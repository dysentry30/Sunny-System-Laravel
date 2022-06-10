<?php

namespace App\Http\Controllers;

use App\Models\Pasals;
use Illuminate\Http\Request;
use App\Models\AddendumContracts;
use Illuminate\Support\Facades\Redirect;

class PasalController extends Controller
{
 
    public function index()
    {
        return view("pasals/view", ["pasals" => Pasals::all()]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Pasals $pasal)
    {
        return response()->json([
            "pasal" => $pasal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeRequest()
    {
        return view("changeRequest/view", ["addendumContracts" => AddendumContracts::all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pasals $pasal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasals $pasal)
    {
        if ($pasal->delete()) {
            return Redirect::back()->with("msg", "This pasal have been deleted");
        }
        return Redirect::back()->with("msg", "This pasal failed to delete");
    }
}
