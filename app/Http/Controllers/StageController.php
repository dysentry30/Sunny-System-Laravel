<?php

namespace App\Http\Controllers;

use App\Models\AddendumContracts;
use App\Models\ContractManagements;
use Illuminate\Http\Request;

class StageController extends Controller
{
    // Save Stage from Addendum to database
    public function stageAddendumSave(Request $request) {
        if ($request->id_addendum == 0) {
            return response()->json([
                "status" => "failed",
                "msg" => "Update Stage Failed. Please make addendum first",
            ]);
        }
        $id = $request->id_addendum;
        $addendum_contract = AddendumContracts::find($id);
        // if ($addendum_contract->stages == 2) {
        //     $addendum_contract->stages = 1;
        // } else {
            // }
        $addendum_contract->stages = $request->stage;
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
    }

    // Stage save to database or server
    public function stageSave(Request $request) {
        $id = $request->id_contract;
        $contract_management = ContractManagements::find($id);
        $contract_management->stages = $request->stage;
        if ($contract_management->save()) {
            return response()->json([
                "status" => "success",
                "link" => true,
            ]);
        }
    }
}
