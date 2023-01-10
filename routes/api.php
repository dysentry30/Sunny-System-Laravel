<?php

use App\Http\Controllers\ProyekController;
use App\Http\Controllers\UserController;
use App\Models\Customer;
use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\IndustryOwner;
use App\Models\Proyek;
use App\Models\ProyekBerjalans;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    // Begin - Detail Proyek yang ada forecast
    Route::post('/detail-proyek', function (Request $request) {
        $periode = getPeriode($request->periode);
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (isset($is_bpmcsrf_exist)) {

            // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
            // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
            if (isset($request->unitkerjaid)) {
                // $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->where("bulan_pelaksanaan", "=", $periode[1])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"]);
                $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "tahun_perolehan", "bulan_pelaksanaan"])->filter(function ($p) use ($periode) {
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
            $proyeks = $proyeks->map(function ($p) use ($request, $periode) {
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
                        $p->jenis = "INTERN";
                        break;
                    case "N":
                        $p->jenis = "EXTERN";
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
                $p->rencana_perolehan = $p->tahun_perolehan . "-" . str_pad($p->bulan_pelaksanaan, 2, 0, STR_PAD_LEFT) . "-" . "01";
                $p->perkiraan_durasi = date_create($p->tanggal_mulai_terkontrak)->diff(date_create($p->tanggal_akhir_terkontrak))->days;
                $p->periode = $request->periode;
                unset($p->jenis_proyek, $p->unit_kerja, $p->kode_proyek, $p->stage, $p->tanggal_mulai_terkontrak, $p->tanggal_akhir_terkontrak, $p->Forecasts,  $p->tahun_perolehan, $p->bulan_pelaksanaan);

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
    // End - Detail Proyek yang ada forecast


    // Begin - Detail Proyek yang ada forecast
    Route::post('/detail-nilai-proyek', function (Request $request) {
        $periode = getPeriode($request->periode);
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (isset($is_bpmcsrf_exist)) {

            // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
            // $forecasts = Forecast::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
            $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", ((int) $periode[1]))->where("tahun", "=", (int) $periode[0])->where("unit_kerja", "=", $request->unitkerjaid)->get(["nama_proyek", "stage", "proyeks.kode_proyek", "unit_kerja", "jenis_proyek", "tipe_proyek", "nilai_perolehan", "is_cancel", "month_forecast", "nilai_forecast", "realisasi_forecast", "periode_prognosa"])->where("stage", "!=", 7)->where("is_cancel", "!=", true);
            // $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("unit_kerja", "=", $request->unitkerjaid)->get()->where("stage", "!=", 7)->where("is_cancel", "!=", true);
            $total_realisasi = $proyeks->sum(function($s) {
                return (int) $s->realisasi_forecast;
            });
            $proyeks = $proyeks->unique('nama_proyek');
            
            $proyeks = $proyeks->map(function ($p) use ($periode, &$total_realisasi) {
                if($p->tipe_proyek == "R") {
                    if (str_contains($p->kode_proyek, "KD")) {
                        $p->spk_code = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
                        // Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->dump();
                    } else {
                        $p->spk_code = $p->kode_proyek;
                    }
                    // $p->spk_code = $p->kode_proyek.'tes-pis';
                    $p->proyek_name = $p->nama_proyek;
                    switch ($p->jenis_proyek) {
                        case "I":
                            $p->type_code = "INTERN";
                            break;
                        case "N":
                            $p->type_code = "EXTERN";
                            break;
                        case "J":
                            $p->type_code = "JO";
                            break;
                    }
                    $data_ok = collect();
                    for ($i = 1; $i <= 12; $i++) {
                        $f = HistoryForecast::where("periode_prognosa", '=', $periode[1])->where("kode_proyek", '=', $p->kode_proyek)->where("month_forecast", "=", $i)->first();
                        if (!empty($f) && $i == $f->month_forecast) {
                            $data_ok->push([
                                "month" => $i,
                                "total" => (int) $f->nilai_forecast
                            ]);
                        } else {
                            $data_ok->push([
                                "month" => $i,
                                "total" => 0
                            ]);
                        }
                    }
                } else {
                    if (str_contains($p->kode_proyek, "KD")) {
                        $p->spk_code = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
                        // Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->dump();
                    } else {
                        $p->spk_code = $p->kode_proyek;
                    }
                    // $p->spk_code = $p->kode_proyek;
                    $p->proyek_name = $p->nama_proyek;
                    switch ($p->jenis_proyek) {
                        case "I":
                            $p->type_code = "INTERN";
                            break;
                        case "N":
                            $p->type_code = "EXTERN";
                            break;
                        case "J":
                            $p->type_code = "JO";
                            break;
                    }
                    $data_ok = collect();
                    for ($i = 1; $i <= 12; $i++) {
                        // $f = HistoryForecast::where("periode_prognosa", '=', $periode[1])->where("kode_proyek", '=', $p->kode_proyek)->where("month_forecast", "=", $i)->first();
                        if (!empty($p) && $i == $p->month_forecast) {
                            $data_ok->push([
                                "month" => $i,
                                "total" => (int) $p->nilai_forecast
                            ]);
                        } else {
                            $data_ok->push([
                                "month" => $i,
                                "total" => 0
                            ]);
                        }
                    }
                }
                $p->component_id = 0;
                $p->header_id = 0;
                $p->data_ok = $data_ok;
                unset($p->kode_proyek, $p->nama_proyek, $p->jenis_proyek, $p->unit_kerja, $p->nilai_perolehan, $p->is_cancel, $p->stage, $p->tipe_proyek);
                unset($p->month_forecast, $p->nilai_forecast, $p->periode_prognosa, $p->realisasi_forecast);
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
                    "Data" => $proyeks->flatten(),
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

    // Begin - Detail Proyek yang ada forecast
    Route::post('/detail-nilai-proyek-sap', function (Request $request) {
        $periode = getPeriode($request->periode);
        $is_bpmcsrf_exist = $request->header("BPMCSRF");
        if (isset($is_bpmcsrf_exist)) {

            // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
            // $forecasts = Forecast::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
            $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("history_forecast.periode_prognosa", (int) $periode[1])->where("history_forecast.tahun", "=", (int) $periode[0])->where("unit_kerja", "=", $request->unitkerjaid)->get(["nama_proyek", "stage", "proyeks.kode_proyek", "unit_kerja", "jenis_proyek", "tipe_proyek", "nilai_perolehan", "is_cancel", "month_forecast", "nilai_forecast", "realisasi_forecast", "periode_prognosa"])->where("stage", "!=", 7)->where("is_cancel", "!=", true);
            // $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("unit_kerja", "=", $request->unitkerjaid)->get()->where("stage", "!=", 7)->where("is_cancel", "!=", true);
            $total_realisasi = $proyeks->sum(function($s) {
                return (int) $s->realisasi_forecast;
            });
            // dd($proyeks);
            $proyeks = $proyeks->unique('nama_proyek');
            
            $proyeks = $proyeks->map(function ($p) use ($periode, &$total_realisasi) {
                

                if($p->tipe_proyek == "R") {
                    if (str_contains($p->kode_proyek, "KD")) {
                        $p->spk_code = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
                        // Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->dump();
                    } else {
                        $p->spk_code = $p->kode_proyek;
                    }
                    // $p->spk_code = $p->kode_proyek.'tes-pis';
                    $p->proyek_name = $p->nama_proyek;
                    switch ($p->jenis_proyek) {
                        case "I":
                            $p->type_code = "INTERN";
                            break;
                        case "N":
                            $p->type_code = "EXTERN";
                            break;
                        case "J":
                            $p->type_code = "JO";
                            break;
                    }
                    $data_ok = collect();
                    for ($i = 1; $i <= 12; $i++) {
                        $f = HistoryForecast::where("periode_prognosa", '=', $periode[1])->where("kode_proyek", '=', $p->kode_proyek)->where("month_forecast", "=", $i)->first();
                        if (!empty($f) && $i == $f->month_forecast) {
                            $data_ok->push([
                                "month" => $i,
                                "total" => (int) $f->nilai_forecast
                            ]);
                        } else {
                            $data_ok->push([
                                "month" => $i,
                                "total" => 0
                            ]);
                        }
                    }
                } else {
                    if (str_contains($p->kode_proyek, "KD")) {
                        $p->spk_code = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
                        // Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->dump();
                    } else {
                        $p->spk_code = $p->kode_proyek;
                    }
                    // $p->spk_code = $p->kode_proyek;
                    $p->proyek_name = $p->nama_proyek;
                    switch ($p->jenis_proyek) {
                        case "I":
                            $p->type_code = "INTERN";
                            break;
                        case "N":
                            $p->type_code = "EXTERN";
                            break;
                        case "J":
                            $p->type_code = "JO";
                            break;
                    }
                    $data_ok = collect();
                    for ($i = 1; $i <= 12; $i++) {
                        // $f = HistoryForecast::where("periode_prognosa", '=', $periode[1])->where("kode_proyek", '=', $p->kode_proyek)->where("month_forecast", "=", $i)->first();
                        if (!empty($p) && $i == $p->month_forecast) {
                            $data_ok->push([
                                "month" => $i,
                                "total" => (int) $p->nilai_forecast
                            ]);
                        } else {
                            $data_ok->push([
                                "month" => $i,
                                "total" => 0
                            ]);
                        }
                    }
                }
                // Referensi dari WIKA - BW BPC PBI INTERFACE FROM NON SAP v1.4 GDRIVE
                $p->ZIOCH0008    = "AB00100000"; // PROFIT CENTER DIVISI
                $p->ZIOCH0002    = "A000"; // COMPANY CODE
                $p->ZIOCH0094    = $p->type_code; // STATUS CONTRACT
                $p->ZIOCH0089    = date("d.m.Y"); // WAKTU PEROLEHAN
                $p->ZIOCH0091    = "CRM0001";

                $p->component_id = 0;
                $p->header_id = 0;
                $p->data_ok = $data_ok;
                unset($p->kode_proyek, $p->nama_proyek, $p->jenis_proyek, $p->unit_kerja, $p->nilai_perolehan, $p->is_cancel, $p->stage, $p->tipe_proyek);
                unset($p->month_forecast, $p->nilai_forecast, $p->periode_prognosa, $p->realisasi_forecast);
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
                    "Data" => $proyeks->flatten(),
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
        setLogging("api", "INSERT GROUP RKAP => ", $request->toArray());
        $data = $request->UsrApprovalGroup;
        $list_proyek = collect($data["UsrListProyek"]);
        $unit_kerja = UnitKerja::find($data["UsrUnitKerja"]);
        // $month = (int) date("m") == 1 ? 12 : (int) date("m");
        // $year = (int) date("m") == 1 ? (int) date("Y") - 1: (int) date("Y");
        $month = (int) date("m");
        $year = (int) date("Y");

        // CHECK JIKA UNIT KERJA SUDAH OTOR
        $check_is_history_exist = HistoryForecast::all()->filter(function($hf) use($unit_kerja, $month, $year) {
            return $hf->tahun == $year && $hf->periode_prognosa == $month && $hf->Proyek->unit_kerja == $unit_kerja->divcode;
        })->count() > 0;

        if($check_is_history_exist) {
            return response()->json([
                "InsertGroupRKAPResult" => [
                    "Success"=> true,
                    "StatusCode"=> 2,
                    "Message"=> "Insert Data RKAP Unit Kerja $unit_kerja->unit_kerja sudah terkunci"
                ]
            ], 200);
        }

        $tahun = $data["UsrTahunPelaksanaan"];
        $bulan = (int) date('m');
        $is_data_inserted = false;
        // $list_proyek = collect($request["list_proyek"]);
        // $unit_kerja = $request["unit_kerja"];
        // $periode = collect(explode("-", $request["periode_prognosa"]));
        // $tahun = (int) $periode[0];
        // $bulan = (int) $periode[1];
        // $is_data_inserted = false;
        $list_proyek->each(function ($proyek) use ($data, $bulan, $tahun, $unit_kerja, &$is_data_inserted) {
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
            $p->nilaiok_awal = round((int) $proyek["UsrNilaiOKAwal"]);
            $p->nilai_rkap = round((int) $proyek["UsrNilaiOKAwal"]);
            $p->bulan_pelaksanaan = $proyek["UsrBulanRealisasiAwal"];
            $p->bulan_awal = $proyek["UsrBulanRealisasiAwal"];
            $p->nilaiok_review = round((int) $proyek["UsrNilaiOKReview"]);
            $p->nilai_valas_review = round((int) $proyek["UsrNilaiOKReview"]);
            $p->bulan_review = $proyek["UsrBulanPelaksanaan"];
            $p->unit_kerja = $unit_kerja->divcode;
            $p->tahun_perolehan = $tahun;
            $p->dop = $p->UnitKerja->dop;
            $p->stage = 1;
            $p->porsi_jo = 100;
            $p->is_cancel = false;

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
            if($p->save()) {
                $is_data_inserted = true;
            }
        });
        if ($is_data_inserted) {
            return response()->json([
                "InsertGroupRKAPResult" => [
                    "Success"=> true,
                    "StatusCode"=> 1,
                    "Message"=> "Insert Data RKAP Unit Kerja Divisi Infrastruktur 1 Success"
                ]
            ], 200);
        }
        return response()->json([
            "status" => 400,
            "msg" => "Group RKAP gagal ditambahkan",
        ], 400);
    })->middleware("userAuth");
    // End - RKAP

    // Begin - Industry Owner ke SAP
    Route::get('/get-industry-attract', function () {
        // $customers_attractivness = Customer::with(["IndustryOwner"])->get();
        $customers_attractivness = IndustryOwner::all();
        $customers_attractivness = $customers_attractivness->map(function($ca) {
            // dd($ca);
            $new_ca = new stdClass();
            $new_ca->periode = date("Ymd");
            $new_ca->industry_code = $ca->code_owner ?? "";
            $new_ca->attractivness_status = $ca->owner_attractiveness ?? "";
            return $new_ca;
        });
        // $industry_attractivness = IndustryOwner::all();
        // $new_class = $industry_attractivness->map(function($ia) {
        //     $new_ia = new stdClass();
        //     $new_ia->periode = date("Ymd");
        //     $new_ia->code_customer = "";
        //     $new_ia->industry_code = $ia->code_owner;
        //     $new_ia->attractivness_status = $ia->owner_attractiveness;
        //     return $new_ia;
        // });
        return response()->json($customers_attractivness);
    });
    // End - Industry Owner ke SAP

    // get periode year and month
    // function getPeriode($periode)
    // {
    //     return [(int) substr($periode, 0, 4), (int) substr($periode, 4, 2)];
    // }

    // function arrayToXML($array, &$xml_data)
    // {
    //     foreach ($array as $key => $value) {
    //         // $xml_data->addAttribute('type', 'application/xml');
    //         if (is_array($value)) {
    //             if (is_numeric($key)) {
    //                 $key = 'entry'; //dealing with <0/>..<n/> issues
    //             }
    //             // $subnode = $xml_data->addChild("entry");
    //             $subnode = $xml_data->addChild($key);
    //             // $subnode = $xml_data->addChild("content");
    //             arrayToXML($value, $subnode);
    //         } else {
    //             $xml_data->addChild("$key", htmlspecialchars("$value"));
    //         }
    //     }
    //     return $xml_data->asXML();
    // }
});
