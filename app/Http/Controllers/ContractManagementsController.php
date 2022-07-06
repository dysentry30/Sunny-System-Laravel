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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class ContractManagementsController extends Controller
{

    public function index()
    {
        $contract_managements = ContractManagements::all();
        $sorted_contracts = $contract_managements->sortBy("contract_in");
        return view('4_Contract', ["contracts" => $sorted_contracts]);
    }


    public function new()
    {
        return view('Contract/view', ["contracts" => ContractManagements::all(), "projects" => Proyek::all()]);
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
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "date" => "This field must be date only",
            "before" => "Make sure 'Tanggal Mulai Kontrak' is before 'Tanggal Berakhir Kontrak'",
            "after" => "Make sure 'Tanggal Berakhir Kontrak' is after 'Tanggal Mulai Kontrak'",
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
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "date" => "This field must be date only",
            "before" => "Make sure 'Tanggal Mulai Kontrak' is before 'Tanggal Berakhir Kontrak'",
            "after" => "Make sure 'Tanggal Berakhir Kontrak' is after 'Tanggal Mulai Kontrak'",
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
        if ($contractManagements->update()) {
            Alert::error('Error', "Contract berhasil diperbarui");
            return redirect("/contract-management");
        }
        Alert::error('Error', "Contract ini gagal diperbarui");
        return redirect("/contract-management");
    }


    public function viewContract($id_contract)
    {
        if (Session::has("pasals")) {
            Session::forget("pasals");
        }
        return view('Contract/view', ["contract" => ContractManagements::find($id_contract), "projects" => Proyek::all(), "contracts" => ContractManagements::all()]);
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


    public function draftContractView($id_contract, DraftContracts $draftContracts)
    {

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
        $faker = new Uuid();
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
            // dd($validation->errors());
            Alert::error('Error', "Review Contract gagal diperbarui");
            return Redirect::back();
        }


        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
        }
        $validation->validate();

        $reviewContracts->id_document = $id_document;
        $reviewContracts->note_review = $data["note-review"];
        $reviewContracts->id_contract = $data["id-contract"];
        $reviewContracts->tender_menang = $is_tender_menang;

        if ($reviewContracts->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Review Contract berhasil dibuat");
            return redirect($_SERVER["HTTP_REFERER"]);
        }
        Alert::error('Error', "Review Contract gagal dibuat");
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Issue Project of Contract to server or database
    public function issueProjectUpload(Request $request, IssueProjects $issueProjects)
    {
        $faker = new Uuid();
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
            // dd($validation->errors());
            Alert::error('Error', "Issue Contract gagal dibuat");
            return Redirect::back();
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
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
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Questions of Contract to server or database
    public function questionUpload(Request $request, Questions $questions)
    {
        $faker = new Uuid();
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
            Alert::error('Error', "Question gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
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
            Alert::success('Success', "Question berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Question gagal ditambahkan");
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Risk of Contract to server or database
    public function riskUpload(Request $request, InputRisks $risk)
    {
        $faker = new Uuid();
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
            Alert::error('Error', "Risk gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
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
            Alert::success('Success', "Risk berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Risk gagal ditambahkan");
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Laporan Bulanan of Contract to server or database
    public function monthlyReportUpload(Request $request, MonthlyReports $monthlyReports)
    {
        $faker = new Uuid();
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
            Alert::error('Error', "Review Contract gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
        }

        $monthlyReports->id_contract = $data["id-contract"];
        $monthlyReports->id_document = $id_document;
        $monthlyReports->document_name_report = $data["document-name-bulanan"];
        $monthlyReports->note_report = $data["note-bulanan"];
        if ($monthlyReports->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Laporan Bulanan berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Laporan Bulanan gagal ditambahkan");
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Uplaod Serah Terima of Contract to server or database
    public function handOverUpload(Request $request, HandOvers $handOver)
    {
        $faker = new Uuid();
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
            return Redirect::back();
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
        return Redirect::back();
    }
}
