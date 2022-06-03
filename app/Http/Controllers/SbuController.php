<?php

namespace App\Http\Controllers;

use App\Models\Sbu;
use Illuminate\Http\Request;

class SbuController extends Controller
{
            /**
             * Display a listing of the resource.
             *
             * @return \Illuminate\Http\Response
             */
    public function index()
    {
        return view('/MasterData/Sbu', ['sbu' => Sbu::all()]);
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
        
        $newSbu->sbu = $dataSbu["sbu"];
        $newSbu->kode_sbu = $dataSbu["kode-sbu"];
        $newSbu->klasifikasi = $dataSbu["klasifikasi"];
        $newSbu->sub_klasifikasi = $dataSbu["sub-klasifikasi"];
        $newSbu->referensi1 = $dataSbu["referensi1"];
        $newSbu->referensi2 = $dataSbu["referensi2"];
        $newSbu->referensi3 = $dataSbu["referensi3"];

        if ($newSbu->save()) {
            return redirect('/sbu')->with("success", true);
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
    public function destroy(Sbu $sbu)
    {
        //
    }
}
