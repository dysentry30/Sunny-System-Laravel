<?php

namespace App\Http\Controllers;

use App\Models\AddendumContracts;
use App\Models\ContractManagements;
use App\Models\PerubahanKontrak;
use Illuminate\Http\Request;

class StageController extends Controller
{
    // Save Stage from Addendum to database
    public function stageAddendumSave(Request $request)
    {
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
    public function stageSave(Request $request)
    {
        $id = $request->id_contract;
        $contract_management = ContractManagements::find($id);
        $contract_management->stages = $request->stage;
        if ($contract_management->save()) {
            toast("Stage berhasil diperbarui", "success")->autoClose(3000);
            return response()->json([
                "status" => "success",
                "link" => true,
            ]);
        }
    }

    public function stagePerubahanKontrakSave(Request $request) {
        $data = $request->all();
        $perubahan_kontrak = PerubahanKontrak::find($data["id_perubahan_kontrak"]);
        if(isset($data["is-dispute"])) {
            $perubahan_kontrak->is_dispute = true;
            if($perubahan_kontrak->save()) {
                toast("Perubahan Kontrak berhasil ter-dispute", "success", "top-right");
                return redirect()->back();
            }
        } else {
            $perubahan_kontrak->is_dispute = false;
            $perubahan_kontrak->stage = $data["stage"];
            if($perubahan_kontrak->save()) {
                return response()->json([
                    "status" => "success",
                ]);
            }
        }
    }
}
