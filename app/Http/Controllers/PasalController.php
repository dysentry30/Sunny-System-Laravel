<?php

namespace App\Http\Controllers;

use App\Models\Pasals;
use Illuminate\Http\Request;
use App\Models\AddendumContracts;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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
        return view("9_Change_request", ["addendumContracts" => AddendumContracts::all()]);
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

    public function pasalClear(Request $request) {
        if (Session::has("pasals")) {
            Session::forget("pasals");
        }
        return response()->json([
            "status" => "success",
            "message" => "Pasal-pasal have been cleared",
        ]);
    }

    // save pasal to Session
    public function pasalSave(Request $request) {
        $data = $request->all();
        $pasalsPost = explode(",", $data["pasals"]);
        $pasals = [];
        foreach ($pasalsPost as $pasalPost) {
            $pasal = Pasals::find($pasalPost);
            if ($pasal instanceof Pasals) {
                array_push($pasals, $pasal);
            }
        }
        if (Session::has("pasals")) {
            Session::forget("pasals");
            Session::put("pasals", $pasals);
            return response()->json([
                "status" => "success",
                "message" => "Success to update pasal",
                "pasals" => json_encode(Session::get("pasals")),
            ]);
        } else {
            Session::put("pasals", $pasals);
        }
    
        if (Session::has("pasals")) {
            return response()->json([
                "status" => "success",
                "message" => "Success to add pasal",
                "pasals" => json_encode(Session::get("pasals")),
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Failed to add pasal",
        ]);
    }

    // Save Pasal to database or server
    public function pasalAdd(Request $request, Pasals $pasals) {
        $pasal = $request->get("pasal");
        $pasals->pasal = $pasal;
        if ($pasals->save()) {
            return response()->json([
                "status" => "success",
                "message" => "Your pasal have been added",
                "pasals" => Pasals::all(),
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Your pasal cannot be added",
        ]);
    }

    // update Pasal from input to database
    
    public function pasalUpdate(Request $request) {
        $pasal = $request->get("pasal");
        $id_pasal = $request->get("id_pasal");
        $pasals = Pasals::find($id_pasal);
        $pasals->pasal = $pasal;
        if ($pasals->save()) {
            return response()->json([
                "status" => "success",
                "message" => "Your pasal have been updated",
                "pasals" => Pasals::all(),
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Your pasal cannot be updated",
        ]);
    }
}
