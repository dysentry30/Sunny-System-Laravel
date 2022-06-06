<?php

// require_once "./vendor/autoload.php";
// require_once 'vendor/autoload.php';

use App\Models\Proyek;
use App\Models\Customer;
use Google\Service\Docs;
use Google\Service\Oauth2;
use Illuminate\Http\Request;
use App\Models\DraftContracts;
use App\Models\ProyekBerjalan;
use PhpOffice\PhpWord\PhpWord;
use App\Models\ProyekBerjalans;
use App\Models\ReviewContracts;
use Illuminate\Http\UploadedFile;
use Illuminate\support\Facades\DB;
use App\Models\ContractManagements;
use App\Models\CustomerAttachments;
use Illuminate\Support\Facades\URL;
use Google\Service\Drive\Permission;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DopController;
use App\Http\Controllers\SbuController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\SumberDanaController;
use Google\Service\CloudResourceManager\Project;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;


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



Route::get('/', [DashboardController::class, 'view']);


//Begin :: Customer

    // customer dashboard all database
    Route::get('/customer', [CustomerController::class, 'view']);



    // DELETE data customer pada dasboard customer by ID 
    Route::delete('customer/delete/{id_customer}', function ($id_customer) { 
        $id_customer = Customer::find($id_customer)->delete();
        return redirect("/customer")->with('status', 'Customer deleted');   
    });


    // view customer by id_customer #1
    Route::get('/customer/view/{id_customer}', function ($id_customer) {
        $customer = Customer::find($id_customer);
        // dd($customer->proyekBerjalans); //tes log hasil 
        return view('Customer/viewCustomer', [
            "customer" => $customer, 
            "customers" => Customer::all(),
            "attachment" => $customer->customerAttachments->all(),   
            "proyekberjalan" => $customer->proyekBerjalans->all(),
        ]);
    });



    // EDIT customer by view id_customer #2   
    Route::post('/customer/save-edit', function (
        Request $request, 
        Customer $editCustomer, 
        CustomerAttachments $customerAttachments) 
        {

        $data = $request->all(); 
        // dd($data); //tes log hasil $data 
        $editCustomer=Customer::find($data["id-customer"]);
        $editCustomer->name = $data["name-customer"];
        $editCustomer->check_customer = $request->has("check-customer"); //boolean check
        $editCustomer->check_partner = $request->has("check-partner"); //boolean check
        $editCustomer->check_competitor = $request->has("check-competitor"); //boolean check
        $editCustomer->address_1 = $data["AddressLine1"];
        $editCustomer->address_2 = $data["AddressLine2"];
        $editCustomer->email = $data["email"];
        $editCustomer->phone_number = $data["phone-number"];
        $editCustomer->website = $data["website"];

        // form company information
        $editCustomer->jenis_instansi = $data["jenis-instansi"];
        $editCustomer->kode_proyek = $data["kodeproyek-company"];
        $editCustomer->npwp_company = $data["npwp-company"];
        $editCustomer->kode_nasabah = $data["kodenasabah-company"];
        $editCustomer->journey_company = $data["journey-company"];
        $editCustomer->segmentation_company = $data["segmentation-company"];
        $editCustomer->name_pic = $data["name-pic"];
        $editCustomer->kode_pic = $data["kode-pic"];
        $editCustomer->email_pic = $data["email-pic"];
        $editCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form table performance
        $editCustomer->nilaiok = $data["nilaiok-performance"];
        $editCustomer->piutang = $data["piutang-performance"];
        $editCustomer->laba = $data["laba-performance"];
        $editCustomer->rugi = $data["rugi-performance"];

        // form attachment
        $editCustomer->note_attachment = $data["note-attachment"];
        $customerAttachments->id_customer=$data["id-customer"];
        $customerAttachments->name_customer=$data["name-customer"];
        
        
        
        if ($_FILES['doc-attachment']['size'] == 0)
        {
            // file is empty (and not an error)
            $editCustomer->save();
        }else{
            $editCustomer->save();
            $file_name = $request->file("doc-attachment")->getClientOriginalName();
            $customerAttachments->name_attachment = $file_name;
            $request->file("doc-attachment")->storeAs("public/CustomerAttachments", $file_name);
            $customerAttachments->save();
        }

        return redirect("/customer");
    }); 

    // NEW to Create New customer #1 
    Route::get('/customer/new', function () {
        return view('Customer/newCustomer');
    });


    // NEW to Create New customer #2
    Route::post('/customer/save', function (Request $request, Customer $newCustomer) {
        $data = $request->all(); 
        // dd($request); //console log hasil $data
        $newCustomer->name = $data["name-customer"];
        $newCustomer->check_customer = $request->has("check-customer"); //boolean check
        $newCustomer->check_partner = $request->has("check-partner"); //boolean check
        $newCustomer->check_competitor = $request->has("check-competitor"); //boolean check
        $newCustomer->address_1 = $data["AddressLine1"];
        $newCustomer->address_2 = $data["AddressLine2"];
        $newCustomer->email = $data["email"];
        $newCustomer->phone_number = $data["phone-number"];
        $newCustomer->website = $data["website"];

        // form company information
        $newCustomer->jenis_instansi = $data["jenis-instansi"];
        $newCustomer->kode_proyek = $data["kodeproyek-company"];
        $newCustomer->npwp_company = $data["npwp-company"];
        $newCustomer->kode_nasabah = $data["kodenasabah-company"];
        $newCustomer->journey_company = $data["journey-company"];
        $newCustomer->segmentation_company = $data["segmentation-company"];
        $newCustomer->name_pic = $data["name-pic"];
        $newCustomer->kode_pic = $data["kode-pic"];
        $newCustomer->email_pic = $data["email-pic"];
        $newCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form table performance
        $newCustomer->nilaiok = $data["nilaiok-performance"];
        $newCustomer->piutang = $data["piutang-performance"];
        $newCustomer->laba = $data["laba-performance"];
        $newCustomer->rugi = $data["rugi-performance"];
        
        // form attachment
        // $newCustomer->note_attachment = $data["note-attachment"];

        if ($newCustomer->save()) {
            return redirect("/customer")->with("success", true);
        }
    });

    // Edit MODAL by view id_customer    
    Route::post('/customer/save-modal', function (
        Request $request, 
        Customer $modalCustomer, 
        ProyekBerjalans $customerHistory) 
        {

        $data = $request->all(); 
        // dd($data); //tes log hasil $data 
        $modalCustomer=Customer::find($data["id-customer"]);
        $customerHistory->id_customer = $data["id-customer"];
        $customerHistory->nama_proyek = $data["nama-proyek"];
        $customerHistory->kode_proyek = $data["kode-proyek"];
        $customerHistory->pic_proyek = $data["pic-proyek"];
        $customerHistory->unit_kerja = $data["unit-kerja"];
        $customerHistory->jenis_proyek = $data["jenis-proyek"];
        $customerHistory->nilaiok_proyek = $data["nilaiok-proyek"];

        $modalCustomer->save();
        $customerHistory->save();
        return redirect("/customer");
            
    }); 
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

