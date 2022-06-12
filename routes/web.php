<?php

use App\Http\Controllers\ClaimController;
use App\Models\AddendumContractDrafts;
use App\Models\AddendumContracts;
use Illuminate\Support\Facades\Route;
use App\Models\ContractManagements;
use App\Models\DraftContracts;
use App\Models\HandOvers;
use App\Models\InputRisks;
use App\Models\IssueProjects;
use App\Models\MonthlyReports;
use App\Models\Pasals;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractManagementsController;
use App\Http\Controllers\SumberDanaController;
use App\Http\Controllers\DopController;
use App\Http\Controllers\SbuController;
use App\Http\Controllers\UnitKerjaController;
use App\Models\ClaimDetails;
use App\Models\ClaimManagements;
use App\Models\Proyek;
use App\Models\Questions;
use App\Models\ReviewContracts;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Customer;
use App\Models\CustomerAttachments;
use App\Http\Controllers\CustomerController;
use App\Models\ProyekBerjalans;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\PasalController;

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



Route::get('/', function () {
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



// begin :: Pasal
Route::get('/pasal/edit', [PasalController::class, 'index']);

Route::get('/pasal/delete/{pasal}', [PasalController::class, 'destroy']);

Route::get('/pasal/{pasal}', [PasalController::class, 'show']);

Route::get('change-request', [PasalController::class, 'changeRequest']);

// end :: Pasal


// begin :: Claim Management
Route::get('claim-management', [ClaimController::class, 'index']);

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


// view customer by id_customer #1
Route::get('/customer/view/{id_customer}', [CustomerController::class, 'view']);



// EDIT customer by view id_customer #2   
Route::post('/customer/save-edit', [CustomerController::class, 'saveEdit']);


// NEW to Create New customer #1 
Route::get('/customer/new', [CustomerController::class, 'new']);


// NEW to Create New customer #2
Route::post('/customer/save', [CustomerController::class, 'saveNew']);


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

//End :: Project


//Begin :: Forecast

// Home Page Forecast
Route::get('/forecast', [ForecastController::class, 'index']);

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


function moveFileTemp(UploadedFile $file, $file_name)
{
    $result = $file->storeAs("public/words", $file_name . "." . $file->getClientOriginalExtension());

    return $result;
}

Route::post("/draft-contract/upload", function (Request $request, DraftContracts $draftContracts) {

    $data = $request->all();
    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
        "date" => "This field must be date format only",
    ];
    $rules = [
        "attach-file-draft" => "required|file",
        "document-name-draft" => "required|string",
        "note-draft" => "required|string",
        "id-contract" => "required|numeric",
        "draft-contract-title" => "required|string",
        "draft-contract-version" => "required|numeric",
        "draft-contract-start-date" => "required|date",
        "draft-contract-create-by" => "required|string",
    ];
    $validation = Validator::make($data, $rules, $messages);
    if (!Session::has("pasals")) {
        $request->old("draft-contract-title");
        $request->old("draft-contract-version");
        $request->old("draft-contract-start-date");
        $request->old("draft-contract-create-by");
        $request->old("note-draft");
        $request->old("document-name-draft");
        $request->old("document-name-draft-menang");
        $request->old("attach-file-draft");
        $validation->validate();
        return Redirect::back()->with("error", "Pastikan pasal-pasal sudah di ceklis");
    }

    if (Session::has("pasals")) {
        $pasals = [];
        foreach (Session::get("pasals") as $pasal) {
            array_push($pasals, $pasal->id_pasal);
        }
    }
    $faker = new Faker\Core\Uuid();
    $id_document = $faker->uuid3();
    $file = $request->file("attach-file-draft");

    if ($validation->fails()) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        $request->old("draft-contract-title");
        $request->old("draft-contract-version");
        $request->old("draft-contract-start-date");
        $request->old("draft-contract-create-by");
        $request->old("note-draft");
        $request->old("document-name-draft");
        $request->old("document-name-draft-menang");
        $request->old("attach-file-draft");
        return Redirect::back()->with("error", "Please fill 'Draft Contract' empty field");
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    $validation->validate();

    $draftContracts->document_name = $data["document-name-draft"];
    $draftContracts->id_document = $id_document;
    $draftContracts->draft_note = $data["note-draft"];
    $draftContracts->created_by = $data["draft-contract-create-by"];
    $draftContracts->start_date = $data["draft-contract-start-date"];
    $draftContracts->id_contract = $data["id-contract"];
    $draftContracts->tender_menang = $is_tender_menang;
    $draftContracts->pasals = join(",", $pasals) ?? "";
    $draftContracts->draft_contract_version = $data["draft-contract-version"];
    $draftContracts->title_draft = $data["draft-contract-title"];
    if ($draftContracts->save()) {
        moveFileTemp($file, $id_document);
        return Redirect::to("/contract-management/view/$draftContracts->id_contract")->with("success", "Your Draft Contract has been saved");
    }
    return Redirect::back()->with("error", "Your Draft Contract failed to save");
});

Route::post("/addendum-contract/upload", function (Request $request, AddendumContracts $addendumContracts) {

    $data = $request->all();
    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
        "date" => "This field must be date format only",
    ];
    $rules = [
        // "document-name-addendum-menang" => "required|string",
        "addendum-contract-title" => "required|string",
        "addendum-contract-version" => "required|numeric",
        "addendum-contract-start-date" => "required|date",
        "addendum-contract-create-by" => "required|string",
    ];
    $validation = Validator::make($data, $rules, $messages);
    if (!Session::has("pasals")) {
        $request->old("addendum-contract-title");
        $request->old("addendum-contract-version");
        $request->old("addendum-contract-start-date");
        $request->old("addendum-contract-create-by");
        $validation->validate();
        return Redirect::back()->with("error", "Pastikan pasal-pasal sudah di ceklis");
    }
    if (Session::has("pasals")) {
        $pasals = [];
        foreach (Session::get("pasals") as $pasal) {
            array_push($pasals, $pasal->id_pasal);
        }
    }

    if ($validation->fails()) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        $request->old("addendum-contract-title");
        $request->old("addendum-contract-version");
        $request->old("addendum-contract-start-date");
        $request->old("addendum-contract-create-by");

        return Redirect::back()->with("error", "Please fill 'Addendum Contract' empty field");
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        $request->old("addendum-contract-title");
        $request->old("addendum-contract-version");
        $request->old("addendum-contract-start-date");
        $request->old("addendum-contract-create-by");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    // if ($is_tender_menang == 1) {
    //     $rules["document-name-addendum-menang"] = "required|string";
    //     $addendumContracts->document_name = $data["document-name-addendum-menang"];
    // } else {
    // }
    $validation->validate();

    // Update Stages Contract
    $is_id_contract_exist->stages = 4;
    // $addendumContracts->document_name = $data["document-name-addendum"];
    $addendumContracts->created_by = $data["addendum-contract-create-by"];
    $addendumContracts->start_date = $data["addendum-contract-start-date"];
    $addendumContracts->id_contract = $data["id-contract"];
    $addendumContracts->tender_menang = $is_tender_menang;
    $addendumContracts->stages = 1;
    $addendumContracts->pasals = join(",", $pasals) ?? "";
    $addendumContracts->addendum_contract_version = $data["addendum-contract-version"];
    $addendumContracts->no_addendum = $data["addendum-contract-title"];
    if ($addendumContracts->save() && $is_id_contract_exist->save()) {
        Session::forget("pasals");
        return Redirect::to("/contract-management/view/$addendumContracts->id_contract")->with("success", "Your Addendum Contract has been saved");
    }
    return Redirect::back()->with("error", "Your Addendum Contract failed to save");
});

