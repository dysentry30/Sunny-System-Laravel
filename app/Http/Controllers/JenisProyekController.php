<?php

namespace App\Http\Controllers;

use App\Models\JenisProyek;
use App\Http\Requests\StoreJenisProyekRequest;
use App\Http\Requests\UpdateJenisProyekRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class JenisProyekController extends Controller
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
            $jenis = JenisProyek::where($column, 'like', '%' . $filter . '%')->get();
        } else {
            $jenis = JenisProyek::get();
        }

        return view('/MasterData/JenisProyek', compact(['jenis', 'column', 'filter']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJenisProyekRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, JenisProyek $jenis)
    {
        $data = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "jenis-proyek" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Jenis Proyek Gagal Dibuat !");
        }

        $validation->validate();
        $jenis->jenis_proyek = $data["jenis-proyek"];
        $jenis->kode_jenis = $data["jenis-kode"];

        Alert::success('Success', $data["jenis-proyek"] . ", Berhasil Ditambahkan");

        if ($jenis->save()) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisProyek  $jenisProyek
     * @return \Illuminate\Http\Response
     */
    public function show(JenisProyek $jenisProyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisProyek  $jenisProyek
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisProyek $jenisProyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisProyekRequest  $request
     * @param  \App\Models\JenisProyek  $jenisProyek
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisProyekRequest $request, JenisProyek $jenisProyek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisProyek  $jenisProyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisProyek $jenisProyek)
    {
        //
    }
}
