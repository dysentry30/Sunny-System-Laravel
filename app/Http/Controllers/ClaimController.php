<?php

namespace App\Http\Controllers;

use App\Models\ClaimContractDiajukan;
use App\Models\ClaimContractDisetujui;
use App\Models\ClaimContractDrafts;
use App\Models\ClaimContractNegoisasi;
use DateTime;
use Faker\Core\Uuid;
use App\Models\Proyek;
use App\Models\ClaimDetails;
use Illuminate\Http\Request;
use App\Models\ClaimManagements;
use App\Models\ContractManagements;
use App\Models\Pasals;
use App\Models\PerubahanKontrak;
use App\Models\ReviewContracts;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Google\Service\FactCheckTools\Resource\Claims;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $column = $request->get("column");
    //     $filter = $request->get("filter");
    //     // if (Auth::user()->check_administrator) {
    //     //     $claims = PerubahanKontrak::join("contract_managements", "contract_managements.id_contract", "=", "perubahan_kontrak.id_contract")->select("perubahan_kontrak.*")->get();
    //     // } else {
    //     //     $claims = PerubahanKontrak::join("contract_managements", "contract_managements.id_contract", "=", "perubahan_kontrak.id_contract")->where("contract_managements.unit_kerja", "=", Auth::user()->unit_kerja)->select("perubahan_kontrak.*")->get();
    //     // }
    //     // $claims = PerubahanKontrak::with(["ContractManagement"])->get();
    //     $claims = PerubahanKontrak::all();
    //     // $claims = ContractManagements::with(["project", "PerubahanKontrak"])->get();
    //     // $claims = ContractManagements::get();
    //     $test = $claims->each(function($data){
    //         return $data->ContractManagements;
    //     });

    //     $proyeks = Proyek::all();


    //     // dd($test->groupBy('id_contract'));
    //     if (!empty($column)) {

    //         $proyekClaim = $claims->where('jenis_perubahan', '=', "Klaim")->filter(function($data) use($column, $filter) {
    //             return preg_match("/^$filter/", $data[$column]);
    //         });
            
    //         $proyekAnti = $claims->where('jenis_perubahan', '=', "Anti Klaim")->filter(function($data) use($column, $filter) {
    //             return preg_match("/^$filter/", $data[$column]);
    //         });

    //         $proyekAsuransi = $claims->where('jenis_perubahan', '=', "Klaim Asuransi")->filter(function($data) use($column, $filter) {
    //             return preg_match("/^$filter/", $data[$column]);
    //         });
            
    //         $proyekVos = $claims->where('jenis_perubahan', '=', "VO")->filter(function($data) use($column, $filter) {
    //             return preg_match("/^$filter/", $data[$column]);
    //         });
            
    //     } else {
    //         $proyekClaim = $claims->where('jenis_perubahan', '=', "Klaim")->groupBy('id_contract')->map(function($data){
    //             return $data->first();
    //         });
            
    //         $proyekAnti = $claims->where('jenis_perubahan', '=', "Anti Klaim")->groupBy('id_contract')->map(function($data){
    //             return $data->first();
    //         });
            
    //         $proyekAsuransi = $claims->where('jenis_perubahan', '=', "Klaim Asuransi")->groupBy('id_contract')->map(function($data){
    //             return $data->first();
    //         });
            
    //         $proyekVos = $claims->where('jenis_perubahan', '=', "VO")->groupBy('id_contract')->map(function($data){
    //             return $data->first();
    //         });
    //     }
    //     // dd($proyekClaim);
    //     // dd($proyekAnti);
    //     // dd($proyekAsuransi);
    //     // dd($proyekVos);
    //     return view("5_Claim", compact(["proyekVos" ,"proyekClaim", "proyekAnti", "proyekAsuransi", "column", "filter", "proyeks"]));
    // }

    public function index(Request $request)
    {
        // $filterTahun = $request->query("tahun-proyek") ?? (int) date("Y");
        // $filterUnitKerja = $request->query("unit-kerja");
        // $year = (int) date("Y");
        // $unitkerjas = UnitKerja::get()->whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D"]);
        // $tahun_proyek = Proyek::get()->groupBy("tahun_perolehan")->keys();
        // $filter_unit = $unitkerjas->groupBy("divcode")->keys();
        // $proyeks_all = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->where("tahun_perolehan", "=", $filterTahun)->get();
        // dd($filterUnitKerja);
        // dd($uk_map);
        // $proyeks = ContractManagements::join("proyeks", "contract_managements.project_id", "=", "proyeks.kode_proyek")->get();
        // $claims = $proyeks->map(function($proyek){
        //     $claim = PerubahanKontrak::where("id_contract", "=", $proyek->id_contract)->get();
        //     return $claim;
        // });
        // $proyeks = ContractManagements::with(["project", "PerubahanKontrak"])->get();
        // $claims = $proyeks->map(function($p){
        //     $map = $p->PerubahanKontrak;
        //     return $map;
        // })->flatten();
        // $claim = $claims->map(function($p){
        //     return $p->Proyek;
        // })->groupBy("kode_proyek");
        // $claims = ContractManagements::where("stages", "=", 2)->join("proyeks", "contract_managements.project_id", "=", "proyeks.kode_proyek")->get();
        // dd($filterTahun);
        // if(!empty($filterUnitKerja)){
        //     $proyeks = $proyeks_all->where("unit_kerja", "=", $filterUnitKerja);
        // }else{
        //     $proyeks = $proyeks_all;
        // }
        // dd($proyeks);

        $filterUnitKerja = $request->query("filter-unit");
        $filterJenis = $request->query("filter-jenis");
        $filterTahun = $request->query("tahun-proyek") ?? (int) date("Y");
        $filterBulan = $request->query("bulan-proyek") ?? "";

        $year = (int) date("Y");
        $month = (int) date("m");

        $tahun_proyeks = Proyek::get()->groupBy("tahun_perolehan")->keys();
            // $unitkerjas = UnitKerja::get()->whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8"]);
            // dd($unitkerjas);
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

            // $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            // if(!empty($filterBulan) && $filterTahun == 2023){
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            // }else{
            //     if($filterTahun < 2023 && !empty($filterBulan)){
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     }elseif($filterTahun < 2023 && empty($filterBulan)){
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     }else{
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     }
                
            // }

            $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->get();
            // dd($proyeks_all);
            $proyeks_filter = collect();
            
            if(!empty($filterBulan)){
                $time = Carbon::createFromFormat("m Y", "$filterBulan $filterTahun");
                // dd($time);
            }else{
                $time = Carbon::now();
            }
            foreach(range(1,12) as $item){
                $proyeks_check = collect();
                if(!empty($filterBulan)){
                    // $proyeks_check = $proyeks_all->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
                    $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
                }else{
                    $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", 12);
                }
                // dump($time, (int)$time->format("Y"), (int)$time->format("m"), $proyeks_filter);
                $time = $time->subMonth(1);
                if($proyeks_all->isNotEmpty()){
                    $proyeks_filter->push($proyeks_check);
                }
                // dd($proyeks_all);
            }

            $filter = $proyeks_filter->flatten()->unique()->filter(function($item) use($filterTahun){
                if($filterTahun == 2022){
                    return $item->tahun_perolehan != 2023;
                }else{
                    return $item;
                }
            });


            // dd($proyeks_filter->flatten()->unique());

        // $claims = $proyeks_filter->flatten()->unique()->where("stages", ">=", 2);
        $claims = $filter->where("stages", ">=", 2);
        // dd($claims);

        return view("5_Claim", compact(["claims", "filterUnitKerja", "filterJenis", "unitkerjas", "tahun_proyeks", "filterTahun", "month", "filterBulan", "unit_kerjas_select"]));

    }

    public function view($kode_proyek, $id_contract, Request $request)
    {
        // $filterBulan = $request->query("bulan-perubahan");
        $filterStatus = $request->query("stage");
        // dd($filterStatus);
        // $filterBulan = $data["bulan-perubahan"];

        // $monthNow = new DateTime("M");
        $contracts = ContractManagements::where("id_contract", "=", $id_contract)->first();
        $proyek = Proyek::where("kode_proyek", "=", $kode_proyek)->first();

        if(!empty($filterStatus)){
            $claims = PerubahanKontrak::where("id_contract", "=", $id_contract)->where("stage", "=", $filterStatus)->get();
        }else{
            $claims = PerubahanKontrak::where("id_contract", "=", $id_contract)->get();
        }

        $claim_all = PerubahanKontrak::where("id_contract", "=", $id_contract)->get(); 

        // dd($contract);

        $claims_vo = $claims->where("jenis_perubahan", "=", "VO");
        $claims_klaim = $claims->where("jenis_perubahan", "=", "Klaim");
        $claims_anti_klaim = $claims->where("jenis_perubahan", "=", "Anti Klaim");
        $claims_klaim_asuransi = $claims->where("jenis_perubahan", "=", "Klaim Asuransi");
        // dd($claims_vo);

        return view("claimManagement/viewDetail", compact(["contracts", "claims_vo", "claims_klaim", "claims_anti_klaim", "claims_klaim_asuransi", "proyek", "claim_all"]));
    }

    // public function viewClaim($id_proyek, $jenis_claim)
    // {
    //     $proyek = Proyek::find($id_proyek);
    //     $claim = $proyek->ContractManagements->PerubahanKontrak;
    //     // dd($claim);
    //     $jenis_claim = str_replace('-', ' ', $jenis_claim);
    //     $proyekClaim = $claim->where("jenis_perubahan", "=", $jenis_claim);
    //     // foreach ($claim as $claims) {
    //     //     if ($claims->jenis_claim == $jenis_claim) {
    //     //         array_push($proyekClaim, $claims);
    //     //     }
    //     // }

    //     // dd($jenis_claim);

    //     // $proyekClaim = ClaimManagements::where('jenis_claim', "=", "Claim")->get();


    //     return view("claimManagement/viewClaim", ['proyekClaims' => $proyekClaim, 'proyek' => $proyek, "jenis_claim" => $jenis_claim]);
    // }

    public function claimDelete(Request $request)
    {
        $data = $request->all();
        $claim = ClaimManagements::find($data["id-claim"]);
        ClaimDetails::where("id_claim", "=", $claim->id_claim)->get()->each(function ($approval) {
            Storage::disk("public/words")->delete($approval->id_document . ".docx");
            $approval->delete();
        });
        if ($claim->delete()) {
            Alert::success("Success", "Claim berhasil dihapus");
            return redirect("/claim-management");
        }
        Alert::error("Error", "Claim gagal dihapus");
        return redirect("/claim-management");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new(Proyek $proyek, $contract)
    {
        // $contract = urldecode(urldecode($contract));
        $contract = url_encode($contract);
        $contract = ContractManagements::find($contract);
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

    //New Claim
    public function newClaim(Request $request) {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "Field di atas wajib diisi string",
        ];
        $rules = [
            "kode-proyek" => "required|string",
            "jenis-perubahan" => "required|string",
            "tanggal-perubahan" => "required|string",
            "uraian-perubahan" => "required|string",
            "proposal-klaim" => "required|string",
            "tanggal-pengajuan" => "required|string",
            "biaya-pengajuan" => "required|string",
            "waktu-pengajuan" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Alert::error('Error', "Perubahan Kontrak gagal ditambahkan");
            return Redirect::back();
            // return Redirect::back();
            // dd($validation->errors());
        }

        $validation->validate();
        // if(isset($data["id-perubahan-kontrak"])) {
        //     $perubahan_kontrak = PerubahanKontrak::find($data["id-perubahan-kontrak"]);
        //     $perubahan_kontrak->id_contract = $data["id-contract"];
        //     $perubahan_kontrak->jenis_perubahan = $data["jenis-perubahan"];
        //     $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
        //     $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
        //     // $perubahan_kontrak->jenis_dokumen = $data["jenis-dokumen"];
        //     // $perubahan_kontrak->instruksi_owner = $data["instruksi-owner"];
        //     $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
        //     $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
        //     $perubahan_kontrak->biaya_pengajuan = str_replace(".", "", $data["biaya-pengajuan"]);
        //     $perubahan_kontrak->waktu_pengajuan = $data["waktu-pengajuan"];
        //     $perubahan_kontrak->stage = 1;
        //     if ($perubahan_kontrak->save()) {
        //         Alert::success("Success", "Perubahan Kontrak berhasil diperbarui");
        //         return redirect()->back();
        //     }
        //     Alert::error("Erorr", "Perubahan Kontrak gagal diperbarui");
        //     return Redirect::back();
        // } else {
            $contract = ContractManagements::where("project_id", "=", $data["kode-proyek"])->first();
            $perubahan_kontrak = new PerubahanKontrak();
            $perubahan_kontrak->kode_proyek = $data["kode-proyek"];
            $perubahan_kontrak->id_contract = $contract->id_contract;
            $perubahan_kontrak->jenis_perubahan = $data["jenis-perubahan"];
            $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
            $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
            // $perubahan_kontrak->jenis_dokumen = $data["jenis-dokumen"];
            // $perubahan_kontrak->instruksi_owner = $data["instruksi-owner"];
            $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
            $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
            $perubahan_kontrak->biaya_pengajuan = str_replace(".", "", $data["biaya-pengajuan"]);
            $perubahan_kontrak->waktu_pengajuan = $data["waktu-pengajuan"];
            $perubahan_kontrak->stage = 1;
            // dd($perubahan_kontrak);
            if ($perubahan_kontrak->save()) {
                Alert::success("Success", "Perubahan Kontrak berhasil ditambahkan");
                return redirect()->back();
            }
            Alert::error("Erorr", "Perubahan Kontrak gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
        // }
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
            "required" => "Field ini mandatory",
            "string" => "Field ini harus Alphanumeric",
            "date" => "Field ini harus berisikan tanggal",
        ];
        $rules = [
            "approve-date" => "required|date",
            "pic" => "required|string",
            "project-id" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("approve-date");
            $request->old("pic");
            // $request->old("project-id");
            // $request->old("id-contract");
            $request->old("number-claim");
            Alert::error("Error", "Klaim gagal dibuat!");
            return redirect()->back();
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
        $claimManagements->nilai_claim = (int) str_replace(",", "", $data["total-claim"]);

        if ($claimManagements->save()) {
            Alert::success("Success", "Claim Berhasil Ditambahkan");
            return redirect("/contract-management/view/" . $data["id-contract"]);
        }
        Alert::error("Error", "Claim Gagal Ditambahkan");
        return redirect("/claim-management");
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
        dd($claim_management);
        return view("claimManagement/new", ["currentContract" => $claim_management->contract, "claimContract" => $claim_management, "proyek" => $claim_management->project, "pasals" => Pasals::all()]);
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
            "required" => "Field ini mandatory",
            "numeric" => "Field ini hanya berisi angka",
            "string" => "Field ini harus Alphanumeric",
            "date" => "Field ini harus berisikan tanggal",
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
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $validation->validate();
        $claimManagements->kode_proyek = $data["project-id"];
        $claimManagements->id_contract = $data["id-contract"];
        $claimManagements->tanggal_claim = new DateTime($data["approve-date"]);
        $claimManagements->pic = $data["pic"];
        $claimManagements->nilai_claim = (int) str_replace(",", "", $data["total-claim"]);

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
            "required" => "Field ini mandatory",
            "numeric" => "Field ini hanya berisi angka",
            "string" => "Field ini harus Alphanumeric",
            "file" => "Field ini harus berisi file"
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
        // if (!empty($request->get("stage-disetujui"))) {
        //     $stage = 2;
        // } else if (!empty($request->get("stage-ditolak"))) {
        //     $stage = 3;
        // } elseif (!empty($request->get("stage-cancel"))) {
        //     $stage = 4;
        // }

        $claimManagement = ClaimManagements::find($id_claim);
        if ($claimManagement instanceof ClaimManagements) {
            $claimManagement->stages = $stage;
            if ($claimManagement->save()) {
                return response()->json([
                    "status" => "success",
                ]);
                // Alert::success("Success", "Stage berhasil diperbarui");
                // return redirect()->back();
            }
        }
        return response()->json([
            "status" => "failed",
        ]);
        // Alert::error("Error", "Stage gagal diperbarui");
        // return redirect()->back();
    }

    public function claimDraftUpload(Request $request, ClaimContractDrafts $claimContractDrafts)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field ini mandatory",
            "numeric" => "Field ini hanya berisi angka",
            "string" => "Field ini harus Alphanumeric",
            "file" => "Field ini harus berisi file",
            "not_in" => "Field ini harus lebih besar dari 0",
            "mimes" => "Field ini harus berextensi :values"
        ];
        $rules = [
            "surat-instruksi" => "required|file|mimes:docx",
            "proposal-claim" => "required|file|mimes:docx",
            "no-draft-claim" => "required",
            "uraian-claim" => "required|string",
            "rekomendasi" => "required|boolean",
            "uraian-rekomendasi" => "required|string",
            "pengajuan-biaya" => "required|not_in:0",
            "pengajuan-waktu" => "required|date",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            if (!Session::has("pasals")) {
                session()->flash("pasal-error", true);
            }
            $request->old("no-draft-claim");
            $request->old("uraian-claim");
            $request->old("rekomendasi");
            $request->old("uraian-rekomendasi");
            $request->old("pengajuan-biaya");
            $request->old("pengajuan-waktu");
            Alert::toast("Gagal membuat Klaim Kontrak Draft", "error")->autoClose(3000)->timerProgressBar(true);
            redirect()->back()->with("modal", $data["modal-name"]);
        }
        $validation->validate();
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            $request->old("no-draft-claim");
            $request->old("uraian-claim");
            $request->old("rekomendasi");
            $request->old("uraian-rekomendasi");
            $request->old("pengajuan-biaya");
            $request->old("pengajuan-waktu");
            Alert::toast("Pastikan kontrak sudah dibuat!", "error")->autoClose(3000)->timerProgressBar(true);
            return Redirect::back()->with("modal", $data["modal-name"]);
        }

        $pasals = [];
        if (Session::has("pasals")) {
            foreach (Session::get("pasals") as $pasal) {
                if ($pasal instanceof Pasals) {
                    array_push($pasals, $pasal->id_pasal);
                } else {
                    array_push($pasals, $pasal->pasal);
                }
            }
            Session::forget("pasals");
        } else {
            Alert::toast("Pastikan pasal sudah ditambahkan!", "error")->autoClose(3000)->timerProgressBar(true);
            return Redirect::back()->with("modal", $data["modal-name"]);
        }

        $faker = new Uuid;
        $id_document_proposal_claim = $faker->uuid3();
        $id_document_surat_instruksi = $faker->uuid3();

        if (isset($data["dokumen-pendukung"])) {
            $list_id_document_pendukung = collect();
            if (count($data["dokumen-pendukung"]) > 1) {
                foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                    $id_document = $faker->uuid3();
                    // array_push($list_id_document_pendukung, $id_document);
                    $list_id_document_pendukung->push($id_document);
                    moveFileTemp($dokumen_pendukung, $id_document);
                }
                $claimContractDrafts->dokumen_pendukung = $list_id_document_pendukung->join(",");
            } else {
                $id_document = $faker->uuid3();
                moveFileTemp($data["dokumen-pendukung"][0], $id_document);
                // $list_id_document_pendukung->push($id_document);
                $claimContractDrafts->dokumen_pendukung = $id_document . ",";
            }
        }

        $claimContractDrafts->id_claim = $data["id-claim"];
        $claimContractDrafts->no_claim_draft = $data["no-draft-claim"];
        $claimContractDrafts->uraian_claim_draft = $data["uraian-claim"];
        $claimContractDrafts->id_document_proposal_claim = $id_document_proposal_claim;
        $claimContractDrafts->id_document_surat_instruksi = $id_document_surat_instruksi;
        $claimContractDrafts->pengajuan_biaya = (int) str_replace(",", "", $data["pengajuan-biaya"]);
        $claimContractDrafts->rekomendasi = (bool) $data["rekomendasi"];
        $claimContractDrafts->uraian_rekomendasi = $data["uraian-rekomendasi"];
        $claimContractDrafts->pengajuan_waktu_eot = $data["pengajuan-waktu"];
        $claimContractDrafts->pasals = join(",", $pasals);
        if ($claimContractDrafts->save()) {
            $claim_management = ClaimManagements::find($data["id-claim"]);
            $claim_management->save();
            // Session::forget("pasals");
            moveFileTemp($data["proposal-claim"], $id_document_proposal_claim);
            moveFileTemp($data["surat-instruksi"], $id_document_surat_instruksi);
            Alert::success("Success", "Berhasil membuat Klaim Kontrak Draft");
            return redirect()->back();
        }

        Alert::error("Error", "Gagal membuat Klaim Kontrak Draft");
        return Redirect::back();
    }

    public function claimDiajukanUpload(Request $request, ClaimContractDiajukan $claimContractDiajukan)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field ini mandatory",
            "string" => "Field ini harus Alphanumeric",
            "file" => "Field ini harus berisi file",
            "date" => "Field ini harus berisi tanggal"
        ];
        $rules = [
            "tanggal-diajukan" => "required|date",
            "proposal-claim" => "required|file",
            "diajukan-rekomendasi" => "required|string",
            "uraian-rekomendasi" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("tanggal-diajukan");
            $request->old("diajukan-rekomendasi");
            $request->old("uraian-rekomendasi");
            Alert::toast("Klaim Diajukan gagal disimpan", "error");
            redirect()->back()->with("modal", $data["modal-name"]);
        }
        $validation->validate();

        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            $request->old("tanggal-diajukan");
            $request->old("diajukan-rekomendasi");
            $request->old("uraian-rekomendasi");
            Alert::toast("Pastikan kontrak sudah dibuat!", "error")->autoClose(3000)->timerProgressBar(true);
            return Redirect::back()->with("modal", $data["modal-name"]);
        }

        $faker = new Uuid;
        $id_document_proposal_claim = $faker->uuid3();
        if (isset($data["dokumen-pendukung"])) {
            $list_id_document_pendukung = collect();
            if (count($data["dokumen-pendukung"]) > 1) {
                foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                    $id_document = $faker->uuid3();
                    // array_push($list_id_document_pendukung, $id_document);
                    $list_id_document_pendukung->push($id_document);
                    moveFileTemp($dokumen_pendukung, $id_document);
                }
                $claimContractDiajukan->dokumen_pendukung = $list_id_document_pendukung->join(",");
            } else {
                $id_document = $faker->uuid3();
                moveFileTemp($data["dokumen-pendukung"][0], $id_document);
                // $list_id_document_pendukung->push($id_document);
                $claimContractDiajukan->dokumen_pendukung = $id_document . ",";
            }
        }

        $claimContractDiajukan->id_claim = $data["id-claim"];
        $claimContractDiajukan->id_document_proposal_claim = $id_document_proposal_claim;
        $claimContractDiajukan->tanggal_diajukan = $data["tanggal-diajukan"];
        $claimContractDiajukan->rekomendasi = (bool) $data["diajukan-rekomendasi"];
        $claimContractDiajukan->uraian_rekomendasi = $data["uraian-rekomendasi"];
        if ($claimContractDiajukan->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["proposal-claim"], $id_document_proposal_claim);
            Alert::success("Success", "Klaim Diajukan berhasil disimpan");
            return redirect()->back();
        }

        Alert::error("Error", "Klaim Diajukan gagal disimpan");
        return Redirect::back();
    }

    public function claimNegosiasiUpload(Request $request, ClaimContractNegoisasi $claimContractNegoisasi)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field ini mandatory",
            "string" => "Field ini harus Alphanumeric",
            "file" => "Field ini harus berisi file",
            "date" => "Field ini harus berisi tanggal"
        ];
        $rules = [
            "tanggal-activity" => "required|date",
            "id-claim" => "required",
            "uraian-activity" => "required|string",
            "keterangan" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("tanggal-activity");
            $request->old("uraian-activity");
            $request->old("keterangan");
            Alert::toast("Klaim Negosiasi gagal disimpan", "error")->autoClose(3000)->timerProgressBar(true);;
            redirect()->back()->with("modal", $data["modal-name"]);
        }
        $validation->validate();

        $faker = new Uuid();
        if (isset($data["dokumen-pendukung"])) {
            $list_id_document_pendukung = collect();
            if (count($data["dokumen-pendukung"]) > 1) {
                foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                    $id_document = $faker->uuid3();
                    // array_push($list_id_document_pendukung, $id_document);
                    $list_id_document_pendukung->push($id_document);
                    moveFileTemp($dokumen_pendukung, $id_document);
                }
                $claimContractNegoisasi->dokumen_pendukung = $list_id_document_pendukung->join(",");
            } else {
                $id_document = $faker->uuid3();
                moveFileTemp($data["dokumen-pendukung"][0], $id_document);
                // $list_id_document_pendukung->push($id_document);
                $claimContractNegoisasi->dokumen_pendukung = $id_document . ",";
            }
        }

        $claimContractNegoisasi->id_claim = $data["id-claim"];
        $claimContractNegoisasi->uraian_activity = $data["uraian-activity"];
        $claimContractNegoisasi->tanggal_activity = $data["tanggal-activity"];
        $claimContractNegoisasi->keterangan = $data["keterangan"];
        if ($claimContractNegoisasi->save()) {
            // Session::forget("pasals");
            Alert::success("Success", "Klaim Negosiasi berhasil disimpan");
            return redirect()->back();
        }
        $request->old("tanggal-diajukan");
        $request->old("diajukan-rekomendasi");
        $request->old("uraian-rekomendasi");
        $request->old("keterangan");
        Alert::error("Error", "Klaim Negosiasi gagal disimpan");
        return Redirect::back()->with("modal", $data["modal-name"]);
    }

    public function claimDisetujuiUpload(Request $request, ClaimContractDisetujui $claimContractDisetujui)
    {
        $data = $request->all();
        $faker = new Uuid();
        $id_document = $faker->uuid3();

        $messages = [
            "required" => "Field ini mandatory",
            "string" => "Field ini harus Alphanumeric",
            "file" => "Field ini harus berisi file",
            "date" => "Field ini harus berisi tanggal"
        ];
        $rules = [
            "tanggal-disetujui" => "required|date",
            "waktu-eot-disetujui" => "required|date",
            "id-claim" => "required",
            "biaya-disetujui" => "required",
            "keterangan-disetujui" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("tanggal-disetujui");
            $request->old("waktu-eot-disetujui");
            $request->old("biaya-disetujui");
            $request->old("keterangan-disetujui");
            Alert::toast("Klaim Disetujui gagal disimpan", "error")->autoClose(3000)->timerProgressBar(true);;
            redirect()->back()->with("modal", $data["modal-name"]);
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            $request->old("tanggal-disetujui");
            $request->old("waktu-eot-disetujui");
            $request->old("biaya-disetujui");
            $request->old("keterangan-disetujui");
            Alert::error("Error", "Pastikan kontrak sudah dibuat!")->autoClose(3000)->timerProgressBar(true);;
            return Redirect::back()->with("modal", $data["modal-name"]);
        }

        $messages = [
            "required" => "Field ini mandatory",
            "string" => "Field ini harus Alphanumeric",
            "file" => "Field ini harus berisi file",
            "date" => "Field ini harus berisi tanggal"
        ];
        $rules = [
            "tanggal-disetujui" => "required|date",
            "waktu-eot-disetujui" => "required|date",
            "id-claim" => "required",
            "biaya-disetujui" => "required|string",
            "keterangan-disetujui" => "required|string",
            "surat-disetujui" => "required|file",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("tanggal-activity");
            $request->old("proposal-claimndasi");
            $request->old("uraian-activity");
            $request->old("keterangan");
            dd($validation->errors());
            Alert::toast("Klaim Disetujui gagal disimpan", "error")->autoClose(3000)->timerProgressBar(true);;
            redirect()->back()->with("modal", $data["modal-name"]);
        }
        $validation->validate();

        $id_document_surat_disetujui = $faker->uuid3();
        if (isset($data["dokumen-pendukung"])) {
            $list_id_document_pendukung = collect();
            if (count($data["dokumen-pendukung"]) > 1) {
                foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                    $id_document = $faker->uuid3();
                    // array_push($list_id_document_pendukung, $id_document);
                    $list_id_document_pendukung->push($id_document);
                    moveFileTemp($dokumen_pendukung, $id_document);
                }
                $claimContractDisetujui->dokumen_pendukung = $list_id_document_pendukung->join(",");
            } else {
                $id_document = $faker->uuid3();
                moveFileTemp($data["dokumen-pendukung"][0], $id_document);
                // $list_id_document_pendukung->push($id_document);
                $claimContractDisetujui->dokumen_pendukung = $id_document . ",";
            }
        }

        $claimContractDisetujui->id_claim = $data["id-claim"];
        $claimContractDisetujui->id_document_surat_disetujui = $id_document_surat_disetujui;
        $claimContractDisetujui->tanggal_disetujui = $data["tanggal-disetujui"];
        $claimContractDisetujui->biaya_disetujui = (int) str_replace(",", "", $data["biaya-disetujui"]);
        $claimContractDisetujui->waktu_eot_disetujui = $data["waktu-eot-disetujui"];
        $claimContractDisetujui->keterangan = $data["keterangan-disetujui"];
        if ($claimContractDisetujui->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["surat-disetujui"], $id_document_surat_disetujui);
            Alert::success("Success", "Klaim Disetujui berhasil disimpan");
            return redirect()->back();
        }

        Alert::error("Error", "Klaim Disetujui gagal disimpan");
        return Redirect::back()->with("modal", $data["modal-name"]);
    }
}
