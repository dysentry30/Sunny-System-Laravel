<?php

use App\Http\Controllers\ProyekController;
use App\Http\Controllers\UserController;
use App\Models\Customer;
use App\Models\Forecast;
use App\Models\Proyek;
use App\Models\ProyekBerjalans;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/proyek/save', function (Request $request) {
//     $data = $request->all();
//     dd($data);
// });
Route::middleware(["web"])->group(function () {

    // Begin Proyek
    Route::post('/proyek/save', [ProyekController::class, 'save'])->middleware("userAuth");
    // End Proyek

    // Begin Login / Logout
    Route::post('/login', [UserController::class, 'authen'])->middleware("userNotAuth");
    Route::post('/logout', [UserController::class, 'logout'])->middleware("userAuth");
    // End Login / Logout

    // Begin Detail Proyek yang ada forecast
    Route::post('/detail-proyek', function (Request $request) {
        $periode = getPeriode($request->periode);
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (isset($is_bpmcsrf_exist)) {

            // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
            // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
            if (isset($request->unitkerjaid)) {
                // $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->where("bulan_pelaksanaan", "=", $periode[1])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"]);
                $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"])->filter(function ($p) use ($periode) {
                    $is_forecast_exist = $p->Forecasts->where("periode_prognosa", $periode[1])->count() > 0;
                    unset($p->Forecasts);
                    return $is_forecast_exist;
                });
            } else {
                return response()->json([
                    "status" => 400,
                    "msg" => "Unit Kerja Not Found"
                ], 400);
            }
            $proyeks = $proyeks->map(function ($p) use ($request) {
                if (str_contains($p->kode_proyek, "KD")) {
                    $p->kode_crm = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
                } else {
                    $p->kode_crm = $p->kode_proyek;
                }
                $p->nama_proyek = $p->nama_proyek;
                $p->departemen_id = $p->unit_kerja;
                $p->ap_id = "";
                switch ($p->jenis_proyek) {
                    case "I":
                        $p->jenis = "Internal";
                        break;
                    case "N":
                        $p->jenis = "Eksternal";
                        break;
                    case "J":
                        $p->jenis = "JO";
                        break;
                }
                $p->kategori = "PROYEK";

                switch ($p->stage) {
                    case 0:
                        $p->tahap = "Pasar Dini";
                        break;
                    case 1:
                        $p->tahap = "Pasar Dini";
                        break;
                    case 2:
                        $p->tahap = "Pasar Potensial";
                        break;
                    case 3:
                        $p->tahap = "Prakualifikasi";
                        break;
                    case 4:
                        $p->tahap = "Tender Diikuti";
                        break;
                    case 5:
                        $p->tahap = "Perolehan";
                        break;
                    case 6:
                        $p->tahap = "Menang";
                        break;
                    case 7:
                        $p->tahap = "Terendah";
                        break;
                    case 8:
                        $p->tahap = "Terkontrak";
                        break;
                }
                // dd($p->tanggal_mulai_terkontrak, $p->tanggal_akhir_terkontrak);
                $p->pemberi_kerja = ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first()->name_customer ?? "";
                $p->rencana_perolehan = null;
                $p->perkiraan_durasi = date_create($p->tanggal_mulai_terkontrak)->diff(date_create($p->tanggal_akhir_terkontrak))->days;
                $p->periode = $request->periode;
                unset($p->jenis_proyek, $p->unit_kerja, $p->kode_proyek, $p->stage, $p->tanggal_mulai_terkontrak, $p->tanggal_akhir_terkontrak);

                return $p;
            });
            $data = [
                "GetDetailProyekResult" => [
                    "Success" => true,
                    "Message" => null,
                    "TotalData" => $proyeks->count(),
                    "Data" => $proyeks,
                ],

            ];
            return response()->json($data);
        }
        return response()->json([
            "status" => 401,
            "msg" => "Tidak Terautentikasi"
        ]);
    })->middleware("userAuth");

    // Begin Detail Proyek yang ada forecast
    Route::post('/detail-proyek-xml', function (Request $request) {
        $periode = getPeriode($request->periode);
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (isset($is_bpmcsrf_exist)) {
            // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
            // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
            if (isset($request->unitkerjaid)) {
                // $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->where("bulan_pelaksanaan", "=", $periode[1])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"]);
                $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak"])->filter(function ($p) use ($periode) {
                    $is_forecast_exist = $p->Forecasts->where("periode_prognosa", $periode[1])->count() > 0;
                    unset($p->Forecasts);
                    return $is_forecast_exist;
                });
            } else {
                return response()->json([
                    "status" => 400,
                    "msg" => "Unit Kerja Not Found"
                ], 400);
            }

            $proyeks = $proyeks->map(function ($p) use ($request) {
                $p->Id = $p->id;
                if (str_contains($p->kode_proyek, "KD")) {
                    $p->UsrKodeProyek = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
                } else {
                    $p->UsrKodeProyek = $p->kode_proyek;
                }
                $p->Title = $p->nama_proyek;
                // $p->ap_id = "";
                switch ($p->jenis_proyek) {
                    case "I":
                        $p->UsrJenis = "Internal";
                        break;
                    case "N":
                        $p->UsrJenis = "Eksternal";
                        break;
                    case "J":
                        $p->UsrJenis = "JO";
                        break;
                }
                $p->UsrKontrakMulai = $p->tanggal_mulai_terkontrak;
                $p->UsrAkhirKontrak = $p->tanggal_akhir_terkontrak;
                $p->UsrNoSPK = $p->nospk_external;
                $p->UsrBASTPHO = $p->tanggal_selesai_pho;
                $p->UsrBASTFHO = $p->tanggal_selesai_fho;
                $p->UsrPorsi = $p->porsi_jo;
                $p->UsrNilaiKontrak = $p->nilai_perolehan;
                $p->UsrKlasifikasiProyek = $p->klasifikasi_terkontrak;
                $p->UsrNoKontrak = $p->nomor_terkontrak;
                $p->UsrNilaiTukar = $p->kurs_review;
                $p->UsrValas = $p->nilai_valas_review;
                $p->UsrTanggalSPKEkternal = $p->tglspk_internal;
                $p->UsrTanggalKontrak = $p->tanggal_terkontrak;
                $proyek_berjalan = ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first();
                $p->Account = [ 
                    "Name" => $proyek_berjalan->name ?? NULL,
                    "UsrKdNasabah" => $proyek_berjalan->customer->kode_nasabah ?? NULL,
                ];
                $p->UsrProvinsi = $p->provinsi;
                $p->UsrNegara = $p->negara;
                $p->UsrSumberDana = $p->sumber_dana;
                $p->UsrSistemPembayaran = $p->sistem_bayar;
                $p->UsrMataUang = $p->sistem_bayar;
                $p->UsrJenisKontrak = $p->jenis_terkontrak;
                $p->UsrNilaiKontrakKeseluruhan = $p->nilai_kontrak_keseluruhan;
                $p->UsrNilaiKontrakKeseluruhan = $p->nilai_kontrak_keseluruhan;
                $p->UsrNilaiKontrakKeseluruhan = $p->nilai_kontrak_keseluruhan;
                $p->UsrNilaiKontrakKeseluruhan = $p->nilai_kontrak_keseluruhan;

                // switch ($p->stage) {
                //     case 0:
                //         $p->tahap = "Pasar Dini";
                //         break;
                //     case 1:
                //         $p->tahap = "Pasar Dini";
                //         break;
                //     case 2:
                //         $p->tahap = "Pasar Potensial";
                //         break;
                //     case 3:
                //         $p->tahap = "Prakualifikasi";
                //         break;
                //     case 4:
                //         $p->tahap = "Tender Diikuti";
                //         break;
                //     case 5:
                //         $p->tahap = "Perolehan";
                //         break;
                //     case 6:
                //         $p->tahap = "Menang";
                //         break;
                //     case 7:
                //         $p->tahap = "Terendah";
                //         break;
                //     case 8:
                //         $p->tahap = "Terkontrak";
                //         break;
                // }
                unset($p->jenis_proyek, $p->unit_kerja, $p->kode_proyek, $p->tanggal_mulai_terkontrak, $p->tanggal_akhir_terkontrak, $p->id);
                unset($p->tanggal_selesai_pho, $p->tanggal_selesai_fho, $p->nama_proyek, $p->nospk_external, $p->porsi_jo, $p->nilai_kontrak_keseluruhan);
                unset($p->nilai_kontrak_keseluruhan, $p->nilai_valas_review, $p->tanggal_terkontrak, $p->nilai_perolehan, $p->kurs_review, $p->klasifikasi_terkontrak);
                unset($p->nomor_terkontrak, $p->tglspk_internal);

                return $p;
            });
            $data = [
                // "Success" => true,
                "TakenDate" => Carbon::now()->translatedFormat("d F Y H:i:s"),
                // "Message" => null,
                // "TotalData" => $proyeks->count(),
                "Data" => $proyeks->toArray(),
            ];
            // creating object of SimpleXMLElement
            $xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes" ?><feed></feed>');

            // function call to convert array to xml
            $data = arrayToXML($data, $xml_data);
            // print_r($data);
            return response($data)->header("Content-Type", "text/xml");
        }
        return response()->json([
            "status" => 401,
            "msg" => "Tidak Terautentikasi"
        ]);
    })->middleware("userAuth");

    // Begin - Detail Proyek yang ada forecast
    Route::post('/detail-nilai-proyek', function (Request $request) {
        $periode = getPeriode($request->periode);
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (isset($is_bpmcsrf_exist)) {

            // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
            // $forecasts = Forecast::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
            $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("stage", "=", 8)->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "nilai_perolehan"]);
            $total_realisasi = $proyeks->sum("nilai_perolehan");
            $proyeks = $proyeks->map(function ($p) use ($periode) {
                if (str_contains($p->kode_proyek, "KD")) {
                    $p->spk_code = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm;
                    // Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->dump();
                } else {
                    $p->spk_code = $p->kode_proyek;
                }
                $p->proyek_name = $p->nama_proyek;
                switch ($p->jenis_proyek) {
                    case "I":
                        $p->type_code = "Internal";
                        break;
                    case "N":
                        $p->type_code = "Eksternal";
                        break;
                    case "J":
                        $p->type_code = "JO";
                        break;
                }
                $data_ok = collect();
                for ($i = 1; $i <= 12; $i++) {
                    $f = Forecast::where("periode_prognosa", '=', $periode[1])->where("kode_proyek", '=', $p->spk_code)->where("month_rkap", "=", $i)->first();
                    if (!empty($f) && $i == $f->month_rkap) {
                        $data_ok->push([
                            "month" => $i,
                            "total" => (int) $f->rkap_forecast
                        ]);
                    } else {
                        $data_ok->push([
                            "month" => $i,
                            "total" => 0
                        ]);
                    }
                }
                $p->component_id = 0;
                $p->header_id = 0;
                $p->data_ok = $data_ok;
                unset($p->kode_proyek, $p->nama_proyek, $p->jenis_proyek, $p->unit_kerja, $p->nilai_perolehan);
                // $p->nilai_forecast = $p->forecasts->sum("nilai_forecast");
                // $p->rkap_forecast = $p->forecasts->sum("rkap_forecast");
                // $p->realisasi_forecast = $p->forecasts->sum("realisasi_forecast");
                return $p;
            });
            $data = [
                "GetDetailNilaiProyekResult" => [
                    "Success" => true,
                    "Message" => null,
                    "TotalData" => $proyeks->count(),
                    "TotalRealisasi" => $total_realisasi,
                    "Data" => $proyeks,
                ],

            ];
            return response()->json($data);
        }
        return response()->json([
            "status" => 401,
            "msg" => "Tidak Terautentikasi"
        ]);
    })->middleware("userAuth");
    // End - Detail Proyek yang ada forecast

    // Begin - RKAP
    Route::post('/rkap/save', function (Request $request) {
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (!isset($is_bpmcsrf_exist)) {
            return response()->json([
                "status" => 401,
                "msg" => "Tidak Terautentikasi"
            ]);
        }
        $data = collect($request->UsrListProyek);
        $unit_kerja = $request->UsrUnitKerja;
        $tahun = $request->UsrTahunPelaksanaan;
        $bulan = (int) date('m');
        $is_data_inserted = false;
        // $data = collect($request->list_proyek);
        // $unit_kerja = $request->unit_kerja;
        // $periode = collect(explode("-", $request->periode_prognosa));
        // $tahun = (int) $periode[0];
        // $bulan = (int) $periode[1];
        // $is_data_inserted = false;
        $data->each(function ($proyek) use ($data, $bulan, $tahun, $unit_kerja, &$is_data_inserted) {
            $p = new Proyek();
            $p->kode_proyek = $proyek["UsrCodeProyek"];
            $p->nama_proyek = $proyek["UsrName"];
            $p->is_rkap = true;
            if (str_contains($proyek["UsrJenisProyek"], "I")) {
                $jenis_proyek = "I";
            } else if (str_contains($proyek["UsrJenisProyek"], "J")) {
                $jenis_proyek = "J";
            } else {
                $jenis_proyek = "N";
            }
            $p->jenis_proyek = $jenis_proyek;
            $tipe_proyek = ($proyek["UsrRetail"] == true ? 'R' : 'P');
            $p->tipe_proyek = $tipe_proyek;
            $p->nilaiok_awal = $proyek["UsrNilaiOKAwal"];
            $p->bulan_pelaksanaan = $proyek["UsrBulanRealisasiAwal"];
            $p->bulan_awal = $proyek["UsrBulanRealisasiAwal"];
            $p->nilaiok_review = $proyek["UsrNilaiOKReview"];
            $p->nilai_valas_review = $proyek["UsrNilaiOKReview"];
            $p->bulan_review = $proyek["UsrBulanPelaksanaan"];
            $p->unit_kerja = $unit_kerja;
            $p->tahun_perolehan = $tahun;
            $p->dop = $p->UnitKerja->dop;
            $p->stage = 1;
            $p->porsi_jo = 100;

            $customer = Customer::where('name', "=", $proyek["UsrCustomer"])->get()->first();
            // dd($customerHistory);
            if ($customer != null) {
                $customerHistory = new ProyekBerjalans();
                $customerHistory->name_customer = $proyek["UsrCustomer"];
                $customerHistory->id_customer = $customer->id_customer;
                $customerHistory->nama_proyek = $p->nama_proyek;
                $customerHistory->kode_proyek = $p->kode_proyek;
                $customerHistory->pic_proyek = $p->ketua_tender ?? "";
                $customerHistory->unit_kerja = $p->unit_kerja;
                $customerHistory->jenis_proyek = $p->jenis_proyek;
                $customerHistory->nilaiok_proyek = $p->nilaiok_awal;
                $customerHistory->stage = $p->stage;
                if ($customerHistory->save()) {
                    $is_data_inserted = true;
                } else {
                    $is_data_inserted = false;
                }
            }

            $req_forecasts = collect($proyek["UsrNilaiOKRetail"]);
            $req_forecasts->each(function ($f) use ($proyek, $bulan, &$is_data_inserted) {
                $forecast = new Forecast();
                $forecast->kode_proyek = $proyek["UsrCodeProyek"];
                $forecast->nilai_forecast = 0;
                $forecast->month_forecast = $f["UsrBulanRaPerolehan"];
                $forecast->rkap_forecast = $f["UsrNilaiOKAwal"];
                $forecast->month_rkap = $f["UsrBulanRaPerolehan"];
                $forecast->realisasi_forecast = 0;
                $forecast->month_realisasi = $f["UsrBulanRaPerolehan"];
                $forecast->periode_prognosa = $bulan;
                if ($forecast->save()) {
                    $is_data_inserted = true;
                } else {
                    $is_data_inserted = false;
                }
            });

            $p->save();
        });
        if ($is_data_inserted) {
            return response()->json([
                "status" => 200,
                "msg" => "Group RKAP berhasil ditambahkan",
            ], 200);
        }
        return response()->json([
            "status" => 400,
            "msg" => "Group RKAP gagal ditambahkan",
        ], 400);
    })->middleware("userAuth");
    // End - RKAP

    // get periode year and month
    function getPeriode($periode)
    {
        return [(int) substr($periode, 0, 4), (int) substr($periode, 4, 2)];
    }

    function arrayToXML($array, &$xml_data)
    {
        foreach ($array as $key => $value) {
            // $xml_data->addAttribute('type', 'application/xml');
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'entry'; //dealing with <0/>..<n/> issues
                }
                // $subnode = $xml_data->addChild("entry");
                $subnode = $xml_data->addChild($key);
                // $subnode = $xml_data->addChild("content");
                arrayToXML($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
        return $xml_data->asXML();
    }
});
