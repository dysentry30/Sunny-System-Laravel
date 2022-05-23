<?php


use Illuminate\Support\Facades\Route;
use App\Models\ContractManagements;
use App\Models\DraftContracts;
use App\Models\InputRisks;
use App\Models\IssueProjects;
use App\Models\MonthlyReports;
use App\Models\Questions;
use App\Models\ReviewContracts;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;

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

Route::get('/customer', function () {
    return view('2_Customer');
});

Route::get('/contract-management', function () {
    return view('4_Contract', ["contracts" => ContractManagements::all()]);
});

Route::get('/contract-management/view', function () {
    return view('Contract/view', ["contracts" => ContractManagements::all()]);
});

Route::post('/contract-management/save', function (Request $request, ContractManagements $contractManagements) {
    $data = $request->all();
    $contractManagements->id_contract = (int) $data["number-contract"];
    $contractManagements->project_id = (int) $data["project-id"];
    $contractManagements->contract_proceed = "Belum Selesai";
    $contractManagements->contract_in = new DateTime($data["start-date"]);
    $contractManagements->contract_out = new DateTime($data["due-date"]);
    $contractManagements->number_spk = (int) $data["number-spk"];
    $contractManagements->value = (int) str_replace(",", "", $data["value"]);
    if ($contractManagements->save()) {
        // echo "sukses";
        return redirect("/contract-management")->with("success", true);
    }
    return redirect("/contract-management");
    // return view('Contract/view');
});

Route::post('/contract-management/update', function (Request $request, ContractManagements $contractManagements) {
    $data = $request->all();
    $contractManagements->find($data["number-contract"]);
    // $contractManagements->id_contract = (int) $data["number-contract"];
    $contractManagements->project_id = (int) $data["project-id"];
    $contractManagements->contract_proceed = "Belum Selesai";
    $contractManagements->contract_in = new DateTime($data["start-date"]);
    $contractManagements->contract_out = new DateTime($data["due-date"]);
    $contractManagements->number_spk = (int) $data["number-spk"];
    $contractManagements->value = (int) str_replace(",", "", $data["value"]);
    $contractManagements->update();
    return redirect("/contract-management");
});

Route::get('/contract-management/view/{id_contract}', function ($id_contract) {
    return view('Contract/view', ["contract" => ContractManagements::find($id_contract), "contracts" => ContractManagements::all()]);
});

Route::post("/contract-management/save/{id_contract}", function (Request $request, $id_contract) {
    $contract_management = ContractManagements::find($id_contract);
    $contract_management->id_contract = $request->number_contract;
    $contract_management->project_name = $request->project_name;
    $contract_management->contract_in = $request->start_date;
    $contract_management->contract_out = $request->due_date;
    $contract_management->value = $request->value_contract;

    if ($contract_management->save()) {
        return response(json_encode([
            "status" => "Success",
            "message" => "Kontrak ini berhasil disimpan",
        ]), 200, [
            "content-type" => "application/json"
        ]);
    }
    return response(json_encode([
        "status" => "Failed",
        "message" => "Kontrak ini gagal disimpan",
    ]), 200, [
        "content-type" => "application/json"
    ]);

    // $contract_management->num = $request->number_contract;
});


// function getClient()
// {
//     global $request;
//     $client = new \Google\Client();
//     // $credentials = json_encode([
//     //     "CLIENT_ID" => getenv("GOOGLE_CLIENT_ID"),
//     //     "CLIENT_SECRET_PATH" => getenv("GOOGLE_CLIENT_SECRET"),
//     // ]);

//     $client->setApplicationName('Sunny System');

//     $client->setScopes([DOCS::DOCUMENTS, DOCS::DRIVE]);
//     $client->addScope([Oauth2::USERINFO_EMAIL, Oauth2::USERINFO_PROFILE]);

//     $client->setAccessType('online');

//     $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"];
//     $client->setRedirectUri($redirect_uri);

