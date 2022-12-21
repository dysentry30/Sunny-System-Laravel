<?php

use App\Events\NotificationApproval;
use App\Models\User;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\UnitKerja;
use App\Models\Opportunity;
use App\Models\IndustryOwner;
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
use App\Http\Controllers\JenisProyekController;
use App\Http\Controllers\MataUangController;
use App\Http\Controllers\TipeProyekController;
use App\Models\IndustrySector;
use App\Models\JenisProyek;
use App\Models\MataUang;
use App\Models\Provinsi;
use App\Models\ProyekBerjalans;
use App\Models\Sbu;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Termwind\Components\Dd;

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

Route::get('/logout', [UserController::class, 'logout'])->middleware("userAuth");

// Route::post('/createUser', [UserController::class, 'testLogin']);
// end :: Login




Route::group(['middleware' => ["userAuth", "admin"]], function () {

    // Route::middleware(["admin", "adminKontrak", "userSales"])->group(function () {
    // });

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard-ccm/perolehan-kontrak', [DashboardController::class, 'dashboard_perolehan_kontrak']);

    Route::get('/dashboard-ccm/pelaksanaan-kontrak', [DashboardController::class, 'dashboard_pelaksanaan_kontrak']);

    Route::get('/dashboard-ccm/pemeliharaan-kontrak', [DashboardController::class, 'dashboard_pemeliharaan_kontrak']);

    Route::get('/dashboard/filter/{prognosa}/{type}/{month}', [DashboardController::class, 'getDataFilterPoint']);

    Route::get('/dashboard/filter/{prognosa}/{type}/{month}/{unit_kerja}', [DashboardController::class, 'getDataFilterPoint']);

    Route::get('/dashboard/triwulan/{prognosa}/{type}/{month}', [DashboardController::class, 'getDataFilterPointTriwulan']);

    Route::get('/dashboard/triwulan/{prognosa}/{type}/{month}/{unit_kerja}', [DashboardController::class, 'getDataFilterPointTriwulan']);

    Route::get('/dashboard/realisasi/{prognosa}/{type}/{unitKerja}', [DashboardController::class, 'getDataFilterPointRealisasi']);

    Route::get('/dashboard/realisasi/{prognosa}/{type}/{unitKerja}/{divcode}', [DashboardController::class, 'getDataFilterPointRealisasi']);

    Route::get('/dashboard/monitoring-proyek/{tipe}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/monitoring-proyek/{tipe}/{periode}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/monitoring-proyek/{tipe}/{periode}/{filter}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/terendah-terkontrak/{tipe}', [DashboardController::class, "getDataTerendahTerkontrak"]);

    Route::get('/dashboard/terendah-terkontrak/{tipe}/{filter}', [DashboardController::class, "getDataTerendahTerkontrak"]);

    Route::get('/dashboard/index-jumlah/{tipe}', [DashboardController::class, "getDataCompetitive"]);

    Route::get('/dashboard/index-jumlah/{tipe}/{filter}', [DashboardController::class, "getDataCompetitive"]);

    Route::get('/dashboard/index-nilai/{tipe}', [DashboardController::class, "getDataCompetitiveNilai"]);

    Route::get('/dashboard/index-nilai/{tipe}/{filter}', [DashboardController::class, "getDataCompetitiveNilai"]);

    Route::get('/dashboard/sumber-dana-rkap/{tipe}', [DashboardController::class, "getDataSumberDanaRKAP"]);

    Route::get('/dashboard/sumber-dana-rkap/{tipe}/{filter}', [DashboardController::class, "getDataSumberDanaRKAP"]);

    Route::get('/dashboard/sumber-dana-realisasi/{tipe}', [DashboardController::class, "getDataSumberDanaRealisasi"]);

    Route::get('/dashboard/sumber-dana-realisasi/{tipe}/{filter}', [DashboardController::class, "getDataSumberDanaRealisasi"]);

    Route::get('/dashboard/nilai-ok-per-divisi/{tipe}', [DashboardController::class, "getDataNilaiOK"]);

    // Route::get('/dashboard/nilai-ok-per-divisi/{tipe}/{filter}', [DashboardController::class, "getDataNilaiOK"]);

    Route::get('/dashboard/nilai-realisasi-per-divisi/{tipe}', [DashboardController::class, "getDataNilaiRealisasi"]);

    // Route::get('/dashboard/nilai-realisasi-per-divisi/{tipe}/{filter}', [DashboardController::class, "getDataNilaiRealisasi"]);

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

    // Delete Struktur Organisasi Attach  
    Route::get('/customer/struktur/{id}/attach/delete', [CustomerController::class, 'deleteStrukturAttach']);

    // Get nilai OK Customer  
    Route::post('/customer/get-nilai-ok', [CustomerController::class, 'getNilaiOKCustomer']);

    // Get nilai Piutang  
    Route::post('/customer/get-nilai-piutang', [CustomerController::class, 'getNilaiPiutangCustomer']);

    // Get nilai Laba Rugi  
    Route::post('/customer/get-nilai-laba-rugi', [CustomerController::class, 'getNilaiLabaRugiCustomer']);

    // Get kode nasabah  
    Route::post('/customer/get-kode-nasabah', [CustomerController::class, 'getKodeNasabah']);

    // Begin :: get Kabupaten
    Route::get(
        '/get-kabupaten/{id}',
        function ($id) {
            // $data_kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/$id.json")->json();
            $data_kabupaten = Provinsi::where("country_id", "=", $id)->get()->toJson();
            return $data_kabupaten;
        }
    );
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

    Route::get('/proyek-datatables/{datatables}', [ProyekController::class, 'view']);

    // direct to proyek after SAVE page 
    Route::post('/proyek/save', [ProyekController::class, 'save']);

    // VIEW to proyek and EDIT 
    Route::get('/proyek/view/{kode_proyek}', [ProyekController::class, 'edit']);

    Route::get('/proyek/view/{kode_proyek}/{periodePrognosa}', [ProyekController::class, 'edit']);

    // direct to Project after EDIT 
    Route::post('/proyek/update', [ProyekController::class, 'update']);

    Route::get('/proyek/export-proyek', [ProyekController::class, 'exportProyek']);

    Route::post('/proyek/update/retail', [ProyekController::class, 'updateRetail']);

    // Reset Porsi JO 
    Route::get('/proyek/reset-jo/{kode_proyek}', [ProyekController::class, 'resetJo']);

    Route::post('/proyek/forecast/{i}/{periodePrognosa}/retail', function (Request $request, $i, $periodePrognosa) {
        $data = $request->all();
        // dd($data, $i, $periodePrognosa);

        $findForecast = Forecast::where("kode_proyek", "=", $data["kode-proyek"])->where("month_forecast", "=", (int) $i)->where("periode_prognosa", "=", $periodePrognosa)->get()->first();
        // $tabPane = "kt_user_view_overview_forecast";

        if (empty($findForecast)) {
            $nullForecast = Forecast::where("kode_proyek", "=", $data["kode-proyek"])->where("month_forecast", "=", null)->where("periode_prognosa", "=", $periodePrognosa)->get()->first();
            if (!empty($nullForecast)) {
                $nullForecast->delete();
            }
            $forecast = new Forecast();
            $forecast->kode_proyek = $data["kode-proyek"];

            $forecast->nilai_forecast = (string) (str_replace(".", "", $data["nilaiforecast-" . $i] ?? 0));
            $forecast->month_forecast = (int) $i;

            $forecast->rkap_forecast = (string) (str_replace(".", "", $data["nilaiok-" . $i] ?? 0));
            $forecast->month_rkap = (int) $i;

            $forecast->realisasi_forecast = (string) (str_replace(".", "", $data["nilairealisasi-" . $i] ?? 0));
            $forecast->month_realisasi = (int) $i;

            // $prognosa = (int) date('m');
            $forecast->periode_prognosa = $periodePrognosa;

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

            // $prognosa = (int) date('m');
            $findForecast->periode_prognosa = $periodePrognosa;

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
        $forecast = Forecast::where("kode_proyek", "=", $data["kode_proyek"])->where("periode_prognosa", "=", $data["periode_prognosa"] ?? (int) date("m"))->orderByDesc("created_at");
        // $forecast = DB::select("SELECT * FROM forecasts WHERE kode_proyek='" . $data["kode_proyek"] . "' AND (" . "YEAR(created_at)=" . date("Y") . " OR YEAR(updated_at)=" . date("Y"). ");");
        if (!empty($forecast)) {
            $forecast->each(function ($f) {
                $f->delete();
            });
            $new_forecast = new Forecast();
            $new_forecast->kode_proyek = (string) $proyek->kode_proyek;
            $new_forecast->rkap_forecast = (string) $proyek->nilai_rkap;
            $new_forecast->month_rkap = (int) $proyek->bulan_pelaksanaan;
            $new_forecast->realisasi_forecast = (string) $proyek->nilai_perolehan ?? 0;
            $new_forecast->month_realisasi = (int) $proyek->bulan_ri_perolehan ?? null;
            $new_forecast->month_forecast = (int) $data["forecast_month"];
            $new_forecast->periode_prognosa = (int) $data["periode_prognosa"];
            $new_forecast->nilai_forecast = (string) $data["nilai_forecast"] * $per;

            if ($new_forecast->save()) {
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

    // DELETE Dokumen NDA
    Route::delete('proyek/dokumen-nda/{id}/delete', [ProyekController::class, 'deleteDokumenNda']);

    // DELETE Dokumen MOU
    Route::delete('proyek/dokumen-mou/{id}/delete', [ProyekController::class, 'deleteDokumenMou']);

    // DELETE Dokumen ECA
    Route::delete('proyek/dokumen-eca/{id}/delete', [ProyekController::class, 'deleteDokumenEca']);

    // DELETE Dokumen ICA
    Route::delete('proyek/dokumen-ica/{id}/delete', [ProyekController::class, 'deleteDokumenIca']);

    // DELETE Dokumen RKS
    Route::delete('proyek/dokumen-rks/{id}/delete', [ProyekController::class, 'deleteDokumenRks']);

    // DELETE Dokumen DRAFT
    Route::delete('proyek/dokumen-draft/{id}/delete', [ProyekController::class, 'deleteDokumenDraft']);

    // DELETE Dokumen ITB TOR
    Route::delete('proyek/dokumen-itb-tor/{id}/delete', [ProyekController::class, 'deleteDokumenItbTor']);

    // DELETE Dokumen Tender
    Route::delete('proyek/dokumen-tender/{id}/delete', [ProyekController::class, 'deleteDokumenTender']);

    // DELETE Dokumen Risk
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

    Route::get('/forecast-internal/{periode}/{year}', [ForecastController::class, 'viewForecastInternal']);


    Route::get('/forecast-kumulatif-eksternal', [ForecastController::class, 'viewForecastKumulatifEksternal']);

    Route::get('/forecast-kumulatif-eksternal-internal', [ForecastController::class, 'viewForecastKumulatifIncludeInternal']);

    Route::get('/forecast-kumulatif-eksternal/{periode}/{year}', [ForecastController::class, 'viewForecastKumulatifEksternal']);

    Route::get('/forecast-kumulatif-eksternal-internal/{periode}/{year}', [ForecastController::class, 'viewForecastKumulatifIncludeInternal']);

    // Home Page Forecast with Specific periode
    Route::get('/forecast/{periode}/{year}', [ForecastController::class, 'index']);

    // Home Page Forecast with Specific periode "KUMULATIF"
    Route::get('/forecast-kumulatif-eksternal/{periode}/{year}', [ForecastController::class, 'viewForecastKumulatifEksternal']);

    // Get all data from database
    Route::post('/forecast', [ForecastController::class, 'getAllData']);
    Route::post('/forecast/unit-kerja', [ForecastController::class, 'getAllDataUnitKerjas']);
    Route::get('/request-approval-history', [ForecastController::class, 'requestApprovalHistoryView']);
    Route::get('/request-approval-history/{periode}/{tahun}', [ForecastController::class, 'requestApprovalHistoryView']);
    // to NEW page 
    // Route::get('/proyek/new', [ProyekController::class, 'new']);

    Route::post('/history/request-unlock', function (Request $request) {
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->select(["history_forecast.*", "proyeks.unit_kerja"])->where("proyeks.unit_kerja", "=", $unit_kerja->divcode)->whereYear("history_forecast.created_at", "=", (int) date("Y"))->get();
        $history_forecasts->each(function ($h) {
            $h->is_request_unlock = "f";
            $h->save();
        });
        Alert::toast("Berhasil melakukan request unlock pada unit <b>$unit_kerja->unit_kerja</b>", 'success');
        return back();
    });

    Route::post('/history/unlock', function (Request $request) {
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->select(["history_forecast.*", "proyeks.unit_kerja"])->where("proyeks.unit_kerja", "=", $unit_kerja->divcode)->whereYear("history_forecast.created_at", "=", (int) date("Y"))->get();
        $history_forecasts->each(function ($h) {
            $h->is_request_unlock = "t";
            $h->save();
        });
        Alert::toast("Berhasil unlock untuk unit <b>$unit_kerja->unit_kerja</b>", 'success');
        return back();
    });

    WebSocketsRouter::webSocket("/testing-websocket", \App\Websockets\SocketHandlers\WebsocketHandler::class);

    Route::post('/forecast/set-lock/unit-kerja', function (Request $request) {
        $data = $request->all();
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $data["unit_kerja"])->first();
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->select(["history_forecast.*", "proyeks.unit_kerja"])->where("proyeks.unit_kerja", "=", $unit_kerja->divcode)->whereYear("history_forecast.created_at", "=", (int) date("Y"))->get();
        $history_forecasts->each(function ($h) use ($data) {
            $h->is_approved_1 = (bool) $data["is_approved"] ? "t" : "f";
            $h->save();
        });
        return response()->json([
            "status" => "Success",
            "msg" => "<b>$unit_kerja->unit_kerja</b> berhasil di approved",
        ]);
    });

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
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("periode_prognosa", "=", $data["periode_prognosa"])->get()->where("is_cancel", "!=", true)->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy("kode_proyek");
        } else {
            $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.unit_kerja", $unit_kerja_user)->where("periode_prognosa", "=", $data["periode_prognosa"])->get()->where("is_cancel", "!=", true)->groupBy("kode_proyek");
        }
        // $proyeks = Proyek::where("unit_kerja", $from_user->unit_kerja)->get()->sortBy("kode_proyek");
        foreach ($proyeks as $kode_proyek => $proyek) {
            // dump();
            // $total_realisasi += $proyek->sum("realisasi_forecast");
            $current_proyek = Proyek::find($kode_proyek);
            // dd($proyek);
            $forecasts = $proyek;
            // $forecasts = $proyek->filter(function ($p) {
            //     // return str_contains($p->created_at->format("m"), date("m")) && $p->nilai_forecast != 0 && $p->unit_kerja == Auth::user()->unit_kerja;
            //     // return str_contains($p->created_at->format("m"), date("m")) && $p->nilai_forecast != 0;
            //     return $p->nilai_forecast != 0;
            // });
            if ($current_proyek->tipe_proyek == "R") {
                $history_forecast_count = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->where("periode_prognosa", "=", $data["periode_prognosa"])->get();
                if ($history_forecast_count->count() > 0) continue;
                // dd($current_proyek);
                foreach ($forecasts as $forecast) {
                    $history_forecast = new HistoryForecast();
                    // if ($forecast->month_forecast > $farestMonth) {
                    //     $farestMonth = $forecast->month_forecast;
                    // }
                    // $total_forecast += (int) $forecast->nilai_forecast;
                    // $total_realisasi += (int) $forecast->realisasi_forecast;
                    // $total_rkap += (int) $forecast->rkap_forecast;
                    $history_forecast->kode_proyek = $kode_proyek;
                    $history_forecast->nilai_forecast = $forecast->nilai_forecast ?? "0";
                    $history_forecast->month_forecast = $forecast->month_forecast;
                    // $history_forecast->rkap_forecast = str_replace(".", "", (int) $current_proyek->nilai_rkap ?? 0) ?? 0;
                    if (!empty($forecast->rkap_forecast)) {
                        $history_forecast->rkap_forecast = $forecast->rkap_forecast ?? "0";
                    } else {
                        $history_forecast->rkap_forecast = "0";
                    }
                    $history_forecast->month_rkap = (int) $forecast->month_rkap;
                    // $history_forecast->month_rkap = $forecast->month_rkap;
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan == null ? 0 : str_replace(",", "", $current_proyek->nilai_kontrak_keseluruhan ?? 0);
                    $history_forecast->realisasi_forecast = $forecast->realisasi_forecast ?? "0";
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan;
                    $history_forecast->month_realisasi = $forecast->month_realisasi;
                    $history_forecast->periode_prognosa = $request->periode_prognosa;
                    $history_forecast->save();
                }
            } else {

                $history_forecast_count = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->where("periode_prognosa", "=", $data["periode_prognosa"])->get();
                if ($history_forecast_count->count() > 0) continue;
                $history_forecast = new HistoryForecast();

                foreach ($forecasts as $forecast) {

                    if ($forecast->month_forecast > $farestMonth) {
                        $farestMonth = $forecast->month_forecast;
                    }
                    $total_forecast += (int) $forecast->nilai_forecast ?? 0;
                    $total_realisasi += (int) $forecast->realisasi_forecast;
                    $total_rkap += (int) $forecast->rkap_forecast ?? 0;
                }
                // RKAP, REALISASI
                $history_forecast->kode_proyek = $kode_proyek;
                $history_forecast->nilai_forecast = (string) $total_forecast;
                $history_forecast->month_forecast = $farestMonth;
                // $history_forecast->rkap_forecast = str_replace(".", "", (int) $current_proyek->nilai_rkap ?? 0) ?? 0;
                $history_forecast->rkap_forecast = (string) $total_rkap;
                $history_forecast->month_rkap = (int) $current_proyek->bulan_pelaksanaan ?? 1;
                // $history_forecast->month_rkap = $current_proyek->bulan_pelaksa;
                // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan == null ? 0 : str_replace(",", "", $current_proyek->nilai_kontrak_keseluruhan ?? 0);
                if ($current_proyek->stage == 8) {
                    $history_forecast->realisasi_forecast = $total_realisasi ?? "0";
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan;
                    $history_forecast->month_realisasi = $current_proyek->bulan_ri_perolehan ?? 0;
                }
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
        $data = $request->all();
        if (isset($data["unit_kerja"])) {
            $unit_kerja = UnitKerja::where("unit_kerja", "=", $data["unit_kerja"])->first();
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("proyeks.unit_kerja", $unit_kerja->divcode)->select("history_forecast.*")->get();
        } else {
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(
                ",",
                Auth::user()->unit_kerja
            )) : Auth::user()->unit_kerja;
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->whereIn("unit_kerja", $unit_kerja_user->toArray());
            } else {
                $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("proyeks.unit_kerja", $unit_kerja_user);
            }
        }
        // if (Auth::user()->check_administrator) {
        //     $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode_prognosa"])->get();
        //     # code...
        // } else {
        //     $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $request->periode_prognosa)->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
        // }
        foreach ($history_forecasts as $history_forecast) {
            $history_forecast->delete();
        }
        if ($request->ajax()) {
            return response()->json([
                "status" => "success",
                "msg" => "Forecast berhasil dibuka",
            ]);
        }
        Alert::success('Success', "History berhasil dihapus");
        return back();
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

    // Home Mata Uang
    Route::get('/mata-uang', [MataUangController::class, 'index']);

    // Save Mata Uang
    Route::post('/mata-uang/save', [MataUangController::class, 'store']);

    // Delete Mata Uang
    Route::delete('/mata-uang/delete/{id}', [MataUangController::class, 'delete']);

    // Home Jenis Proyek
    Route::get('/jenis-proyek', [JenisProyekController::class, 'index']);

    // Save Jenis Proyek
    Route::post('/jenis-proyek/save', [JenisProyekController::class, 'store']);

    // Delete Jenis Proyek
    Route::delete('/jenis-proyek/delete/{id}', [JenisProyekController::class, 'delete']);

    // Home Tipe Proyek
    Route::get('/tipe-proyek', [TipeProyekController::class, 'index']);

    // Save Tipe Proyek
    Route::post('/tipe-proyek/save', [TipeProyekController::class, 'store']);

    // Delete Tipe Proyek
    Route::delete('/tipe-proyek/delete/{id}', [TipeProyekController::class, 'delete']);

    // Master Data Industry Owner
    Route::get('/industry-owner', function (Request $request) {
        $industryOwners = IndustryOwner::all();
        return view("/MasterData/IndustryOwner", compact(["industryOwners"]));
    });

    // Master Data Provinsi
    Route::get('/provinsi', function (Request $request) {
        $provinsi = Provinsi::all();
        return view("/MasterData/Provinsi", compact(["provinsi"]));
    });

    // Master Data Industry Sector
    Route::get('/industry-sector', function (Request $request) {
        // $provinsi = Provinsi::all();
        // $industrySector = json_decode(Http::get("https://fioridev.wika.co.id/ywikasd002/industry-sector?sap-client=200"));
        $industrySector = IndustrySector::all();
        return view("/MasterData/IndustrySectors", compact(["industrySector"]));
    });

    Route::get('/industry-sector/get', function (Request $request) {
        // $provinsi = Provinsi::all();
        try {
            $uname = "WIKA_INT";
            $pass = "Initial123";
            $author = base64_encode($uname . ":" . $pass);
            $industrySector = getApi("https://fiori.wika.co.id/ywikasd002/industry-sector?sap-client=300", "", ["Authorization: Basic $author"], false);
            $industrySector = collect($industrySector->DATA)->mapInto(\Illuminate\Support\Collection::class);
            // $industrySector = collect(json_decode(Http::get("https://fioridev.wika.co.id/ywikasd002/industry-sector?sap-client=200")));
            if ($industrySector->isEmpty()) {
                $data = [
                    "status" => false,
                    "data" => [
                        "msg" => "Data tidak ditemukan!",
                    ],
                ];
                return response()->json($data, 500);
            }
            // dd($industrySector);
            // $industrySector = collect([
            //     "devid" => "",
            //     "packageid" => "EB2618CE98301EDD96FCF101025538F9",
            //     "cocode" => "A000",
            //     "prctr" => "",
            //     "timestamp" => "20221104022229",
            //     "data" => [
            //         [
            //             "braco" => "0001",
            //             "vtext" => "Industry code 01"
            //         ],
            //         [
            //             "braco" => "Z01",
            //             "vtext" => "Telekomuni:Infrastru"
            //         ],
            //         [
            //             "braco" => "Z02",
            //             "vtext" => "Farmasi"
            //         ],
            //         [
            //             "braco" => "Z03",
            //             "vtext" => "Jalan Tol"
            //         ],
            //         [
            //             "braco" => "Z04",
            //             "vtext" => "Makanan & Minuman"
            //         ],
            //         [
            //             "braco" => "Z05",
            //             "vtext" => "Telekomuni:Jasa tele"
            //         ],
            //         [
            //             "braco" => "Z06",
            //             "vtext" => "Jasa Kesehatan"
            //         ],
            //         [
            //             "braco" => "Z07",
            //             "vtext" => "CPO"
            //         ],
            //         [
            //             "braco" => "Z08",
            //             "vtext" => "AngktnLaut:Kontainer"
            //         ],
            //         [
            //             "braco" => "Z09",
            //             "vtext" => "AngktnLaut:Penyebran"
            //         ],
            //         [
            //             "braco" => "Z10",
            //             "vtext" => "AngktnLaut:Tanker"
            //         ],
            //         [
            //             "braco" => "Z11",
            //             "vtext" => "Gula"
            //         ],
            //         [
            //             "braco" => "Z12",
            //             "vtext" => "Pertambangan Nikel"
            //         ],
            //         [
            //             "braco" => "Z13",
            //             "vtext" => "Industri Nikel"
            //         ],
            //         [
            //             "braco" => "Z14",
            //             "vtext" => "Ketenagalistrikan"
            //         ],
            //         [
            //             "braco" => "Z15",
            //             "vtext" => "Pakan Ternak"
            //         ],
            //         [
            //             "braco" => "Z16",
            //             "vtext" => "Perdagangan Besar"
            //         ],
            //         [
            //             "braco" => "Z17",
            //             "vtext" => "Perdagangan Ritel"
            //         ],
            //         [
            //             "braco" => "Z18",
            //             "vtext" => "Perkebunan Lainnya"
            //         ],
            //         [
            //             "braco" => "Z19",
            //             "vtext" => "Petrokimia Hulu"
            //         ],
            //         [
            //             "braco" => "Z20",
            //             "vtext" => "Pulp & Paper"
            //         ],
            //         [
            //             "braco" => "Z21",
            //             "vtext" => "Pupuk"
            //         ],
            //         [
            //             "braco" => "Z22",
            //             "vtext" => "Rokok"
            //         ],
            //         [
            //             "braco" => "Z23",
            //             "vtext" => "Konstruksi Infrastru"
            //         ],
            //         [
            //             "braco" => "Z24",
            //             "vtext" => "Multifinance"
            //         ],
            //         [
            //             "braco" => "Z25",
            //             "vtext" => "Otomotif"
            //         ],
            //         [
            //             "braco" => "Z26",
            //             "vtext" => "PropResidnsial:Apart"
            //         ],
            //         [
            //             "braco" => "Z27",
            //             "vtext" => "PropResidnsial:Perum"
            //         ],
            //         [
            //             "braco" => "Z28",
            //             "vtext" => "Retail Telekomunikas"
            //         ],
            //         [
            //             "braco" => "Z29",
            //             "vtext" => "Furniture"
            //         ],
            //         [
            //             "braco" => "Z30",
            //             "vtext" => "Angkutan Darat"
            //         ],
            //         [
            //             "braco" => "Z31",
            //             "vtext" => "Industri Elektro"
            //         ],
            //         [
            //             "braco" => "Z32",
            //             "vtext" => "Batu Bara"
            //         ],
            //         [
            //             "braco" => "Z33",
            //             "vtext" => "Hulu Gas"
            //         ],
            //         [
            //             "braco" => "Z34",
            //             "vtext" => "Hulu Minyak"
            //         ],
            //         [
            //             "braco" => "Z35",
            //             "vtext" => "Alat Berat"
            //         ],
            //         [
            //             "braco" => "Z36",
            //             "vtext" => "Perikanan"
            //         ],
            //         [
            //             "braco" => "Z37",
            //             "vtext" => "Karet."
            //         ],
            //         [
            //             "braco" => "Z38",
            //             "vtext" => "Semen"
            //         ],
            //         [
            //             "braco" => "Z39",
            //             "vtext" => "Angkutan Udara."
            //         ],
            //         [
            //             "braco" => "Z40",
            //             "vtext" => "Prop:Pusat Perbelanj"
            //         ],
            //         [
            //             "braco" => "Z41",
            //             "vtext" => "Prhotelan Bintang4&5"
            //         ],
            //         [
            //             "braco" => "Z42",
            //             "vtext" => "Prhotelan Bintang123"
            //         ],
            //         [
            //             "braco" => "Z43",
            //             "vtext" => "Prdagangn Besar Tele"
            //         ],
            //         [
            //             "braco" => "Z44",
            //             "vtext" => "AngktnLaut: Tug&barg"
            //         ],
            //         [
            //             "braco" => "Z45",
            //             "vtext" => "Angktn Laut: Penunja"
            //         ],
            //         [
            //             "braco" => "Z46",
            //             "vtext" => "Baja"
            //         ],
            //         [
            //             "braco" => "Z47",
            //             "vtext" => "Plastik."
            //         ],
            //         [
            //             "braco" => "Z48",
            //             "vtext" => "Tekstil&Produk Tekst"
            //         ],
            //         [
            //             "braco" => "Z49",
            //             "vtext" => "Prop:Perkantoran"
            //         ],
            //         [
            //             "braco" => "Z50",
            //             "vtext" => "Jasa Pengemb SDM"
            //         ]
            //     ]
            // ]);
            $industrySector->each(function ($i) {
                $is_industry_sector_exist = IndustrySector::find($i["BRACO"]);
                if (empty($is_industry_sector_exist)) {
                    $new_industry_sector = new IndustrySector();
                    $new_industry_sector->id_industry_sector = $i["BRACO"];
                    $new_industry_sector->description = $i["VTEXT"];
                    $new_industry_sector->save();
                }
            });

            $data = [
                "status" => true,
                "data" => [
                    "msg" => "Get Industry Sector berhasil"
                ],
            ];
            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                "status" => false,
                "data" => [
                    "msg" => $e->getMessage(),
                ],
            ];
            return response()->json($data, 500);
        }
        // $industrySector = IndustrySector::all();
        // return view("/MasterData/IndustrySectors", compact(["industrySector"]));
    });
    //End :: Master Data


    //Begin :: FAQ - KnowledgeBase
    Route::get('/knowledge-base',  [FaqsController::class, 'index']);

    Route::post('/knowledge-base/new',  [FaqsController::class, 'create']);

    Route::post('/knowledge-base/update',  [FaqsController::class, 'update']);

    Route::delete('/knowledge-base/delete/{id}',  [FaqsController::class, 'delete']);
    //End :: FAQ - KnowledgeBase


    //Begin :: History Autorisasi
    Route::get('/history-autorisasi', function (Request $request) {
        $periodeOtor = $request->query("periode-prognosa") ?? (int) date('m') - 1;
        // $periodeOtor = (int) date('m');
        if ($periodeOtor == 1) {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("stage", "!=", 7)->where("is_cancel", "!=", true)->where("periode_prognosa", "=", $periodeOtor)->whereYear("history_forecast.created_at", "=", (int) date("Y") - 1)->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        } else {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("stage", "!=", 7)->where("is_cancel", "!=", true)->where("periode_prognosa", "=", $periodeOtor)->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        }

        // dd($history_forecasts->select(["proyeks.kode_proyek","proyeks.unit_kerja", "unit_kerjas.unit_kerja", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "nilai_forecast", "realisasi_forecast"])->get()->first());
        $history_forecasts = $history_forecasts->select(["proyeks.kode_proyek", "proyeks.unit_kerja", "unit_kerjas.unit_kerja", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "rkap_forecast", "nilai_forecast", "realisasi_forecast", "is_approved_1"])->get()->groupBy("unit_kerja");

        // $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("stage", "!=", 7)->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        // $history_forecasts = $history_forecasts->get()->groupBy("unit_kerja");
        return view("/12_Autorisasi", compact("history_forecasts", "periodeOtor"));
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
        } else if (str_contains(auth()->user()->name, "(PIC)")) {
            $users = User::with('UnitKerja')->get()->reverse()->where("check_administrator", "!=", true);
        } else {
            $users = User::join("unit_kerjas", "unit_kerjas.divcode", "=", "users.unit_kerja")->where("unit_kerjas.divcode", "=", Auth::user()->unit_kerja)->get();
        }
        return view("/MasterData/User", ["users" => $users, "unit_kerjas" => UnitKerja::all()]);
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

    Route::get('/user/password/reset/new', [UserController::class, "userNewPassword"]);

    Route::post('/user/password/reset/save', [UserController::class, "userNewPasswordSave"]);

    Route::post('/user/forecast/set-lock', [UserController::class, "requestLockAnswer"]);

    Route::post('/user/forecast/set-unlock', [UserController::class, "requestUnlockAnswer"]);

    Route::post('/check-current-password', [UserController::class, "checkCurrentPassword"]);

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

});

// Begin API PROYEK XML
// Route::get("/detail-proyek-xml", function (Request $request) {
//     return view("detailProyekXML/detailProyekXML");
// });

// Route::get('/get-proyek-xml', function (Request $request) {
//     $data = File::get(public_path('faqs/f6h4IX1u'));
//     // return response()->header("Content-Type", "text/plain")->download(public_path('faqs/f6h4IX1u'));
//     return response($data)->header("Content-Type", "text/xml");
// });

// Route::get('/detail-proyek-xml/OpportunityCollection', function (Request $request) {
//     dd($request);
//     $periode = getPeriode(date("Y") . date("m"));
//     // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
//     // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
//     // $proyeks = Proyek::where("tahun_perolehan", "=", $periode[0])->where("stage", "=", 8)->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak"])->filter(function ($p) use ($periode) {
//     $proyeks = Proyek::where("stage", "=", 8)->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak", "provinsi", "negara", "sistem_bayar", "sumber_dana", "sbu", "jenis_terkontrak", "lokasi_tender", "mata_uang_review", "mata_uang_awal"])->filter(function ($p) use ($periode) {
//         if ($periode[1] == 1) {
//             $is_forecast_exist = $p->Forecasts->where("periode_prognosa", ((int) $periode[1] + 11))->whereYear("created_at", "=", ((int) date("Y") - 1))->count() > 0;
//         } else {
//             $is_forecast_exist = $p->Forecasts->where("periode_prognosa", ((int) $periode[1] - 1))->count() > 0;
//         }
//         unset($p->Forecasts);
//         return $is_forecast_exist;
//     });
//     // if (isset($request->unitkerjaid)) {
//     //     // $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->where("bulan_pelaksanaan", "=", $periode[1])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"]);
//     // } else {
//     //     return response()->json([
//     //         "status" => 400,
//     //         "msg" => "Unit Kerja Not Found"
//     //     ], 400);
//     // }

//     $proyeks = $proyeks->map(function ($p) use ($request) {
//         // $p->Id = $p->id;
//         $p->Category = "";
//         $p->title = "";
//         $p->updated = $p->updated_at;
//         $p->author = [
//             "name" => ""
//         ];
//         $p->Account = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Name" => ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first()->name_customer ?? "",
//                             "UsrKdNasabah" => $p->kode_nasabah ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];
//         $p->UsrProvinsi = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Description" => $p->provinsi ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];
//         $p->UsrNegara = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Description" => $p->negara ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];
//         $p->UsrSistemPembayaran = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Description" => $p->sistem_bayar ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];
//         $p->UsrMataUang = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "ShortName" => $p->mata_uang_awal != null ? ($p->mata_uang_review != null ? "" : $p->mata_uang_review) : $p->mata_uang_awal,
//                         ]
//                     ]
//                 ]
//             ]
//         ];

//         $p->UsrJenisKontrak = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Description" => $p->jenis_terkontrak ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];

//         $p->UsrSumberDanaL = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Name" => $p->sumber_dana ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];

//         $p->UsrSBUL = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "UsrKode" => $p->sbu,
//                         ]
//                     ]
//                 ]
//             ]
//         ];

//         $p->UsrJenis = [
//             "inline" => [
//                 "entry" => [
//                     "content" => [
//                         "properties" => [
//                             "Name" => JenisProyek::find($p->jenis_proyek)->jenis_proyek ?? "",
//                         ]
//                     ]
//                 ]
//             ]
//         ];

//         // $sign = ":";
//         $p->content = [
//             "m:properties" => [
//                 "d:Id" => DB::table("proyek_code_crm")->where("nama_proyek_crm", '=', $p->nama_proyek)->first()->uuid_crm ?? $p->id,
//                 "d:Title" => $p->nama_proyek,
//                 "d:UsrKontrakMulai" => $p->tanggal_mulai_terkontrak,
//                 "d:UsrAkhirKontrak" => $p->tanggal_akhir_terkontrak,
//                 "d:UsrNoSPK" => $p->nospk_external,
//                 "d:UsrBASTPHO" => $p->tanggal_selesai_pho,
//                 "d:UsrBASTFHO" => $p->tanggal_selesai_fho,
//                 "d:UsrPorsi" => $p->porsi_jo,
//                 "d:UsrNilaiKontrak" => $p->nilai_perolehan,
//                 "d:UsrKlasifikasiProyek" => $p->klasifikasi_terkontrak,
//                 "d:UsrNoKontrak" => $p->nomor_terkontrak,
//                 "d:UsrNilaiTukar" => $p->kurs_review,
//                 "d:UsrValas" => $p->nilai_valas_review,
//                 "d:UsrTanggalSPKEkternal" => $p->tglspk_internal,
//                 "d:UsrTanggalKontrak" => $p->tanggal_terkontrak,
//                 "d:UsrNilaiKontrakKeseluruhan" => $p->nilai_kontrak_keseluruhan,
//                 "d:UsrKodeProyek" => DB::table("proyek_code_crm")->where("nama_proyek_crm", '=', $p->nama_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek,
//             ],
//         ];
//         // $p->ap_id = "";
//         // switch ($p->jenis_proyek) {
//         //     case "I":
//         //         $p->UsrJenis = "Internal";
//         //         break;
//         //     case "N":
//         //         $p->UsrJenis = "Eksternal";
//         //         break;
//         //     case "J":
//         //         $p->UsrJenis = "JO";
//         //         break;
//         // };
//         // $p->UsrNoKontrak = $p->nomor_terkontrak;
//         // $p->UsrNilaiTukar = $p->kurs_review;
//         // $p->UsrValas = $p->nilai_valas_review;
//         // $p->UsrTanggalSPKEkternal = $p->tglspk_internal;
//         // $p->UsrTanggalKontrak = $p->tanggal_terkontrak;
//         // $proyek_berjalan = ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first();
//         // $p->Account = [
//         //     "Name" => $proyek_berjalan->name ?? NULL,
//         //     "UsrKdNasabah" => $proyek_berjalan->customer->kode_nasabah ?? NULL,
//         // ];
//         // $p->UsrProvinsi = $p->provinsi;
//         // $p->UsrNegara = $p->negara;
//         // $p->UsrSumberDana = $p->sumber_dana;
//         // $p->UsrSistemPembayaran = $p->sistem_bayar;
//         // $p->UsrMataUang = $p->sistem_bayar;
//         // $p->UsrJenisKontrak = $p->jenis_terkontrak;
//         // $p->UsrNilaiKontrakKeseluruhan = $p->nilai_kontrak_keseluruhan;
//         // if (str_contains($p->kode_proyek, "KD")) {
//         //     $p->UsrKodeProyek = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
//         // } else {
//         //     $p->UsrKodeProyek = $p->kode_proyek;
//         // }
//         // switch ($p->stage) {
//         //     case 0:
//         //         $p->tahap = "Pasar Dini";
//         //         break;
//         //     case 1:
//         //         $p->tahap = "Pasar Dini";
//         //         break;
//         //     case 2:
//         //         $p->tahap = "Pasar Potensial";
//         //         break;
//         //     case 3:
//         //         $p->tahap = "Prakualifikasi";
//         //         break;
//         //     case 4:
//         //         $p->tahap = "Tender Diikuti";
//         //         break;
//         //     case 5:
//         //         $p->tahap = "Perolehan";
//         //         break;
//         //     case 6:
//         //         $p->tahap = "Menang";
//         //         break;
//         //     case 7:
//         //         $p->tahap = "Terendah";
//         //         break;
//         //     case 8:
//         //         $p->tahap = "Terkontrak";
//         //         break;
//         // }
//         unset($p->jenis_proyek, $p->unit_kerja, $p->kode_proyek, $p->tanggal_mulai_terkontrak, $p->tanggal_akhir_terkontrak, $p->id);
//         unset($p->tanggal_selesai_pho, $p->tanggal_selesai_fho, $p->nama_proyek, $p->nospk_external, $p->porsi_jo, $p->nilai_kontrak_keseluruhan);
//         unset($p->nilai_kontrak_keseluruhan, $p->nilai_valas_review, $p->tanggal_terkontrak, $p->nilai_perolehan, $p->kurs_review, $p->klasifikasi_terkontrak);
//         unset($p->nomor_terkontrak, $p->tglspk_internal);
//         unset($p->provinsi, $p->negara, $p->sistem_bayar, $p->sumber_dana, $p->sbu, $p->jenis_terkontrak, $p->lokasi_tender, $p->mata_uang_review, $p->mata_uang_awal);

//         return $p;
//     });
//     $data = $proyeks->toArray();
//     $taken_date = Carbon\Carbon::now()->translatedFormat("d F Y H:i:s");
//     // creating object of SimpleXMLElement
//     $xml_data = new SimpleXMLElement('<(?)xml version="1.0" encoding="utf-8"(?)> <feed xml:base="https://crm.wika.co.id/detail-proyek-xml" xmlns="http://www.w3.org/2005/Atom" xmlns:d="http://schemas.microsoft.com/ado/2007/08/dataservices" xmlns:m="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata" xmlns:georss="http://www.georss.org/georss" xmlns:gml="http://www.opengis.net/gml"> <title type="text">OpportunityCollection</title> <updated>'. $taken_date .'</updated> </feed>');
//     // <id>https://crm.wika.co.id/api/detail-proyek-xml</id> 
//     // function call to convert array to xml
//     $data = arrayToXML($data, $xml_data);
//     // print_r($data);
//     // $data = str_replace(array("\r", "\n"), "", $data);
//     return response($data)->header("Content-Type", "text/xml");
// });

Route::get('/detail-proyek-xml/OpportunityCollection/{unitKerja}', function (Request $request, $unitKerjaPis) {
    // dd($request, $unitKerjaPis);
    $periode = getPeriode(date("Y") . date("m"));
    // $forecasts = Forecast::with(["Proyek"])->get(["*"])->unique("kode_proyek");
    // $forecasts = Proyek::where("periode_prognosa", '=', (int) $prognosa)->whereYear("created_at", "=", $tahun)->get();
    // $proyeks = Proyek::where("tahun_perolehan", "=", $periode[0])->where("stage", "=", 8)->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak"])->filter(function ($p) use ($periode) {
    $periodeOtor = 0;
    $yearOtor = 0;
    $proyeks = Proyek::where("stage", "=", 8)->where("unit_kerja", "=", $unitKerjaPis)->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak", "provinsi", "negara", "sistem_bayar", "sumber_dana", "sbu", "jenis_terkontrak", "lokasi_tender", "mata_uang_review", "mata_uang_awal", "longitude", "latitude"])->filter(function ($p) use (&$periodeOtor, $periode, &$yearOtor) {
        if ($periode[1] == 1) {
            $periodeOtor = 12;
            $yearOtor = (int) date("Y") - 1;
            $is_forecast_exist = $p->HistoryForecasts->where("periode_prognosa", ((int) $periode[1] + 11))->whereYear("created_at", "=", $yearOtor)->count() > 0;
        } else {
            $periodeOtor = $periode[1] - 1;
            $yearOtor = (int) date("Y");
            $is_forecast_exist = $p->HistoryForecasts->where("periode_prognosa", ((int) $periode[1] - 1))->count() > 0;
        }
        unset($p->HistoryForecasts);
        return $is_forecast_exist;
    });

    // if (isset($request->unitkerjaid)) {
    //     // $proyeks = Proyek::where("unit_kerja", "=", $request->unitkerjaid)->where("tahun_perolehan", "=", $periode[0])->where("bulan_pelaksanaan", "=", $periode[1])->get(["nama_proyek", "kode_proyek", "unit_kerja", "jenis_proyek", "stage", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak"]);
    // } else {
    //     return response()->json([    
    //         "status" => 400,
    //         "msg" => "Unit Kerja Not Found"
    //     ], 400);
    // }

    $proyeks = $proyeks->map(function ($p) use ($yearOtor, $periodeOtor, $request) {
        // $p->Id = $p->id;
        $p->Category = "";
        $p->title = "";
        $p->updated = $p->updated_at;
        $p->author = [
            "name" => ""
        ];
        $p->Account = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "Name" => ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first()->name_customer ?? "",
                            "UsrKdNasabah" => ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first()->customer->kode_nasabah ?? "",
                        ]
                    ]
                ]
            ]
        ];
        $p->UsrProvinsi = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "Description" => (isset($p->Provinsi) || !empty($p->Provinsi)) ? $p->provinsi : Provinsi::where("province_name", "=", $p->provinsi)->first()->province_id ?? $p->provinsi,
                        ]
                    ]
                ]
            ]
        ];
        $data_negara = collect(json_decode(Storage::get("/public/data/country.json")));
        $p->UsrNegara = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            // "Description" => $p->negara == 'Indonesia' ? "ID" : '',
                            "Description" => $data_negara->where("country", "=", $p->negara)->first()->abbreviation ?? "ID",
                        ]
                    ]
                ]
            ]
        ];
        switch ($p->sistem_bayar) {
            case "Milestone":
                $sistem_bayar = "CP03";
                break;
            case "CPF (Turn key)":
                $sistem_bayar = "CP02";
                break;
            case "Monthly":
                $sistem_bayar = "CP01";
                break;
        };
        $p->UsrSistemPembayaran = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "Description" => $sistem_bayar ?? "",
                        ]
                    ]
                ]
            ]
        ];
        $mata_uang = $p->mata_uang_awal != null ? $p->mata_uang_awal : ($p->mata_uang_review != null ? $p->mata_uang_review : "");
        $mata_uang = MataUang::where("mata_uang", "=", $mata_uang)->first();
        $p->UsrMataUang = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "ShortName" => $mata_uang->mata_uang_kode ?? "",
                        ]
                    ]
                ]
            ]
        ];

        switch ($p->jenis_terkontrak) {
            case "Cost-Plus/Provisional Sum":
                $jenis_terkontrak = "JKT01";
                break;
            case "Turnkey":
                $jenis_terkontrak = "JKT02";
                break;
            case "Design & Build":
                $jenis_terkontrak = "JKT06";
                break;
            case "OM":
                $jenis_terkontrak = "JKT05";
                break;
            case "Unit Price":
                $jenis_terkontrak = "JKT05";
                break;
            case "Lumpsum":
                $jenis_terkontrak = "JKT06";
                break;
            case "Fixed Price":
                $jenis_terkontrak = "JKT05";
                break;
            case "Lumpsum+":
                $jenis_terkontrak = "JKT06";
                break;
        };

        $p->UsrJenisKontrak = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "Description" => $jenis_terkontrak ?? "",
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($p->SumberDana->kode_sumber) && $p->SumberDana->kode_sumber == "Loan") $p->SumberDana->kode_sumber = "LOAN";

        $p->UsrSumberDanaL = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "Name" => $p->SumberDana->kode_sumber ?? "",
                        ]
                    ]
                ]
            ]
        ];

        $p->UsrSBUL = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            "UsrKode" => Sbu::where("lingkup_kerja", "=", $p->sbu)->first()->kode_sbu ?? "",
                        ]
                    ]
                ]
            ]
        ];
        $jenis_proyek = 0;
        switch ($p->jenis_proyek) {
            case "I":
                $jenis_proyek = "Internal";
                break;
            case "N":
                $jenis_proyek = "Non JO";
                break;
            case "J":
                // $jenis_proyek = "JO Portion Member";
                switch ($p->kategori_jo) {
                    case "30":
                        $jenis_proyek = "JO Integrated Leader";
                        break;
                    case "31":
                        $jenis_proyek = "JO Integrated Member";
                        break;
                    case "40":
                        $jenis_proyek = "JO Portion Leader";
                        break;
                    case "41":
                        $jenis_proyek = "JO Portion Member";
                        break;
                    case "50":
                        $jenis_proyek = "JO Mix Integrated - Portion";
                        break;
                }
                break;
        }
        $p->UsrJenis = [
            "inline" => [
                "entry" => [
                    "content" => [
                        "properties" => [
                            // "Name" => JenisProyek::find($p->jenis_proyek)->jenis_proyek ?? "",
                            "Name" => $jenis_proyek ?? "",
                        ]
                    ]
                ]
            ]
        ];

        $kode_sap = "";
        $kategori = "";
        $sbu = $p->Sbu ?? null;
        if (!empty($sbu)) {
            if (str_contains($sbu->kode_sbu, "A0") || str_contains($sbu->kode_sbu, "B0")) {
                $kategori = "Sipil";
            } else if (str_contains($sbu->kode_sbu, "C0") || str_contains($sbu->kode_sbu, "D0")) {
                $kategori = "EPC";
            } else if (str_contains($sbu->kode_sbu, "E0")) {
                $kategori = "Gedung";
            }

            if ($p->klasifikasi_terkontrak == "Mega Proyek" && $kategori == "Gedung") {
                $kode_sap = "Y1 - Proyek Mega K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Besar" && $kategori == "Gedung") {
                $kode_sap = "Y2 - Proyek Besar K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Menengah" && $kategori == "Gedung") {
                $kode_sap = "Y3 - Proyek Menengah K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Kecil" && $kategori == "Gedung") {
                $kode_sap = "Y4 - Proyek Kecil K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Mega Proyek" && $kategori == "Sipil") {
                $kode_sap = "Z1 - Proyek Mega K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Besar" && $kategori == "Sipil") {
                $kode_sap = "Z2 - Proyek Besar K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Menengah" && $kategori == "Sipil") {
                $kode_sap = "Z3 - Proyek Menengah K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Kecil" && $kategori == "Sipil") {
                $kode_sap = "Z4 - Proyek Kecil K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Mega Proyek" && $kategori == "EPC") {
                $kode_sap = "Z5 - Proyek Mega K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Besar" && $kategori == "EPC") {
                $kode_sap = "Z6 - Proyek Besar K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Menengah" && $kategori == "EPC") {
                $kode_sap = "Z7 - Proyek Menengah K. Gedung";
            } else if ($p->klasifikasi_terkontrak == "Proyek Kecil" && $kategori == "EPC") {
                $kode_sap = "Z8 - Proyek Kecil K. Gedung";
            }
        }

        // $sign = ":";
        $p->content = [
            "m:properties" => [
                "d:Id" => DB::table("proyek_code_crm")->where("kode_proyek", '=', $p->kode_proyek)->first()->uuid_crm ?? $p->id,
                "d:Title" => $p->nama_proyek,
                "d:UsrKontrakMulai" => $p->tanggal_mulai_terkontrak,
                "d:UsrAkhirKontrak" => $p->tanggal_akhir_terkontrak,
                "d:UsrNoSPK" => $p->nospk_external,
                "d:UsrBASTPHO" => $p->tanggal_selesai_pho,
                "d:UsrBASTFHO" => $p->tanggal_selesai_fho,
                "d:UsrPorsi" => $p->porsi_jo,
                "d:UsrNilaiKontrak" => $p->HistoryForecasts->where("periode_prognosa", "=", $periodeOtor)->sum(function ($hf) {
                    return (int) $hf->realisasi_forecast;
                }),
                "d:UsrKlasifikasiProyek" => $p->klasifikasi_terkontrak,
                "d:UsrNoKontrak" => $p->nomor_terkontrak,
                "d:UsrNilaiTukar" => $p->kurs_review,
                "d:UsrValas" => $p->nilai_valas_review,
                "d:UsrTanggalSPKEkternal" => $p->tglspk_internal,
                "d:UsrTanggalKontrak" => $p->tanggal_terkontrak,
                // "d:UsrNilaiKontrakKeseluruhan" => $p->HistoryForecasts->where("periode_prognosa", "=", $periodeOtor)->sum(function ($hf) { return (int) $hf->realisasi_forecast; }),
                "d:UsrNilaiKontrakKeseluruhan" => $p->nilai_kontrak_keseluruhan,
                "d:UsrKodeProyek" => DB::table("proyek_code_crm")->where("kode_proyek", '=', $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek,
                "d:UsrLongitude" => $p->longitude,
                "d:UsrLatitude" => $p->latitude,
                "d:UsrKatsap" => $kode_sap,
            ],
        ];
        // $p->ap_id = "";
        // switch ($p->jenis_proyek) {
        //     case "I":
        //         $p->UsrJenis = "Internal";
        //         break;
        //     case "N":
        //         $p->UsrJenis = "Eksternal";
        //         break;
        //     case "J":
        //         $p->UsrJenis = "JO";
        //         break;
        // };
        // $p->UsrNoKontrak = $p->nomor_terkontrak;
        // $p->UsrNilaiTukar = $p->kurs_review;
        // $p->UsrValas = $p->nilai_valas_review;
        // $p->UsrTanggalSPKEkternal = $p->tglspk_internal;
        // $p->UsrTanggalKontrak = $p->tanggal_terkontrak;
        // $proyek_berjalan = ProyekBerjalans::where("kode_proyek", "=", $p->kode_proyek)->first();
        // $p->Account = [
        //     "Name" => $proyek_berjalan->name ?? NULL,
        //     "UsrKdNasabah" => $proyek_berjalan->customer->kode_nasabah ?? NULL,
        // ];
        // $p->UsrProvinsi = $p->provinsi;
        // $p->UsrNegara = $p->negara;
        // $p->UsrSumberDana = $p->sumber_dana;
        // $p->UsrSistemPembayaran = $p->sistem_bayar;
        // $p->UsrMataUang = $p->sistem_bayar;
        // $p->UsrJenisKontrak = $p->jenis_terkontrak;
        // $p->UsrNilaiKontrakKeseluruhan = $p->nilai_kontrak_keseluruhan;
        // if (str_contains($p->kode_proyek, "KD")) {
        //     $p->UsrKodeProyek = Illuminate\Support\Facades\DB::table('proyek_code_crm')->where("kode_proyek", "=", $p->kode_proyek)->first()->kode_proyek_crm ?? $p->kode_proyek;
        // } else {
        //     $p->UsrKodeProyek = $p->kode_proyek;
        // }
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
        unset($p->nomor_terkontrak, $p->tglspk_internal, $p->provinsi, $p->sumber_dana);
        unset($p->provinsi, $p->negara, $p->sistem_bayar, $p->sumber_dana, $p->sbu, $p->jenis_terkontrak, $p->lokasi_tender, $p->mata_uang_review, $p->mata_uang_awal);
        return $p;
    });
    $data = $proyeks->toArray();
    $taken_date = Carbon\Carbon::now()->translatedFormat("d F Y H:i:s");
    // creating object of SimpleXMLElement
    $xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?> <feed xml:base="https://crm.wika.co.id/detail-proyek-xml" xmlns="http://www.w3.org/2005/Atom" xmlns:d="http://schemas.microsoft.com/ado/2007/08/dataservices" xmlns:m="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata" xmlns:georss="http://www.georss.org/georss" xmlns:gml="http://www.opengis.net/gml"> <title type="text">OpportunityCollection</title> <updated>' . $taken_date . '</updated> </feed>');
    // <id>https://crm.wika.co.id/api/detail-proyek-xml</id> 
    // function call to convert array to xml
    $data = arrayToXML($data, $xml_data);
    // print_r($data);
    // $data = str_replace(array("\r", "\n"), "", $data);
    return response($data)->header("Content-Type", "text/xml");
});
// End API PROYEK XML



Route::get('/abort/{code}/{msg}', function ($code, $msg) {
    return abort($code, $msg);
});
