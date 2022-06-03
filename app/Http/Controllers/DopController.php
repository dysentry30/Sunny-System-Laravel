<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use Illuminate\Http\Request;

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
        
        $newDop->dop = $dataDop["dop"];

        if ($newDop->save()) {
            return redirect("/dop")->with("success", true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dop  $dop
     * @return \Illuminate\Http\Response
     */
    public function show(Dop $dop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dop  $dop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dop $dop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dop  $dop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dop $dop)
    {
        //
    }
}
