<?php

namespace App\Http\Controllers;

use App\Models\Direktorat;
use App\Models\Dop;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DirektoratController extends Controller
{
    public function index(Request $request) {
        $direktorat_all = Direktorat::all();
        $dops = Dop::all();
        return view("MasterData/Direktorat", compact(["direktorat_all", "dops"]));
    }

    public function save(Request $request) {
        $data = $request->all();
        $rules = [
            "direktorat" => "required"
        ];
        $is_invalid = validateInput($data, $rules);
        
        if(!empty($is_invalid)) {
            Alert::html("Error", "Pastikan field <b>$is_invalid</b> terisi!", "error");
            return redirect()->back();
        }
        
        $new_direktorat = new Direktorat();
        $new_direktorat->dop = $data["direktorat"];
        if($new_direktorat->save()) {
            Alert::success("Success", "Data Direktorat berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Error", "Data Direktorat gagal ditambahkan");
        return redirect()->back();
    }

    public function edit(Request $request, Direktorat $direktorat) {
        $data = $request->all();
        $rules = [
            "direktorat" => "required"
        ];
        $is_invalid = validateInput($data, $rules);
        
        if(!empty($is_invalid)) {
            Alert::html("Error", "Pastikan field <b>$is_invalid</b> terisi!", "error");
            return redirect()->back();
        }
        
        $direktorat->dop = $data["direktorat"];
        if($direktorat->save()) {
            Alert::success("Success", "Data Direktorat berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error("Error", "Data Direktorat gagal diperbarui");
        return redirect()->back();
    }

    public function delete(Request $request, Direktorat $direktorat) {
        
        if($direktorat->delete()) {
            Alert::success("Success", "Data Direktorat berhasil dihapus");
            return redirect()->back();
        }
        Alert::error("Error", "Data Direktorat gagal dihapus");
        return redirect()->back();
    }
}