Route::post("/addendum-contract/draft/upload", function (Request $request, AddendumContractDrafts $addendumContractDrafts) {

    $data = $request->all();
    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
        "date" => "This field must be date format only",
    ];
    $rules = [
        "attach-file-addendum" => "required|file",
        // "document-name-addendum-menang" => "required|string",
        "document-name-addendum" => "required|string",
        "note-addendum" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);
    $validation->validate();

    $faker = new Faker\Core\Uuid();
    $id_document = $faker->uuid3();
    $file = $request->file("attach-file-addendum");

    if ($validation->fails()) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        $request->old("note-addendum");
        $request->old("document-name-addendum");
        $request->old("document-name-addendum-menang");
        $request->old("attach-file-addendum");
        dd("validation");

        return Redirect::back()->with("error", "Please fill 'Addendum Contract' empty field");
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        $request->old("note-addendum");
        $request->old("document-name-addendum");
        $request->old("document-name-addendum-menang");
        $request->old("attach-file-addendum");
        return Redirect::back()->with("error", "Contract not exist");
    }

    // $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    // if ($is_tender_menang == 1) {
    //     $addendumContracts->document_name_addendum = $data["document-name-addendum-menang"];
    // } else {
    // }
    $addendumContractDrafts->document_name_addendum = $data["document-name-addendum"];
    $addendumContractDrafts->id_document = $id_document;
    $addendumContractDrafts->id_addendum = $data["id-addendum"];
    $addendumContractDrafts->note_addendum = $data["note-addendum"];
    // $addendumContractDrafts->tender_menang = $is_tender_menang;
    if ($addendumContractDrafts->save()) {
        // Session::forget("pasals");
        moveFileTemp($file, $id_document);
        return Redirect::to("/contract-management/view/" . $data['id-contract'] . "/addendum-contract/$addendumContractDrafts->id_addendum")->with("success", "Your Draft Addendum Contract has been saved");
    }
    return Redirect::back()->with("error", "Your Draft Addendum Contract failed to save");
});

