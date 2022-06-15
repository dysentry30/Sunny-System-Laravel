<?php

namespace App\Http\Controllers;

use App\Models\ContractManagements;
use App\Models\DraftContracts;
use Faker\Core\Uuid;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DraftContractController extends Controller
{
    
    // Upload Data to server or database

    /**
     * @param Request $request
     * @param DraftContracts $draftContracts
     * 
     * @return [Redirect]
     */
    public function save(Request $request, DraftContracts $draftContracts) {

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
        $faker = new Uuid();
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
    }
}
