<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenggunaJasa;
use App\Models\KriteriaPenggunaJasaDetail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class KriteriaPenggunaJasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData/KriteriaPenggunaJasa', ["data" => KriteriaPenggunaJasa::all()]);
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

        $kriteriaPenggunaJasa = new KriteriaPenggunaJasa();
        $kriteriaPenggunaJasa->kategori = $data["kategori"];
        $kriteriaPenggunaJasa->bobot = $data["bobot"];
        $kriteriaPenggunaJasa->item = $data["item"];
        $kriteriaPenggunaJasa->kriteria_1 = $data["kriteria_1"];
        $kriteriaPenggunaJasa->kriteria_2 = $data["kriteria_2"];
        $kriteriaPenggunaJasa->kriteria_3 = $data["kriteria_3"];
        $kriteriaPenggunaJasa->kriteria_4 = $data["kriteria_4"];
        $kriteriaPenggunaJasa->nota_rekomendasi = $data["nota_rekomendasi"];
        $kriteriaPenggunaJasa->start_tahun = $data["tahun_start"];
        $kriteriaPenggunaJasa->start_bulan = $data["bulan_start"];
        $kriteriaPenggunaJasa->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $kriteriaPenggunaJasa->finish_tahun = $data["tahun_finish"];
            $kriteriaPenggunaJasa->finish_bulan = $data["bulan_finish"];
        }

        if ($kriteriaPenggunaJasa->save()) {
            Alert::success("Success", "Kriteria Pengguna Jasa Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Kriteria Pengguna Jasa Gagal Ditambahkan");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KriteriaPenggunaJasa  $kriteriaPenggunaJasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $kriteriaPenggunaJasa = KriteriaPenggunaJasa::find($id);

        // dd($data, $kriteriaPenggunaJasa);

        if (empty($kriteriaPenggunaJasa)) {
            Alert::success("Error", "Kriteria Pengguna Jasa Tidak Ditemukan");
            return redirect()->back();
        }

        // dd($data);

        $kriteriaPenggunaJasa->kategori = $data["kategori"];
        $kriteriaPenggunaJasa->bobot = $data["bobot"];
        $kriteriaPenggunaJasa->item = $data["item"];
        $kriteriaPenggunaJasa->kriteria_1 = $data["kriteria_1"];
        $kriteriaPenggunaJasa->kriteria_2 = $data["kriteria_2"];
        $kriteriaPenggunaJasa->kriteria_3 = $data["kriteria_3"];
        $kriteriaPenggunaJasa->kriteria_4 = $data["kriteria_4"];
        $kriteriaPenggunaJasa->nota_rekomendasi = $data["nota_rekomendasi"];
        $kriteriaPenggunaJasa->start_tahun = $data["tahun_start"];
        $kriteriaPenggunaJasa->start_bulan = $data["bulan_start"];
        $kriteriaPenggunaJasa->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["tahun_finish"])) {
            $kriteriaPenggunaJasa->finish_tahun = $data["tahun_finish"];
            $kriteriaPenggunaJasa->finish_bulan = $data["bulan_finish"];
        }
        if ($kriteriaPenggunaJasa->save()) {
            Alert::success("Success", "Kriteria Pengguna Jasa Berhasil Diperbaharui");
            return redirect()->back();
        }
        Alert::success("Error", "Kriteria Pengguna Jasa Gagal Diperbaharui");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriaPenggunaJasa  $kriteriaPenggunaJasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(KriteriaPenggunaJasa $kriteriaPenggunaJasa, string $id)
    {
        $isKriteriaPenggunaJasa = $kriteriaPenggunaJasa->find($id);
        if ($isKriteriaPenggunaJasa) {
            $isKriteriaPenggunaJasa->delete();
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
        // dd($data);

        // if (!isset($data['dokumen_penilaian']) || count($data['dokumen_penilaian']) != 6) {
        //     Alert::error("Error", "Harap masukkan semua dokumen!");
        //     return redirect()->back()->with("modal", $data["modal"]);
        // }

        $masterKriteriaPenggunaJasa = KriteriaPenggunaJasa::where('nota_rekomendasi', 'Nota Rekomendasi 1')->get()->sortBy('position')->values();

        $collectKriteriaDetail = [];
        // $files = collect($request->file("dokumen_penilaian"))->values();
        $index = collect($data["index"]);

        // if (empty($data["is_legalitas"]) || empty($data["is_kriteria_1"]) || empty($data["is_kriteria_2"]) || empty($data["is_kriteria_3"]) || empty($data["is_kriteria_4"]) || empty($data["is_kriteria_5"])) {
        //     Alert::error('Form Penilaian Pengguna Jasa Tidak lengkap', "Mohon periksa kembali");
        //     return redirect()->back();
        // }

        $kriteria_detail = new KriteriaPenggunaJasaDetail();
        foreach ($index as $key => $item) {
            if (isset($data["dokumen_penilaian_$item"])) {
                $files = collect($data["dokumen_penilaian_$item"])->values();
                $array_files = collect();
                $kriteria_detail->kode_proyek = $data['kode_proyek'];
                if ($key == 0) {
                    $kriteria_detail->item = null;
                    $kriteria_detail->kriteria = $data['is_legalitas'];
                } else {
                    if ($key <= 5) {
                        if (isset($data['is_kriteria_' . $key])) {
                            $kriteria_detail->kriteria = $data['is_kriteria_' . $key];
                            $kriteria_detail->item = $masterKriteriaPenggunaJasa[$key - 1]->item;
                        } else {
                            $kriteria_detail->kriteria = null;
                            $kriteria_detail->item = null;
                        }
                    }
                }
                $kriteria_detail->nilai = (int)$data['nilai'][$key];
                $kriteria_detail->keterangan = $data['keterangan'][$key];
                $kriteria_detail->index = $key;
                // dd($files);
                foreach ($files as $file) {
                    $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                    $array_files->push($id_document);
                    // $kriteria_detail->id_document = $id_document;

                    $file->move(public_path('file-kriteria-pengguna-jasa'), $id_document);
                }
                $kriteria_detail->id_document = $array_files->toJson();
            } else {
                $kriteria_detail->kode_proyek = $data['kode_proyek'];
                if ($key == 0) {
                    $kriteria_detail->item = null;
                    $kriteria_detail->kriteria = $data['is_legalitas'];
                } else {
                    if ($key <= 5) {
                        if (isset($data['is_kriteria_' . $key])) {
                            $kriteria_detail->kriteria = $data['is_kriteria_' . $key];
                            $kriteria_detail->item = $masterKriteriaPenggunaJasa[$key - 1]->item;
                        } else {
                            $kriteria_detail->kriteria = null;
                            $kriteria_detail->item = null;
                        }
                    }
                }
                $kriteria_detail->nilai = (int)$data['nilai'][$key] ?? 0;
                $kriteria_detail->keterangan = $data['keterangan'][$key];
                $kriteria_detail->index = $key;
                $kriteria_detail->id_document = null;
            }
            $collectKriteriaDetail[] = $kriteria_detail->attributesToArray();
        }
        // dd($collectKriteriaDetail);
        if (KriteriaPenggunaJasaDetail::insert($collectKriteriaDetail)) {
            Alert::success("Success", "Form Kriteria Pengguna Jasa berhasil dibuat!");
            return redirect('/rekomendasi?open=kt_modal_view_proyek_rekomendasi_' . $data['kode_proyek']);
        }

        Alert::error("Error", "Form Kriteria Pengguna Jasa gagal dibuat!");
        return redirect()->back();
    }

    public function detailEdit(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // if (isset($data['dokumen_penilaian']) && count($data['dokumen_penilaian']) != KriteriaPenggunaJasaDetail::where('kode_proyek', $data['kode_proyek'])->count()) {
        //     Alert::error("Error", "Harap masukkan semua dokumen!");
        //     return redirect()->back()->with("modal", $data["modal"]);
        // }

        $masterKriteriaPenggunaJasa = KriteriaPenggunaJasa::all();

        // $collectKriteriaDetail = [];
        // $files = collect($request->file("dokumen_penilaian"));
        try {
            foreach ($data['id_detail'] as $key => $item) {
                $kriteria_detail = KriteriaPenggunaJasaDetail::find($data['id_detail'][$key]);
                // $array_files = collect();
                $current_file = collect(json_decode($kriteria_detail->id_document, true));

                $kriteria_detail->kode_proyek = $data['kode_proyek'];
                if ($key == 0) {
                    $kriteria_detail->item = null;
                    $kriteria_detail->kriteria = $data['is_legalitas'];
                } else {
                    if ($key != 5) {
                        if (isset($data['is_kriteria_' . $key])) {
                            $kriteria_detail->kriteria = $data['is_kriteria_' . $key];
                            $kriteria_detail->item = $masterKriteriaPenggunaJasa[$key - 1]->item;
                        } else {
                            $kriteria_detail->kriteria = null;
                            $kriteria_detail->item = null;
                        }
                    }
                }
                $kriteria_detail->nilai = (int)$data['nilai'][$key] ?? 0;
                $kriteria_detail->keterangan = $data['keterangan'][$key];

                $files = $data["dokumen_penilaian_$key"] ?? null;
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                        $current_file->push($id_document);
                        // $kriteria_detail->id_document = $id_document;

                        $file->move(public_path('file-kriteria-pengguna-jasa'), $id_document);
                    }
                }
                // dd($current_file);
                $kriteria_detail->id_document = $current_file->toJson();
                $collectKriteriaDetail[] = $kriteria_detail->attributesToArray();
                $kriteria_detail->index = $data['index'][$key];

                $kriteria_detail->save();
                // if (isset($data['dokumen_penilaian'])) {
                //     if (!empty($files[$key])) {
                //         $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $files[$key]->getClientOriginalName());
                //         // File::delete(public_path('/file-kriteria-pengguna-jasa//' . $kriteria_detail->id_document));
                //         $kriteria_detail->id_document = $id_document;
                //         $files[$key]->move(public_path('file-kriteria-pengguna-jasa'), $id_document);
                //     }
                // }
                // $collectKriteriaDetail[] = $kriteria_detail->attributesToArray();
            }
            Alert::success("Success", "Form Kriteria Pengguna Jasa berhasil diperbaharui!");
            return redirect()->back();
        } catch (\Throwable $th) {
            // dd($th);
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
        // dd($collectKriteriaDetail);
        // if (KriteriaPenggunaJasaDetail::insert($collectKriteriaDetail)) {
        //     Alert::success("Success", "Form Kriteria Pengguna Jasa berhasil dibuat!");
        //     return redirect()->back();
        // }

    }

    public function deleteFile(Request $request)
    {
        try {
            $data = $request->all();

            $kriteriaPenggunaJasa = KriteriaPenggunaJasaDetail::find($data["id"]);
            $list_documents = collect(json_decode($kriteriaPenggunaJasa["id_document"]));
            $updated_docs = collect();

            foreach ($list_documents as $doc) {
                if ($doc == $data["file-name"]) {
                    File::delete(public_path('/file-kriteria-pengguna-jasa//' . $doc));
                } else {
                    $updated_docs->push($doc);
                }
            }

            $kriteriaPenggunaJasa->id_document = $updated_docs;
            if ($kriteriaPenggunaJasa->save()) {
                Alert::success("Success", "Form Kriteria Pengguna Jasa berhasil diperbaharui!");
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::success("Error", "Form Kriteria Pengguna Jasa gagal diperbaharui! Mohon untuk hubungi admin.");
            Log::error($th->getMessage());
            return redirect()->back();
        }
        
    }
}
