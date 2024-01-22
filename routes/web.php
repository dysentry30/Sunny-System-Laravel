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
use App\Http\Controllers\ContractApprovalController;
use App\Http\Controllers\ContractManagementsController;
use App\Http\Controllers\CSIController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DirektoratController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JenisProyekController;
use App\Http\Controllers\KriteriaPenggunaJasaController;
use App\Http\Controllers\KriteriaSelectionNonGreenlaneController;
use App\Http\Controllers\PenilaianPenggunaJasaController;
use App\Http\Controllers\MataUangController;
use App\Http\Controllers\OtomasiApprovalController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TipeProyekController;
use App\Http\Controllers\RoleManagementsController;
use App\Http\Controllers\KonsultanPerencanaController;
use App\Http\Controllers\AssessmentPartnerSelectionController;
use App\Http\Controllers\Rekomendasi2Controller;
use App\Models\ChecklistCalonMitraKSO;
use App\Models\ContractChangeNotice;
use App\Models\ContractChangeOrder;
use App\Models\ContractChangeProposal;
use App\Models\FieldChange;
use App\Models\IndustrySector;
use App\Models\ClaimManagements;
use App\Models\Customer;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\Dop;
use App\Models\Jabatan;
use App\Models\JenisProyek;
use App\Models\PerjanjianKso;
use App\Models\KriteriaAssessment;
use App\Models\KriteriaGreenLine;
use App\Models\KriteriaPenilaianPefindo;
use App\Models\LegalitasPerusahaan;
use App\Models\MasterFortuneRank;
use App\Models\MasterLQRank;
use App\Models\MasterPefindo;
use App\Models\MasterGrupTierBUMN;
use App\Models\MasterKriteriaGreenlanePartner;
use App\Models\PenilaianPartnerSelection;
use App\Models\PenilaianChecklistProjectSelection;
use App\Models\MatriksApprovalPartnerSelection;
use App\Models\MatriksApprovalNotaRekomendasi2;
use App\Models\MasterCatatanNotaRekomendasi2;
use App\Models\MasterKlasifikasiProyek;
use App\Models\MasterKlasifikasiOmsetProyek;
use App\Models\MasterKlasifikasiProduksiProyek;
use App\Models\MasterAlatProyek;
use App\Models\MataUang;
use App\Models\MatriksApprovalRekomendasi;
use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\ProyekBerjalans;
use App\Models\Sbu;
use App\Models\SiteInstruction;
use App\Models\SumberDana;
use App\Models\TechnicalForm;
use App\Models\TechnicalQuery;
use App\Models\PersonelTenderProyek;
use App\Models\AlatProyek;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Carbon\Carbon;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\PerubahanKontrak;
use App\Models\ProyekPISNew;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Termwind\Components\Dd;
use Barryvdh\DomPDF\Facade\Pdf;

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
Route::get('/ccm', [UserController::class, 'welcome'])->middleware("userNotAuth");
Route::get('/crm-login', [UserController::class, 'authenticate'])->middleware("userNotAuth");
Route::get('/csi-login', [UserController::class, 'welcome'])->middleware("userNotAuth");

Route::get('/login-admin', [UserController::class, 'welcome'])->middleware("userNotAuth");
// begin :: Login

Route::post('/login', [UserController::class, 'authen']);
// Route::post('/login', [UserController::class, 'authenNew']);

Route::get('/logout', [UserController::class, 'logout'])->middleware("userAuth");

// Route::post('/createUser', [UserController::class, 'testLogin']);
// end :: Login
function generate_new_kode($val) {
    $no_urut = random_int(100,999);
    $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);
    $kode_proyek = $val;
    $is_kode_proyek_exist = Proyek::find($kode_proyek);
    if(!empty($is_kode_proyek_exist)) {
        $kode_proyek = generate_new_kode($kode_proyek);
    }
    return $kode_proyek;
}
Route::get('/generate-kode-proyek/{kode_proyek}', function ($kode_proyek) {
    
    $list_kode_proyek = collect(explode("-",$kode_proyek));
    $list_new_kode_proyek = collect();
    $counter = 253;
    foreach($list_kode_proyek as $key => $p) {

        $newProyek = Proyek::find($p);
        // if(empty($newProyek->tahun_perolehan) && $newProyek->tahun_perolehan != 2023 && $newProyek->is_rkap != true) dd($newProyek);
        if(empty($newProyek) && empty($newProyek->tahun_perolehan) && empty($newProyek->is_rkap)) continue;
        
        //begin::Generate Kode Proyek
        
        $generateProyek = Proyek::whereYear("created_at", "=", (int) date("Y"))->get()->sortBy("id");
        $unit_kerja = $newProyek->unit_kerja;
        $jenis_proyek = $newProyek->jenis_proyek;
        $tipe_proyek = $newProyek->tipe_proyek;
        if ($tipe_proyek == "R") {
            $newProyek->stage = 8;
        } else {
            $newProyek->stage = 1;
        }
        $tahun = $newProyek->tahun_perolehan;

        // Kondisi kalau tahun lebih besar dari 2021 maka O Selain itu A
        // $kode_tahun = $tahun == 2021 ? "A" : "O";
        $kode_tahun = get_year_code($tahun);
    
        // Menggabungkan semua kode beserta nomor urut
        $kode_proyek = $unit_kerja . $jenis_proyek . $tipe_proyek . $kode_tahun;
    
        // $no_urut = $generateProyek->count(function($p) use($kode_proyek) {
        //     return str_contains($p->kode_proyek, $kode_proyek);
        // }) + $key;
        $no_urut = ++$counter;
    
        // Untuk membuat 3 digit nomor urut terakhir
        $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);
        // dd($no_urut, $kode_proyek);
        // if (str_contains($generateProyek->last()->kode_proyek, "KD")) {
        //     $no_urut = (int) $generateProyek->last()->id + 1;
        // } else {
        //     // $no_urut = count($generateProyek)+1;
        //     $no_urut = (int) $generateProyek->last()->id + 1;
        // }
        
        $kode_proyek = $kode_proyek . $no_urut;
        $is_kode_proyek_exist = Proyek::find($kode_proyek);
        if(!empty($is_kode_proyek_exist)) {
            // $kode_proyek = generate_new_kode($kode_proyek);
            $no_urut = ++$counter;
        
            // Untuk membuat 3 digit nomor urut terakhir
            $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);
        }
        $pb = $newProyek->proyekBerjalan;
        if(!empty($pb)) {
            $new_pb = new ProyekBerjalans();
            $new_pb->id_customer = $pb->id_customer;
            $new_pb->name_customer = $pb->name_customer;
            $new_pb->nama_proyek = $pb->nama_proyek;
            $new_pb->kode_proyek = $kode_proyek;
            $new_pb->pic_proyek = $pb->pic_proyek;
            $new_pb->unit_kerja = $pb->unit_kerja;
            $new_pb->jenis_proyek = $pb->jenis_proyek;
            $new_pb->nilaiok_proyek = $pb->nilaiok_proyek;
            $new_pb->stage = $pb->stage;
            $new_pb->save();
        }
        $newProyek->kode_proyek = $kode_proyek;

        // // Sync Dokumen Proyek
        // $attachment_menang = $newProyek->AttachmentMenang;
        // $risk_tender_proyek_docs = $newProyek->RiskTenderProyek;
        // $dokumen_prakualifikasi = $newProyek->DokumenPrakualifikasi;
        // dump($attachment_menang, $risk_tender_proyek_docs, $dokumen_prakualifikasi);



        // dd($new_pb);
        // $list_new_kode_proyek->push($kode_proyek);
        $newProyek->save();
    }
    if(!empty($new_pb)) {
        return response()->json(["proyek" => $newProyek, "proyek_berjalan_new" => $new_pb, "proyek_berjalan_old" => $pb]);
    }
    return response()->json($newProyek);
    // dd($list_new_kode_proyek);
    //end::Generate Kode Proyek
});



