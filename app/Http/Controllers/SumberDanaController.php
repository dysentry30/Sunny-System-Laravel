<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


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
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nama-sumber" => "required",
            "kategori" => "required",
            "unique-code" => "required",
        ];
        $validation = Validator::make($dataSumber, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nama-sumber");
            Alert::error('Error', "Sumber Dana Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();  

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

        Alert::success('Success', $dataSumber["nama-sumber"].", Berhasil Ditambahkan");

        if ($newSumber->save()) {
            return redirect()->back();
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
    public function delete($id)
    {
        $id = SumberDana::find($id);
        $sumber = $id->nama_sumber;
        
        $id->delete();
        Alert::success('Delete', $sumber.", Berhasil Dihapus");

        return redirect()->back();
    }
}
