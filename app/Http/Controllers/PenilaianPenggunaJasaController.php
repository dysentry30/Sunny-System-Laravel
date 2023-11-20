<?php

namespace App\Http\Controllers;

use App\Models\PenilaianPenggunaJasa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenilaianPenggunaJasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData/PenilaianPenggunaJasa', ["data" => PenilaianPenggunaJasa::all()]);
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

        $penilaianPenggunaJasa = new PenilaianPenggunaJasa();
        $penilaianPenggunaJasa->nama = $data["nama"];
        $penilaianPenggunaJasa->nota_rekomendasi = $data["nota_rekomendasi"];
        $penilaianPenggunaJasa->dari_nilai = $data["dari_nilai"];
        $penilaianPenggunaJasa->sampai_nilai = $data["sampai_nilai"];
        $penilaianPenggunaJasa->start_tahun = $data["tahun_start"];
        $penilaianPenggunaJasa->start_bulan = $data["bulan_start"];
        $penilaianPenggunaJasa->is_active = isset($data["isActive"]) ? true : false;
        if ($penilaianPenggunaJasa->is_active == true) {
            $penilaianPenggunaJasa->finish_tahun = null;
            $penilaianPenggunaJasa->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $penilaianPenggunaJasa->finish_tahun = $data["tahun_finish"];
                $penilaianPenggunaJasa->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($penilaianPenggunaJasa->save()) {
            Alert::success("Success", "Kriteria Pengguna Jasa Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Kriteria Pengguna Jasa Gagal Ditambahkan");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenilaianPenggunaJasa  $penilaianPenggunaJasa
     * @return \Illuminate\Http\Response
     */
    public function edit(PenilaianPenggunaJasa $penilaianPenggunaJasa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenilaianPenggunaJasa  $penilaianPenggunaJasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $penilaianPenggunaJasa = PenilaianPenggunaJasa::find($id);

        // dd($data, $penilaianPenggunaJasa);

        if (empty($penilaianPenggunaJasa)) {
            Alert::success("Error", "Kriteria Pengguna Jasa Tidak Ditemukan");
            return redirect()->back();
        }

        $penilaianPenggunaJasa->nota_rekomendasi = $data["nota_rekomendasi"];
        $penilaianPenggunaJasa->nama = $data["nama"];
        $penilaianPenggunaJasa->dari_nilai = $data["dari_nilai"];
        $penilaianPenggunaJasa->sampai_nilai = $data["sampai_nilai"];
        $penilaianPenggunaJasa->start_tahun = $data["tahun_start"];
        $penilaianPenggunaJasa->start_bulan = $data["bulan_start"];
        $penilaianPenggunaJasa->is_active = isset($data["isActive"]) ? true : false;
        if ($penilaianPenggunaJasa->is_active == true) {
            $penilaianPenggunaJasa->finish_tahun = null;
            $penilaianPenggunaJasa->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $penilaianPenggunaJasa->finish_tahun = $data["tahun_finish"];
                $penilaianPenggunaJasa->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($penilaianPenggunaJasa->save()) {
            Alert::success("Success", "Kriteria Pengguna Jasa Berhasil Diubah");
            return redirect()->back();
        }
        Alert::success("Error", "Kriteria Pengguna Jasa Gagal Diubah");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenilaianPenggunaJasa  $penilaianPenggunaJasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenilaianPenggunaJasa $penilaianPenggunaJasa, string $id)
    {
        $isPenilaianPenggunaJasa = $penilaianPenggunaJasa->find($id);
        if ($isPenilaianPenggunaJasa) {
            $isPenilaianPenggunaJasa->delete();
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
}
