<?php

namespace App\Http\Controllers;

use App\Models\MataUang;
use App\Http\Requests\StoreMataUangRequest;
use App\Http\Requests\UpdateMataUangRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class MataUangController extends Controller
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
            $mataUang = MataUang::sortable()->where($column, 'like', '%' . $filter . '%')->get();
        } else {
            $mataUang = MataUang::sortable()->get();
        }

        return view('/MasterData/MataUang', compact(['mataUang', 'column', 'filter']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MataUang $mataUang)
    {
        $dataUang = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "mata-uang" => "required",
        ];
        $validation = Validator::make($dataUang, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "DOP Fagal Dibuat !");
        }

        $validation->validate();
        $mataUang->mata_uang = $dataUang["mata-uang"];
        $mataUang->kurs = $dataUang["kurs"];

        Alert::success('Success', $dataUang["mata-uang"] . ", Berhasil Ditambahkan");

        if ($mataUang->save()) {
            return redirect()->back();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMataUangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(StoreMataUangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function show(MataUang $mataUang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function edit(MataUang $mataUang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMataUangRequest  $request
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMataUangRequest $request, MataUang $mataUang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = MataUang::find($id);
        $mata_uang = $id->mata_uang;

        $id->delete();
        Alert::success('Delete', $mata_uang . ", Berhasil Dihapus")->hideCloseButton();

        return redirect()->back();
    }
}
