<?php

namespace App\Http\Controllers;

use App\Models\Csi;
use App\Models\CsiKalkulasiJawaban;
use App\Models\CsiMasterGroupParentPertanyaan;
use App\Models\CsiMasterKategoriPertanyaan;
use App\Models\CsiMasterPertanyaan;
use App\Models\CsiMasterTingkatKepuasan;
use App\Models\User;
use App\Models\Proyek;
use App\Models\ProyekProgress;
use App\Models\UnitKerja;
use App\Models\Customer;
use App\Models\ProyekPISNew;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StrukturCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use DateTime;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;



class CSIController extends Controller
{
    public function index(Request $request) {
        $unit_kerja = UnitKerja::select('divcode')->where('dop', '!=', 'EA')->get();
        $unit_kerja_filter = $unit_kerja->map(function ($unit) {
            return $unit->divcode;
        })->toArray();
        // $proyeks = Proyek::whereIn('unit_kerja', $unit_kerja_filter)->get();
        // $proyeks = ProyekPISNew::join('customers', 'pemberi_kerja_code', 'kode_nasabah')->where('entitas_proyek', '=', null)->get();
        $proyeks = ProyekPISNew::with('Customer', 'Csi')->where('entitas_proyek', '=', null)->where('bast2_date', '>=', Carbon::now())->get();
        // $csi = Proyek::join("proyek_csi", "proyek_csi.no_spk", "=", "proyeks.kode_proyek")->get();
        // dd($proyeks->first());
        $csi = Csi::all();
        return view("14_CSI", compact(["csi", "proyeks"]));
    }
    
    public function indexCustomer(Request $request, $id = "") {
        $data = $request->all();
        // dd(explode("-", Auth::user()->nip));
        if (!empty($id)) {
            $csi = Csi::find($id);
        } else {
            $getStrukturFromEmailUser = StrukturCustomer::where('email_struktur', Auth::user()->email)->where('id_struktur_organisasi', Auth::user()->nip)->first();
            if (empty($getStrukturFromEmailUser)) {
                Alert::error('Error', 'Survey tidak ditemukan');
                return redirect('/csi-login');
            }
            $user = explode("-", $getStrukturFromEmailUser->id_struktur_organisasi);
            // $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', '=', $user[2])->first();
            $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', Auth::user()->nip)->first();
            // $csi = Csi::find($user[2]);
        }

        if (!empty($csi->jawaban)) {
            $jawaban = collect(json_decode($csi->jawaban));
        } else {
            $jawaban = null;
        }
        
        // dd($id);
        $customer = Customer::where("id_customer", "=", $csi->id_customer)->first();
        // $proyek = Proyek::where("kode_proyek", "=", $csi->no_spk)->first();
        $proyek = ProyekPISNew::where("spk_intern_no", "=", $csi->no_spk)->first();
        // $proyek = ProyekPISNew::where(function ($query) use ($csi) {
        //     $query->where('profit_center', $csi->no_spk)
        //         ->orWhere('spk_intern_no', $csi->no_spk);
        // })->first();

        if (Gate::allows('user-csi') && !empty($csi->jawaban)) {
            $user = User::find(Auth::user()->id);
            // dd($user);
            // $user->is_active = false;
            $user->save();
            Alert::success("Success", "Terimakasih Telah Mengisi Survey Kepuasan Pelanggan Untuk Proyek : " . $proyek->nama_proyek);
            Auth::logout();
            return redirect()->intended("/csi-login");
        }
        // $csi->save();
        // dd($csi);
        if (str_contains(Auth::user()->email, "@wika-customer")) {
            // Alert::html('To Whom It May Concern <br><br> Mr/Mrs : <b>' . $csi->Struktur->nama_struktur . '</b>  <br> Position : <b>' . $csi->Struktur->jabatan_struktur . '</b> <br> Project : <b>' . $csi->Proyek->nama_proyek . '</b>' , '<br> We kindly ask for your assistance in measuring the customer satisfaction index for the project which we are currently running. As part of our commitment to provide high-quality services, we believe it is essential to evaluate and understand our valuable customers level of satisfaction.' . '<br>  We hope that you are willing to provide information to help us with this project. We are looking forward to receiving your response and help to improve our customer satisfaction.' . '<br><br> Best regards, <br> SvP Strategic Marketing & Transformation', 'success')->autoClose(12000)->width(1000);
        }
        return view("/Csi/view_csi", compact(["csi","customer", "proyek", "jawaban"]));
    }

