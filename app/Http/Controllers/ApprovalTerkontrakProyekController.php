<?php

namespace App\Http\Controllers;

use App\Class\sendNotification;
use App\Models\ApprovalTerkontrakProyek;
use App\Models\Forecast;
use App\Models\MatriksApprovalTerkontrakProyek;
use App\Models\ProyekBerjalans;
use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ApprovalTerkontrakProyekController extends Controller
{
    private $isNomorTargetActive;
    private $matriks_user;

    public function __construct()
    {
        $this->isNomorTargetActive = env("IS_SEND_EMAIL");
    }

    public function index()
    {
        $this->matriks_user = !Auth::user()->check_administrator ? Auth::user()->Pegawai->MatriksTerkontrakProyek->where("is_active", true) : MatriksApprovalTerkontrakProyek::where("is_active", true)->get();

        if ($this->matriks_user->isNotEmpty()) {
            $isCanApprove = !empty(Auth::user()->Pegawai?->MatriksTerkontrakProyek?->where("is_active", true));
            $unitKerja = $this->matriks_user->map(function ($item) {
                return $item->unit_kerja;
            })->toArray();
        } else {
            $isCanApprove = false;
            $unitKerja = Gate::denies('super-admin') ? explode(',', Auth::user()->unit_kerja) : UnitKerja::get("divcode")->toArray();
        }

        $proyeks = ApprovalTerkontrakProyek::whereIn("unit_kerja", $unitKerja)->get();

        return view("25_Approval_Proyek_Terkontrak", compact("isCanApprove", "proyeks"));
    }

    public function requestApproval(Request $request, Proyek $proyek)
    {
        try {

            $matriks_approve = MatriksApprovalTerkontrakProyek::where('unit_kerja', $proyek->unit_kerja)->get();

            if ($matriks_approve->isEmpty()) {
                return response()->json([
                    "Success" => false,
                    "Message" => "Matriks Belum Ditentukan. Hubungi Admin!"
                ]);
            }

            $isExistApproval = $proyek->ApprovalTerkontrakProyek;

            if ($isExistApproval) {
                $isExistApproval->request_by = Auth::user()->nip;
                $isExistApproval->request_on = Carbon::now();
                $isExistApproval->is_revisi = null;
                if ($isExistApproval->save()) {
                    foreach ($matriks_approve as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/approval-terkontrak-proyek?open=kt_modal_approve_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan hasil revisi approval Proyek CRM Terkontrak untuk proyek " . $proyek->nama_proyek . "\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Revisi Approval Proyek CRM Terkontrak", nl2br($message), $this->isNomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }

                        $sendNotification = new sendNotification();
                        $sendNotification->sendNotificationFirebase($target->Pegawai->nip, "Approval", "Terkontrak", $proyek->kode_proyek, "Pengajuan", "revisi");
                    }

                    return response()->json([
                        "Success" => true,
                        "Message" => "Proyek berhasil diajukan"
                    ]);
                    // Alert::success("Success", "Proyek berhasil diajukan");
                    // return redirect()->back();
                }
            } else {
                $newRequest = new ApprovalTerkontrakProyek();
                $newRequest->kode_proyek = $proyek->kode_proyek;
                $newRequest->unit_kerja = $proyek->unit_kerja;
                $newRequest->is_request_approval = true;
                $newRequest->request_by = Auth::user()->nip;
                $newRequest->request_on = Carbon::now();

                if ($newRequest->save()) {
                    foreach ($matriks_approve as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/approval-terkontrak-proyek?open=kt_modal_approve_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Approval Proyek CRM Terkontrak untuk proyek " . $proyek->nama_proyek . "\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Approval Proyek CRM Terkontrak", nl2br($message), $this->isNomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }

                        $sendNotification = new sendNotification();
                        $sendNotification->sendNotificationFirebase($target->Pegawai->nip, "Approval", "Terkontrak", $proyek->kode_proyek, "Pengajuan", "approve");
                    }

                    return response()->json([
                        "Success" => true,
                        "Message" => "Proyek berhasil diajukan"
                    ]);
                    // Alert::success("Success", "Proyek berhasil diajukan");
                    // return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            throw $e;
            return response()->json([
                "Success" => true,
                "Message" => $e->getMessage()
            ]);
            // Alert::error("Error", $e->getMessage());
            // return redirect()->back();
        }
    }

    public function setApproval(Request $request, Proyek $proyek)
    {
        try {
            DB::beginTransaction();
            $this->matriks_user = !Auth::user()->check_administrator ? Auth::user()->Pegawai->MatriksTerkontrakProyek->where("is_active", true) : MatriksApprovalTerkontrakProyek::where("is_active", true)->get();

            if ($this->matriks_user->isEmpty()) {
                Alert::error("Error", "Anda tidak dapat melakukan approval. Silahkan hubungi Admin");
                return redirect()->back();
            }

            $actionSelected = $request->get("button-selected");

            $proyekApprovalSelected = ApprovalTerkontrakProyek::where("kode_proyek", $proyek->kode_proyek)->first();
            if (empty($proyekApprovalSelected)) {
                Alert::error("Error", "Terjadi Kesalahan. Hubungi Admin!");
                return redirect()->back();
            }
            $selectPicCrm = Pegawai::where("nip", $proyekApprovalSelected->request_by)->first();

            if (empty($proyek->nilai_perolehan)) {
                Alert::error("Error", "Nilai Perolehan belum diisi. Periksa Kembali");
                return redirect()->back();
            }

            if ($actionSelected == "approved") {
                $proyekApprovalSelected->is_approved = true;
                $proyekApprovalSelected->approved_by = Auth::user()->nip;
                $proyekApprovalSelected->approved_on = Carbon::now();
                $proyekApprovalSelected->is_request_approval = false;

                if ($proyekApprovalSelected->save()) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $selectPicCrm->nip . "&redirectTo=/approval-terkontrak-proyek";
                    $message = "Yth Bapak/Ibu " . $selectPicCrm->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan Approval Proyek CRM Terkontrak untuk proyek " . $proyek->nama_proyek . " telah disetujui.\nSilahkan tekan link di bawah ini untuk melihatnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($selectPicCrm, "Pemberitahuan Approval Proyek CRM Terkontrak", nl2br($message), $this->isNomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                    
                    $getTanggalRequest = Carbon::create($proyekApprovalSelected->request_on);
                    $bulans = $getTanggalRequest->month;
                    $years = $getTanggalRequest->year;

                    // if (!empty($proyek->bulan_ri_perolehan) && !empty($proyek->nilai_perolehan) && $proyek->stage == 8 && $proyek->is_need_approval_terkontrak && $proyek->tahun_perolehan == $years) {
                    //     $editForecast = Forecast::where("kode_proyek", "=", $proyek->kode_proyek)->where("periode_prognosa", "=", $bulans)->where("tahun", "=", $years)->first();
                    //     if (!empty($editForecast)) {
                    //         $oldestForecast = Forecast::where("kode_proyek", "=", $proyek->kode_proyek)->where("periode_prognosa", "=", ($bulans - 1))->where("tahun", "=", $years)->first();
                    //         if (!empty($oldestForecast) && (int) date("d") <= 15) {
                    //             // $oldestForecast = new Forecast();
                    //             $oldestForecast->kode_proyek = $proyek->kode_proyek;
                    //             $oldestForecast->periode_prognosa = $bulans - 1;
                    //             $oldestForecast->tahun = $years;
                    //             $oldestForecast->nilai_forecast = (int) str_replace('.', '', $proyek->nilai_perolehan);
                    //             $oldestForecast->realisasi_forecast = (int) str_replace('.', '', $proyek->nilai_perolehan);
                    //             $oldestForecast->month_realisasi = (int) $proyek->bulan_ri_perolehan;
                    //             $oldestForecast->save();
                    //         }
                    //         $editForecast->nilai_forecast = (int) str_replace('.', '', $proyek->nilai_perolehan);
                    //         $editForecast->realisasi_forecast = (int) str_replace('.', '', $proyek->nilai_perolehan);
                    //         $editForecast->month_realisasi = (int) $proyek->bulan_ri_perolehan;
                    //         $editForecast->save();
                    //     } else {
                    //         $newForecast = new Forecast();
                    //         $newForecast->kode_proyek = $proyek->kode_proyek;
                    //         $newForecast->month_forecast = $proyek->bulan_ri_perolehan;
                    //         $newForecast->nilai_forecast = (int) str_replace('.', '', $proyek->nilai_perolehan);
                    //         $newForecast->month_realisasi = $proyek->bulan_ri_perolehan;
                    //         $newForecast->realisasi_forecast = (int) str_replace('.', '', $proyek->nilai_perolehan);
                    //         $newForecast->periode_prognosa = $bulans;
                    //         $newForecast->tahun = (int) date("Y");
                    //         $newForecast->save();
                    //     }
                    // }
                    $generateDataNasabahOnline = self::generateNasabahOnline($proyek);
                    if ($proyek->UnitKerja->dop != "EA" && env("APP_ENV") == "production") {
                        dd("TES");
                        // self::sendDataNasabahOnline($generateDataNasabahOnline);
                    }
                    // $proyekBerjalan = ProyekBerjalans::where('kode_proyek', $proyek->kode_proyek)->first();
                    // $proyekBerjalan->stage = 8;
                    $proyek->is_need_approval_terkontrak = false;
                    $proyek->save();
                    $sendNotification = new sendNotification();
                    $sendNotification->sendNotificationFirebase($selectPicCrm->nip, "Approval", "Terkontrak", $proyek->kode_proyek, "Persetujuan", "approve");
                    // $proyekBerjalan->save();
                }
                DB::commit();
                Alert::success("Success", "Proyek berhasil disetujui");
                return redirect()->back();
            } else {
                if (empty($request->get("revisi-note"))) {
                    Alert::error("Gagal", "Catatan Revisi wajib diisi");
                    return redirect()->back();
                }

                $proyekApprovalSelected->is_revisi = true;
                $proyekApprovalSelected->revisi_by = Auth::user()->nip;
                $proyekApprovalSelected->revisi_on = Carbon::now();
                $proyekApprovalSelected->revisi_note = $request->get("revisi-nota");

                if ($proyekApprovalSelected->save()) {
                    $selectPicCrm = Pegawai::where("nip", $proyekApprovalSelected->request_by)->first();
                    $url = $request->schemeAndHttpHost() . "?nip=" . $selectPicCrm->nip . "&redirectTo=/proyek/view/$proyekApprovalSelected->kode_proyek";
                    $message = "Yth Bapak/Ibu " . $selectPicCrm->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan Revisi Approval Proyek CRM Terkontrak untuk proyek " . $proyek->nama_proyek . ".\nSilahkan tekan link di bawah ini untuk melihatnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($selectPicCrm, "Pemberitahuan Revisi Approval Proyek CRM Terkontrak", nl2br($message), $this->isNomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                    $sendNotification = new sendNotification();
                    $sendNotification->sendNotificationFirebase($selectPicCrm->nip, "Approval", "Terkontrak", $proyek->kode_proyek, "Persetujuan", "revisi");
                }
                DB::commit();
                Alert::success("Success", "Proyek berhasil diajukan revisi");
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }


    private function generateNasabahOnline($proyek)
    {
        $customer = $proyek->proyekBerjalan->customer;

        $sap = $customer->sap;
        $pic = $customer->pic->filter(function ($p) {
            return (!empty($p->nama_pic) && !empty($p->jabatan_pic) && !empty($p->email_pic) && !empty($p->phone_pic));
        })->first();

        $provinsi = Provinsi::where("province_name", "=", $customer->provinsi)->first() ?? Provinsi::find($customer->provinsi);
        if (empty($provinsi)) {
            Alert::html("Error", "Pastikan <b>Provinsi</b> pada Field <b>Pelanggan</b> sudah terisi!", "error")->autoClose(10000);
            return redirect()->back();
        }
        // dd($customer);
        $grouping = "";
        $kdgrp = "";
        $ktgrd = "";
        $cust_akont = "";
        $witht = "";
        if ($customer->jenis_instansi == "Kementrian / Pemerintah Pusat" || $customer->jenis_instansi == "Pemerintah Provinsi" || $customer->jenis_instansi == "Pemerintah Kota / Kabupaten") {
            $kdgrp = "03";
            $grouping = "ZN01";
            $ktgrd = "Z1";
            $cust_akont = "1104111000";
            $witht = "J7";
        } else if ($customer->jenis_instansi == "BUMN") {
            $kdgrp = "04";
            $grouping = "ZN01";
            $ktgrd = "Z1";
            $cust_akont = "1104111000";
            $witht = "J7";
        } else if ($customer->jenis_instansi == "BUMD" || $customer->jenis_instansi == "Swasta Nasional") {
            $kdgrp = "05";
            $grouping = "ZN02";
            $ktgrd = "Z2";
            $cust_akont = "1104211000";
            $witht = "J7";
        } else if ($customer->jenis_instansi == "Pemerintah Asing" || $customer->jenis_instansi == "Swasta Asing") {
            $kdgrp = "06";
            $grouping = "ZN02";
            $ktgrd = "Z2";
            $cust_akont = "1104211000";
            $witht = "J7";
        } else if ($customer->jenis_instansi == "Perusahaan JO") {
            $kdgrp = "08";
            $grouping = "ZN05";
            $ktgrd = "Z4";
            $cust_akont = "";
            $witht = "";
        }

        $alamat = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $customer->address_1), 0, 255);

        $data_nasabah_online = collect([
            "nmnasabah" => "$customer->name",
            "alamat" => "$alamat",
            "kota" => "$customer->kota_kabupaten",
            "email" => "$customer->email",
            "ext" => "-",
            "telepon" => "$customer->phone_number",
            "fax" => "$customer->fax",
            "npwp" => "$customer->npwp_company",
            "nama_kontak" => $pic->nama_pic ?? "",
            "jenisperusahaan" => "$customer->jenis_instansi",
            "jabatan" => $pic->jabatan_pic ?? "",
            "email1" => $pic->email_pic ?? "",
            "telpon1" => $pic->phone_pic ?? "",
            "handphone" => $pic->phone_pic ?? "",
            "tipe_perusahaan" => "$customer->jenis_perusahaan",
            "tipe_lain_perusahaan" => "-",
            "cotid" => "11",
            "dtsap" => [
                [
                    "devid" => "YMMI002",
                    "packageid" => $this->GUID(),
                    "cocode" => "A000",
                    "prctr" => "",
                    // "timestamp" => "20221013100000",
                    "timestamp" => date("y") . date("m") . date("d") . "10000",
                    "data" => [
                        [
                            "BPARTNER" => "$customer->kode_nasabah",

                            "GROUPING" => "$grouping",

                            "LVORM" => "",

                            "TITLE" => "Z001",

                            "NAME" => "$customer->name",

                            "TITLELETTER" => "",

                            "SEARCHTERM1" => substr($customer->name, 0, 40) ?? "",

                            "SEARCHTERM2" => substr($customer->name, 0, 40) ?? "",

                            "STREET" => $sap->street ?? "",

                            "HOUSE_NO" => "",

                            "POSTL_COD1" => "$customer->kode_pos",

                            "CITY" => explode("-", $provinsi->province_id)[1],

                            // "ADDR_COUNTRY" => $provinsi->country_id ?? "ID",
                            "ADDR_COUNTRY" => "ID",

                            "REGION" => explode("-", $provinsi->province_id)[1],

                            "PO_BOX" => "",

                            "POSTL_COD3" => "",

                            "LANGU" => "E",

                            "TELEPHONE" => "$customer->phone_number",

                            "PHONE_EXTENSION" => "",

                            "MOBPHONE" => "$customer->handphone",

                            "FAX" => "$customer->fax",

                            "FAX_EXTENSION" => "",

                            "E_MAIL" => "$customer->email",

                            "VALIDFROMDATE" => now()->translatedFormat("d-m-Y"),

                            "VALIDTODATE" => now()->addMonths(5)->translatedFormat("d-m-Y"),

                            "IDENTIFICATION" => [
                                [

                                    // "TAXTYPE" => "$sap->tax_number_category",
                                    "TAXTYPE" => $provinsi->country_id == "ID" ? "ID1" : "ID2",

                                    "TAXNUMBER" => "$customer->npwp_company"
                                ]
                            ],

                            "BANK" => [
                                [
                                    "BANK_DET_ID" => "",

                                    "BANK_CTRY" => "",

                                    "BANK_KEY" => "CRM",

                                    "BANK_ACCT" => "",

                                    "BK_CTRL_KEY" => "",

                                    "BANK_REF" => "",

                                    "EXTERNALBANKID" => "",

                                    "ACCOUNTHOLDER" => "",

                                    "BANKACCOUNTNAME" => ""
                                ]
                            ],

                            "CUST_BUKRS" => "",

                            "KUNNR" => "",

                            "CUST_AKONT" => "$cust_akont",

                            "CUST_C_ZTERM" => "$customer->syarat_pembayaran",

                            "CUST_WTAX" => [
                                [

                                    "WITHT" => "$witht",

                                    "WT_AGENT" => "",

                                    "WT_AGTDF" => "",

                                    "WT_AGTDT" => ""
                                ]
                            ],

                            "VKORG" => "",

                            "VTWEG" => "",

                            "SPART" => "",

                            "KDGRP" => "$kdgrp",

                            "CUST_WAERS" => "IDR",

                            "KALKS" => "",

                            "VERSG" => "",

                            "VSBED" => "",

                            "INCO1" => "",

                            "INCO2_L" => "",

                            "CUST_S_ZTERM" => "$customer->syarat_pembayaran",

                            "KTGRD" => "$ktgrd",

                            "TAXKD" => "$customer->tax",

                            "VEND_BUKRS" => "",

                            "LIFNR" => "",

                            "VEND_AKONT" => "",

                            "VEND_C_ZTERM" => "",

                            "REPRF" => "X",

                            "VEND_WTAX" => [[]],
                            // "VEND_WTAX" => [

                            //     "WITHT" => "J3",

                            //     "WT_SUBJCT" => "X"

                            // ],

                            "EKORG" => "",

                            "VEND_P_ZTERM" => "",

                            "WEBRE" => "",

                            "VEND_WAERS" => "",

                            "LEBRE" => "",

                            "BRAN2" => $customer->IndustrySector->id_industry_sector,
                        ]
                    ]
                ]
            ]
        ]);

        return $data_nasabah_online;
    }

    private function sendDataNasabahOnline($dataNasabah)
    {
        $namaNasabah = $dataNasabah["nmnasabah"];
        $nasabah_online_response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm", $dataNasabah)->json();
        setLogging("Send_Nasabah_Online", "[Nasabah Online => $namaNasabah] => ", $dataNasabah->toArray());
        if (!$nasabah_online_response["status"] && !str_contains($nasabah_online_response["msg"], "sudah ada dalam nasabah online")) {
            // integrationLog("SEND NASABAH ONLINE", $dataNasabah->toJson(), null, "FAIL", $nasabah_online_response["status"], $nasabah_online_response, null, $nasabah_online_response["msg"]);
            Alert::warning("Attention", $nasabah_online_response["msg"]);
            return redirect()->back();
        }

        // integrationLog("SEND NASABAH ONLINE", $dataNasabah->toJson(), null, "SUCCESS", $nasabah_online_response["status"], null, $nasabah_online_response);
    }

    private static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
