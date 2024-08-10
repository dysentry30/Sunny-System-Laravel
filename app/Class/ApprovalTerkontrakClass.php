<?php

namespace App\Class;

use App\Models\Provinsi;
use App\Models\Proyek;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ApprovalTerkontrakClass
{
    // public $proyek;
    public function __construct()
    {
    }

    public static function generateNasabahOnline(Proyek $proyek, $isMobile = false)
    {
        $customer = $proyek->proyekBerjalan->customer;
        $sap = $customer->sap;
        $pic = $customer->pic->filter(function ($p) {
            return (!empty($p->nama_pic) && !empty($p->jabatan_pic) && !empty($p->email_pic) && !empty($p->phone_pic));
        })->first();

        $provinsi = Provinsi::where("province_name", "=", $customer->provinsi)->first() ?? Provinsi::find($customer->provinsi);
        if (empty($provinsi)) {

            if ($isMobile) {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'message' => "Pastikan Provinsi pada Field Pelanggan sudah terisi!",
                    'data' => []
                ]);
            }

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
                    "packageid" => self::GUID(),
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

    public static function sendDataNasabahOnline($dataNasabah, $isMobile = false)
    {
        $namaNasabah = $dataNasabah["nmnasabah"];
        $nasabah_online_response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm", $dataNasabah)->json();
        setLogging("Send_Nasabah_Online", "[Nasabah Online => $namaNasabah] => ", $dataNasabah->toArray());
        if (!$nasabah_online_response["status"] && !str_contains($nasabah_online_response["msg"], "sudah ada dalam nasabah online")) {
            // integrationLog("SEND NASABAH ONLINE", $dataNasabah->toJson(), null, "FAIL", $nasabah_online_response["status"], $nasabah_online_response, null, $nasabah_online_response["msg"]);
            Alert::warning("Attention", $nasabah_online_response["msg"]);
            return redirect()->back();
        }
    }

    private static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
