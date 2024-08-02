<?php

namespace App\Http\Controllers;

use App\Models\ContractApproval;
use App\Models\ContractManagements;
use App\Models\PerubahanKontrak;
use App\Models\ProyekPISNew;
use App\Models\UnitKerja;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use stdClass;
use Illuminate\Support\Facades\Log;


class ContractApprovalController extends Controller
{
    private function sendDataSAP($id_contract, $periode)
    {
        // $claims_all = PerubahanKontrak::all();
        // $claims_all = ContractApproval::whereIn("jenis_perubahan", ["VO", "Klaim"])->whereIn("stage", [1, 2, 4, 5])->where("id_contract", "=", $id_contract)->where('periode', '=', $periode)->get();
        $claims_all = ContractApproval::whereIn("jenis_perubahan", ["VO", "Klaim"])
        ->whereIn("stage", [1, 2, 4, 5])
            ->where(function ($query) use ($id_contract) {
                $query->where("id_contract", $id_contract)
                    ->orWhere("profit_center", $id_contract);
            })
            ->where('periode_laporan', '=', $periode)->get();
        $data_claims_potential = $claims_all->map(function ($item, $key) use ($claims_all) {

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function ($i, $key) use ($item) {
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function ($ic) use ($item) {
                if ($item->stage >= 1) {
                    return (int) $ic->stage >= 1;
                }
            })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if ($item->stage == 4) {
            //         return (int) $ic->stage == 4;
            //     }elseif($item->stage == 5){
            //         return (int) $ic->stage == 5;
            //     } elseif ($item->stage >= 2) {
            //         return (int) $ic->stage >= 2;
            //     } elseif ($item->stage >= 1) {
            //         return (int) $ic->stage >= 1;
            //     }
            // })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if($item->stage == 1 ){
            //         return $ic->stage == 1;
            //     }elseif($item->stage == 2){
            //         return $ic->stage == 2;
            //     }elseif($item->stage == 5){
            //         return $ic->stage == 5;
            //     }
            // })->count();

            $uraian_formatted = substr(preg_replace('/\s+/', ' ', str_replace('"', '', $item->uraian_perubahan)), 0, 255);
            $uraian_formatted = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $uraian_formatted), 0, 255);

            // $profit_center = $item->Proyeks->profit_center;
            $profit_center = $item->profit_center;
            $newClass = new stdClass();

            $newClass->NO_PROPOSAL_CLAIM = $item->proposal_klaim;
            $newClass->TANGGAL = (int) date("Ymd");
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$uraian_formatted";

            if ($item->stage >= 1) {
                $newClass->CLAIM_CAT = "ITEM POTENTIAL";
            };

            // if ($item->stage == 4) {
            //     $newClass->CLAIM_CAT = "ITEM NEGOTIATION";
            // }elseif($item->stage == 5){
            //     $newClass->CLAIM_CAT = "ITEM APPROVED";
            // } elseif ($item->stage >= 2) {
            //     $newClass->CLAIM_CAT = "ITEM SUBMISSION";
            // } elseif ($item->stage >= 1) {
            //     $newClass->CLAIM_CAT = "ITEM POTENTIAL";
            // };

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

            if ($item->stage == 5) {
                if ($item->jenis_perubahan == "VO") {
                    if ($item->nilai_negatif) {
                        $newClass->CLAIM_AMOUNT = 0 - (int)$item->nilai_disetujui;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                    }
                } else {
                    $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                }
            } else {
                if ($item->jenis_perubahan == "VO") {
                    if ($item->nilai_negatif) {
                        $newClass->CLAIM_AMOUNT = 0 - (int)$item->biaya_pengajuan;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                    }
                } else {
                    $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                }
            }

            // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");

            // $newClass->CLAIM_VAL = $claims_all->groupBy("jenis_perubahan")->map(function($i, $key) use($item){
            //     return $key = $i->count();
            // })->get($item->jenis_perubahan);

            if ($item->jenis_perubahan == "Klaim") {
                $newClass->CATEGORY = "CLAIM";
            } else {
                $newClass->CATEGORY = "$item->jenis_perubahan";
            }

            return $newClass;
        })->values();

