<?php

use App\Http\Controllers\AddendumContractController;
use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractManagementsController;
use App\Http\Controllers\SumberDanaController;
use App\Http\Controllers\DopController;
use App\Http\Controllers\SbuController;
use App\Http\Controllers\UnitKerjaController;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DraftContractController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasalController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\UserController;
use App\Models\Forecast;
use Illuminate\Support\Facades\Auth;

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




// Route::get('/', function () {
//     return view('1_Dashboard');
// });
Route::get('/', [UserController::class, 'welcome'])->middleware("userNotAuth");


// begin :: Login
    Route::get('/', [UserController::class, 'welcome'])->middleware('guest');
    // Route::get('/welcome', [UserController::class, 'welcome'])->middleware('guest');

    Route::post('/login', [UserController::class, 'authen']);

    Route::post('/logout', [UserController::class, 'logout']);

    // Route::post('/createUser', [UserController::class, 'testLogin']);
// end :: Login




Route::group(['middleware' => ["userAuth"]], function () {
    Route::get('/dashboard', function () {
        \Illuminate\Support\Facades\Artisan::call("storage:link");
        return view('1_Dashboard');
    });

    // begin :: contract management
    Route::get('/contract-management', [ContractManagementsController::class, 'index']);
    
    Route::get('/contract-management/view', [ContractManagementsController::class, 'new']);
    
    Route::post('/contract-management/save', [ContractManagementsController::class, 'save']);
    
    Route::post('/contract-management/update', [ContractManagementsController::class, 'update']);
    
    Route::get('/contract-management/view/{id_contract}', [ContractManagementsController::class, 'viewContract']);
    
    Route::get('/contract-management/view/{id_contract}/addendum-contract', [ContractManagementsController::class, 'addendumContract']);
    
    Route::get('/contract-management/view/{id_contract}/addendum-contract/{addendumContract}', [ContractManagementsController::class, 'addendumView']);
    
    Route::get('/contract-management/view/{id_contract}/addendum-contract/{addendumContract}/new', [ContractManagementsController::class, 'addendumNew']);
    
    Route::get('/contract-management/view/{id_contract}/addendum-contract/{addendumContract}/{addendumDraft}', [ContractManagementsController::class, 'addendumDraft']);
    
    Route::get('/contract-management/view/{id_contract}/draft-contract', [ContractManagementsController::class, 'draftContract']);
    
    Route::get('/contract-management/view/{id_contract}/draft-contract/{draftContracts}', [ContractManagementsController::class, 'draftContractView']);
    
    Route::get('/contract-management/view/{id_contract}/draft-contract/{is_tender_menang}', [ContractManagementsController::class, 'tenderMenang']);
    
    // end :: contract management
});



// begin :: Pasal
Route::get('/pasal/edit', [PasalController::class, 'index']);

Route::get('/pasal/delete/{pasal}', [PasalController::class, 'destroy']);

Route::get('/pasal/{pasal}', [PasalController::class, 'show']);

Route::get('change-request', [PasalController::class, 'changeRequest']);

// end :: Pasal


// begin :: Claim Management


Route::get('claim-management', [ClaimController::class, 'index']);

Route::get('claim-management/proyek/{kode_proyek}', [ClaimController::class, 'viewClaim']);

Route::get('claim-management/view/{kode_proyek}', [ClaimController::class, 'viewClaim']);

Route::get('claim-management/{proyek}/{contract}/new',  [ClaimController::class, 'new']);

Route::post('/claim-management/save', [ClaimController::class, 'save']);

Route::get('claim-management/view/{claim_management}', [ClaimController::class, 'show']);

Route::post('/approval-claim/save', [ClaimController::class, 'store']);

Route::post('/approval-claim/delete', [ClaimController::class, 'delete']);

Route::post('/claim-management/update', [ClaimController::class, 'update']);

Route::post('/detail-claim/save', [ClaimController::class, 'detailSave']);

Route::post('/claim/stage/save', [ClaimController::class, 'claimStage']);

// end :: Claim Management