Route::post("/addendum-contract/draft/update", function (Request $request) {

    $data = $request->all();
    $addendumContractDrafts = AddendumContractDrafts::find($data["id-addendum-draft"]);
    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
        "date" => "This field must be date format only",
    ];
    $rules = [
        "attach-file-addendum" => "file",
        // "document-name-addendum-menang" => "required|string",
        "document-name-addendum" => "required|string",
        "note-addendum" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);
    $validation->validate();

    $file = $request->file("attach-file-addendum");

    if (isset($file)) {
        $faker = new Faker\Core\Uuid();
        $id_document = $faker->uuid3();
    }

    if ($validation->fails()) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        $request->old("note-addendum");
        $request->old("document-name-addendum");
        $request->old("document-name-addendum-menang");
        $request->old("attach-file-addendum");

        return Redirect::back()->with("error", "Please fill 'Addendum Contract' empty field");
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        dd("contract exist");
        $request->old("note-addendum");
        $request->old("document-name-addendum");
        $request->old("document-name-addendum-menang");
        $request->old("attach-file-addendum");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    if ($is_tender_menang == 1) {
        $rules["document-name-addendum-menang"] = "required|string";
        $addendumContractDrafts->document_name_addendum = $data["document-name-addendum-menang"];
    } else {
        $addendumContractDrafts->document_name_addendum = $data["document-name-addendum"] ?? $addendumContractDrafts->document_name_addendum;
    }
    $addendumContractDrafts->id_document = $id_document ?? $addendumContractDrafts->id_document;
    // $addendumContractDrafts->id_addendum = $data["id-addendum"];
    $addendumContractDrafts->note_addendum = $data["note-addendum"];
    // $addendumContractDrafts->tender_menang = $is_tender_menang;
    if ($addendumContractDrafts->save()) {
        // Session::forget("pasals");
        if (isset($file)) {
            moveFileTemp($file, $id_document);
        }
        return Redirect::to("/contract-management/view/" . $data['id-contract'] . "/addendum-contract/$addendumContractDrafts->id_addendum")->with("success", "Your Draft Addendum Contract has been updated");
    }
    return Redirect::back()->with("error", "Your Draft Addendum Contract failed to update");
});