        $data_claims_submission = $claims_all->filter(function ($item) {
            return $item->stage >= 2;
        })->map(function ($item, $key) use ($claims_all) {

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function ($i, $key) use ($item) {
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function ($ic) use ($item) {
                if ($item->stage >= 2) {
                    return (int) $ic->stage >= 2;
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

            $uraian_formatted = substr(preg_replace('/\s+/', ' ', str_replace('"', '', $item->uraian_perubahan)), 0, 255);
            $uraian_formatted = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $uraian_formatted), 0, 255);

            // $profit_center = $item->Proyeks->profit_center;
            $profit_center = $item->profit_center;
            $newClass = new stdClass();

            $newClass->NO_PROPOSAL_CLAIM = $item->proposal_klaim;
            $newClass->TANGGAL = (int) date("Ymd");
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$uraian_formatted";

            if ($item->stage >= 2) {
                $newClass->CLAIM_CAT = "ITEM SUBMISSION";
            }

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

            if ($item->stage == 5) {
                if ($item->jenis_perubahan == "VO") {
                    if ($item->nilai_negatif) {
                        $newClass->CLAIM_AMOUNT = 0 - (int)$item->nilai_disetujui;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                    }
                } else {
                    $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                }
            } else {
                if ($item->jenis_perubahan == "VO") {
                    if ($item->nilai_negatif) {
                        $newClass->CLAIM_AMOUNT = 0 - (int)$item->biaya_pengajuan;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                    }
                } else {
                    $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                }
            }

            // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");

            // $newClass->CLAIM_VAL = $claims_all->groupBy("jenis_perubahan")->map(function($i, $key) use($item){
            //     return $key = $i->count();
            // })->get($item->jenis_perubahan);

            if ($item->jenis_perubahan == "Klaim") {
                $newClass->CATEGORY = "CLAIM";
            } else {
                $newClass->CATEGORY = "$item->jenis_perubahan";
            }

            return $newClass;
        })->values();

        $data_claims_filter = $claims_all->filter(function ($item) {
            return $item->stage == 4 || $item->stage == 5;
        })->map(function ($item, $key) use ($claims_all) {

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function($i, $key) use($item){
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function($ic) use($item){
                if ($item->stage == 4) {
                    return (int) $ic->stage == 4;
                }elseif($item->stage == 5){
                    return (int) $ic->stage == 5;
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

            $uraian_formatted = substr(preg_replace('/\s+/', ' ', str_replace('"', '', $item->uraian_perubahan)), 0, 255);
            $uraian_formatted = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $uraian_formatted), 0, 255);

            // $profit_center = $item->Proyeks->profit_center;
            $profit_center = $item->profit_center;
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
            }

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

            if ($item->stage == 5) {
                if ($item->jenis_perubahan == "VO") {
                    if ($item->nilai_negatif) {
                        $newClass->CLAIM_AMOUNT = 0 - (int)$item->nilai_disetujui;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                    }
                } else {
                    $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                }
            } else {
                if ($item->jenis_perubahan == "VO") {
                    if ($item->nilai_negatif) {
                        $newClass->CLAIM_AMOUNT = 0 - (int)$item->biaya_pengajuan;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                    }
                } else {
                    $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                }
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

        $data_claims = $data_claims_potential->merge($data_claims_submission)->merge($data_claims_filter);

        // return response()->json($data_claims->toArray(), 200);
        // dump(
        //     $data_claims->toArray()
        // );

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
                "KODE_PROYEK" => $claims_all->first()?->profit_center,
                "DATA" => $data_claims->toArray() ?? [],
                "STATUS" => "SUCCESS"
            ]);

            $response_success = [
                "statusCode" => 200,
                "message" => "success"
            ];

            return response()->json($response_success);
        } else {
            $this->setLogging('ccm_approval', "APPROVAL CCM => ", [
                "KODE_PROYEK" => $claims_all->first()?->profit_center,
                "DATA" => $data_claims->toArray() ?? [],
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
                $unitkerjas = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
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

            if (!empty($filterBulan) && $filterTahun >= 2023) {
                $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
            }else{
                if($filterTahun < 2023 && !empty($filterBulan)){
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }elseif($filterTahun < 2023 && empty($filterBulan)){
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                }else{
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $month)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
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

            if (Gate::any(["admin-ccm"])) {
                if (!empty($filterBulan) && $filterTahun >= 2023) {
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                } else {
                    if ($filterTahun < 2023 && !empty($filterBulan)) {
                        $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                    } elseif ($filterTahun < 2023 && empty($filterBulan)) {
                        $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                    } else {
                        $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $month)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->get()->groupBy('kode_proyek');
                    }
                }
            } elseif (Gate::any(["user-ccm"]) && !empty(Auth::user()->proyeks_selected)) {
                $proyekSelected = !empty(Auth::user()->proyeks_selected) ? json_decode(Auth::user()->proyeks_selected) : [];
                if (!empty($filterBulan) && $filterTahun >= 2023) {
                    $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->whereIn('profit_center', $proyekSelected)->get()->groupBy('kode_proyek');
                } else {
                    if ($filterTahun < 2023 && !empty($filterBulan)) {
                        $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->whereIn('profit_center', $proyekSelected)->get()->groupBy('kode_proyek');
                    } elseif ($filterTahun < 2023 && empty($filterBulan)) {
                        $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->whereIn('profit_center', $proyekSelected)->get()->groupBy('kode_proyek');
                    } else {
                        $contract_approval = ContractApproval::where("tahun", "=", $filterTahun)->where("periode_laporan", "=", $month)->whereIn("unit_kerja", $unit_kerja_get)->where("is_locked", "!=", false)->whereIn('profit_center', $proyekSelected)->get()->groupBy('kode_proyek');
                    }
                }
            } else {
                $contract_approval = null;
            }
        }

        if (!empty($contract_approval)) {
            $approvals = $contract_approval->map(function ($approval) {
                // dump($approval->first()->Proyeks->nama_proyek);
                // $nama_proyek = $approval->first()->Proyeks->nama_proyek;
                $nama_proyek = $approval->first()->ProyekPISNew->proyek_name;
                //Kategori VO
                $cat_vo = $approval->where("jenis_perubahan", "=", "VO");
                $item_vo = $cat_vo->count();
                $jumlah_vo = $cat_vo->sum("biaya_pengajuan");
                $item_vo_approve = $cat_vo->where("stage", 5)->count();
                $jumlah_vo_approve = $cat_vo->where("stage", 5)->sum(function ($item) {
                    if ($item->nilai_negatif) {
                        return 0 - (int)$item->nilai_disetujui;
                    }
                    return (int)$item->nilai_disetujui;
                });
                // dd($item_vo, $jumlah_vo);

                //Kategori Klaim
                $cat_klaim = $approval->where("jenis_perubahan", "=", "Klaim");
                $item_klaim = $cat_klaim->count();
                $jumlah_klaim = $cat_klaim->sum("biaya_pengajuan");
                $item_klaim_approve = $cat_klaim->where("stage", 5)->count();
                $jumlah_klaim_approve = $cat_klaim->where("stage", 5)->sum(function ($item) {
                    return (int) $item->nilai_disetujui;
                });
                // dd($item_klaim, $jumlah_klaim);

                //Kategori ANti Klaim
                $cat_anti_klaim = $approval->where(
                    "jenis_perubahan",
                    "=",
                    "Anti Klaim"
                );
                $item_anti_klaim = $cat_anti_klaim->count();
                $jumlah_anti_klaim = $cat_anti_klaim->sum("biaya_pengajuan");
                $item_anti_klaim_approve = $cat_anti_klaim->where("stage", 5)->count();
                $jumlah_anti_klaim_approve = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                    return (int) $item->nilai_disetujui;
                });
                // dd($item_anti_klaim, $jumlah_anti_klaim);

                //Kategori Klaim Asuransi
                $cat_klaim_asuransi = $approval->where("jenis_perubahan", "=", "Klaim Asuransi");
                $item_klaim_asuransi = $cat_klaim_asuransi->count();
                $jumlah_klaim_asuransi = $cat_klaim_asuransi->sum("biaya_pengajuan");
                $item_klaim_asuransi_approve = $cat_klaim_asuransi->where("stage", 5)->count();
                $jumlah_klaim_asuransi_approve = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                    return (int) $item->nilai_disetujui;
                });
                // dd($item_klaim_asuransi, $jumlah_klaim_asuransi);


                switch ($approval->first()->periode_laporan) {
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
                    'profit_center' => $approval->first()->profit_center,
                    'nama_proyek' => $nama_proyek,
                    'jumlah_vo' => $jumlah_vo,
                    'jumlah_klaim' => $jumlah_klaim,
                    'jumlah_anti_klaim' => $jumlah_anti_klaim,
                    'jumlah_klaim_asuransi' => $jumlah_klaim_asuransi,
                    'total_vo' => $item_vo,
                    'total_klaim' => $item_klaim,
                    'total_anti_klaim' => $item_anti_klaim,
                    'total_klaim_asuransi' => $item_klaim_asuransi,
                    'total_vo_approve' => $item_vo_approve,
                    'jumlah_vo_approve' => $jumlah_vo_approve,
                    'total_klaim_approve' => $item_klaim_approve,
                    'jumlah_klaim_approve' => $jumlah_klaim_approve,
                    'total_anti_klaim_approve' => $item_anti_klaim_approve,
                    'jumlah_anti_klaim_approve' => $jumlah_anti_klaim_approve,
                    'total_klaim_asuransi_approve' => $item_klaim_asuransi_approve,
                    'jumlah_klaim_asuransi_approve' => $jumlah_klaim_asuransi_approve,
                    // 'nilai_kontrak' => $approval->first()->Proyeks->nilai_kontrak ?? 0,
                    'nilai_kontrak' => $approval->first()->ProyekPISNew->contract_value_idr ?? 0,
                    'periode' => $month,
                    // 'unit_kerja' => $approval->first()->Proyeks->UnitKerja->unit_kerja,
                    'unit_kerja' => $approval->first()->ProyekPISNew->UnitKerja->unit_kerja,
                    'is_approved' => $approval->first()->is_approved,
                    'is_request_unlock' => $approval->first()->is_request_unlock,
                ];
            });
        } else {
            $approvals = collect([]);
        }


        // dd($approvals);

        // $is_exist_history = ContractApproval::where("periode_laporan", $periode)->where("is_locked", "!=", false)->get();
        // dd($contract_approval->groupBy('kode_proyek'));
        return view("15_CCM_Approval", compact(["approvals", "tahun_proyeks", "filterTahun", "month", "filterBulan", "unit_kerjas_select", "filterUnit", "user"]));
    }

    // public function lockApproval(Request $request){
    //     $data = $request->all();
    //     // return response()->json($data, 200);
    //     // dd((int)$data["periode_laporan"], (int)date('d'));

    //     $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

    //     $contract = ContractManagements::where("id_contract", "=", $data["id_contract"])->first();

    //     $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode_laporan", $month)->first();

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

    //     $periode_approval = $data["periode_laporan"] == 1 ? 12 : $data["periode_laporan"];

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
    //         $approve->periode = $data["periode_laporan"] == 1 ? 12 : $data["periode_laporan"] - 1;
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
        $approval = ContractApproval::where(function ($query) use ($data) {
            $query->where('id_contract', $data['id_contract'])
            ->orWhere('profit_center', $data['profit_center']);
        })->where('periode_laporan', '=', $data["periode"])->get();
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
            'stage',
            'profit_center',
            'nilai_negatif'
        ])->where(function ($query) use ($data) {
            $query->where('id_contract', $data['id_contract'])
            ->orWhere('profit_center', $data['profit_center']);
        })->get();

        // dd($approval);
        if ($approval->isNotEmpty()) {
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
            try {
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
                    // $claim['periode'] = $periode;
                    $claim['id'] = Str::uuid()->toString();
                    $claim['periode_laporan'] = $periode;
                    $claim['tahun'] = date('Y');
                    // $claim['unit_kerja'] = $claim->Proyek->unit_kerja;
                    $claim['unit_kerja'] = $claim->ProyekPISNew->kd_divisi;
                    $claim['is_locked'] = true;
                    $claim->nilai_negatif = $claim->nilai_negatif ?: false;
                    // $claim['perubahan_id'] = $claim->id;
                    // $claim->makeHidden(['Proyek', 'id']); //Untuk menghilangkan relasi agar tidak masuk ke array
                    $claim->makeHidden(['ProyekPISNew', 'id_perubahan_kontrak']); //Untuk menghilangkan relasi agar tidak masuk ke array
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
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // dd("Success!!");
    }

    public function setUnlock(Request $request){
        $data = $request->all();

        $month = (int)date("m") == 1 ? 12 : (int)date("m")-1;

        $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode_laporan", $month)->first();

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

        $approval = ContractApproval::where("id_contract", "=", $data["id_contract"])->where("periode_laporan", $month)->first();

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

        // $approval = ContractApproval::where("id_contract", "=", $id_contract)->where("periode_laporan", $periode);
        $approval = ContractApproval::where(function ($query) use ($id_contract) {
            $query->where("id_contract", $id_contract)
                ->orWhere("profit_center", $id_contract);
        })->where("periode_laporan", $periode);
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







    //Menu History Autorisasi
    public function viewHistoryLaporan(Request $request)
    {
        $data = $request->all();

        $periodeOtor = (int)date("m") == 1 ? 12 : (int)date("m") - 1;

        $periodeOtor = isset($data["periode-prognosa"]) ? $data["periode-prognosa"] : $periodeOtor;

        $historyClaims = ContractApproval::where("periode_laporan", $periodeOtor)->where("tahun", date("Y"))->get()->groupBy("unit_kerja");
        // dd($historyClaims);

        $totalItemVOAll = 0;
        $totalItemKlaimAll = 0;
        $totalItemAntiKlaimAll = 0;
        $totalItemKlaimAsuransiAll = 0;

        $totalItemVOAllApproved = 0;
        $totalItemKlaimAllApproved = 0;
        $totalItemAntiKlaimAllApproved = 0;
        $totalItemKlaimAsuransiAllApproved = 0;

        $jumlahVOAll = 0;
        $jumlahKlaimAll = 0;
        $jumlahAntiKlaimAll = 0;
        $jumlahKlaimAsuransiAll = 0;

        $jumlahVOAllApproved = 0;
        $jumlahKlaimAllApproved = 0;
        $jumlahAntiKlaimAllApproved = 0;
        $jumlahKlaimAsuransiAllApproved = 0;


        if (!empty($historyClaims)) {
            $historyClaims = $historyClaims->mapWithKeys(function ($hc, $unitKerja) use (
                &$totalItemVOAll,
                &$totalItemKlaimAll,
                &$totalItemAntiKlaimAll,
                &$totalItemKlaimAsuransiAll,
                &$totalItemVOAllApproved,
                &$totalItemKlaimAllApproved,
                &$totalItemAntiKlaimAllApproved,
                &$totalItemKlaimAsuransiAllApproved,
                &$jumlahVOAll,
                &$jumlahKlaimAll,
                &$jumlahAntiKlaimAll,
                &$jumlahKlaimAsuransiAll,
                &$jumlahVOAllApproved,
                &$jumlahKlaimAllApproved,
                &$jumlahAntiKlaimAllApproved,
                &$jumlahKlaimAsuransiAllApproved,
            ) {
                $jumlahVOAllDivisi = 0;
                $jumlahKlaimAllDivisi = 0;
                $jumlahAntiKlaimAllDivisi = 0;
                $jumlahKlaimAsuransiAllDivisi = 0;

                $jumlahVOAllDivisiApproved = 0;
                $jumlahKlaimAllDivisiApproved = 0;
                $jumlahAntiKlaimAllDivisiApproved = 0;
                $jumlahKlaimAsuransiAllDivisiApproved = 0;

                $unitKerja = UnitKerja::where("divcode", $unitKerja)->first()->unit_kerja;

                $newClass = new stdClass();
                $newClass->unit_kerja = $hc->first()->unit_kerja;
                $newClass->periode_laporan = get_bulan($hc->first()->periode_laporan);
                $newClass->tahun = $hc->first()->tahun;
                $newClass->is_request_unlock = $hc->first()->is_request_unlock;
                $newClass->is_locked = $hc->first()->is_locked;
                $newClass->is_approved = $hc->first()->is_approved;

                $kategoriVO = $hc->where("jenis_perubahan", "VO");
                $kategoriKlaim = $hc->where("jenis_perubahan", "Klaim");
                $kategoriAntiKlaim = $hc->where("jenis_perubahan", "Anti Klaim");
                $kategoriKlaimAsuransi = $hc->where("jenis_perubahan", "Klaim Asuransi");

                foreach ($kategoriVO as $vo) {
                    if (!$vo->nilai_negatif) {
                        $jumlahVOAllDivisi += $vo->biaya_pengajuan;
                        if ($vo->stage == 5) {
                            $jumlahVOAllDivisiApproved += (int)$vo->nilai_disetujui;
                        }
                    } else {
                        $jumlahVOAllDivisi -= $vo->biaya_pengajuan;
                        if ($vo->stage == 5) {
                            $jumlahVOAllDivisiApproved -= (int)$vo->nilai_disetujui;
                        }
                    }
                }

                foreach ($kategoriKlaim as $klaim) {
                    $jumlahKlaimAllDivisi += $klaim->biaya_pengajuan;
                    if ($klaim->stage == 5) {
                        $jumlahKlaimAllDivisiApproved += (int)$klaim->nilai_disetujui;
                    }
                }

                foreach ($kategoriAntiKlaim as $anti_klaim) {
                    $jumlahAntiKlaimAllDivisi -= $anti_klaim->biaya_pengajuan;
                    if ($anti_klaim->stage == 5) {
                        $jumlahAntiKlaimAllDivisiApproved -= (int)$anti_klaim->nilai_disetujui;
                    }
                }

                foreach ($kategoriKlaimAsuransi as $klaim_asuransi) {
                    $jumlahKlaimAsuransiAllDivisi += $klaim_asuransi->biaya_pengajuan;
                    if ($klaim_asuransi->stage == 5) {
                        $jumlahKlaimAsuransiAllDivisiApproved += (int)$klaim_asuransi->nilai_disetujui;
                    }
                }


                $newClass->total_vo_submitted = $kategoriVO->count();
                $newClass->total_vo_approved = $kategoriVO->where("stage", 5)->count();
                $totalItemVOAll += $newClass->total_vo_submitted;
                $totalItemVOAllApproved += $newClass->total_vo_approved;

                $newClass->jumlah_vo_submitted = $jumlahVOAllDivisi;
                $newClass->jumlah_vo_approved = $jumlahVOAllDivisiApproved;
                $jumlahVOAll += $newClass->jumlah_vo_submitted;
                $jumlahVOAllApproved += $newClass->jumlah_vo_approved;

                $newClass->total_klaim_submitted = $kategoriKlaim->count();
                $newClass->total_klaim_approved = $kategoriKlaim->where("stage", 5)->count();
                $totalItemKlaimAll += $newClass->total_klaim_submitted;
                $totalItemKlaimAllApproved += $newClass->total_klaim_approved;

                $newClass->jumlah_klaim_submitted = $jumlahKlaimAllDivisi;
                $newClass->jumlah_klaim_approved = $jumlahKlaimAllDivisiApproved;
                $jumlahKlaimAll += $newClass->jumlah_klaim_submitted;
                $jumlahKlaimAllApproved += $newClass->jumlah_klaim_approved;

                $newClass->total_anti_klaim_submitted = $kategoriAntiKlaim->count();
                $newClass->total_anti_klaim_approved = $kategoriAntiKlaim->where("stage", 5)->count();
                $totalItemAntiKlaimAll += $newClass->total_anti_klaim_submitted;
                $totalItemAntiKlaimAllApproved += $newClass->total_anti_klaim_approved;

                $newClass->jumlah_anti_klaim_submitted = $jumlahAntiKlaimAllDivisi;
                $newClass->jumlah_anti_klaim_approved = $jumlahAntiKlaimAllDivisiApproved;
                $jumlahAntiKlaimAll += $newClass->jumlah_anti_klaim_submitted;
                $jumlahAntiKlaimAllApproved += $newClass->jumlah_anti_klaim_approved;

                $newClass->total_klaim_asuransi_submitted = $kategoriKlaimAsuransi->count();
                $newClass->total_klaim_asuransi_approved = $kategoriKlaimAsuransi->where("stage", 5)->count();
                $totalItemKlaimAsuransiAll += $newClass->total_klaim_asuransi_submitted;
                $totalItemKlaimAsuransiAllApproved += $newClass->total_klaim_asuransi_approved;

                $newClass->jumlah_klaim_asuransi_submitted = $jumlahKlaimAsuransiAllDivisi;
                $newClass->jumlah_klaim_asuransi_approved = $jumlahKlaimAsuransiAllDivisiApproved;
                $jumlahKlaimAsuransiAll += $newClass->jumlah_klaim_asuransi_submitted;
                $jumlahKlaimAsuransiAllApproved += $newClass->jumlah_klaim_asuransi_approved;

                return [$unitKerja => $newClass];
            });
        }

        return view("23_History_Laporan_Approval", compact(
            "historyClaims",
            "periodeOtor",
            "totalItemVOAll",
            "totalItemKlaimAll",
            "totalItemAntiKlaimAll",
            "totalItemKlaimAsuransiAll",
            "totalItemVOAllApproved",
            "totalItemKlaimAllApproved",
            "totalItemAntiKlaimAllApproved",
            "totalItemKlaimAsuransiAllApproved",
            "jumlahVOAll",
            "jumlahKlaimAll",
            "jumlahAntiKlaimAll",
            "jumlahKlaimAsuransiAll",
            "jumlahVOAllApproved",
            "jumlahKlaimAllApproved",
            "jumlahAntiKlaimAllApproved",
            "jumlahKlaimAsuransiAllApproved",
        ));
    }

    public function viewDetailHistoryLaporan(Request $request, $unitKerja, $periodeOtor)
    {
        $data = $request->all();

        $historyClaims = ContractApproval::where("periode_laporan", $periodeOtor)->where("unit_kerja", $unitKerja)->where("tahun", date("Y"))->get()->groupBy("profit_center");
        // dd($historyClaims);

        $totalItemVOAll = 0;
        $totalItemKlaimAll = 0;
        $totalItemAntiKlaimAll = 0;
        $totalItemKlaimAsuransiAll = 0;

        $totalItemVOAllApproved = 0;
        $totalItemKlaimAllApproved = 0;
        $totalItemAntiKlaimAllApproved = 0;
        $totalItemKlaimAsuransiAllApproved = 0;

        $jumlahVOAll = 0;
        $jumlahKlaimAll = 0;
        $jumlahAntiKlaimAll = 0;
        $jumlahKlaimAsuransiAll = 0;

        $jumlahVOAllApproved = 0;
        $jumlahKlaimAllApproved = 0;
        $jumlahAntiKlaimAllApproved = 0;
        $jumlahKlaimAsuransiAllApproved = 0;


        if (!empty($historyClaims)) {
            $historyClaims = $historyClaims->mapWithKeys(function ($hc, $proyek) use (
                &$totalItemVOAll,
                &$totalItemKlaimAll,
                &$totalItemAntiKlaimAll,
                &$totalItemKlaimAsuransiAll,
                &$totalItemVOAllApproved,
                &$totalItemKlaimAllApproved,
                &$totalItemAntiKlaimAllApproved,
                &$totalItemKlaimAsuransiAllApproved,
                &$jumlahVOAll,
                &$jumlahKlaimAll,
                &$jumlahAntiKlaimAll,
                &$jumlahKlaimAsuransiAll,
                &$jumlahVOAllApproved,
                &$jumlahKlaimAllApproved,
                &$jumlahAntiKlaimAllApproved,
                &$jumlahKlaimAsuransiAllApproved,
            ) {
                $jumlahVOAllDivisi = 0;
                $jumlahKlaimAllDivisi = 0;
                $jumlahAntiKlaimAllDivisi = 0;
                $jumlahKlaimAsuransiAllDivisi = 0;

                $jumlahVOAllDivisiApproved = 0;
                $jumlahKlaimAllDivisiApproved = 0;
                $jumlahAntiKlaimAllDivisiApproved = 0;
                $jumlahKlaimAsuransiAllDivisiApproved = 0;

                $proyek = ProyekPISNew::where("profit_center", $proyek)->first()->proyek_name;

                $newClass = new stdClass();
                $newClass->profit_center = $hc->first()->profit_center;
                $newClass->unit_kerja = UnitKerja::where("divcode", $hc->first()->unit_kerja)->first()->unit_kerja;
                $newClass->periode_laporan = get_bulan($hc->first()->periode_laporan);
                $newClass->tahun = $hc->first()->tahun;
                $newClass->is_request_unlock = $hc->first()->is_request_unlock;
                $newClass->is_locked = $hc->first()->is_locked;
                $newClass->is_approved = $hc->first()->is_approved;

                $kategoriVO = $hc->where("jenis_perubahan", "VO");
                $kategoriKlaim = $hc->where("jenis_perubahan", "Klaim");
                $kategoriAntiKlaim = $hc->where("jenis_perubahan", "Anti Klaim");
                $kategoriKlaimAsuransi = $hc->where("jenis_perubahan", "Klaim Asuransi");

                foreach ($kategoriVO as $vo) {
                    if (!$vo->nilai_negatif) {
                        $jumlahVOAllDivisi += $vo->biaya_pengajuan;
                        if ($vo->stage == 5) {
                            $jumlahVOAllDivisiApproved += (int)$vo->nilai_disetujui;
                        }
                    } else {
                        $jumlahVOAllDivisi -= $vo->biaya_pengajuan;
                        if ($vo->stage == 5) {
                            $jumlahVOAllDivisiApproved -= (int)$vo->nilai_disetujui;
                        }
                    }
                }

                foreach ($kategoriKlaim as $klaim) {
                    $jumlahKlaimAllDivisi += $klaim->biaya_pengajuan;
                    if ($klaim->stage == 5) {
                        $jumlahKlaimAllDivisiApproved += (int)$klaim->nilai_disetujui;
                    }
                }

                foreach ($kategoriAntiKlaim as $anti_klaim) {
                    $jumlahAntiKlaimAllDivisi -= $anti_klaim->biaya_pengajuan;
                    if ($anti_klaim->stage == 5) {
                        $jumlahAntiKlaimAllDivisiApproved -= (int)$anti_klaim->nilai_disetujui;
                    }
                }

                foreach ($kategoriKlaimAsuransi as $klaim_asuransi) {
                    $jumlahKlaimAsuransiAllDivisi += $klaim_asuransi->biaya_pengajuan;
                    if ($klaim_asuransi->stage == 5) {
                        $jumlahKlaimAsuransiAllDivisiApproved += (int)$klaim_asuransi->nilai_disetujui;
                    }
                }


                $newClass->total_vo_submitted = $kategoriVO->count();
                $newClass->total_vo_approved = $kategoriVO->where("stage", 5)->count();
                $totalItemVOAll += $newClass->total_vo_submitted;
                $totalItemVOAllApproved += $newClass->total_vo_approved;

                $newClass->jumlah_vo_submitted = $jumlahVOAllDivisi;
                $newClass->jumlah_vo_approved = $jumlahVOAllDivisiApproved;
                $jumlahVOAll += $newClass->jumlah_vo_submitted;
                $jumlahVOAllApproved += $newClass->jumlah_vo_approved;

                $newClass->total_klaim_submitted = $kategoriKlaim->count();
                $newClass->total_klaim_approved = $kategoriKlaim->where("stage", 5)->count();
                $totalItemKlaimAll += $newClass->total_klaim_submitted;
                $totalItemKlaimAllApproved += $newClass->total_klaim_approved;

                $newClass->jumlah_klaim_submitted = $jumlahKlaimAllDivisi;
                $newClass->jumlah_klaim_approved = $jumlahKlaimAllDivisiApproved;
                $jumlahKlaimAll += $newClass->jumlah_klaim_submitted;
                $jumlahKlaimAllApproved += $newClass->jumlah_klaim_approved;

                $newClass->total_anti_klaim_submitted = $kategoriAntiKlaim->count();
                $newClass->total_anti_klaim_approved = $kategoriAntiKlaim->where("stage", 5)->count();
                $totalItemAntiKlaimAll += $newClass->total_anti_klaim_submitted;
                $totalItemAntiKlaimAllApproved += $newClass->total_anti_klaim_approved;

                $newClass->jumlah_anti_klaim_submitted = $jumlahAntiKlaimAllDivisi;
                $newClass->jumlah_anti_klaim_approved = $jumlahAntiKlaimAllDivisiApproved;
                $jumlahAntiKlaimAll += $newClass->jumlah_anti_klaim_submitted;
                $jumlahAntiKlaimAllApproved += $newClass->jumlah_anti_klaim_approved;

                $newClass->total_klaim_asuransi_submitted = $kategoriKlaimAsuransi->count();
                $newClass->total_klaim_asuransi_approved = $kategoriKlaimAsuransi->where("stage", 5)->count();
                $totalItemKlaimAsuransiAll += $newClass->total_klaim_asuransi_submitted;
                $totalItemKlaimAsuransiAllApproved += $newClass->total_klaim_asuransi_approved;

                $newClass->jumlah_klaim_asuransi_submitted = $jumlahKlaimAsuransiAllDivisi;
                $newClass->jumlah_klaim_asuransi_approved = $jumlahKlaimAsuransiAllDivisiApproved;
                $jumlahKlaimAsuransiAll += $newClass->jumlah_klaim_asuransi_submitted;
                $jumlahKlaimAsuransiAllApproved += $newClass->jumlah_klaim_asuransi_approved;

                return [$proyek => $newClass];
            });
        }

        return view("23_History_Laporan_Approval", compact(
            "historyClaims",
            "periodeOtor",
            "totalItemVOAll",
            "totalItemKlaimAll",
            "totalItemAntiKlaimAll",
            "totalItemKlaimAsuransiAll",
            "totalItemVOAllApproved",
            "totalItemKlaimAllApproved",
            "totalItemAntiKlaimAllApproved",
            "totalItemKlaimAsuransiAllApproved",
            "jumlahVOAll",
            "jumlahKlaimAll",
            "jumlahAntiKlaimAll",
            "jumlahKlaimAsuransiAll",
            "jumlahVOAllApproved",
            "jumlahKlaimAllApproved",
            "jumlahAntiKlaimAllApproved",
            "jumlahKlaimAsuransiAllApproved",
        ));
    }

    public function lockChangeFromBackdoor(Request $request)
    {
        $data = $request->all();

        $claims = PerubahanKontrak::select([
            'id_perubahan_kontrak',
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
            'stage',
            'perubahan_kontrak.profit_center',
            'nilai_negatif',
            'kd_divisi'
        ])->join('proyek_pis_new', 'perubahan_kontrak.profit_center', '=', 'proyek_pis_new.profit_center')->get()->groupBy('kd_divisi');

        $claimsFilter = $claims->filter(function ($item, $key) use ($data) {
            return $key == $data["unitKerja"];
        })->first();

        if (!empty($claimsFilter)) {
            $approval = new ContractApproval();
            $data_approval = $claimsFilter->map(function ($claim) use ($data) {
                // $claim['periode'] = $periode;
                $claim['id'] = Str::uuid()->toString();
                $claim['periode_laporan'] = $data["periode"];
                $claim['tahun'] = date('Y');
                $claim['unit_kerja'] = $claim->kd_divisi;
                $claim['is_locked'] = true;
                $claim->nilai_negatif = $claim->nilai_negatif ?: false;
                // $claim['perubahan_id'] = $claim->id;
                // $claim->makeHidden(['Proyek', 'id']); //Untuk menghilangkan relasi agar tidak masuk ke array
                $claim->makeHidden(['id_perubahan_kontrak', 'kd_divisi']); //Untuk menghilangkan relasi agar tidak masuk ke array
                return $claim;
            });
            // dd($data_approval);
            $is_success = $approval->insert($data_approval->toArray());
            if ($is_success) {
                // Alert::success("Success", "Contract berhasil dilock");
                // toast("Contract berhasil dilock", "success")->autoClose(3000);
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            } else {
                // Alert::error("Error", "Contract gagal dilock");
                // toast("Contract gagal dilock", "error")->autoClose(3000);
                return response()->json([
                    "status" => "error",
                    "link" => false,
                ]);
            }
        }
    }

    public function setApproveFromBackdoor(Request $request)
    {
        $data = $request->all();
        $approval = ContractApproval::select([
            "contract_approval_new.*",
            "proyek_pis_new.kd_divisi",
        ])->join("proyek_pis_new", "contract_approval_new.profit_center", "=", "proyek_pis_new.profit_center")->where("periode_laporan", $data["periode"])->where("tahun", date("Y"))->where("kd_divisi", $data["unitKerja"])->get()->groupBy("profit_center");

        foreach ($approval as $profit_center => $approve) {
            // $update = $approve->update(['is_approved' => "t"]);
            $get_response = $this->sendDataSAP($profit_center, $data["periode"]);
            if ($get_response->original["statusCode"] == 200) {
                dump("success");
            } else {
                dump("fail");
            }
        }

        dd("FINISH");
    }
}
