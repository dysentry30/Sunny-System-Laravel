<?php

namespace App\Http\Controllers;

use App\Models\Csi;
use App\Models\User;
use App\Models\Proyek;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class CSIController extends Controller
{
    public function index(Request $request) {
        $csi = Csi::all();
        return view("14_CSI", compact(["csi"]));
    }
    
    public function indexCustomer(Request $request) {
        // dd(explode("-", Auth::user()->nip));
        $user = explode("-", Auth::user()->nip);
        // $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', '=', $user[2])->first();
        $csi = Csi::find($user[3]);
        // dd($csi);
        $customer = Customer::where("id_customer", "=", $csi->id_customer)->first();
        $proyek = Proyek::where("kode_proyek", "=", $csi->no_spk)->first();
        return view("/Csi/view_csi", compact(["csi","customer", "proyek"]));
    }

    public function saveSurvey(Request $request) {
        dd($request->all());
        // dd(explode("-", Auth::user()->nip));
        $user = explode("-", Auth::user()->nip);
        // $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', '=', $user[2])->first();
        $csi = Csi::find($user[3]);
        // dd($csi);
        $customer = Customer::where("id_customer", "=", $csi->id_customer)->first();
        $proyek = Proyek::where("kode_proyek", "=", $csi->no_spk)->first();
        return view("/Csi/view_csi", compact(["csi","customer", "proyek"]));
    }

    public function sendCsi(Request $request) {

        $data = $request->all();
        // dd($data);
        $csi = Csi::find($data['id-csi']);
        if ($csi->status != "Not Sent") {
            Alert::error("Pesan Gagal Terkirim", "Pastikan Customer Telah Mengisi Survey Sebelumnya");
            return redirect()->back();
        }
        $csi->status = "Requested";
        $csi->save();
        // dd($csi);

        $user = new User();
        $idCustomer = Str::random(12);
        $user->nip = $data['kode-proyek'] . "-" . $data['id-pemberi-kerja']."-" . $data['id-struktur'] . "-" . $data['id-csi'] . "-" . $idCustomer;
        // dd($data["nip"]);
        $user->name = $data['nama-penerima'];
        $user->email = $idCustomer. "@wika-customer";
        $user->no_hp = $data['nomor-penerima'];
        $user->unit_kerja = null;
        // $user->alamat = $data["alamat"];
        $user->check_user_sales = true;
        $user->check_administrator = false;
        $user->check_admin_kontrak = false;
        $user->check_team_proyek = false;
        // $user->password = Hash::make($password);
        $user->is_active = true;
        $user->password = Hash::make($user->email);
        $user->save();

        // dd($user);


        $url = "https://crm.wika.co.id/customer/view/". $data['id-pemberi-kerja']."/". str_replace(" ", "%20", $data['pemberi-kerja']);
        $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            "api_key" => "c15978155a6b4656c4c0276c5adbb5917eb033d5",
            "sender" => "62811881227",
            "number" => $data['nomor-penerima'],
            "message" => "Hi, *". $data['nama-penerima']. "* dari *" . $data['pemberi-kerja'] . "*.\nSilahkan tekan link di bawah ini untuk pengisian survey kami.\nGunakan User dan password dibawah ini untuk login : \nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n\n$url",
            // "url" => $url
        ]);

        Alert::success('Success', "Berhasil, Pesan Telah Terkirim ke ". $data['nama-penerima']);
        return redirect()->back();
    }
}
