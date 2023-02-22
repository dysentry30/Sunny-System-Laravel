<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Divisi;
use App\Models\Dop;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DivisiController extends Controller
{
    public function index(Request $request) {
        $divisi_all = Divisi::all();
        $unit_kerjas = UnitKerja::all();
        $dops = Dop::all();
        $companies = Company::all();
        return view("MasterData/Divisi", compact(["divisi_all", "dops", "companies", "unit_kerjas"]));
    }

    public function save(Request $request) {
        $data = $request->all();
        $rules = [
            "unit-kerja" => "required"
        ];
        $is_invalid = validateInput($data, $rules);
        
        if(!empty($is_invalid)) {
            Alert::html("Error", "Pastikan field <b>$is_invalid</b> terisi!", "error");
            return redirect()->back();
        }
        
        $new_direktorat = new Divisi();
        $new_direktorat->unit_kerja = $data["unit-kerja"];
        if($new_direktorat->save()) {
            Alert::success("Success", "Data Divisi berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Error", "Data Divisi gagal ditambahkan");
        return redirect()->back();
    }

    public function edit(Request $request, Divisi $direktorat) {
        $data = $request->all();
        $rules = [
            "unit-kerja" => "required"
        ];
        $is_invalid = validateInput($data, $rules);
        
        if(!empty($is_invalid)) {
            Alert::html("Error", "Pastikan field <b>$is_invalid</b> terisi!", "error");
            return redirect()->back();
        }
        
        $direktorat->unit_kerja = $data["unit-kerja"];
        if($direktorat->save()) {
            Alert::success("Success", "Data Divisi berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error("Error", "Data Divisi gagal diperbarui");
        return redirect()->back();
    }

    public function delete(Request $request, Divisi $divisi) {
        
        if($divisi->delete()) {
            Alert::success("Success", "Data Divisi berhasil dihapus");
            return redirect()->back();
        }
        Alert::error("Error", "Data Divisi gagal dihapus");
        return redirect()->back();
    }
}
