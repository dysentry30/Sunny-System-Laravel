<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;


class SumberDanaController extends Controller
{
            /**
             * Display a listing of the resource.
             *
             * @return \Illuminate\Http\Response
             */
    public function index()
    {

        return view('/MasterData/SumberDana', ['sumberdana' => SumberDana::all()]);
    }

            /**
             * Store a newly created resource in storage.
             *
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
    public function store(Request $request, SumberDana $newSumber)
    {
        $dataSumber = $request->all(); 
        
        $newSumber->nama_sumber = $dataSumber["nama-sumber"];
        $newSumber->kategori = $dataSumber["kategori"];
        $newSumber->unique_code = $dataSumber["unique-code"];
        $newSumber->jenis_perusahaan = $dataSumber["jenis-perusahaan"];
        $newSumber->tipe_lain = $dataSumber["tipe-lain"];
        $newSumber->kode_sumber = $dataSumber["kode-sumber"];
        $newSumber->sumber_dana_id = $dataSumber["sumber-dana-id"];
        $newSumber->kode_proyek_id = $dataSumber["kode-proyek-id"];
        $newSumber->kode_proyek_id = $dataSumber["kode-proyek-id"];
        $newSumber->tipe_perusahaan = $dataSumber["tipe-perusahaan"];
        $newSumber->cot_id = $dataSumber["cot-id"];

        if ($newSumber->save()) {
            return redirect('/sumber-dana')->with("success", true);
        }
    }

            /**
             * Display the specified resource.
             *
             * @param  \App\Models\SumberDana  $sumberDana
             * @return \Illuminate\Http\Response
             */
    public function show(SumberDana $sumberDana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SumberDana  $sumberDana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SumberDana $sumberDana)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SumberDana  $sumberDana
     * @return \Illuminate\Http\Response
     */
    public function destroy(SumberDana $sumberDana)
    {
        //
    }
}