//End :: Project


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


// Begin :: Contract Management

    // Route::get('/contract-management', function () {
    //     return view('4_Contract', ["contracts" => ContractManagements::all()]);
    // });
    
    // Route::get('/contract-management/view', function () {
        //     return view('Contract/view');
        // });
        
        // Route::get('/contract-management/view/{id_contract}', function ($id_contract) {
            //     return view('Contract/view', ["contract" => ContractManagements::find($id_contract), "contracts" => ContractManagements::all()]);
            // });
            
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
    
    // function moveFileTemp(UploadedFile $file, $file_name)
    // {
        //     $result = $file->storeAs("public/words", $file_name . "." . $file->getClientOriginalExtension());
        //     return $result;
        // }
        
        // Route::get("/draft-contract/upload", function (Request $request) {
            //     $id_contract = $request->get("id-contract");
            //     getClient();
            //     return response()->redirectToRoute("contract-management/view/" . $id_contract);
            // });
            
            // Route::post("/draft-contract/upload", function (Request $request, DraftContracts $draftContracts) {
                //     $faker = new Faker\Core\Uuid();
                //     $file = $request->file("file");
                //     $id_contract = $request->get("id-contract");
                //     $file_name = $request->get("file-name");
                //     $draft_note = $request->get("draft-note");
                //     $is_tender_menang = $request->get("tender-menang");
                //     // $client = getClient();
                //     $draftContracts->id_document = $faker->uuid3();
                //     $draftContracts->draft_name = $file_name;
                //     $draftContracts->draft_note = $draft_note;
    //     $draftContracts->id_contract = $id_contract;
    //     $draftContracts->tender_menang = $is_tender_menang;
    //     $draftContracts->save();
    //     moveFileTemp($file, $draftContracts->id_document);
    //     // if ($client != null) {
    //     // $uploadedFile = insertFileToDrive($moveFile, $client, $id_contract);
    //     // print_r($uploadedFile);
    //     // insert data to database
    
    //     // }
    //     return response("Success");
    // });
    
    // Route::post("/draft-contract/upload", function (Request $request, ReviewContracts $reviewContracts) {
        //     $faker = new Faker\Core\Uuid();
        //     $file = $request->file("file");
        //     $id_contract = $request->get("id-contract");
        //     $file_name = $request->get("file-name");
        //     $draft_note = $request->get("draft-note");
        //     $is_tender_menang = $request->get("tender-menang");
        //     $reviewContracts->id_document = $faker->uuid3();
        //     $reviewContracts->draft_name = $file_name;
        //     $reviewContracts->draft_note = $draft_note;
        //     $reviewContracts->id_contract = $id_contract;
        //     $reviewContracts->tender_menang = $is_tender_menang;
        //     $reviewContracts->save();
        //     moveFileTemp($file, $reviewContracts->id_document);
        //     return response("Success");
        // });
        
        // function viewDocs($id_document)
        // {
            //     // $client = getClient();
            //     // if (isAuthorized($client)) {
                //     //     $document_view_link = "https://docs.google.com/document/d/$id_document/edit";
                //     //     $data = [
                    //     //         "link_document" => $document_view_link
                    //     //     ];
                    //     //     print_r(json_encode($data));
                    //     // }
                    //     // return $client;
                    // }
                    
                    // // function isAuthorized(Google\Client $client)
                    // // {
                        // //     if ($client->getAccessToken()) {
                            // //         return true;
                            // //     }
                            // //     return false;
                            // // }
                            
                            // function getPermissionFile(\Google\Client $client, $id_document)
                            // {
                                //     // $client = getClient();
                                //     // $client_info = new Google\Service\Oauth2($client);
                                //     // if ($client->getAccessToken()) {
                                    //     // print_r($client_info->userinfo->get());
                                    //     // }
                                    //     // $client->
                                    //     // $client->fetchAccessTokenWithAuthCode(Session::get("code"));
                                    //     // $client->addScope(Oauth2::USERINFO_EMAIL);
                                    //     // print_r($client_info->userinfo->get());
                                    //     // $role = "Editor";
                                    //     // if ($client->getAccessToken() && Session::get("code") != null) {
                                        //     // }
                                        //     // $user_email = $client_info->userinfo->get()->getEmail();
                                        //     // echo $user_email;
                                        // }
                                        
                                        // Route::get("/document/view/{id_document}", function (Request $request, $id_document) {
                                            //     // $words_content = \Phpof ;
                                            //     $document_path = asset("/storage/words/" . $id_document . ".docx");
                                            //     // $document_docx = \PhpOffice\PhpWord\IOFactory::load($document_path);
                                            //     // $docx_to_html  = new \PhpOffice\PhpWord\Writer\HTML($document_docx);
                                            //     // return view("document", ["document" => html_entity_decode(htmlspecialchars_decode($docx_to_html->getContent()))]);
                                            //     return view("document", ["document" => $document_path]);
                                            
                                            //     // $document_path = URL::to("/") . Storage::url("public/words/" . $id_document . ".docx");
                                            //     // dd($document_path);
                                            //     // return view("document", ["document_link" => $document_path]);
                                            // });
                                            
// End :: Contract Management