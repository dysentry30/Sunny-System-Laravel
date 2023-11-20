<?php

namespace App\Http\Controllers;

use App\Models\KriteriaSelectionNonGreenlane;
use Illuminate\Http\Request;
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
}
