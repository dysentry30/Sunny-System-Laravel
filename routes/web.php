<?php

use App\Models\User;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\UnitKerja;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Mail\UserPasswordEmail;
use App\Models\HistoryForecast;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DopController;
use App\Http\Controllers\SbuController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\UserController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\PasalController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\SumberDanaController;
use App\Http\Controllers\TeamProyekController;
use App\Http\Controllers\DraftContractController;
use App\Http\Controllers\KriteriaPasarController;
use App\Http\Controllers\AddendumContractController;
use App\Http\Controllers\ContractManagementsController;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', [UserController::class, 'welcome'])->middleware("userNotAuth");


// begin :: Login

Route::post('/login', [UserController::class, 'authen']);

Route::get('/logout', [UserController::class, 'logout']);

// Route::post('/createUser', [UserController::class, 'testLogin']);
// end :: Login




Route::group(['middleware' => ["userAuth", "admin"]], function () {

    // Route::middleware(["admin", "adminKontrak", "userSales"])->group(function () {
    // });

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard/filter/{prognosa}/{type}/{month}', [DashboardController::class, 'getDataFilterPoint']);

    Route::get('/dashboard/filter/{prognosa}/{type}/{month}/{unit_kerja}', [DashboardController::class, 'getDataFilterPoint']);

    Route::get('/dashboard/triwulan/{prognosa}/{type}/{month}', [DashboardController::class, 'getDataFilterPointTriwulan']);

    Route::get('/dashboard/triwulan/{prognosa}/{type}/{month}/{unit_kerja}', [DashboardController::class, 'getDataFilterPointTriwulan']);

    Route::get('/dashboard/realisasi/{prognosa}/{type}/{unitKerja}', [DashboardController::class, 'getDataFilterPointRealisasi']);

    Route::get('/dashboard/realisasi/{prognosa}/{type}/{unitKerja}/{divcode}', [DashboardController::class, 'getDataFilterPointRealisasi']);

    Route::get('/dashboard/monitoring-proyek/{tipe}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/monitoring-proyek/{tipe}/{filter}', [DashboardController::class, "getDataMonitoringProyek"]);
    
    Route::get('/dashboard/terendah-terkontrak/{tipe}/{filter}', [DashboardController::class, "getDataTerendahTerkontrak"]);

    // begin :: contract management
    Route::get('/contract-management', [ContractManagementsController::class, 'index']);

    Route::get('/contract-management/view', [ContractManagementsController::class, 'new']);

    Route::post('/contract-management/save', [ContractManagementsController::class, 'save']);

    Route::post('/contract-management/update', [ContractManagementsController::class, 'update']);

    Route::post('/contract-management/document-bast/upload', [ContractManagementsController::class, 'documentBastContractUpload']);

    Route::post('/contract-management/ba-defect/upload', [ContractManagementsController::class, 'baDefectContractUpload']);

    Route::post('/contract-management/dokumen-pendukung/upload', [ContractManagementsController::class, 'dokumenPendukungContractUpload']);

    Route::post('/contract-management/pending-issue/upload', [ContractManagementsController::class, 'pendingIssueContractUpload']);

    Route::post('/contract-management/penutupan-proyek/upload', [ContractManagementsController::class, 'penutupanProyekContractUpload']);

    Route::post('/contract-management/usulan-perubahan-draft/upload', [ContractManagementsController::class, 'usulanPerubahanDraftContractUpload']);

    Route::post('/contract-management/rencana-kerja-kontrak/upload', [ContractManagementsController::class, 'rencanaKerjaManajemenContractUpload']);

    Route::delete('/contract-management/{contractManagement}/delete', [ContractManagementsController::class, 'delete']);

    Route::get('/contract-management/view/{id_contract}', [ContractManagementsController::class, 'viewContract']);

    Route::get('/contract-management/view/{id_contract}/addendum-contract', [ContractManagementsController::class, 'addendumContract']);

    Route::get('/contract-management/view/{id_contract}/addendum-contract/{addendumContract}', [ContractManagementsController::class, 'addendumView']);

    Route::get('/contract-management/view/{id_contract}/addendum-contract/{addendumContract}/new', [ContractManagementsController::class, 'addendumNew']);

    Route::get('/contract-management/view/{id_contract}/addendum-contract/{addendumContract}/{addendumDraft}', [ContractManagementsController::class, 'addendumDraft']);

    Route::get('/contract-management/view/{id_contract}/draft-contract', [ContractManagementsController::class, 'draftContract']);

    Route::get('/contract-management/view/{id_contract}/draft-contract/{draftContracts}', [ContractManagementsController::class, 'draftContractView']);

    // Route::get('/contract-management/view/{id_contract}/draft-contract/{is_tender_menang}', [ContractManagementsController::class, 'draftContractView']);
    Route::get('/contract-management/view/{id_contract}/draft-contract/tender-menang/1', [ContractManagementsController::class, 'tenderMenang']);

    Route::post("/draft-contract/upload", [DraftContractController::class, "save"]);

    Route::post("/addendum-contract/upload", [AddendumContractController::class, "upload"]);

    Route::post("/addendum-contract/update", [AddendumContractController::class, "update"]);

    Route::post("/addendum-contract/draft/upload", [AddendumContractController::class, "draftUpload"]);

    Route::post("/addendum-contract/diajukan/upload", [AddendumContractController::class, "draftDiajukanUpload"]);

    Route::post("/addendum-contract/negosiasi/upload", [AddendumContractController::class, "draftNegoisasiUpload"]);

    Route::post("/addendum-contract/disetujui/upload", [AddendumContractController::class, "draftDisetujuiUpload"]);

    Route::post("/addendum-contract/amandemen/upload", [AddendumContractController::class, "draftAmandemenUpload"]);

    Route::post("/addendum-contract/draft/update", [AddendumContractController::class, "draftUpdate"]);

    Route::get('change-request', [AddendumContractController::class, 'changeRequest']);
    // end :: contract management



    // begin :: Pasal
    Route::get('/pasal/edit', [PasalController::class, 'index']);

    Route::delete('/pasal/delete/{pasal}', [PasalController::class, 'destroy']);

    Route::get('/pasal/{pasal}', [PasalController::class, 'show']);

    Route::post('/import/pasal', [PasalController::class, "importPasal"]);
    // end :: Pasal



    // begin :: Claim Management

    Route::get('claim-management', [ClaimController::class, 'index']);

    Route::get('claim-management/proyek/{kode_proyek}/{jenis_claim}', [ClaimController::class, 'viewClaim']);

    // Route::get('claim-management/view/{kode_proyek}', [ClaimController::class, 'viewClaim']);

    Route::get('/claim-management/{proyek}/{contract}/new',  [ClaimController::class, 'new']);

    Route::post('/claim-management/save', [ClaimController::class, 'save']);

    Route::post('/claim-management/delete', [ClaimController::class, 'claimDelete']);

    Route::get('claim-management/view/{claim_management}', [ClaimController::class, 'show']);

    Route::post('/approval-claim/save', [ClaimController::class, 'store']);

    Route::post('/approval-claim/delete', [ClaimController::class, 'delete']);

    Route::post('/claim-management/update', [ClaimController::class, 'update']);

    Route::post('/detail-claim/save', [ClaimController::class, 'detailSave']);

    Route::post('/claim/stage/save', [ClaimController::class, 'claimStage']);

    Route::post('/claim-contract/draft/upload', [ClaimController::class, 'claimDraftUpload']);

    Route::post('/claim-contract/diajukan/upload', [ClaimController::class, 'claimDiajukanUpload']);

    Route::post('/claim-contract/negosiasi/upload', [ClaimController::class, 'claimNegosiasiUpload']);

    Route::post('/claim-contract/disetujui/upload', [ClaimController::class, 'claimDisetujuiUpload']);
    // end :: Claim Management



    // Begin :: Menu Document
    Route::get('/document', [DocumentController::class, "documentIndex"]);
    // End :: Menu Document



    //Begin :: Customer
    // Customer with Auto Scrol
    Route::get('/customer', [CustomerController::class, 'getIndex']);

    // customer dashboard all database
    // Route::get('/customer', [CustomerController::class, 'index']);


    // DELETE data customer pada dasboard customer by ID 
    Route::delete('customer/delete/{id_customer}', [CustomerController::class, 'delete']);


    // NEW to Create New customer #1 
    Route::get('/customer/new', [CustomerController::class, 'new']);


    // NEW to Create New customer #2
    Route::post('/customer/save', [CustomerController::class, 'saveNew']);

    // view customer by id_customer #1
    Route::get('/customer/view/{id_customer}', [CustomerController::class, 'view']);

    // EDIT customer by view id_customer #2   
    Route::post('/customer/save-edit', [CustomerController::class, 'saveEdit']);

    // // Edit Customer Proyek History by new history    
    // Route::post('/customer/view-modal', [CustomerController::class, 'addProyek']);

    // Edit Customer Proyek History by view id_customer    
    Route::post('/customer/save-modal', [CustomerController::class, 'customerHistory']);

    // DELETE Attachment 
    Route::delete('/customer/attachment/{id}/delete', [CustomerController::class, 'deleteAttachment']);

    // Add PIC    
    Route::post('/customer/pic', [CustomerController::class, 'pic']);

    // Edit PIC    
    Route::post('/customer/pic/{id}/edit', [CustomerController::class, 'editPic']);

    // Delete PIC    
    Route::delete('/customer/pic/{id}/delete', [CustomerController::class, 'deletePic']);

    // Add Struktur Organisasi    
    Route::post('/customer/struktur', [CustomerController::class, 'struktur']);

    // EDIT Struktur Organisasi    
    Route::post('/customer/struktur/{id}/edit', [CustomerController::class, 'editStruktur']);

    // Delete Struktur Organisasi    
    Route::delete('/customer/struktur/{id}/delete', [CustomerController::class, 'deleteStruktur']);

    // Begin :: get Kabupaten
    Route::get('/get-kabupaten/{id}', function ($id) {
        // $data_kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/$id.json")->json();
        $data_kabupaten = json_decode(Storage::get("/public/data/$id.json"));
        return $data_kabupaten;
    });
    // End :: get Kabupaten

    // Begin :: get coordinate kabupaten
    Route::get('/get-kabupaten-coordinate/{city_name}', function ($city_name) {
        $data = Http::get("https://nominatim.openstreetmap.org/search.php?q=$city_name+Indonesia&polygon_geojson=1&format=json");
        // dd($data->json());
        return $data[0];
    });
    // End :: get coordinate kabupaten
    //End :: Customer



    //Begin :: Project
    Route::get('/opportunity', function (Request $request) {
        $oppor = Opportunity::paginate(50);
        $unitkerjas = UnitKerja::all();
        // foreach($oppor as $o) {
        //     dump($o->UsrKodeProyek);
        // }
        // dd();
        return view("3_Opportunity", compact(["oppor", "unitkerjas"]));
    });

    // Home Page Proyek
    Route::get('/proyek', [ProyekController::class, 'view']);

    // direct to proyek after SAVE page 
    Route::post('/proyek/save', [ProyekController::class, 'save']);

    // VIEW to proyek and EDIT 
    Route::get('/proyek/view/{kode_proyek}', [ProyekController::class, 'edit']);

    // direct to Project after EDIT 
    Route::post('/proyek/update', [ProyekController::class, 'update']);

    Route::post('/proyek/update/retail', [ProyekController::class, 'updateRetail']);

    Route::post('/proyek/forecast/{i}/retail', function (Request $request, $i) {
        $data = $request->all();
        // dd($data, $i);

        $findForecast = Forecast::where("kode_proyek", "=", $data["kode-proyek"])->where("month_forecast", "=", (int) $i)->get()->first();
        // $tabPane = "kt_user_view_overview_forecast";

        if (empty($findForecast)) {

            $forecast = new Forecast();
            $forecast->kode_proyek = $data["kode-proyek"];

            $forecast->nilai_forecast = (string) (str_replace(".", "", $data["nilaiforecast-" . $i] ?? 0));
            $forecast->month_forecast = (int) $i;

            $forecast->rkap_forecast = (string) (str_replace(".", "", $data["nilaiok-" . $i] ?? 0));
            $forecast->month_rkap = (int) $i;

            $forecast->realisasi_forecast = (string) (str_replace(".", "", $data["nilairealisasi-" . $i] ?? 0));
            $forecast->month_realisasi = (int) $i;

            $prognosa = (int) date('m');
            $forecast->periode_prognosa = $prognosa;

            // dd($tabPane);

            $forecast->save();

            Alert::success('Success', "Forecast Berhasil Dibuat");
            return redirect()->back();

        } else {

            $findForecast->kode_proyek = $data["kode-proyek"];

            $findForecast->nilai_forecast = (string) (str_replace(".", "", $data["nilaiforecast-" . $i] ?? 0));
            $findForecast->month_forecast = (int) $i;

            $findForecast->rkap_forecast = (string) (str_replace(".", "", $data["nilaiok-" . $i] ?? 0));
            $findForecast->month_rkap = (int) $i;

            $findForecast->realisasi_forecast = (string) (str_replace(".", "", $data["nilairealisasi-" . $i] ?? 0));
            $findForecast->month_realisasi = (int) $i;

            $prognosa = (int) date('m');
            $findForecast->periode_prognosa = $prognosa;

            $findForecast->save();
            
            // dd($tabPane);

            Alert::success('Success', "Forecast Berhasil Diubah");
            return redirect()->back();
        }
    });

    // DELETE data customer pada dasboard customer by ID 
    Route::delete('/proyek/delete/{kode_proyek}', [ProyekController::class, 'delete']);

    // CANCEL data  
    Route::post('/proyek/cancel-modal/{kode_proyek}', [ProyekController::class, 'cancelProyek']);

    // Stage Update 
    Route::post('/proyek/stage-save', [ProyekController::class, 'stage']);

    Route::post('/proyek/forecast/save', function (Request $request) {
        $data = $request->all();
        $per = 1000000;
        $proyek = Proyek::find($data["kode_proyek"]);
        $forecast = Forecast::where("kode_proyek", "=", $data["kode_proyek"])->where("month_forecast", "=", $data["forecast_month"])->where("periode_prognosa", "=", $data["periode_prognosa"] ?? (int) date("m"))->orderByDesc("created_at")->first();
        // $forecast = DB::select("SELECT * FROM forecasts WHERE kode_proyek='" . $data["kode_proyek"] . "' AND (" . "YEAR(created_at)=" . date("Y") . " OR YEAR(updated_at)=" . date("Y"). ");");
        if (!empty($forecast)) {
            if ($forecast->update(["nilai_forecast" => (string) $data["nilai_forecast"] * $per])) {
                if (!empty($proyek->forecast)) {
                    $totalfc = 0;
                    foreach ($proyek->Forecasts as $proyekfc) {
                        $totalfc += $proyekfc->nilai_forecast;
                    }
                    $proyek->forecast = (string) $totalfc;
                    $proyek->save();
                } else {
                    $proyek->forecast = (string) $data["nilai_forecast"];
                    $proyek->save();
                }
                return response()->json([
                    "status" => "success",
                    "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> berhasil di tambahkan",
                ]);
            }
        } else {
            $nilai_kontrak_keseluruhan = $proyek->nilai_kontrak_keseluruhan == null ? 0 : str_replace(".", "", (int) $proyek->perolehan);
            $forecast = new Forecast();
            $forecast->nilai_forecast = (string) $data["nilai_forecast"] * $per;
            $forecast->month_forecast = (int) $data["forecast_month"];
            $forecast->month_rkap = (int) $proyek->bulan_pelaksanaan;
            $forecast->month_realisasi = $proyek->bulan_ri_perolehan;
            $forecast->month_forecast = (int) $data["forecast_month"];
            $forecast->rkap_forecast = str_replace(".", "", (int) $proyek->nilai_rkap);
            $forecast->realisasi_forecast = (string) $nilai_kontrak_keseluruhan;
            $forecast->periode_prognosa = (int) $data["periode_prognosa"];
            $forecast->kode_proyek = $data["kode_proyek"];
            if ($forecast->save()) {
                if ($proyek->kode_proyek == $data["kode_proyek"]) {
                    $proyek->forecast += (int) $data["nilai_forecast"] * $per;
                    $proyek->save();
                } else {
                    $proyek->forecast = (int) $data["nilai_forecast"] * $per;
                    $proyek->save();
                }
                return response()->json([
                    "status" => "success",
                    "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> berhasil di tambahkan",
                ]);
            }
            return response()->json([
                "status" => "failed",
                "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> gagal di tambahkan",
            ]);
        }

        return response()->json([
            "status" => "failed",
            "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> gagal di tambahkan",
        ]);
    });

    // GET Kriteria 
    Route::post('/proyek/get-kriteria', [ProyekController::class, "getKriteria"]);

    // ADD Kriteria 
    Route::post('/proyek/kriteria-add', [ProyekController::class, 'tambahKriteria']);

    // EDIT Kriteria 
    Route::post('/proyek/{id}/kriteria-edit', [ProyekController::class, 'editKriteria']);

    // DELETE Kriteria 
    Route::delete('/proyek/kriteria-delete/{id}', [ProyekController::class, 'deleteKriteria']);

    // ADD Porsi-JO 
    Route::post('/proyek/porsi-jo', [ProyekController::class, "tambahJO"]);

    // EDIT Porsi-JO 
    Route::post('/proyek/porsi-jo/{id}/edit', [ProyekController::class, "editJO"]);

    // DELETE Porsi-JO 
    Route::delete('/proyek/porsi-delete/{id}', [ProyekController::class, "deleteJO"]);

    // ADD Team Proyek 
    Route::post('proyek/user/add', [ProyekController::class, 'assignTeam']);

    // DELETE Team Proyek 
    Route::delete('proyek/user-delete/{id}', [ProyekController::class, 'deleteTeam']);

    // ADD Peserta Tender 
    Route::post('proyek/peserta-tender/add', [ProyekController::class, 'tambahTender']);

    // EDIT Peserta Tender 
    Route::post('/proyek/peserta-tender/{id}/edit', [ProyekController::class, 'editTender']);

    // DELETE Peserta Tender 
    Route::delete('proyek/peserta-tender/{id}/delete', [ProyekController::class, 'deleteTender']);

    // DELETE Dokumen Prakualifikasi
    Route::delete('proyek/dokumen-prakualifikasi/{id}/delete', [ProyekController::class, 'deleteDokumenPrakualifikasi']);

    // DELETE Dokumen Prakualifikasi
    Route::delete('proyek/risk-tender/{id}/delete', [ProyekController::class, 'deleteRiskTender']);

    // DELETE Attachment Menang
    Route::delete('/proyek/attachment-menang/{id}/delete', [ProyekController::class, 'deleteAttachmentMenang']);

    // ADD History Adendum 
    Route::post('proyek/adendum/add', [ProyekController::class, 'tambahAdendum']);

    // EDIT History Adendum 
    Route::post('proyek/adendum/{id}/edit', [ProyekController::class, 'editAdendum']);

    // DELETE History Adendum 
    Route::delete('proyek/adendum/{id}/delete', [ProyekController::class, 'deleteAdendum']);

    //End :: Project



    //Begin :: Forecast
    // Home Page Forecast
    Route::get('/forecast', [ForecastController::class, 'index']);

    Route::get('/forecast-internal', [ForecastController::class, 'viewForecastInternal']);

    Route::get('/forecast-kumulatif-eksternal', [ForecastController::class, 'viewForecastKumulatifEksternal']);

    Route::get('/forecast-kumulatif-eksternal-internal', [ForecastController::class, 'viewForecastKumulatifIncludeInternal']);

    // Home Page Forecast with Specific periode
    Route::get('/forecast/{periode}/{year}', [ForecastController::class, 'index']);

    // Get all data from database
    Route::post('/forecast', [ForecastController::class, 'getAllData']);
    Route::post('/forecast/unit-kerja', [ForecastController::class, 'getAllDataUnitKerjas']);
    // to NEW page 
    // Route::get('/proyek/new', [ProyekController::class, 'new']);

    // begin :: Set lock / unlock data month forecast
    Route::post('/forecast/set-lock', function (Request $request) {
        $data = $request->all();
        $from_user = Auth::user();


        // $history_forecast = HistoryForecast::where("periode_prognosa", "=", $request->periode_prognosa);
        // if (!empty($history_forecast->get()->all())) {
        //     $history_forecast->delete();
        // }

        $farestMonth = 0;
        $total_forecast = 0;
        $total_realisasi = 0;
        $total_rkap = 0;
        // $proyeks = Proyek::where("unit_kerja", $from_user->unit_kerja)->get()->sortBy("kode_proyek");
        $proyeks = Forecast::where("periode_prognosa", "=", $data["periode_prognosa"])->get()->groupBy("kode_proyek");
        foreach ($proyeks as $kode_proyek => $proyek) {
            // dump();
            // $total_realisasi += $proyek->sum("realisasi_forecast");
            $current_proyek = Proyek::find($kode_proyek);
            $forecasts = $proyek;
            // $forecasts = $proyek->filter(function ($p) {
            //     // return str_contains($p->created_at->format("m"), date("m")) && $p->nilai_forecast != 0 && $p->unit_kerja == Auth::user()->unit_kerja;
            //     // return str_contains($p->created_at->format("m"), date("m")) && $p->nilai_forecast != 0;
            //     return $p->nilai_forecast != 0;
            // });
            $forecasts = $proyek;
            if ($current_proyek->tipe_proyek == "R") {
                $history_forecast = new HistoryForecast();

                foreach ($forecasts as $forecast) {
                    $history_forecast->kode_proyek = $kode_proyek;
                    $history_forecast->nilai_forecast = $forecast->nilai_forecast;
                    $history_forecast->month_forecast = $forecast->month_forecast;
                    // $history_forecast->rkap_forecast = str_replace(".", "", (int) $current_proyek->nilai_rkap ?? 0) ?? 0;
                    $history_forecast->rkap_forecast = $forecast->rkap_forecast;
                    // $history_forecast->month_rkap = (int) $current_proyek->bulan_pelaksanaan ?? 1;
                    $history_forecast->month_rkap = $forecast->month_rkap;
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan == null ? 0 : str_replace(",", "", $current_proyek->nilai_kontrak_keseluruhan ?? 0);
                    $history_forecast->realisasi_forecast = $forecast->realisasi_forecast;
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan;
                    $history_forecast->month_realisasi = $forecast->month_realisasi;
                    $history_forecast->periode_prognosa = $request->periode_prognosa;
                    // if ($forecast->month_forecast > $farestMonth) {
                    //     $farestMonth = $forecast->month_forecast;
                    // }
                    // $total_forecast += $forecast->nilai_forecast;
                    // $total_realisasi += $forecast->realisasi_forecast;
                    // $total_rkap += $forecast->rkap_forecast;
                }
                $history_forecast->save();
            } else {
                $history_forecast = new HistoryForecast();

                foreach ($forecasts as $forecast) {

                    if ($forecast->month_forecast > $farestMonth) {
                        $farestMonth = $forecast->month_forecast;
                    }
                    $total_forecast += $forecast->nilai_forecast;
                    $total_realisasi += $forecast->realisasi_forecast;
                    $total_rkap += $forecast->rkap_forecast;
                }
                // RKAP, REALISASI
                $history_forecast->kode_proyek = $kode_proyek;
                $history_forecast->nilai_forecast = (string) $total_forecast;
                $history_forecast->month_forecast = $farestMonth;
                // $history_forecast->rkap_forecast = str_replace(".", "", (int) $current_proyek->nilai_rkap ?? 0) ?? 0;
                $history_forecast->rkap_forecast = $total_rkap;
                // $history_forecast->month_rkap = (int) $current_proyek->bulan_pelaksanaan ?? 1;
                $history_forecast->month_rkap = $current_proyek->bulan_awal;
                // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan == null ? 0 : str_replace(",", "", $current_proyek->nilai_kontrak_keseluruhan ?? 0);
                $history_forecast->realisasi_forecast = $current_proyek->nilai_perolehan == null ? 0 : str_replace(",", "", (int) $current_proyek->nilai_perolehan ?? 0) ?? 0;
                // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan;
                $history_forecast->month_realisasi = $current_proyek->bulan_ri_perolehan ?? 0;
                $history_forecast->periode_prognosa = $request->periode_prognosa;
                $history_forecast->save();
                // if ($index == $forecasts->count() - 1) {
                // }
            }
            $farestMonth = 0;
            $total_forecast = 0;
            $total_realisasi = 0;
            $total_rkap = 0;
        }
        return response()->json([
            "status" => "success",
            "msg" => "Forecast berhasil dikunci",
        ]);

        // dump($total_forecast);
        // if ($total_forecast != 0) {

        // }
        // $proyeks = Proyek::all()->groupBy("kode_proyek");
        // foreach ($proyeks as $proyek) {

        // }
        // return response()->json([
        //     "status" => "success",
        //     "msg" => "Forecast berhasil dikunci",
        // ]);
        // if (isset($data["set-lock"])) {

        // }

        // // $unit_kerjas = UnitKerja::where("divcode", Auth::user()->unit_kerja);
        // $unit_kerjas = UnitKerja::find(1);
        // // dd($unit_kerjas);
        // if (auth()->user()->check_administrator) {
        //     if ($unit_kerjas->metode_approval == "Sequence") {
        //         $next_user = [];
        //         $to_user = $unit_kerjas->User_1;
        //         if(!empty($unit_kerjas->User_2)) {
        //             array_push($next_user, $unit_kerjas->User_2->id);
        //         }

        //         if(!empty($unit_kerjas->User_3)) {
        //             array_push($next_user, $unit_kerjas->User_3->id);
        //         }
        //         // $next_user = $unit_kerjas->user_2;
        //         LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast", $next_user, 0, 0);
        //         // Alert::success("Success", "Forecast has been locked");
        //         return response()->json([
        //             "status" => "success",
        //             "msg" => "Silahkan tunggu sampai approval selesai. Cek notifikasi anda secara berkala!",
        //         ]);
        //     } else {
        //         // $unit_kerjas->each(function ($unit_kerja) {
        //         // });
        //     }
        //     // return response()->json([
        //     //     "status" => "success",
        //     //     "msg" => "OKe",
        //     // ]);
        // }
        // return response()->json([
        //     "status" => "failed",
        //     "msg" => "Maaf, anda bukan admin",
        // ]);
    });

    // Route::post('/forecast/set-lock', function (Request $request) {
    //     $data = $request->all();
    //     $proyeks = Forecast::where("periode_prognosa", "=", $data["periode_prognosa"])->get()->groupBy("kode_proyek");
    //     // loop 12 bulan
    //     // $kode_proyeks = array_keys($proyeks);
    //     foreach ($proyeks as $forecasts) {
    //         foreach ($forecasts as $f) {
    //             $proyek = Proyek::find($f->kode_proyek);
    //             for ($i = 1; $i <= 12; $i++) {
    //                 $history_forecast = new HistoryForecast();
    //                 $history_forecast->kode_proyek = $proyek->kode_proyek;
    //                 $history_forecast->nilai_forecast = $f->nilai_forecast;
    //                 $history_forecast->month_forecast = $f->month_forecast;
    //                 $history_forecast->month_rkap = $proyek->bulan_pelaksanaan ?? 0;
    //                 $history_forecast->rkap_forecast = str_replace(",", "", $proyek->nilai_rkap) ?? 0;
    //                 $history_forecast->realisasi_forecast = str_replace(",", "", $proyek->bulan_perolehan) ?? 0;
    //                 $history_forecast->month_realisasi = $proyek->nilai_perolehan ?? 0;
    //                 $history_forecast->periode_prognosa = $i;
    //                 $history_forecast->save();
    //             }
    //         }
    //     }
    // });


    Route::post('/forecast/set-unlock-previous-forecast', function (Request $request) {
        $data = $request->all();
        // HistoryForecast::where("periode_prognosa", "=", $data["periode_prognosa"])->delete();
        // $from_user = Auth::user();
        // $unit_kerjas = UnitKerja::find(1);
        // // dd($unit_kerjas);
        // if (auth()->user()->check_administrator) {
        //     if ($unit_kerjas->metode_approval == "Sequence") {
        //         $next_user = [];
        //         $to_user = $unit_kerjas->User_1;
        //         if (!empty($unit_kerjas->User_2)) {
        //             array_push($next_user, $unit_kerjas->User_2->id);
        //         }

        //         if (!empty($unit_kerjas->User_3)) {
        //             array_push($next_user, $unit_kerjas->User_3->id);
        //         }
        //         // $next_user = $unit_kerjas->user_2;
        //         LockForeacastEvent::dispatch($from_user, $to_user, "Request Unlock Forecast", $next_user, 0, 0);
        //         // Alert::success("Success", "Forecast has been locked");
        //         return response()->json([
        //             "status" => "success",
        //             "msg" => "Silahkan tunggu sampai approval selesai. Cek notifikasi anda secara berkala!",
        //         ]);
        //     } else {
        //         // $unit_kerjas->each(function ($unit_kerja) {
        //         // });
        //     }
        //     // return response()->json([
        //     //     "status" => "success",
        //     //     "msg" => "OKe",
        //     // ]);
        // }
        if (Auth::user()->check_administrator) {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode_prognosa"])->get();
        } else {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode_prognosa"])->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
        }
        dd($history_forecasts);
        foreach ($history_forecasts as $history_forecast) {
            $history_forecast->delete();
        }
        return response()->json([
            "status" => "success",
            // "msg" => "Forecast berhasil dibuka",
        ]);
    });

    Route::post('/forecast/set-unlock', function (Request $request) {
        $data = $request->all();
        // HistoryForecast::where("periode_prognosa", "=", $data["periode_prognosa"])->delete();
        // $from_user = Auth::user();
        // $unit_kerjas = UnitKerja::find(1);
        // // dd($unit_kerjas);
        // if (auth()->user()->check_administrator) {
        //     if ($unit_kerjas->metode_approval == "Sequence") {
        //         $next_user = [];
        //         $to_user = $unit_kerjas->User_1;
        //         if (!empty($unit_kerjas->User_2)) {
        //             array_push($next_user, $unit_kerjas->User_2->id);
        //         }

        //         if (!empty($unit_kerjas->User_3)) {
        //             array_push($next_user, $unit_kerjas->User_3->id);
        //         }
        //         // $next_user = $unit_kerjas->user_2;
        //         LockForeacastEvent::dispatch($from_user, $to_user, "Request Unlock Forecast", $next_user, 0, 0);
        //         // Alert::success("Success", "Forecast has been locked");
        //         return response()->json([
        //             "status" => "success",
        //             "msg" => "Silahkan tunggu sampai approval selesai. Cek notifikasi anda secara berkala!",
        //         ]);
        //     } else {
        //         // $unit_kerjas->each(function ($unit_kerja) {
        //         // });
        //     }
        //     // return response()->json([
        //     //     "status" => "success",
        //     //     "msg" => "OKe",
        //     // ]);
        // }
        if (Auth::user()->check_administrator) {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode_prognosa"])->get();
            # code...
        } else {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $request->periode_prognosa)->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
        }
        foreach ($history_forecasts as $history_forecast) {
            $history_forecast->delete();
        }
        return response()->json([
            "status" => "success",
            "msg" => "Forecast berhasil dibuka",
        ]);
    });
    // end :: Set lock / unlock data month forecast
    //End :: Forecast



    // Begin :: Master Data
    // Home Page Company
    Route::get('/company', [CompanyController::class, 'index']);

    // NEW Company after SAVE 
    Route::post('/company/save', [CompanyController::class, 'store']);

    // NEW Company EDIT 
    Route::post('/company/{id}/edit', [CompanyController::class, 'update']);

    // Delete Company  
    Route::delete('/company/delete/{id}', [CompanyController::class, 'delete']);

    // Home Sumber Dana
    Route::get('/sumber-dana', [SumberDanaController::class, 'index']);

    // NEW Sumber Dana after SAVE
    Route::post('/sumber-dana/save', [SumberDanaController::class, 'store']);

    // EDIT Sumber Dana
    Route::post('/sumber-dana/{id}/edit', [SumberDanaController::class, 'update']);

    // DELETE Sumber Dana
    Route::delete('/sumber-dana/delete/{id}', [SumberDanaController::class, 'delete']);

    // Home DOP
    Route::get('/dop', [DopController::class, 'index']);

    // NEW DOP after SAVE
    Route::post('/dop/save', [DopController::class, 'store']);

    // NEW DOP EDIT
    Route::post('/dop/{id}/save', [DopController::class, 'update']);

    // NEW DOP after SAVE
    Route::delete('/dop/delete/{id}', [DopController::class, 'delete']);

    // Home SBU
    Route::get('/sbu', [SbuController::class, 'index']);

    // NEW SBU after SAVE
    Route::post('/sbu/save', [SbuController::class, 'store']);

    // EDIT SBU
    Route::post('/sbu/{id}/edit', [SbuController::class, 'update']);

    // DELETE SBU
    Route::delete('/sbu/delete/{id}', [SbuController::class, 'delete']);

    // Home Unit Kerja
    Route::get('/unit-kerja', [UnitKerjaController::class, 'index']);

    // NEW Unit Kerja after SAVE
    Route::post('/unit-kerja/save', [UnitKerjaController::class, 'store']);

    // Setting Unit Kerja
    Route::post('/unit-kerja/setting/save', [UnitKerjaController::class, 'update']);

    // NEW Unit Kerja after SAVE
    Route::delete('/unit-kerja/delete/{id}', [UnitKerjaController::class, 'delete']);

    // Home Kriteria Pasar
    Route::get('/kriteria-pasar', [KriteriaPasarController::class, 'index']);

    // Home Kriteria Pasar
    Route::post('/kriteria-pasar/save', [KriteriaPasarController::class, 'store']);

    // Home Edit
    Route::post('/kriteria-pasar/{id}/edit', [KriteriaPasarController::class, 'update']);

    // Home Delete
    Route::delete('/kriteria-pasar/delete/{id}', [KriteriaPasarController::class, 'delete']);
    //End :: Master Data


    //Begin :: FAQ - KnowledgeBase
    Route::get('/knowledge-base',  [FaqsController::class, 'index']);

    Route::post('/knowledge-base/new',  [FaqsController::class, 'create']);

    Route::post('/knowledge-base/update',  [FaqsController::class, 'update']);

    Route::delete('/knowledge-base/delete/{id}',  [FaqsController::class, 'delete']);
    //End :: FAQ - KnowledgeBase


    //Begin :: History Autorisasi
    Route::get('/history-autorisasi', function () {
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja")->get();
        return view("/12_Autorisasi", compact("history_forecasts"));
    });
    //End :: History Autorisasi


    // Route::post("/contract-management/save/{id_contract}", function (Request $request, $id_contract) {
    //     $contract_management = ContractManagements::find($id_contract);
    //     $contract_management->id_contract = $request->number_contract;
    //     $contract_management->project_name = $request->project_name;
    //     $contract_management->contract_in = $request->start_date;
    //     $contract_management->contract_out = $request->due_date;
    //     $contract_management->value = $request->value_contract;

    //     if ($contract_management->save()) {
    //         return response(json_encode([
    //             "status" => "Success",
    //             "message" => "Kontrak ini berhasil disimpan",
    //         ]), 200, [
    //             "content-type" => "application/json"
    //         ]);
    //     }
    //     return response(json_encode([
    //         "status" => "Failed",
    //         "message" => "Kontrak ini gagal disimpan",
    //     ]), 200, [
    //         "content-type" => "application/json"
    //     ]);

    //     // $contract_management->num = $request->number_contract;
    // });

    Route::post("/review-contract/upload", [ContractManagementsController::class, "reviewContractUpload"]);

    Route::post("/review-pembatalan-kontrak/upload", [ContractManagementsController::class, "reviewPembatalanKontrak"]);

    Route::post("/issue-project/upload", [ContractManagementsController::class, "issueProjectUpload"]);

    Route::post("/question/upload", [ContractManagementsController::class, "questionUpload"]);

    Route::post("/input-risk/upload", [ContractManagementsController::class, "riskUpload"]);

    Route::post("/laporan-bulanan/upload", [ContractManagementsController::class, "monthlyReportUpload"]);

    Route::post("/serah-terima/upload", [ContractManagementsController::class, "handOverUpload"]);

    Route::post("/klarifikasi-negosiasi/upload", [ContractManagementsController::class, "klarifikasiNegoUpload"]);

    Route::post("/kontrak-tanda-tangan/upload", [ContractManagementsController::class, "kontrakTandaTanganUpload"]);

    Route::post("/dokumen-pendukung/upload", [ContractManagementsController::class, "dokumenPendukungUpload"]);

    Route::post("/perjanjian-kso/upload", [ContractManagementsController::class, "perjanjianKSO"]);

    Route::post("/mom-meeting/upload", [ContractManagementsController::class, "momMeeting"]);


    Route::get("/document/view/{id}/{id_document}", [DocumentController::class, "documentView"]);

    Route::get("/document/view/{id}/{id_document}/history", [DocumentController::class, "documentViewHistory"]);

    Route::post('/pasal/clear', [PasalController::class, "pasalClear"]);

    Route::post("/document/view/{id}/{id_document}/save", [DocumentController::class, "documentSave"]);

    Route::post('/stage/save', [StageController::class, "stageSave"]);

    Route::post('/stage/addendum/save', [StageController::class, "stageAddendumSave"]);

    Route::post('/pasal/save', [PasalController::class, "pasalSave"]);

    Route::post('/pasal/add', [PasalController::class, "pasalAdd"]);

    Route::post('/pasal/update', [PasalController::class, "pasalUpdate"]);

    Route::post('/pasal/import', [PasalController::class, "importPasal"]);

    // begin :: USERS
    Route::get('/user', function () {
        //Menggunakan metode Eager Loading agar memangkas loading query database 
        if (Auth::user()->check_administrator) {
            $users = User::with('UnitKerja')->get()->reverse();
        } else {
            $users = User::join("unit_kerjas", "unit_kerjas.divcode", "=", "users.unit_kerja")->where("unit_kerjas.divcode", "=", Auth::user()->unit_kerja)->get();
        }
        return view("/MasterData/User", ["users" => $users]);
        // return view("/MasterData/User", ["users" => User::all()->reverse()]);
    });
    // Route::get('/user', [UserController::class, 'index']);

    Route::get('/user/new', function () {
        return view("/User/newUser", ["unit_kerjas" => UnitKerja::all()]);
    });

    Route::post('/user/save', [UserController::class, "save"]);

    Route::post('/user/update', [UserController::class, "update"]);

    Route::delete('/user/delete/{id}', [UserController::class, "delete"]);

    Route::post('/user/password/reset', [UserController::class, "userResetPassword"]);

    Route::post('/user/password/reset/new', [UserController::class, "userNewPassword"]);

    Route::post('/user/password/reset/save', [UserController::class, "userNewPasswordSave"]);

    Route::post('/user/forecast/set-lock', [UserController::class, "requestLockAnswer"]);

    Route::post('/user/forecast/set-unlock', [UserController::class, "requestUnlockAnswer"]);

    Route::get('/user/view/{user}', [UserController::class, "view"]);

    Route::get('/team-proyek', [TeamProyekController::class, "index"]);
    // end :: USERS

    // begin RKAP
    Route::get('/rkap', function () {
        if (Auth::user()->check_administrator) {
            $unitkerjas = Proyek::sortable()->get()->groupBy("unit_kerja");
        } else {
            $unitkerjas = Proyek::sortable()->where("unit_kerja", "=", Auth::user()->unit_kerja)->get()->groupBy("unit_kerja");
        }

        $proyeks = [];
        foreach ($unitkerjas as $key => $unitkerja) {
            $proyek = Proyek::sortable()->where("unit_kerja", "=", $key)->get()->groupBy("tahun_perolehan");
            array_push($proyeks, $proyek);
            //    dump($proyeks);
        }
        // dd();

        return view("/11_Rkap", compact(["unitkerjas", "proyeks"]));
    });

    Route::get('/rkap/{divcode}/{tahun_pelaksanaan}', function ($divcode, $tahun_pelaksanaan, Request $request) {
        $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_pelaksanaan)->where("unit_kerja", "=", $divcode)->get();
        $rkaps = UnitKerja::where("divcode", "=", $divcode)->first();
        // dd($rkaps);

        return view("/Rkap/viewRkap", compact(["proyeks", "tahun_pelaksanaan", "rkaps"]));
    });
    // end RKAP

    // begin RKAP AWAL dan REVIEW
    Route::get('/ok-awal', function () {
        if (Auth::user()->check_administrator) {
            $unitkerjas = Proyek::sortable()->get()->groupBy("unit_kerja");
        } else {
            $unitkerjas = Proyek::sortable()->where("unit_kerja", "=", Auth::user()->unit_kerja)->get()->groupBy("unit_kerja");
        }

        $proyeks = [];
        foreach ($unitkerjas as $key => $unitkerja) {
            $proyek = Proyek::sortable()->where("unit_kerja", "=", $key)->get()->groupBy("tahun_perolehan");
            array_push($proyeks, $proyek);
            //    dump($proyeks);
        }
        // dd();

        return view("/11_Rkap", compact(["unitkerjas", "proyeks"]));
    });

    Route::get('/ok-review', function () {
        if (Auth::user()->check_administrator) {
            $unitkerjas = Proyek::sortable()->get()->groupBy("unit_kerja");
        } else {
            $unitkerjas = Proyek::sortable()->where("unit_kerja", "=", Auth::user()->unit_kerja)->get()->groupBy("unit_kerja");
        }

        $proyeks = [];
        foreach ($unitkerjas as $key => $unitkerja) {
            $proyek = Proyek::sortable()->where("unit_kerja", "=", $key)->get()->groupBy("tahun_perolehan");
            array_push($proyeks, $proyek);
            //    dump($proyeks);
        }
        // dd();

        return view("/11_Rkap", compact(["unitkerjas", "proyeks"]));
    });

    Route::get('/rkap/{divcode}/{tahun_pelaksanaan}', function ($divcode, $tahun_pelaksanaan, Request $request) {
        $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_pelaksanaan)->where("unit_kerja", "=", $divcode)->get();
        $rkaps = UnitKerja::where("divcode", "=", $divcode)->first();
        // dd($rkaps);

        return view("/Rkap/viewRkap", compact(["proyeks", "tahun_pelaksanaan", "rkaps"]));
    });
    // end RKAP AWAL dan REVIEW


    // begin email testing
    Route::get('/email', function () {
        return new UserPasswordEmail(auth()->user(), "test");
    });
    // end email testing

    // Begin Download Files
    Route::get('/download/{id}', function ($id) {
        if (File::exists(public_path("excel/$id"))) {
            return response()->download(public_path("excel/$id"));
        }
        return abort(403, "File Not Found");
    });
    Route::get('/download-pareto', function () {
        $paretoProyeks = Proyek::with(['UnitKerja'])->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja")->select(["proyeks.nama_proyek", "proyeks.stage", "proyeks.forecast", "unit_kerjas.unit_kerja"]);
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (Auth::user()->check_administrator) {
            $paretoProyeks = $paretoProyeks->get()->sortByDesc("forecast", SORT_NUMERIC)->slice(0, 25);
        } else if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $paretoProyeks = $paretoProyeks->get()->sortByDesc("forecast", SORT_NUMERIC)->slice(0, 25)->whereIn("unit_kerja", $unit_kerja_user->toArray());
        } else {
            $paretoProyeks = $paretoProyeks->get()->sortByDesc("forecast", SORT_NUMERIC)->slice(0, 25)->whereIn("unit_kerja", $unit_kerja_user);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        // Header
        $sheet->getStyle("A1:D1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', "Stage");
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai Forecast");

        // Content Excel
        $counter = 2;
        $paretoProyeks->each(function ($proyek) use ($sheet, &$counter) {
            $sheet->setCellValue("A" . $counter, $proyek->nama_proyek);
            $sheet->setCellValue("B" . $counter, $proyek->unit_kerja);
            $sheet->setCellValue("C" . $counter, DashboardController::getProyekStage($proyek->stage));
            $sheet->setCellValue("D" . $counter, $proyek->forecast);
            $counter++;
        });

        $writer = new Xlsx($spreadsheet);
        $file_name = "pareto-proyek-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));
        return response()->download(public_path("excel/$file_name"));
    });
    // End Download Files

    function writeDOCXFile($content)
    {
        $php_word = new PhpWord();
        $section = $php_word->addSection();
        // $html = "<p>test</p>";
        // $html .= "<b>test</b>";
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);
        $docx_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word);
        return $docx_writer;
    }

    function moveFileTemp(UploadedFile $file, $file_name)
    {
        $path = "words/";
        $file_name =  $file_name . "." . $file->getClientOriginalExtension();
        $result = $file->move(public_path($path), $file_name);

        return $result;
    }

    function moneyFormatToNumber(string $value)
    {
        return (int) str_replace(",", "", $value);
    }
});
