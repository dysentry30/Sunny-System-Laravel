<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Pasals;
use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Models\DraftContracts;
use App\Models\AddendumContracts;
use App\Models\ContractManagements;
use App\Models\AddendumContractDrafts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContractManagementsController extends Controller
{
    
    public function index () 
    {
        $contract_managements = ContractManagements::all();
        $sorted_contracts = $contract_managements->sortBy("contract_in");
        return view('4_Contract', ["contracts" => $sorted_contracts]);
    }

   
    public function new () 
    {
        return view('Contract/view', ["contracts" => ContractManagements::all(), "projects" => Proyek::all()]);
    }


     
    public function save (Request $request, ContractManagements $contractManagements)
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
                dd($validation->errors());
                return redirect()->back()->with("failed", "this contract failed to add");
            }
            $validation->validate();
            $contractManagements->id_contract = (int) $data["number-contract"];
            $contractManagements->project_id = $data["project-id"];
            $contractManagements->contract_proceed = "Belum Selesai";
            $contractManagements->contract_in = new DateTime($data["start-date"]);
            $contractManagements->contract_out = new DateTime($data["due-date"]);
            $contractManagements->number_spk = (int) $data["number-spk"];
            $contractManagements->stages = (int) 1;
            $contractManagements->value = (int) preg_replace("/[^0-9]/i", "", $data["value"]);
            if ($contractManagements->save()) {
                // echo "sukses";
                return redirect("/contract-management")->with("success", "This contract has been added");
            }
            return redirect("/contract-management")->with("failed", "This contract failed to add");
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
            "project-id" => "required|numeric",
            "start-date" => "required|date|before:due-date",
            "due-date" => "required|date|after:start-date",
            "value" => "required",
            "number-spk" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            return redirect()->back()->with("failed", "This contract failed to update");
        }
        $validation->validate();
        $contractManagements = ContractManagements::find($data["number-contract"]);
        // dd($data);
        $contractManagements->project_id = (int) $data["project-id"];
        // $contractManagements->contract_proceed = "Belum Selesai";
        $contractManagements->contract_in = new DateTime($data["start-date"]);
        $contractManagements->contract_out = new DateTime($data["due-date"]);
        $contractManagements->number_spk = (int) $data["number-spk"];
        $contractManagements->value = (int) str_replace(",", "", $data["value"]);
        if ($contractManagements->update()) {
            return redirect("/contract-management")->with("success", "Your contract has been updated");
        }
        return redirect("/contract-management")->with("failed", "Your contract failed to update");
    }


    public function viewContract ($id_contract)
    {
            if (Session::has("pasals")) {
                Session::forget("pasals");
            }
            return view('Contract/view', ["contract" => ContractManagements::find($id_contract), "projects" => Proyek::all(), "contracts" => ContractManagements::all()]);
    }


    public function tenderMenang ($id_contract, $is_tender_menang) 
    {
        if ($is_tender_menang == "tender-menang") {
            $is_tender_menang = true;
        }
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract, "is_tender_menang" => $is_tender_menang]);
    }


    public function draftContract ($id_contract) 
    {
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract]);
    }


    public function addendumContract ($id_contract) 
    {
        return view("addendumContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract]);
    }


    public function addendumNew ($id_contract, AddendumContracts $addendumContract) 
    {
        return view("addendumContract/new", ["contract" => ContractManagements::find($id_contract), "id_contract" => $id_contract, "addendumContract" => $addendumContract]);
    }


    public function addendumView ($id_contract, AddendumContracts $addendumContract) 
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


    public function addendumDraft ($id_contract, AddendumContracts $addendumContract, AddendumContractDrafts $addendumDraft) 
    {
        return view("addendumContract/new", ["addendumContract" => $addendumContract, "id_contract" => $id_contract, "addendumDraft" => $addendumDraft]);
    }


    public function draftContractView ($id_contract, DraftContracts $draftContracts) 
    {
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "id_contract" => $id_contract, "draftContract" => $draftContracts]);
    }


}
