<?php

namespace App\Http\Controllers;

use App\Models\ContractApproval;
use App\Models\ContractManagements;
use App\Models\PerubahanKontrak;
use App\Models\UnitKerja;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use stdClass;
use Illuminate\Support\Facades\Log;


class ContractApprovalController extends Controller
{
    private function sendDataSAP($id_contract, $periode)
    {
        // $claims_all = PerubahanKontrak::all();
        $claims_all = ContractApproval::whereIn("jenis_perubahan", ["VO", "Klaim"])->whereIn("stage", [1, 2, 4, 5])->where("id_contract", "=", $id_contract)->where('periode', '=', $periode)->get();
        $data_claims = $claims_all->map(function($item, $key) use($claims_all){

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function($i, $key) use($item){
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function($ic) use($item){
                if ($item->stage == 4) {
                    return (int) $ic->stage == 4;
                }elseif($item->stage == 5){
                    return (int) $ic->stage == 5;
                } elseif ($item->stage >= 2) {
                    return (int) $ic->stage >= 2;
                } elseif ($item->stage >= 1) {
                    return (int) $ic->stage >= 1;
                }
            })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if($item->stage == 1 ){
            //         return $ic->stage == 1;
            //     }elseif($item->stage == 2){
            //         return $ic->stage == 2;
            //     }elseif($item->stage == 5){
            //         return $ic->stage == 5;
            //     }
            // })->count();

            $uraian_formatted = substr($item->uraian_perubahan, 0, 255);

            $profit_center = $item->Proyeks->profit_center;
            $newClass = new stdClass();

            $newClass->NO_PROPOSAL_CLAIM = $item->proposal_klaim;
            $newClass->TANGGAL = (int) date("Ymd");
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$uraian_formatted";

            if ($item->stage == 4) {
                $newClass->CLAIM_CAT = "ITEM NEGOTIATION";
            }elseif($item->stage == 5){
                $newClass->CLAIM_CAT = "ITEM APPROVED";
            } elseif ($item->stage >= 2) {
                $newClass->CLAIM_CAT = "ITEM SUBMISSION";
            } elseif ($item->stage >= 1) {
                $newClass->CLAIM_CAT = "ITEM POTENTIAL";
            };

            // if($item->stage == 2){
            //     $newClass->CLAIM_CAT = "ITEM DIAJUKAN";
            // }elseif($item->stage == 1){
            //     $newClass->CLAIM_CAT = "ITEM TARGET";
            // }elseif($item->stage == 5){
            //     $newClass->CLAIM_CAT = "ITEM DISETUJUI";
            // } elseif ($item->stage == 4) {
            //     $newClass->CLAIM_CAT = "ITEM NEGOSIASI";
            // };

            $newClass->CLAIM_VAL = $claim_val;

            if($item->stage == 5){
                $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
            }else{
                $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
            }
            
            // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");
            
            // $newClass->CLAIM_VAL = $claims_all->groupBy("jenis_perubahan")->map(function($i, $key) use($item){
            //     return $key = $i->count();
            // })->get($item->jenis_perubahan);

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
        $get_token = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests");
        $csrf_token = $get_token->header("x-csrf-token");
        $cookie = "";
        collect($get_token->cookies()->toArray())->each(function ($c) use (&$cookie) {
            $cookie .= $c["Name"] . "=" . $c["Value"] . ";";
        });

        // SECOND STEP SEND DATA TO BW
        $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests");
        $content_location = $get_content_location->header("content-location");


        // THIRD STEP SEND DATA TO BW
        // dd($new_class->toJson());
        $fill_data = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/dataSend?request=$content_location&datapid=1", $data_claims->toArray());

        // FOURTH STEP SEND DATA TO BW
        $closed_request = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests/$content_location/close");
        // dd($closed_request, $data_claims, $fill_data);

        if ($fill_data->successful() && $closed_request->successful()) {

            $this->setLogging('ccm_approval', "APPROVAL CCM => ", [
                "KODE_PROYEK" => $claims_all->first()->kode_proyek,
                "DATA" => $data_claims->toArray(),
                "STATUS" => "SUCCESS"
            ]);

            $response_success = [
                "statusCode" => 200,
                "message" => "success"
            ];

            return response()->json($response_success);
        } else {
            $this->setLogging('ccm_approval', "APPROVAL CCM => ", [
                "KODE_PROYEK" => $claims_all->first()->kode_proyek,
                "DATA" => $data_claims->toArray(),
                "STATUS" => "FAILED"
            ]);

            $response_success = [
                "statusCode" => 400,
                "message" => "failed"
            ];

            return response()->json($response_success);
        }
    }

    public function index(Request $request){

        $filterUnit = $request->query("filter-unit");
        $filterJenis = $request->query("filter-jenis");
        $filterTahun = $request->query("tahun-proyek") ?? (int) date("Y");
        $filterBulan = $request->query("bulan-proyek") ?? "";
        // dd($filterBulan);

        $year = (int) date("Y");
        $month = (int) date('m') == 1 ? 12 : ((int)date('d') < 15 ? (int) date('m') : (int) date('m') - 1);

        $tahun_proyeks = ContractApproval::get()->sortByDesc("tahun")->groupBy("tahun")->keys();
        $periode = (int)date("m") == 12 ? 1 : (int)date("m")-1;
        $user = Auth::user();

        if (Auth::user()->check_administrator) {
            if ($filterTahun < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unitkerjas = UnitKerja::whereNoN("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas_select = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get();
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->whereNotIn("unit_kerja", $unit_kerja_code)->get();
                // $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
                // $proyeks = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->whereNotIn("unit_kerja", $unit_kerja_code)->whereIn("stage", [6, 8, 9])->where("stages", "=", 3)->get();
            } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unitkerjas = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas_select = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get();
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->whereNotIn("unit_kerja", $unit_kerja_code)->get();
                // $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->get();
                // $proyeks = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->whereNotIn("unit_kerja", $unit_kerja_code)->whereIn("stage", [6, 8, 9])->where("stages", "=", 3)->get();
            }

            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            if(!empty($filterBulan) && $filterTahun == 2023){
                $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
            }else{
                if($filterTahun < 2023 && !empty($filterBulan)){
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }elseif($filterTahun < 2023 && empty($filterBulan)){
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }else{
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "=", $month)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }    
            }

        }else{

            $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);

            if ($filterTahun < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unitkerjas = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas_select = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->whereNotIn("unit_kerja", $unit_kerja_code)->get();
                // $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
                // $proyeks = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->whereNotIn("unit_kerja", $unit_kerja_code)->whereIn("stage", [6, 8, 9])->where("stages", "=", 3)->get();
            } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"];
                $unitkerjas = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas_select = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->whereNotIn("unit_kerja", $unit_kerja_code)->get();
                // $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->get();
                // $proyeks = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->whereNotIn("unit_kerja", $unit_kerja_code)->whereIn("stage", [6, 8, 9])->where("stages", "=", 3)->get();
            }

            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            if(!empty($filterBulan) && $filterTahun == 2023){
                $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
            }else{
                if($filterTahun < 2023 && !empty($filterBulan)){
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }elseif($filterTahun < 2023 && empty($filterBulan)){
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }else{
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode", "=", $month)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }
            }
        }

        $approvals = $contract_approval->map(function ($approval) {
            // dump($approval->first()->Proyeks->nama_proyek);
            $nama_proyek = $approval->first()->Proyeks->nama_proyek;
            //Kategori VO
            $cat_vo = $approval->where("jenis_perubahan", "=", "VO");
            $item_vo = $cat_vo->count();
            $jumlah_vo = $cat_vo->sum("biaya_pengajuan");
            // dd($item_vo, $jumlah_vo);

            //Kategori Klaim
            $cat_klaim = $approval->where("jenis_perubahan", "=", "Klaim");
            $item_klaim = $cat_klaim->count();
            $jumlah_klaim = $cat_klaim->sum("biaya_pengajuan");
            // dd($item_klaim, $jumlah_klaim);

            //Kategori ANti Klaim
            $cat_anti_klaim = $approval->where("jenis_perubahan", "=", "Anti Klaim");
            $item_anti_klaim = $cat_anti_klaim->count();
            $jumlah_anti_klaim = $cat_anti_klaim->sum("biaya_pengajuan");
            // dd($item_anti_klaim, $jumlah_anti_klaim);

            //Kategori Klaim Asuransi
            $cat_klaim_asuransi = $approval->where("jenis_perubahan", "=", "Klaim Asuransi");
            $item_klaim_asuransi = $cat_klaim_asuransi->count();
            $jumlah_klaim_asuransi = $cat_klaim_asuransi->sum("biaya_pengajuan");
            // dd($item_klaim_asuransi, $jumlah_klaim_asuransi);


            switch ($approval->first()->periode) {
                case 1:
                    $month = "Januari";
                    break;
                case 2:
                    $month = "Februari";
                    break;
                case 3:
                    $month = "Maret";
                    break;
                case 4:
                    $month = "April";
                    break;
                case 5:
                    $month = "Mei";
                    break;
                case 6:
                    $month = "Juni";
                    break;
                case 7:
                    $month = "Juli";
                    break;
                case 8:
                    $month = "Agustus";
                    break;
                case 9:
                    $month = "September";
                    break;
                case 10:
                    $month = "Oktober";
                    break;
                case 11:
                    $month = "November";
                    break;
                case 12:
                    $month = "Desember";
                    break;
            }


            return [
                'id_contract' => $approval->first()->id_contract,
                'nama_proyek' => $nama_proyek,
                'jumlah_vo' => $jumlah_vo,
                'jumlah_klaim' => $jumlah_klaim,
                'jumlah_anti_klaim' => $jumlah_anti_klaim,
                'jumlah_klaim_asuransi' => $jumlah_klaim_asuransi,
                'total_vo' => $item_vo,
                'total_klaim' => $item_klaim,
                'total_anti_klaim' => $item_anti_klaim,
                'total_klaim_asuransi' => $item_klaim_asuransi,
                'nilai_kontrak' => $approval->first()->Proyeks->nilai_kontrak ?? 0,
                'periode' => $month,
                'unit_kerja' => $approval->first()->Proyeks->UnitKerja->unit_kerja,
                'is_approved' => $approval->first()->is_approved,
                'is_request_unlock' => $approval->first()->is_request_unlock,
            ];
        });

        // dd($approvals);

        // $is_exist_history = ContractApproval::where("periode", $periode)->where("is_locked", "!=", false)->get();
        // dd($contract_approval->groupBy('kode_proyek'));
        return view("15_CCM_Approval", compact(["approvals", "tahun_proyeks", "filterTahun", "month", "filterBulan", "unit_kerjas_select", "filterUnit", "user"]));
    }

    // public function lockApproval(Request $request){
    //     $data = $request->all();
    //     // return response()->json($data, 200);
    //     // dd((int)$data["periode"], (int)date('d'));

    //     $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

    //     $contract = ContractManagements::where("id_contract", "=", $data["id_contract"])->first();

    //     $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode", $month)->first();

    //     $perubahan = PerubahanKontrak::where("id_contract", "=", $data["id_contract"])->get();

    //     $progress = $contract->project->ProyekProgress->sortByDesc("created_at")->first();

    //     // dd($contract->project->unit_kerja);

    //     //Kategori VO
    //     $cat_vo = $perubahan->where("jenis_perubahan", "=", "VO");
    //     $item_vo = $cat_vo->count();
    //     $jumlah_vo = $cat_vo->sum("biaya_pengajuan");
    //     // dd($item_vo, $jumlah_vo);

    //     //Kategori Klaim
    //     $cat_klaim = $perubahan->where("jenis_perubahan", "=", "Klaim");
    //     $item_klaim = $cat_klaim->count();
    //     $jumlah_klaim = $cat_klaim->sum("biaya_pengajuan");
    //     // dd($item_klaim, $jumlah_klaim);

    //     //Kategori ANti Klaim
    //     $cat_anti_klaim = $perubahan->where("jenis_perubahan", "=", "Anti Klaim");
    //     $item_anti_klaim = $cat_anti_klaim->count();
    //     $jumlah_anti_klaim = $cat_anti_klaim->sum("biaya_pengajuan");
    //     // dd($item_anti_klaim, $jumlah_anti_klaim);

    //     //Kategori Klaim Asuransi
    //     $cat_klaim_asuransi = $perubahan->where("jenis_perubahan", "=", "Klaim Asuransi");
    //     $item_klaim_asuransi = $cat_klaim_asuransi->count();
    //     $jumlah_klaim_asuransi = $cat_klaim_asuransi->sum("biaya_pengajuan");
    //     // dd($item_klaim_asuransi, $jumlah_klaim_asuransi);

    //     $periode_approval = $data["periode"] == 1 ? 12 : $data["periode"];

    //     if(!empty($approval)){
    //         $approval->id_contract = $data["id_contract"];
    //         $approval->kode_proyek = $data["kode_proyek"];
    //         $approval->unit_kerja = $contract->project->unit_kerja;
    //         $approval->nilai_kontrak = $progress->ok_review ?? 0;
    //         $approval->periode = (int)date('d') < 15 ? $periode_approval : $periode_approval - 1;
    //         $approval->tahun = $data["tahun"];
    //         $approval->jumlah_vo = $jumlah_vo;
    //         $approval->total_vo = $item_vo;
    //         $approval->jumlah_klaim = $jumlah_klaim;
    //         $approval->total_klaim = $item_klaim;
    //         $approval->jumlah_anti_klaim = $jumlah_anti_klaim;
    //         $approval->total_anti_klaim = $item_anti_klaim;
    //         $approval->jumlah_klaim_asuransi = $jumlah_klaim_asuransi;
    //         $approval->total_klaim_asuransi = $item_klaim_asuransi;
    //         $approval->is_locked = true;
    //         // $approval->is_request_unlock = false;
    //         // $approval->is_approved = false;

    //         // dd($approval);

    //         if($approval->save()){
    //             Alert::success("Success", "Contract berhasil dilock");
    //             // toast("Contract berhasil dilock", "success")->autoClose(3000);
    //             return response()->json([
    //                 "status" => "success",
    //                 "link" => true,
    //             ]);
    //         }else{
    //             Alert::error("Error", "Contract gagal dilock");
    //             // toast("Contract gagal dilock", "error")->autoClose(3000);
    //             return response()->json([
    //                 "status" => "error",
    //                 "link" => false,
    //             ]);
    //         }
    //     }else{
    //         $approve = new ContractApproval();
    //         $approve->id_contract = $data["id_contract"];
    //         $approve->kode_proyek = $data["kode_proyek"];
    //         $approve->unit_kerja = $contract->project->unit_kerja;
    //         $approve->periode = $data["periode"] == 1 ? 12 : $data["periode"] - 1;
    //         $approve->tahun = $data["tahun"];
    //         $approve->jumlah_vo = $jumlah_vo ?? 0;
    //         $approve->total_vo = $item_vo;
    //         $approve->jumlah_klaim = $jumlah_klaim ?? 0;
    //         $approve->total_klaim = $item_klaim;
    //         $approve->jumlah_anti_klaim = $jumlah_anti_klaim ?? 0;
    //         $approve->total_anti_klaim = $item_anti_klaim;
    //         $approve->jumlah_klaim_asuransi = $jumlah_klaim_asuransi ?? 0;
    //         $approve->total_klaim_asuransi = $item_klaim_asuransi;
    //         $approve->is_locked= true;
    //         $approve->stage = $contract->stages;
    //         // $approve->is_request_unlock = false;
    //         // $approve->is_approved = true;

    //         // dd($approve);

    //         if($approve->save()){
    //             Alert::success("Success", "Contract berhasil dilock");
    //             // toast("Contract berhasil dilock", "success")->autoClose(3000);
    //             return response()->json([
    //                 "status" => "success",
    //                 "link" => true,
    //             ]);
    //         }else{
    //             Alert::error("Error", "Contract gagal dilock");
    //             // toast("Contract gagal dilock", "error")->autoClose(3000);
    //             return response()->json([
    //                 "status" => "error",
    //                 "link" => false,
    //             ]);
    //         }

    //     }

    // }

    public function lockApprovalRev(Request $request)
    {
        $data = $request->all();
        $approval = ContractApproval::where('id_contract', '=', $data['id_contract'])->where('periode', '=', $data["periode"])->get();
        $claims = PerubahanKontrak::select(['id_perubahan_kontrak',
            'kode_proyek',
            'id_contract',
            'jenis_perubahan',
            'tanggal_perubahan',
            'uraian_perubahan',
            'proposal_klaim',
            'tanggal_pengajuan',
            'biaya_pengajuan',
            'nilai_disetujui',
            'waktu_pengajuan',
            'waktu_disetujui',
            'stage'
        ])->where('id_contract', '=', $data['id_contract'])->get();

        // dd($approval);
        if (!empty($approval->toArray()) || $approval->isNotEmpty()) {
            try {
                $approval = $approval->keyBy('perubahan_id')->map(function ($item, $key) use ($claims) {
                    $claim = $claims->where('id_perubahan_kontrak', $key)->first();
                    $item->tanggal_perubahan = $claim->tanggal_perubahan;
                    $item->uraian_perubahan = $claim->uraian_perubahan;
                    $item->proposal_klaim = $claim->proposal_klaim;
                    $item->tanggal_pengajuan = $claim->tanggal_pengajuan;
                    $item->biaya_pengajuan = $claim->biaya_pengajuan;
                    $item->waktu_pengajuan = $claim->waktu_pengajuan;
                    $item->nilai_disetujui = $claim->nilai_disetujui;
                    $item->waktu_disetujui = $claim->waktu_disetujui;
                    $item->stage = $claim->stage;
                    $item->is_locked = true;
                    $item->save();
                    return true;
                });
                if ($approval) {
                    Alert::success("Success", "Contract berhasil dilock");
                    // toast("Contract berhasil dilock", "success")->autoClose(3000);
                    return response()->json([
                        "status" => "success",
                        "link" => true,
                    ]);
                } else {
                    Alert::error("Error", "Contract gagal dilock");
                    // toast("Contract gagal dilock", "error")->autoClose(3000);
                    return response()->json([
                        "status" => "error",
                        "link" => false,
                    ]);
                }
            } catch (\Throwable $th) {
                Alert::error("Error", $th->getMessage());
                // toast("Contract gagal dilock", "error")->autoClose(3000);
                return response()->json([
                    "status" => "error",
                    "link" => false,
                ]);
            }
            // $approval->kode_proyek = $data["kode-proyek"];
            // $approval->id_contract = $data['id_contract'];
            // $approval->jenis_perubahan = $data["jenis-perubahan"];
            // $approval->tanggal_perubahan = $data["tanggal-perubahan"];
            // $approval->uraian_perubahan = $data["uraian-perubahan"];
            // $approval->proposal_klaim = $data["proposal-klaim"];
            // $approval->tanggal_pengajuan = $data["tanggal-pengajuan"];
            // $approval->biaya_pengajuan = !empty($data["biaya-pengajuan"]) ? str_replace(".", "", $data["biaya-pengajuan"]) : null;
            // $approval->waktu_pengajuan = !empty($data["biaya-pengajuan"]) ? $data["waktu-pengajuan"] : null;
            // $approval->nilai_disetujui = !empty($data["nilai-disetujui"]) ? str_replace(".", "", $data["nilai-disetujui"]) : null;
            // $approval->waktu_disetujui = !empty($data["waktu-disetujui"]) ? $data["waktu-disetujui"] : null;
            // $approval->stage = 1;
        } else {
            if ((int)date('d') < 15) {
                if ((int)date('m') == 1) {
                    $periode = 1;
                } else {
                    $periode = (int)date("m");
                }
            } else {
                if ((int)date('m') == 1) {
                    $periode = 12;
                } else {
                    $periode = (int)date("m") - 1;
                }
            }
            $approval = new ContractApproval();
            $data_approval = $claims->map(function ($claim) use ($periode) {
                $claim['periode'] = $periode;
                $claim['tahun'] = date('Y');
                $claim['unit_kerja'] = $claim->Proyek->unit_kerja;
                $claim['is_locked'] = true;
                $claim['perubahan_id'] = $claim->id;
                $claim->makeHidden(['Proyek', 'id']); //Untuk menghilangkan relasi agar tidak masuk ke array
                return $claim;
            });
            // dd($approval);
            $is_success = $approval->insert($data_approval->toArray());
            if ($is_success) {
                Alert::success("Success", "Contract berhasil dilock");
                // toast("Contract berhasil dilock", "success")->autoClose(3000);
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            } else {
                Alert::error("Error", "Contract gagal dilock");
                // toast("Contract gagal dilock", "error")->autoClose(3000);
                return response()->json([
                    "status" => "error",
                    "link" => false,
                ]);
            }
        }

        // dd("Success!!");
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

        $approval->total_request_unlock = $approval->total_request_unlock + 1;
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

        $month = (int) date('m') == 1 ? 12 : ((int)date('d') < 15 ? (int) date('m') : (int) date('m') - 1);

        $periode = !empty($data['periode']) ? $data['periode'] : $month;

        $approval = ContractApproval::where("id_contract", "=", $id_contract)->where("periode", $periode);
        // dd($periode, $approval->update(['is_approved' => $data['approve']]));

        // $approval->is_approved = $data["approve"];

        // $approval->save();

        // dd($this->sendDataSAP($id_contract, $periode));

        if ($data["approve"] == 't') {
            $update = $approval->update(['is_approved' => $data['approve']]);
            if ($update) {
                $get_response = $this->sendDataSAP($id_contract, $periode);
                if ($get_response->original["statusCode"] == 200) {
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
            } else {
                Alert::error("error", "Contract gagal di Approve, Hubungi Admin");
                return response()->json([
                    "status" => "error",
                    "link" => false,
                ]);
            }

        }else{
            $update = $approval->update(['is_approved' => $data['approve']]);
            if ($update) {
                return response()->json([
                "status" => "success",
                "link" => true,
                ]);
            }
        }

    }

    function setLogging($file, $message, $data)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/$file.log"),
        ])->info("$message", $data);
    }
}
