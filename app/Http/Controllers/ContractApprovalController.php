<?php

namespace App\Http\Controllers;

use App\Models\ContractApproval;
use App\Models\ContractManagements;
use App\Models\PerubahanKontrak;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use stdClass;

class ContractApprovalController extends Controller
{
    private function sendDataSAP($id_contract){
        // $claims_all = PerubahanKontrak::all();
        $claims_all = PerubahanKontrak::whereIn("jenis_perubahan", ["VO", "Klaim"])->where("id_contract", "=", $id_contract)->get();
        // $claims_map = $claims_all->map(function($claim){
        //     return $claim->Proyek->UnitKerja->id_profit_center;
        // });
        // dd($claims_map);
        // $profit_center = $contract->project->UnitKerja->id_profit_center;
        // $claims = $contract->PerubahanKontrak;
        $data_claims = $claims_all->map(function($item, $key) use($claims_all){
            $profit_center = $item->Proyek->profit_center;

            $newClass = new stdClass();
            $newClass->TANGGAL = (int) date("Ymd");
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            // $newClass->PROJECT_DEF = "AB00000";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$item->uraian_perubahan";
            if($item->stage == 2){
                $newClass->CLAIM_CAT = "ITEM DIAJUKAN";
            }elseif($item->stage == 1){
                $newClass->CLAIM_CAT = "ITEM TARGET";
            }elseif($item->stage == 5){
                $newClass->CLAIM_CAT = "ITEM DISETUJUI";
            };
            $newClass->CLAIM_VAL = $claims_all->count();
            if ($item->jenis_perubahan == "Klaim") {
                $newClass->CATEGORY = "CLAIM";
            }else{
                $newClass->CATEGORY = "$item->jenis_perubahan";
            }

            return $newClass;
        })->values();

        // return response()->json($data_claims, 200);
        // dd($data_claims);

        // SAP DEV
        // // FIRST STEP SEND DATA TO BW
        // $csrf_token = "";
        // $content_location = "";
        // // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
        // // $http = Http::withBasicAuth("WIKA_API", "WikaWika2022");
        // $get_token = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests");
        // $csrf_token = $get_token->header("x-csrf-token");
        // $cookie = "";
        // collect($get_token->cookies()->toArray())->each(function($c) use(&$cookie) {
        //     $cookie .= $c["Name"] . "=" . $c["Value"] . ";"; 
        // });

        // // SECOND STEP SEND DATA TO BW
        // $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests");
        // $content_location = $get_content_location->header("content-location");
        

        // // THIRD STEP SEND DATA TO BW
        // // dd($new_class->toJson());
        // $fill_data = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/dataSend?request=$content_location&datapid=1", $data_claims->toArray());
        
        // // FOURTH STEP SEND DATA TO BW
        // $closed_request = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests/$content_location/close");
        // // dd($closed_request, $data_claims, $fill_data);

        //-------------------------------------------------------------------------------------//

        
        //SAP PRODUCTION

        // FIRST STEP SEND DATA TO BW
        $csrf_token = "";
        $content_location = "";
        // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
        // $http = Http::withBasicAuth("WIKA_API", "WikaWika2022");
        $get_token = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests");
        $csrf_token = $get_token->header("x-csrf-token");
        $cookie = "";
        collect($get_token->cookies()->toArray())->each(function($c) use(&$cookie) {
            $cookie .= $c["Name"] . "=" . $c["Value"] . ";"; 
        });

        // SECOND STEP SEND DATA TO BW
        $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests");
        $content_location = $get_content_location->header("content-location");
        

        // THIRD STEP SEND DATA TO BW
        // dd($new_class->toJson());
        $fill_data = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/dataSend?request=$content_location&datapid=1", $data_claims->toArray());
        
        // FOURTH STEP SEND DATA TO BW
        $closed_request = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests/$content_location/close");
        // dd($closed_request, $data_claims, $fill_data);

        return response()->json($data_claims);
    }

    public function index(){
        $month = (int)date("m") == 12 ? 1 : (int)date("m")-1;
        $is_exist_history = ContractApproval::where("periode", $month)->where("is_locked", "!=", false)->get();
        // dd($is_exist_history);
        return view("15_CCM_Approval", compact("is_exist_history"));
    }

