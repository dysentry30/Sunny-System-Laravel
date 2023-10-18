<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenggunaJasa;
use App\Models\KriteriaPenggunaJasaDetail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
        if (isset($data["finish_tahun"]) && isset($data["finish_bulan"])) {
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

        if (!isset($data['dokumen_penilaian']) || count($data['dokumen_penilaian']) != 6) {
            Alert::error("Error", "Harap masukkan semua dokumen!");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $masterKriteriaPenggunaJasa = KriteriaPenggunaJasa::all();

        $collectKriteriaDetail = [];
        $files = collect($request->file("dokumen_penilaian"))->values();
        foreach ($files as $key => $item) {
            $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $item->getClientOriginalName());
            $kriteria_detail = new KriteriaPenggunaJasaDetail();
            $kriteria_detail->kode_proyek = $data['kode_proyek'];
            if ($key < $masterKriteriaPenggunaJasa->count()) {
                $kriteria_detail->kriteria = $data['is_kriteria_' . $key];
                $kriteria_detail->item = $masterKriteriaPenggunaJasa[$key]->item;
            } else {
                $kriteria_detail->item = null;
                $kriteria_detail->kriteria = $data['is_legalitas'];
            }
            $kriteria_detail->nilai = (int)$data['nilai'][$key];
            $kriteria_detail->keterangan = $data['keterangan'][$key];
            $kriteria_detail->id_document = $id_document;

            $item->move(public_path('file-kriteria-pengguna-jasa'), $id_document);
            $collectKriteriaDetail[] = $kriteria_detail->attributesToArray();
        }
        // dd($collectKriteriaDetail);
        if (KriteriaPenggunaJasaDetail::insert($collectKriteriaDetail)) {
            Alert::success("Success", "Form Kriteria Pengguna Jasa berhasil dibuat!");
            return redirect()->back();
        }

        Alert::error("Error", "Form Kriteria Pengguna Jasa gagal dibuat!");
        return redirect()->back();
    }
}