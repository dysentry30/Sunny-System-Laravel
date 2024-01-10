<?php

namespace App\Http\Controllers;

use App\Models\KriteriaProjectSelectionDetail;
use App\Models\KriteriaSelectionNonGreenlane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class KriteriaSelectionNonGreenlaneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData/KriteriaSelectionNonGreenlane', ["data" => KriteriaSelectionNonGreenlane::all()]);
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
        $kriteria = new KriteriaSelectionNonGreenlane();
        $kriteria->nota_rekomendasi = $data["nota_rekomendasi"];
        $kriteria->parameter = $data["parameter"];
        $kriteria->bobot = $data["bobot"];
        $kriteria->start_tahun = $data["tahun_start"];
        $kriteria->start_bulan = $data["bulan_start"];
        $kriteria->is_active = isset($data["isActive"]) ? true : false;
        if ($kriteria->is_active == true) {
            $kriteria->finish_tahun = null;
            $kriteria->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $kriteria->finish_tahun = $data["tahun_finish"];
                $kriteria->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($kriteria->save()) {
            Alert::success("Success", "Kriteria Selection Non Greenlane Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Kriteria Selection Non Greenlane Gagal Ditambahkan");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KriteriaSelectionNonGreenlane  $kriteriaSelectionNonGreenlane
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $kriteria = KriteriaSelectionNonGreenlane::find($id);

        // dd($data, $kriteria);

        if (empty($kriteria)) {
            Alert::success("Error", "Kriteria Selection Non Greenlane Tidak Ditemukan");
            return redirect()->back();
        }

        $kriteria->nota_rekomendasi = $data["nota_rekomendasi"];
        $kriteria->parameter = $data["parameter"];
        $kriteria->bobot = $data["bobot"];
        $kriteria->start_tahun = $data["tahun_start"];
        $kriteria->start_bulan = $data["bulan_start"];
        $kriteria->is_active = isset($data["isActive"]) ? true : false;
        if ($kriteria->is_active == true) {
            $kriteria->finish_tahun = null;
            $kriteria->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $kriteria->finish_tahun = $data["tahun_finish"];
                $kriteria->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($kriteria->save()) {
            Alert::success("Success", "Kriteria Selection Non Greenlane Berhasil Diubah");
            return redirect()->back();
        }
        Alert::success("Error", "Kriteria Selection Non Greenlane Gagal Diubah");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriaSelectionNonGreenlane  $kriteriaSelectionNonGreenlane
     * @return \Illuminate\Http\Response
     */
    public function destroy(KriteriaSelectionNonGreenlane $kriteriaSelectionNonGreenlane, string $id)
    {
        $isKriteria = $kriteriaSelectionNonGreenlane->find($id);
        if ($isKriteria) {
            $isKriteria->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    }


    public function detailSave(Request $request)
    {
        $data = $request->all();

        $index = collect($data['index']);
        $collectJawaban = [];

        $kriteriaMaster = KriteriaSelectionNonGreenlane::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaSelectioDetail = new KriteriaProjectSelectionDetail();

        foreach ($index as $key => $urutan) {
            if (isset($data["dokumen_kriteria_$key"])) {
                $files = collect($data["dokumen_kriteria_$key"])->values();
                $array_files = collect();

                $kriteriaSelectioDetail->parameter = $kriteriaMaster[(int)$urutan - 1]->parameter;
                $kriteriaSelectioDetail->is_true = $data["is_kriteria_" . $urutan] == 1 ? true : false;
                $kriteriaSelectioDetail->nilai = $data['nilai'][(int)$urutan - 1];
                $kriteriaSelectioDetail->keterangan = $data["keterangan"][(int)$urutan - 1];

                foreach ($files as $file) {
                    $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                    $array_files->push($id_document);
                    $file->move(public_path('file-project-selection'), $id_document);
                }

                $kriteriaSelectioDetail->id_document = $array_files->toJson();
                $kriteriaSelectioDetail->urutan = $urutan;
                $kriteriaSelectioDetail->kode_proyek = $data["kode_proyek"];
                $kriteriaSelectioDetail->index = $key;
            } else {
                $kriteriaSelectioDetail->parameter = $kriteriaMaster[(int)$urutan - 1]->parameter;
                $kriteriaSelectioDetail->is_true = $data["is_kriteria_" . $urutan] == 1 ? true : false;
                $kriteriaSelectioDetail->nilai = $data['nilai'][(int)$urutan - 1];
                $kriteriaSelectioDetail->keterangan = $data["keterangan"][(int)$urutan - 1];
                $kriteriaSelectioDetail->id_document = null;
                $kriteriaSelectioDetail->urutan = $urutan;
                $kriteriaSelectioDetail->kode_proyek = $data["kode_proyek"];
                $kriteriaSelectioDetail->index = $key;
            }

            $collectJawaban[] = $kriteriaSelectioDetail->attributesToArray();
        }

        if (KriteriaProjectSelectionDetail::insert($collectJawaban)) {
            Alert::success("Success", "Assessment Project Selection berhasil dibuat!");
            return redirect()->back();
        }

        Alert::error("Error", "Assessment Project Selection gagal dibuat!");
        return redirect()->back();
    }


    public function detailEdit(Request $request)
    {
        $data = $request->all();
        $collectJawaban = [];

        $kriteriaMaster = KriteriaSelectionNonGreenlane::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaSelectioDetail = new KriteriaProjectSelectionDetail();

        try {
            foreach ($data['id_detail'] as $key => $value) {
                $kriteriaSelectioDetail = KriteriaProjectSelectionDetail::find($data['id_detail'][$key]);
                $current_file = collect(json_decode($kriteriaSelectioDetail->id_document, true));

                $urutan = $data['index'][$key];
                $kriteriaSelectioDetail->parameter = $kriteriaMaster[(int)$urutan - 1]->parameter;
                $kriteriaSelectioDetail->is_true = $data["is_kriteria_" . $urutan] == 1 ? true : false;
                $kriteriaSelectioDetail->nilai = $data['nilai'][(int)$urutan - 1];
                $kriteriaSelectioDetail->keterangan = $data["keterangan"][(int)$urutan - 1];

                $files = $data["dokumen_kriteria_$urutan"] ?? null;
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                        $current_file->push($id_document);
                        $file->move(public_path('file-project-selection'), $id_document);
                    }
                }
                $kriteriaSelectioDetail->id_document = empty($current_file) || $current_file->isEmpty() ? null : $current_file->toJson();

                $kriteriaSelectioDetail->save();
            }

            Alert::success("Success", "Assessment Project Selection berhasil diubah!");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteFile(Request $request)
    {
        try {
            $data = $request->all();

            $kriteriaSelected = KriteriaProjectSelectionDetail::find($data["id"]);
            $list_documents = collect(json_decode($kriteriaSelected["id_document"]));
            $updated_docs = collect();

            foreach ($list_documents as $doc) {
                if ($doc == $data["file-name"]) {
                    File::delete(public_path('/file-project-selection//' . $doc));
                } else {
                    $updated_docs->push($doc);
                }
            }

            $kriteriaSelected->id_document = empty($updated_docs) || $updated_docs->isEmpty() ? null : $updated_docs;

            if ($kriteriaSelected->save()) {
                Alert::success("Success", "Form Assessment Project Selection berhasil berhasil diperbaharui!");
                return redirect()->back();
            }
        } catch (\Exception $th) {
            Alert::success("Error", "Form Assessment Project Selection gagal diperbaharui! Mohon untuk hubungi admin.");
            Log::error($th->getMessage());
            return redirect()->back();
        }
    }
}
