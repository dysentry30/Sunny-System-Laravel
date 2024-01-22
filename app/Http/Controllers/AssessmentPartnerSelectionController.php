<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenggunaJasa;
use App\Models\LegalitasPerusahaan;
use App\Models\PartnerSelectionDetail;
use App\Models\PenilaianPartnerSelection;
use App\Models\PorsiJO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AssessmentPartnerSelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = PorsiJO::where('id_company_jo', '!=', null)
            ->where('is_greenlane', '!=', null)
            ->where('is_greenlane', '!=', false)
            ->get();
        $partnerDetail = PartnerSelectionDetail::all();
        $kriteriaPenilaian = PenilaianPartnerSelection::where('is_active', true)->get();

        if ($kriteriaPenilaian->isEmpty()) {
            Alert::error('Error', 'Mohon isi Master Data Penilaian Risiko Partner terlebih dahulu!');

            if (Gate::allows('super-admin')) {
                return redirect('/penilaian-partner-selection');
            } else {
                return redirect('/proyek');
            }
        }

        return view('16_Partner_Selection_Assessment', [
            'customers' => $customers,
            'partnerDetail' => $partnerDetail,
            'kriteriaPenilaian' => $kriteriaPenilaian
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $collectJawaban = [];

        $index = collect($data['index']);

        $legalitasMaster = LegalitasPerusahaan::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaMaster = KriteriaPenggunaJasa::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $partnerDetail = new PartnerSelectionDetail();

        $current_timestamp = Carbon::now();

        foreach ($index as $key => $urutan) {
            if ($key <= ($legalitasMaster->count() - 1)) {
                if (isset($data["dokumen_legalitas_$key"])) {
                    $files = collect($data["dokumen_legalitas_$key"])->values();
                    $array_files = collect();

                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $legalitasMaster[$key]->kategori;
                    $partnerDetail->kriteria = $data["is_legalitas_" . $urutan];
                    $partnerDetail->nilai = null;
                    $partnerDetail->keterangan = $data["is_legalitas_keterangan"][$key];

                    foreach ($files as $file) {
                        $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                        $array_files->push($id_document);
                        $file->move(public_path('file-selection-partner'), $id_document);
                    }

                    $partnerDetail->id_document = $array_files->toJson();
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                } else {
                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $legalitasMaster[$key]->kategori;
                    $partnerDetail->kriteria = $data["is_legalitas_" . $urutan];
                    $partnerDetail->nilai = null;
                    $partnerDetail->keterangan = $data["is_legalitas_keterangan"][$key];
                    $partnerDetail->id_document = null;
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                }
            } else {
                if (isset($data["dokumen_penilaian_$key"])) {
                    $files = collect($data["dokumen_penilaian_$key"])->values();
                    $array_files = collect();

                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $kriteriaMaster[(int)$urutan - 1]->kategori;
                    $partnerDetail->kriteria = $data["is_kriteria_" . $urutan];
                    $partnerDetail->nilai = (float)$data['nilai'][(int)$urutan - 1];
                    $partnerDetail->keterangan = $data["keterangan"][(int)$urutan - 1];

                    foreach ($files as $file) {
                        $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                        $array_files->push($id_document);
                        $file->move(public_path('file-selection-partner'), $id_document);
                    }

                    $partnerDetail->id_document = $array_files->toJson();
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                } else {
                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $kriteriaMaster[(int)$urutan - 1]->item;
                    $partnerDetail->kriteria = $data["is_kriteria_" . $urutan];
                    $partnerDetail->nilai = (float)$data['nilai'][(int)$urutan - 1];
                    $partnerDetail->keterangan = $data["keterangan"][(int)$urutan - 1];
                    $partnerDetail->id_document = null;
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                }
            }

            $collectJawaban[] = $partnerDetail->attributesToArray();
        }

        if (PartnerSelectionDetail::insert($collectJawaban)) {
            Alert::success("Success", "Partner Selection berhasil dibuat!");
            return redirect()->back();
        }

        Alert::error("Error", "Partner Selection gagal dibuat!");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $legalitasMaster = LegalitasPerusahaan::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaMaster = KriteriaPenggunaJasa::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();

        try {
            foreach ($data['id_detail'] as $key => $value) {
                $kriteriaDetail = PartnerSelectionDetail::find($data['id_detail'][$key]);
                $current_file = collect(json_decode($kriteriaDetail->id_document, true));
                $urutan = $data['index'][$key];

                if ($key <= ($legalitasMaster->count() - 1)) {
                    $kriteriaDetail->item = $legalitasMaster[$key]->kategori;
                    $kriteriaDetail->kriteria = $data["is_legalitas_" . $urutan];
                    $kriteriaDetail->nilai = null;
                    $kriteriaDetail->keterangan = $data["is_legalitas_keterangan"][$key];

                    $files = $data["dokumen_legalitas_$key"] ?? null;
                    if (!empty($files)) {
                        foreach ($files as $file) {
                            $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                            $current_file->push($id_document);
                            $file->move(public_path('file-selection-partner'), $id_document);
                        }
                    }
                    $kriteriaDetail->id_document = empty($current_file) || $current_file->isEmpty() ? null : $current_file->toJson();
                } else {
                    $kriteriaDetail->item = $kriteriaMaster[(int)$urutan - 1]->kategori;
                    $kriteriaDetail->kriteria = $data["is_kriteria_" . $urutan];
                    $kriteriaDetail->nilai = (float)$data['nilai'][(int)$urutan - 1];
                    $kriteriaDetail->keterangan = $data["keterangan"][(int)$urutan - 1];

                    $files = $data["dokumen_penilaian_$urutan"] ?? null;
                    if (!empty($files)) {
                        foreach ($files as $file) {
                            $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                            $current_file->push($id_document);
                            $file->move(public_path('file-selection-partner'), $id_document);
                        }
                    }
                    $kriteriaDetail->id_document = empty($current_file) || $current_file->isEmpty() ? null : $current_file->toJson();
                }

                $kriteriaDetail->save();
            }
            // dd("Tes");
            Alert::success("Success", "Form Kriteria Partner Selection berhasil diperbaharui!");
            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFile(Request $request)
    {
        try {
            $data = $request->all();

            $partnerSelected = PartnerSelectionDetail::find($data["id"]);
            $list_documents = collect(json_decode($partnerSelected["id_document"]));
            $updated_docs = collect();

            foreach ($list_documents as $doc) {
                if ($doc == $data["file-name"]) {
                    File::delete(public_path('/file-selection-partner//' . $doc));
                } else {
                    $updated_docs->push($doc);
                }
            }

            $partnerSelected->id_document = empty($updated_docs) || $updated_docs->isEmpty() ? null : $updated_docs;

            if ($partnerSelected->save()) {
                Alert::success("Success", "Form Kriteria Partner Selection berhasil berhasil diperbaharui!");
                return redirect()->back();
            }
        } catch (\Exception $th) {
            Alert::success("Error", "Form Kriteria Partner Selection gagal diperbaharui! Mohon untuk hubungi admin.");
            Log::error($th->getMessage());
            return redirect()->back();
        }
    }
}