Route::post("/review-contract/upload", function (Request $request, ReviewContracts $reviewContracts) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-review");
    $data = $request->all();
    // dd($data);
    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
    ];
    $rules = [
        "attach-file-review" => "required|file",
        "document-name-review" => "required|string",
        "note-review" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;

    $reviewContracts->document_name_review = $data["document-name-review"];
    $validation = Validator::make($data, $rules, $messages);
    if ($validation->fails()) {
        dd($validation->errors());
        return Redirect::back()->with("failed", "Failed to add Review Contract");
    }


    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }
    $validation->validate();

    $reviewContracts->id_document = $id_document;
    $reviewContracts->note_review = $data["note-review"];
    $reviewContracts->id_contract = $data["id-contract"];
    $reviewContracts->tender_menang = $is_tender_menang;

    if ($reviewContracts->save()) {
        moveFileTemp($file, $id_document);
        return redirect($_SERVER["HTTP_REFERER"])->with("success", "Your review contract has been added successful");
    }
    return redirect($_SERVER["HTTP_REFERER"])->with("failed", "Your review contract failed to add");
});

Route::post("/issue-project/upload", function (Request $request, IssueProjects $issueProjects) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-issue");
    $data = $request->all();

    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
    ];
    $rules = [
        "attach-file-issue" => "required|file",
        "document-name-issue" => "required|string",
        "note-issue" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);
    if ($validation->fails()) {
        dd($validation->errors());
        return Redirect::back()->with("failed", "Failed to add Review Contract");
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    $validation->validate();

    $issueProjects->document_name_issue = $data["document-name-issue"];
    $issueProjects->id_contract = $data["id-contract"];
    $issueProjects->id_document = $id_document;
    $issueProjects->note_issue = $data["note-issue"];
    $issueProjects->tender_menang = $is_tender_menang;
    if ($issueProjects->save()) {
        moveFileTemp($file, $id_document);
        return Redirect::back()->with("success", "Your issue have been added");
    }
    return redirect($_SERVER["HTTP_REFERER"])->with("failed", "Your issue failed added");
});

Route::post("/question/upload", function (Request $request, Questions $questions) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-question");
    $data = $request->all();

    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
    ];
    $rules = [
        "attach-file-question" => "required|file",
        "document-name-question" => "required|string",
        "note-question" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);

    if ($validation->fails()) {
        return Redirect::back()->with("failed", "Failed to add question");
        // dd($validation->errors());
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }
    $validation->validate();

    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;

    $questions->document_name_question = $data["document-name-question"];
    $questions->id_contract = $data["id-contract"];
    $questions->id_document = $id_document;
    $questions->note_question = $data["note-question"];
    $questions->tender_menang = $is_tender_menang;
    if ($questions->save()) {
        moveFileTemp($file, $id_document);
        return Redirect::back()->with("success", "Your question have been added");
    }
    return redirect($_SERVER["HTTP_REFERER"])->with("failed", "Your question failed to added");
});

Route::post("/input-risk/upload", function (Request $request, InputRisks $risk) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-risk");
    $data = $request->all();

    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "file" => "This field must be file only",
        "string" => "This field must be alphabet only",
    ];
    $rules = [
        "attach-file-risk" => "required|file",
        "document-name-risk" => "required|string",
        "note-risk" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);
    if ($validation->fails()) {
        return Redirect::back()->with("failed", "Failed to add Risk");
        // dd($validation->errors());
    }

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    $validation->validate();

    $risk->document_name_risk = $data["document-name-risk"];
    $risk->id_contract = $data["id-contract"];
    $risk->id_document = $id_document;
    $risk->note_risk = $data["note-risk"];
    $risk->tender_menang = $is_tender_menang;
    if ($risk->save()) {
        moveFileTemp($file, $id_document);
        return Redirect::back()->with("success", "Your Risk has been added");
    }
    return redirect($_SERVER["HTTP_REFERER"])->with("failed", "Your Risk failed to added");
});

Route::post("/laporan-bulanan/upload", function (Request $request, MonthlyReports $monthlyReports) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-bulanan");
    $data = $request->all();

    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "string" => "This field must be alphabet only",
        "file" => "This field must be file only",
    ];
    $rules = [
        "attach-file-bulanan" => "required|file",
        "document-name-bulanan" => "required|string",
        "note-bulanan" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);
    if ($validation->fails()) {
        return Redirect::back()->with("failed", "Failed to add Review Contract");
        // dd($validation->errors());
    }
    $validation->validate();

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $monthlyReports->id_contract = $data["id-contract"];
    $monthlyReports->id_document = $id_document;
    $monthlyReports->document_name_report = $data["document-name-bulanan"];
    $monthlyReports->note_report = $data["note-bulanan"];
    if ($monthlyReports->save()) {
        moveFileTemp($file, $id_document);
        return Redirect::back()->with("success", "Your Monthly Report has been added");
    }
    return redirect($_SERVER["HTTP_REFERER"])->with("failed", "Your Monthly Report failed to added");
});

