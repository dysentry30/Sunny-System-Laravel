<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Company;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/MasterData/UnitKerja', ['unitkerjas' => UnitKerja::all(), 'dops' => Dop::all(), 'companies' => Company::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UnitKerja $newUnitKerja)
    {
        $dataUnitKerja = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nomor-unit" => "required",
            "unit-kerja" => "required",
            "divcode" => "required",
            "dop" => "required",
            "company" => "required",
        ];
        $validation = Validator::make($dataUnitKerja, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-unit");
            $request->old("unit-kerja");
            $request->old("divcode");
            $request->old("dop");
            $request->old("company");
            Alert::error('Error', "Unit Kerja Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();   
        
        $newUnitKerja->nomor_unit = $dataUnitKerja["nomor-unit"];
        $newUnitKerja->unit_kerja = $dataUnitKerja["unit-kerja"];
        $newUnitKerja->divcode = $dataUnitKerja["divcode"];
        $newUnitKerja->dop = $dataUnitKerja["dop"];
        $newUnitKerja->company = $dataUnitKerja["company"];
        $newUnitKerja->pic = $dataUnitKerja["pic"];

        Alert::success('Success', $dataUnitKerja["unit-kerja"].", Berhasil Ditambahkan");

        if ($newUnitKerja->save()) {
            return redirect('/unit-kerja')->with("success", true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(UnitKerja $unitKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitKerja $unitKerja)
    {
        $data = $request->all();
        dd($data);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nomor-unit" => "required",
            "unit-kerja" => "required",
            "divcode" => "required",
            "dop" => "required",
            "company" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-unit");
            $request->old("unit-kerja");
            $request->old("divcode");
            $request->old("dop");
            $request->old("company");
            Alert::error('Error', "Unit Kerja Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();   
        
        $unitKerja->nomor_unit = $data["nomor-unit"];
        $unitKerja->unit_kerja = $data["unit-kerja"];
        $unitKerja->divcode = $data["divcode"];
        $unitKerja->dop = $data["dop"];
        $unitKerja->company = $data["company"];
        $unitKerja->pic = $data["pic"];

        
        if ($unitKerja->save()) {
            Alert::success('Success', $data["unit-kerja"].", Berhasil Ditambahkan");
            return redirect('/unit-kerja')->with("success", true);
        }
        Alert::error('Error', "Setting Approval untuk <b>" . $data["unit-kerja"]. "</b> gagal disimpan");
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = UnitKerja::find($id);
        $unitKerja = $id->unit_kerja;
        
        $id->delete();
        Alert::success('Delete', $unitKerja.", Berhasil Dihapus");

        return redirect()->back();
    }
}
