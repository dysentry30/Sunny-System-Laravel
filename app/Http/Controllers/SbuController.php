<?php

namespace App\Http\Controllers;

use App\Models\Sbu;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SbuController extends Controller
{
            /**
             * Display a listing of the resource.
             *
             * @return \Illuminate\Http\Response
             */
    public function index(Request $request)
    {
        $column = $request->get("column");
        $filter = $request->query("filter");

        if (!empty($column)) {
            $sbus = Sbu::sortable()->where($column, 'like', '%'.$filter.'%')->get();
        }else{
        $sbus = Sbu::sortable()->get();
        }    
        return view('/MasterData/Sbu', compact(['sbus', 'column', 'filter']));
    }

            /**
             * Store a newly created resource in storage.
             *
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sbu $newSbu)
    {
        $dataSbu = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "kode-sbu" => "required",
            "lingkup" => "required",
            "klasifikasi" => "required",
            "sub-klasifikasi" => "required",
        ];
        $validation = Validator::make($dataSbu, $rules, $messages);
        if ($validation->fails()) {
            $request->old("kode-sbu");
            $request->old("lingkup");
            $request->old("klasifikasi");
            $request->old("sub-klasifikasi");
            Alert::error('Error', "SBU Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();  
        
        $newSbu->kode_sbu = $dataSbu["kode-sbu"];
        $newSbu->lingkup_kerja = $dataSbu["lingkup"];
        $newSbu->klasifikasi = $dataSbu["klasifikasi"];
        $newSbu->sub_klasifikasi = $dataSbu["sub-klasifikasi"];
        $newSbu->referensi1 = $dataSbu["referensi1"];
        $newSbu->referensi2 = $dataSbu["referensi2"];
        $newSbu->referensi3 = $dataSbu["referensi3"];

        Alert::success('Success', "SBU, Berhasil Ditambahkan");

        if ($newSbu->save()) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sbu  $sbu
     * @return \Illuminate\Http\Response
     */
    public function show(Sbu $sbu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sbu  $sbu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataSbu = $request->all();
        // dd($dataSbu);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "edit-kode-sbu" => "required",
            "edit-lingkup" => "required",
            "edit-klasifikasi" => "required",
            "edit-sub-klasifikasi" => "required",
        ];
        $validation = Validator::make($dataSbu, $rules, $messages);
        if ($validation->fails()) {
            $request->old("edit-kode-sbu");
            $request->old("edit-lingkup");
            $request->old("edit-klasifikasi");
            $request->old("edit-sub-klasifikasi");
            Alert::error('Error', "SBU Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();  
        
        $editSbu = Sbu::find($id);
        $editSbu->kode_sbu = $dataSbu["edit-kode-sbu"];
        $editSbu->lingkup_kerja = $dataSbu["edit-lingkup"];
        $editSbu->klasifikasi = $dataSbu["edit-klasifikasi"];
        $editSbu->sub_klasifikasi = $dataSbu["edit-sub-klasifikasi"];
        $editSbu->referensi1 = $dataSbu["edit-referensi1"];
        $editSbu->referensi2 = $dataSbu["edit-referensi2"];
        $editSbu->referensi3 = $dataSbu["edit-referensi3"];

        Alert::success('Success', "SBU, Berhasil Diubah");

        if ($editSbu->save()) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sbu  $sbu
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = Sbu::find($id);
        $sbu = $id->sbu;
        
        $id->delete();
        Alert::success('Delete', $sbu.", Berhasil Dihapus");

        return redirect()->back();
    }
}