Route::post("/serah-terima/upload", function (Request $request, HandOvers $handOver) {

    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-terima");
    $data = $request->all();

    $messages = [
        "required" => "This field is required",
        "numeric" => "This field must be numeric only",
        "string" => "This field must be alphabet only",
        "file" => "This field must be file only",
    ];
    $rules = [
        "attach-file-terima" => "required|file",
        "document-name-terima" => "required|string",
        "note-terima" => "required|string",
        "id-contract" => "required|numeric",
    ];
    $validation = Validator::make($data, $rules, $messages);
    if ($validation->fails()) {
        return Redirect::back()->with("failed", "Failed to add Serah Terima Kontrak");
        // dd($validation->errors());
    }
    $validation->validate();

    // Check ID Contract exist
    $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    if (empty($is_id_contract_exist)) {
        // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        return Redirect::back()->with("error", "Contract not exist");
    }

    $content_word_html = $data["content-word-terima"];
    $handOver->id_contract = $data["id-contract"];
    $handOver->id_document = $id_document;
    $handOver->document_name_terima = $data["document-name-terima"];
    $handOver->note_terima = $data["note-terima"];
    if ($handOver->save()) {
        moveFileTemp($file, $id_document);
        return Redirect::back()->with("success", "Your Handover has been added");
    }
    return Redirect::back()->with("failed", "Failed to add Serah Terima Kontrak");
});


Route::get("/document/view/{id}/{id_document}", function (Request $request) {
    $id_document = $request->id_document;
    $id = $request->id;
    // dd($request->id_document);
    $document_path = asset("/storage/words/" . $id_document . ".docx");
    return view("document", ["document" => $document_path, "id" => $id, "id_document" => $id_document]);
    // return view("document", ["document" => $document_path]);
});

Route::get("/document/view/{id}/{id_document}/history", function (Request $request) {
    $id_document = explode("_", $request->id_document)[0];
    $id_document = str_replace(".docx", "", $id_document);
    $id = $request->id;
    $files = Storage::disk("public/words")->allFiles();
    $file_documents = [];
    foreach ($files as $file) {
        if (str_contains($file, "_")) {
            $file_id = explode("_", $file)[0];
        } else {
            $file_id = str_replace(".docx", "", $file);
        }
        if ($file_id == $id_document) {
            // dump($file);
            array_push($file_documents, $file);
        }
    }
    // dd($file_documents);
    return view("document-history", ["files" => $file_documents, "id" => $id]);
});

Route::post('/pasal/clear', function (Request $request) {
    if (Session::has("pasals")) {
        Session::forget("pasals");
    }
    return response()->json([
        "status" => "success",
        "message" => "Pasal-pasal have been cleared",
    ]);
});

