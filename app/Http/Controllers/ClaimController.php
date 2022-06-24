<?php

namespace App\Http\Controllers;

use DateTime;
use Faker\Core\Uuid;
use App\Models\Proyek;
use App\Models\ClaimDetails;
use Illuminate\Http\Request;
use App\Models\ClaimManagements;
use App\Models\ContractManagements;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $all_proyek = Proyek::all();
        // $proyek_with_claim = [];
        // foreach ($all_proyek as $proyek) {
        //     if(count($proyek->ClaimManagements) > 0) {
        //         array_push($proyek_with_claim, $proyek);
        //     }
        // }
        
        $proyekClaim = Proyek::WhereHas('ClaimManagements', function ($claim){
            $claim->where('jenis_claim', '=', "Claim");
        })->get();
        
        $proyekAnti = Proyek::WhereHas('ClaimManagements', function ($claim){
            $claim->where('jenis_claim', '=', "Anti Claim");
        })->get();

        $proyekAsuransi = Proyek::WhereHas('ClaimManagements', function ($claim){
            $claim->where('jenis_claim', '=', "Claim Asuransi");
        })->get();
        
        // dd($proyekClaim);
        return view("5_Claim", ["proyekClaim" => $proyekClaim, "proyekAnti" => $proyekAnti, "proyekAsuransi" => $proyekAsuransi]);
    }

    public function viewClaim($id_proyek, $jenis_claim)
    {   
        $proyek = Proyek::find($id_proyek);
        $claim = $proyek->ClaimManagements;
        $jenis_claim = str_replace('-', ' ', $jenis_claim);
        $proyekClaim = [];
        foreach ($claim as $claims) {
                if($claims->jenis_claim == $jenis_claim) {
                    array_push($proyekClaim, $claims);
                }
            }

        // dd($jenis_claim);
        
        // $proyekClaim = ClaimManagements::where('jenis_claim', "=", "Claim")->get();


        return view("claimManagement/viewClaim", ['proyekClaims' => $proyekClaim, 'proyek' => $proyek]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new(Proyek $proyek, ContractManagements $contract)
    {
        $no_urut = new ClaimManagements();
        if (!empty($no_urut->all()->sortBy("id_claim")->last()->id_claim)) {
            $no_urut = (int) explode(".", $no_urut->all()->sortBy("id_claim")->last()->id_claim ?? 0)[2];
        } else {
            $no_urut = 0;
        }
        if ($no_urut < 1) {
            $no_urut = 1;
        } else {
            $no_urut += 1;
        }
        $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);
        $kode_claim = "CL." . date("Y") . "." . $no_urut;
        return view("claimManagement/new", ["contractManagements" => ContractManagements::all(), "currentContract" => $contract, "proyek" => $proyek, "kode_claim" => $kode_claim, "claimContract" => null]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, ClaimManagements $claimManagements)
    {
        $data = $request->all();
        // if (preg_match("/[^,0-9]/i", $data["total-claim"])) {
        //     return redirect()->back()->with("failed", "Total Claim must be numeric or ',' only");
        // }

        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            "approve-date" => "required|date",
            "pic" => "required|string",
            "project-id" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("approve-date");
            $request->old("pic");
            // $request->old("project-id");
            // $request->old("id-contract");
            $request->old("number-claim");
            $request->old("jenis-claim");
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $validation->validate();
        $claimManagements->id_claim = $data["number-claim"];
        $claimManagements->kode_proyek = $data["project-id"];
        $claimManagements->id_contract = $data["id-contract"];
        $claimManagements->stages = 1;
        $claimManagements->nilai_claim = 0;
        $claimManagements->tanggal_claim = new DateTime($data["approve-date"]);
        $claimManagements->pic = $data["pic"];
        $claimManagements->jenis_claim = $data["jenis-claim"];

        if ($claimManagements->save()) {
            return redirect("/contract-management/view/".$data["id-contract"])->with("success", "This claim has been added");
        }
        return redirect("/claim-management")->with("failed", "This claim failed to add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $approval_name = trim(htmlspecialchars($request->get("approval-claim-name")));
        $id_claim = $request->id_claim;
        $total = $request->total;
        $claimManagement = ClaimManagements::find($id_claim);
        $approval_array = explode(";", trim($claimManagement->approval_claim));
        $index_array = count($approval_array);
        $claimManagement->nilai_claim += $total;
        if ($index_array > 1) {
            $store_data_array = [$index_array, $approval_name, $total];
            $claimManagement->approval_claim = $claimManagement->approval_claim . json_encode($store_data_array) . ";";
        } else {
            $store_data_array = [$index_array, $approval_name, $total];
            $claimManagement->approval_claim = json_encode($store_data_array) . ";";
        }

        if ($claimManagement->save()) {
            return response()->json([
                "status" => "success",
                "message" => "Approval has been added",
                "approval_name" => $approval_name,
                "index_array" => $index_array,
                "nilai_claim" => number_format($claimManagement->nilai_claim, 0, ",", ","),
            ]);
        }
        return response()->json([
            "status" => "success",
            "message" => "Approval failed to add",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClaimManagements $claim_management)
    {
        return view("claimManagement/new", ["currentContract" => $claim_management->contract, "claimContract" => $claim_management, "proyek" => $claim_management->project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id_claim = $request->id_claim;
        $id_requested = $request->index_array;
        $claimManagement = ClaimManagements::find($id_claim);
        $approval_array = explode(";", trim($claimManagement->approval_claim));
        array_pop($approval_array); //remove last array because it's always an empty string
        $approval_array = array_map(function ($data) {
            $data_array = json_decode($data);
            return $data_array;
        }, $approval_array);
        $total = array_map(function ($data) {
            return (int) $data[2];
        }, $approval_array);
        $approval_array = array_filter($approval_array, function ($data) use ($id_requested) {
            return $data[0] != $id_requested;
        });
        $index_array = count($approval_array);
        $total = array_sum($total);
        $store_data_array = "";
        foreach ($approval_array as $approval) {
            $store_data_array .= json_encode($approval) . ";";
            // $store_data_array += "";
        }
        dump($store_data_array);
        // if ($index_array > 1) {
        //     $claimManagement->approval_claim = json_encode($approval_array) . ";";
        // } else {
        //     $claimManagement->approval_claim = "";
        // }
        // $claimManagement->nilai_claim = $total;
        // if ($claimManagement->save()) {
        //     return response()->json([
        //         "status" => "success",
        //         "message" => "Selected approval has been deleted",
        //         "approval_name" => $approval_name,
        //         "index_array" => $index_array,
        //         "nilai_claim" => number_format($claimManagement->nilai_claim, 0, ",", ","),
        //     ]);
        // }
        // return response()->json([
        //     "status" => "success",
        //     "message" => "Approval failed to add",
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        // if (preg_match("/[^,0-9]/i", $data["total-claim"])) {
        //     return redirect()->back()->with("failed", "Total Claim must be numeric or ',' only");
        // }
        $claimManagements = ClaimManagements::find($data["id-claim"]);
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            "approve-date" => "required|date",
            "pic" => "required|string",
            "project-id" => "required|string",
            "id-claim" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("approve-date");
            $request->old("pic");
            $request->old("project-id");
            $request->old("id-contract");
            $request->old("id-claim");
            dd($validation->errors());
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $validation->validate();
        $claimManagements->kode_proyek = $data["project-id"];
        $claimManagements->id_contract = $data["id-contract"];
        $claimManagements->tanggal_claim = new DateTime($data["approve-date"]);
        $claimManagements->pic = $data["pic"];

        if ($claimManagements->save()) {
            return redirect("/claim-management/view/$claimManagements->id_claim")->with("success", "This claim has been updated");
        }
        return redirect("/claim-management")->with("failed", "This claim failed to update");
    }

    public function detailSave(Request $request, ClaimDetails $claimDetail)
    {
        $data = $request->all();
        $id_claim = $data["id-claim"];
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only"
        ];
        $rules = [
            "attach-file-claim-detail" => "required|file",
            "document-name-claim-detail" => "required|string",
            "note-claim-detail" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("attach-file-claim-detail");
            $request->old("document-name-claim-detail");
            $request->old("note-claim-detail");
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $faker = new Uuid();
        $id_document = $faker->uuid3();
        $validation->validate();
        $claimDetail->id_document = $id_document;
        $claimDetail->document_name = $data["document-name-claim-detail"];
        $claimDetail->id_claim = $id_claim;
        $claimDetail->note_detail_claim = $data["note-claim-detail"];
        if ($claimDetail->save()) {
            moveFileTemp($data["attach-file-claim-detail"], $id_document);
            return redirect("/claim-management/view/$id_claim")->with("success", "Detail Claim has been added");
        }
        $request->old("attach-file-claim-detail");
        $request->old("document-name-claim-detail");
        $request->old("note-claim-detail");
        return redirect("/claim-management/view/$id_claim")->with("failed", "This claim failed to add");
    }

    public function claimStage(Request $request)
    {
        $id_claim = $request->id_claim;
        $stage = $request->stage;
        $claimManagement = ClaimManagements::find($id_claim);
        if ($claimManagement instanceof ClaimManagements) {
            $claimManagement->stages = $stage;
            if ($claimManagement->save()) {
                return response()->json([
                    "status" => "success",
                    "message" => "Stage has been updated",
                ]);
            }
        }
        return response()->json([
            "status" => "failed",
            "message" => "Stage failed to update",
        ]);
    }
}