//     $client->setAuthConfig(
//         ["web" => [
//             "client_id" => getenv("GOOGLE_CLIENT_ID"),
//             "project_id" => getenv("PROJECT_ID"),
//             "auth_uri" => getenv("AUTH_URI"),
//             "token_uri" => getenv("TOKEN_URI"),
//             "auth_provider_x509_cert_url" => getenv("AUTH_PROVIDER_X509_CERT_URL"),
//             "client_secret" => getenv("GOOGLE_CLIENT_SECRET"),
//             // "redirect_uris" => getenv("GOOGLE_REDIRECT_URIS"),
//         ]]
//     );
//     if (isset($_GET['code'])) {
//         $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//         $client->setAccessToken($token);

//         // store in the session also
//         $request->session()->put('upload_token', $token);
//         header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
//     }

//     // set the access token as part of the client
//     if (!empty($request->session()->get('upload_token'))) {
//         $client->setAccessToken($request->session()->get('upload_token'));
//         if ($client->isAccessTokenExpired()) {
//             $request->session()->remove('upload_token');
//         }
//     } else {
//         $authUrl = $client->createAuthUrl();
//         $data = [
//             "status" => "Login Required",
//             "link" => $authUrl,
//         ];
//         // return redirect($data["link"]);
//         print_r(json_encode($data));
//         return $client;
//         // return response("", 200, []);
//     }
//     return $client;
// }

// function insertFileToDrive($file_name, $client, $id_contract)
// {
//     if ($client->getAccessToken()) {
//         $service_drive = new \Google\Service\Drive($client);
//         // $service_docs = new \Google\Service\Docs($client);
//         $file_drive = new \Google\Service\Drive\DriveFile();
//         $original_file_name = explode("/", $file_name);
//         $file_drive->setName($original_file_name[count($original_file_name) - 1]);
//         $permissions = new Permission();
//         // $file_drive->setPermissions($permissions->set)
//         $result = $service_drive->files->create($file_drive, [
//             'data' => file_get_contents(Storage::path($file_name)),
//             'mimeType' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
//             'uploadType' => 'media'
//         ]);
//         // print_r($result);
//         return $result;
//     }
// }

function moveFileTemp(UploadedFile $file, $file_name)
{
    $result = $file->storeAs("public/words", $file_name . "." . $file->getClientOriginalExtension());
    return $result;
}


Route::post("/draft-contract/upload", function (Request $request, DraftContracts $draftContracts) {
    $faker = new Faker\Core\Uuid();
    $id_document = $faker->uuid3();
    $file = $request->file("attach-file-draft");
    $data = $request->all();
    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    if ($is_tender_menang == 1) {
        $draftContracts->draft_name = $data["document-name-draft-menang"];
    } else {
        $draftContracts->draft_name = $data["document-name-draft"];
    }
    $draftContracts->id_document = $id_document;
    $draftContracts->draft_note = $data["note-draft"];
    $draftContracts->id_contract = $data["id-contract"];
    $draftContracts->tender_menang = $is_tender_menang;
    $draftContracts->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
});

Route::post("/review-contract/upload", function (Request $request, ReviewContracts $reviewContracts) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-review");
    $data = $request->all();
    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    if ($is_tender_menang == 1) {
        $reviewContracts->document_name_review = $data["document-name-review-menang"];
    } else {
        $reviewContracts->document_name_review = $data["document-name-review"];
    }
    $reviewContracts->id_document = $id_document;
    $reviewContracts->note_review = $data["note-review"];
    $reviewContracts->id_contract = $data["id-contract-review"];
    $reviewContracts->tender_menang = $is_tender_menang;
    $reviewContracts->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
});

Route::post("/issue-project/upload", function (Request $request, IssueProjects $issueProjects) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-issue");
    $data = $request->all();
    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    if ($is_tender_menang == 1) {
        $issueProjects->document_name_issue = $data["document-name-issue-menang"];
    } else {
        $issueProjects->document_name_issue = $data["document-name-issue"];
    }
    $issueProjects->id_contract = $data["id-contract"];
    $issueProjects->id_document = $id_document;
    $issueProjects->note_issue = $data["note-issue"];
    $issueProjects->tender_menang = $is_tender_menang;
    $issueProjects->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
});

