<?php

use App\Http\Controllers\ProyekController;
use App\Http\Controllers\UserController;
use App\Models\Forecast;
use App\Models\Proyek;
use App\Models\ProyekBerjalans;
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
        $periode = explode("-", $request->periode);
        $tahun = $periode[0];
        $prognosa = $periode[1];
        // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
        // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
        $proyeks = Proyek::all(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage"]);
        $proyeks = $proyeks->map(function($p) {
            switch ($p->stage) {
                case 0:
                    $p->stage = "Pasar Dini";
                    break;
                case 1:
                    $p->stage = "Pasar Dini";
                    break;
                case 2:
                    $p->stage = "Pasar Potensial";
                    break;
                case 3:
                    $p->stage = "Prakualifikasi";
                    break;
                case 4:
                    $p->stage = "Tender Diikuti";
                    break;
                case 5:
                    $p->stage = "Perolehan";
                    break;
                case 6:
                    $p->stage = "Menang";
                    break;
                case 7:
                    $p->stage = "Terendah";
                    break;
                case 8:
                    $p->stage = "Terkontrak";
                    break;
            }

            switch ($p->jenis_proyek) {
                case "I":
                    $p->jenis_proyek = "Internal";
                    break;
                case "N":
                    $p->jenis_proyek = "Eksternal";
                    break;
                case "J":
                    $p->jenis_proyek = "JO";
                    break;
            }
            $p->pemberi_kerja = ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first()->name_customer ?? "";
            return $p;
        });
        $data = [
            "total_data" => $proyeks->count(),
            "periode" => $request->periode,
            "proyeks" => $proyeks
        ];
        return response()->json($data);
    })->middleware("userAuth");

    Route::post('/detail-nilai-proyek', function (Request $request) {
        $periode = explode("-", $request->periode);
        $tahun = $periode[0];
        $prognosa = (int) $periode[1];
        // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
        // $forecasts = Forecast::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
        $proyeks = Proyek::all(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage"]);
        $proyeks = $proyeks->map(function($p) use($tahun, $prognosa) {
            switch ($p->stage) {
                case 0:
                    $p->stage = "Pasar Dini";
                    break;
                case 1:
                    $p->stage = "Pasar Dini";
                    break;
                case 2:
                    $p->stage = "Pasar Potensial";
                    break;
                case 3:
                    $p->stage = "Prakualifikasi";
                    break;
                case 4:
                    $p->stage = "Tender Diikuti";
                    break;
                case 5:
                    $p->stage = "Perolehan";
                    break;
                case 6:
                    $p->stage = "Menang";
                    break;
                case 7:
                    $p->stage = "Terendah";
                    break;
                case 8:
                    $p->stage = "Terkontrak";
                    break;
            }

            switch ($p->jenis_proyek) {
                case "I":
                    $p->jenis_proyek = "Internal";
                    break;
                case "N":
                    $p->jenis_proyek = "Eksternal";
                    break;
                case "J":
                    $p->jenis_proyek = "JO";
                    break;
            }
            $p->forecasts = $p->Forecasts->where("periode_prognosa", '=', $prognosa);
            return $p;
        });
        $data = [
            "total_data" => $proyeks->count(),
            "total_forecast" => $proyeks->sum("nilai_forecast"),
            "total_rkap" => $proyeks->sum("rkap_forecast"),
            "total_realisasi" => $proyeks->sum("realisasi_forecast"),
            "periode" => $request->periode,
            "proyeks" => $proyeks
        ];
        return response()->json($data);
    })->middleware("userAuth");
    // End Detail Proyek yang ada forecast

    // Begin RKAP
    Route::post('/rkap/save', function (Request $request) {
        $data = $request->all();
        return response()->json($data);
    });
    // End RKAP

});