Route::group(['middleware' => ["userAuth", "admin"]], function () {

    // Route::middleware(["admin", "adminKontrak", "userSales"])->group(function () {
    // });

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard-ccm/perolehan-kontrak', [DashboardController::class, 'dashboard_perolehan_kontrak']);

    Route::get('/dashboard-ccm/pelaksanaan-kontrak', [DashboardController::class, 'dashboard_pelaksanaan_kontrak']);

    Route::get('/dashboard-ccm/pemeliharaan-kontrak', [DashboardController::class, 'dashboard_pemeliharaan_kontrak']);

    Route::get('/dashboard/filter/{year}/{prognosa}/{type}/{month}', [DashboardController::class, 'getDataFilterPoint']);

    Route::get('/dashboard/filter/{year}/{prognosa}/{type}/{month}/{unit_kerja}', [DashboardController::class, 'getDataFilterPoint']);

    Route::get('/dashboard/triwulan/{prognosa}/{type}/{month}', [DashboardController::class, 'getDataFilterPointTriwulan']);

    Route::get('/dashboard/triwulan/{prognosa}/{type}/{month}/{unit_kerja}', [DashboardController::class, 'getDataFilterPointTriwulan']);

    Route::get('/dashboard/realisasi/{prognosa}/{type}/{unitKerja}', [DashboardController::class, 'getDataFilterPointRealisasi']);

    Route::get('/dashboard/realisasi/{prognosa}/{type}/{unitKerja}/{divcode}', [DashboardController::class, 'getDataFilterPointRealisasi']);

    Route::get('/dashboard/monitoring-proyek/{tipe}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/monitoring-proyek/{tipe}/{periode}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/monitoring-proyek/{tipe}/{periode}/{filter}', [DashboardController::class, "getDataMonitoringProyek"]);

    Route::get('/dashboard/terendah-terkontrak/{tipe}', [DashboardController::class, "getDataTerendahTerkontrak"]);

    Route::get('/dashboard/terendah-terkontrak/{tipe}/{filter}', [DashboardController::class, "getDataTerendahTerkontrak"]);

    // Route::get('/dashboard/index-jumlah/{tipe}/{year}', [DashboardController::class, "getDataCompetitive"]);

    Route::get('/dashboard/index-jumlah/{tipe}/{filter}/{year}', [DashboardController::class, "getDataCompetitive"]);

    // Route::get('/dashboard/index-nilai/{tipe}', [DashboardController::class, "getDataCompetitiveNilai"]);

    Route::get('/dashboard/index-nilai/{tipe}/{filter}/{year}', [DashboardController::class, "getDataCompetitiveNilai"]);

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

    Route::post('/contract-management/final-dokumen/upload', [ContractManagementsController::class, 'uploadDokumenFinal']);

    Route::post('/contract-management/final-dokumen/{id}/edit', [ContractManagementsController::class, 'editDokumenFinal']);

    Route::post('/contract-management/final-dokumen/{id}/delete', [ContractManagementsController::class, 'deleteDokumenFinal']);

    Route::get('/contract-management/view', [ContractManagementsController::class, 'new']);

    Route::post('/contract-management/save', [ContractManagementsController::class, 'save']);

    Route::post('/contract-management/update', [ContractManagementsController::class, 'update']);

    Route::post('/contract-management/document-bast/upload', [ContractManagementsController::class, 'documentBastContractUpload']);

    Route::post('/contract-management/document-bast/{id_bast}/edit', [
        ContractManagementsController::class, 'documentBastContractEdit'
    ]);

    Route::post('/contract-management/ba-defect/upload', [ContractManagementsController::class, 'baDefectContractUpload']);

    Route::post('/contract-management/bast-2/{id_document}/delete', [
        ContractManagementsController::class, 'deleteBast'
    ]);

    Route::post('/contract-management/dokumen-pendukung/upload', [ContractManagementsController::class, 'dokumenPendukungContractUpload']);

    Route::post('/contract-management/pending-issue/upload', [ContractManagementsController::class, 'pendingIssueContractUpload']);

    Route::post('/contract-management/pending-issue/edit', [ContractManagementsController::class, 'pendingIssueContractEdit']);

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

    Route::get('/contract-management/view/{id_contract}/perubahan-kontrak/{perubahan_kontrak}', [ContractManagementsController::class, 'perubahanKontrakView']);

    Route::get('/review-contract/view/{id_contract}/{stage}', [ContractManagementsController::class, 'reviewKontrakView']);
    
    // Route::get('/contract-management/view/{id_contract}/draft-contract/{is_tender_menang}', [ContractManagementsController::class, 'draftContractView']);
    Route::get('/contract-management/view/{id_contract}/draft-contract/tender-menang/1', [ContractManagementsController::class, 'tenderMenang']);

    Route::get('/contract-management/view/{id_contract}/get-manajemen-kontrak/{id}', [ContractManagementsController::class, 'getChecklistManajemenKontrak']);

    Route::post("/draft-contract/upload", [DraftContractController::class, "save"]);

    Route::post("/addendum-contract/upload", [AddendumContractController::class, "upload"]);

    Route::post("/addendum-contract/update", [AddendumContractController::class, "update"]);

    Route::post("/addendum-contract/draft/upload", [AddendumContractController::class, "draftUpload"]);

    Route::post("/addendum-contract/diajukan/upload", [AddendumContractController::class, "draftDiajukanUpload"]);

    Route::post("/addendum-contract/negosiasi/upload", [AddendumContractController::class, "draftNegoisasiUpload"]);

    Route::post("/addendum-contract/disetujui/upload", [AddendumContractController::class, "draftDisetujuiUpload"]);

    Route::post("/addendum-contract/amandemen/upload", [AddendumContractController::class, "draftAmandemenUpload"]);

    Route::post("/jenis-dokumen/upload", [AddendumContractController::class, "jenisDokumenUpload"]);

    Route::post("/addendum-contract/draft/update", [AddendumContractController::class, "draftUpdate"]);

    Route::get('change-request', [AddendumContractController::class, 'changeRequest']);

    Route::post("/get-progress", [ContractManagementsController::class, "getDataProgressPIS"]);

    Route::post("/contract-management/set-lock", [ContractApprovalController::class, "lockApprovalRev"]);

    Route::get("/contract-management/download/kso/{id_document}", function (string $id) {
        $document_kso = PerjanjianKso::select(['id_document', 'document_name'])->where('id_document', '=', $id)->first();
        $path = public_path('words\\' . $document_kso->id_document . '.docx');
        // dd($path);
        return response()->download($path, $document_kso->document_name . '.docx');
    });
    // end :: contract management


    //begin :: History Approval CCM

    Route::get("/history-approval", [ContractApprovalController::class, "index"]);

    Route::post("/history-approval/set-approve/{id_contract}", [ContractApprovalController::class, "setApprove"]);

    Route::post("/history-approval/set-unlock", [ContractApprovalController::class, "setUnlock"]);

    Route::post("/history-approval/request-unlock", [ContractApprovalController::class, "requestUnlock"]);
 
     //end :: History Approval CCM



    // begin :: Pasal
    Route::get('/pasal/edit', [PasalController::class, 'index']);

    Route::delete('/pasal/delete/{pasal}', [PasalController::class, 'destroy']);

    Route::get('/pasal/{pasal}', [PasalController::class, 'show']);

    Route::post('/import/pasal', [PasalController::class, "importPasal"]);
    // end :: Pasal



    // begin :: Claim Management

    Route::get('claim-management', [ClaimController::class, 'index']);

    // Route::get('claim-management/proyek/{kode_proyek}/{jenis_claim}', [ClaimController::class, 'viewClaim']);
    Route::get('claim-management/proyek/{kode_proyek}/{id_contract}', [ClaimController::class, 'view']);

    Route::get('claim-management/proyek/{profit_center}', [ClaimController::class, 'viewClaimNew']);
    
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
    // Route::get('/document', [DocumentController::class, "documentIndex"]);
    Route::get('/document', [DocumentController::class, "documentDatabaseView"]);
    Route::get('/document-template', [DocumentController::class, "documentTemplateView"]);
    Route::post('/document-template/new', [DocumentController::class, "documentTemplateNew"]);
    Route::post('/document-template/delete/{id}', [DocumentController::class, "documentTemplateDelete"]);
    // End :: Menu Document



    //Begin :: Customer
    // Customer with Auto Scrol
    Route::get('/customer', [CustomerController::class, 'getIndex']);


    // Begin CSI

    Route::get('/csi', [CSIController::class, "index"]);

    Route::get('/csi/customer-survey', [CSIController::class, "indexCustomer"]);

    Route::get('/csi/customer-survey/{id}', [CSIController::class, "indexCustomer"]);

    Route::post('/csi/send/{id}', [CSIController::class, "sendCsi"]);

    Route::post('/csi/send/new/{id}', [CSIController::class, "sendCsiNew"]);

    Route::post('/csi/get-progress/{kodeProyek}', [CSIController::class, "createCsi"]);

    Route::post('/csi/customer-survey-save', [CSIController::class, "saveSurvey"]);

    // End CSI

    // customer dashboard all database
    // Route::get('/customer', [CustomerController::class, 'index']);

    // Begin Rekomendasi
    Route::get('/rekomendasi', [RekomendasiController::class, "index"])->name('rekomendasi');
    Route::post('/rekomendasi/{kode_proyek}/generate', [RekomendasiController::class, "generateFileNotaRekomendasiFinal"]);
    Route::get("/green-lane", [RekomendasiController::class, "indexGreenLane"]);
    Route::get("/non-green-lane", [RekomendasiController::class, "indexNonGreenLane"]);
    // End Rekomendasi

    //Begin::Assessment Partner Selection
    Route::get(
        '/assessment-partner-selection',
        [AssessmentPartnerSelectionController::class, 'index']
    );
    Route::post('/assessment-partner-selection/{partner}/save', [
        AssessmentPartnerSelectionController::class, 'store'
    ]);
    Route::post('/assessment-partner-selection/{partner}/edit', [
        AssessmentPartnerSelectionController::class, 'update'
    ]);
    Route::post('/assessment-partner-selection/delete-file', [
        AssessmentPartnerSelectionController::class, 'deleteFile'
    ]);
    //End::Assessment Partner Selection

    //Begin::Nota Rekomendasi 2
    Route::get('/nota-rekomendasi-2', [Rekomendasi2Controller::class, 'index']);
    Route::post('/nota-rekomendasi-2/{kode_proyek}/pengajuan', [Rekomendasi2Controller::class, 'ProsesPengajuan']);
    Route::post('/nota-rekomendasi-2/{kode_proyek}/penyusun', [Rekomendasi2Controller::class, 'ProsesPenyusun']);
    Route::post('/nota-rekomendasi-2/{kode_proyek}/verifikasi', [Rekomendasi2Controller::class, 'ProyekVerifikasi']);
    Route::post('/nota-rekomendasi-2/{kode_proyek}/rekomendasi', [Rekomendasi2Controller::class, 'ProyekRekomendasi']);
    Route::post('/nota-rekomendasi-2/{kode_proyek}/persetujuan', [Rekomendasi2Controller::class, 'ProyekPersetujuan']);

    Route::post('/nota-rekomendasi-2/{kode_proyek}/pemaparan', [Rekomendasi2Controller::class, 'ProyekPemaparan']);


    Route::post('/nota-rekomendasi-2/assessment-project-selection/detail/save', [KriteriaSelectionNonGreenlaneController::class, 'detailSave']);
    Route::post('/nota-rekomendasi-2/assessment-project-selection/detail/edit', [KriteriaSelectionNonGreenlaneController::class, 'detailEdit']);
    Route::post('/nota-rekomendasi-2/assessment-project-selection/delete-file', [KriteriaSelectionNonGreenlaneController::class, 'deleteFile']);


    Route::get('/proyek/{proyek}/kso/generate', function (Proyek $proyek) {
        if (empty($proyek)) {
            Alert::error('Error', 'Proyek tidak ditemukan!');
            return redirect()->back();
        }

        $verifikasiKSO = collect(json_decode($proyek->alasan_kso));
        // dd($verifikasiKSO);

        if ($verifikasiKSO->isEmpty()) {
            Alert::error(
                'Error',
                'Mohon isi Verifikasi Internal KSO terlebih dahulu!'
            );
            return redirect()->back();
        }

        try {
            $pdf = Pdf::loadView('GenerateFile.view', ["verifikasiKSO" => $verifikasiKSO, 'jenisProyek' => $proyek->jenis_proyek]);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('Form Verifikasi Internal KSO atau Non KSO - ' . $proyek->kode_proyek . '.pdf');
        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    });

    Route::get('/proyek/{proyek}/kso/setuju/generate', function (Proyek $proyek) {
        if (empty($proyek)) {
            Alert::error('Error', 'Proyek tidak ditemukan!');
            return redirect()->back();
        }

        try {
            $pdf = Pdf::loadView('GenerateFile.generatePermohonanKSO', ["proyek" => $proyek]);
            $pdf->setPaper('A4', 'potrait');
            return $pdf->download('Form Persetujuan Pembentukan KSO - ' . $proyek->kode_proyek . '.pdf');
        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    });

    Route::get('/proyek/{proyek}/project-greenlane/generate', function (Proyek $proyek) {
        if (empty($proyek)) {
            Alert::error('Error', 'Proyek tidak ditemukan!');
            return redirect()->back();
        }

        if (is_null($proyek->jenis_terkontrak) || is_null($proyek->sistem_bayar) || is_null($proyek->is_uang_muka)) {
            Alert::error('Error', 'Jenis Kontrak, Sistem Pembayaran, dan Uang Muka wajib diisi atau simpan terlebih dahulu.');
            return redirect()->back();
        }

        $is_greenlane_project = true;

        try {
            $pdf = Pdf::loadView('GenerateFile.generateVerifikasiProyek', ["proyek" => $proyek]);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('Form Verifikasi Internal Penentuan Project Greenlane atau Non Greenlane - ' . $proyek->kode_proyek . '.pdf');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    });
    //End::Nota Rekomendasi 2

    //Begin::Tender

    //Begin::Personel Utama
    Route::get('/personel-utama', function () {
        return response()->view('Tender/personelTender', ["data" => PersonelTenderProyek::all()]);
    });
    //End::Personel Utama

    //Begin::Alat
    Route::get('/alat', function () {
        return response()->view('Tender/alatTender', ["data" => AlatProyek::all()]);
    });
    //End::Alat

    //End::Tender


    // DELETE data customer pada dasboard customer by ID 
    Route::delete('customer/delete/{id_customer}', [CustomerController::class, 'delete']);


    // NEW to Create New customer #1 
    Route::get('/customer/new', [CustomerController::class, 'new']);


    // NEW to Create New customer #2
    Route::post('/customer/save', [CustomerController::class, 'saveNew']);

    // view customer by id_customer #1
    Route::get('/customer/view/{id_customer}/{nama}', [CustomerController::class, 'view']);

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

    // Get kode BP  
    Route::post('/customer/get-kode-bp', [CustomerController::class, 'getKodeBP']); 
    
    // Save Masalah Hukum 
    Route::post('/customer/masalah-hukum/save', [CustomerController::class, 'saveMasalahHukum']);

    // Route::post('/customer/csi/save', [CustomerController::class, 'saveCSI']);

    Route::post('/customer/cli/save', [CustomerController::class, 'saveCLI']);

    Route::post('/customer/nps/save', [CustomerController::class, 'saveNPS']);

    Route::post('/customer/karya-inovasi/save', [CustomerController::class, 'saveInovasi']);
    
    Route::post('/customer/porsi-saham/save', [CustomerController::class, 'savePorsiSaham']);
    Route::post('/customer/porsi-saham/edit', [CustomerController::class, 'savePorsiSaham']);
    Route::delete('/customer/porsi-saham/{porsi_saham}/delete', [CustomerController::class, 'deletePorsiSaham']);

    Route::post('/customer/company-profile/save', [CustomerController::class, 'saveCompanyProfile']);
    Route::post('/customer/company-profile/edit', [CustomerController::class, 'saveCompanyProfile']);
    Route::delete('/customer/company-profile/{company_profile}/delete', [CustomerController::class, 'deleteCompanyProfile']);

    Route::post('/customer/laporan-keuangan/save', [CustomerController::class, 'saveLaporanKeuangan']);
    Route::post('/customer/laporan-keuangan/edit', [CustomerController::class, 'saveLaporanKeuangan']);
    Route::delete('/customer/laporan-keuangan/{laporan_keuangan}/delete', [CustomerController::class, 'deleteLaporanKeuangan']);

    Route::post('/customer/AHU/save', [CustomerController::class, 'saveAHU']);
    Route::post('/customer/AHU/edit', [CustomerController::class, 'saveAHU']);
    Route::delete('/customer/AHU/{ahu}/delete', [CustomerController::class, 'deleteAHU']);



    // Begin :: get Kabupaten
    Route::get('/get-kabupaten/{id}',function ($id) {
            $data_provinsi = collect(json_decode(Storage::get("/public/data/provinsi.json")))->where("province_id", "=", $id)->first()->id;
            $data_kabupaten = collect(json_decode(Storage::get("/public/data/$data_provinsi.json")));
            // $data_kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/$id.json")->json();
            // $data_kabupaten = Provinsi::where("country_id", "=", $id)->get()->toJson();
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

    Route::post('/proyek/forecast/{i}/{periodePrognosa}/{year}/retail', function (Request $request, $i, $periodePrognosa, $year) {
        $data = $request->all();
        // dd($data, $i, $periodePrognosa);

        $findForecast = Forecast::where("kode_proyek", "=", $data["kode-proyek"])->where("month_forecast", "=", (int) $i)->where("periode_prognosa", "=", $periodePrognosa)->where("tahun", "=", $year)->get()->first();
        // $tabPane = "kt_user_view_overview_forecast";

        if (empty($findForecast)) {
            $nullForecast = Forecast::where("kode_proyek", "=", $data["kode-proyek"])->where("month_forecast", "=", null)->where("periode_prognosa", "=", $periodePrognosa)->where("tahun", "=", $year)->get()->first();
            if (!empty($nullForecast)) {
                $nullForecast->delete();
            }
            $forecast = new Forecast();
            $forecast->kode_proyek = $data["kode-proyek"];

            if ($data["nilairealisasi-" . $i] != null && $periodePrognosa == $i) {
                dd($data["nilairealisasi-" . $i]);
                $forecast->nilai_forecast = (string) (str_replace(".", "", $data["nilairealisasi-" . $i] ?? 0));
                $forecast->month_forecast = (int) $i;
            } else {
                $forecast->nilai_forecast = (string) (str_replace(".", "", $data["nilaiforecast-" . $i] ?? 0));
                $forecast->month_forecast = (int) $i;
            }

            $forecast->rkap_forecast = (string) (str_replace(".", "", $data["nilaiok-" . $i] ?? 0));
            $forecast->month_rkap = (int) $i;

            $forecast->realisasi_forecast = (string) (str_replace(".", "", $data["nilairealisasi-" . $i] ?? 0));
            $forecast->month_realisasi = (int) $i;

            // $prognosa = (int) date('m');
            $forecast->periode_prognosa = $periodePrognosa;
            $forecast->tahun = $year;

            // dd($tabPane);

            $forecast->save();

            Alert::success('Success', "Forecast Berhasil Dibuat");
            return redirect()->back();
        } else {
            $findForecast->kode_proyek = $data["kode-proyek"];

            if ($data["nilairealisasi-" . $i] != null && $periodePrognosa == $i) {
                $findForecast->nilai_forecast = (string) (str_replace(".", "", $data["nilairealisasi-" . $i] ?? 0));
                $findForecast->month_forecast = (int) $i;
            } else {
                $findForecast->nilai_forecast = (string) (str_replace(".", "", $data["nilaiforecast-" . $i] ?? 0));
                $findForecast->month_forecast = (int) $i;
            }

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

    Route::get('/proyek/get-departemen/{divcode}', [ProyekController::class, "getDataDepartemen"]);

    Route::post('/proyek/forecast/save', function (Request $request) {
        $data = $request->all();
        $per = 1000000;
        $proyek = Proyek::find($data["kode_proyek"]);
        $forecast = Forecast::where("kode_proyek", "=", $data["kode_proyek"])->where("periode_prognosa", "=", $data["periode_prognosa"] ?? (int) date("m"))->where("tahun", "=", $data["tahun"])->orderByDesc("created_at");
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
            $new_forecast->tahun = (int) $data["tahun"];
            $new_forecast->nilai_forecast = (string) $data["nilai_forecast"] * $per;
            
            if ($new_forecast->save()) {
                // edit nilai bulan sebelumnya
                if((int) $data["periode_prognosa"] != 1) {
                    $get_previous_periode_forecast = Forecast::where("kode_proyek", "=", $proyek->kode_proyek)->where("periode_prognosa", "=", (int) $data["periode_prognosa"] - 1)->where("tahun", "=", $data["tahun"])->get()->first();
                    if(!empty($get_previous_periode_forecast)) {
                        $get_previous_periode_forecast->nilai_forecast = (string) $data["nilai_forecast"] * $per;
                        $get_previous_periode_forecast->realisasi_forecast = (string) $proyek->nilai_perolehan ?? 0;
                        $get_previous_periode_forecast->month_forecast = (int) $data["forecast_month"];
                        $get_previous_periode_forecast->month_realisasi = (int) $proyek->bulan_ri_perolehan ?? null;
                        $get_previous_periode_forecast->save();
                    }
                }
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
            $forecast->tahun = (int) date("Y");
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

    // ADD Porsi-JO 
    Route::post('/proyek/porsi-jo/get-pefindo', [ProyekController::class, "getDataPefindo"]);

    // EDIT Porsi-JO 
    Route::post('/proyek/porsi-jo/{id}/edit', [ProyekController::class, "editJO"]);

    // DELETE Porsi-JO 
    Route::delete('/proyek/porsi-delete/{id}', [ProyekController::class, "deleteJO"]);

    //ADD::Dokumen Kelengkapan Partner
    Route::post('/proyek/porsi-jo/upload/{id_partner}', [ProyekController::class, "uploadDokumenKelengkapanPartner"]);

    //DOWNLOAD::Dokumen Kelengkapan Partner
    Route::get(
        '/proyek/porsi-jo/download/{id_kelengkapan}',
        [ProyekController::class, "downloadDokumenKelengkapanPartner"]
    );

    //DELETE::Dokumen Kelengkapan Partner
    Route::post('/proyek/porsi-jo/delete/{id}', [ProyekController::class, "deleteDokumenKelengkapanPartner"]);

    //VIEW Syarat Prakualifikasi dari Owner
    Route::get('/proyek/syarat-prakualifikasi/{proyek}/view',
        [ProyekController::class, "viewSyaratPrakualifikasi"]
    );

    //VIEW EDIT Syarat Prakualifikasi dari Owner
    Route::get('/proyek/syarat-prakualifikasi/{proyek}/list', [ProyekController::class, "viewEditSyaratPrakualifikasi"]);

    //ADD Syarat Prakualifikasi dari Owner
    Route::post('/proyek/syarat-prakualifikasi/{proyek}/save',
        [ProyekController::class, "saveSyaratPrakualifikasi"]
    );

    //Edit Syarat Prakualifikasi dari Owner
    Route::post('/proyek/syarat-prakualifikasi/{proyek}/edit',
        [ProyekController::class, "editSyaratPrakualifikasi"]
    );

    // ADD Team Proyek 
    Route::post('proyek/user/add', [ProyekController::class, 'assignTeam']);

    // DELETE Team Proyek 
    Route::delete('proyek/user-delete/{id}', [ProyekController::class, 'deleteTeam']);

    // ADD Peserta Tender 
    Route::post('proyek/peserta-tender/add', [ProyekController::class, 'tambahTender']);

    // EDIT Peserta Tender 
    Route::post('/proyek/peserta-tender/{id}/edit', [ProyekController::class, 'editTender']);

    // NOTE Peserta Tender 
    Route::post('/proyek/peserta-tender/{id}/note', [ProyekController::class, 'noteTender']);

    // DELETE Peserta Tender 
    Route::delete('proyek/peserta-tender/{id}/delete', [ProyekController::class, 'deleteTender']);

    // ADD KONSULTAN PERENCANA 
    Route::post('proyek/konsultan-perencana/add', [ProyekController::class, 'tambahKonsultan'
    ]);

    // EDIT KONSULTAN PERENCANA 
    Route::post('/proyek/konsultan-perencana/{id}/edit', [ProyekController::class, 'editKonsultan']);

    // DELETE KONSULTAN PERENCANA 
    Route::delete('proyek/konsultan-perencana/{id}/delete', [ProyekController::class, 'deleteKonsultan']);

    // ADD Tim Tender 
    Route::post('proyek/tim-tender/add', [ProyekController::class, 'tambahTimTender']);

    // EDIT Tim Tender 
    Route::post('/proyek/tim-tender/{id}/edit', [ProyekController::class, 'editTimTender']);

    // DELETE Tim Tender 
    Route::delete('proyek/tim-tender/{id}/delete', [ProyekController::class, 'deleteTimTender']);

    // ADD Personel Tender 
    Route::post('proyek/personel-tender/add', [ProyekController::class, 'tambahPersonelTender']);

    // EDIT Personel Tender 
    Route::post('/proyek/personel-tender/{id}/edit', [ProyekController::class, 'editPersonelTender'
    ]);

    // DELETE Personel Tender 
    Route::delete('proyek/personel-tender/{id}/delete', [ProyekController::class, 'deletePersonelTender']);

    // DELETE Dokumen Nota Rekomendasi 1 
    Route::delete('proyek/dokumen-nota-rekomendasi-1/{id}/delete', [ProyekController::class, 'deleteNotaRekomendasi1']);

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

    //DOWNLOAD Dokumen Penentuan KSO
    Route::get(
        '/proyek/dokumen-penentuan-kso/{id_document}/download',
        [ProyekController::class, 'downloadDokumenPenentuanKSO']
    );

    //DELETE Dokumen Penentuan KSO
    Route::delete(
        '/proyek/dokumen-penentuan-kso/{id}/delete',
        [
            ProyekController::class, 'deleteDokumenPenentuanKSO'
        ]
    );

    //DOWNLOAD Dokumen Penentuan KSO
    Route::get(
        '/proyek/dokumen-penentuan-project-greenlane/{id_document}/download',
        [ProyekController::class, 'downloadDokumenPenentuanProjectGreenlane']
    );

    //DELETE Dokumen Penentuan KSO
    Route::delete(
        '/proyek/dokumen-penentuan-project-greenlane/{id}/delete',
        [ProyekController::class, 'deleteDokumenPenentuanProjectGreenlane']
    );
	
    //RFA Dokumen To CCM
    // Route::get('/proyek/{kode_proyek}/{kategori}', [ProyekController::class, 'updateRfaDocument']);
    Route::post('/proyek/{kode_proyek}/rfa', [ProyekController::class, 'updateRfaDocument']);

    //ADD ALAT PROYEK
    Route::post('/proyek/alat-proyek/add', [ProyekController::class, 'tambahAlatProyek']);
    //EDIT ALAT PROYEK
    Route::post('/proyek/alat-proyek/{alat}/edit', [ProyekController::class, 'editAlatProyek']);
    //DELETE ALAT PROYEK
    Route::post('/proyek/alat-proyek/{alat}/delete', [ProyekController::class, 'deleteAlatProyek']);
    //DELETE FILE ALAT PROYEK
    Route::post('/proyek/alat-proyek/delete', [
        ProyekController::class, 'deleteFileAlatProyek'
    ]);
    //DOWNLOAD FILE PERJANJIAN
    Route::get('/proyek/alat-proyek/{id}/{id_document}/download', [ProyekController::class, 'downloadFilePerjanjianAlat']);

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
    Route::get('/request-approval-history/{year}', [ForecastController::class, 'requestApprovalHistoryView']);
    // to NEW page 
    // Route::get('/proyek/new', [ProyekController::class, 'new']);

    Route::post('/history/request-unlock', function (Request $request) {
        $data = $request->all();
        $tahun = (int) date("m") == 1 ? (int) date("Y") - 1 : (int) date("Y");
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->select(["history_forecast.*", "proyeks.unit_kerja"])->where("proyeks.unit_kerja", "=", $unit_kerja->divcode)->where("history_forecast.periode_prognosa", "=", $data["periode-prognosa"])->where("history_forecast.tahun", "=", $tahun)->get();
        $history_forecasts->each(function ($h) {
            $h->is_request_unlock = "f";
            $h->save();
        });
        Alert::toast("Berhasil melakukan request unlock pada unit <b>$unit_kerja->unit_kerja</b>", 'success');
        return back();
    });

    Route::post('/history/unlock', function (Request $request) {
        $data = $request->all();
        $tahun = (int) date("m") == 1 ? (int) date("Y") - 1 : (int) date("Y");
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->select(["history_forecast.*", "proyeks.unit_kerja"])->where("proyeks.unit_kerja", "=", $unit_kerja->divcode)->where("history_forecast.periode_prognosa", "=", $data["periode-prognosa"])->where("history_forecast.tahun", "=", $tahun)->get();
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
        $tahun = (int) date("m") == 1 ? (int) date("Y") - 1 : (int) date("Y");
        $month = (int) date("m");
        $data = $request->all();
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $data["unit_kerja"])->first();
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->select(["history_forecast.*", "proyeks.unit_kerja", "proyeks.stage", "proyeks.tipe_proyek", "proyeks.nama_proyek", "proyeks.bulan_pelaksanaan"])->where("proyeks.unit_kerja", "=", $unit_kerja->divcode)->where("proyeks.tahun_perolehan", "=", $tahun)->where("history_forecast.periode_prognosa", "=", $data["periode_prognosa"])->where("history_forecast.tahun", "=", $tahun)->get(); 
        $result_all_data_send_to_sap = collect();
        $history_forecasts->each(function ($h) use ($data, $month, $tahun, &$result_all_data_send_to_sap) {
            $h->is_approved_1 = (bool) $data["is_approved"] ? "t" : "f";
            $customers_attractivness = IndustryOwner::all();

            // Begin :: Kirim data Forecast ke SAP
            if((bool) $data["is_approved"]) {
                // $data_send_to_sap = collect([
                //     "FISCAL_PERIOD" => date("Y") . str_pad($data["periode_prognosa"], 3, 0, STR_PAD_LEFT),
                //     "FISCALYEAR_VARIANT" => "K4",
                //     "FISCAL_YEAR" => $tahun,
                //     "COMP_CODE" => (string) $h->Proyek->UnitKerja->company_code ?? "",
                //     "AUDITTRAIL" => "INPUT_PROG",
                //     "CATEGORY" => "PROG",
                //     "PROFIT_CENTER_DIV" => (string) $h->Proyek->UnitKerja->id_profit_center ?? "",
                //     "KODE_PROYEK" => str_contains($h->kode_proyek, "KD") ? DB::table('proyek_code_crm')->where("kode_proyek", "=", $h->kode_proyek)->first()->kode_proyek_crm ?? $h->kode_proyek : $h->kode_proyek,
                //     "VERSION" => "PROG_" . str_pad($h->periode_prognosa, 3, 0, STR_PAD_LEFT),
                //     "KEY_FIGURE" => "10000",
                //     "AMOUNT" => (int) $h->nilai_forecast,
                //     "DESCRIPTION" => "MONTH " . str_pad($h->month_forecast, 2, 0, STR_PAD_LEFT),
                // ]);
                $jenis_proyek = "";
                $cat_project = "";
                switch($h->Proyek->jenis_proyek) {
                    case "I":
                        $jenis_proyek = "INTERN";
                        break;
                    case "N":
                        $jenis_proyek = "EXTERN";
                        break;
                    case "J":
                        $jenis_proyek = "JO";
                        break;
                }
                switch($h->Proyek->tipe_proyek) {
                    case "P":
                        $cat_project = "Proyek";
                        break;
                    case "R":
                        $cat_project = "Retail";
                        break;
                }

                if (strlen($h->nama_proyek) <= 60) {
                    if ($h->stage < 8 || $h->Proyek->tipe_proyek == "R") {
                        /*
                            ketika proyek bukan retail dan tidak punya bulan prognosa,
                            maka ambil bulan perolehan proyek. Jika proyek itu retail,
                            maka tetap ambil bulan prognosa nya.
                        */
                        $bulan_perolehan = ($h->Proyek->tipe_proyek != "R" && (empty($h->month_forecast) || empty($h->nilai_forecast))) ? $h->bulan_pelaksanaan : $h->month_forecast;
                        if (
                            (int) $data["periode_prognosa"] <= (int) $h->month_forecast
                        ) {
                            $data_send_to_sap_prognosa = collect([
                                "/BIC/ZIOCH0008" => (string) $h->Proyek->UnitKerja->id_profit_center ?? "",
                                "/BIC/ZIOCH0022" => str_contains($h->kode_proyek, "KD") ? DB::table('proyek_code_crm')->where(
                                    "kode_proyek",
                                    "=",
                                    $h->kode_proyek
                                )->first()->kode_proyek_crm ?? $h->kode_proyek : $h->kode_proyek,
                                "/BIC/ZIOCH0002" => $h->Proyek->UnitKerja->company_code,
                                "/BIC/ZIOCH0098" => (string) $h->Proyek->UnitKerja->Departemen?->profit_center_departemen ?? "",
                                "DESCRIPTION" => (string) $h->Proyek->nama_proyek,
                                "CAT_FOR_PROJECT" => $cat_project,
                                "STATUS_CONTRACT" => $jenis_proyek,
                                "/BIC/ZIOCH0109" => (int) ($h->tahun . str_pad($bulan_perolehan, 2, 0, STR_PAD_LEFT) . str_pad(Carbon::createFromFormat("Y/n/d", "$h->tahun/$h->periode_prognosa/01")->format("d"), 2, 0, STR_PAD_LEFT)), // Periode
                                "CUSTOMER_CRM" => $h->Proyek->proyekBerjalan->customer->name ?? "", // nama customer di customer
                                "CUSTOMER" => $h->Proyek->proyekBerjalan->customer->kode_bp ?? "", // kode sap di customer
                                "SBU" => $h->Proyek->Sbu->kode_sbu ?? "", // kode sbu di SBU
                                "AMOUNT_PROGNOSA" => (int) $data["periode_prognosa"] <= (int) $h->month_forecast ? (int) $h->nilai_forecast : 0,
                                "REPORT_PERIOD" => (int) (date("Y") . str_pad($data["periode_prognosa"], 3, 0, STR_PAD_LEFT)),
                                "VERSION" => "PROG",
                            ]);

                            $result_all_data_send_to_sap->push($data_send_to_sap_prognosa);
                        }
                    }
                    if (($h->stage == 8 || $h->tipe_proyek == "R") && !empty($h->realisasi_forecast) && (int) $data["periode_prognosa"] == (int) $h->month_realisasi) {
                        $data_send_to_sap_realisasi = collect([
                            "/BIC/ZIOCH0008" => (string) $h->Proyek->UnitKerja->id_profit_center ?? "",
                            "/BIC/ZIOCH0022" => str_contains($h->kode_proyek, "KD") ? DB::table('proyek_code_crm')->where("kode_proyek", "=", $h->kode_proyek)->first()->kode_proyek_crm ?? $h->kode_proyek : $h->kode_proyek,
                            "/BIC/ZIOCH0002" => $h->Proyek->UnitKerja->company_code,
                            "/BIC/ZIOCH0098" => (string) $h->Proyek->UnitKerja->Departemen?->profit_center_departemen ?? "",
                            "DESCRIPTION" => (string) $h->Proyek->nama_proyek,
                            "CAT_FOR_PROJECT" => $cat_project,
                            "STATUS_CONTRACT" => $jenis_proyek,
                            "/BIC/ZIOCH0109" => (int) ($h->tahun . str_pad($h->month_realisasi, 2, 0, STR_PAD_LEFT) . str_pad(Carbon::createFromFormat("Y/n/d", "$h->tahun/$h->periode_prognosa/01")->format("d"), 2, 0, STR_PAD_LEFT)), // Periode
                            "CUSTOMER_CRM" => $h->Proyek->proyekBerjalan->customer->name ?? "", // nama customer di customer
                            "CUSTOMER" => $h->Proyek->proyekBerjalan->customer->kode_bp ?? "", // kode sap di customer
                            "SBU" => $h->Proyek->Sbu->kode_sbu ?? "", // kode sbu di SBU
                            "AMOUNT_PROGNOSA" => (int) $data["periode_prognosa"] == (int) $h->month_realisasi ? (int) $h->realisasi_forecast : 0,
                            "REPORT_PERIOD" => (int) (date("Y") . str_pad($data["periode_prognosa"], 3, 0, STR_PAD_LEFT)),
                            "VERSION" => "ACT",
                        ]);
                        $result_all_data_send_to_sap->push($data_send_to_sap_realisasi);
                    }
                }
            }
            
            $h->save();
        });
        if((bool) $data["is_approved"]) {
            $results_response = collect();
            // $result_all_data_send_to_sap = $result_all_data_send_to_sap->where("AMOUNT_PROGNOSA", ">", 0);
            // FIRST STEP SEND DATA TO BW
            setLogging("prognosa", "SEND PROGNOSA TO SAP ". $data["unit_kerja"] ." =>", $result_all_data_send_to_sap->toArray());
            // return response()->json($result_all_data_send_to_sap, 200);
            $csrf_token = "";
            $content_location = "";
            // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
            // $http = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022");
            $fp = fopen(storage_path('logs/http_log.log'), 'w+');
            $prognosa_log = fopen(storage_path('logs/prognosa_http_log.log'), 'a');
            $get_token = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/requests");
            $csrf_token = $get_token->header("x-csrf-token");
            $results_response->push($get_token->body());
            $cookie = "";
            collect($get_token->cookies()->toArray())->each(function($c) use(&$cookie) {
                $cookie .= $c["Name"] . "=" . $c["Value"] . ";"; 
            });
            fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));

            // SECOND STEP SEND DATA TO BW
            $get_content_location = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/requests");
            $results_response->push($get_content_location->body());
            $content_location = $get_content_location->header("content-location");
            fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));

            // $industry_attractivness = IndustryOwner::all();
            // $new_class = $industry_attractivness->map(function($ia) {
            //     $new_ia = new stdClass();
            //     $new_ia->PERIODE = date("Ymd");
            //     $new_ia->INDUSTRY_CODE = $ia->code_owner ?? "";
            //     $new_ia->ATTRACTIVENESS_STATUS = $ia->owner_attractiveness ?? "";
            //     return $new_ia;
            // });

            // THIRD STEP SEND DATA TO BW
            // dd($new_class->);
            $fill_data = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/dataSend?request=$content_location&datapid=1", $result_all_data_send_to_sap->toArray());
            $results_response->push($fill_data->body());
            fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));


            // FOURTH STEP SEND DATA TO BW
            $closed_request = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/requests/$content_location/close");
            $results_response->push($closed_request->body());
            setLogging("prognosa", "Response Prognosa to SAP " . $data["unit_kerja"] . " =>", $results_response->toArray());
            fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));
            fclose($prognosa_log);
            fclose($fp);
            // dd($closed_request, $fill_data, $result_all_data_send_to_sap);
            // return response()->json($customers_attractivness);
        }
        // End :: Kirim data Forecast ke SAP

        return response()->json([
            "status" => "Success",
            "msg" => "<b>$unit_kerja->unit_kerja</b> berhasil di approved",
        ]);
    });

    // begin :: Set lock / unlock data month forecast
    Route::post('/forecast/set-lock', function (Request $request) {
        $data = $request->all();
        // dd($data);
        $from_user = Auth::user();
        $bulan = (int) date("m");
        if ($bulan == 1 && (int) date("d") < 15) {
            $tahun = (int) date("Y") - 1;
        } else {
            $tahun = (int) date("Y");
        }
        

        // $history_forecast = HistoryForecast::where("periode_prognosa", "=", $request->periode_prognosa);
        // if (!empty($history_forecast->get()->all())) {
        //     $history_forecast->delete();
        // }

        $farestMonth = 0;
        $total_forecast = 0;
        $total_realisasi = 0;
        $total_rkap = 0;
        // check new year condition
        // $date = Carbon::now();
        // $year = $date->year;
        // $day = $date->day;
        // $month = $date->month;
        // if($month == 1 && $day < 15) {
        //     $year -= 1;
        // }
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.tahun_perolehan", "=", $tahun)->where("forecasts.tahun", "=", $tahun)->where("periode_prognosa", "=", $data["periode_prognosa"])->get()->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy("kode_proyek");
        } else {
            $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.tahun_perolehan", "=", $tahun)->where("forecasts.tahun", "=", $tahun)->where("periode_prognosa", "=", $data["periode_prognosa"])->where("proyeks.unit_kerja", $unit_kerja_user)->get()->groupBy("kode_proyek");
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
                $history_forecast_count = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->where("periode_prognosa", "=", $data["periode_prognosa"])->where("tahun", "=", $tahun)->get();
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
                    if ($forecast->is_cancel == true) {
                        $history_forecast->nilai_forecast = "0";
                        $history_forecast->realisasi_forecast = "0";
                    } else if ($current_proyek->stage < 8) {
                        $history_forecast->nilai_forecast = $forecast->nilai_forecast ?? "0";
                        $history_forecast->realisasi_forecast = "0";
                    } else {
                        if (($forecast->periode_prognosa == $forecast->month_realisasi)) {
                            $history_forecast->nilai_forecast = $forecast->realisasi_forecast ?? "0";
                            $history_forecast->realisasi_forecast = $forecast->realisasi_forecast ?? "0";
                        } else {
                            $history_forecast->nilai_forecast = $forecast->nilai_forecast ?? "0";
                            $history_forecast->realisasi_forecast = $forecast->realisasi_forecast ?? "0";
                        }
                    }
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
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan;
                    $history_forecast->month_realisasi = $forecast->month_realisasi;
                    $history_forecast->periode_prognosa = $request->periode_prognosa;

                    $history_forecast->stage = $current_proyek->stage;

                    if ($request->periode_prognosa == 12 && $bulan == 1) {
                        $history_forecast->tahun = (int) date("Y")-1;
                    } else {
                        $history_forecast->tahun = (int) date("Y");
                    }
                    
                    $history_forecast->save();
                }
            } else {

                $history_forecast_count = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->where("periode_prognosa", "=", $data["periode_prognosa"])->where("tahun", "=", $tahun)->get();
                if ($history_forecast_count->count() > 0) continue;
                $history_forecast = new HistoryForecast();

                foreach ($forecasts as $forecast) {
                    if ($forecast->month_forecast > $farestMonth) {
                        $farestMonth = $forecast->month_forecast;
                    }
                    if ($forecast->is_cancel == true) {
                        $total_forecast += (int) 0;
                        $total_realisasi += (int) 0;
                    } else {
                        $total_realisasi += (int) $forecast->realisasi_forecast;
                        $total_forecast += (int) $forecast->nilai_forecast ?? 0;
                    }
                    
                    $total_rkap += (int) $forecast->rkap_forecast ?? 0;
                    // if ($forecast->stage == 8) {
                    //     dd($forecast, $total_realisasi, $total_forecast);
                    // }
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
                    $history_forecast->realisasi_forecast = $total_realisasi;
                    // $history_forecast->realisasi_forecast = $current_proyek->nilai_kontrak_keseluruhan;
                    // $history_forecast->month_realisasi = $current_proyek->bulan_ri_perolehan ?? 0;
                    $history_forecast->month_realisasi = $forecast->month_realisasi ?? 0;
                    // $history_forecast->month_realisasi = $current_proyek->bulan_ri_perolehan ?? 0;
                }
                $history_forecast->periode_prognosa = $request->periode_prognosa;

                $history_forecast->stage = $current_proyek->stage;

                if ($request->periode_prognosa == 12 && $bulan == 1 ) {
                    $history_forecast->tahun = (int) date("Y") - 1;
                } else {
                    $history_forecast->tahun = (int) date("Y");
                }

                if (empty($history_forecast->month_realisasi)) {
                    $history_forecast->realisasi_forecast = 0;
                    $history_forecast->month_realisasi = 0;
                }
                // if ($current_proyek->kode_proyek == '5NPC437') {
                //     dd($current_proyek->nilai_perolehan, $history_forecast->realisasi_forecast);
                // }
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
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode-prognosa"])->where("proyeks.unit_kerja", $unit_kerja->divcode)->select("history_forecast.*")->get();
        } else {
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(
                ",",
                Auth::user()->unit_kerja
            )) : Auth::user()->unit_kerja;
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode-prognosa"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            } else {
                $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode-prognosa"])->where("proyeks.unit_kerja", $unit_kerja_user);
            }
        }
        // if (Auth::user()->check_administrator) {
        //     $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $data["periode_prognosa"])->get();
        //     # code...
        // } else {
        //     $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("periode_prognosa", "=", $request->periode_prognosa)->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
        // }
        $history_forecasts = $history_forecasts->filter(function ($h) {
            return $h->is_approved_1 == "f" || $h->is_request_unlock == "t";
        });
        $check_value = $history_forecasts->every(function ($h) {
            return $h->is_request_unlock == "f";
        });
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
    
    // NEW Unit Kerja after SAVE
    Route::post('/unit-kerja/update', [UnitKerjaController::class, 'updateUnitKerja']);

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
    Route::get('/industry-attractivness', function (Request $request) {
        $industryOwners = IndustryOwner::all()->groupBy("periode")->sortKeysDesc()->first();
        $industrySector = IndustrySector::all()->groupBy("periode")->sortKeysDesc()->first();
        return view("/MasterData/IndustryOwner", compact(["industryOwners", "industrySector"]));
    });

    Route::post('/industry-attractiveness/save', function (Request $request) {
        $data = $request->all();
        $rules = [
            "kode-attractiveness" => "required",
            "owner-attractiveness" => "required",
            "deskripsi-attractiveness" => "required",
            "periode.*" => "required",
        ];
        // dd($data);
        $is_invalid = validateInput($data, $rules);
        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->withInput()->with("modal", $data["modal"]);
        }

        // Check if code already exist
        $is_code_exist = IndustryOwner::find($data["kode-attractiveness"]);
        if(!empty($is_code_exist)) {
            Alert::html("Error", "Industry Attractiveness dengan kode <b>$is_code_exist->code_owner</b> sudah ada!", "error");
            return redirect()->back()->withInput()->with("modal", $data["modal"]);
        }

        $new_industry_attractiveness = new IndustryOwner();
        $new_industry_attractiveness->code_owner = $data["kode-attractiveness"];
        $new_industry_attractiveness->owner_attractiveness = $data["owner-attractiveness"];
        $new_industry_attractiveness->owner_description = $data["deskripsi-attractiveness"];
        $new_industry_attractiveness->periode = $data["periode"]["bulan"] . "-" . $data["periode"]["tahun"];

        if($new_industry_attractiveness->save()) {
            Alert::html("Success", "Industry Attractiveness dengan kode <b>" . $data["kode-attractiveness"] . "</b> berhasil ditambahkan", "success");
            return redirect()->back();
        }
        Alert::html("Error", "Industry Attractiveness dengan kode <b>" . $data["kode-attractiveness"] . "</b> gagal ditambahkan", "error");
        return redirect()->back();

    });

    // Master Data Provinsi
    Route::get('/provinsi', function (Request $request) {
        $provinsi = Provinsi::where("country_id", "=", "ID")->get();
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

    Route::get('/kriteria-green-line', function () {
        $instansi = SumberDana::all()->map(function($sd) {
            $new_class = new stdClass();
            $new_class->instansi = $sd->nama_sumber;
            return $new_class;
        });
        $sumber_danas = SumberDana::all()->map(function($sd) {
            $new_class = new stdClass();
            $new_class->kode = $sd->sumber_dana_id;
            return $new_class;
        })->unique("kode");

        $kriteria_green_line_all = KriteriaGreenLine::all();
        // dd($instansi);
        return view("/MasterData/KriteriaGreenLine", compact(["instansi", "sumber_danas", "kriteria_green_line_all"]));
    });
    
    Route::get('/kriteria/{item}', function ($item) {
        if($item == "Instansi") {
            $data = SumberDana::all()->map(function($sd) {
                return $sd = $sd->nama_sumber;
            });
        } else if($item == "Sumber Dana" || $item == "Proyek Luar Negeri") {
            $data = SumberDana::all()->map(function($sd) {
                return $sd = $sd->sumber_dana_id;
            })->unique()->sort()->values();
        } else if($item == "APBD" || $item == "Pemerintah Provinsi") {
            $data = Provinsi::where('country_id', 'ID')->get();
        } else {
            $data = collect();
        }
        return response()->json($data->toArray());
    });

    Route::post('/kriteria-green-line/save', function (Request $request) {
        $data = $request->collect();
        $data = $data->map(function($d, $key) use($data) {
            // $new_class->item = $data["Item"];
            // $new_class->isi = $data["isi"];
            if(is_array($d)) {
                 $d = !empty($data["sub-isi"][0]) ? $data["sub-isi"][0] : $data["sub-isi"][1];
            }
            return $d;
        })->toArray();
        // dd($data);
        $rules = [
            "item" => "required",
            "isi" => "required",
        ];

        $is_invalid = validateInput($data, $rules);
        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $new_kriteria = new KriteriaGreenLine();
        $new_kriteria->item = $data["item"];
        $new_kriteria->isi = $data["isi"];
        $new_kriteria->sub_isi = $data["sub-isi"];
        $new_kriteria->start_tahun = $data["tahun_start"];
        $new_kriteria->start_bulan = $data["bulan_start"];
        $new_kriteria->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["bulan_finish"]) && isset($data["tahun_finish"])) {
            $new_kriteria->finish_tahun = $data["tahun_finish"];
            $new_kriteria->finish_bulan = $data["bulan_finish"];
        }
        if($new_kriteria->save()) {
            Alert::success('Success', "Kriteria Green Line berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Green Line gagal ditambahkan");
        return redirect()->back();
    });

    Route::post('/kriteria-green-line/update', function (Request $request) {
        $data = $request->collect();
        $data = $data->map(function($d, $key) use($data) {
            // $new_class->item = $data["Item"];
            // $new_class->isi = $data["isi"];
            if(is_array($d)) {
                 $d = !empty($data["sub-isi"][0]) ? $data["sub-isi"][0] : $data["sub-isi"][1];
            }
            return $d;
        })->toArray();

        $rules = [
            "item" => "required",
            "isi" => "required",
        ];

        $is_invalid = validateInput($data, $rules);
        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $update_kriteria = KriteriaGreenLine::find($data["id-kriteria"]);
        if(empty($update_kriteria)) {
            Alert::html("Error", "Kriteria Green Lane tidak ditemukan!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }
        $update_kriteria->item = $data["item"];
        $update_kriteria->isi = $data["isi"];
        $update_kriteria->sub_isi = $data["sub-isi"];
        $update_kriteria->start_tahun = $data["tahun_start"];
        $update_kriteria->start_bulan = $data["bulan_start"];
        $update_kriteria->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $update_kriteria->finish_tahun = $data["tahun_finish"] ?? "";
            $update_kriteria->finish_bulan = $data["bulan_finish"] ?? "";
        }
        // dd($update_kriteria, $data);
        if($update_kriteria->save()) {
            Alert::success('Success', "Kriteria Green Lane berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Green Lane gagal diperbarui");
        return redirect()->back();
    });

    Route::post('/kriteria-green-line/delete', function (Request $request) {
        $data = $request->all();
        $delete_kriteria_green_line = KriteriaGreenLine::find($data["id-kriteria"]);
        if($delete_kriteria_green_line->delete()) {
            Alert::success('Success', "Kriteria Green Line berhasil dihapus");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Green Line gagal dihapus");
        return redirect()->back();
    });
    // End :: Master Data Kriteria Green Line
    
    // Begin :: Master Data Kriteria Assessment
    Route::post('/kriteria-assessment/save', function (Request $request) {
        $data = $request->collect();
        // dd($data);
        $data = $data->map(function($d, $key) use($data) {
            if(is_array($d)) {
                $d = collect($d)->filter(function($d_item) {
                    return $d_item != null;
                })->first();
            }
            return $d;
        })->toArray();
        $rules = [
            "kategori" => "required",
            "kriteria-penilaian" => "required",
            "nilai" => "required",
            "isi" => "required",
        ];

        $is_invalid = validateInput($data, $rules);
        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $new_kriteria = new KriteriaAssessment();
        $new_kriteria->start_tahun = $data["tahun_start"];
        $new_kriteria->start_bulan = $data["bulan_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $new_kriteria->finish_tahun = $data["tahun_finish"] ?? "";
            $new_kriteria->finish_bulan = $data["bulan_finish"] ?? "";
        }
        $new_kriteria->kategori = $data["kategori"];
        $new_kriteria->kriteria_penilaian = $data["kriteria-penilaian"];
        $new_kriteria->klasifikasi = $data["klasifikasi"];
        $new_kriteria->nilai = $data["nilai"];
        $new_kriteria->isi = $data["isi"];

        if($new_kriteria->save()) {
            Alert::success('Success', "Kriteria Assessment berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Assessment gagal ditambahkan");
        return redirect()->back();
    });

    Route::post('/kriteria-assessment/update', function (Request $request) {
        $data = $request->collect();
        $data = $data->map(function($d, $key) use($data) {
            if(is_array($d)) {
                $d = collect($d)->filter(function($d_item) {
                    return $d_item != null;
                })->first();
            }
            return $d;
        })->toArray();
        $rules = [
            "kategori" => "required",
            "kriteria-penilaian" => "required",
            "nilai" => "required",
            "isi" => "required",
        ];

        $is_invalid = validateInput($data, $rules);
        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $new_kriteria = KriteriaAssessment::find($data["id-kriteria"]);
        if(empty($new_kriteria)) {
            Alert::html("Error", "Kriteria Assessment tidak ditemukan!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }
        $new_kriteria->start_tahun = $data["tahun_start"];
        $new_kriteria->start_bulan = $data["bulan_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $new_kriteria->finish_tahun = $data["tahun_finish"] ?? "";
            $new_kriteria->finish_bulan = $data["bulan_finish"] ?? "";
        }
        $new_kriteria->kategori = $data["kategori"];
        $new_kriteria->kriteria_penilaian = $data["kriteria-penilaian"];
        $new_kriteria->klasifikasi = $data["klasifikasi"];
        $new_kriteria->nilai = $data["nilai"];
        $new_kriteria->isi = $data["isi"];

        if($new_kriteria->save()) {
            Alert::success('Success', "Kriteria Assessment berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Assessment gagal diperbarui");
        return redirect()->back();
    });

    Route::post('/kriteria-assessment/delete', function (Request $request) {
        $data = $request->collect();
        $kriteria = KriteriaAssessment::find($data["id-kriteria"]);
        if($kriteria->delete()) {
            Alert::success('Success', "Kriteria Assessment berhasil dihapus");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Assessment gagal dihapus");
        return redirect()->back();
    });

    Route::get('/kriteria-assessment', function (Request $request) {
        $kriteria_assessments = KriteriaAssessment::all();
        return view("MasterData/KriteriaAssessment", compact(["kriteria_assessments"]));
    });

    Route::get('/matriks-approval-rekomendasi', function () {
        $approval_rekomendasi = MatriksApprovalRekomendasi::with(["Pegawai", "Divisi"])->where("start_tahun", "=", (int) date("Y"))->orderBy('updated_at')->get();
        // $jabatans = Jabatan::where("tahun", "=", (int) date("Y"))->get();
        // $unit_kerjas = UnitKerja::whereNotIn("divcode", ["B", "C", "D", "O", "U", "F", "L"])->get();
        $divisi_all = Divisi::all();
        $pegawai_all = Pegawai::all();
        $departemens = Departemen::all();
        // dd($approval_rekomendasi);
        return view("MasterData/MatriksApprovalRekomendasi", compact(["approval_rekomendasi", "divisi_all", "pegawai_all", "departemens"]));
    });

    Route::post('/matriks-approval-rekomendasi/save', function (Request $request) {
        $data = $request->all();
        $rules = [
            "tahun_start" => "required|numeric",
            "bulan_start" => "required|numeric",
            "nama-pegawai" => "required",
            "unit-kerja" => "required",
            "klasifikasi-proyek" => "required",
            // "departemen" => "required",
            "kategori" => "required",
            "kode-unit" => "required",
            "urutan" => "required",
        ];
        // $is_validate = $request->validateWithBag("post", [
        //     "start_tahun" => "required|numeric",
        //     "jabatan" => "required",
        //     "unit-kerja" => "required",
        // ]);
        $is_invalid = validateInput($data, $rules);

        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $approval_rekomendasi = new MatriksApprovalRekomendasi();
        $approval_rekomendasi->start_tahun = $data["tahun_start"];
        $approval_rekomendasi->start_bulan = $data["bulan_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $approval_rekomendasi->finish_tahun = $data["tahun_finish"];
            $approval_rekomendasi->finish_bulan = $data["bulan_finish"];
        }
        $approval_rekomendasi->is_active = isset($data["isActive"]) ? true : false;
        // $approval_rekomendasi->jabatan = $data["jabatan"];
        $approval_rekomendasi->nama_pegawai = $data["nama-pegawai"];
        $approval_rekomendasi->unit_kerja = $data["unit-kerja"];
        $approval_rekomendasi->klasifikasi_proyek = $data["klasifikasi-proyek"];
        $approval_rekomendasi->kategori = $data["kategori"];
        $approval_rekomendasi->departemen = $data["departemen"];
        $approval_rekomendasi->kode_unit_kerja = $data["kode-unit"];
        $approval_rekomendasi->urutan = $data["urutan"];

        if($approval_rekomendasi->save()) {
            Alert::success('Success', "Matriks Approval Rekomendasi berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Rekomendasi gagal ditambahkan");
        return redirect()->back();
    });

    Route::post('/matriks-approval-rekomendasi/update', function (Request $request) {
        $data = $request->all();
        $rules = [
            "tahun_start" => "required|numeric",
            "bulan_start" => "required|numeric",
            "nama-pegawai" => "required",
            "unit-kerja" => "required",
            "klasifikasi-proyek" => "required",
            "kategori" => "required",
            "kode-unit" => "required",
            "urutan" => "required",
            // "departemen" => "required"
        ];
        // $is_validate = $request->validateWithBag("post", [
        //     "tahun" => "required|numeric",
        //     "jabatan" => "required",
        //     "unit-kerja" => "required",
        // ]);
        $is_invalid = validateInput($data, $rules);

        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $approval_rekomendasi = MatriksApprovalRekomendasi::find($data["id-matriks-approval"]);
        // $approval_rekomendasi->jabatan = $data["jabatan"];
        $approval_rekomendasi->nama_pegawai = $data["nama-pegawai"];
        $approval_rekomendasi->unit_kerja = $data["unit-kerja"];
        $approval_rekomendasi->klasifikasi_proyek = $data["klasifikasi-proyek"];
        $approval_rekomendasi->departemen = $data["departemen"];
        $approval_rekomendasi->kategori = $data["kategori"];
        $approval_rekomendasi->start_tahun = $data["tahun_start"];
        $approval_rekomendasi->start_bulan = $data["bulan_start"];
        $approval_rekomendasi->is_active = isset($data["isActive"]) ? true : false;
        if ($approval_rekomendasi->is_active == true) {
            $approval_rekomendasi->finish_tahun = null;
            $approval_rekomendasi->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $approval_rekomendasi->finish_tahun = $data["tahun_finish"];
                $approval_rekomendasi->finish_bulan = $data["bulan_finish"];
            }
        }
        $approval_rekomendasi->kode_unit_kerja = $data["kode-unit"];
        $approval_rekomendasi->urutan = $data["urutan"];

        // dd($approval_rekomendasi);

        if($approval_rekomendasi->save()) {
            Alert::success('Success', "Matriks Approval Rekomendasi berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Rekomendasi gagal diperbarui");
        return redirect()->back();
    });

    Route::post('/matriks-approval-rekomendasi/delete', function (Request $request) {
        $data = $request->all();
        // dd($data);
        $approval_rekomendasi = MatriksApprovalRekomendasi::find($data["id-matriks-approval"]);

        if($approval_rekomendasi->delete()) {
            Alert::success('Success', "Matriks Approval Rekomendasi berhasil dihapus");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Rekomendasi gagal dihapus");
        return redirect()->back();
    });

    Route::get('/legalitas-perusahaan', function () {
        $data = LegalitasPerusahaan::all();
        return view("MasterData/LegalitasPerusahaan", compact(["data"]));
    });

    Route::post('/legalitas-perusahaan/save', function (Request $request) {
        $data = $request->all();

        $legalitas = new LegalitasPerusahaan();
        // $legalitas->bobot = $data["bobot"];
        $legalitas->item = $data["item"];
        $legalitas->item_2 = $data["item_2"] ?? null;
        $legalitas->nota_rekomendasi = $data["nota_rekomendasi"];
        $legalitas->start_tahun = $data["tahun_start"];
        $legalitas->start_bulan = $data["bulan_start"];
        $legalitas->is_active = isset($data["isActive"]) ? true : false;

        if ($legalitas->nota_rekomendasi == "Nota Rekomendasi 2") {
            if (isset($data['kategori'])) {
                $legalitas->kategori = $data['kategori'];
            }
        }

        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $legalitas->finish_tahun = $data["tahun_finish"];
            $legalitas->finish_bulan = $data["bulan_finish"];
        }

        if ($legalitas->save()) {
            Alert::success("Success", "Legalitas Perusahaan Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Legalitas Perusahaan Gagal Ditambahkan");
        return redirect()->back();
    });

    Route::post('/legalitas-perusahaan/update/{id}', function (Request $request, string $id) {
        $data = $request->all();

        $legalitas = LegalitasPerusahaan::find($id);

        // dd($data, $kriteriaPenggunaJasa);

        if (empty($legalitas)) {
            Alert::success("Error", "Legalitas Perusahaan Tidak Ditemukan");
            return redirect()->back();
        }

        // $legalitas->bobot = $data["bobot"];
        $legalitas->item = $data["item"];
        $legalitas->item_2 = $data["item_2"] ?? null;
        $legalitas->nota_rekomendasi = $data["nota_rekomendasi"];
        $legalitas->start_tahun = $data["tahun_start"];
        $legalitas->start_bulan = $data["bulan_start"];
        $legalitas->is_active = isset($data["isActive"]) ? true : false;

        if ($legalitas->nota_rekomendasi == "Nota Rekomendasi 2") {
            if (isset($data['kategori'])) {
                $legalitas->kategori = $data['kategori'];
            }
        }

        if ($legalitas->is_active == true) {
            $legalitas->finish_tahun = null;
            $legalitas->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $legalitas->finish_tahun = $data["tahun_finish"];
                $legalitas->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($legalitas->save()) {
            Alert::success("Success", "Legalitas Perusahaan Berhasil Diubah");
            return redirect()->back();
        }
        Alert::success("Error", "Legalitas Perusahaan Gagal Diubah");
        return redirect()->back();
    });

    Route::post('/legalitas-perusahaan/delete/{id}', function (Request $request, $id) {
        $data = $request->all();

        $legalitas = LegalitasPerusahaan::find($id);

        if (empty($legalitas)) {
            Alert::success("Error", "Legalitas Perusahaan Tidak Ditemukan");
            return redirect()->back();
        }

        if ($legalitas->delete()) {
            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });

    // Begin :: Master Data Jabatan
    Route::get('/jabatan', function () {
        $jabatans = Jabatan::where("tahun", "=", (int) date("Y"))->get();
        $dops = Dop::all();
        return view("MasterData/Jabatan", compact(["jabatans", "dops"]));
    });

    Route::post('/jabatan/save', function (Request $request) {
        $data = $request->collect();
        // dd($data);
        $rules = [
            "tahun" => "required|numeric",
            "nama-jabatan" => "required",
            "unit-kerja" => "required",
        ];
        $is_invalid = validateInput($data->toArray(), $rules);

        if(!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }
        $data = $data->map(function($d) {
            if(is_array($d)) {
                return collect($d)->join(",");
            }
            return $d;
        });

        $update_jabatan = Jabatan::find($data["id-jabatan"]);
        $update_jabatan->nama_jabatan = $data["nama-jabatan"];
        $update_jabatan->unit_kerja = $data["unit-kerja"];
        $update_jabatan->tahun = $data["tahun"];

        if($update_jabatan->save()) {
            Alert::success('Success', "Jabatan berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error('Error', "Jabatan gagal diperbarui");
        return redirect()->back();
    });


    // Begin :: Master Data Pegawai
    Route::get("/pegawai", [
        PegawaiController::class, "index"
    ]);
    // End :: Master Data Pegawai

    // Begin :: Master Data Divisi
    Route::get(
        "/divisi",
        [
            DivisiController::class, "index"
        ]
    );
    Route::post(
        "/divisi/save",
        [DivisiController::class, "save"]
    );
    Route::post("/divisi/{divisi}/save", [DivisiController::class, "edit"]);
    Route::post("/divisi/{divisi}/delete", [DivisiController::class, "delete"]);
    // End :: Master Data Divisi

    // Begin :: Master Data Direktorat
    Route::get("/direktorat", [DirektoratController::class, "index"]);
    Route::post(
        "/direktorat/save",
        [DirektoratController::class, "save"]
    );
    Route::post("/direktorat/{direktorat}/save", [DirektoratController::class, "edit"]);
    Route::post("/direktorat/{direktorat}/delete", [DirektoratController::class, "delete"]);
    // End :: Master Data Direktorat

    //Begin :: Master Data Departemen
    Route::get(
        "/departemen",
        [
            DepartemenController::class, "index"
        ]
    );
    Route::post(
        "/departemen/save",
        [DepartemenController::class, "createDepartemen"]
    );
    Route::post(
        "/departemen/{id}/edit",
        [DepartemenController::class, "editDepartemen"]
    );
    Route::post("/departemen/{kode_departemen}/delete", [DepartemenController::class, "deleteDepartemen"]);
    //End:: Master Data Departemen


    Route::get('/otomasi-approval', [OtomasiApprovalController::class, 'index']);
    Route::post('/otomasi-approval/save', [OtomasiApprovalController::class, 'store']);
    Route::post('/otomasi-approval/update/{id}', [OtomasiApprovalController::class, 'update']);
    Route::post('/otomasi-approval/delete/{id}', [OtomasiApprovalController::class, 'destroy']);

    Route::get('/kriteria-pengguna-jasa', [KriteriaPenggunaJasaController::class, 'index']);
    Route::post('/kriteria-pengguna-jasa/save', [KriteriaPenggunaJasaController::class, 'store']);
    Route::post('/kriteria-pengguna-jasa/update/{id}', [KriteriaPenggunaJasaController::class, 'update']);
    Route::post('/kriteria-pengguna-jasa/delete/{id}', [KriteriaPenggunaJasaController::class, 'destroy']);
    Route::post('/kriteria-pengguna-jasa/delete-file', [KriteriaPenggunaJasaController::class, 'deleteFile']);
    Route::post('/kriteria-pengguna-jasa/detail/save', [KriteriaPenggunaJasaController::class, 'detailSave']);
    Route::post('/kriteria-pengguna-jasa/detail/edit', [KriteriaPenggunaJasaController::class, 'detailEdit']);
    
    Route::get('/penilaian-pengguna-jasa', [PenilaianPenggunaJasaController::class, 'index']);
    Route::post('/penilaian-pengguna-jasa/save', [PenilaianPenggunaJasaController::class, 'store']);
    Route::post('/penilaian-pengguna-jasa/update/{id}', [PenilaianPenggunaJasaController::class, 'update']);
    Route::post('/penilaian-pengguna-jasa/delete/{id}', [PenilaianPenggunaJasaController::class, 'destroy']);

    Route::get('/kriteria-selection-non-greenlane', [KriteriaSelectionNonGreenlaneController::class, 'index']);
    Route::post('/kriteria-selection-non-greenlane/save', [KriteriaSelectionNonGreenlaneController::class, 'store']);
    Route::post('/kriteria-selection-non-greenlane/update/{id}', [KriteriaSelectionNonGreenlaneController::class, 'update']);
    Route::post('/kriteria-selection-non-greenlane/delete/{id}', [KriteriaSelectionNonGreenlaneController::class, 'destroy']);

    Route::get('/penilaian-partner-selection', function () {
        return view('MasterData/PenilaianPartnerSelection', ['data' => PenilaianPartnerSelection::all()]);
    });
    Route::post('/penilaian-partner-selection/save', function (Request $request) {
        $data = $request->all();

        $penilaian = new PenilaianPartnerSelection();
        $penilaian->nama = $data["nama"];
        // $penilaian->nota_rekomendasi = $data["nota_rekomendasi"];
        $penilaian->dari_nilai = $data["dari_nilai"];
        $penilaian->sampai_nilai = $data["sampai_nilai"];
        $penilaian->start_tahun = $data["tahun_start"];
        $penilaian->start_bulan = $data["bulan_start"];
        $penilaian->is_active = isset($data["isActive"]) ? true : false;
        if (
            $penilaian->is_active == true
        ) {
            $penilaian->finish_tahun = null;
            $penilaian->finish_bulan = null;
        } else {
            if (
                isset($data["tahun_finish"]) && isset($data["bulan_finish"])
            ) {
                $penilaian->finish_tahun = $data["tahun_finish"];
                $penilaian->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($penilaian->save()) {
            Alert::success("Success", "Penilaian Partner Selection Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Penilaian Partner Selection Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/penilaian-partner-selection/update/{id}', function (Request $request, $id) {
        $data = $request->all();

        $penilaianPenggunaJasa = PenilaianPartnerSelection::find($id);

        // dd($data, $penilaianPenggunaJasa);

        if (empty($penilaianPenggunaJasa)) {
            Alert::success("Error", "Penilaian Pengguna Jasa Tidak Ditemukan");
            return redirect()->back();
        }

        // $penilaianPenggunaJasa->nota_rekomendasi = $data["nota_rekomendasi"];
        $penilaianPenggunaJasa->nama = $data["nama"];
        $penilaianPenggunaJasa->dari_nilai = $data["dari_nilai"];
        $penilaianPenggunaJasa->sampai_nilai = $data["sampai_nilai"];
        $penilaianPenggunaJasa->start_tahun = $data["tahun_start"];
        $penilaianPenggunaJasa->start_bulan = $data["bulan_start"];
        $penilaianPenggunaJasa->is_active = isset($data["isActive"]) ? true : false;
        if ($penilaianPenggunaJasa->is_active == true) {
            $penilaianPenggunaJasa->finish_tahun = null;
            $penilaianPenggunaJasa->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $penilaianPenggunaJasa->finish_tahun = $data["tahun_finish"];
                $penilaianPenggunaJasa->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($penilaianPenggunaJasa->save()) {
            Alert::success("Success", "Penilaian Pengguna Jasa Berhasil Diubah");
            return redirect()->back();
        }
        Alert::success("Error", "Penilaian Pengguna Jasa Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/penilaian-partner-selection/delete/{id}', function ($id) {
        $isPenilaian = PenilaianPartnerSelection::find($id);
        if ($isPenilaian) {
            $isPenilaian->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    });

    Route::get('/penilaian-checklist-project-selection', function () {
        return view('MasterData/PenilaianChecklistProjectSelection', ['data' => PenilaianChecklistProjectSelection::all()]);
    });
    Route::post('/penilaian-checklist-project-selection/save', function (Request $request) {
        $data = $request->all();

        $penilaian = new PenilaianChecklistProjectSelection();
        $penilaian->nama = $data["nama"];
        // $penilaian->nota_rekomendasi = $data["nota_rekomendasi"];
        $penilaian->dari_nilai = $data["dari_nilai"];
        $penilaian->sampai_nilai = $data["sampai_nilai"];
        $penilaian->start_tahun = $data["tahun_start"];
        $penilaian->start_bulan = $data["bulan_start"];
        $penilaian->is_active = isset($data["isActive"]) ? true : false;
        if (
            $penilaian->is_active == true
        ) {
            $penilaian->finish_tahun = null;
            $penilaian->finish_bulan = null;
        } else {
            if (
                isset($data["tahun_finish"]) && isset($data["bulan_finish"])
            ) {
                $penilaian->finish_tahun = $data["tahun_finish"];
                $penilaian->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($penilaian->save()) {
            Alert::success("Success", "Penilaian Project Selection Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Penilaian Project Selection Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/penilaian-checklist-project-selection/update/{id}', function (Request $request, $id) {
        $data = $request->all();

        $penilaianPenggunaJasa = PenilaianChecklistProjectSelection::find($id);

        // dd($data, $penilaianPenggunaJasa);

        if (empty($penilaianPenggunaJasa)) {
            Alert::success("Error", "Penilaian Project Selection Tidak Ditemukan");
            return redirect()->back();
        }

        // $penilaianPenggunaJasa->nota_rekomendasi = $data["nota_rekomendasi"];
        $penilaianPenggunaJasa->nama = $data["nama"];
        $penilaianPenggunaJasa->dari_nilai = $data["dari_nilai"];
        $penilaianPenggunaJasa->sampai_nilai = $data["sampai_nilai"];
        $penilaianPenggunaJasa->start_tahun = $data["tahun_start"];
        $penilaianPenggunaJasa->start_bulan = $data["bulan_start"];
        $penilaianPenggunaJasa->is_active = isset($data["isActive"]) ? true : false;
        if ($penilaianPenggunaJasa->is_active == true) {
            $penilaianPenggunaJasa->finish_tahun = null;
            $penilaianPenggunaJasa->finish_bulan = null;
        } else {
            if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
                $penilaianPenggunaJasa->finish_tahun = $data["tahun_finish"];
                $penilaianPenggunaJasa->finish_bulan = $data["bulan_finish"];
            }
        }

        if ($penilaianPenggunaJasa->save()) {
            Alert::success("Success", "Penilaian Project Selection Berhasil Diubah");
            return redirect()->back();
        }
        Alert::success("Error", "Penilaian Project Selection Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/penilaian-checklist-project-selection/delete/{id}', function ($id) {
        $isPenilaian = PenilaianChecklistProjectSelection::find($id);
        if ($isPenilaian) {
            $isPenilaian->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    });

    //Begin::Klasifikasi Proyek
    Route::get('/master-klasifikasi-proyek', function () {
        return view('MasterData/MasterKlasifikasiProyek', ['data' => MasterKlasifikasiProyek::all()]);
    });
    Route::post('/master-klasifikasi-proyek/save', function (Request $request) {
        $data = $request->all();

        $klasifikasi = new MasterKlasifikasiProyek();
        $klasifikasi->keterangan = $data["nama"];
        // $klasifikasi->nota_rekomendasi = $data["nota_rekomendasi"];
        $klasifikasi->dari_nilai = str_replace('.', '', $data["dari_nilai"]);
        $klasifikasi->sampai_nilai = str_replace('.', '', $data["sampai_nilai"]);
        // $klasifikasi->start_tahun = $data["tahun_start"];
        // $klasifikasi->start_bulan = $data["bulan_start"];
        // $klasifikasi->is_active = isset($data["isActive"]) ? true : false;
        // if (
        //     $klasifikasi->is_active == true
        // ) {
        //     $klasifikasi->finish_tahun = null;
        //     $klasifikasi->finish_bulan = null;
        // } else {
        //     if (
        //         isset($data["tahun_finish"]) && isset($data["bulan_finish"])
        //     ) {
        //         $klasifikasi->finish_tahun = $data["tahun_finish"];
        //         $klasifikasi->finish_bulan = $data["bulan_finish"];
        //     }
        // }

        if ($klasifikasi->save()) {
            Alert::success(
                "Success",
                "Klasifikasi Proyek Berhasil Ditambahkan"
            );
            return redirect()->back();
        }
        Alert::success("Error", "Penilaian Partner Selection Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-klasifikasi-proyek/update/{id}', function (Request $request, $id) {
        $data = $request->all();

        $klasifikasi = MasterKlasifikasiProyek::find($id);

        // dd($data, $klasifikasi);

        if (empty($klasifikasi)) {
            Alert::success("Error", "Klasifikasi Proyek Tidak Ditemukan");
            return redirect()->back();
        }

        // $klasifikasi->nota_rekomendasi = $data["nota_rekomendasi"];
        $klasifikasi->keterangan = $data["nama"];
        $klasifikasi->dari_nilai = $data["dari_nilai"];
        $klasifikasi->sampai_nilai = $data["sampai_nilai"];
        // $klasifikasi->start_tahun = $data["tahun_start"];
        // $klasifikasi->start_bulan = $data["bulan_start"];
        // $klasifikasi->is_active = isset($data["isActive"]) ? true : false;
        // if ($klasifikasi->is_active == true) {
        //     $klasifikasi->finish_tahun = null;
        //     $klasifikasi->finish_bulan = null;
        // } else {
        //     if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
        //         $klasifikasi->finish_tahun = $data["tahun_finish"];
        //         $klasifikasi->finish_bulan = $data["bulan_finish"];
        //     }
        // }

        if ($klasifikasi->save()) {
            Alert::success(
                "Success",
                "Klasifikasi Proyek Berhasil Diubah"
            );
            return redirect()->back();
        }
        Alert::success("Error", "Klasifikasi Jasa Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/master-klasifikasi-proyek/delete/{id}', function ($id) {
        $isPenilaian = MasterKlasifikasiProyek::find($id);
        if ($isPenilaian) {
            $isPenilaian->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    });
    //End::Klasifikasi Proyek

    //Begin::Klasifikasi Omzet Proyek
    Route::get('/master-klasifikasi-omzet', function () {
        return view('MasterData/MasterKlasifikasiOmset', ['data' => MasterKlasifikasiOmsetProyek::all()]);
    });
    Route::post('/master-klasifikasi-omzet/save', function (Request $request) {
        $data = $request->all();

        $klasifikasi = new MasterKlasifikasiOmsetProyek();
        $klasifikasi->keterangan = $data["nama"];
        // $klasifikasi->nota_rekomendasi = $data["nota_rekomendasi"];
        $klasifikasi->dari_nilai = str_replace('.', '', $data["dari_nilai"]);
        $klasifikasi->sampai_nilai = str_replace('.', '', $data["sampai_nilai"]);
        // $klasifikasi->start_tahun = $data["tahun_start"];
        // $klasifikasi->start_bulan = $data["bulan_start"];
        // $klasifikasi->is_active = isset($data["isActive"]) ? true : false;
        // if (
        //     $klasifikasi->is_active == true
        // ) {
        //     $klasifikasi->finish_tahun = null;
        //     $klasifikasi->finish_bulan = null;
        // } else {
        //     if (
        //         isset($data["tahun_finish"]) && isset($data["bulan_finish"])
        //     ) {
        //         $klasifikasi->finish_tahun = $data["tahun_finish"];
        //         $klasifikasi->finish_bulan = $data["bulan_finish"];
        //     }
        // }

        if ($klasifikasi->save()) {
            Alert::success(
                "Success",
                "Klasifikasi Omzet Proyek Berhasil Ditambahkan"
            );
            return redirect()->back();
        }
        Alert::success("Error", "Klasifikasi Omzet Proyek Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-klasifikasi-omzet/update/{id}', function (Request $request, $id) {
        $data = $request->all();

        $klasifikasi = MasterKlasifikasiOmsetProyek::find($id);

        // dd($data, $klasifikasi);

        if (empty($klasifikasi)) {
            Alert::success("Error", "Klasifikasi Omzet Proyek Tidak Ditemukan");
            return redirect()->back();
        }

        // $klasifikasi->nota_rekomendasi = $data["nota_rekomendasi"];
        $klasifikasi->keterangan = $data["nama"];
        $klasifikasi->dari_nilai = $data["dari_nilai"];
        $klasifikasi->sampai_nilai = $data["sampai_nilai"];
        // $klasifikasi->start_tahun = $data["tahun_start"];
        // $klasifikasi->start_bulan = $data["bulan_start"];
        // $klasifikasi->is_active = isset($data["isActive"]) ? true : false;
        // if ($klasifikasi->is_active == true) {
        //     $klasifikasi->finish_tahun = null;
        //     $klasifikasi->finish_bulan = null;
        // } else {
        //     if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
        //         $klasifikasi->finish_tahun = $data["tahun_finish"];
        //         $klasifikasi->finish_bulan = $data["bulan_finish"];
        //     }
        // }

        if ($klasifikasi->save()) {
            Alert::success(
                "Success",
                "Klasifikasi Omzet Proyek Berhasil Diubah"
            );
            return redirect()->back();
        }
        Alert::success("Error", "Klasifikasi Omzet Proyek Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/master-klasifikasi-omzet/delete/{id}', function ($id) {
        $isPenilaian = MasterKlasifikasiOmsetProyek::find($id);
        if ($isPenilaian) {
            $isPenilaian->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    });
    //End::Klasifikasi Omzet Proyek

    //Begin::Klasifikasi Omzet Proyek
    Route::get('/master-klasifikasi-produksi', function () {
        return view('MasterData/MasterKlasifikasiProduksiProyek', ['data' => MasterKlasifikasiProduksiProyek::all()]);
    });
    Route::post('/master-klasifikasi-produksi/save', function (Request $request) {
        $data = $request->all();

        $klasifikasi = new MasterKlasifikasiProduksiProyek();
        $klasifikasi->keterangan = $data["nama"];
        // $klasifikasi->nota_rekomendasi = $data["nota_rekomendasi"];
        $klasifikasi->dari_nilai = str_replace('.', '', $data["dari_nilai"]);
        $klasifikasi->sampai_nilai = str_replace('.', '', $data["sampai_nilai"]);
        // $klasifikasi->start_tahun = $data["tahun_start"];
        // $klasifikasi->start_bulan = $data["bulan_start"];
        // $klasifikasi->is_active = isset($data["isActive"]) ? true : false;
        // if (
        //     $klasifikasi->is_active == true
        // ) {
        //     $klasifikasi->finish_tahun = null;
        //     $klasifikasi->finish_bulan = null;
        // } else {
        //     if (
        //         isset($data["tahun_finish"]) && isset($data["bulan_finish"])
        //     ) {
        //         $klasifikasi->finish_tahun = $data["tahun_finish"];
        //         $klasifikasi->finish_bulan = $data["bulan_finish"];
        //     }
        // }

        if ($klasifikasi->save()) {
            Alert::success(
                "Success",
                "Klasifikasi Produksi Proyek Berhasil Ditambahkan"
            );
            return redirect()->back();
        }
        Alert::success("Error", "Klasifikasi Produksi Proyek Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-klasifikasi-produksi/update/{id}', function (Request $request, $id) {
        $data = $request->all();

        $klasifikasi = MasterKlasifikasiProduksiProyek::find($id);

        // dd($data, $klasifikasi);

        if (empty($klasifikasi)) {
            Alert::success("Error", "Klasifikasi Produksi Proyek Tidak Ditemukan");
            return redirect()->back();
        }

        // $klasifikasi->nota_rekomendasi = $data["nota_rekomendasi"];
        $klasifikasi->keterangan = $data["nama"];
        $klasifikasi->dari_nilai = $data["dari_nilai"];
        $klasifikasi->sampai_nilai = $data["sampai_nilai"];
        // $klasifikasi->start_tahun = $data["tahun_start"];
        // $klasifikasi->start_bulan = $data["bulan_start"];
        // $klasifikasi->is_active = isset($data["isActive"]) ? true : false;
        // if ($klasifikasi->is_active == true) {
        //     $klasifikasi->finish_tahun = null;
        //     $klasifikasi->finish_bulan = null;
        // } else {
        //     if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
        //         $klasifikasi->finish_tahun = $data["tahun_finish"];
        //         $klasifikasi->finish_bulan = $data["bulan_finish"];
        //     }
        // }

        if ($klasifikasi->save()) {
            Alert::success(
                "Success",
                "Klasifikasi Produksi Proyek Berhasil Diubah"
            );
            return redirect()->back();
        }
        Alert::success("Error", "Klasifikasi Produksi Proyek Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/master-klasifikasi-produksi/delete/{id}', function ($id) {
        $isPenilaian = MasterKlasifikasiProduksiProyek::find($id);
        if ($isPenilaian) {
            $isPenilaian->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    });
    //End::Klasifikasi Omzet Proyek

    Route::get('/proyek/get-data-alat', function (Request $request) {
        $search = $request->input('search');
        $page = $request->input(
            'page',
            1
        );
        $perPage = 10;
        $maxResults = 10;

        $dataPegawai = MasterAlatProyek::when(!empty($search), function ($query) use ($search) {
            // $query->where('nomor_rangka', 'like', '%' . strtoupper($search) . '%')
            $query->where('nomor_rangka', 'like', '%' . $search . '%')
            ->orWhere('nama_alat', 'like', '%' . $search . '%');
        });
        $data = $dataPegawai->paginate($perPage, ['*'], 'page', $page);

        // $data->pagination['more'] = ($page * $perPage) < $maxResults;

        return response()->json($data);
    });

    Route::post('/proyek/check-alat-select/get', function (Request $request) {
        $alatProyekFilter = AlatProyek::where('nomor_rangka', $request->get('nomor_rangka'))->get();

        try {
            if ($alatProyekFilter->count() > 0) {
                $checkAlatInProyek = $alatProyekFilter->map(function ($personel) {
                    return $personel->Proyek;
                })->unique('kode_proyek')->values()->all();

                $filterStageProyek = collect($checkAlatInProyek)->filter(function ($proyek) {
                    return $proyek->is_cancel != true && $proyek->stage >= 4 && $proyek->stage != 7;
                });

                if ($filterStageProyek->count() > 0) {
                    $checkProyekCustomer = $filterStageProyek->map(function ($proyek) {
                        return $proyek->proyekBerjalan->customer;
                    });

                    $checkCustomerPUPR = $checkProyekCustomer->filter(function ($customer) {
                        return $customer->kode_pelanggan == "A10021";
                    });

                    if ($checkCustomerPUPR->count() > 3) {
                        return response()->json([
                            "Success" => true,
                            "Message" => "Alat sedang mengikuti proses 3 Tender"
                        ]);
                    } else {
                        return response()->json([
                            "Success" => true,
                            "Message" => null
                        ]);
                    }
                } else {
                    return response()->json([
                        "Success" => true,
                        "Message" => null
                    ]);
                }
            } else {
                return response()->json([
                    "Success" => true,
                    "Message" => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "Success" => false,
                "Message" => $e->getMessage()
            ]);
        }
    });

    //Begin::Master get data pegawai
    Route::get('/proyek/get-data-pegawai', function (Request $request) {
        $search = $request->input('search');
        $page = $request->input(
            'page',
            1
        );
        $perPage = 10;
        $maxResults = 10;

        $dataPegawai = Pegawai::when(!empty($search), function ($query) use ($search) {
            $query->where('nama_pegawai', 'like', '%' . strtoupper($search) . '%')
                ->orWhere('nip', 'like', '%' . strtoupper($search) . '%');
        });
        $data = $dataPegawai->paginate($perPage, ['*'], 'page', $page);

        // $data->pagination['more'] = ($page * $perPage) < $maxResults;

        return response()->json($data);
    });

    Route::get('/proyek/check-pegawai-pupr/{nip}', function ($nip) {
        $personelFilter = PersonelTenderProyek::where('nip', $nip)->get();

        try {
            if ($personelFilter->count() > 0) {
                $checkPersonelInProyek = $personelFilter->map(function ($personel) {
                    return $personel->Proyek;
                })->unique('kode_proyek')->values()->all();

                $filterStageProyek = collect($checkPersonelInProyek)->filter(function ($proyek) {
                    return $proyek->is_cancel != true && $proyek->stage >= 4 && $proyek->stage != 7;
                });

                if ($filterStageProyek->count() > 0) {
                    $checkProyekCustomer = $filterStageProyek->map(function ($proyek) {
                        return $proyek->proyekBerjalan->customer;
                    });

                    $checkCustomerPUPR = $checkProyekCustomer->filter(function ($customer) {
                        return $customer->kode_pelanggan == "A10021";
                    });

                    if ($checkCustomerPUPR->count() > 3) {
                        return response()->json([
                            "Success" => true,
                            "Message" => "Personel sedang mengikuti proses 3 Tender PUPR"
                        ]);
                    } else {
                        return response()->json([
                            "Success" => true,
                            "Message" => null
                        ]);
                    }
                } else {
                    return response()->json([
                        "Success" => true,
                        "Message" => null
                    ]);
                }
            } else {
                return response()->json([
                    "Success" => true,
                    "Message" => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "Success" => false,
                "Message" => $e->getMessage()
            ]);
        }
    });

    Route::get('/get-data-divisi/{divisi_id}', function (Request $request, $divisi_id) {

        $divisi = Divisi::find($divisi_id);

        if (!empty($divisi) && !empty($divisi->kode_sap)) {
            $data = Departemen::where('kode_divisi', $divisi->kode_sap)->get();
        } else {
            $data = Departemen::all();
        }

        return response()->json($data);
    });

    Route::get(
        '/matriks-approval-partner',
        function () {
            $matriks_all = MatriksApprovalPartnerSelection::with(["Pegawai", "Divisi"])
            ->where('is_active', true)
            ->orderBy('updated_at')
            ->get();

            $divisi_all = Divisi::all();
            $pegawai_all = Pegawai::pluck('nama_pegawai', 'nip');
            $departemens = Departemen::all();
            // dd($matriks_all);
            return view("MasterData/MatriksApprovalPartnerSelection", compact([
                "matriks_all", "divisi_all", "pegawai_all", "departemens"
            ]));
        }
    );

    Route::post('/matriks-approval-partner/save', function (Request $request) {
        $data = $request->all();
        // dd($data);
        $rules = [
            "tahun_start" => "required|numeric",
            "bulan_start" => "required|numeric",
            "nama-pegawai" => "required",
            "unit-kerja" => "required",
            "klasifikasi-proyek" => "required",
            // "departemen" => "required",
            "kategori" => "required",
            "kode-unit" => "required",
            "urutan" => "required",
        ];
        // $is_validate = $request->validateWithBag("post", [
        //     "start_tahun" => "required|numeric",
        //     "jabatan" => "required",
        //     "unit-kerja" => "required",
        // ]);
        $is_invalid = validateInput($data, $rules);

        if (!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $namaPegawai = Pegawai::where(
            'nip',
            $data["nama-pegawai"]
        )->first()->nama_pegawai;

        $matriks = new MatriksApprovalPartnerSelection();
        $matriks->start_tahun = $data["tahun_start"];
        $matriks->start_bulan = $data["bulan_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $matriks->finish_tahun = $data["tahun_finish"];
            $matriks->finish_bulan = $data["bulan_finish"];
        }
        $matriks->is_active = isset($data["isActive"]) ? true : false;
        // $matriks->jabatan = $data["jabatan"];
        $matriks->nama_pegawai = $data["nama-pegawai"];
        $matriks->title = $namaPegawai;
        $matriks->divisi_id = $data["unit-kerja"];
        $matriks->klasifikasi_proyek = $data["klasifikasi-proyek"];
        $matriks->kategori = $data["kategori"];
        $matriks->departemen_code = $data["departemen"];
        $matriks->kode_unit_kerja = $data["kode-unit"];
        $matriks->urutan = $data["urutan"];

        if ($matriks->save()) {
            Alert::success('Success', "Matriks Approval Partner berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Partner gagal ditambahkan");
        return redirect()->back();
    });

    Route::post('/matriks-approval-partner/update', function (Request $request) {
        $data = $request->all();
        $rules = [
            "tahun_start" => "required|numeric",
            "bulan_start" => "required|numeric",
            "nama-pegawai" => "required",
            "unit-kerja" => "required",
            "klasifikasi-proyek" => "required",
            "kategori" => "required",
            "kode-unit" => "required",
            "urutan" => "required",
            // "departemen" => "required"
        ];
        // $is_validate = $request->validateWithBag("post", [
        //     "tahun" => "required|numeric",
        //     "jabatan" => "required",
        //     "unit-kerja" => "required",
        // ]);
        $is_invalid = validateInput($data, $rules);

        if (!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $matriks = MatriksApprovalPartnerSelection::find($data["id-matriks-approval"]);
        $namaPegawai = Pegawai::where('nip', $data["nama-pegawai"])->first()->nama_pegawai;

        $matriks->start_bulan = $data["bulan_start"];
        $matriks->start_tahun = $data["tahun_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $matriks->finish_tahun = $data["tahun_finish"];
            $matriks->finish_bulan = $data["bulan_finish"];
        }
        $matriks->is_active = isset($data["isActive"]) ? true : false;
        // $matriks->jabatan = $data["jabatan"];
        $matriks->nama_pegawai = $data["nama-pegawai"];
        $matriks->title = $namaPegawai;
        $matriks->divisi_id = $data["unit-kerja"];
        $matriks->klasifikasi_proyek = $data["klasifikasi-proyek"];
        $matriks->kategori = $data["kategori"];
        $matriks->departemen_code = $data["departemen"];
        $matriks->kode_unit_kerja = $data["kode-unit"];
        $matriks->urutan = $data["urutan"];
        // dd($matriks);

        if ($matriks->save()) {
            Alert::success('Success', "Matriks Approval Partner berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Partner gagal diperbarui");
        return redirect()->back();
    });

    Route::post('/matriks-approval-partner/delete', function (Request $request) {
        $data = $request->all();
        $approval_partner = MatriksApprovalPartnerSelection::find($data["id-matriks-approval"]);

        if ($approval_partner->delete()) {
            Alert::success('Success', "Matriks Approval Partner berhasil dihapus");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Partner gagal dihapus");
        return redirect()->back();
    });
    //End::Master Matriks Approval Partner Selection

    //Begin::Master Matriks Approval Nota Rekomendasi 2   
    Route::get('/matriks-approval-rekomendasi-2', function () {
        $matriks_all = MatriksApprovalNotaRekomendasi2::with(["Pegawai", "Divisi"])
        ->where('is_active', true)
        ->orderBy('updated_at')
        ->get();

        $divisi_all = Divisi::all();
        $pegawai_all = Pegawai::pluck('nama_pegawai', 'nip');
        $departemens = Departemen::all();
        // dd($matriks_all);
        return view("MasterData/MatriksApprovalRekomendasi2", compact([
            "matriks_all", "divisi_all", "pegawai_all", "departemens"
        ]));
    });

    Route::post('/matriks-approval-rekomendasi-2/save', function (Request $request) {
        $data = $request->all();
        // dd($data);
        $rules = [
            "tahun_start" => "required|numeric",
            "bulan_start" => "required|numeric",
            "nama-pegawai" => "required",
            "unit-kerja" => "required",
            "klasifikasi-proyek" => "required",
            // "departemen" => "required",
            "kategori" => "required",
            "kode-unit" => "required",
            "urutan" => "required",
        ];
        // $is_validate = $request->validateWithBag("post", [
        //     "start_tahun" => "required|numeric",
        //     "jabatan" => "required",
        //     "unit-kerja" => "required",
        // ]);
        $is_invalid = validateInput($data, $rules);

        if (!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $namaPegawai = Pegawai::where(
            'nip',
            $data["nama-pegawai"]
        )->first()->nama_pegawai;

        $matriks = new MatriksApprovalNotaRekomendasi2();
        $matriks->start_tahun = $data["tahun_start"];
        $matriks->start_bulan = $data["bulan_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $matriks->finish_tahun = $data["tahun_finish"];
            $matriks->finish_bulan = $data["bulan_finish"];
        }
        $matriks->is_active = isset($data["isActive"]) ? true : false;
        // $matriks->jabatan = $data["jabatan"];
        $matriks->nama_pegawai = $data["nama-pegawai"];
        $matriks->title = $namaPegawai;
        $matriks->divisi_id = $data["unit-kerja"];
        $matriks->klasifikasi_proyek = $data["klasifikasi-proyek"];
        $matriks->kategori = $data["kategori"];
        $matriks->departemen_code = $data["departemen"];
        $matriks->kode_unit_kerja = $data["kode-unit"];
        $matriks->urutan = $data["urutan"];

        if ($matriks->save()) {
            Alert::success('Success', "Matriks Approval Nota Rekomendasi 2 berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Nota Rekomendasi 2 gagal ditambahkan");
        return redirect()->back();
    });

    Route::post('/matriks-approval-rekomendasi-2/update', function (Request $request) {
        $data = $request->all();
        $rules = [
            "tahun_start" => "required|numeric",
            "bulan_start" => "required|numeric",
            "nama-pegawai" => "required",
            "unit-kerja" => "required",
            "klasifikasi-proyek" => "required",
            "kategori" => "required",
            "kode-unit" => "required",
            "urutan" => "required",
            // "departemen" => "required"
        ];
        // $is_validate = $request->validateWithBag("post", [
        //     "tahun" => "required|numeric",
        //     "jabatan" => "required",
        //     "unit-kerja" => "required",
        // ]);
        $is_invalid = validateInput($data, $rules);

        if (!empty($is_invalid)) {
            Alert::html("Error", "Field <b>$is_invalid</b> harus terisi!", "error");
            return redirect()->back()->with("modal", $data["modal"]);
        }

        $matriks = MatriksApprovalNotaRekomendasi2::find($data["id-matriks-approval"]);
        $namaPegawai = Pegawai::where('nip', $data["nama-pegawai"])->first()->nama_pegawai;

        $matriks->start_bulan = $data["bulan_start"];
        $matriks->start_tahun = $data["tahun_start"];
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $matriks->finish_tahun = $data["tahun_finish"];
            $matriks->finish_bulan = $data["bulan_finish"];
        }
        $matriks->is_active = isset($data["isActive"]) ? true : false;
        // $matriks->jabatan = $data["jabatan"];
        $matriks->nama_pegawai = $data["nama-pegawai"];
        $matriks->title = $namaPegawai;
        $matriks->divisi_id = $data["unit-kerja"];
        $matriks->klasifikasi_proyek = $data["klasifikasi-proyek"];
        $matriks->kategori = $data["kategori"];
        $matriks->departemen_code = $data["departemen"];
        $matriks->kode_unit_kerja = $data["kode-unit"];
        $matriks->urutan = $data["urutan"];
        // dd($matriks);

        if ($matriks->save()) {
            Alert::success('Success', "Matriks Approval Nota Rekomendasi 2 berhasil diperbarui");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Nota Rekomendasi 2 gagal diperbarui");
        return redirect()->back();
    });

    Route::post('/matriks-approval-rekomendasi-2/delete', function (Request $request) {
        $data = $request->all();
        $approval_partner = MatriksApprovalNotaRekomendasi2::find($data["id-matriks-approval"]);

        if ($approval_partner->delete()) {
            Alert::success('Success', "Matriks Approval Nota Rekomendasi 2 berhasil dihapus");
            return redirect()->back();
        }
        Alert::error('Error', "Matriks Approval Nota Rekomendasi 2 gagal dihapus");
        return redirect()->back();
    });
    //End::Master Matriks Approval Nota Rekomendasi 2

    
    //End :: Master Data


    //Begin :: FAQ - KnowledgeBase
    Route::get('/knowledge-base',  [FaqsController::class, 'index']);

    Route::post('/knowledge-base/new',  [FaqsController::class, 'create']);

    Route::post('/knowledge-base/update',  [FaqsController::class, 'update']);

    Route::delete('/knowledge-base/delete/{id}',  [FaqsController::class, 'delete']);
    //End :: FAQ - KnowledgeBase


    //Begin :: History Autorisasi
    Route::get('/history-autorisasi', function (Request $request) {
        $bulan = (int) date('m');
        $year = (int) date('Y');
        if ($bulan == 1) {
            $periodeOtor = 12;
        } else {
            $periodeOtor = $request->query("periode-prognosa") ?? $bulan - 1;
            $jenisProyek = $request->query("jenis-proyek") ?? "All";
        }
        
        // $periodeOtor = (int) date('m');
        if ($periodeOtor == 1) {
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("tahun_perolehan", "=", $year)->where("periode_prognosa", "=", $periodeOtor)->where("tahun", "=", $year)->orderBy("proyeks.unit_kerja")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        } else {
            // $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("tahun_perolehan", "=", $year)->where("periode_prognosa", "=", $periodeOtor)->where("tahun", "=", $year)->orderBy("proyeks.unit_kerja")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
            $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $periodeOtor != "" ? (string) $periodeOtor : (int) date("m"))->where("history_forecast.tahun", "=", $year)->orderBy("proyeks.unit_kerja")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        }
        if($jenisProyek == "N") {
            $history_forecasts = $history_forecasts->where("jenis_proyek", "!=", "I");
        }
        // dd($history_forecasts->select(["proyeks.kode_proyek","proyeks.unit_kerja", "unit_kerjas.unit_kerja", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "nilai_forecast", "realisasi_forecast"])->get()->first());
        $history_forecasts = $history_forecasts->select(["proyeks.kode_proyek", "proyeks.unit_kerja", "unit_kerjas.unit_kerja", "unit_kerjas.divcode", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "rkap_forecast", "nilai_forecast", "month_realisasi", "realisasi_forecast", "month_forecast", "is_approved_1", "proyeks.stage", "is_rkap", "is_cancel"])->get()->groupBy("unit_kerja");
        // dump($history_forecasts->first()->first());
        // $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("stage", "!=", 7)->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        // $history_forecasts = $history_forecasts->get()->groupBy("unit_kerja");
        return view("/12_Autorisasi", compact("history_forecasts", "periodeOtor", "jenisProyek"));
    });

    Route::get('/history-autorisasi/{unit_kerja}/{jenisProyek}/{periode}/detail', function (Request $request, $unit_kerja, $jenisProyek, $periode) {
        $bulan = $periode;
        $year = (int) date('Y');
        $periodeOtor = $request->query("periode-prognosa") ?? $bulan;

        // $periodeOtor = (int) date('m');
        $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("tahun_perolehan", "=", $year)->where("periode_prognosa", "<=", $periodeOtor)->where("tahun", "=", $year)->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        // dump($history_forecasts->get());
        // $history_forecast_filter = $history_forecasts->get()->filter(function($history){
        //     if (!empty($history->realisasi_forecast) && empty($history->month_realisasi)) {
        //         return;
        //     }
        //     return $history;
        // });
        // dump($history_forecast_filter);
        if ($jenisProyek == "N") {
            $history_forecasts = $history_forecasts->where("jenis_proyek", "!=", "I");
        }
        // dd($history_forecasts->select(["proyeks.kode_proyek","proyeks.unit_kerja", "unit_kerjas.unit_kerja", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "nilai_forecast", "realisasi_forecast"])->get()->first());
        // $history_forecasts = $history_forecasts->select(["proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja",  "proyeks.tipe_proyek", "unit_kerjas.unit_kerja", "unit_kerjas.divcode", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "rkap_forecast", "nilai_forecast", "month_realisasi", "realisasi_forecast", "is_approved_1", "stage", "is_rkap", "bulan_ri_perolehan"])->get()->where("divcode", "=", $unit_kerja)->sortBy('periode_prognosa')->groupBy("nama_proyek");
        $history_forecasts = $history_forecasts->select(["proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja",  "proyeks.tipe_proyek", "unit_kerjas.unit_kerja", "unit_kerjas.divcode", "periode_prognosa", "history_forecast.created_at", "nilaiok_review", "nilaiok_awal", "rkap_forecast", "nilai_forecast", "month_realisasi", "realisasi_forecast", "is_approved_1", "proyeks.stage", "is_rkap", "bulan_ri_perolehan"])->get()->filter(function ($history) {
            // if (!empty($history->realisasi_forecast) && empty($history->month_realisasi)) {
            //     return;
            // }

            return $history;
            // return $history->rkap_forecast != 0 && $history->nilai_forecast != 0 && $history->realisasi_forecast != 0;
        })->where("divcode", "=", $unit_kerja)->sortBy('periode_prognosa')->groupBy("nama_proyek");
        // $tes = $history_forecasts->sum(function($his) {
        //     return (int) $his->realisasi_forecast;
        //     });
        // $history_forecasts = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("stage", "!=", 7)->join("dops", "dops.dop", "=", "proyeks.dop")->join("unit_kerjas", "unit_kerjas.divcode", "=", "proyeks.unit_kerja");
        // $history_forecasts = $history_forecasts->get()->groupBy("unit_kerja");
        return view("/12_Autorisasi_Detail", compact("history_forecasts", "periodeOtor", "jenisProyek", "unit_kerja"));
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

    Route::post("/input-risk/edit", [ContractManagementsController::class, "riskUpdate"]);

    Route::post("/laporan-bulanan/upload", [ContractManagementsController::class, "monthlyReportUpload"]);

    Route::post("/serah-terima/upload", [ContractManagementsController::class, "handOverUpload"]);

    Route::post("/klarifikasi-negosiasi/upload", [ContractManagementsController::class, "klarifikasiNegoUpload"]);

    Route::post("/kontrak-tanda-tangan/upload", [ContractManagementsController::class, "kontrakTandaTanganUpload"]);

    Route::post("/dokumen-pendukung/upload", [ContractManagementsController::class, "dokumenPendukungUpload"]);

    Route::post("/perjanjian-kso/upload", [ContractManagementsController::class, "perjanjianKSO"]);

    Route::post("/mom-meeting/upload", [ContractManagementsController::class, "momMeeting"]);

    Route::post("/perubahan-kontrak/upload", [ClaimController::class, "newClaim"]);

    Route::post("/perubahan-kontrak/edit", [ClaimController::class, "perubahanKontrakEdit"]);

    Route::post("/perubahan-kontrak/update", [ContractManagementsController::class, "uploadPerubahanKontrak"]);

    Route::post("/pasal-kontraktual/upload", [ContractManagementsController::class, "uploadPasalKontraktual"]);

    Route::post("/checklist-manajemen-kontrak/upload", [ContractManagementsController::class, "uploadChecklistKontrak"]);
    
    Route::post("/asuransi-pelaksanaan/upload", [ContractManagementsController::class, "uploadAsuransi"]);

    Route::post("/asuransi-pelaksanaan/edit", [ContractManagementsController::class, "editAsuransi"]);
    
    Route::post("/ld-law/upload", [ContractManagementsController::class, "ld_law"]);
    
    Route::post("/jaminan-pelaksanaan/upload", [ContractManagementsController::class, "uploadJaminan"]);

    Route::post("/jaminan-pelaksanaan/edit", [ContractManagementsController::class, "editJaminan"]);

    Route::post("/dokumen-site-instruction/upload", [ContractManagementsController::class, "siteInstruction"]);
    Route::post("/dokumen-site-instruction/{id}/delete", [ContractManagementsController::class, "deleteSiteInstruction"]);
    
    Route::post("/dokumen-technical-form/upload", [ContractManagementsController::class, "technicalForm"]);
    Route::post("/dokumen-technical-form/{id}/delete", [ContractManagementsController::class, "deleteTechnicalForm"]);
    
    Route::post("/dokumen-technical-query/upload", [ContractManagementsController::class, "technicalQuery"]);
    Route::post("/dokumen-technical-query/{id}/delete", [ContractManagementsController::class, "deleteTechnicalQuery"]);
    
    Route::post("/dokumen-field-design-change/upload", [ContractManagementsController::class, "fieldChange"]);
    Route::post("/dokumen-field-design-change/{id}", [ContractManagementsController::class, "deleteFieldChange"]);
    
    Route::post("/dokumen-contract-change-notice/upload", [ContractManagementsController::class, "changeNotice"]);
    Route::post("/dokumen-contract-change-notice/{id}/delete", [ContractManagementsController::class, "deleteChangeNotice"]);
    
    Route::post("/dokumen-contract-change-order/upload", [ContractManagementsController::class, "changeOrder"]);
    Route::post("/dokumen-contract-change-order/{id}/delete", [ContractManagementsController::class, "deleteChangeOrder"]);

    Route::post("/dokumen-contract-change-proposal/upload", [ContractManagementsController::class, "changeProposal"]);
    Route::post("/dokumen-contract-change-proposal/{id}/delete", [ContractManagementsController::class, "deleteChangeProposal"]);    
    
    Route::get("/document/view/{id}/{id_document}", [DocumentController::class, "documentView"]);

    Route::get("/document/view/{id}/{id_document}/history", [DocumentController::class, "documentViewHistory"]);

    Route::post('/pasal/clear', [PasalController::class, "pasalClear"]);

    Route::post("/document/view/{id}/{id_document}/save", [DocumentController::class, "documentSave"]);

    Route::post('/stage/save', [StageController::class, "stageSave"]);

    Route::post('/stage/addendum/save', [StageController::class, "stageAddendumSave"]);

    Route::post('/stage/perubahan-kontrak/save', [StageController::class, "stagePerubahanKontrakSave"]);

    Route::post('/pasal/save', [PasalController::class, "pasalSave"]);

    Route::post('/pasal/add', [PasalController::class, "pasalAdd"]);

    Route::post('/pasal/update', [PasalController::class, "pasalUpdate"]);

    Route::post('/pasal/import', [PasalController::class, "importPasal"]);

    // begin :: USERS
    Route::get('/user', function () {
        //Menggunakan metode Eager Loading agar memangkas loading query database 
        if (Auth::user()->check_administrator) {
            $users = User::with('UnitKerja')->get()->reverse();
        } else if (Auth::user()->check_user_sales && Auth::user()->role_admin) {
            $users = User::with('UnitKerja')->get()->reverse()->where("check_administrator", "!=", true);
        } else {
            $users = User::join("unit_kerjas", "unit_kerjas.divcode", "=", "users.unit_kerja")->where("unit_kerjas.divcode", "=", Auth::user()->unit_kerja)->get();
        }

        $pegawai_all = Pegawai::select(['id_pegawai', 'nip', 'nama_pegawai'])->get();
        return view("/MasterData/User", ["users" => $users, "unit_kerjas" => UnitKerja::all(), "pegawai_all" => $pegawai_all]);
        // return view("/MasterData/User", ["users" => User::all()->reverse()]);
    });
    // Route::get('/user', [UserController::class, 'index']);

    Route::get('/user/new', function () {
        return view("/User/newUser", ["unit_kerjas" => UnitKerja::all()]);
    });

    Route::post('/user/save', [UserController::class, "save"]);

    Route::post('/user/role/save',
        [UserController::class, "saveRole"]
    );
    
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

    //Begin :: Role Management
    Route::get('/role-management', [RoleManagementsController::class, 'index']);
    Route::post('/role-management/save', [RoleManagementsController::class, 'save']);
    Route::post('/role-management/update/{id}', [RoleManagementsController::class, 'edit']);
    Route::post('/role-management/delete/{id}', [RoleManagementsController::class, 'delete']);
    //End :: Role Management

    //Begin::Konsultan Perencana
    Route::get('/konsultan-perencana', [KonsultanPerencanaController::class, 'index']);
    Route::post('/konsultan-perencana/save', [KonsultanPerencanaController::class, 'store']);
    Route::get('/konsultan-perencana/{id}/show', [KonsultanPerencanaController::class, 'show']);
    Route::post('/konsultan-perencana/{id}/edit', [KonsultanPerencanaController::class, 'update']);
    Route::post('/konsultan-perencana/{id}/delete', [KonsultanPerencanaController::class, 'destroy']);
    //End::Konsultan Perencana

    //Begin::Checklist Calon Mitra KSO
    Route::get('/checklist-calon-mitra-kso', function (Request $request) {
        return view('MasterData/ChecklistCalonMitraKSO', ['data' => ChecklistCalonMitraKSO::all()]);
    });
    Route::post('/checklist-calon-mitra-kso/save', function (Request $request) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "aspek" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Checklist Calon Mitra KSO Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();

        $checklist = new ChecklistCalonMitraKSO();
        $checklist->aspek = $data['aspek'];
        $checklist->start_tahun = $data["tahun_start"];
        $checklist->start_bulan = $data["bulan_start"];
        $checklist->posisi = $data["posisi"];
        $checklist->opsi = $data["opsi"];
        $checklist->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $checklist->finish_tahun = $data["tahun_finish"];
            $checklist->finish_bulan = $data["bulan_finish"];
        }
        if (isset($data['kategori'])) {
            $checklist->kategori = $data['kategori'];
        }

        $checklist->isi = $data['isi'];

        if ($checklist->save()) {
            Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Checklist Calon Mitra KSO Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/checklist-calon-mitra-kso/{id}/edit', function (Request $request, $id) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "aspek" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Checklist Calon Mitra KSO Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();

        $checklist = ChecklistCalonMitraKSO::find($id);

        if (empty($checklist)) {
            Alert::success("Error", "Checklist Calon Mitra KSO Tidak Ditemukan");
            return redirect()->back();
        }

        $checklist->aspek = $data['aspek'];
        $checklist->start_tahun = $data["tahun_start"];
        $checklist->start_bulan = $data["bulan_start"];
        $checklist->posisi = $data["posisi"];
        $checklist->opsi = $data["opsi"];
        $checklist->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $checklist->finish_tahun = $data["tahun_finish"];
            $checklist->finish_bulan = $data["bulan_finish"];
        }
        if (isset($data['kategori'])) {
            $checklist->kategori = $data['kategori'];
        }

        $checklist->isi = $data['isi'];

        if ($checklist->save()) {
            Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Checklist Calon Mitra KSO Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/checklist-calon-mitra-kso/{checklist}/delete', function (ChecklistCalonMitraKSO $checklist) {
        if (empty($checklist)) {
            Alert::success("Error", "Checklist Calon Mitra KSO Tidak Ditemukan");
            return redirect()->back();
        }

        if ($checklist->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });
    //End::Checklist Calon Mitra KSO

    //Begin::Master Fortune Rank
    Route::get('/master-fortune-rank', function (Request $request) {
        return view('MasterData/FortuneRank', ['customer' => Customer::all(), 'data' => MasterFortuneRank::all()]);
    });
    Route::post('/master-fortune-rank/save', function (Request $request) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
            "nama_pelanggan" => 'required|string',
            "urutan" => 'required|integer|min:1|max:100',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("urutan")) {
                Alert::error(
                    'Error',
                    "Urutan diisi nilai 1 - 100. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "Fortune Rank gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();

        $pelanggan = Customer::find($data['nama_pelanggan']);

        $fortune = new MasterFortuneRank();
        $fortune->id_pelanggan = $pelanggan->id_customer;
        $fortune->nama_pelanggan = $pelanggan->name;
        $fortune->urutan = (int)$data["urutan"];
        $fortune->bulan = $data["bulan"];
        $fortune->tahun = $data["tahun"];

        if ((int) $data["urutan"] > 100) {
            $pelanggan->forbes_rank = "Diluar Top 100";
        } elseif ((int)$data["urutan"] <= 100 && (int)$data["urutan"] > 50) {
            $pelanggan->forbes_rank = "Urutan 51-100";
        } else {
            $pelanggan->forbes_rank = "Urutan 1-50";
        }

        if ($fortune->save() && $pelanggan->save()) {
            Alert::success('Success', "Fortune Rank Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Fortune Rank Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-fortune-rank/{id}/edit', function (Request $request, $id) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
                "urutan" => 'required|integer|min:1',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("urutan")) {
                Alert::error(
                    'Error',
                    "Urutan diisi minimal nilai 1. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "Fortune Rank gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();

        $pelanggan = Customer::find($data['nama_pelanggan']);

        $fortune = MasterFortuneRank::find($id);
        $fortune->id_pelanggan = $pelanggan->id_customer;
        $fortune->nama_pelanggan = $pelanggan->name;
        $fortune->urutan = (int)$data["urutan"];
        $fortune->bulan = $data["bulan"];
        $fortune->tahun = $data["tahun"];

        if ((int) $data["urutan"] > 100) {
            $pelanggan->forbes_rank = "Diluar Top 100";
        } elseif ((int)$data["urutan"] <= 100 && (int)$data["urutan"] > 50) {
            $pelanggan->forbes_rank = "Urutan 51-100";
        } else {
            $pelanggan->forbes_rank = "Urutan 1-50";
        }

        if ($fortune->save() && $pelanggan->save()) {
            Alert::success('Success', "Fortune Rank Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Fortune Rank Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/master-fortune-rank/{fortune}/delete', function (MasterFortuneRank $fortune) {
        if (empty($fortune)) {
            Alert::success("Error", "Fortune Rank Tidak Ditemukan");
            return redirect()->back();
        }

        if ($fortune->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });
    //End::Master Fortune Rank

    //Begin::Master LQ Rank
    Route::get('/master-lq-rank', function (Request $request) {
        return view('MasterData/LQRank', ['customer' => Customer::all(), 'data' => MasterLQRank::all()]);
    });
    Route::post('/master-lq-rank/save', function (Request $request) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
                "urutan" => 'required|integer|min:1',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("urutan")) {
                Alert::error(
                    'Error',
                    "Urutan diisi nilai minimal 1. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "LQ Rank gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();
        // dd($data);
        $pelanggan = Customer::find($data['nama_pelanggan']);

        $lqRank = new MasterLQRank();
        $lqRank->id_pelanggan = $pelanggan->id_customer;
        $lqRank->nama_pelanggan = $pelanggan->name;
        $lqRank->urutan = (int)$data["urutan"];
        $lqRank->bulan = $data["bulan"];
        $lqRank->tahun = $data["tahun"];

        if ((int) $data["urutan"] > 45) {
            $pelanggan->lq_rank = "Diluar Top 45";
        } elseif ((int)$data["urutan"] <= 45 && (int)$data["urutan"] > 20) {
            $pelanggan->lq_rank = "Urutan 21-45";
        } else {
            $pelanggan->lq_rank = "Urutan 1-20";
        }

        if ($lqRank->save() && $pelanggan->save()) {
            Alert::success('Success', "LQ Rank Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "LQ Rank Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-lq-rank/{id}/edit', function (Request $request, $id) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
                "urutan" => 'required|integer|min:1',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("urutan")) {
                Alert::error(
                    'Error',
                    "Urutan diisi nilai 1 - 100. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "Fortune Rank gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();
        // dd($data);
        $pelanggan = Customer::find($data['nama_pelanggan']);
        $lq = MasterLQRank::find($id);
        $lq->nama_pelanggan = $pelanggan->id_customer;
        $lq->nama_pelanggan = $pelanggan->name;
        $lq->urutan = (int)$data["urutan"];
        $lq->bulan = $data["bulan"];
        $lq->tahun = $data["tahun"];

        if ((int) $data["urutan"] > 45) {
            $pelanggan->lq_rank = "Diluar Top 45";
        } elseif ((int)$data["urutan"] <= 45 && (int)$data["urutan"] > 20) {
            $pelanggan->lq_rank = "Urutan 21-45";
        } else {
            $pelanggan->lq_rank = "Urutan 1-20";
        }

        if ($lq->save() && $pelanggan->save()) {
            Alert::success('Success', "LQ Rank Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "LQ Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/master-lq-rank/{lq}/delete', function (MasterLQRank $lq) {
        if (empty($lq)) {
            Alert::success("Error", "LQ Rank Tidak Ditemukan");
            return redirect()->back();
        }

        if ($lq->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });
    //End::Master LQ Rank

    //Begin::Master LQ Rank
    Route::get('/master-pefindo', function (Request $request) {
        $listMasterPefindo = MasterPefindo::all();
        $updateMasterPefindo = $listMasterPefindo
            ->filter(function ($item) {
                return ($item->bulan_start - date('m') < 6) && $item->tahun_start == date('Y');
            })->map(function ($item) {
                $collectItem = [];
                $collectItem["id"] = $item->id;
                $collectItem["is_active"] = false;
                return $collectItem;
            })->toArray();

        foreach ($updateMasterPefindo as $key => $item) {
            MasterPefindo::where('id', $item['id'])->update($updateMasterPefindo[$key]);
        }

        return view('MasterData/MasterPefindo', ['customer' => Customer::all(), 'data' => $listMasterPefindo]);
    });
    Route::post('/master-pefindo/save', function (Request $request) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
            "nama_pelanggan" => 'required|string',
            "score" => 'required|integer|min:1',
            "file" => 'file|mimes:pdf',
            "bulan" => 'required',
            "tahun" => 'required'
        ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            // dd($error);
            if ($error->has("score")) {
                Alert::error(
                    'Error',
                    "Score diisi nilai minimal 1. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("file")) {
                Alert::error(
                    'Error',
                    "Upload file format PDF. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "Pefindo gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();
        $file = $request->file("file");
        $id_document = date("His_") . str_replace(' ', '_', $file->getClientOriginalName());
        $pelanggan = Customer::find($data['nama_pelanggan']);
        $pefindo = new MasterPefindo();
        $pefindo->id_pelanggan = $pelanggan->id_customer;
        $pefindo->bulan_start = $data['bulan'];
        $pefindo->tahun_start = $data['tahun'];
        $pefindo->is_active = isset($data['isActive']) && ((int)$data['bulan'] - date('m') < 6) ? false : true;
        $pefindo->nama_pelanggan = $pelanggan->name;
        $pefindo->score = (int)$data["score"];
        $pefindo->id_document = $id_document;

        $kriteria_penilaian = KriteriaPenilaianPefindo::all()
        ->filter(function ($item) use ($data) {
            return $item->dari_nilai <= (int)$data["score"] && $item->sampai_nilai > (int)$data["score"];
        })
        ->first();

        $pefindo->grade = $kriteria_penilaian->grade;
        $pefindo->keterangan = $kriteria_penilaian->nama;

        if ($pefindo->save()) {
            $file->move(public_path('pefindo'), $id_document);
            Alert::success('Success', "Pefindo Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Pefindo Gagal Ditambahkan");
        return redirect()->back();
    });
    // Route::post('/master-pefindo/{id}/edit', function (Request $request, $id) {
    //     $data = $request->all();
    //     $messages = [
    //         "required" => "Field di atas wajib diisi",
    //     ];
    //     $rules = [
    //             "nama_pelanggan" => 'required|string',
    //             "urutan" => 'required|integer|min:1',
    //         ];
    //     $validation = Validator::make(
    //         $data,
    //         $rules,
    //         $messages
    //     );

    //     if ($validation->fails()) {
    //         $error = collect($validation->errors());
    //         if ($error->has("urutan")) {
    //             Alert::error(
    //                 'Error',
    //                 "Urutan diisi nilai 1 - 100. Periksa Kembali!"
    //             );
    //             return redirect()->back();
    //         } elseif ($error->has("nama_pelanggan")) {
    //             Alert::error(
    //                 'Error',
    //                 "Nama Pelanggan wajib diisi. Periksa Kembali!"
    //             );
    //             return redirect()->back();
    //         } else {
    //             Alert::error(
    //                 'Error',
    //                 "Fortune Rank gagal ditambahkan. Periksa Kembali!"
    //             );
    //             return redirect()->back();
    //         }
    //     }

    //     $validation->validate();
    //     // dd($data);
    //     $lq = MasterPefindo::find($id);
    //     $lq->nama_pelanggan = $data['nama_pelanggan'];
    //     $lq->urutan = (int)$data["urutan"];
    //     $lq->bulan = $data["bulan"];
    //     $lq->tahun = $data["tahun"];

    //     if ($lq->save()) {
    //         Alert::success('Success', "LQ Rank Berhasil Diubah");
    //         return redirect()->back();
    //     }
    //     Alert::error('Error', "LQ Gagal Diubah");
    //     return redirect()->back();
    // });
    Route::post('/master-pefindo/{pefindo}/delete', function (MasterPefindo $pefindo) {
        if (empty($pefindo)) {
            Alert::success("Error", "LQ Rank Tidak Ditemukan");
            return redirect()->back();
        }
        $nama_file = $pefindo->id_document;
        if ($pefindo->delete()) {
            File::delete(public_path("pefindo/$nama_file"));
            return response()->json([
                "Success" => true,
                "Message" => "Data Berhasil Dihapus"
            ]);
        }

        return response()->json([
            "Success" => false,
            "Message" => "Data Berhasil Dihapus"
        ]);
    });
    //End::Master Pefindo

    //Begin::Master Group Tier
    Route::get('/master-group-tier', function (Request $request) {
        $customer = Customer::select(['id_customer', 'name', 'jenis_instansi'])->where('jenis_instansi', 'BUMN')->get();
        return view('MasterData/MasterGroupTierBUMN', ['customer' => $customer, 'data' => MasterGrupTierBUMN::all()]);
    });
    Route::post('/master-group-tier/save', function (Request $request) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
                "kategori" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("kategori")) {
                Alert::error(
                    'Error',
                    "Kategori wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "LQ Rank gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();
        // dd($data);
        $pelanggan = Customer::find($data['nama_pelanggan']);

        $groupTier = new MasterGrupTierBUMN();
        $groupTier->id_pelanggan = $pelanggan->id_customer;
        $groupTier->nama_pelanggan = $pelanggan->name;
        $groupTier->kategori = $data["kategori"];

        if ($groupTier->save()) {
            Alert::success('Success', "Group Tier BUMN Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Group Tier BUMN Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-group-tier/{id}/edit', function (Request $request, $id) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
                "kategori" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("kategori")) {
                Alert::error(
                    'Error',
                    "Kategori wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_pelanggan")) {
                Alert::error(
                    'Error',
                    "Nama Pelanggan wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } else {
                Alert::error(
                    'Error',
                    "Fortune Rank gagal ditambahkan. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();
        // dd($data);
        $pelanggan = Customer::find($data['nama_pelanggan']);
        $groupTier = MasterGrupTierBUMN::find($id);
        $groupTier->nama_pelanggan = $pelanggan->id_customer;
        $groupTier->nama_pelanggan = $pelanggan->name;
        $groupTier->kategori = $data["kategori"];

        if ($groupTier->save()) {
            Alert::success('Success', "Group Tier BUMN Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Group Tier BUMN Diubah");
        return redirect()->back();
    });
    Route::post('/master-group-tier/{tier}/delete', function (MasterGrupTierBUMN $tier) {
        if (empty($tier)) {
            Alert::success("Error", "Group Tier BUMN Tidak Ditemukan");
            return redirect()->back();
        }

        if ($tier->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => "Group Tier BUMN Berhasil Dihapus"
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => "Group Tier BUMN Gagal Dihapus"
        ]);
    });
    //End::Master Group Tier

    //Begin::Master Alat Proyek
    Route::get('/master-alat-proyek', function (Request $request) {
        return view('MasterData/MasterAlatProyek', ['data' => MasterAlatProyek::all()]);
    });
    Route::post('/master-alat-proyek/save', function (Request $request) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nomor_rangka" => 'required|string',
                "nama_alat" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("nomor_rangka")) {
                Alert::error(
                    'Error',
                    "Nomor Rangka wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_alat")) {
                Alert::error(
                    'Error',
                    "Nama Alat wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();

        $dataNew = new MasterAlatProyek();
        $dataNew->nomor_rangka = $data['nomor_rangka'];
        $dataNew->nama_alat = $data['nama_alat'];
        $dataNew->spesifikasi = $data['spesifikasi'];
        $dataNew->kategori = $data['kategori'];

        if ($dataNew->save()) {
            Alert::success('Success', "Master Alat Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Master Alat Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-alat-proyek/{id}/edit', function (Request $request, $id) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nomor_rangka" => 'required|string',
                "nama_alat" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            $error = collect($validation->errors());
            if ($error->has("nomor_rangka")) {
                Alert::error(
                    'Error',
                    "Nomor Rangka wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            } elseif ($error->has("nama_alat")) {
                Alert::error(
                    'Error',
                    "Nama Alat wajib diisi. Periksa Kembali!"
                );
                return redirect()->back();
            }
        }

        $validation->validate();
        $dataNew = MasterAlatProyek::find($id);
        $dataNew->nomor_rangka = $data['nomor_rangka'];
        $dataNew->nama_alat = $data['nama_alat'];
        $dataNew->spesifikasi = $data['spesifikasi'];
        $dataNew->kategori = $data['kategori'];

        if ($dataNew->save()) {
            Alert::success('Success', "Master Alat Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Master Alat Diubah");
        return redirect()->back();
    });
    Route::post('/master-alat-proyek/{alat}/delete', function (MasterAlatProyek $alat) {
        if (empty($alat)) {
            Alert::success("Error", "Master Alat Tidak Ditemukan");
            return redirect()->back();
        }

        if ($alat->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => "Master Alat Berhasil Dihapus"
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => "Master Alat Gagal Dihapus"
        ]);
    });
    //End::Master Alat Proyek

    //Begin::Kriteria Green Lane Partner
    Route::get('/kriteria-greenlane-partner', function (Request $request) {
        return view('MasterData/KriteriaGreenlanePartner', ['customer' => Customer::all(), 'data' => MasterKriteriaGreenlanePartner::all()]);
    });
    Route::post('/kriteria-greenlane-partner/save', function (Request $request) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Kriteria Green Lane Partner Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();
        $pelanggan = Customer::find($data['nama_pelanggan']);
        $kriteria = new MasterKriteriaGreenlanePartner();
        $kriteria->id_pelanggan = $pelanggan->id_customer;
        $kriteria->nama_pelanggan = $pelanggan->name;
        $kriteria->start_tahun = $data["tahun_start"];
        $kriteria->start_bulan = $data["bulan_start"];
        $kriteria->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $kriteria->finish_tahun = $data["tahun_finish"];
            $kriteria->finish_bulan = $data["bulan_finish"];
        }

        if ($kriteria->save()) {
            Alert::success('Success', "Kriteria Green Lane Partner Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Green Lane Partner Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/kriteria-greenlane-partner/{id}/edit', function (Request $request, $id) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama_pelanggan" => 'required|string',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Kriteria Green Lane Partner Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();

        $kriteria = MasterKriteriaGreenlanePartner::find($id);

        if (empty($kriteria)) {
            Alert::success("Error", "Kriteria Green Lane Partner Tidak Ditemukan");
            return redirect()->back();
        }

        $pelanggan = Customer::find($data['nama_pelanggan']);

        $kriteria->id_pelanggan = $pelanggan->id_customer;
        $kriteria->nama_pelanggan = $pelanggan->name;
        $kriteria->start_tahun = $data["tahun_start"];
        $kriteria->start_bulan = $data["bulan_start"];
        $kriteria->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $kriteria->finish_tahun = $data["tahun_finish"];
            $kriteria->finish_bulan = $data["bulan_finish"];
        }

        if ($kriteria->save()) {
            Alert::success('Success', "Kriteria Green Lane Partner Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Green Lane Partner Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/kriteria-greenlane-partner/{kriteria}/delete', function (MasterKriteriaGreenlanePartner $kriteria) {
        if (empty($kriteria)) {
            Alert::success("Error", "Kriteria Green Lane Partner Tidak Ditemukan");
            return redirect()->back();
        }

        if ($kriteria->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });
    //End::Kriteria Green Lane Partner

    //Begin::Master Catatan Rekomendasi
    Route::get('/master-catatan-rekomendasi', function (Request $request) {
        return view('MasterData/MasterCatatanNotaRekomendasi2', ['data' => MasterCatatanNotaRekomendasi2::all()]);
    });
    Route::post('/master-catatan-rekomendasi/save', function (Request $request) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "kategori" => 'required|string',
            ];
        $validation = Validator::make(
                $data,
                $rules,
                $messages
            );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Master Catatan Rekomendasi Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();
        $masterCatatan = new MasterCatatanNotaRekomendasi2();
        $masterCatatan->kategori = $data["kategori"];
        $masterCatatan->urutan = $data["urutan"];
        $masterCatatan->start_tahun = $data["tahun_start"];
        $masterCatatan->start_bulan = $data["bulan_start"];
        $masterCatatan->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $masterCatatan->finish_tahun = $data["tahun_finish"];
            $masterCatatan->finish_bulan = $data["bulan_finish"];
        }

        if ($masterCatatan->save()) {
            Alert::success('Success', "Master Catatan Rekomendasi Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Master Catatan Rekomendasi Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/master-catatan-rekomendasi/update/{id}', function (Request $request, $id) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "kategori" => 'required|string',
            ];
        $validation = Validator::make(
                $data,
                $rules,
                $messages
            );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Master Catatan Rekomendasi Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();

        $masterCatatan = MasterCatatanNotaRekomendasi2::find($id);

        if (empty($masterCatatan)) {
            Alert::success("Error", "Master Catatan Rekomendasi Tidak Ditemukan");
            return redirect()->back();
        }

        // $pelanggan = Customer::find($data['nama_pelanggan']);

        $masterCatatan->kategori = $data["kategori"];
        $masterCatatan->urutan = $data["urutan"];
        $masterCatatan->start_tahun = $data["tahun_start"];
        $masterCatatan->start_bulan = $data["bulan_start"];
        $masterCatatan->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $masterCatatan->finish_tahun = $data["tahun_finish"];
            $masterCatatan->finish_bulan = $data["bulan_finish"];
        }

        if ($masterCatatan->save()) {
            Alert::success('Success', "Master Catatan Rekomendasi Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Master Catatan Rekomendasi Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/master-catatan-rekomendasi/{kriteria}/delete', function (MasterCatatanNotaRekomendasi2 $masterCatatan) {
        if (empty($masterCatatan)) {
            Alert::success("Error", "Master Catatan Rekomendasi Tidak Ditemukan");
            return redirect()->back();
        }

        if ($masterCatatan->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });
    //End::Master Catatan Rekomendasi

    //Begin::Kriteria Penilaian Pefindo
    Route::get('/kriteria-penilaian-pefindo', function (Request $request) {
        return view('MasterData/KriteriaPenilaianPefindo', ['data' => KriteriaPenilaianPefindo::all()]);
    });
    Route::post('/kriteria-penilaian-pefindo/save', function (Request $request) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama" => 'required|string',
                "grade" => 'required|string',
                "dari_nilai" => 'required|integer',
                "sampai_nilai" => 'required|integer',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Kriteria Penilaian Pefindo Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();
        $kriteria = new KriteriaPenilaianPefindo();
        $kriteria->nama = $data["nama"];
        $kriteria->grade = ucfirst($data["grade"]);
        $kriteria->dari_nilai = (int)$data["dari_nilai"];
        $kriteria->sampai_nilai = (int)$data["sampai_nilai"];
        $kriteria->probability_of_default = $data["probability_of_default"];
        $kriteria->start_tahun = $data["tahun_start"];
        $kriteria->start_bulan = $data["bulan_start"];
        $kriteria->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $kriteria->finish_tahun = $data["tahun_finish"];
            $kriteria->finish_bulan = $data["bulan_finish"];
        }

        if ($kriteria->save()) {
            Alert::success('Success', "Kriteria Penilaian Pefindo Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Penilaian Pefindo Gagal Ditambahkan");
        return redirect()->back();
    });
    Route::post('/kriteria-penilaian-pefindo/{id}/edit', function (Request $request, $id) {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
        ];
        $rules = [
                "nama" => 'required|string',
                "grade" => 'required|string',
                "dari_nilai" => 'required|integer',
                "sampai_nilai" => 'required|integer',
            ];
        $validation = Validator::make(
            $data,
            $rules,
            $messages
        );

        if ($validation->fails()) {
            Alert::error(
                'Error',
                "Kriteria Penilaian Pefindo Gagal Ditambahkan. Periksa Kembali!"
            );
            return redirect()->back();
        }

        $validation->validate();

        $kriteria = KriteriaPenilaianPefindo::find($id);

        if (empty($kriteria)) {
            Alert::success(
                "Error",
                "Kriteria Penilaian Pefindo Tidak Ditemukan"
            );
            return redirect()->back();
        }

        $kriteria->nama = $data["nama"];
        $kriteria->grade = ucfirst($data["grade"]);
        $kriteria->dari_nilai = (int)$data["dari_nilai"];
        $kriteria->sampai_nilai = (int)$data["sampai_nilai"];
        $kriteria->probability_of_default = $data["probability_of_default"];
        $kriteria->start_tahun = $data["tahun_start"];
        $kriteria->start_bulan = $data["bulan_start"];
        $kriteria->is_active = isset($data["isActive"]) ? true : false;
        if (isset($data["tahun_finish"]) && isset($data["bulan_finish"])) {
            $kriteria->finish_tahun = $data["tahun_finish"];
            $kriteria->finish_bulan = $data["bulan_finish"];
        }

        if ($kriteria->save()) {
            Alert::success('Success', "Kriteria Penilaian Pefindo Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Kriteria Penilaian Pefindo Gagal Diubah");
        return redirect()->back();
    });
    Route::post('/kriteria-penilaian-pefindo/{kriteria}/delete', function (KriteriaPenilaianPefindo $kriteria) {
        if (empty($kriteria)) {
            Alert::success("Error", "Kriteria Penilaian Pefindo Tidak Ditemukan");
            return redirect()->back();
        }

        if ($kriteria->delete()) {
            // Alert::success('Success', "Checklist Calon Mitra KSO Berhasil Dihapus");
            // return redirect()->back();

            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        // Alert::error('Error', "Checklist Calon Mitra KSO Gagal Dihapus");
        // return redirect()->back();
        return response()->json([
            "Success" => false,
            "Message" => null
        ]);
    });
    //End::Kriteria Penilaian Pefindo

    // begin RKAP
    Route::get('/rkap', function (Request $request) {

        $filterTahun = $request->query("tahun-proyek") ?? (int) date("Y");

        if (
            $filterTahun != (int)date("Y")
        ) {
            $proyeks = Proyek::where('is_rkap', true)->where('tahun_perolehan', $filterTahun)->get();
        } else {
            $proyeks = Proyek::where('is_rkap', true)->where('tahun_perolehan', (int)date('Y'))->get();
        }

        dd($proyeks);

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if (Auth::user()->check_administrator) {
            $unitkerjas = Proyek::sortable()->where("is_rkap", "=", true)->get()->groupBy("unit_kerja");
        } else {
            $unitkerjas = Proyek::sortable()->where("is_rkap", "=", true)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy("unit_kerja");
        }


        // dd();

        return view("/11_Rkap", compact(["unitkerjas", "proyeks"]));
    });

    Route::get('/rkap/{divcode}/{tahun_pelaksanaan}', function ($divcode, $tahun_pelaksanaan, Request $request) {
        $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_pelaksanaan)->where("is_rkap", "=", true)->where("unit_kerja", "=", $divcode)->get();
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

    //Begin :: Integrasi Get Proyek PIS
    Route::get('/get-progress-pis/all', function () {
        $login = Http::post('https://nasabah-dev.wika.co.id/services/auth', [
            "entitas" => "CRM",
            "skey" => "OAZvRmB7HKDdDkKF29DXZwgSmlv9KqQWZNDWV51SAAAb3nOvuA1AvZf5FnIBrLxC"
        ]);
        // dd($login);
        if ($login->successful()) {
            // $login_response = $login->header("w-key");
            // dd($login_response);
            $token = $login->header('w-key') ?? null;

            if (!empty($token)) {
                $response = Http::withHeaders(["w-access-token" => $token])
                    ->get('https://nasabah-dev.wika.co.id/services/getproyek');
                if ($response->successful()) {
                    $data = $response->collect($key = 'data');
                    if (!empty($data)) {
                        try {
                            $data_mapping = $data->map(function ($proyek) {
                                $proyekModel = new ProyekPISNew();
                                $proyekModel->proyek_id = is_array($proyek["proyek_id"]) && empty($proyek["proyek_id"]) ? null : $proyek["proyek_id"];
                                $proyekModel->proyek_name = is_array($proyek["proyek_name"]) && empty($proyek["proyek_name"]) ? null : $proyek["proyek_name"];
                                $proyekModel->proyek_shortname = is_array($proyek["proyek_shortname"]) && empty($proyek["proyek_shortname"]) ? null : $proyek["proyek_shortname"];
                                $proyekModel->contract_no = is_array($proyek["contract_no"]) && empty($proyek["contract_no"]) ? null : $proyek["contract_no"];
                                $proyekModel->contract_date = is_array($proyek["contract_date"]) && empty($proyek["contract_date"]) ? null : $proyek["contract_date"];
                                $proyekModel->type_code = is_array($proyek["type_code"]) && empty($proyek["type_code"]) ? null : $proyek["type_code"];
                                $proyekModel->status_id = is_array($proyek["status_id"]) && empty($proyek["status_id"]) ? null : $proyek["status_id"];
                                $proyekModel->spk_extern_no = is_array($proyek["spk_extern_no"]) && empty($proyek["spk_extern_no"]) ? null : $proyek["spk_extern_no"];
                                $proyekModel->spk_extern_date = is_array($proyek["spk_extern_date"]) && empty($proyek["spk_extern_date"]) ? null : $proyek["spk_extern_date"];
                                $proyekModel->spk_intern_no = is_array($proyek["spk_intern_no"]) && empty($proyek["spk_intern_no"]) ? null : $proyek["spk_intern_no"];
                                $proyekModel->spk_intern_date = is_array($proyek["spk_intern_date"]) && empty($proyek["spk_intern_date"]) ? null : $proyek["spk_intern_date"];
                                $proyekModel->sbu_id = is_array($proyek["sbu_id"]) && empty($proyek["sbu_id"]) ? null : $proyek["sbu_id"];
                                $proyekModel->currency_code = is_array($proyek["currency_code"]) && empty($proyek["currency_code"]) ? null : $proyek["currency_code"];
                                $proyekModel->currency_rate = is_array($proyek["currency_rate"]) && empty($proyek["currency_rate"]) ? null : $proyek["currency_rate"];
                                $proyekModel->contract_value_idr = is_array($proyek["contract_value_idr"]) && empty($proyek["contract_value_idr"]) ? null : $proyek["contract_value_idr"];
                                $proyekModel->contract_value_valas = is_array($proyek["contract_value_valas"]) && empty($proyek["contract_value_valas"]) ? null : $proyek["contract_value_valas"];
                                $proyekModel->job_type = is_array($proyek["job_type"]) && empty($proyek["job_type"]) ? null : $proyek["job_type"];
                                $proyekModel->address = is_array($proyek["address"]) && empty($proyek["address"]) ? null : $proyek["address"];
                                $proyekModel->country_id = is_array($proyek["country_id"]) && empty($proyek["country_id"]) ? null : $proyek["country_id"];
                                $proyekModel->province_id = is_array($proyek["province_id"]) && empty($proyek["province_id"]) ? null : $proyek["province_id"];
                                $proyekModel->longitude = is_array($proyek["longitude"]) && empty($proyek["longitude"]) ? null : $proyek["longitude"];
                                $proyekModel->latitude = is_array($proyek["latitude"]) && empty($proyek["latitude"]) ? null : $proyek["latitude"];
                                $proyekModel->sumber_dana_id = is_array($proyek["sumber_dana_id"]) && empty($proyek["sumber_dana_id"]) ? null : $proyek["sumber_dana_id"];
                                $proyekModel->created_by = is_array($proyek["created_by"]) && empty($proyek["created_by"]) ? null : $proyek["created_by"];
                                $proyekModel->creation_time = is_array($proyek["creation_time"]) && empty($proyek["creation_time"]) ? null : $proyek["creation_time"];
                                $proyekModel->last_updated_by = is_array($proyek["last_updated_by"]) && empty($proyek["last_updated_by"]) ? null : $proyek["last_updated_by"];
                                $proyekModel->last_update_time = is_array($proyek["last_update_time"]) && empty($proyek["last_update_time"]) ? null : $proyek["last_update_time"];
                                $proyekModel->mp_name = is_array($proyek["mp_name"]) && empty($proyek["mp_name"]) ? null : $proyek["mp_name"];
                                $proyekModel->mp_nip = is_array($proyek["mp_nip"]) && empty($proyek["mp_nip"]) ? null : $proyek["mp_nip"];
                                $proyekModel->mp_phone = is_array($proyek["mp_phone"]) && empty($proyek["mp_phone"]) ? null : $proyek["mp_phone"];
                                $proyekModel->mp_email = is_array($proyek["mp_email"]) && empty($proyek["mp_email"]) ? null : $proyek["mp_email"];
                                $proyekModel->pemberi_kerja_code = is_array($proyek["pemberi_kerja_code"]) && empty($proyek["pemberi_kerja_code"]) ? null : $proyek["pemberi_kerja_code"];
                                $proyekModel->pemberi_kerja_name = is_array($proyek["pemberi_kerja_name"]) && empty($proyek["pemberi_kerja_name"]) ? null : $proyek["pemberi_kerja_name"];
                                $proyekModel->pemberi_kerja_intern = is_array($proyek["pemberi_kerja_intern"]) && empty($proyek["pemberi_kerja_intern"]) ? null : $proyek['pemberi_kerja_intern'];
                                $proyekModel->scorecard_type = is_array($proyek["scorecard_type"]) && empty($proyek["scorecard_type"]) ? null : $proyek["scorecard_type"];
                                $proyekModel->entitas_proyek = is_array($proyek["entitas_proyek"]) && empty($proyek["entitas_proyek"]) ? null : $proyek["entitas_proyek"];
                                $proyekModel->is_proyek_pelaporan = is_array($proyek["is_proyek_pelaporan"]) && empty($proyek["is_proyek_pelaporan"]) ? null : $proyek["is_proyek_pelaporan"];
                                $proyekModel->use_pmcs = is_array($proyek["use_pmcs"]) && empty($proyek["use_pmcs"]) ? null : $proyek["use_pmcs"];
                                $proyekModel->start_date = is_array($proyek["start_date"]) && empty($proyek["start_date"]) ? null : $proyek["start_date"];
                                $proyekModel->finish_date = is_array($proyek["finish_date"]) && empty($proyek["finish_date"]) ? null : $proyek["finish_date"];
                                $proyekModel->duration = is_array($proyek["duration"]) && empty($proyek["duration"]) ? null : $proyek["duration"];
                                $proyekModel->extended_duration = is_array($proyek["extended_duration"]) && empty($proyek["extended_duration"]) ? null : $proyek["extended_duration"];
                                $proyekModel->maintenance_duration = is_array($proyek["maintenance_duration"]) && empty($proyek["maintenance_duration"]) ? null : $proyek["maintenance_duration"];
                                $proyekModel->bast1_date = is_array($proyek["bast1_date"]) && empty($proyek["bast1_date"]) ? null : $proyek["bast1_date"];
                                $proyekModel->bast2_date = is_array($proyek["bast2_date"]) && empty($proyek["bast2_date"]) ? null : $proyek["bast2_date"];
                                $proyekModel->bast_final_date = is_array($proyek["bast_final_date"]) && empty($proyek["bast_final_date"]) ? null : $proyek["bast_final_date"];
                                $proyekModel->tot_pegawai_organik = is_array($proyek["tot_pegawai_organik"]) && empty($proyek["tot_pegawai_organik"]) ? null : $proyek["tot_pegawai_organik"];
                                $proyekModel->tot_pegawai_terampil = is_array($proyek["tot_pegawai_terampil"]) && empty($proyek["tot_pegawai_terampil"]) ? null : $proyek["tot_pegawai_terampil"];
                                $proyekModel->tot_pegawai_os_trainer = is_array($proyek["tot_pegawai_os_trainer"]) && empty($proyek["tot_pegawai_os_trainer"]) ? null : $proyek["tot_pegawai_os_trainer"];
                                $proyekModel->tot_pegawai_kkwt = is_array($proyek["tot_pegawai_kkwt"]) && empty($proyek["tot_pegawai_kkwt"]) ? null : $proyek["tot_pegawai_kkwt"];
                                $proyekModel->jo_type = is_array($proyek["jo_type"]) && empty($proyek["jo_type"]) ? null : $proyek["jo_type"];
                                $proyekModel->jo_creation_no = is_array($proyek["jo_creation_no"]) && empty($proyek["jo_creation_no"]) ? null : $proyek["jo_creation_no"];
                                $proyekModel->jo_creation_date = is_array($proyek["jo_creation_date"]) && empty($proyek["jo_creation_date"]) ? null : $proyek["jo_creation_date"];
                                $proyekModel->jo_mou_no = is_array($proyek["jo_mou_no"]) && empty($proyek["jo_mou_no"]) ? null : $proyek["jo_mou_no"];
                                $proyekModel->jo_mou_date = is_array($proyek["jo_mou_date"]) && empty($proyek["jo_mou_date"]) ? null : $proyek["jo_mou_date"];
                                $proyekModel->jo_npwp = is_array($proyek["jo_npwp"]) && empty($proyek["jo_npwp"]) ? null : $proyek["jo_npwp"];
                                $proyekModel->crm_proyek_id = is_array($proyek["crm_proyek_id"]) && empty($proyek["crm_proyek_id"]) ? null : $proyek["crm_proyek_id"];
                                $proyekModel->kategori_proyek = is_array($proyek["kategori_proyek"]) && empty($proyek["kategori_proyek"]) ? null : $proyek["kategori_proyek"];
                                $proyekModel->ra_progress = is_array($proyek["ra_progress"]) && empty($proyek["ra_progress"]) ? null : $proyek["ra_progress"];
                                $proyekModel->progress_lock_status = is_array($proyek["progress_lock_status"]) && empty($proyek["progress_lock_status"]) ? null : $proyek["progress_lock_status"];
                                $proyekModel->is_strategis_nas = is_array($proyek["is_strategis_nas"]) && empty($proyek["is_strategis_nas"]) ? null : $proyek["is_strategis_nas"];
                                $proyekModel->is_strategis_wika = is_array($proyek["is_strategis_wika"]) && empty($proyek["is_strategis_wika"]) ? null : $proyek["is_strategis_wika"];
                                $proyekModel->jenis_kontrak = is_array($proyek["jenis_kontrak"]) && empty($proyek["jenis_kontrak"]) ? null : $proyek["jenis_kontrak"];
                                $proyekModel->is_new = is_array($proyek["is_new"]) && empty($proyek["is_new"]) ? null : $proyek["is_new"];
                                $proyekModel->is_closed = is_array($proyek["is_closed"]) && empty($proyek["is_closed"]) ? null : $proyek["is_closed"];
                                $proyekModel->kasie_name = is_array($proyek["kasie_name"]) && empty($proyek["kasie_name"]) ? null : $proyek["kasie_name"];
                                $proyekModel->kasie_nip = is_array($proyek["kasie_nip"]) && empty($proyek["kasie_nip"]) ? null : $proyek["kasie_nip"];
                                $proyekModel->kasie_phone = is_array($proyek["kasie_phone"]) && empty($proyek["kasie_phone"]) ? null : $proyek["kasie_phone"];
                                $proyekModel->kasie_email = is_array($proyek["kasie_email"]) && empty($proyek["kasie_email"]) ? null : $proyek["kasie_email"];
                                $proyekModel->tanggal_mulai = is_array($proyek["tanggal_mulai"]) && empty($proyek["tanggal_mulai"]) ? null : $proyek["tanggal_mulai"];
                                $proyekModel->klasifikasi = is_array($proyek["klasifikasi"]) && empty($proyek["klasifikasi"]) ? null : $proyek["klasifikasi"];
                                $proyekModel->pembayaran = is_array($proyek["pembayaran"]) && empty($proyek["pembayaran"]) ? null : $proyek["pembayaran"];
                                $proyekModel->sbu_skd = is_array($proyek["sbu_skd"]) && empty($proyek["sbu_skd"]) ? null : $proyek["sbu_skd"];
                                $proyekModel->keterangan_pembayaran = is_array($proyek["keterangan_pembayaran"]) && empty($proyek["keterangan_pembayaran"]) ? null : $proyek["keterangan_pembayaran"];
                                $proyekModel->status_proyek_internal = is_array($proyek["status_proyek_internal"]) && empty($proyek["status_proyek_internal"]) ? null : $proyek["status_proyek_internal"];
                                $proyekModel->profit_center = is_array($proyek["profit_center"]) && empty($proyek["profit_center"]) ? null : $proyek["profit_center"];
                                $proyekModel->is_closed_risk = is_array($proyek["is_closed_risk"]) && empty($proyek["is_closed_risk"]) ? null : $proyek["is_closed_risk"];
                                $proyekModel->status_contract = is_array($proyek["status_contract"]) && empty($proyek["status_contract"]) ? null : $proyek["status_contract"];
                                $proyekModel->klasifikasi_sap = is_array($proyek["klasifikasi_sap"]) && empty($proyek["klasifikasi_sap"]) ? null : $proyek["klasifikasi_sap"];
                                $proyekModel->start_year = is_array($proyek["start_year"]) && empty($proyek["start_year"]) ? null : $proyek["start_year"];
                                $proyekModel->end_year = is_array($proyek["end_year"]) && empty($proyek["end_year"]) ? null : $proyek["end_year"];
                                $proyekModel->bast1_year = is_array($proyek["bast1_year"]) && empty($proyek["bast1_year"]) ? null : $proyek["bast1_year"];
                                $proyekModel->bast2_year = is_array($proyek["bast2_year"]) && empty($proyek["bast2_year"]) ? null : $proyek["bast2_year"];
                                $proyekModel->jenis_proyek = is_array($proyek["jenis_proyek"]) && empty($proyek["jenis_proyek"]) ? null : $proyek["jenis_proyek"];
                                $proyekModel->tipe_proyek = is_array($proyek["tipe_proyek"]) && empty($proyek["tipe_proyek"]) ? null : $proyek["tipe_proyek"];
                                $proyekModel->status_proyek = is_array($proyek["status_proyek"]) && empty($proyek["status_proyek"]) ? null : $proyek["status_proyek"];
                                $proyekModel->is_investasi = is_array($proyek["is_investasi"]) && empty($proyek["is_investasi"]) ? null : $proyek["is_investasi"];
                                $proyekModel->kd_divisi = is_array($proyek["kd_divisi"]) && empty($proyek["kd_divisi"]) ? null : $proyek["kd_divisi"];
                                $proyekModel->project_definition = is_array($proyek["project_definition"]) && empty($proyek["project_definition"]) ? null : $proyek["project_definition"];
                                $proyekModel->kode_crm = is_array($proyek["kode_crm"]) && empty($proyek["kode_crm"]) ? null : $proyek["kode_crm"];
                                $proyekModel->divisi = is_array($proyek["divisi"]) && empty($proyek["divisi"]) ? null : $proyek["divisi"];
                                $proyekModel->tipe_kontrak = is_array($proyek["tipe_kontrak"]) && empty($proyek["tipe_kontrak"]) ? null : $proyek["tipe_kontrak"];
                                $proyekModel->sumber_dana = is_array($proyek["sumber_dana"]) && empty($proyek["sumber_dana"]) ? null : $proyek["sumber_dana"];
                                $proyekModel->pola_bayar = is_array($proyek["pola_bayar"]) && empty($proyek["pola_bayar"]) ? null : $proyek["pola_bayar"];
                                $proyekModel->kdbp_sap = is_array($proyek["kdbp_sap"]) && empty($proyek["kdbp_sap"]) ? null : $proyek["kdbp_sap"];
                                $proyekModel->requisition_id = is_array($proyek["requisition_id"]) && empty($proyek["requisition_id"]) ? null : $proyek["requisition_id"];
                                $proyekModel->business_partner = is_array($proyek["business_partner"]) && empty($proyek["business_partner"]) ? null : $proyek["business_partner"];
                                $proyekModel->bi_email = is_array($proyek["bi_email"]) && empty($proyek["bi_email"]) ? null : $proyek["bi_email"];
                                $proyekModel->sbu_name = is_array($proyek["sbu_name"]) && empty($proyek["sbu_name"]) ? null : $proyek["sbu_name"];
                                $proyekModel->is_sap = is_array($proyek["is_sap"]) && empty($proyek["is_sap"]) ? null : $proyek["is_sap"];

                                return $proyekModel;
                            });

                            ProyekPISNew::insert($data_mapping->toArray());
                            $logging = [
                                'success' => true,
                                'createdAt' => Carbon::now(),
                                'data' => $data_mapping->toArray()
                            ];
                            setLogging('Get_Progress_PIS_3', "[Get Data Proyek From PIS] => ", $logging);
                        } catch (\Throwable $th) {
                            dd($th);
                        }
                    }
                }
            }
        }
    });
    //End :: Integrasi Get Proyek PIS

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
    // $proyeks = Proyek::where("stage", "=", 8)->where("unit_kerja", "=", $unitKerjaPis)->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak", "provinsi", "negara", "sistem_bayar", "sumber_dana", "sbu", "jenis_terkontrak", "lokasi_tender", "mata_uang_review", "mata_uang_awal", "longitude", "latitude"])->filter(function ($p) use (&$periodeOtor, $periode, &$yearOtor) {
    //     if ($periode[1] == 1) {
    //         $periodeOtor = 12;
    //         $yearOtor = (int) date("Y") - 1;
    //         $is_forecast_exist = $p->HistoryForecasts->where("periode_prognosa", $periodeOtor)->where("tahun", "=", $yearOtor)->count() > 0;
    //     } else {
    //         $periodeOtor = $periode[1] - 1;
    //         $yearOtor = (int) date("Y");
    //         $is_forecast_exist = $p->HistoryForecasts->where("periode_prognosa", $periodeOtor)->where("tahun", "=", $yearOtor)->count() > 0;
    //     }
    //     unset($p->HistoryForecasts);
    //     return $is_forecast_exist;
    // });
    $proyeks = Proyek::where("stage", "=", 8)->where("tahun_perolehan", "=", $periode[0])->where("unit_kerja", "=", $unitKerjaPis)->get(["id", "tanggal_selesai_pho", "tanggal_selesai_fho", "jenis_proyek", "kode_proyek", "nama_proyek", "tanggal_mulai_terkontrak", "tanggal_akhir_terkontrak", "nospk_external", "porsi_jo", "nilai_kontrak_keseluruhan", "nomor_terkontrak", "nilai_valas_review", "tglspk_internal", "tanggal_terkontrak", "nilai_perolehan", "kurs_review", "klasifikasi_terkontrak", "provinsi", "negara", "sistem_bayar", "sumber_dana", "sbu", "jenis_terkontrak", "lokasi_tender", "mata_uang_review", "mata_uang_awal", "longitude", "latitude"]);


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
            case "CPF (Turn Key)":
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
            case "Lumsump+Unit Price":
                $jenis_terkontrak = "JKT08";
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
        $jenis_proyek = "";
        switch ($p->jenis_proyek) {
            case "I":
                $jenis_proyek = "Internal";
                break;
            case "N":
                $jenis_proyek = "Non JO";
                break;
            case "J":
                $jenis_proyek = "JO";
                // switch ($p->kategori_jo) {
                //     case "30":
                //         $jenis_proyek = "JO Integrated Leader";
                //         break;
                //     case "31":
                //         $jenis_proyek = "JO Integrated Member";
                //         break;
                //     case "40":
                //         $jenis_proyek = "JO Portion Leader";
                //         break;
                //     case "41":
                //         $jenis_proyek = "JO Portion Member";
                //         break;
                //     case "50":
                //         $jenis_proyek = "JO Mix Integrated - Portion";
                //         break;
                // }
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
                $kode_sap = "Z1 - Proyek Mega K. Sipil";
            } else if ($p->klasifikasi_terkontrak == "Proyek Besar" && $kategori == "Sipil") {
                $kode_sap = "Z2 - Proyek Besar K. Sipil";
            } else if ($p->klasifikasi_terkontrak == "Proyek Menengah" && $kategori == "Sipil") {
                $kode_sap = "Z3 - Proyek Menengah K. Sipil";
            } else if ($p->klasifikasi_terkontrak == "Proyek Kecil" && $kategori == "Sipil") {
                $kode_sap = "Z4 - Proyek Kecil K. Sipil";
            } else if ($p->klasifikasi_terkontrak == "Mega Proyek" && $kategori == "EPC") {
                $kode_sap = "Z5 - Proyek Mega K. EPC";
            } else if ($p->klasifikasi_terkontrak == "Proyek Besar" && $kategori == "EPC") {
                $kode_sap = "Z6 - Proyek Besar K. EPC";
            } else if ($p->klasifikasi_terkontrak == "Proyek Menengah" && $kategori == "EPC") {
                $kode_sap = "Z7 - Proyek Menengah K. EPC";
            } else if ($p->klasifikasi_terkontrak == "Proyek Kecil" && $kategori == "EPC") {
                $kode_sap = "Z8 - Proyek Kecil K. EPC";
            }
        }

        // $sign = ":";
        $kode_proyek = DB::table("proyek_code_crm")->where("kode_proyek", '=', $p->kode_proyek)->first()->kode_proyek_crm ?? null;
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
                "d:UsrKodeProyek" => (!empty($kode_proyek) || $kode_proyek != "") ? $kode_proyek : $p->kode_proyek,
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
    setLogging("api", "Detail Proyek XML => ", $data);
    $taken_date = Carbon::now()->translatedFormat("d F Y H:i:s");
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

// Begin Send Data Industry Attractivness ke SAP
Route::get('/send-data-industry-attractivness', function (Request $request) {
    // $customers_attractivness = Customer::with(["IndustryOwner"])->get();
    $customers_attractivness = IndustryOwner::all();
    $customers_attractivness = $customers_attractivness->map(function($ca) {
        // dd($ca);
        $new_ca = new stdClass();
        $new_ca->PERIODE = date("Ymd");
        $new_ca->INDUSTRY_CODE = $ca->code_owner ?? "";
        $new_ca->ATTRACTIVENESS_STATUS = $ca->owner_attractiveness ?? "";
        return $new_ca;
    });

    // FIRST STEP SEND DATA TO BW
    $csrf_token = "";
    $content_location = "";
    // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
    // $http = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022");
    $get_token = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi001/requests");
    $csrf_token = $get_token->header("x-csrf-token");
    $cookie = "";
    collect($get_token->cookies()->toArray())->each(function($c) use(&$cookie) {
        $cookie .= $c["Name"] . "=" . $c["Value"] . ";"; 
    });

    // SECOND STEP SEND DATA TO BW
    $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi001/requests");
    $content_location = $get_content_location->header("content-location");
    // $industry_attractivness = IndustryOwner::all();
    // $new_class = $industry_attractivness->map(function($ia) {
    //     $new_ia = new stdClass();
    //     $new_ia->PERIODE = date("Ymd");
    //     $new_ia->INDUSTRY_CODE = $ia->code_owner ?? "";
    //     $new_ia->ATTRACTIVENESS_STATUS = $ia->owner_attractiveness ?? "";
    //     return $new_ia;
    // });

    // THIRD STEP SEND DATA TO BW
    // dd($new_class->toJson());
    $fill_data = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi001/dataSend?request=$content_location&datapid=1", $customers_attractivness->toArray());
    
    // FOURTH STEP SEND DATA TO BW
    $closed_request = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi001/requests/$content_location/close");
    dd($closed_request);
    return response()->json($customers_attractivness);
});
// End Send Data Industry Attractivness ke SAP
// Begin Send Data Claim ke BW SAP
Route::get('/send-data-claim-management', function (Request $request) {
    // $data = $request->all();

    // $claims_all = PerubahanKontrak::all();
    // $claims_all = PerubahanKontrak::whereIn("jenis_perubahan", ["VO", "Klaim"])->where("id_contract", "=", $data)->first();
    $claims_all = PerubahanKontrak::whereIn("jenis_perubahan", ["VO", "Klaim"])->where("id_contract", "=", "9163afe7-0617-3423-9f49-ed78e1d0ea9d")->get();
    // dd($claims_all);
    // $claims_map = $claims_all->map(function($claim){
    //     return $claim->Proyek->UnitKerja->id_profit_center;
    // });
    // dd($claims_map);
    // $profit_center = $contract->project->UnitKerja->id_profit_center;
    // $claims = $contract->PerubahanKontrak;
    $filter = $claims_all->filter(function ($item) {
        return $item->Proyek->profit_center != "";
        // return $item;
    });
    $data_claims = $claims_all->map(function ($item, $key) use ($claims_all) {

        $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function ($i, $key) use ($item) {
            return $key == $item->jenis_perubahan;
            // return $i->stage == 1;
        })->flatten();

        $claim_val = $item_claim->filter(function ($ic) use ($item) {
            if ($item->stage == 1) {
                return $ic->stage == 1;
            } elseif ($item->stage == 2) {
                return $ic->stage == 2;
            } elseif ($item->stage == 5) {
                return $ic->stage == 5;
            }
        })->count();

        $profit_center = $item->Proyek->profit_center;

        $newClass = new stdClass();
        $newClass->TANGGAL = (int) date("Ymd");
        $newClass->PROFIT_CTR = "$profit_center";
        $newClass->PROJECT_DEF = "$profit_center";
        // $newClass->PROJECT_DEF = "AB00000";
        $newClass->COMP_CODE = "A000";
        $newClass->ITEM_CLAIM = "$item->uraian_perubahan";
        if ($item->stage == 2) {
            $newClass->CLAIM_CAT = "ITEM DIAJUKAN";
        } elseif ($item->stage == 1) {
            $newClass->CLAIM_CAT = "ITEM TARGET";
        } elseif ($item->stage == 5) {
            $newClass->CLAIM_CAT = "ITEM DISETUJUI";
        };

        $newClass->CLAIM_VAL = $claim_val;

        if ($item->stage == 5) {
            $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
        } else {
            $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
        }

        // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");

        if ($item->jenis_perubahan == "Klaim") {
            $newClass->CATEGORY = "CLAIM";
        } else {
            $newClass->CATEGORY = "$item->jenis_perubahan";
        }

        return $newClass;
    })->values();

    return response()->json($data_claims, 200);
    // dd($data_claims->toJson());

    // FIRST STEP SEND DATA TO BW
    $csrf_token = "";
    $content_location = "";
    // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
    // $http = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022");
    $get_token = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests");
    $csrf_token = $get_token->header("x-csrf-token");
    $cookie = "";
    collect($get_token->cookies()->toArray())->each(function ($c) use (&$cookie) {
        $cookie .= $c["Name"] . "=" . $c["Value"] . ";";
    });

    // SECOND STEP SEND DATA TO BW
    $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests");
    $content_location = $get_content_location->header("content-location");


    // THIRD STEP SEND DATA TO BW
    // dd($new_class->toJson());
    $fill_data = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/dataSend?request=$content_location&datapid=1", $data_claims->toArray());

    // FOURTH STEP SEND DATA TO BW
    $closed_request = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests/$content_location/close");
    dd($closed_request, $data_claims, $fill_data);

    return response()->json($data_claims);
});
// End Send Data Claim ke BW SAP

// Begin Get Jenis Dokumen
Route::get('/get-jenis-dokumen/{jenis_dokumen}', function ($jenis_dokumen) {
    // <option  value="Site Instruction">Site Instruction</option>
    //                                             <option  value="Technical Form">Technical Form</option>
    //                                             <option  value="Technical Query">Technical Query</option>
    //                                             <option  value="Field Design Change">Field Design Change</option>
    //                                             <option  value="Contract Change Notice">Contract Change Notice</option>
    //                                             <option  value="Contract Change Proposal">Contract Change Proposal</option>
    //                                             <option  value="Contract Change Order">Contract Change Order</option>
    switch($jenis_dokumen) {
        case "Site Instruction":
            $data = SiteInstruction::all();
            return response()->json($data);
            break;
        
        case "Technical Form":
            $data = TechnicalForm::all();
            return response()->json($data);
            break;
        
        case "Technical Query":
            $data = TechnicalQuery::all();
            return response()->json($data);
            break;
        
        case "Field Design Change":
            $data = FieldChange::all();
            return response()->json($data);
            break;
        
        case "Contract Change Notice":
            $data = ContractChangeNotice::all();
            return response()->json($data);
            break;
        
        case "Contract Change Proposal":
            $data = ContractChangeProposal::all();
            return response()->json($data);
            break;
        
        case "Contract Change Order":
            $data = ContractChangeOrder::all();
            return response()->json($data);
            break;
    }
});

Route::get('/get-jenis-dokumen/{jenis_dokumen}/{profit_center}', function ($jenis_dokumen, $profit_center) {
    switch ($jenis_dokumen) {
        case "Site Instruction":
            $data = SiteInstruction::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        
        case "Technical Form":
            $data = TechnicalForm::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        
        case "Technical Query":
            $data = TechnicalQuery::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        
        case "Field Design Change":
            $data = FieldChange::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        
        case "Contract Change Notice":
            $data = ContractChangeNotice::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        
        case "Contract Change Proposal":
            $data = ContractChangeProposal::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        
        case "Contract Change Order":
            $data = ContractChangeOrder::where('profit_center', '=', $profit_center)->get();
            return response()->json($data);
            break;
        

    }
});
// End Get Jenis Dokumen

Route::get('/abort/{code}/{msg}', function ($code, $msg) {
    return abort($code, $msg);
});

Route::get('/php-info', function () {
    return dd(phpinfo());
});

Route::get('/test-file', function (Request $request) {
    // $proyek = Proyek::find('HNPC003');
    // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
    // return createWordPersetujuan($proyek, $hasil_assessment, true, false, $request);
    // dd("tes");
    try {
        $pdf = Pdf::loadView('GenerateFile.generatePermohonanKSO');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('Form Verifikasi Internal KSO atau Non KSO - HNPC003.pdf');
        dd("TES");
    } catch (Exception $e) {
        dd($e->getMessage());
    }

    // $proyek = NotaRekomendasi2::where('kode_proyek', 'HNPC003')->first();
    // return createWordPersetujuanNota2($proyek, true);
    // $proyek = Proyek::find('PNPC009');
    // return createWordProfileRisikoNew('GNPC364');
    // return mergeFileLampiranRisiko('GNPC361');
});