    public function saveSurvey(Request $request) {
        $data = $request->all();
        // dd(explode("-", Auth::user()->nip));
        $user = explode("-", Auth::user()->nip);
        $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->where('id_struktur_organisasi', '=', Auth::user()->nip)->first();
        // dd($csi);
        // $csi = Csi::where('no_spk', '=', $user[0])->where('id_customer', '=', $user[1])->first();
        // $csi = Csi::find($user[2]);
        $customer = Customer::where("id_customer", "=", $csi->id_customer)->first();
        // $proyek = Proyek::where("kode_proyek", "=", $csi->no_spk)->first();
        $proyek = ProyekPISNew::where("spk_intern_no", "=", $csi->no_spk)->first();
        // $proyek = ProyekPISNew::where(function ($query) use ($csi) {
        //     $query->where('profit_center', $csi->no_spk)
        //         ->orWhere('spk_intern_no', $csi->no_spk);
        // })->first();

        // dd(collect($data)->count(),$data);
        if (!empty($data['tidak-setuju']) && $data['tidak-setuju'] == true) {
            $csi->jawaban = "Tidak Setuju";
            $csi->jawaban = json_encode($data);
            $csi->is_setuju = "f";
            $csi->status = "Done";
            $csi->tanggal_submit = date('now');
            $csi->save();
        } else {
            $score_nps = (int) (((int) $data['answer_3']) / 1);
            $score_cli = (int) (((int) $data['answer_1_1'] + (int) $data['answer_1_2']) / 2);
            $score_csi_a = (int) (((int) $data['answer_2_1']) / 1);
            $score_csi_b = (int) (((int) $data['answer_2_2'] + (int) $data['answer_2_3']) / 2);
            $total_kepentingan = (int) $data['answer_4_1_2'] + (int) $data['answer_4_2_2'] + (int) $data['answer_4_3_2'] + (int) $data['answer_4_4_1_b'] + (int) $data['answer_4_4_2_b'] + (int) $data['answer_4_4_3_b'] + (int) $data['answer_4_4_4_b'] + (int) $data['answer_5_1_2'] + (int) $data['answer_5_2_2'] + (int) $data['answer_5_3_2'] + (int) $data['answer_5_4_2'] + (int) $data['answer_5_5_2'];
            $total_kepuasan = (int) $data['answer_4_1_1'] + (int) $data['answer_4_2_1'] + (int) $data['answer_4_3_1'] + (int) $data['answer_4_4_1_a'] + (int) $data['answer_4_4_2_a'] + (int) $data['answer_4_4_3_a'] + (int) $data['answer_4_4_4_a'] + (int) $data['answer_5_1_1'] + (int) $data['answer_5_2_1'] + (int) $data['answer_5_3_1'] + (int) $data['answer_5_4_1'] + (int) $data['answer_5_5_1'];
            $wis_1 = round((((int) $data['answer_4_1_2'] / (int) $total_kepentingan) * (int) $data['answer_4_1_1']), 2);
            $wis_2 = round((((int) $data['answer_4_2_2'] / (int) $total_kepentingan) * (int) $data['answer_4_2_1']), 2);
            $wis_3 = round((((int) $data['answer_4_3_2'] / (int) $total_kepentingan) * (int) $data['answer_4_3_1']), 2);
            $wis_4 = round((((int) $data['answer_4_4_1_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_1_a']), 2);
            $wis_5 = round((((int) $data['answer_4_4_2_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_2_a']), 2);
            $wis_6 = round((((int) $data['answer_4_4_3_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_3_a']), 2);
            $wis_7 = round((((int) $data['answer_4_4_4_b'] / (int) $total_kepentingan) * (int) $data['answer_4_4_4_a']), 2);
            $wis_8 = round((((int) $data['answer_5_1_2'] / (int) $total_kepentingan) * (int) $data['answer_5_1_1']), 2);
            $wis_9 = round((((int) $data['answer_5_2_2'] / (int) $total_kepentingan) * (int) $data['answer_5_2_1']), 2);
            $wis_10 = round((((int) $data['answer_5_3_2'] / (int) $total_kepentingan) * (int) $data['answer_5_3_1']), 2);
            $wis_11 = round((((int) $data['answer_5_4_2'] / (int) $total_kepentingan) * (int) $data['answer_5_4_1']), 2);
            $wis_12 = round((((int) $data['answer_5_5_2'] / (int) $total_kepentingan) * (int) $data['answer_5_5_1']), 2);
            $total_wis = round($wis_1, 2) + round($wis_2, 2) + round($wis_3, 2) + round($wis_4, 2) + round($wis_5, 2) + round($wis_6, 2) + round($wis_7, 2) + round($wis_8, 2) + round($wis_9, 2) + round($wis_10, 2) + round($wis_11, 2) + round($wis_12, 2);
            $score_csi_c = (int) $total_wis / 5;

            for ($i = 1; $i < 13; $i++) {
                $variableName = 'wis_' . $i;

                $newCsiJawaban = new CsiKalkulasiJawaban();
                $newCsiJawaban->csi_id = $csi->id_csi;
                $newCsiJawaban->no_spk = $csi->no_spk;
                $newCsiJawaban->nilai = $$variableName;
                $newCsiJawaban->index = $i;
                $newCsiJawaban->kategori = 'wis';
                $newCsiJawaban->keterangan = $variableName;
                // dd($newCsiJawaban);
                $newCsiJawaban->save();
            }

            // $csi->score_csi = ($score_csi_a + $score_csi_b + $score_csi_b) / 3;
            $csi->score_csi = $total_wis;
            $csi->score_cli = $score_cli;
            $csi->score_nps = $score_nps;
            $csi->score_total = ($csi->score_csi + $csi->score_cli + $csi->score_nps) / 3;

            // dd("csi",$csi->score_csi, "cli", $csi->score_cli, "nps", $csi->score_nps);

            $arrayJawaban = $data;
            $csi->jawaban = json_encode($arrayJawaban);
            $csi->is_setuju = "t";
            $csi->kompetitor = $data['kompetitor'] ?? null;
            $csi->status = "Done";
            $csi->tanggal_submit = Carbon::create('now');
            $csi->save();
        }
        // dd($data, $csi);
        
        
        $jawaban = collect(json_decode($csi->jawaban));
        // dd($jawaban);

        if (Gate::allows('user-csi')) {
            $user = User::find(Auth::user()->id);
            // dd($user);
            // $user->is_active = false;
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

    // public function sendCsi(Request $request) {

    //     $data = $request->all();
    //     // dd($data);
    //     $csi = Csi::find($data['id-csi']);
    //     if ($csi->status != "Not Sent") {
    //         Alert::error("Pesan Gagal Terkirim", "Pastikan Customer Telah Mengisi Survey Sebelumnya");
    //         return redirect()->back();
    //     }

    //     $user = new User();
    //     $idCustomer = Str::random(12);
    //     $user->nip = $data['kode-proyek'] . "-" . $data['id-pemberi-kerja']."-" . $data['id-csi'] . "-" . $idCustomer;
    //     // dd($data["nip"]);
    //     $user->name = $data['nama-penerima'];
    //     $user->email = $idCustomer. "@wika-customer";
    //     $user->no_hp = $data['nomor-penerima'];
    //     $user->unit_kerja = null;
    //     // $user->alamat = $data["alamat"];
    //     $user->check_user_sales = true;
    //     $user->check_administrator = false;
    //     $user->check_admin_kontrak = false;
    //     $user->check_team_proyek = false;
    //     // $user->password = Hash::make($password);
    //     $user->is_active = true;
    //     $user->password = Hash::make($user->email);
        
    //     $csi->status = "Requested";
    //     $csi->id_struktur_organisasi = $user->nip;
    //     // dd($csi, $user);


    //     // $url = "https://crm-dev.wika.co.id/customer/view/". $data['id-pemberi-kerja']."/". str_replace(" ", "%20", $data['pemberi-kerja']);
    //     $url = "https://crm.wika.co.id/csi-login";
    //     $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
    //         "api_key" => "4DCR3IU2Eu70znFSvnuc3X3x9gJdcc",
    //         // "sender" => "628188827008",
    //         // "sender" => "62811881227",
    //         "sender" => env("NO_WHATSAPP_BLAST"),
    //         "number" => $data['nomor-penerima'],
    //         "message" => "Salam Hormat, *" . $data['nama-penerima'] . "* dari *" . $data['pemberi-kerja'] . "*.\nKami dari PT. Wijaya Karya (Persero) Tbk, membutuhkan bantuan Anda untuk perbaikan kinerja. Mohon tekan link di bawah ini untuk pengisian survey kepuasan pelanggan.\n\nGunakan User dan password dibawah ini untuk login :  \nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n$url\n\n\nHi, *" . $data['nama-penerima'] . "* from *" . $data['pemberi-kerja'] . "*.\nWe are from PT. Wijaya Karya (Persero) Tbk, kindly need your help to improve our performance. Please click bellow link below to complete customer satisfaction survey.\n\nUse the username and password to log in:\nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n$url",
    //         // "url" => $url
    //     ]);
    //     // dd($send_msg_to_wa);

    //     $send_msg_to_wa->onError(function($error) {
    //         // dd($error);
    //         Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
    //         return redirect()->back();
    //     });
        
    //     $newStruktur = StrukturCustomer::where('id_struktur_organisasi', $data["id-pemberi-kerja"])->where('proyek_struktur', $data["kode-proyek"])->where('role_struktur', $data["segmen"])->first(); 
    //     if (!empty($newStruktur)) {
    //         $newStruktur->nama_struktur = $data["nama-penerima"];
    //         $newStruktur->id_struktur_organisasi = $user->nip;
    //         $newStruktur->jabatan_struktur = $data["jabatan"];
    //         $newStruktur->email_struktur = $data["email"];
    //         $newStruktur->phone_struktur = $data["nomor-penerima"];
    //         $newStruktur->save();
    //     } else {
    //         $newStruktur = new StrukturCustomer();
    //         $newStruktur->id_struktur_organisasi = $user->nip;
    //         $newStruktur->id_customer = $data["id-pemberi-kerja"];
    //         $newStruktur->nama_struktur = $data["nama-penerima"];
    //         $newStruktur->jabatan_struktur = $data["jabatan"];
    //         $newStruktur->email_struktur = $data["email"];
    //         $newStruktur->phone_struktur = $data["nomor-penerima"];
    //         $newStruktur->proyek_struktur = $data["kode-proyek"];
    //         $newStruktur->role_struktur = $data["segmen"];
    //         $newStruktur->save();
    //     }

    //     $csi->save();
    //     $user->save();


    //     Alert::success('Success', "Berhasil, Pesan Telah Terkirim ke ". $data['nama-penerima']);
    //     return redirect()->back();
    // }

    public function sendCsiNew(Request $request)
    {

        $data = $request->all();
        // dd($data);
        // $csi = Csi::find($data['id-csi']);
        // if ($csi->status != "Not Sent") {
        //     Alert::error("Pesan Gagal Terkirim", "Pastikan Customer Telah Mengisi Survey Sebelumnya");
        //     return redirect()->back();
        // }

        $validateInput = validateInput($data, [
            'email' => 'required|email',
            'nama-penerima' => 'required|string'
        ]);

        if (!empty($validateInput)) {
            Alert::html("Error", "Pastikan field <b>$validateInput</b> terisi!", "error");
            return redirect()->back();
        }

        $findEmailDuplicate = User::where('email', $data['email'])->first();

        // if ($findEmailDuplicate) {
        //     Alert::error('Error', 'Email telah digunakan');
        //     return redirect()->back();
        // }

        $proyek = ProyekPISNew::where('spk_intern_no', $data['kode-proyek'])->first();
        // $proyek = ProyekPISNew::where(function ($query) use ($data) {
        //     $query->where('profit_center', $data['kode-proyek'])
        //     ->orWhere('spk_intern_no', $data['kode-proyek']);
        // })->first();

        $csi = new Csi();

        $idCustomer = Str::random(12);

        $user = User::where('email', $data['email'])->first();

        if (empty($user)) {
            $user = new User();
            // $user->nip = $data['kode-proyek'] . "-" . $data['id-pemberi-kerja']."-" . $data['id-csi'] . "-" . $idCustomer;
            // $user->nip = $data['kode-proyek'] . "-" . $data['id-pemberi-kerja'] . "-" . $idCustomer;
            // dd($data["nip"]);
            $user->name = $data['nama-penerima'];
            $user->email = $data['email'];
            $user->no_hp = $data['nomor-penerima'];
            $user->unit_kerja = null;
            // $user->alamat = $data["alamat"];
            $user->check_user_csi = true;
            $user->check_user_sales = false;
            $user->check_administrator = false;
            $user->check_admin_kontrak = false;
            $user->check_team_proyek = false;
            $user->check_team_proyek = false;

            $user->role_user = true;
            $user->role_admin = false;
            $user->role_approver = false;
            $user->role_risk = false;

            // $user->password = Hash::make($password);
        }
        $user->is_active = true;

        $user->nip = $data['kode-proyek'] . "-" . $data['id-pemberi-kerja'] . "-" . $idCustomer;
        $user->password = Hash::make($idCustomer);

        $csi->status = "Requested";
        $csi->id_struktur_organisasi = $user->nip;
        $csi->id_customer = $proyek->Customer?->id_customer;
        $csi->no_spk = $data['kode-proyek'];
        $csi->kategori = $data['kategori'];
        $csi->progress = $data['progress'];
        $csi->tanggal_request = Carbon::create('now');
        // $csi->tanggal = $current;
        // $csi->status = "Not Sent";
        // $csi->progress = $calculate_progress;
        // dd($data['nomor-penerima']);


        // $url = "https://crm-dev.wika.co.id/customer/view/". $data['id-pemberi-kerja']."/". str_replace(" ", "%20", $data['pemberi-kerja']);
        $url = "https://crm.wika.co.id/csi-login";
        $message = nl2br("Salam Hormat, " . $data['nama-penerima'] . " dari " . $data['pemberi-kerja'] . ".\nKami dari PT. Wijaya Karya (Persero) Tbk, membutuhkan bantuan Anda untuk perbaikan kinerja. Mohon tekan link di bawah ini untuk pengisian survey kepuasan pelanggan.\n\nGunakan User dan password dibawah ini untuk login :  \nUser : " . $user->email . "\nPassword : " . $idCustomer . "\n$url\n\n\nHi, " . $data['nama-penerima'] . " from " . $data['pemberi-kerja'] . ".\nWe are from PT. Wijaya Karya (Persero) Tbk, kindly need your help to improve our performance. Please click bellow link below to complete customer satisfaction survey.\n\nUse the username and password to log in:\nUser : " . $user->email . "\nPassword : " . $idCustomer . "\n$url");
        // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
        //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
        //     "sender" => env("NO_WHATSAPP_BLAST"),
        //     "number" => $data['nomor-penerima'],
        //     // "number" => "085881028391",
        //     "message" => "Salam Hormat, *" . $data['nama-penerima'] . "* dari *" . $data['pemberi-kerja'] . "*.\nKami dari PT. Wijaya Karya (Persero) Tbk, membutuhkan bantuan Anda untuk perbaikan kinerja. Mohon tekan link di bawah ini untuk pengisian survey kepuasan pelanggan.\n\nGunakan User dan password dibawah ini untuk login :  \nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n$url\n\n\nHi, *" . $data['nama-penerima'] . "* from *" . $data['pemberi-kerja'] . "*.\nWe are from PT. Wijaya Karya (Persero) Tbk, kindly need your help to improve our performance. Please click bellow link below to complete customer satisfaction survey.\n\nUse the username and password to log in:\nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n$url",
        //     // "url" => $url
        // ]);

        // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
        //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
        //     "sender" => "6281188827008",
        //     // "sender" => "62811881227",
        //     "number" => $data['nomor-penerima'],
        //     "message" => "Salam Hormat, *" . $data['nama-penerima'] . "* dari *" . $data['pemberi-kerja'] . "*.\nKami dari PT. Wijaya Karya (Persero) Tbk, membutuhkan bantuan Anda untuk perbaikan kinerja. Mohon tekan link di bawah ini untuk pengisian survey kepuasan pelanggan.\n\nGunakan User dan password dibawah ini untuk login :  \nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n$url\n\n\nHi, *" . $data['nama-penerima'] . "* from *" . $data['pemberi-kerja'] . "*.\nWe are from PT. Wijaya Karya (Persero) Tbk, kindly need your help to improve our performance. Please click bellow link below to complete customer satisfaction survey.\n\nUse the username and password to log in:\nUser : *" . $user->email . "*\nPassword : *" . $user->email . "*\n$url",
        //     // "url" => $url
        // ]);
        // dd($send_msg_to_wa);

        // $send_msg_to_wa->onError(function ($error) {
        //     // dd($error);
        //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
        //     return redirect()->back();
        // });

        $emailNotification = sendNotifEmail($data['email'], "Permohonan Pengisian Survey Kepuasan Pelanggan", $message, false, false);
        if (!$emailNotification) {
            return redirect()->back();
        }

        $newStruktur = StrukturCustomer::where('id_struktur_organisasi', $data["id-pemberi-kerja"])->where('proyek_struktur', $data["kode-proyek"])->where('role_struktur', $data["segmen"])->first();
        if (!empty($newStruktur)) {
            $newStruktur->nama_struktur = $data["nama-penerima"];
            $newStruktur->id_struktur_organisasi = $user->nip;
            $newStruktur->jabatan_struktur = $data["jabatan"];
            $newStruktur->email_struktur = $data["email"];
            $newStruktur->phone_struktur = $data["nomor-penerima"];
            $newStruktur->save();
        } else {
            $newStruktur = new StrukturCustomer();
            $newStruktur->id_struktur_organisasi = $user->nip;
            $newStruktur->id_customer = $data["id-pemberi-kerja"];
            $newStruktur->nama_struktur = $data["nama-penerima"];
            $newStruktur->jabatan_struktur = $data["jabatan"];
            $newStruktur->email_struktur = $data["email"];
            $newStruktur->phone_struktur = $data["nomor-penerima"];
            $newStruktur->proyek_struktur = $data["kode-proyek"];
            $newStruktur->role_struktur = $data["segmen"];
            $newStruktur->save();
        }

        $csi->save();
        $user->save();


        Alert::success('Success', "Berhasil, Pesan Telah Terkirim ke " . $data['nama-penerima']);
        return redirect()->back();
    }

    public function createCsi($kode_proyek, $kode_spk, $id_customer)
    {

        // $data = $request->all();

        // $kode_spk = $data['kode-spk'];

        $current = new DateTime();
        $str_current = $current->format('Ym');
        $is_exist_progress_period = ProyekProgress::where("kode_spk", "=", $kode_spk)->where("periode", "=", $str_current)->first();
        // $proyek = Proyek::where('kode_proyek', '=', $data['kode-proyek'])->first();
        $proyek = Proyek::where('kode_proyek', '=', $kode_proyek)->first();
        // dd($is_exist_progress_period);

        if (!empty($kode_spk)) {
            $response = Http::post('http://pis.wika.co.id/wpapi/files/getAPIQISList', [
                "kdspk" => $kode_spk,
                "period" => "$str_current"
            ]);

            if ($response->successful()) {
                $data_response = $response->collect($key = "data")->first();

                $calculate_progress = (int)$data_response['ok_review'] && (int)$data_response['progress_fisik_ri'] ? round(((int)$data_response['ok_review'] / (int)$data_response['progress_fisik_ri']), 2) : 0;

                $newCsi = new Csi();
                $newCsi->id_customer = $id_customer;
                $newCsi->id_struktur_organisasi = null;
                $newCsi->no_spk = $kode_proyek;
                $newCsi->tanggal = $current;
                $newCsi->status = "Not Sent";
                $newCsi->progress = $calculate_progress;

                $proyek->progress = $calculate_progress;

                if ($is_exist_progress_period) {
                    $progress = $is_exist_progress_period;
                    $progress->kode_proyek = $kode_proyek;
                    $progress->kode_spk = $kode_spk;
                    $progress->ok_review = (int)$data_response["ok_review"];
                    $progress->progress_fisik_ri = (int)$data_response["progress_fisik_ri"];
                    $progress->lama_proyek = $data_response["lamaproyek"];
                    $progress->laba_kotor_ri = (int)$data_response["laba_kotor_ri"];
                    $progress->progress_fisik_ra = (int) $data_response["progress_fisik_ra"];
                    $progress->pu_berelasi = (int) $data_response["pu_berelasi"];
                    $progress->pu_ketiga = (int) $data_response["pu_ketiga"];
                    $progress->ra_bl = (int) $data_response["ra_bl"];
                    $progress->ri_bl = (int) $data_response["ri_bl"];
                    $progress->ra_btl = (int) $data_response["ra_btl"];
                    $progress->ri_btl = (int) $data_response["ri_btl"];
                    $progress->ri_pdpk = (int) $data_response["ri_pdpk"];
                    $progress->bdd = (int) $data_response["bdd"];
                    $progress->persekot = (int) $data_response["persekot"];
                    $progress->laba_kotor_ra = (int) $data_response["laba_kotor_ra"];
                    $progress->piutang = (int) $data_response["piutang"];
                    $progress->tagbrut = (int) $data_response["tagbrut"];
                    $progress->periode = $str_current;
                } else {
                    $progress = new ProyekProgress();
                    $progress->kode_proyek = $kode_proyek;
                    $progress->kode_spk = $kode_spk;
                    $progress->ok_review = (int)$data_response["ok_review"];
                    $progress->progress_fisik_ri = (int)$data_response["progress_fisik_ri"];
                    $progress->lama_proyek = $data_response["lamaproyek"];
                    $progress->laba_kotor_ri = (int)$data_response["laba_kotor_ri"];
                    $progress->progress_fisik_ra = (int) $data_response["progress_fisik_ra"];
                    $progress->pu_berelasi = (int) $data_response["pu_berelasi"];
                    $progress->pu_ketiga = (int) $data_response["pu_ketiga"];
                    $progress->ra_bl = (int) $data_response["ra_bl"];
                    $progress->ri_bl = (int) $data_response["ri_bl"];
                    $progress->ra_btl = (int) $data_response["ra_btl"];
                    $progress->ri_btl = (int) $data_response["ri_btl"];
                    $progress->ri_pdpk = (int) $data_response["ri_pdpk"];
                    $progress->bdd = (int) $data_response["bdd"];
                    $progress->persekot = (int) $data_response["persekot"];
                    $progress->laba_kotor_ra = (int) $data_response["laba_kotor_ra"];
                    $progress->piutang = (int) $data_response["piutang"];
                    $progress->tagbrut = (int) $data_response["tagbrut"];
                    $progress->periode = $str_current;
                    // dd($progress);
                }
                if ($progress->save() && $newCsi->save() && $proyek->save()) {
                    // Alert::success             
                    $status = [
                        'kode_proyek' => $kode_proyek,
                        'periode' => $str_current,
                        'status' => 'SUCCESS',
                        'progress' => $calculate_progress,
                        'dataPIS' => $data_response,
                    ];
                    return $this->setLogging("Get_Progress_PIS", "[Progress=>" . $kode_proyek . '=>' . $calculate_progress . ']', $status);
                    // Alert::success('Success', "Berhasil, Progress Didapatkan");
                    // return redirect()->back();
                }

                // Alert::error("Error", "Progress Gagal Didapatkan, Hubungi Admin !");
                // return redirect()->back();

                $status = [
                    'kode_proyek' => $kode_proyek,
                    'periode' => $str_current,
                    'status' => 'FAILED',
                    'progress' => $calculate_progress,
                    'dataPIS' => $response
                ];

                return $this->setLogging("Get_Progress_PIS", "[Progress=>" . $kode_proyek . '=>' . $calculate_progress . ']', $status);

                // dd($data);
            }
            // return response()->json($response->json(["link" => true]), 200);

        }

        // Alert::error("Error", "Progress gagal didapatkan karena Nomor SPK belum ada, Hubungi Admin !");
        // return redirect()->back();

        $status = [
            'kode_proyek' => $kode_proyek,
            'periode' => $str_current,
            'status' => 'NOMOR SPK TIDAK ADA'
        ];

        return $this->setLogging("Get_Progress_PIS", "[Progress=>" . $kode_proyek . '=>' . '-' . ']', $status);
    }

    public function loopingGetProgress()
    {
        $unit_kerja = UnitKerja::select('divcode')->where('dop', '!=', 'EA')->get();
        $unit_kerja_filter = $unit_kerja->map(function ($unit) {
            return $unit->divcode;
        })->toArray();
        $proyeks = Proyek::join('proyek_berjalans', 'proyek_berjalans.kode_proyek', '=', 'proyeks.kode_proyek')->where('kode_spk', '!=', null)->whereIn('proyeks.unit_kerja', $unit_kerja_filter)->where('proyeks.stage', '=', 8)->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true)->get();
        // dd($proyeks);

        return $proyeks->map(function ($proyek) {
            $this->createCsi($proyek->kode_proyek, $proyek->kode_spk, $proyek->id_customer);
        });
    }

    function setLogging($file, $message, $data)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/$file.log"),
        ])->info("$message", $data);
    }





    //---------------------------------//
    // Begin Master Data
    //---------------------------------//

    /**
     * Master Data Pertanyaan
     */
    public function MasterDataPertanyaanCSIIndex(Request $request)
    {
        $masterPertanyaanCsi = CsiMasterPertanyaan::all();
        $masterKategoriPertanyaan = CsiMasterKategoriPertanyaan::select(['code', 'kategori'])->where('is_active', true)->orderBy('posisi')->get();
        $masterGroupParentPertanyaan = CsiMasterGroupParentPertanyaan::select(['code', 'kategori'])->where('is_active', true)->get();
        return view('Csi.masterData.master_pertanyaan', ['data' => $masterPertanyaanCsi, "masterKategori" => $masterKategoriPertanyaan, "masterParent" => $masterGroupParentPertanyaan]);
    }

    /**
     * Get Master Data Pertanyaan
     */
    public function MasterDataPertanyaanCSIGetData($id)
    {
        try {
            $masterPertanyaan = CsiMasterPertanyaan::with(['CsiMasterKategoriPertanyaan', 'CsiMasterGroupParentPertanyaan'])->where('id', $id)->first();
            $masterKategoriPertanyaan = CsiMasterKategoriPertanyaan::select(['code', 'kategori'])->where('is_active', true)->orderBy('posisi')->get();
            $masterGroupParentPertanyaan = CsiMasterGroupParentPertanyaan::select(['code', 'kategori'])->where('is_active', true)->get();

            $masterGroupSubParentPertanyaan = [
                "Kepentingan",
                "Kepuasan"
            ];

            $masterPilihanInput = [
                "pilihan",
                "text"
            ];

            $masterJumlahInput = [1, 2, 3, 4, 5];

            $masterKategoriJawaban = [
                "Sangat Penting / Sangat Tidak Penting",
                "Sangat Puas / Sangat Tidak Puas",
                "Sangat Setuju / Sangat Tidak Setuju",
                "Lebih Baik / Sama / Lebih Buruk",
                "Ya / Tidak",
            ];

            // $data = [];

            // $data[] = [
            //     'data' => $masterPertanyaan,
            //     'masterKategoriPertanyaan' => $masterKategoriPertanyaan,
            //     'masterGroupParentPertanyaan' => $masterGroupParentPertanyaan,
            //     'masterGroupSubParentPertanyaan' => collect($masterGroupSubParentPertanyaan),
            //     'masterPilihanInput' => collect($masterPilihanInput),
            //     'masterJumlahInput' => collect($masterJumlahInput),
            //     'masterPilihanInput' => collect($masterPilihanInput),
            // ];

            if (empty($masterPertanyaan)) {
                $response = [
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                    'data' => []
                ];
            } else {
                $response = [
                    'success' => true,
                    'message' => 'Success',
                    'data' => [
                        'masterPertanyaan' => $masterPertanyaan,
                        'masterKategoriPertanyaan' => $masterKategoriPertanyaan,
                        'masterGroupParentPertanyaan' => $masterGroupParentPertanyaan,
                        'masterGroupSubParentPertanyaan' => collect($masterGroupSubParentPertanyaan),
                        'masterPilihanInput' => collect($masterPilihanInput),
                        'masterJumlahInput' => collect($masterJumlahInput),
                        'masterKategoriJawaban' => collect($masterKategoriJawaban),
                    ],
                ];
            }
            return response()->json([$response]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Tambah Master Data Pertanyaan
     */
    public function MasterDataPertanyaanCSINew(Request $request)
    {
        try {
            $data = $request->all();

            $rules = [
                'start-periode' => 'required|date',
                'kategori' => 'required|string',
                // 'parent' => 'string',
                // 'sub-parent' => 'string',
                'pertanyaan-indonesia' => 'required|string',
                'pertanyaan-inggris' => 'required|string',
                'tipe-input' => 'required|string',
                'jumlah-pilihan' => 'integer',
                'pilihan-jawaban' => 'required|string',
                'bobot' => 'required|integer',
                'posisi' => 'required|integer',
                // 'is-active' => 'required|boolean',
                // 'finish-periode' => 'date',
            ];

            $validateInput = validateInput($data, $rules);

            if (!empty($validateInput)) {
                Alert::html("Error", "Field <b>$validateInput</b> harus terisi!", "error");
                return redirect()->back()->withInput()->with("modal", $data["modal"]);
            }

            $masterPertanyaan = new CsiMasterPertanyaan();
            $masterPertanyaan->start_periode = $data['start-periode'];
            $masterPertanyaan->kategori = $data['kategori'];
            $masterPertanyaan->parent = $data['parent'];
            $masterPertanyaan->sub_parent = $data['sub-parent'];
            $masterPertanyaan->pertanyaan_indonesia = $data['pertanyaan-indonesia'];
            $masterPertanyaan->pertanyaan_inggris = $data['pertanyaan-inggris'];
            $masterPertanyaan->tipe_input = $data['tipe-input'];
            $masterPertanyaan->jumlah_pilihan = $data['jumlah-pilihan'];
            $masterPertanyaan->pilihan_jawaban = $data['pilihan-jawaban'];
            $masterPertanyaan->bobot = $data['bobot'];
            $masterPertanyaan->posisi = $data['posisi'];
            $masterPertanyaan->is_active = isset($data['is-active']) ? true : false;
            $masterPertanyaan->finish_periode = $data['finish-periode'];

            if ($masterPertanyaan->save()) {
                Alert::success('Success', 'Data Berhasil Disimpan');
                return redirect()->back();
            }
            Alert::error('Terjadi Kesalahan!', 'Data Gagal Disimpan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Terjadi Kesalahan!', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update Master Data Pertanyaan
     */
    public function MasterDataPertanyaanCSIUpdate(Request $request, $id)
    {
        try {
            $data = $request->all();

            $rules = [
                'start-periode' => 'required|date',
                'kategori' => 'required|string',
                // 'parent' => 'string',
                // 'sub-parent' => 'string',
                'pertanyaan-indonesia' => 'required|string',
                'pertanyaan-inggris' => 'required|string',
                'tipe-input' => 'required|string',
                'jumlah-pilihan' => 'integer',
                'pilihan-jawaban' => 'required|string',
                'bobot' => 'required|integer',
                'posisi' => 'required|integer',
                // 'is-active' => 'required|boolean',
                // 'finish-periode' => 'date',
            ];

            $validateInput = validateInput($data, $rules);

            if (!empty($validateInput)) {
                Alert::html("Error", "Field <b>$validateInput</b> harus terisi!", "error");
                return redirect()->back()->withInput()->with("modal", $data["modal"]);
            }

            $masterPertanyaan = CsiMasterPertanyaan::find($id);

            if (empty($masterPertanyaan)) {
                Alert::error('Error', "Data tidak ditemukan!");
                return redirect()->back();
            }

            $masterPertanyaan->start_periode = $data['start-periode'];
            $masterPertanyaan->kategori = $data['kategori'];
            $masterPertanyaan->parent = $data['parent'];
            $masterPertanyaan->sub_parent = $data['sub-parent'];
            $masterPertanyaan->pertanyaan_indonesia = $data['pertanyaan-indonesia'];
            $masterPertanyaan->pertanyaan_inggris = $data['pertanyaan-inggris'];
            $masterPertanyaan->tipe_input = $data['tipe-input'];
            $masterPertanyaan->jumlah_pilihan = $data['jumlah-pilihan'];
            $masterPertanyaan->pilihan_jawaban = $data['pilihan-jawaban'];
            $masterPertanyaan->bobot = $data['bobot'];
            $masterPertanyaan->posisi = $data['posisi'];
            $masterPertanyaan->is_active = isset($data['is-active']) ? true : false;
            $masterPertanyaan->finish_periode = !isset($data['is-active']) ? $data['finish-periode'] : '';

            if ($masterPertanyaan->save()) {
                Alert::success('Success', 'Data Berhasil Disimpan');
                return redirect()->back();
            }
            Alert::error('Terjadi Kesalahan!', 'Data Gagal Disimpan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Terjadi Kesalahan!', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Delete Master Data Pertanyaan
     */
    public function MasterDataPertanyaanCSIDelete(Request $request)
    {
        $data = CsiMasterPertanyaan::find($request->get('id'));
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => "Data gagal dihapus. Mohon Hubungi Admin!"
            ]);
        }

        if ($data->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Data Berhasil Dihapus"
            ]);
        }
    }

    /**
     * Master Data Tingkat Kepuasan
     */
    public function MasterDataTingkatKepuasanCSIIndex(Request $request)
    {
        $masterTingkatKepuasanCsi = CsiMasterTingkatKepuasan::all();
        return view('Csi.masterData.master_tingkat_kepuasan', ['data' => $masterTingkatKepuasanCsi]);
    }

    /**
     * Get Master Data Tingkat Kepuasan
     */
    public function MasterDataTingkatKepuasanGetData($id)
    {
        try {
            $data = CsiMasterTingkatKepuasan::find($id);
            $kategori = [
                'Tidak Puas / Not Satisfied',
                'Kurang Puas / Less Satisfied',
                'Cukup Puas / Quiet Satisfied',
                'Puas / Satisfied',
                'Sangat Puas / Very Satisfied',
            ];
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => [
                    'data' => $data,
                    'kategori' => $kategori

                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Tambah Master Data Tingkat Kepuasan
     */
    public function MasterDataTingkatKepuasanCSINew(Request $request)
    {
        try {
            $data = $request->all();

            $rules = [
                'start-periode' => 'required|date',
                'kategori' => 'required|string',
                'dari-nilai' => 'required|integer',
                'sampai-nilai' => 'required|integer',
                // 'finish-periode' => 'date',
                // 'is-active' => 'required|boolean',
            ];

            $validateInput = validateInput($data, $rules);

            if (!empty($validateInput)) {
                Alert::html("Error", "Field <b>$validateInput</b> harus terisi!", "error");
                return redirect()->back()->withInput()->with("modal", $data["modal"]);
            }

            $masterTingkatKepuasan = new CsiMasterTingkatKepuasan();
            $masterTingkatKepuasan->start_periode = $data['start-periode'];
            $masterTingkatKepuasan->kategori = $data['kategori'];
            $masterTingkatKepuasan->dari = $data['dari-nilai'];
            $masterTingkatKepuasan->sampai = $data['sampai-nilai'];
            $masterTingkatKepuasan->is_active = isset($data['is-active']) ? true : false;
            $masterTingkatKepuasan->finish_periode = $data['finish-periode'];

            if ($masterTingkatKepuasan->save()) {
                Alert::success('Success', 'Data Berhasil Disimpan');
                return redirect()->back();
            }
            Alert::error('Terjadi Kesalahan!', 'Data Gagal Disimpan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Terjadi Kesalahan!', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update Master Data Tingkat Kepuasan
     */
    public function MasterDataTingkatKepuasanCSIUpdate(Request $request, $id)
    {
        try {
            $data = $request->all();

            $rules = [
                'start-periode' => 'required|date',
                'kategori' => 'required|string',
                'dari-nilai' => 'required|integer',
                'sampai-nilai' => 'required|integer',
                // 'finish-periode' => 'date',
                // 'is-active' => 'required|boolean',
            ];

            $validateInput = validateInput($data, $rules);

            if (!empty($validateInput)) {
                Alert::html("Error", "Field <b>$validateInput</b> harus terisi!", "error");
                return redirect()->back()->withInput()->with("modal", $data["modal"]);
            }

            $masterTingkatKepuasan = CsiMasterTingkatKepuasan::find($id);

            if (empty($masterTingkatKepuasan)) {
                Alert::error('Error', "Data tidak ditemukan!");
                return redirect()->back();
            }

            $masterTingkatKepuasan->start_periode = $data['start-periode'];
            $masterTingkatKepuasan->kategori = $data['kategori'];
            $masterTingkatKepuasan->dari = $data['dari-nilai'];
            $masterTingkatKepuasan->sampai = $data['sampai-nilai'];
            $masterTingkatKepuasan->is_active = isset($data['is-active']) ? true : false;
            $masterTingkatKepuasan->finish_periode = $data['finish-periode'];

            if ($masterTingkatKepuasan->save()) {
                Alert::success('Success', 'Data Berhasil Disimpan');
                return redirect()->back();
            }
            Alert::error('Terjadi Kesalahan!', 'Data Gagal Disimpan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Terjadi Kesalahan!', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Delete Master Data Tingkat Kepuasan
     */
    public function MasterDataTingkatKepuasanCSIDelete(Request $request)
    {
        $data = CsiMasterTingkatKepuasan::find($request->get('id'));
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => "Data gagal dihapus. Mohon Hubungi Admin!"
            ]);
        }

        if ($data->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Data Berhasil Dihapus"
            ]);
        }
    }

}
