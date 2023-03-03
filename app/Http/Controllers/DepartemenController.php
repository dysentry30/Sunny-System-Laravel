<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DepartemenController extends Controller
{
    public function index(){
        $departemens = Departemen::all();
        return view("MasterData/Departement", compact("departemens"));
    }

    public function createDepartemen(Request $request){
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "kode-departemen" => "required|string",
            "nama-departemen" => "required|string",
            "kode-divisi" => "required|string",
            "profit-center-departemen" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Departemen Gagal Ditambahkan");
            return Redirect::back()->with("modal", $data["modal"]);
            // return Redirect::back();
        }
        $validation->validate();

        $departemen = new Departemen();
        $departemen->kode_departemen = $data["kode-departemen"];
        $departemen->nama_departemen = $data["nama-departemen"];
        $departemen->kode_divisi = $data["kode-divisi"];
        $departemen->profit_center_departemen = $data["profit-center-departemen"];

        if($departemen->save()){
            Alert::success("Success", "Departemen Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error("Error", "Departemen Gagal Ditambahkan");
            return redirect()->back();
    }

    public function editDepartemen(Request $request, $id){
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "kode-departemen" => "required|string",
            "nama-departemen" => "required|string",
            "kode-divisi" => "required|string",
            "profit-center-departemen" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Departemen Gagal Diubah");
            return Redirect::back();
            // return Redirect::back();
        }
        $validation->validate();

        $is_exist_departemen = Departemen::find($id);

        if (empty($is_exist_departemen)) {
            Alert::error("Error", "Departemen tidak ditemukan!");
            return redirect()->back();
        }

        $departemen = $is_exist_departemen;
        $departemen->kode_departemen = $data["kode-departemen"];
        $departemen->nama_departemen = $data["nama-departemen"];
        $departemen->kode_divisi = $data["kode-divisi"];
        $departemen->profit_center_departemen = $data["profit-center-departemen"];

        if($departemen->save()){
            Alert::success("Success", "Departemen Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error("Error", "Departemen Gagal Diubah");
        return redirect()->back();
    }
    
    public function deleteDepartemen($kode_departemen)
    {
        $is_exist_departemen = Departemen::where("kode_departemen", "=", $kode_departemen)->first();
        if(Auth::user()->check_administrator && !empty($is_exist_departemen)){
            if($is_exist_departemen->delete()){
                Alert::success("Success", "Departemen Berhasil Dihapus");
                return redirect()->back();
            }
            Alert::error("Error", "Departemen Gagal Dihapus");
            return redirect()->back();
        }
        Alert::error("Error", "Departemen Gagal Dihapus");
        return redirect()->back();
    }
}