Route::post("/question/upload", function (Request $request, Questions $questions) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-question");
    $data = $request->all();
    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    if ($is_tender_menang == 1) {
        $questions->document_name_question = $data["document-name-question-menang"];
    } else {
        $questions->document_name_question = $data["document-name-question"];
    }
    $questions->id_contract = $data["id-contract"];
    $questions->id_document = $id_document;
    $questions->note_question = $data["note-question"];
    $questions->tender_menang = $is_tender_menang;
    $questions->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
});

Route::post("/input-risk/upload", function (Request $request, InputRisks $risk) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-risk");
    $data = $request->all();
    $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    if ($is_tender_menang == 1) {
        $risk->document_name_risk = $data["document-name-risk-menang"];
    } else {
        $risk->document_name_risk = $data["document-name-risk"];
    }
    $risk->id_contract = $data["id-contract"];
    $risk->id_document = $id_document;
    $risk->note_risk = $data["note-risk"];
    $risk->tender_menang = $is_tender_menang;
    $risk->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
});

Route::post("/laporan-bulanan/upload", function (Request $request, MonthlyReports $monthlyReports) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-bulanan");
    $data = $request->all();
    $monthlyReports->id_contract = $data["id-contract"];
    $monthlyReports->id_document = $id_document;
    $monthlyReports->document_name_report = $data["document-name-bulanan"];
    $monthlyReports->note_report = $data["note-bulanan"];
    $monthlyReports->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
});

Route::post("/serah-terima/upload", function (Request $request, MonthlyReports $monthlyReports) {
    $faker = new Faker\Core\Uuid();
    $id_document = (string) $faker->uuid3();
    $file = $request->file("attach-file-terima");
    $data = $request->all();
    $monthlyReports->id_contract = $data["id-contract"];
    $monthlyReports->id_document = $id_document;
    $monthlyReports->document_name_report = $data["document-name-terima"];
    $monthlyReports->note_report = $data["note-terima"];
    $monthlyReports->save();
    moveFileTemp($file, $id_document);
    return redirect($_SERVER["HTTP_REFERER"]);
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
    $id = $request->id;
    $files = Storage::disk("public/words")->allFiles();
    $file_documents = [];
    foreach ($files as $file) {
        if (str_contains($file, "_")) {
            $file_id = explode("_", $file)[0];
        } else {
            $file_id = $file;
        }
        if ($file_id == $id_document) {
            // dump($file);
            array_push($file_documents, str_replace(".docx", "", $file));
        }
    }
    return view("document-history", ["files" => $file_documents, "id" => $id]);
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
                $data = DB::selectOne("SELECT * FROM $table_name WHERE $table_name.id_document = '$id_document';");
                if (!empty($data)) {
                    $primary_column = array_keys(get_object_vars($data));
                    $php_word = new PhpWord();
                    $section = $php_word->addSection();
                    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $request->get("content_word"));
                    $docx_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word);
                    $counter = explode("_", $data->id_document);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                    header("Content-Disposition: attachment;filename=$id_document.docx");
                    if (empty($counter[1])) {
                        $file_name = $counter[0] . "_2";
                        $docx_writer->save(public_path("storage/words/" . $file_name . ".docx"));
                        DB::update("UPDATE $table_name SET id_document = '$file_name' WHERE  $primary_column[0] = $id");
                    } else {
                        $num = (int) $counter[1] + 1;
                        $file_name = $counter[0] . "_$num";
                        $docx_writer->save(public_path("storage/words/" . $file_name . ".docx"));
                        DB::update("UPDATE $table_name SET id_document = '$file_name' WHERE $primary_column[0] = $id");
                    }
                    return response()->json([
                        "status" => "success",
                        "redirect" => url("/contract-management/view/$data->id_contract"),
                    ]);
                }
            }
        }
    }
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
