<?php

namespace App\Http\Controllers;

use DateTime;
use Faker\Core\Uuid;
use App\Models\Pasals;
use App\Models\Proyek;
use App\Models\HandOvers;
use App\Models\Questions;
use App\Models\InputRisks;
use App\Models\ClaimDetails;
use Illuminate\Http\Request;
use App\Models\IssueProjects;
use App\Models\DraftContracts;
use App\Models\MonthlyReports;
use App\Models\ReviewContracts;
use App\Models\ClaimManagements;
use App\Models\AddendumContracts;
use App\Models\ContractManagements;
use App\Models\AddendumContractDrafts;
use App\Models\DokumenPendukung;
use App\Models\KlarifikasiNegosiasiCda;
use App\Models\KontrakBertandatangan;
use App\Models\MomKickOffMeeting;
use App\Models\PendingIssue;
use App\Models\PerjanjianKso;
use App\Models\RencanKerjaManajemenKontrak;
use App\Models\ReviewPembatalanKontrak;
use App\Models\UsulanPerubahanDraft;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContractManagementsController extends Controller
{

    public function index()
    {
        // $contract_managements = ContractManagements::all();
        // $sorted_contracts = $contract_managements->sortBy("contract_in");
        // return view('4_Contract', ["contracts" => $sorted_contracts]);
        if (Auth::user()->check_administrator) {
            // $proyeks = Proyek::all()->where("stage", ">", 7)->where("nomor_terkontrak", "!=", "");
            // $proyeks = DB::table("proyeks as p")->select("p.*")->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("p.stage", ">", 7)->where("p.nomor_terkontrak", "!=", "")->where("c.stages", "<", 3)->get()->sortBy("p.kode_proyek");
            $proyeks_terkontrak = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("c.stages", "<", 3)->get()->sortBy("p.kode_proyek")->map(function ($data) {
                return self::stdClassToModel($data, Proyek::class);
            })->whereNotNull("nomor_terkontrak");
            $proyeks_tender_awal = Proyek::all()->where("stage", "<", 5);
            $proyeks_pelaksanaan_serah_terima = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->whereBetween("c.stages", [3, 4], "or")->get()->map(function ($data) {
                return self::stdClassToModel($data, Proyek::class);
            });

            $proyeks_pelaksanaan_closing_proyek = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("c.stages", 5)->get()->map(function ($data) {
                return self::stdClassToModel($data, Proyek::class);
            });
        } else {
            // $proyeks = Proyek::join()where("unit_kerja", "=", Auth::user()->unit_kerja)->where("stage", ">", 7)->where("nomor_terkontrak", "!=", "")->get()->sortBy("kode_proyek");
            $proyeks = DB::table("proyeks as p")->join("contract_managements as c", "c.kode_proyek", "=", "p.kode_proyek")->where("p.unit_kerja", "=", Auth::user()->unit_kerja)->where("stage", ">", 7)->where("p.nomor_terkontrak", "!=", "")->where("c.stages", "<", 3)->get()->sortBy("kode_proyek");
        }
        // return view("4_Contract", compact(["proyeks"]));
        return view("4_Contract", compact(["proyeks_terkontrak", "proyeks_tender_awal", "proyeks_pelaksanaan_serah_terima", "proyeks_pelaksanaan_closing_proyek"]));
    }

    private function stdClassToModel($data, $instance)
    {
        // backup fillable
        $keys = array_keys(get_object_vars($data));
        $proyek = new $instance;
        $fillable = $proyek->getFillable();

        // set id and other fields you want to be filled
        $proyek->fillable($keys);

        // fill $proyek->attributes array
        $proyek->fill((array) $data);

        // fill $proyek->original array
        $proyek->syncOriginal();

        $proyek->exists = true;

        // restore fillable
        $proyek->fillable($fillable);

        return $proyek;
    }

    public function new()
    {
        if (Auth::user()->check_administrator) {
            $proyeks_filtered = Proyek::all();
        } else {
            $proyeks_filtered = Proyek::all()->filter(function ($proyek) {
                return $proyek->stage == 6 || $proyek->stage == 8 || $proyek->unit_kerja == Auth::user()->unit_kerja;
            });
        }
        return view('Contract/view', ["projects" => $proyeks_filtered]);
    }

    function deleteModelArray(Collection $model, $child = false, string $childColllection = null)
    {
        if ($child && !empty($childColllection)) {
            $model->each(function ($draft) use ($childColllection) {
                $childColllection::where("id_claim", "=", $draft->id_claim)->get()->each(function ($dataChild) {
                    Storage::disk("public/words")->delete($dataChild->id_document . ".docx");
                    $dataChild->delete();
                });
                Storage::disk("public/words")->delete($draft->id_document . ".docx");
                $draft->delete();
            });
        } else {
            $model->each(function ($draft) {
                Storage::disk("public/words")->delete($draft->id_document . ".docx");
                $draft->delete();
            });
        }
    }

    public function delete(ContractManagements $contractManagement)
    {
        $draftContracts = DraftContracts::where("id_contract", "=", $contractManagement->id_contract)->get();
        $reviewContracts = ReviewContracts::where("id_contract", "=", $contractManagement->id_contract)->get();
        $addendumContract = AddendumContracts::where("id_contract", "=", $contractManagement->id_contract)->get();
        $claimManagements = ClaimManagements::where("id_contract", "=", $contractManagement->id_contract)->get();
        $handOver = HandOvers::where("id_contract", "=", $contractManagement->id_contract)->get();
        $inputRisks = InputRisks::where("id_contract", "=", $contractManagement->id_contract)->get();
        $issueProjects = IssueProjects::where("id_contract", "=", $contractManagement->id_contract)->get();
        $monthlyReports = MonthlyReports::where("id_contract", "=", $contractManagement->id_contract)->get();
        $questions = Questions::where("id_contract", "=", $contractManagement->id_contract)->get();

        Alert::success('Delete', $contractManagement->id_contract . ", Berhasil Dihapus");

        if (!empty($draftContracts)) {
            $this->deleteModelArray($draftContracts);
        }
        if (!empty($reviewContracts)) {
            $this->deleteModelArray($reviewContracts);
        }
        if (!empty($addendumContract)) {
            $this->deleteModelArray($addendumContract);
        }
        if (!empty($claimManagements)) {
            $this->deleteModelArray($claimManagements, true, ClaimDetails::class);
        }
        if (!empty($handOver)) {
            $this->deleteModelArray($handOver);
        }
        if (!empty($inputRisks)) {
            $this->deleteModelArray($inputRisks);
        }
        if (!empty($issueProjects)) {
            $this->deleteModelArray($issueProjects);
        }
        if (!empty($monthlyReports)) {
            $this->deleteModelArray($monthlyReports);
        }
        if (!empty($questions)) {
            $this->deleteModelArray($questions);
        }

        if ($contractManagement->delete()) {
            Alert::success("Success", "Contract berhasil dihapus");
            return redirect()->back();
        }
        Alert::Error("Failed", "Contract gagal dihapus");
        return redirect()->back();
    }

    public function save(Request $request, ContractManagements $contractManagements)
    {
        $data = $request->all();
        $proyek = Proyek::find($data["project-id"]);

        if ($proyek->stage < 7) {
            Alert::html('Erorr', 'Pastikan proyek sudah <b>Terkontrak</b>', 'Error');
            return redirect()->back();
        } else if (!empty($proyek->ContractManagements)) {
            Alert::html('Erorr', 'Pastikan proyek belum memiliki Kontrak', 'Error');
            return redirect()->back();
        }
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus tanggal",
            "before" => "Pastikan 'Tanggal Mulai Kontrak' ditentukan sebelum 'Tanggal Berakhir Kontrak'",
            "after" => "Pastikan 'Tanggal Berakhir Kontrak' ditentukan sesudah 'Tanggal Mulai Kontrak'",
        ];
        $rules = [
            "number-contract" => "required|numeric",
            "project-id" => "required|string",
            "start-date" => "required|date|before:due-date",
            "due-date" => "required|date|after:start-date",
            "value" => "required",
            "number-spk" => "required|numeric",
        ];

        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("number-contract");
            $request->old("project-id");
            $request->old("start-date");
            $request->old("due-date");
            $request->old("value");
            $request->old("number-spk");
            $validation->validate();
            Alert::error("Error", "Contract gagal ditambahkan");
            return redirect()->back();
        }

        // begin:: check if id contract exist and has same project id
        $is_contract_exist = ContractManagements::where("id_contract", "=", (int) $data["number-contract"])->orWhere("project_id", "=", $data["project-id"])->get()->first();
        if (!empty($is_contract_exist)) {
            $request->old("number-contract");
            $request->old("project-id");
            $request->old("start-date");
            $request->old("due-date");
            $request->old("value");
            $request->old("number-spk");
            $validation->validate();
            Alert::error("Error", "Nomor Kontrak atau Proyek sudah ada, Pastikan Proyek tidak melebihi dari 2 kontrak");
            return redirect()->back();
        }
        // end:: check if id contract exist and has same project id


        $contractManagements->id_contract = (int) $data["number-contract"];
        $contractManagements->project_id = $data["project-id"];
        $contractManagements->contract_proceed = "Belum Selesai";
        $contractManagements->contract_in = new DateTime($data["start-date"]);
        $contractManagements->contract_out = new DateTime($data["due-date"]);
        $contractManagements->number_spk = (int) $data["number-spk"];
        $contractManagements->stages = (int) 1;
        $contractManagements->value = (int) preg_replace("/[^0-9]/i", "", $data["value"]);
        $contractManagements->value_review = 0;

        Alert::success('Success', $data["number-contract"] . ", Berhasil Ditambahkan");
        if ($contractManagements->save()) {
            // echo "sukses";
            return redirect("/contract-management");
        }
        return redirect("/contract-management");
        // return view('Contract/view');
    }


    public function update(Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus tanggal",
            "before" => "Pastikan 'Tanggal Mulai Kontrak' ditentukan sebelum 'Tanggal Berakhir Kontrak'",
            "after" => "Pastikan 'Tanggal Berakhir Kontrak' ditentukan sesudah 'Tanggal Mulai Kontrak'",
        ];
        $rules = [
            "number-contract" => "required|numeric",
            "project-id" => "required|string",
            "start-date" => "required|date|before:due-date",
            "due-date" => "required|date|after:start-date",
            "value" => "required",
            "number-spk" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Contract ini gagal diperbarui");
            return redirect()->back();
        }
        $validation->validate();
        $contractManagements = ContractManagements::find($data["number-contract"]);
        // dd($data);
        $contractManagements->project_id = $data["project-id"];
        // $contractManagements->contract_proceed = "Belum Selesai";
        $contractManagements->contract_in = new DateTime($data["start-date"]);
        $contractManagements->contract_out = new DateTime($data["due-date"]);
        $contractManagements->number_spk = (int) $data["number-spk"];
        $contractManagements->value = (int) str_replace(",", "", $data["value"]);
        $contractManagements->value_review = (int) str_replace(",", "", $data["value-review"]);
        if ($contractManagements->save()) {
            Alert::success('Success', "Contract berhasil diperbarui");
            return redirect()->back();
            // return redirect("/contract-management");
        }
        Alert::error('Error', "Contract ini gagal diperbarui");
        return redirect()->back();
        // return redirect("/contract-management");
    }


    public function viewContract($id_contract)
    {
        if (Session::has("pasals")) {
            Session::forget("pasals");
        }

        $draftContracts = DraftContracts::join("contract_managements as c", "draft_contracts.id_contract", "=", "c.id_contract")->select("draft_contracts.*")->get();
        $review_contracts = ReviewContracts::join("draft_contracts as d", "review_contracts.id_draft_contract", "=", "d.id_draft")->select("review_contracts.*")->get();
        $projects = Proyek::all();
        return view('Contract/view', ["contract" => ContractManagements::find($id_contract), "draftContracts" => $draftContracts, "review_contracts" => $review_contracts, "projects" => $projects]);
    }


    public function tenderMenang($id_contract)
    {
        $is_tender_menang = true;
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract, "is_tender_menang" => $is_tender_menang]);
    }


    public function draftContract($id_contract)
    {
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract]);
    }


    public function addendumContract($id_contract)
    {
        return view("addendumContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract]);
    }


    public function addendumNew($id_contract, AddendumContracts $addendumContract)
    {
        return view("addendumContract/new", ["contract" => ContractManagements::find($id_contract), "id_contract" => $id_contract, "addendumContract" => $addendumContract]);
    }


    public function addendumView($id_contract, AddendumContracts $addendumContract)
    {
        $id_pasals = explode(",", $addendumContract->pasals);
        $res_pasals = [];
        foreach ($id_pasals as $id_pasal) {
            $get_pasal = Pasals::find($id_pasal);
            if ($get_pasal instanceof Pasals) {
                array_push($res_pasals, $get_pasal);
            }
        }
        if (!Session::has("pasals")) {
            Session::put("pasals", $res_pasals);
        }
        return view("addendumContract/view", ["addendumContract" => $addendumContract, "pasals" => Pasals::all(), "pasalsContract" => $res_pasals, "id_contract" => $id_contract]);
    }


    public function addendumDraft($id_contract, AddendumContracts $addendumContract, AddendumContractDrafts $addendumDraft)
    {
        return view("addendumContract/new", ["addendumContract" => $addendumContract, "id_contract" => $id_contract, "addendumDraft" => $addendumDraft]);
    }


    public function draftContractView($id_contract, DraftContracts $draftContracts, Request $request)
    {

        if ($request->ajax()) {
            $pasals = collect();
            $draft_pasals = collect(explode(",", $draftContracts->pasals));
            foreach ($draft_pasals as $pasal) {
                $pasal_model = Pasals::find($pasal);
                if (empty($pasal_model)) {
                    $pasals->push($pasal);
                } else {
                    $pasals->push(($pasal_model->pasal));
                }
            }
            return response()->json($pasals);
        }
        if (!$draftContracts instanceof DraftContracts) {
            $is_tender_menang = true;
            return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract, "is_tender_menang" => $is_tender_menang]);
        }


        $id_pasals = explode(",", $draftContracts->pasals);
        $res_pasals = [];
        foreach ($id_pasals as $id_pasal) {
            $get_pasal = Pasals::find($id_pasal);
            if ($get_pasal instanceof Pasals) {
                array_push($res_pasals, $get_pasal);
            } else {
                array_push($res_pasals, $id_pasal);
            }
        }
        if (!Session::has("pasals")) {
            Session::put("pasals", $res_pasals);
        }
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "pasalsDraft" => $res_pasals, "id_contract" => $id_contract, "draftContract" => $draftContracts]);
    }

    // Upload Review of Contract to Server or Database
    public function reviewContractUpload(Request $request, ReviewContracts $reviewContracts)
    {
        // $faker = new Uuid();
        // $id_document = (string) $faker->uuid3();
        // $file = $request->file("attach-file-review");
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];

        $is_input_has_set = $data["ketentuan-review"] != null ||
            $data["id-draft-contract"] != null ||
            $data["id-contract"] != null;
        // $data["pic-cross-review"] != null ||
        // $data["catatan-review"] != null;

        // if(isset($data["upload-review"]) && !$is_input_has_set) {
        //     $rules = [
        //         "upload-review" => "required|file",
        //     ];
        // } else if(!isset($data["upload-review"]) && $is_input_has_set) {
        //     $rules = [
        //         "ketentuan-review" => "required|string",
        //         "sub-pasal-review" => "required|string",
        //         "uraian-penjelasan-review" => "required|string",
        //         "catatan-review" => "required|string",
        //         "pic-cross-review" => "required|numeric",
        //         "id-contract" => "required|numeric",
        //     ];
        // } else {
        //     Alert::error("Error", "Pilih salah satu untuk dijadikan masukan");
        //     return redirect()->back();
        // }

        // $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        $rules = [
            "ketentuan-review" => "required|string",
            // "sub-pasal-review" => "required|string",
            // "uraian-penjelasan-review" => "required|string",
            // "catatan-review" => "required|string",
            // "pic-cross-review" => "required|numeric",
            "id-contract" => "required|numeric",
            "id-draft-contract" => "required|numeric",
            "input-pasal" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            // dd($validation->errors());
            Alert::error('Error', "Review Contract gagal diperbarui");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }


        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
        }
        $validation->validate();

        if (isset($data["upload-review"]) && !$is_input_has_set) {
            // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            // $spreadsheet = $reader->load($data["upload-review"]);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($data["upload-review"]);
            $spreadsheet = $spreadsheet->getActiveSheet()->toArray();
            array_shift($spreadsheet);
            foreach ($spreadsheet as $data_excel) {
                $reviewContractsExcel = new ReviewContracts();
                $reviewContractsExcel->ketentuan = $data_excel[0];
                $reviewContractsExcel->stage = $data["stage"];
                $reviewContractsExcel->sub_pasal = $data_excel[1];
                $reviewContractsExcel->uraian = $data_excel[2];
                $reviewContractsExcel->pic_cross = $data_excel[3];
                $reviewContractsExcel->catatan = $data_excel[4];
                $reviewContractsExcel->id_contract = $is_id_contract_exist->id_contract;
                $reviewContractsExcel->save();
            }
            Alert::success("Success", "Data berhasil di import ");
            return redirect()->back();
            // moveFileTemp($file, $id_document);
        } else {
            $reviewContracts->stage = $data["stage"];
            $reviewContracts->ketentuan = $data["ketentuan-review"];
            $reviewContracts->id_draft_contract = $data["id-draft-contract"];
            $reviewContracts->id_contract = $data["id-contract"];
            $reviewContracts->pasal_perubahan = $data["input-pasal"];
            // $reviewContracts->sub_pasal = $data["sub-pasal-review"];
            // $reviewContracts->uraian = $data["uraian-penjelasan-review"];
            // $reviewContracts->pic_cross = $data["pic-cross-review"];
            // $reviewContracts->catatan = $data["catatan-review"];
        }

        if ($reviewContracts->save()) {
            Alert::success('Success', "Review Contract berhasil dibuat");
            return redirect($_SERVER["HTTP_REFERER"]);
        }
        Alert::error('Error', "Review Contract gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Issue Project of Contract to server or database
    public function issueProjectUpload(Request $request, IssueProjects $issueProjects)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-issue");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
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
            // dd($validation->errors());
            Alert::error('Error', "Issue Contract gagal dibuat");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
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
            Alert::success('Success', "Issue Contract berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::success('Success', "Issue Contract berhasil ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Questions of Contract to server or database
    public function questionUpload(Request $request, Questions $questions)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-question");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "attach-file-question" => "required|file",
            "document-name-question" => "required|string",
            "note-question" => "required|string",
            "kategori-Aanwitjzing" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Alert::error('Error', "Question gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;

        $questions->document_name_question = $data["document-name-question"];
        $questions->id_contract = $data["id-contract"];
        $questions->id_document = $id_document;
        $questions->kategori_question = $data["kategori-Aanwitjzing"];
        $questions->note_question = $data["note-question"];
        $questions->tender_menang = $is_tender_menang;
        if ($questions->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Question berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Question gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Risk of Contract to server or database
    public function riskUpload(Request $request, InputRisks $risk)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-risk");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "resiko" => "required|string",
            "penyebab" => "required|string",
            "dampak" => "required|string",
            "mitigasi" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Resiko gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
        }

        if (isset($data["stage"])) {
            $is_tender_menang = $data["stage"];
        } else {
            $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        }
        $validation->validate();

        $risk->resiko = $data["resiko"];
        $risk->id_contract = $data["id-contract"];
        $risk->stage = $is_tender_menang; // Kolom Tender Menang dialihfungsikan menjadi Stage
        $risk->penyebab = $data["penyebab"];
        $risk->dampak = $data["dampak"];
        $risk->mitigasi = $data["mitigasi"];
        if ($risk->save()) {
            // moveFileTemp($file, $id_document);
            Alert::success('Success', "Resiko berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Resiko gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Laporan Bulanan of Contract to server or database
    public function monthlyReportUpload(Request $request, MonthlyReports $monthlyReports)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-bulanan");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
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
            Alert::error('Error', "Review Contract gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        $monthlyReports->id_contract = $data["id-contract"];
        $monthlyReports->id_document = $id_document;
        $monthlyReports->document_name_report = $data["document-name-bulanan"];
        $monthlyReports->note_report = $data["note-bulanan"];
        if ($monthlyReports->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Laporan Bulanan berhasil ditambahkan");
            // return Redirect::back();
        }
        Alert::error('Error', "Laporan Bulanan gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Uplaod Serah Terima of Contract to server or database
    public function handOverUpload(Request $request, HandOvers $handOver)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-terima");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
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
            Alert::error('Error', "Serah Terima Kontrak gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        $content_word_html = $data["content-word-terima"];
        $handOver->id_contract = $data["id-contract"];
        $handOver->id_document = $id_document;
        $handOver->document_name_terima = $data["document-name-terima"];
        $handOver->note_terima = $data["note-terima"];
        if ($handOver->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Serah Terima Kontrak berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Serah Terima Kontrak gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return Redirect::back();
    }

    public function klarifikasiNegoUpload(Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Hasil Klarifikasi dan Negosiasi CDA gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return redirect()->back();
        }
        $file = $request->file("attach-file");
        $klarifikasi_model = new KlarifikasiNegosiasiCda();
        $klarifikasi_model->id_contract = $data["id-contract"];
        $klarifikasi_model->id_document = Str::uuid();
        $klarifikasi_model->document_name = $data["document-name"];
        $klarifikasi_model->created_by = auth()->user()->id;
        $klarifikasi_model->note = $data["note"];
        if ($klarifikasi_model->save()) {
            moveFileTemp($file, $klarifikasi_model->id_document);
            Alert::success("Success", "Hasil Klarifikasi dan Negosiasi CDA berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Hasil Klarifikasi dan Negosiasi CDA gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function kontrakTandaTanganUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Kontrak Tanda Tangan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new KontrakBertandatangan();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Kontrak Tanda Tangan berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Kontrak Tanda Tangan gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function reviewPembatalanKontrak(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Kontrak Tanda Tangan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new ReviewPembatalanKontrak();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Review Pembatalan Kontrak berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Review Pembatalan Kontrak gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function perjanjianKSO(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Perjanjian KSO gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new PerjanjianKso();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Perjanjian KSO berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Perjanjian KSO gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function dokumenPendukungUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Pendukung gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new DokumenPendukung();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Dokumen Pendukung berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Dokumen Pendukung gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function momMeeting(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "MoM Kick Off Meeting gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new MomKickOffMeeting();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "MoM Kick Off Meeting berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "MoM Kick Off Meeting gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function documentBastContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "dokumen-bast-1" => "required|file",
            "dokumen-bast-2" => "required|file",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokument Bast gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        $faker = new Uuid();
        $contract_managements = ContractManagements::find($data["id-contract"]);

        if (isset($data["dokumen-bast-1"])) {
            if (!empty($contract_managements->dokumen_bast_1)) {
                $get_dokumen = File::get(public_path("/words/$contract_managements->dokumen_bast_1.docx"));
                if (!empty($get_dokumen)) {
                    File::delete(public_path("/words/$contract_managements->dokumen_bast_1.docx"));
                }
            }
            $id_document = $faker->uuid3();
            $contract_managements->dokumen_bast_1 = $id_document;
            moveFileTemp($data["dokumen-bast-1"], $id_document);
        }

        if (isset($data["dokumen-bast-2"])) {
            if (!empty($contract_managements->dokumen_bast_2)) {
                $get_dokumen = File::get(public_path("/words/$contract_managements->dokumen_bast_2.docx"));
                if (!empty($get_dokumen)) {
                    File::delete(public_path("/words/$contract_managements->dokumen_bast_2.docx"));
                }
            }
            $id_document = $faker->uuid3();
            $contract_managements->dokumen_bast_2 = $id_document;
            moveFileTemp($data["dokumen-bast-2"], $id_document);
        }


        if ($contract_managements->save()) {
            Alert::success("Success", "Dokument Bast berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Dokument Bast gagal ditambahkan");
        return Redirect::back();
        // return redirect()->back();
    }

    public function baDefectContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "ba-defect" => "required",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "BA Defect gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $faker = new Uuid();
        if (count($data["ba-defect"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["ba-defect"] as $dokumen_ba_defect) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_ba_defect, $id_document);
            }
            $contract->list_dokumen_ba_defect = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["ba-defect"][0], $id_document);
            $contract->list_dokumen_ba_defect = $id_document;
        }

        if ($contract->save()) {
            Alert::success("Success", "BA Defect berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "BA Defect gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function dokumenPendukungContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "dokumen-pendukung" => "required",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "BA Defect gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        if (!empty($contract->dokumen_kontrak_dan_addendum)) {
            $list_dokumen_kontrak_dan_addendum = collect(explode(", ", $contract->dokumen_pendukung));
            foreach ($list_dokumen_kontrak_dan_addendum as $dokumen) {
                $get_dokumen = File::get(public_path("/words/$dokumen.docx"));
                if (!empty($get_dokumen)) {
                    File::delete(public_path("/words/$dokumen.docx"));
                }
            }
        }

        $faker = new Uuid();
        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
            $contract->dokumen_pendukung = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $contract->dokumen_pendukung = $id_document;
        }

        if ($contract->save()) {
            Alert::success("Success", "Dokumen berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Dokumen gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function pendingIssueContractUpload(Request $request, PendingIssue $pendingIssue)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "status" => "required",
            "biaya" => "required",
            "waktu" => "required",
            "ancaman" => "required",
            "peluang" => "required",
            "rencana-tindak-lanjut" => "required",
            "target-waktu-penyelesaian" => "required",
            "id-contract" => "required",
            "penyebab" => "required",
        ];
        if (isset($data["pending-issue-file"])) {
            $rules["pending-issue-file"] = "required|file";
        } else {
            $rules["pending-issue"] = "required";
        }
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Pending Issue gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $faker = new Uuid();
        if (isset($data["pending-issue-file"])) {
            $id_document = $faker->uuid3();
            moveFileTemp($data["pending-issue-file"], $id_document);
            $pendingIssue->issue = $id_document;
        } else {
            $pendingIssue->issue = $data["pending-issue"];
        }


        $pendingIssue->status = (bool) $data["status"];
        $pendingIssue->id_contract = $contract->id_contract;
        $pendingIssue->penyebab = $data["penyebab"];
        $pendingIssue->biaya = (int) str_replace(",", "", $data["biaya"]);
        $pendingIssue->waktu = $data["waktu"];
        $pendingIssue->mutu = $data["mutu"];
        $pendingIssue->ancaman = $data["ancaman"];
        $pendingIssue->peluang = $data["peluang"];
        $pendingIssue->rencana_tindak_lanjut = $data["rencana-tindak-lanjut"];
        $pendingIssue->target_waktu_penyelesaian = $data["target-waktu-penyelesaian"];
        if ($pendingIssue->save()) {
            Alert::success("Success", "Pending Issue berhasil ditambahkan");
            return Redirect::back();
            // return redirect()->back();
        }
        Alert::error("Erorr", "Pending Issue gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function penutupanProyekContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "kontrak-dan-addendum-file" => "required",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Kontrak dan Addendum gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
            // return redirect()->back();
        }

        $contract = ContractManagements::find($data["id-contract"]);
        $faker = new Uuid();

        if (!empty($contract->dokumen_kontrak_dan_addendum)) {
            $list_dokumen_kontrak_dan_addendum = collect(explode(",", $contract->dokumen_kontrak_dan_addendum));
            foreach ($list_dokumen_kontrak_dan_addendum as $dokumen) {
                $get_dokumen = File::get(public_path("/words/$dokumen.docx"));
                if (!empty($get_dokumen)) {
                    File::delete(public_path("/words/$dokumen.docx"));
                }
            }
        }

        if (count($data["kontrak-dan-addendum-file"]) > 1) {
            $list_id_document_kontrak_dan_addendum = [];
            foreach ($data["kontrak-dan-addendum-file"] as $dokumen) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_kontrak_dan_addendum, $id_document);
                moveFileTemp($dokumen, $id_document);
            }
            $contract->dokumen_kontrak_dan_addendum = join(",", $list_id_document_kontrak_dan_addendum);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["kontrak-dan-addendum-file"][0], $id_document);
            $contract->dokumen_kontrak_dan_addendum = $id_document;
        }

        if ($contract->save()) {
            Alert::success("Success", "Dokumen Kontrak dan Addendum berhasil ditambahkan");
            // return redirect()->back();
            return Redirect::back();
        }
        Alert::error("Error", "Dokumen Kontrak dan Addendum gagal ditambahkan");
        // return redirect()->back();
        return Redirect::back();
    }

    public function usulanPerubahanDraftContractUpload(Request $request, UsulanPerubahanDraft $usulanPerubahanDraft)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "kategori" => "required",
            "id-contract" => "required",
            "id-review-contract" => "required",
            "keterangan" => "required",
            "pasals" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Usulan Perubahan Draft gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
        }

        $pasals = collect($data["pasals"]);
        $pasals = $pasals->join("|");

        $usulanPerubahanDraft->id_contract = $contract->id_contract;
        $usulanPerubahanDraft->id_review_draft = $data["id-review-contract"];
        $usulanPerubahanDraft->kategori = $data["kategori"];
        $usulanPerubahanDraft->keterangan = $data["keterangan"];
        $usulanPerubahanDraft->pasal_perbaikan = $pasals;
        if ($usulanPerubahanDraft->save()) {
            Alert::success("Success", "Usulan Perubahan Draft berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Usulan Perubahan Draft gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
    }

    public function rencanaKerjaManajemenContractUpload(Request $request, RencanKerjaManajemenKontrak $rencanKerjaManajemenKontrak)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "ketentuan-rencana-kerja" => "required",
            "id-contract" => "required",
            "kelengkapan-adkon" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Rencana Kerja Manajemen Kontrak gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $rencanKerjaManajemenKontrak->id_contract = $contract->id_contract;
        $rencanKerjaManajemenKontrak->ketentuan_rencana_kerja = $data["ketentuan-rencana-kerja"];
        $rencanKerjaManajemenKontrak->informasi_lengkap_adkon = $data["kelengkapan-adkon"];
        if ($rencanKerjaManajemenKontrak->save()) {
            Alert::success("Success", "Rencana Kerja Manajemen Kontrak berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Rencana Kerja Manajemen Kontrak gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }
}
