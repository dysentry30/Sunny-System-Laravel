<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DopController extends Controller
{
            /**
             * Display a listing of the resource.
             *
             * @return \Illuminate\Http\Response
             */
    public function index()
    {
        return view('/MasterData/Dop', ['dops' => Dop::all()]);
    }

            /**
             * Store a newly created resource in storage.
             *
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
    public function store(Request $request, Dop $newDop)
    {
        $dataDop = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "dop" => "required",
        ];
        $validation = Validator::make($dataDop, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "DOP gagal dibuat !");
        }
        
        $validation->validate(); 
        $newDop->dop = $dataDop["dop"];

        Alert::success('Success', $dataDop["dop"].", Berhasil Ditambahkan");

        if ($newDop->save()) {
            return redirect()->back();
        }
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dop  $dop
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = Dop::find($id);
        $dop = $id->dop;
        
        $id->delete();
        Alert::success('Delete', $dop.", Berhasil Dihapus")->hideCloseButton();

        return redirect()->back();
    }
}
