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
    
    public function indexCustomer(Request $request, $id = "") {
        $data = $request->all();
        // dd(explode("-", Auth::user()->nip));
        if (!empty($id)) {
            $csi = Csi::find($id);
        } else {
            $user = explode("-", Auth::user()->nip);
            // $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', '=', $user[2])->first();
            $csi = Csi::find($user[2]);
        }

        if (!empty($csi->jawaban)) {
            $jawaban = collect(json_decode($csi->jawaban));
        } else {
            $jawaban = null;
        }
        
        $customer = Customer::where("id_customer", "=", $csi->id_customer)->first();
        $proyek = Proyek::where("kode_proyek", "=", $csi->no_spk)->first();
        
        if (str_contains(Auth::user()->email, "@wika-customer") && !empty($csi->jawaban)) {
            $user = User::find(Auth::user()->id);
            // dd($user);
            $user->is_active = false;
            $user->save();
            Alert::success("Success", "Terimakasih Telah Mengisi Survey Kepuasan Pelanggan Untuk Proyek : " . $proyek->nama_proyek);
            Auth::logout();
            return redirect()->intended("/csi-login");
        }
        $csi->save();
        // dd($csi);
        return view("/Csi/view_csi", compact(["csi","customer", "proyek", "jawaban"]));
    }

    public function saveSurvey(Request $request) {
        $data = $request->all();
        // dd(explode("-", Auth::user()->nip));
        $user = explode("-", Auth::user()->nip);
        // $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', '=', $user[2])->first();
        $csi = Csi::find($user[2]);
        $customer = Customer::where("id_customer", "=", $csi->id_customer)->first();
        $proyek = Proyek::where("kode_proyek", "=", $csi->no_spk)->first();
        
        // dd(collect($data)->count(),$data);
        
        $score_nps = (int) (((int) $data['answer_3']) / 1);
        $score_cli = (int) (((int) $data['answer_1_1'] + (int) $data['answer_1_2']) / 2);
        $score_csi_a = (int) (((int) $data['answer_2_1']) / 1);
        $score_csi_b = (int) (((int) $data['answer_2_2'] + (int) $data['answer_2_3']) / 2);
        $total_kepentingan = (int) $data['answer_4_1_2'] + (int) $data['answer_4_2_2'] + (int) $data['answer_4_3_2'] + (int) $data['answer_4_4_1_b'] + (int) $data['answer_4_4_2_b'] + (int) $data['answer_4_4_3_b'] + (int) $data['answer_4_4_4_b'] + (int) $data['answer_5_1_2'] + (int) $data['answer_5_2_2'] + (int) $data['answer_5_3_2'] + (int) $data['answer_5_4_2'] + (int) $data['answer_5_5_2'] ;
        $wis_1 = (int) (((int) $data['answer_4_1_2'] / (int) $total_kepentingan) * (int) $data['answer_4_1_1']);
        $wis_2 = (int) (((int) $data['answer_4_2_2'] / (int) $total_kepentingan) * (int) $data['answer_4_2_1']);
        $wis_3 = (int) (((int) $data['answer_4_3_2'] / (int) $total_kepentingan) * (int) $data['answer_4_3_1']);
        $wis_4 = (int) (((int) $data['answer_4_4_1_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_1_a']);
        $wis_5 = (int) (((int) $data['answer_4_4_2_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_2_a']);
        $wis_6 = (int) (((int) $data['answer_4_4_3_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_3_a']);
        $wis_7 = (int) (((int) $data['answer_4_4_4_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_4_a']);
        $wis_8 = (int) (((int) $data['answer_5_1_2'] / (int) $total_kepentingan) * (int) $data['answer_5_1_1']);
        $wis_9 = (int) (((int) $data['answer_5_2_2'] / (int) $total_kepentingan) * (int) $data['answer_5_2_1']);
        $wis_10 = (int) (((int) $data['answer_5_3_2'] / (int) $total_kepentingan) * (int) $data['answer_5_3_1']);
        $wis_11 = (int) (((int) $data['answer_5_4_2'] / (int) $total_kepentingan) * (int) $data['answer_5_4_1']);
        $wis_12 = (int) (((int) $data['answer_5_5_2'] / (int) $total_kepentingan) * (int) $data['answer_5_5_1']);
        $total_wis = $wis_1 + $wis_2 + $wis_3 + $wis_4 + $wis_5 + $wis_6 + $wis_7 + $wis_8 + $wis_9 + $wis_10 + $wis_11 + $wis_12;
        $score_csi_c = (int) $total_wis / 5;

        $csi->score_csi = ($score_csi_a + $score_csi_b+ $score_csi_b) / 3 ;
        $csi->score_cli = $score_cli ;
        $csi->score_nps = $score_nps ;
        $csi->score_total = ($csi->score_csi + $csi->score_cli + $csi->score_nps) / 3 ;
        
        // dd("csi",$csi->score_csi, "cli", $csi->score_cli, "nps", $csi->score_nps);

        $arrayJawaban = $data;
        $csi->jawaban = json_encode($arrayJawaban);
        $csi->status = "Done";
        $csi->save();
        
        $jawaban = collect(json_decode($csi->jawaban));
        // dd($jawaban);
        
        if (str_contains(Auth::user()->email, "@wika-customer")) {
            $user = User::find(Auth::user()->id);
            // dd($user);
            $user->is_active = false;
            $user->save();
            Alert::success("Success", "Terimakasih Telah Mengisi Survey Kepuasan Pelanggan Untuk Proyek : ". $proyek->nama_proyek);
            Auth::logout();
            return redirect()->intended("/csi-login");
            // Alert::error("Preview User Sementara", "Nanti JAwaban Akan Di hide");
            // return view("/Csi/view_csi", compact(["csi","customer", "proyek", "jawaban"]));
        } else {
            return view("/Csi/view_csi", compact(["csi","customer", "proyek", "jawaban"]));
        }
    }

    public function sendCsi(Request $request) {

        $data = $request->all();
        // dd($data);
        $csi = Csi::find($data['id-csi']);
        if ($csi->status != "Not Sent") {
            Alert::error("Pesan Gagal Terkirim", "Pastikan Customer Telah Mengisi Survey Sebelumnya");
            return redirect()->back();
        }

        $user = new User();
        $idCustomer = Str::random(12);
        $user->nip = $data['kode-proyek'] . "-" . $data['id-pemberi-kerja']."-" . $data['id-csi'] . "-" . $idCustomer;
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
        
        $csi->status = "Requested";
        $csi->id_struktur_organisasi = $user->nip;
        // dd($csi, $user);
        
        
        // $url = "https://crm-dev.wika.co.id/customer/view/". $data['id-pemberi-kerja']."/". str_replace(" ", "%20", $data['pemberi-kerja']);
        $url = "https://crm-dev.wika.co.id/csi-login";
        $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            "api_key" => "c15978155a6b4656c4c0276c5adbb5917eb033d5",
            "sender" => "62811881227",
            "number" => $data['nomor-penerima'],
            "message" => "Hi, *". $data['nama-penerima']. "* dari *" . $data['pemberi-kerja'] . "*.\nSilahkan tekan link di bawah ini untuk pengisian survey kami.\nGunakan User dan password dibawah ini untuk login : \nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n\n$url",
            // "url" => $url
        ]);
        // dd($send_msg_to_wa);

        $send_msg_to_wa->onError(function($error) {
            // dd($error);
            Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            return redirect()->back();
        });
        
        $user->save();
        $csi->save();

        Alert::success('Success', "Berhasil, Pesan Telah Terkirim ke ". $data['nama-penerima']);
        return redirect()->back();
    }
}
