<?php

use App\Http\Controllers\ProyekController;
use App\Http\Controllers\UserController;
use App\Models\Customer;
use App\Models\Forecast;
use App\Models\Proyek;
use App\Models\ProyekBerjalans;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
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
        // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
        // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
        if(isset($request->unitkerjaid)) {
            // $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->where("bulan_pelaksanaan", "=", $periode[1])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"]);
            $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"])->filter(function($p) use($periode) {
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
            $p->kode_crm = $p->kode_proyek;
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
    })->middleware("userAuth");

    Route::post('/detail-nilai-proyek', function (Request $request) {
        $periode = getPeriode($request->periode);
        // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
        // $forecasts = Forecast::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
        $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek"]);
        $proyeks = $proyeks->map(function ($p) use($periode) {
            $p->spk_code = $p->kode_proyek;
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
                if(!empty($f) && $i == $f->month_rkap) {
                    $data_ok->push([
                        "month" => $i,
                        "data_ok" => $f->rkap_forecast
                    ]);
                } else {
                    $data_ok->push([
                        "month" => $i,
                        "data_ok" => 0
                    ]);
                }
            }
            $p->data_ok = $data_ok;
            $p->component_id = 0;
            $p->header_id = 0;
            unset($p->kode_proyek, $p->nama_proyek, $p->jenis_proyek, $p->unit_kerja);
            // $p->nilai_forecast = $p->forecasts->sum("nilai_forecast");
            // $p->rkap_forecast = $p->forecasts->sum("rkap_forecast");
            // $p->realisasi_forecast = $p->forecasts->sum("realisasi_forecast");
            return $p;
        });
        $data = [
            "GetDetailProyekResult" => [
                "Success" => true,
                "Message" => null,
                "TotalData" => $proyeks->count(),
                "TotalRealisasi" => $proyeks->sum("realisasi_forecast"),
                "Data" => $proyeks,
            ],
            
        ];
        return response()->json($data);
    })->middleware("userAuth");
    // End Detail Proyek yang ada forecast

    // Begin RKAP
    Route::post('/rkap/save', function (Request $request) {
        $data = collect($request->list_proyek);
        $unit_kerja = $request->unit_kerja;
        $periode = collect(explode("-", $request->periode_prognosa));
        $tahun = (int) $periode[0];
        $bulan = (int) $periode[1];
        $is_data_inserted = false;
        $data->each(function ($proyek) use ($data, $bulan, $tahun, $unit_kerja, &$is_data_inserted) {
            $p = new Proyek();
            $p->kode_proyek = $proyek["kode_proyek"];
            $p->nama_proyek = $proyek["nama_proyek"];
            $p->is_rkap = $proyek["is_rkap"];
            $p->jenis_proyek = $proyek["jenis_proyek"];
            $p->tipe_proyek = $proyek["tipe_proyek"];
            $p->nilaiok_awal = $proyek["nilaiok_awal"];
            $p->nilaiok_review = $proyek["nilaiok_review"];
            $p->nilai_valas_review = $proyek["nilai_valas_review"];
            $p->bulan_review = $proyek["bulan_review"];
            $p->bulan_awal = $proyek["bulan_awal"];
            $p->unit_kerja = $unit_kerja;
            $p->tahun_perolehan = $tahun;
            $p->dop = $p->UnitKerja->dop;
            $p->stage = 1;

            $customer = Customer::where('name', "=", $proyek["nama_customer"])->get()->first();
            // dd($customerHistory);
            if ($customer != null) {
                $customerHistory = new ProyekBerjalans();
                $customerHistory->name_customer = $proyek["nama_customer"];
                $customerHistory->id_customer = $customer->id_customer;
                $customerHistory->nama_proyek = $p->nama_proyek;
                $customerHistory->kode_proyek = $p->kode_proyek;
                $customerHistory->pic_proyek = $p->ketua_tender ?? "";
                $customerHistory->unit_kerja = $p->unit_kerja;
                $customerHistory->jenis_proyek = $p->jenis_proyek;
                $customerHistory->nilaiok_proyek = $p->nilaiok_awal;
                $customerHistory->stage = $p->stage;
                if($customerHistory->save()) {
                    $is_data_inserted = true;
                } else {
                    $is_data_inserted = false;
                }
            }

            if ($p->save()) {
                $req_forecasts = collect($proyek["list_forecast"]);
                $req_forecasts->each(function ($f) use ($p, $proyek, $bulan, &$is_data_inserted) {
                    $forecast = new Forecast();
                    $forecast->kode_proyek = $proyek["kode_proyek"];
                    $forecast->nilai_forecast = 0;
                    $forecast->month_forecast = $f["month_forecast"];
                    $forecast->rkap_forecast = $f["rkap_forecast"];
                    $forecast->month_rkap = $f["month_rkap"];
                    $forecast->realisasi_forecast = 0;
                    $forecast->month_realisasi = $f["month_realisasi"];
                    $forecast->periode_prognosa = $bulan;
                    if($forecast->save()) {
                        $is_data_inserted = true;   
                    } else {
                        $is_data_inserted = false;
                    }
                });
            }
        });
        if($is_data_inserted) {
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
    // End RKAP

    // get periode year and month
    function getPeriode($periode) {
        return [(int) substr($periode,0, 4), (int) substr($periode, 4,2)];
    }
});
