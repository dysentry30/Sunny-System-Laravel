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
            "sbu" => "required",
            "kode-sbu" => "required",
            "klasifikasi" => "required",
            "sub-klasifikasi" => "required",
        ];
        $validation = Validator::make($dataSbu, $rules, $messages);
        if ($validation->fails()) {
            $request->old("sbu");
            $request->old("kode-sbu");
            $request->old("klasifikasi");
            $request->old("sub-klasifikasi");
            Alert::error('Error', "SBU Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();  
        
        $newSbu->sbu = $dataSbu["sbu"];
        $newSbu->kode_sbu = $dataSbu["kode-sbu"];
        $newSbu->klasifikasi = $dataSbu["klasifikasi"];
        $newSbu->sub_klasifikasi = $dataSbu["sub-klasifikasi"];
        $newSbu->referensi1 = $dataSbu["referensi1"];
        $newSbu->referensi2 = $dataSbu["referensi2"];
        $newSbu->referensi3 = $dataSbu["referensi3"];

        Alert::success('Success', $dataSbu["sbu"].", Berhasil Ditambahkan");

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
    public function update(Request $request, Sbu $sbu)
    {
        //
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