// Begin :: Menu Document
Route::get('/document', function () {
    $all_document = [];
    $tables = DB::select("SELECT table_name
                            FROM information_schema.columns
                            WHERE column_name='id_document';");
    foreach ($tables as $table) {
        $table_name = $table->table_name;
        $data = DB::select("SELECT * FROM $table_name;");
        if (!empty($data)) {
            array_push($all_document, $data);
        }
    }
    $all_document = array_merge(...$all_document);
    $id_documents = array_map(function ($array) {
        return array_values((array) $array);
    }, $all_document);
    $documents_name = array_map(function ($array) {
        $array = get_object_vars($array);
        $array_keys = array_keys($array);
        foreach ($array_keys as $key) {
            if (str_contains($key, "document_name")) {
                return $array[$key];
            }
        }
    }, $all_document);
    return view("document/view", ["all_document" => $all_document, "id_documents" => $id_documents, "documents_name" => $documents_name]);
});
// End :: Menu Document


//Begin :: Customer
// customer dashboard all database
Route::get('/customer', [CustomerController::class, 'index']);


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


// Edit Customer Proyek History by view id_customer    
Route::post('/customer/save-modal', [CustomerController::class, 'customerHistory']);
//End :: Customer



//Begin :: Project

// Home Page Proyek
Route::get('/project', [ProyekController::class, 'view']);

// to NEW page 
Route::get('/proyek/new', [ProyekController::class, 'new']);

// direct to proyek after SAVE page 
Route::post('/proyek/save', [ProyekController::class, 'save']);

// VIEW to proyek and EDIT 
Route::get('/proyek/view/{id}', [ProyekController::class, 'edit']);

// direct to Project after EDIT 
Route::post('/proyek/update', [ProyekController::class, 'update']);

// DELETE data customer pada dasboard customer by ID 
Route::delete('proyek/delete/{kode_proyek}', [ProyekController::class, 'delete']);

// Stage Update 
Route::post('/proyek/stage-save', function (Request $request) {
    $id = $request->id;
    $proyekStage = Proyek::find($id);
    $proyekStage->stage = $request->stage;
    // dd($proyekStage);
    if ($proyekStage->save()) {
        return response()->json([
            "status" => "success",
            "link" => true,
        ]);
    }
});

Route::post('/proyek/forecast/save', function (Request $request) {
    $data = $request->all();
    $proyek = Proyek::find($data["kode_proyek"]);
    $forecast = Forecast::where("kode_proyek", "=", $data["kode_proyek"])->where("month_forecast", "=", $data["forecast_month"])->orderByDesc("created_at")->first();
    // $forecast = DB::select("SELECT * FROM forecasts WHERE kode_proyek='" . $data["kode_proyek"] . "' AND (" . "YEAR(created_at)=" . date("Y") . " OR YEAR(updated_at)=" . date("Y"). ");");
    if (!empty($forecast)) {
        // $forecast->nilai_forecast = (int) $data["nilai_forecast"];
        if ($forecast->update(["nilai_forecast" => (int) $data["nilai_forecast"]])) {
            return response()->json([
                "status" => "success",
                "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> berhasil di tambahkan",
            ]);
        }
    } else {
        $forecast = new Forecast();
        $forecast->nilai_forecast = (int) $data["nilai_forecast"];
        $forecast->month_forecast = (int) $data["forecast_month"];
        $forecast->kode_proyek = $data["kode_proyek"];
        if ($forecast->save()) {
            return response()->json([
                "status" => "success",
                "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> berhasil di tambahkan",
            ]);
        }
    }

    return response()->json([
        "status" => "failed",
        "msg" => "Nilai Forecast pada proyek <b>$proyek->nama_proyek</b> gagal di tambahkan",
    ]);
});
//End :: Project


//Begin :: Forecast

// Home Page Forecast
Route::get('/forecast', [ForecastController::class, 'index']);

// Get all data from database
Route::post('/forecast', [ForecastController::class, 'getAllData']);
Route::post('/forecast/unit-kerja', [ForecastController::class, 'getAllDataUnitKerjas']);
// to NEW page 
// Route::get('/proyek/new', [ProyekController::class, 'new']);

//End :: Forecast


// Begin :: Master Data

// Home Page Company
Route::get('/company', [CompanyController::class, 'index']);

// NEW Company after SAVE 
Route::post('/company/save', [CompanyController::class, 'store']);

// Home Sumber Dana
Route::get('/sumber-dana', [SumberDanaController::class, 'index']);

// NEW Sumber Dana after SAVE
Route::post('/sumber-dana/save', [SumberDanaController::class, 'store']);

// Home DOP
Route::get('/dop', [DopController::class, 'index']);

// NEW DOP after SAVE
Route::post('/dop/save', [DopController::class, 'store']);

// Home SBU
Route::get('/sbu', [SbuController::class, 'index']);

// NEW SBU after SAVE
Route::post('/sbu/save', [SbuController::class, 'store']);

// Home Unit Kerja
Route::get('/unit-kerja', [UnitKerjaController::class, 'index']);

// NEW Unit Kerja after SAVE
Route::post('/unit-kerja/save', [UnitKerjaController::class, 'store']);

//End :: Master Data

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

Route::post("/draft-contract/upload", [DraftContractController::class, "save"]);

Route::post("/addendum-contract/upload", [AddendumContractController::class, "upload"]);

Route::post("/addendum-contract/draft/upload", [AddendumContractController::class, "draftUpload"]);

Route::post("/addendum-contract/draft/update", [AddendumContractController::class, "draftUpdate"]);


Route::post("/review-contract/upload", [ContractManagementsController::class, "reviewContractUpload"]);

Route::post("/issue-project/upload", [ContractManagementsController::class, "issueProjectUpload"]);

Route::post("/question/upload", [ContractManagementsController::class, "questionUpload"]);

Route::post("/input-risk/upload", [ContractManagementsController::class, "riskUpload"]);

Route::post("/laporan-bulanan/upload", [ContractManagementsController::class, "monthlyReportUpload"]);

Route::post("/serah-terima/upload", [ContractManagementsController::class, "handOverUpload"]);


Route::get("/document/view/{id}/{id_document}", [DocumentController::class, "documentView"]);

Route::get("/document/view/{id}/{id_document}/history", [DocumentController::class, "documentViewHistory"]);

Route::post('/pasal/clear', [PasalController::class, "pasalClear"]);

Route::post("/document/view/{id}/{id_document}/save", [DocumentController::class, "documentSave"]);

Route::post('/stage/save', [StageController::class, "stageSave"]);

Route::post('/stage/addendum/save', [StageController::class, "stageAddendumSave"]);

Route::post('/pasal/save', [PasalController::class, "pasalSave"]);

Route::post('/pasal/add', [PasalController::class, "pasalAdd"]);

Route::post('/pasal/update', [PasalController::class, "pasalUpdate"]);

// begin route PIC
Route::get('/pic', function () {
    return view("/MasterData/pic", ["all_proyek" => Proyek::all()->reverse()]);
});
// end route PIC

function writeDOCXFile($content)
{
    // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    // header("Content-Disposition: attachment;filename=$id_document.docx");
    $php_word = new PhpWord();
    $section = $php_word->addSection();
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content);
    $docx_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word);
    return $docx_writer;
}

function moveFileTemp(UploadedFile $file, $file_name)
{
    $result = $file->storeAs("public/words", $file_name . "." . $file->getClientOriginalExtension());

    return $result;
}