Route::post("/document/view/{id}/{id_document}/save", function (Request $request) {
    $id_document = $request->id_document;
    $id = $request->id;
    $tables = DB::select("SELECT table_name
    FROM information_schema.columns;");
    foreach ($tables as $table) {
        $table_name = $table->table_name;
        $columns = DB::select("SELECT column_name
        FROM information_schema.columns
       WHERE table_name  = '$table_name';");
        foreach ($columns as $column) {
            $column_name = $column->column_name;
            if ($column_name == "id_document") {
                $query = "SELECT * FROM $table_name WHERE $table_name.id_document = '$id_document';";
                $data = DB::selectOne($query);
                if (!empty($data)) {
                    $primary_column = array_keys(get_object_vars($data));
                    $docx_writer = writeDOCXFile($request->get("content_word"));
                    $counter = explode("_", $data->id_document);
                    if (empty($counter[1])) {
                        $file_name = trim($counter[0]) . "_2";
                        $docx_writer->save(public_path("storage/words/" . $file_name . ".docx"));
                    } else {
                        $num = (int) $counter[1] + 1;
                        $file_name = trim($counter[0]) . "_$num";
                        $docx_writer->save(public_path("storage/words/" . $file_name . ".docx"));
                    }
                    DB::update("UPDATE $table_name SET id_document = '$file_name' WHERE  $primary_column[0] = $id");
                    if ($table_name == "addendum_contract_drafts") {
                        $query = "SELECT * FROM addendum_contracts WHERE addendum_contracts.id_addendum = $data->id_addendum";
                        $addendumContract = DB::selectOne($query);
                        return response()->json([
                            "status" => "success",
                            "redirect" => url("/contract-management/view/$addendumContract->id_contract/addendum-contract/$addendumContract->id_addendum"),
                        ]);
                    }
                    return response()->json([
                        "status" => "success",
                        "redirect" => url("/contract-management/view/$data->id_contract"),
                    ]);
                }
            }
        }
    }
    return response()->json([
        "status" => "failed",
        "redirect" => url("/contract-management"),
    ]);
});

Route::post('/stage/save', function (Request $request) {
    $id = $request->id_contract;
    $contract_management = ContractManagements::find($id);
    $contract_management->stages = $request->stage;
    if ($contract_management->save()) {
        return response()->json([
            "status" => "success",
            "link" => true,
        ]);
    }
});

Route::post('/stage/addendum/save', function (Request $request) {
    if ($request->id_addendum == 0) {
        return response()->json([
            "status" => "failed",
            "msg" => "Update Stage Failed. Please make addendum first",
        ]);
    }
    $id = $request->id_addendum;
    $addendum_contract = AddendumContracts::find($id);
    if ($addendum_contract->stages == 2) {
        $addendum_contract->stages = 1;
    } else {
        $addendum_contract->stages = $request->stage;
    }
    if ($addendum_contract->save()) {
        return response()->json([
            "status" => "success",
            "msg" => "Update Stage Successful",
        ]);
    }
    return response()->json([
        "status" => "failed",
        "msg" => "Update Stage Failed",
    ]);
});

Route::post('/pasal/save', function (Request $request) {
    $data = $request->all();
    $pasalsPost = explode(",", $data["pasals"]);
    $pasals = [];
    foreach ($pasalsPost as $pasalPost) {
        $pasal = Pasals::find($pasalPost);
        if ($pasal instanceof Pasals) {
            array_push($pasals, $pasal);
        }
    }
    if (Session::has("pasals")) {
        Session::forget("pasals");
        Session::put("pasals", $pasals);
        return response()->json([
            "status" => "success",
            "message" => "Success to update pasal",
            "pasals" => json_encode(Session::get("pasals")),
        ]);
    } else {
        Session::put("pasals", $pasals);
    }

    if (Session::has("pasals")) {
        return response()->json([
            "status" => "success",
            "message" => "Success to add pasal",
            "pasals" => json_encode(Session::get("pasals")),
        ]);
    }
    return response()->json([
        "status" => "failed",
        "message" => "Failed to add pasal",
    ]);
});

Route::post('/pasal/add', function (Request $request, Pasals $pasals) {
    $pasal = $request->get("pasal");
    $pasals->pasal = $pasal;
    if ($pasals->save()) {
        return response()->json([
            "status" => "success",
            "message" => "Your pasal have been added",
            "pasals" => Pasals::all(),
        ]);
    }
    return response()->json([
        "status" => "failed",
        "message" => "Your pasal cannot be added",
    ]);
});

Route::post('/pasal/update', function (Request $request) {
    $pasal = $request->get("pasal");
    $id_pasal = $request->get("id_pasal");
    $pasals = Pasals::find($id_pasal);
    $pasals->pasal = $pasal;
    if ($pasals->save()) {
        return response()->json([
            "status" => "success",
            "message" => "Your pasal have been updated",
            "pasals" => Pasals::all(),
        ]);
    }
    return response()->json([
        "status" => "failed",
        "message" => "Your pasal cannot be updated",
    ]);
});

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
