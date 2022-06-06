<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Dop;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/MasterData/UnitKerja', ['unitkerja' => UnitKerja::all(), 'dops' => Dop::all(), 'companies' => Company::all()]);
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
        
        $newUnitKerja->nomor_unit = $dataUnitKerja["nomor-unit"];
        $newUnitKerja->unit_kerja = $dataUnitKerja["unit-kerja"];
        $newUnitKerja->divcode = $dataUnitKerja["divcode"];
        $newUnitKerja->dop = $dataUnitKerja["dop"];
        $newUnitKerja->company = $dataUnitKerja["company"];
        $newUnitKerja->pic = $dataUnitKerja["pic"];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitKerja $unitKerja)
    {
        //
    }
}
