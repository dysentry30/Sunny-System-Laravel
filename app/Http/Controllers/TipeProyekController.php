<?php

namespace App\Http\Controllers;

use App\Models\TipeProyek;
use App\Http\Requests\StoreTipeProyekRequest;
use App\Http\Requests\UpdateTipeProyekRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class TipeProyekController extends Controller
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
            $tipe = TipeProyek::where($column, 'like', '%' . $filter . '%')->get();
        } else {
            $tipe = TipeProyek::get();
        }

        return view('/MasterData/TipeProyek', compact(['tipe', 'column', 'filter']));
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
     * @param  \App\Http\Requests\StoreTipeProyekRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TipeProyek $tipe)
    {
        $data = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "tipe-proyek" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Tipe Proyek Gagal Dibuat !");
        }

        $validation->validate();
        $tipe->tipe_proyek = $data["tipe-proyek"];
        $tipe->kode_tipe = $data["tipe-kode"];

        Alert::success('Success', $data["tipe-proyek"] . ", Berhasil Ditambahkan");

        if ($tipe->save()) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipeProyek  $tipeProyek
     * @return \Illuminate\Http\Response
     */
    public function show(TipeProyek $tipeProyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipeProyek  $tipeProyek
     * @return \Illuminate\Http\Response
     */
    public function edit(TipeProyek $tipeProyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipeProyekRequest  $request
     * @param  \App\Models\TipeProyek  $tipeProyek
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipeProyekRequest $request, TipeProyek $tipeProyek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipeProyek  $tipeProyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipeProyek $tipeProyek)
    {
        //
    }
}
