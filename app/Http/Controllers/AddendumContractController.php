<?php

namespace App\Http\Controllers;

use App\Models\AddendumContractDrafts;
use App\Models\AddendumContracts;
use App\Models\ContractManagements;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AddendumContractController extends Controller
{
    // upload data addendum to server or database
    function upload(Request $request, AddendumContracts $addendumContracts) {

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
    }

    // Save Draft of Addendum to Server or Database
    function draftUpload(Request $request, AddendumContractDrafts $addendumContractDrafts) {

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
    
        $faker = new Uuid();
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
    }

    function draftUpdate(Request $request) {

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
            $faker = new Uuid();
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
    }
}
