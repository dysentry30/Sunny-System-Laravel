<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class InstansiController extends Controller
{
    public function index()
    {
        $instansis = Instansi::all();
        return view("MasterData/Instansi", compact(["instansis"]));
    }
    public function createInstansi(Request $request){
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "kode-instansi" => "required|string",
            "nama-instansi" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Departemen Gagal Ditambahkan");
            return Redirect::back()->with("modal", $data["modal"]);
            // return Redirect::back();
        }
        $validation->validate();

        $instansi = new Instansi();
        $instansi->kode_instansi = $data["kode-instansi"];
        $instansi->nama_instansi = $data["nama-instansi"];

        if($instansi->save()){
            Alert::success("Success", "Instansi Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error("Error", "Instansi Gagal Ditambahkan");
            return redirect()->back();
    }

    public function editInstansi(Request $request, $id){
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "kode-instansi" => "required|string",
            "nama-instansi" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Instansi Gagal Diubah");
            return Redirect::back();
            // return Redirect::back();
        }
        $validation->validate();

        $is_exist_instansi = Instansi::find($id);

        if (empty($is_exist_instansi)) {
            Alert::error("Error", "Instansi tidak ditemukan!");
            return redirect()->back();
        }

        $instansi = $is_exist_instansi;
        $instansi->kode_instansi = $data["kode-instansi"];
        $instansi->nama_instansi = $data["nama-instansi"];

        if($instansi->save()){
            Alert::success("Success", "Departemen Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error("Error", "Departemen Gagal Diubah");
        return redirect()->back();
    }
    
    public function deleteInstansi($kode_instansi)
    {
        $is_exist_instansi = Instansi::where("kode_instansi", "=", $kode_instansi)->first();
        if(Auth::user()->check_administrator && !empty($is_exist_instansi)){
            if($is_exist_instansi->delete()){
                Alert::success("Success", "Instansi Berhasil Dihapus");
                return redirect()->back();
            }
            Alert::error("Error", "Instansi Gagal Dihapus");
            return redirect()->back();
        }
        Alert::error("Error", "Instansi Gagal Dihapus");
        return redirect()->back();
    }
}
