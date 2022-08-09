<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaPasar;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class KriteriaPasarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $column = $request->get("column");
        $filter = $request->query("filter");

        if (!empty($column)) {
            $kriteriaPasar = KriteriaPasar::sortable()->where($column, 'like', '%'.$filter.'%')->orderBy('kategori')->get();
        }else{
        $kriteriaPasar = KriteriaPasar::sortable()->orderBy('kategori')->get();
        }

        return view('/MasterData/KriteriaPasar', compact(['kriteriaPasar', 'column', 'filter']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, KriteriaPasar $newKriteria)
    {
        $dataKriteria = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "kategori" => "required",
            "kriteria" => "required",
            "bobot" => "required",
        ];
        $validation = Validator::make($dataKriteria, $rules, $messages);
        if ($validation->fails()) {
            $request->old("kategori");
            Alert::error('Error', "Kriteria Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();

        $newKriteria->kategori = $dataKriteria["kategori"];
        $newKriteria->kriteria = $dataKriteria["kriteria"];
        $bobot = $dataKriteria["bobot"] / 100;
        // dd($bobot, $dataKriteria["bobot"]);
        $newKriteria->bobot = $bobot;

        Alert::success('Success', $dataKriteria["kategori"] . $dataKriteria["kriteria"] . ", Berhasil Ditambahkan");

        if ($newKriteria->save()) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KriteriaPasar  $kriteriaPasar
     * @return \Illuminate\Http\Response
     */
    public function show(KriteriaPasar $kriteriaPasar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KriteriaPasar  $kriteriaPasar
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "kategori" => "required",
            "kriteria" => "required",
            "bobot" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("kategori");
            Alert::error('Error', "Kriteria Gagal Disimpan, Periksa Kembali !");
        }
        $validation->validate();
        
        $editKriteria = KriteriaPasar::find($id);
        $editKriteria->kategori = $data["kategori"];
        $editKriteria->kriteria = $data["kriteria"];
        $bobot = $data["bobot"] / 100;
        $editKriteria->bobot = $bobot;
        // dd($data);
        
        Alert::success('Success', $data["kategori"] . " - " . $data["kriteria"] . ", Berhasil Diubah");
        
        if ($editKriteria->save()) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriaPasar  $kriteriaPasar
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = KriteriaPasar::find($id);
        $kategori = $id->Kategori;

        $id->delete();
        Alert::success('Delete', "Kategori" . $kategori . ", Berhasil Dihapus");

        return redirect()->back();
    }
}
