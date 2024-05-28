<?php

namespace App\Http\Controllers;

use App\Models\MasalahHukum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasalahHukumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('18_MasalahHukum', ['data' => MasalahHukum::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $data = $request->all();
        $rules = [
            'nama_pelanggan' => 'required',
            'kode-proyek-hukum' => 'required',
            'bentuk_masalah_hukum' => 'required|string',
            'status_hukum' => 'required'
        ];

        $validator = validateInput($data, $rules);

        if (!empty($validator)) {
            Alert::html("Error", "Pastikan field <b>$validator</b> terisi!", "error");
            return redirect()->back();
        }

        $newMasalahHukum = new MasalahHukum();
        $newMasalahHukum->id_customer = $data["nama_pelanggan"];
        $newMasalahHukum->kode_proyek = $data["kode-proyek-hukum"];
        $newMasalahHukum->bentuk_masalah = $data["bentuk_masalah_hukum"];
        $newMasalahHukum->status = $data["status_hukum"];

        if ($newMasalahHukum->save()) {
            Alert::success('Success', 'Masalah Hukum berhasil ditambahkan');
            return redirect()->back();
        }
        Alert::error('Error', 'Masalah Hukum gagal ditambahkan');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $rules = [
            'nama_pelanggan' => 'required',
            'kode-proyek-hukum' => 'required',
            'bentuk_masalah_hukum' => 'required|string',
            'status_hukum' => 'required'
        ];

        $validator = validateInput($data, $rules);

        if (!empty($validator)) {
            Alert::html("Error", "Pastikan field <b>$validator</b> terisi!", "error");
            return redirect()->back();
        }

        $editMasalahHukum = MasalahHukum::find($id);
        $editMasalahHukum->id_customer = $data["nama_pelanggan"];
        $editMasalahHukum->kode_proyek = $data["kode-proyek-hukum"];
        $editMasalahHukum->bentuk_masalah = $data["bentuk_masalah_hukum"];
        $editMasalahHukum->status = $data["status_hukum"];

        if ($editMasalahHukum->save()) {
            Alert::success('Success', 'Masalah Hukum berhasil diedit');
            return redirect()->back();
        }
        Alert::error('Error', 'Masalah Hukum gagal diedit');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $isMasalahHukum = MasalahHukum::find($id);
        if ($isMasalahHukum) {
            $isMasalahHukum->delete();
            return response()->json([
                "Success" => true,
                "Message" => "Success"
            ]);
        }
        return response()->json([
            "Success" => false,
            "Message" => "Failed"
        ]);
    }
}