    public function lockApproval(Request $request){
        $data = $request->all();
        // return response()->json($data, 200);

        $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

        $contract = ContractManagements::where("id_contract", "=", $data["id_contract"])->first();

        $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode", $month)->first();

        $perubahan = PerubahanKontrak::where("id_contract", "=", $data["id_contract"])->get();

        $progress = $contract->project->ProyekProgress->sortByDesc("created_at")->first();

        // dd($progress);

        //Kategori VO
        $cat_vo = $perubahan->where("jenis_perubahan", "=", "VO");
        $item_vo = $cat_vo->count();
        $jumlah_vo = $cat_vo->sum("biaya_pengajuan");
        // dd($item_vo, $jumlah_vo);
        
        //Kategori Klaim
        $cat_klaim = $perubahan->where("jenis_perubahan", "=", "Klaim");
        $item_klaim = $cat_klaim->count();
        $jumlah_klaim = $cat_klaim->sum("biaya_pengajuan");
        // dd($item_klaim, $jumlah_klaim);
        
        //Kategori ANti Klaim
        $cat_anti_klaim = $perubahan->where("jenis_perubahan", "=", "Anti Klaim");
        $item_anti_klaim = $cat_anti_klaim->count();
        $jumlah_anti_klaim = $cat_anti_klaim->sum("biaya_pengajuan");
        // dd($item_anti_klaim, $jumlah_anti_klaim);
        
        //Kategori Klaim Asuransi
        $cat_klaim_asuransi = $perubahan->where("jenis_perubahan", "=", "Klaim Asuransi");
        $item_klaim_asuransi = $cat_klaim_asuransi->count();
        $jumlah_klaim_asuransi = $cat_klaim_asuransi->sum("biaya_pengajuan");
        // dd($item_klaim_asuransi, $jumlah_klaim_asuransi);

        if(!empty($approval)){
            $approval->id_contract = $data["id_contract"];
            $approval->kode_proyek = $data["kode_proyek"];
            $approval->nilai_kontrak = $progress->ok_review ?? 0;
            $approval->periode = $data["periode"] == 1 ? 12 : $data["periode"];
            $approval->tahun = $data["tahun"];
            $approval->jumlah_vo = $jumlah_vo;
            $approval->total_vo = $item_vo;
            $approval->jumlah_klaim = $jumlah_klaim;
            $approval->total_klaim = $item_klaim;
            $approval->jumlah_anti_klaim = $jumlah_anti_klaim;
            $approval->total_anti_klaim = $item_anti_klaim;
            $approval->jumlah_klaim_asuransi = $jumlah_klaim_asuransi;
            $approval->total_klaim_asuransi = $item_klaim_asuransi;
            $approval->is_locked = true;
            // $approval->is_request_unlock = false;
            // $approval->is_approved = false;

            // dd($approval);

            if($approval->save()){
                Alert::success("Success", "Contract berhasil dilock");
                // toast("Contract berhasil dilock", "success")->autoClose(3000);
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }else{
                Alert::error("Error", "Contract gagal dilock");
                // toast("Contract gagal dilock", "error")->autoClose(3000);
                return response()->json([
                    "status" => "error",
                    "link" => false,
                ]);
            }
        }else{
            $approve = new ContractApproval();
            $approve->id_contract = $data["id_contract"];
            $approve->kode_proyek = $data["kode_proyek"];
            $approve->periode = $data["periode"] == 1 ? 12 : $data["periode"];
            $approve->tahun = $data["tahun"];
            $approve->jumlah_vo = $jumlah_vo ?? 0;
            $approve->total_vo = $item_vo;
            $approve->jumlah_klaim = $jumlah_klaim ?? 0;
            $approve->total_klaim = $item_klaim;
            $approve->jumlah_anti_klaim = $jumlah_anti_klaim ?? 0;
            $approve->total_anti_klaim = $item_anti_klaim;
            $approve->jumlah_klaim_asuransi = $jumlah_klaim_asuransi ?? 0;
            $approve->total_klaim_asuransi = $item_klaim_asuransi;
            $approve->is_locked= true;
            // $approve->is_request_unlock = false;
            // $approve->is_approved = true;

            // dd($approve);

            if($approve->save()){
                Alert::success("Success", "Contract berhasil dilock");
                // toast("Contract berhasil dilock", "success")->autoClose(3000);
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }else{
                Alert::error("Error", "Contract gagal dilock");
                // toast("Contract gagal dilock", "error")->autoClose(3000);
                return response()->json([
                    "status" => "error",
                    "link" => false,
                ]);
            }

        }

    }

    public function setUnlock(Request $request){
        $data = $request->all();

        $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

        $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode", $month)->first();

        $approval->is_request_unlock = null;
        $approval->is_locked = false;
        $approval->is_approved = null;

        if($approval->save()){
            Alert::success("success", "Contract berhasil di unlock");
            return redirect()->back();
        }else{
            Alert::error("error", "Contract gagal di unlock");
            return redirect()->back();
        }
    }

    public function requestUnlock(Request $request){
        $data = $request->all();

        $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

        $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode", $month)->first();

        $approval->is_request_unlock = "t";

        if($approval->save()){
            Alert::success("success", "Mohon tunggu untuk di unlock oleh PIC");
            return redirect()->back();
        }else{
            Alert::error("error", "Gagal melakukan request");
            return redirect()->back();
        }
    }

    public function setApprove(Request $request, $id_contract){
        $data = $request->all();

        $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

        $approval = ContractApproval::where("id_contract", "=", $id_contract)->where("periode", $month)->first();

        $approval->is_approved = $data["approve"];

        if($approval->save()){
            $this->sendDataSAP($id_contract);
            Alert::success("success", "Contract berhasil di Approve");
            return response()->json([
                "status" => "success",
                "link" => true,
            ]);
        }else{
            Alert::error("error", "Contract gagal di Approve");
            return response()->json([
                "status" => "error",
                "link" => false,
            ]);
        }

    }
}
