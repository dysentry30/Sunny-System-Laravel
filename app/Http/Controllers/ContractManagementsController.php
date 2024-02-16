<?php

namespace App\Http\Controllers;

use DateTime;
use Faker\Core\Uuid;
use App\Models\Pasals;
use App\Models\Proyek;
use App\Models\HandOvers;
use App\Models\Questions;
use App\Models\UnitKerja;
use App\Models\InputRisks;
use App\Models\FieldChange;
use Illuminate\Support\Str;
use App\Models\ClaimDetails;
use App\Models\ContractBast;
use App\Models\PendingIssue;
use Illuminate\Http\Request;
use App\Models\IssueProjects;
use App\Models\PerjanjianKso;
use App\Models\TechnicalForm;
use App\Models\DraftContracts;
use App\Models\MonthlyReports;
use App\Models\TechnicalQuery;
use App\Models\ReviewContracts;
use App\Models\SiteInstruction;
use App\Models\ClaimManagements;
use App\Models\DokumenPendukung;
use App\Models\PasalKontraktual;
use App\Models\PerubahanKontrak;
use App\Models\AddendumContracts;
use App\Models\MomKickOffMeeting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Models\ContractChangeOrder;
use App\Models\ContractManagements;
use App\Models\ContractChangeNotice;
use App\Models\UsulanPerubahanDraft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\KontrakBertandatangan;
use App\Models\AddendumContractDrafts;
use App\Models\ContractChangeProposal;
use App\Models\ContractUploadFinal;
use App\Models\ContractAsuransi;
use App\Models\ContractChecklist;
use App\Models\ContractJaminan;
use App\Models\ContractLaw;
use App\Models\ContractLD;
use App\Models\ContractApproval;
use App\Models\Csi;
use App\Models\JenisProyek;
use App\Models\KlarifikasiNegosiasiCda;
use App\Models\ProyekPIS;
use App\Models\ProyekProgress;
use App\Models\ReviewPembatalanKontrak;
use App\Models\ProyekPISNew;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\RencanKerjaManajemenKontrak;
use App\Models\UploadFinalDocument;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use SebastianBergmann\CodeCoverage\Util\Percentage;
use stdClass;

class ContractManagementsController extends Controller
{

    public function index(Request $request)
    {

        // $column = $request->get("column");
        $filterUnit = $request->query("filter-unit");
        $filterJenis = $request->query("filter-jenis");
        $filterTahun = $request->query("tahun-proyek") ?? (int) date("Y");
        $filterBulan = $request->query("bulan-proyek") ?? "";
        // dd($filterBulan);

        $year = (int) date("Y");
        $month = (int) date("m");
        // dd($column, $filterUnit, $filterJenis);

        // $contract_managements = ContractManagements::all();
        // $sorted_contracts = $contract_managements->sortBy("contract_in");
        // return view('4_Contract', ["contracts" => $sorted_contracts]);
        if (Gate::any(['super-admin', 'admin-ccm'])) {
            // $proyeks = Proyek::all()->where("stage", ">", 7)->where("nomor_terkontrak", "!=", "");
            // $proyeks = DB::table("proyeks as p")->select("p.*")->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("p.stage", ">", 7)->where("p.nomor_terkontrak", "!=", "")->where("c.stages", "<", 3)->get()->sortBy("p.kode_proyek");
            // $proyeks_terkontrak = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("c.stages", "<", 3)->get()->sortBy("p.kode_proyek")->map(function ($data) {
            //     return self::stdClassToModel($data, Proyek::class);
            // })->whereNotNull("nomor_terkontrak");
            // $proyeks_tender_awal = Proyek::all()->where("stage", "<", 5)->where("stage", "!=", 0);
            // $proyeks_pelaksanaan_serah_terima = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->whereBetween("c.stages", [3, 4], "or")->get()->map(function ($data) {
            //     return self::stdClassToModel($data, Proyek::class);
            // });

            // $proyeks_pelaksanaan_closing_proyek = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("c.stages", 5)->get()->map(function ($data) {
            //     return self::stdClassToModel($data, Proyek::class);
            // });
            $tahun_proyeks = Proyek::get()->groupBy("tahun_perolehan")->keys();
            // $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",",Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // $unitkerjas = UnitKerja::get()->whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8"]);
            // dd($unitkerjas);
            if ($filterTahun < 2023) {
                // $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unitkerjas = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas_select = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get();
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->whereNotIn("unit_kerja", $unit_kerja_code)->get();
                // $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
                // $proyeks = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->whereNotIn("unit_kerja", $unit_kerja_code)->whereIn("stage", [6, 8, 9])->where("stages", "=", 3)->get();
            } else {
                // $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"];
                $unitkerjas = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas_select = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get();
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->whereNotIn("unit_kerja", $unit_kerja_code)->get();
                // $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->get();
                // $proyeks = Proyek::join("contract_managements", "proyeks.kode_proyek", "=", "contract_managements.project_id")->whereNotIn("unit_kerja", $unit_kerja_code)->whereIn("stage", [6, 8, 9])->where("stages", "=", 3)->get();
            }

            $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();
            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            // $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            if(!empty($filterBulan) && $filterTahun == 2023){
                $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->get();
            }else{
                if($filterTahun < 2023 && !empty($filterBulan)){
                    $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->get();
                }elseif($filterTahun < 2023 && empty($filterBulan)){
                    $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->get();
                }else{
                    $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->get();
                    // dd("test");
                }
                
            }

            $proyekPISNew = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->where('contract_managements.profit_center', '!=', null)->where('start_year', '<=', $filterTahun)->get();

            // dd($proyeks_all);

            //2022 - 2023

            // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->get();
            // // dd($proyeks_all);
            // $proyeks_filter = collect();
            
            // if(!empty($filterBulan)){
            //     $time = Carbon::createFromFormat("m Y", "$filterBulan $filterTahun");
            //     // dd($time);
            // }else{
            //     $time = Carbon::now();
            // }
            // foreach(range(1,12) as $item){
            //     $proyeks_check = collect();
            //     if(!empty($filterBulan)){
            //         // $proyeks_check = $proyeks_all->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
            //         $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
            //     }else{
            //         $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", 12);
            //     }
            //     // dump($time, (int)$time->format("Y"), (int)$time->format("m"), $proyeks_filter);
            //     $time = $time->subMonth(1);
            //     if($proyeks_all->isNotEmpty()){
            //         $proyeks_filter->push($proyeks_check);
            //     }
            //     // dd($proyeks_all);
            // }

            // $filter = $proyeks_filter->flatten()->unique()->filter(function($item) use($filterTahun){
            //     if($filterTahun == 2022){
            //         return $item->tahun_perolehan != 2023;
            //     }else{
            //         return $item;
            //     }
            // });

            // $filter_unit = $unitkerjas->groupBy("divcode")->keys();
            // dd($proyeks_all);
            // if (!empty($filterUnit)) {
            //     $proyeks = $proyeks_all->where("unit_kerja", "=", $filterUnit);
            // } else if (!empty($filterJenis)) {
            //     $proyeks = $proyeks_all->where("jenis_proyek", "=", $filterJenis);
            // } else if(!empty($filterTahun)){
            //     $proyeks = $proyeks_all->where("tahun_perolehan", "=", $filterTahun);
            // } else {
            //     $proyeks = $proyeks_all;
            //     // $proyeks_all = Proyek::all();
            // }
            // dd($proyeks_all);
            $proyeks_perolehan = $proyeks_all->whereIn("stage", [2, 3, 4, 5, 6])->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true);
            $proyeks_pelaksanaan = $proyekPISNew;
            // $proyeks_pemeliharaan = $proyeks_all->where("is_cancel", "!=", true)->where("stages", "=", 3);
            $proyeks_pemeliharaan = $proyekPISNew->where("stages", "=", 3);
        } else {
            // $proyeks = Proyek::join()where("unit_kerja", "=", Auth::user()->unit_kerja)->where("stage", ">", 7)->where("nomor_terkontrak", "!=", "")->get()->sortBy("kode_proyek");
            // $proyeks = DB::table("proyeks as p")->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("p.unit_kerja", "=", Auth::user()->unit_kerja)->where("stage", ">", 7)->where("p.nomor_terkontrak", "!=", "")->where("c.stages", "<", 3)->get()->sortBy("kode_proyek");
            // $proyeks_terkontrak = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("c.stages", "<", 3)->get()->sortBy("p.kode_proyek")->map(function ($data) {
            //     return self::stdClassToModel($data, Proyek::class);
            // })->whereNotNull("nomor_terkontrak");
            // $proyeks_tender_awal = Proyek::all()->where("stage", "<", 5)->where("stage", "!=", 0);
            // $proyeks_pelaksanaan_serah_terima = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->whereBetween("c.stages", [3, 4], "or")->get()->map(function ($data) {
            //     return self::stdClassToModel($data, Proyek::class);
            // });

            // $proyeks_pelaksanaan_closing_proyek = DB::table("proyeks as p")->select(["p.*", "c.stages"])->join("contract_managements as c", "c.project_id", "=", "p.kode_proyek")->where("c.stages", 5)->get()->map(function ($data) {
            //     return self::stdClassToModel($data, Proyek::class);
            // });
            // $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // $unitkerjas = UnitKerja::all()->whereIn("divcode", $unit_kerja_user->toArray());
            // if (!empty($filterUnit)) {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("unit_kerja", "=", $filterUnit)->get()->whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "8"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            // } else if (!empty($filterJenis)) {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("jenis_proyek", "=", $filterJenis)->get()->whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "8"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            // } else {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->get()->whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "8"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            // }
            // // dd($proyeks_all);
            // $proyeks_perolehan = $proyeks_all->whereIn("stage", [2, 3, 4, 5, 6])->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true);
            // $proyeks_pelaksanaan = $proyeks_all->where("stage", "=", 8)->where("is_cancel", "!=", true)->filter(function ($p) {
            //     return !empty($p->ContractManagements) && $p->ContractManagements->stages == 2;
            // });
            // $proyeks_pemeliharaan = $proyeks_all->where("is_cancel", "!=", true)->filter(function ($p) {
            //     return !empty($p->ContractManagements) && $p->ContractManagements->stages == 3;
            // });
            // $proyeks_pelaksanaan = $proyeks_all->filter(function($p) {
            //     return !empty($p->ContractManagements) && $p->ContractManagements->where("stages", "=", )
            // });
            $tahun_proyeks = Proyek::get()->groupBy("tahun_perolehan")->keys();
            $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",",Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // $unitkerjas = UnitKerja::get()->whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8"]);
            // dd($unitkerjas);
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

            $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();
            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            // $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();
            $proyekSelected = !empty(Auth::user()->proyeks_selected) ? json_decode(Auth::user()->proyeks_selected) : [];

            if(!empty($filterBulan) && $filterTahun == 2023){
                $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->whereIn('contract_managements.profit_center', $proyekSelected)->get();
            }else{
                if($filterTahun < 2023 && !empty($filterBulan)){
                    $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->whereIn('contract_managements.profit_center', $proyekSelected)->get();
                }elseif($filterTahun < 2023 && empty($filterBulan)){
                    $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->whereIn('contract_managements.profit_center', $proyekSelected)->get();
                }else{
                    $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "<=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("jenis_proyek", $jenis_proyek_get)->whereIn('contract_managements.profit_center', $proyekSelected)->get();
                    // dd("test");
                }
                
            }
            $proyekPISNew = ProyekPISNew::join(
                "contract_managements",
                "contract_managements.profit_center",
                "=",
                "proyek_pis_new.profit_center"
            )->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->where('contract_managements.profit_center', '!=', null)->where(
                'start_year',
                '<=',
                $filterTahun
            )->whereIn('proyek_pis_new.spk_intern_no', $proyekSelected)->get();
        }
        $proyeks_perolehan = $proyeks_all->whereIn("stage", [2, 3, 4, 5, 6])->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true);
        // $proyeks_pelaksanaan = $proyeks_all->where("stage", ">=", 8)->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true);
        $proyeks_pelaksanaan = $proyekPISNew;
        // $proyeks_pemeliharaan = $proyeks_all->where("is_cancel", "!=", true)->where("stages", "=", 3);
        $proyeks_pemeliharaan = $proyekPISNew->where("stages", "=", 3);
    // return view("4_Contract", compact(["proyeks"]));
        return view("4_Contract", compact(["proyeks_perolehan", "proyeks_pelaksanaan", "proyeks_pemeliharaan", "filterUnit", "filterJenis", "unitkerjas", "tahun_proyeks", "filterTahun", "month", "filterBulan", "unit_kerjas_select"]));
    }

    private function stdClassToModel($data, $instance)
    {
        // backup fillable
        $keys = array_keys(get_object_vars($data));
        $proyek = new $instance;
        $fillable = $proyek->getFillable();

        // set id and other fields you want to be filled
        $proyek->fillable($keys);

        // fill $proyek->attributes array
        $proyek->fill((array) $data);

        // fill $proyek->original array
        $proyek->syncOriginal();

        $proyek->exists = true;

        // restore fillable
        $proyek->fillable($fillable);

        return $proyek;
    }

    public function new()
    {
        if (Auth::user()->check_administrator) {
            $proyeks_filtered = Proyek::all();
        } else {
            $proyeks_filtered = Proyek::all()->filter(function ($proyek) {
                return $proyek->stage == 6 || $proyek->stage == 8 || $proyek->unit_kerja == Auth::user()->unit_kerja;
            });
        }
        return view('Contract/view', ["projects" => $proyeks_filtered]);
    }

    function deleteModelArray(Collection $model, $child = false, string $childColllection = null)
    {
        if ($child && !empty($childColllection)) {
            $model->each(function ($draft) use ($childColllection) {
                $childColllection::where("id_claim", "=", $draft->id_claim)->get()->each(function ($dataChild) {
                    Storage::disk("public/words")->delete($dataChild->id_document . ".docx");
                    $dataChild->delete();
                });
                Storage::disk("public/words")->delete($draft->id_document . ".docx");
                $draft->delete();
            });
        } else {
            $model->each(function ($draft) {
                Storage::disk("public/words")->delete($draft->id_document . ".docx");
                $draft->delete();
            });
        }
    }

    public function delete(ContractManagements $contractManagement)
    {
        $draftContracts = DraftContracts::where("id_contract", "=", $contractManagement->id_contract)->get();
        $reviewContracts = ReviewContracts::where("id_contract", "=", $contractManagement->id_contract)->get();
        $addendumContract = AddendumContracts::where("id_contract", "=", $contractManagement->id_contract)->get();
        $claimManagements = ClaimManagements::where("id_contract", "=", $contractManagement->id_contract)->get();
        $handOver = HandOvers::where("id_contract", "=", $contractManagement->id_contract)->get();
        $inputRisks = InputRisks::where("id_contract", "=", $contractManagement->id_contract)->get();
        $issueProjects = IssueProjects::where("id_contract", "=", $contractManagement->id_contract)->get();
        $monthlyReports = MonthlyReports::where("id_contract", "=", $contractManagement->id_contract)->get();
        $questions = Questions::where("id_contract", "=", $contractManagement->id_contract)->get();

        Alert::success('Delete', $contractManagement->id_contract . ", Berhasil Dihapus");

        if (!empty($draftContracts)) {
            $this->deleteModelArray($draftContracts);
        }
        if (!empty($reviewContracts)) {
            $this->deleteModelArray($reviewContracts);
        }
        if (!empty($addendumContract)) {
            $this->deleteModelArray($addendumContract);
        }
        if (!empty($claimManagements)) {
            $this->deleteModelArray($claimManagements, true, ClaimDetails::class);
        }
        if (!empty($handOver)) {
            $this->deleteModelArray($handOver);
        }
        if (!empty($inputRisks)) {
            $this->deleteModelArray($inputRisks);
        }
        if (!empty($issueProjects)) {
            $this->deleteModelArray($issueProjects);
        }
        if (!empty($monthlyReports)) {
            $this->deleteModelArray($monthlyReports);
        }
        if (!empty($questions)) {
            $this->deleteModelArray($questions);
        }

        if ($contractManagement->delete()) {
            Alert::success("Success", "Contract berhasil dihapus");
            return redirect()->back();
        }
        Alert::Error("Failed", "Contract gagal dihapus");
        return redirect()->back();
    }

    public function save(Request $request, ContractManagements $contractManagements)
    {
        $data = $request->all();
        $proyek = Proyek::find($data["project-id"]);

        if ($proyek->stage < 7) {
            Alert::html('Erorr', 'Pastikan proyek sudah <b>Terkontrak</b>', 'Error');
            return redirect()->back();
        } else if (!empty($proyek->ContractManagements)) {
            Alert::html('Erorr', 'Pastikan proyek belum memiliki Kontrak', 'Error');
            return redirect()->back();
        }
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus tanggal",
            "before" => "Pastikan 'Tanggal Mulai Kontrak' ditentukan sebelum 'Tanggal Berakhir Kontrak'",
            "after" => "Pastikan 'Tanggal Berakhir Kontrak' ditentukan sesudah 'Tanggal Mulai Kontrak'",
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
            $request->old("number-contract");
            $request->old("project-id");
            $request->old("start-date");
            $request->old("due-date");
            $request->old("value");
            $request->old("number-spk");
            $validation->validate();
            Alert::error("Error", "Contract gagal ditambahkan");
            return redirect()->back();
        }

        // begin:: check if id contract exist and has same project id
        $is_contract_exist = ContractManagements::where("id_contract", "=", (int) $data["number-contract"])->orWhere("project_id", "=", $data["project-id"])->get()->first();
        if (!empty($is_contract_exist)) {
            $request->old("number-contract");
            $request->old("project-id");
            $request->old("start-date");
            $request->old("due-date");
            $request->old("value");
            $request->old("number-spk");
            $validation->validate();
            Alert::error("Error", "Nomor Kontrak atau Proyek sudah ada, Pastikan Proyek tidak melebihi dari 2 kontrak");
            return redirect()->back();
        }
        // end:: check if id contract exist and has same project id


        $contractManagements->id_contract = (int) $data["number-contract"];
        $contractManagements->project_id = $data["project-id"];
        $contractManagements->contract_proceed = "Belum Selesai";
        $contractManagements->contract_in = new DateTime($data["start-date"]);
        $contractManagements->contract_out = new DateTime($data["due-date"]);
        $contractManagements->number_spk = (int) $data["number-spk"];
        $contractManagements->stages = (int) 1;
        $contractManagements->value = (int) preg_replace("/[^0-9]/i", "", $data["value"]);
        $contractManagements->value_review = 0;

        Alert::success('Success', $data["number-contract"] . ", Berhasil Ditambahkan");
        if ($contractManagements->save()) {
            // echo "sukses";
            return redirect("/contract-management");
        }
        return redirect("/contract-management");
        // return view('Contract/view');
    }


    public function update(Request $request,  ContractManagements $contracts)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "Field di atas wajib diisi string",
        ];
        $rules = [
            "id-contract" => "required|string",
            "delay" => "nullable|string",
            "performance" => "nullable|string",
            "prevailing-language" => "nullable|string",
            "dispute-resolution" => "nullable|string",
            "governing-law" => "nullable|string",
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Alert::error('Error', "Contract gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $contract = $contracts::find($data["id-contract"]);

        if (empty($contract)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        $contract->ld_delay = $data["delay"];
        $contract->ld_performance = $data["performance"];
        $contract->law_governing = $data["governing-law"];
        $contract->law_dispute_resolution = $data["dispute-resolution"];
        $contract->law_prevailing_language = $data["prevailing-language"];
        $contract->jo_scope_of_work = $data["scope-of-work"] ?? null;
        $contract->is_jo = $data["is-jo"] ?? 0;

        if ($contract->save()) {
            // moveFileTemp($file, $id_document);
            Alert::success('Success', "Kontrak berhasil diupdate");
            return Redirect::back();
        }
        Alert::error('Error', "Contract gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // $validation = Validator::make($data, $rules, $messages);
        // if ($validation->fails()) {
        //     Alert::error('Error', "Contract ini gagal diperbarui");
        //     return redirect()->back();
        // }
        // $validation->validate();
        // $contractManagements = ContractManagements::find($data["number-contract"]);
        // // dd($data);
        // $contractManagements->project_id = $data["project-id"];
        // // $contractManagements->contract_proceed = "Belum Selesai";
        // $contractManagements->contract_in = new DateTime($data["start-date"]);
        // $contractManagements->contract_out = new DateTime($data["due-date"]);
        // $contractManagements->number_spk = (int) $data["number-spk"];
        // $contractManagements->value = (int) str_replace(",", "", $data["value"]);
        // $contractManagements->value_review = (int) str_replace(",", "", $data["value-review"]);
        // if ($contractManagements->save()) {
        //     Alert::success('Success', "Contract berhasil diperbarui");
        //     return redirect()->back();
        //     // return redirect("/contract-management");
        // }
        // Alert::error('Error', "Contract ini gagal diperbarui");
        // return redirect()->back();
        // // return redirect("/contract-management");
    }


    public function viewContractOld($id_contract)
    {
        if (Session::has("pasals")) {
            Session::forget("pasals");
        }

        // $draftContracts = DraftContracts::join("contract_managements as c", "draft_contracts.id_contract", "=", "c.id_contract")->select("draft_contracts.*")->get();
        // $review_contracts = ReviewContracts::join("draft_contracts as d", "review_contracts.id_draft_contract", "=", "d.id_draft")->select("review_contracts.*")->get();
        $projects = Proyek::all();
        $contract = ContractManagements::where("id_contract", "=", $id_contract)->first();
        $perubahan_kontrak = PerubahanKontrak::where("id_contract", "=", $id_contract)->get();
        $perubahan_group = $perubahan_kontrak->groupBy("jenis_perubahan")->toArray();
        $perubahan_vo = array_key_exists("VO", $perubahan_group);
        $perubahan_klaim = array_key_exists("Klaim", $perubahan_group);
        $perubahan_anti_klaim = array_key_exists("Anti Klaim", $perubahan_group);       
        $perubahan_klaim_asuransi = array_key_exists("Klaim Asuransi", $perubahan_group);

        $progress = $contract->project->ProyekProgress?->sortByDesc("created_at")->first();
        $progress_fisik_ri = $progress->progress_fisik_ri ?? 0;
        $ok_review = $progress->ok_review ?? 0;
        $progress_now = Percentage::fromFractionAndTotal((int)$progress_fisik_ri, (int)$ok_review)->asString();
        // dump($progress_now);

        // $asuransis = ContractAsuransi::where("id_contract", "=", $id_contract)->get();
        // $asuransi_group = $asuransis->groupBy("kategori_asuransi");
        // $asuransi  = $asuransi_group->map(function($item, $key){
        //     $test = $item[$key];
        //     return $test;
        // });
        // dd($asuransi_group);
        // dd($asuransi);
        // dd(array_key_exists("VO", $perubahan_group), count($perubahan_group["Klaim"]));

        return view('Contract/view', [
            "contract" => $contract,
            "projects" => $projects,
            "perubahan_group" => $perubahan_group,
            "perubahan_vo" => $perubahan_vo,
            "perubahan_klaim" => $perubahan_klaim,
            "perubahan_anti_klaim" => $perubahan_anti_klaim,
            "perubahan_klaim_asuransi" => $perubahan_klaim_asuransi,
            "progress_now" => $progress_now
            // "asuransi_group" => $asuransi_group
        ]);
    }

    public function viewContract($profit_center)
    {
        if (Session::has("pasals")) {
            Session::forget("pasals");
        }

        // $draftContracts = DraftContracts::join("contract_managements as c", "draft_contracts.profit_center", "=", "c.profit_center")->select("draft_contracts.*")->get();
        // $review_contracts = ReviewContracts::join("draft_contracts as d", "review_contracts.id_draft_contract", "=", "d.id_draft")->select("review_contracts.*")->get();
        // $projects = Proyek::all();

        if (Str::isUuid($profit_center)) {
            $contract = ContractManagements::where("id_contract", "=", $profit_center)->first();
            $perubahan_kontrak = PerubahanKontrak::where("id_contract", "=", $profit_center)->get();
            $progress = $contract->project?->ProyekProgress?->sortByDesc("created_at")->first();
        } else {
            $contract = ContractManagements::where("profit_center", "=", $profit_center)->first();
            $perubahan_kontrak = PerubahanKontrak::where("profit_center", "=", $profit_center)->get();
            $progress = $contract->ProyekPISNew?->ProyekProgress?->sortByDesc("created_at")->first();
        }
        $perubahan_group = $perubahan_kontrak->groupBy("jenis_perubahan")->toArray();
        $perubahan_vo = array_key_exists("VO", $perubahan_group);
        $perubahan_klaim = array_key_exists("Klaim", $perubahan_group);
        $perubahan_anti_klaim = array_key_exists("Anti Klaim", $perubahan_group);
        $perubahan_klaim_asuransi = array_key_exists("Klaim Asuransi", $perubahan_group);
        if (!empty($progress)) {
            $progress_fisik_ri = $progress?->progress_fisik_ri ?? 0;
            $ok_review = $progress->ok_review ?? 0;
            $progress_now = Percentage::fromFractionAndTotal((int)$progress_fisik_ri, (int)$ok_review)->asString();
        } else {
            $progress_fisik_ri = 0;
            $ok_review = 0;
            $progress_now = 0;
        }

        // $asuransis = ContractAsuransi::where("id_contract", "=", $id_contract)->get();
        // $asuransi_group = $asuransis->groupBy("kategori_asuransi");
        // $asuransi  = $asuransi_group->map(function($item, $key){
        //     $test = $item[$key];
        //     return $test;
        // });
        // dd($asuransi_group);
        // dd($asuransi);
        // dd(array_key_exists("VO", $perubahan_group), count($perubahan_group["Klaim"]));
        return view('Contract/view', [
            "contract" => $contract,
            // "projects" => $projects,
            "perubahan_group" => $perubahan_group,
            "perubahan_vo" => $perubahan_vo,
            "perubahan_klaim" => $perubahan_klaim,
            "perubahan_anti_klaim" => $perubahan_anti_klaim,
            "perubahan_klaim_asuransi" => $perubahan_klaim_asuransi,
            "progress_now" => $progress_now
            // "asuransi_group" => $asuransi_group
        ]);
    }


    public function tenderMenang($id_contract)
    {
        $is_tender_menang = true;
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract, "is_tender_menang" => $is_tender_menang]);
    }


    public function draftContract($id_contract)
    {
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract]);
    }


    public function addendumContract($id_contract)
    {
        return view("addendumContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract]);
    }


    public function addendumNew($id_contract, AddendumContracts $addendumContract)
    {
        return view("addendumContract/new", ["contract" => ContractManagements::find($id_contract), "id_contract" => $id_contract, "addendumContract" => $addendumContract]);
    }


    public function addendumView($id_contract, AddendumContracts $addendumContract)
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


    public function addendumDraft($id_contract, AddendumContracts $addendumContract, AddendumContractDrafts $addendumDraft)
    {
        return view("addendumContract/new", ["addendumContract" => $addendumContract, "id_contract" => $id_contract, "addendumDraft" => $addendumDraft]);
    }


    public function draftContractView($id_contract, DraftContracts $draftContracts, Request $request)
    {

        if ($request->ajax()) {
            $pasals = collect();
            $draft_pasals = collect(explode(",", $draftContracts->pasals));
            foreach ($draft_pasals as $pasal) {
                $pasal_model = Pasals::find($pasal);
                if (empty($pasal_model)) {
                    $pasals->push($pasal);
                } else {
                    $pasals->push(($pasal_model->pasal));
                }
            }
            return response()->json($pasals);
        }
        if (!$draftContracts instanceof DraftContracts) {
            $is_tender_menang = true;
            return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "id_contract" => $id_contract, "is_tender_menang" => $is_tender_menang]);
        }


        $id_pasals = explode(",", $draftContracts->pasals);
        $res_pasals = [];
        foreach ($id_pasals as $id_pasal) {
            $get_pasal = Pasals::find($id_pasal);
            if ($get_pasal instanceof Pasals) {
                array_push($res_pasals, $get_pasal);
            } else {
                array_push($res_pasals, $id_pasal);
            }
        }
        if (!Session::has("pasals")) {
            Session::put("pasals", $res_pasals);
        }
        return view("DraftContract/view", ["contract" => ContractManagements::find($id_contract), "pasals" => Pasals::all(), "pasalsDraft" => $res_pasals, "id_contract" => $id_contract, "draftContract" => $draftContracts]);
    }

    // Upload Review of Contract to Server or Database
    // public function reviewContractUpload(Request $request, ReviewContracts $reviewContracts)
    // {
    //     // $faker = new Uuid();
    //     // $id_document = (string) $faker->uuid3();
    //     // $file = $request->file("attach-file-review");
    //     $data = $request->all();
    //     // dd($data);
    //     // $messages = [
    //     //     "required" => "Field di atas wajib diisi",
    //     //     "numeric" => "Field di atas harus numeric",
    //     //     "file" => "This field must be file only",
    //     //     "string" => "This field must be alphabet only",
    //     // ];

    //     // $is_input_has_set = $data["ketentuan-review"] != null ||
    //     //     $data["id-draft-contract"] != null ||
    //     //     $data["id-contract"] != null;
    //     // $data["pic-cross-review"] != null ||
    //     // $data["catatan-review"] != null;

    //     // if(isset($data["upload-review"]) && !$is_input_has_set) {
    //     //     $rules = [
    //     //         "upload-review" => "required|file",
    //     //     ];
    //     // } else if(!isset($data["upload-review"]) && $is_input_has_set) {
    //     //     $rules = [
    //     //         "ketentuan-review" => "required|string",
    //     //         "sub-pasal-review" => "required|string",
    //     //         "uraian-penjelasan-review" => "required|string",
    //     //         "catatan-review" => "required|string",
    //     //         "pic-cross-review" => "required|numeric",
    //     //         "id-contract" => "required|string",
    //     //     ];
    //     // } else {
    //     //     Alert::error("Error", "Pilih salah satu untuk dijadikan masukan");
    //     //     return redirect()->back();
    //     // }

    //     // $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
    //     $rules = [
    //         "ketentuan-review" => "required|string",
    //         // "sub-pasal-review" => "required|string",
    //         // "uraian-penjelasan-review" => "required|string",
    //         // "catatan-review" => "required|string",
    //         // "pic-cross-review" => "required|numeric",
    //         "id-contract" => "required|string",
    //         "id-draft-contract" => "required|numeric",
    //         "input-pasal" => "required|string",
    //     ];
    //     $validation = Validator::make($data, $rules, $messages);
    //     if ($validation->fails()) {
    //         // dd($validation->errors());
    //         Alert::error('Error', "Review Contract gagal diperbarui");
    //         return Redirect::back()->with("modal", $data["modal-name"]);
    //         // return Redirect::back();
    //     }


    //     // Check ID Contract exist
    //     $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

    //     if (empty($is_id_contract_exist)) {
    //         // Session::flash("failed", "Please fill 'Draft Contract' empty field");
    //         Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
    //         return Redirect::back();
    //     }
    //     $validation->validate();

    //     if (isset($data["upload-review"]) && !$is_input_has_set) {
    //         // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    //         // $spreadsheet = $reader->load($data["upload-review"]);
    //         $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($data["upload-review"]);
    //         $spreadsheet = $spreadsheet->getActiveSheet()->toArray();
    //         array_shift($spreadsheet);
    //         foreach ($spreadsheet as $data_excel) {
    //             $reviewContractsExcel = new ReviewContracts();
    //             $reviewContractsExcel->ketentuan = $data_excel[0];
    //             $reviewContractsExcel->stage = $data["stage"];
    //             $reviewContractsExcel->sub_pasal = $data_excel[1];
    //             $reviewContractsExcel->uraian = $data_excel[2];
    //             $reviewContractsExcel->pic_cross = $data_excel[3];
    //             $reviewContractsExcel->catatan = $data_excel[4];
    //             $reviewContractsExcel->id_contract = $is_id_contract_exist->id_contract;
    //             $reviewContractsExcel->save();
    //         }
    //         Alert::success("Success", "Data berhasil di import ");
    //         return redirect()->back();
    //         // moveFileTemp($file, $id_document);
    //     } else {
    //         $reviewContracts->stage = $data["stage"];
    //         $reviewContracts->ketentuan = $data["ketentuan-review"];
    //         $reviewContracts->id_draft_contract = $data["id-draft-contract"];
    //         $reviewContracts->id_contract = $data["id-contract"];
    //         $reviewContracts->pasal_perubahan = $data["input-pasal"];
    //         // $reviewContracts->sub_pasal = $data["sub-pasal-review"];
    //         // $reviewContracts->uraian = $data["uraian-penjelasan-review"];
    //         // $reviewContracts->pic_cross = $data["pic-cross-review"];
    //         // $reviewContracts->catatan = $data["catatan-review"];
    //     }

    //     if ($reviewContracts->save()) {
    //         Alert::success('Success', "Review Contract berhasil dibuat");
    //         return redirect($_SERVER["HTTP_REFERER"]);
    //     }
    //     Alert::error('Error', "Review Contract gagal dibuat");
    //     return Redirect::back()->with("modal", $data["modal-name"]);
    //     // return redirect($_SERVER["HTTP_REFERER"]);
    // }

    public function reviewContractUpload(Request $request){
        $data = $request->all();
        // dd($data);

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        // $kategori = $data["kategori"];
        $kategori = collect($data["kategori"]);
        $index = collect($data["index"]);
        $sub_pasal = collect($data["sub-pasal"]);
        $uraian = collect($data["uraian"]);
        $pic = collect($data["pic"]);
        $catatan = collect($data["catatan"]);
        // dd($kategori);
        $data_update = $kategori->map(function($d, $key) use($sub_pasal, $uraian, $pic, $catatan, $data, $index) {
            $new_class = new stdClass();
            $new_class->id_contract = $data["id-contract"];
            $new_class->stage = $data["stage"];
            $new_class->kategori = $d;
            $new_class->index = (int)$index[$key];
            $new_class->sub_pasal = $sub_pasal[$key];
            $new_class->uraian = $uraian[$key];
            $new_class->pic = $pic[$key];
            $new_class->catatan = $catatan[$key];
            return $new_class;
        });
        // dd($data_update);
        // dd($kategori, $sub_pasal, $uraian, $pic, $catatan);

        $is_data_exist_1 = ReviewContracts::where("id_contract", $data["id-contract"])->where("stage", "=", 1)->get();
        $is_data_exist_2 = ReviewContracts::where("id_contract", $data["id-contract"])->where("stage", "=", 2)->get();
        // dd($is_data_exist);
        if($is_data_exist_2->isEmpty()){
            $kategori->each(function($item, $key) use($sub_pasal, $uraian, $pic, $catatan, $data, $is_data_exist_1, $index){
                // $tes = ReviewContracts::where("stage", "=", 1)->get();
                // dd($tes);
                if($data["stage"] == 1){
                    $review_kontrak = new ReviewContracts();
                    $review_kontrak->id_contract = $data["id-contract"];
                    $review_kontrak->stage = $data["stage"];
                    $review_kontrak->kategori = $item;
                    $review_kontrak->index = (int)$index[$key];
                    $review_kontrak->sub_pasal = $sub_pasal[$key];
                    $review_kontrak->uraian = $uraian[$key];
                    $review_kontrak->pic = $pic[$key];
                    $review_kontrak->catatan = $catatan[$key];

                    $duplicate_review = new ReviewContracts();
                    $duplicate_review->id_contract = $data["id-contract"];
                    $duplicate_review->stage = 2;
                    $duplicate_review->kategori = $item;
                    $duplicate_review->index = (int)$index[$key];
                    $duplicate_review->sub_pasal = $sub_pasal[$key];
                    $duplicate_review->uraian = $uraian[$key];
                    $duplicate_review->pic = $pic[$key];
                    $duplicate_review->catatan = $catatan[$key];

                    $review_kontrak->save();
                    $duplicate_review->save();

                    // $budi = $review_kontrak->replicate()->fill(["stage" => 2]);
                    // dd($budi);
                }else{
                    $review_kontrak = new ReviewContracts();
                    $review_kontrak->id_contract = $data["id-contract"];
                    $review_kontrak->stage = $data["stage"];
                    $review_kontrak->kategori = $item;
                    $review_kontrak->index = (int)$index[$key];
                    $review_kontrak->sub_pasal = $sub_pasal[$key];
                    $review_kontrak->uraian = $uraian[$key];
                    $review_kontrak->pic = $pic[$key];
                    $review_kontrak->catatan = $catatan[$key];

                    $review_kontrak->save();
                }
                
            });
            Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
            return redirect()->back();
        }else{
            if($data["stage"] == 1){
                $is_data_exist_1->each(function($item, $key) use($data_update, $data){
                    $item->id_contract = $data["id-contract"];
                    $item->stage = $data["stage"];
                    $item->kategori = $data_update[$key]->kategori;
                    $item->index = (int)$data_update[$key]->index;
                    $item->sub_pasal = $data_update[$key]->sub_pasal;
                    $item->uraian = $data_update[$key]->uraian;
                    $item->pic = $data_update[$key]->pic;
                    $item->catatan = $data_update[$key]->catatan;
                    $item->save();
                });
                $is_data_exist_2->each(function($item, $key) use($data_update, $data){
                    $item->id_contract = $data["id-contract"];
                    $item->stage = 2;
                    $item->kategori = $data_update[$key]->kategori;
                    $item->index = (int)$data_update[$key]->index;
                    $item->sub_pasal = $data_update[$key]->sub_pasal;
                    $item->uraian = $data_update[$key]->uraian;
                    $item->pic = $data_update[$key]->pic;
                    $item->catatan = $data_update[$key]->catatan;
                    $item->save();
                });
                Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
                return redirect()->back();
            }else{
                $is_data_exist_2->each(function($item, $key) use($data_update, $data){
                    $item->id_contract = $data["id-contract"];
                    $item->stage = $data["stage"];
                    $item->kategori = $data_update[$key]->kategori;
                    $item->index = (int)$data_update[$key]->index;
                    $item->sub_pasal = $data_update[$key]->sub_pasal;
                    $item->uraian = $data_update[$key]->uraian;
                    $item->pic = $data_update[$key]->pic;
                    $item->catatan = $data_update[$key]->catatan;
                    $item->save();
                });
                Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
                return redirect()->back();
            }
            // Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
            // return redirect()->back();
        }
        // $data["kategori"]->each(function($item, $key){
        // });

        // $is_data_exist = ReviewContracts::where("id_contract", $data["id-contract"])->get();
        // if($is_data_exist->isEmpty()){
        //     $kategori->each(function($item, $key) use($sub_pasal, $uraian, $pic, $catatan, $data){
        //             // if($data["stage"] == 1){
        //             //     $review_kontrak = new ReviewContracts();
        //             //     $review_kontrak->id_contract = $data["id-contract"];
        //             //     $review_kontrak->stage = $data["stage"];
        //             //     $review_kontrak->kategori = $item;
        //             //     $review_kontrak->sub_pasal = $sub_pasal[$key];
        //             //     $review_kontrak->uraian = $uraian[$key];
        //             //     $review_kontrak->pic = $pic[$key];
        //             //     $review_kontrak->catatan = $catatan[$key];

        //             //     // $duplicate_review = new ReviewContracts();
        //             //     // $duplicate_review->id_contract = $data["id-contract"];
        //             //     // $duplicate_review->stage = 2;
        //             //     // $duplicate_review->kategori = $item;
        //             //     // $duplicate_review->sub_pasal = $sub_pasal[$key];
        //             //     // $duplicate_review->uraian = $uraian[$key];
        //             //     // $duplicate_review->pic = $pic[$key];
        //             //     // $duplicate_review->catatan = $catatan[$key];

        //             //    if ($review_kontrak->save()){
        //             //     Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
        //             //     return redirect()->back();
        //             //    }
        //             //     // $duplicate_review->save();

        //             //     // $budi = $review_kontrak->replicate()->fill(["stage" => 2]);
        //             //     // dd($budi);
        //             // }else{
        //                 $review_kontrak = new ReviewContracts();
        //                 $review_kontrak->id_contract = $data["id-contract"];
        //                 // $review_kontrak->stage = $data["stage"];
        //                 $review_kontrak->kategori = $item;
        //                 $review_kontrak->sub_pasal = $sub_pasal[$key];
        //                 $review_kontrak->uraian = $uraian[$key];
        //                 $review_kontrak->pic = $pic[$key];
        //                 $review_kontrak->catatan = $catatan[$key];

        //                 // dump($review_kontrak);

        //                 $review_kontrak->save();
        //                 // }
                        
        //             });
        //             Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
        //             return Redirect::back();
        //     }else{
        //         $is_data_exist->each(function($item, $key) use($data_update, $data){
        //                     $item->id_contract = $data["id-contract"];
        //                     // $item->stage = $data["stage"];
        //                     $item->kategori = $data_update[$key]->kategori;
        //                     $item->sub_pasal = $data_update[$key]->sub_pasal;
        //                     $item->uraian = $data_update[$key]->uraian;
        //                     $item->pic = $data_update[$key]->pic;
        //                     $item->catatan = $data_update[$key]->catatan;
        //                     $item->save();
        //         });
        //         Alert::success('Success', "Tinjauan Kontrak berhasil ditambahkan");
        //         return Redirect::back();
        //     }
    }

    // Upload Issue Project of Contract to server or database
    public function issueProjectUpload(Request $request, IssueProjects $issueProjects)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-issue");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            "attach-file-issue" => "required|file",
            "document-name-issue" => "required|string",
            "note-issue" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            // dd($validation->errors());
            Alert::error('Error', "Issue Contract gagal dibuat");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        $validation->validate();

        $issueProjects->document_name_issue = $data["document-name-issue"];
        $issueProjects->id_contract = $data["id-contract"];
        $issueProjects->id_document = $id_document;
        $issueProjects->note_issue = $data["note-issue"];
        $issueProjects->tender_menang = $is_tender_menang;
        if ($issueProjects->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Issue Contract berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::success('Success', "Issue Contract berhasil ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Questions of Contract to server or database
    public function questionUpload(Request $request, Questions $questions)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-question");
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            // "numeric" => "Field di atas harus numeric",
            // "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];
        $rules = [
            // "attach-file-question" => "required|file",
            // "document-name-question" => "required|string",
            // "note-question" => "required|string",
            // "kategori-Aanwitjzing" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Alert::error('Error', "Aanwitjzing gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;

        // $questions->document_name_question = $data["document-name-question"];
        // $questions->id_document = $id_document;
        $questions->item = $data["item"];
        $questions->sub_pasal = $data["sub-pasal"];
        $questions->note_question = $data["note-question"];
        $questions->id_contract = $data["id-contract"];
        $questions->tender_menang = $is_tender_menang;
        if ($questions->save()) {
            // moveFileTemp($file, $id_document);
            Alert::success('Success', "Aanwitjzing berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Aanwitjzing gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // public function ld_law(Request $request, ContractManagements $contracts)
    // {
    //     $data = $request->all();
    //     // dd($data);

    //     $messages = [
    //         "required" => "Field di atas wajib diisi",
    //         "string" => "This field must be alphabet only",
    //     ];
    //     $rules = [
    //         "id-contract" => "required|string",
    //         "delay" => "required|string",
    //         "performance" => "required|string",
    //         "governing-law" => "required|string",
    //         "dispute-resolution" => "required|string",
    //         "prevailing-language" => "required|string",
    //     ];
    //     $validation = Validator::make($data, $rules, $messages);

    //     if ($validation->fails()) {
    //         Alert::error('Error', "Input LD & LAW gagal ditambahkan");
    //         return Redirect::back()->with("modal", $data["modal-name"]);
    //         // return Redirect::back();
    //         // dd($validation->errors());
    //     }

    //     // Check ID Contract exist
    //     $contract = $contracts::find($data["id-contract"]);

    //     if (empty($contract)) {
    //         // Session::flash("failed", "Please fill 'Draft Contract' empty field");
    //         Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
    //         return Redirect::back()->with("modal", $data["modal-name"]);
    //         // return Redirect::back();
    //     }
    //     $validation->validate();

    //     $contract->ld_delay = $data["delay"];
    //     $contract->ld_performance = $data["performance"];
    //     $contract->law_governing = $data["governing-law"];
    //     $contract->law_dispute_resolution = $data["dispute-resolution"];
    //     $contract->law_prevailing_language = $data["prevailing-language"];

    //     if ($contract->save()) {
    //         // moveFileTemp($file, $id_document);
    //         Alert::success('Success', "Input LD & LAW berhasil ditambahkan");
    //         return Redirect::back();
    //     }
    //     Alert::error('Error', "Input LD & LAW gagal ditambahkan");
    //     return Redirect::back()->with("modal", $data["modal-name"]);
    //     // return redirect($_SERVER["HTTP_REFERER"]);
    // }
    

    // Upload Risk of Contract to server or database
    public function riskUpload(Request $request, InputRisks $risk)
    {
        $faker = new Uuid();
        // $id_document = (string) $faker->uuid3();
        // $file = $request->file("attach-file-risk");
        $data = $request->collect();
        $key_rules = $data->map(function($val, $key) {
            if(str_contains($key, "tanggal")) {
                return $key = "required|date";
            }
            return $key = "required|string";
        })->toArray();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];
        $rules = $key_rules;
        $data = $data->toArray();
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            // dd($validation->errors());
            $field_mandatory = self::input_name_to_label(collect($validation->errors()->keys()));
            Alert::html('Error', "Field <b>$field_mandatory</b> harus terisi!", "error");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
        }

        if (isset($data["stage"])) {
            $is_tender_menang = $data["stage"];
            $is_closed = 0;
        } else {
            $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
            $is_closed = !empty($data["is-closed"]) ? 1 : 0;
        }
        $validation->validate();

        $risk->verifikasi = $data["verifikasi"];
        $risk->id_contract = $data["id-contract"];
        $risk->stage = $is_tender_menang; // Kolom Tender Menang dialihfungsikan menjadi Stage
        $risk->kategori = $data["kategori"];
        $risk->kriteria = $data["kriteria"];
        $risk->probis_1_2 = $data["probis_1_2"];
        $risk->probis_terganggu = $data["probis_terganggu"];
        $risk->penyebab = $data["penyebab"];
        $risk->resiko_peluang = $data["resiko_peluang"];
        $risk->dampak = $data["dampak"];
        $risk->nilai_resiko_r0 = $data["nilai_resiko_r0"];
        $risk->item_kontrol = $data["item_kontrol"];
        $risk->probabilitas = $data["probabilitas"];
        $risk->tingkat_efektifitas_kontrol = $data["tingkat_efektifitas_kontrol"];
        $risk->nilai_resiko_r1 = $data["nilai_resiko_r1"];
        $risk->tindak_lanjut_mitigasi = $data["tindak_lanjut_mitigasi"];
        $risk->tingkat_efektifitas_tindak_lanjut = $data["tingkat_efektifitas_tindak_lanjut"];
        $risk->nilai_resiko_r2 = $data["nilai_resiko_r2"];
        $risk->biaya_proaktif = $data["biaya_proaktif"];
        $risk->tanggal_mulai = $data["tanggal_mulai"];
        $risk->tanggal_selesai = $data["tanggal_selesai"];
        $risk->tindak_lanjut_reaktif = $data["tindak_lanjut_reaktif"];
        $risk->biaya_reaktif = $data["biaya_reaktif"];
        $risk->pic_rtl = $data["pic_rtl"];
        $risk->uraian = $data["uraian"];
        $risk->nilai = $data["nilai"];
        $risk->skor = $data["skor"];
        $risk->is_closed = $is_closed;
        if ($risk->save()) {
            // moveFileTemp($file, $id_document);
            Alert::success('Success', "Resiko berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Resiko gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Risk of Contract to server or database
    public function riskUpdate(Request $request)
    {
        
        // $id_document = (string) $faker->uuid3();
        // $file = $request->file("attach-file-risk");
        $data = $request->collect();
        $risk = InputRisks::find($data["id-risk"]);
        // dd($risk);
        $key_rules = $data->map(function($val, $key) {
            if(str_contains($key, "tanggal")) {
                return $key = "required|date";
            }
            return $key = "required|string";
        })->toArray();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
        ];
        $rules = $key_rules;
        $data = $data->toArray();
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            // dd($validation->errors());
            $field_mandatory = self::input_name_to_label(collect($validation->errors()->keys()));
            Alert::html('Error', "Field <b>$field_mandatory</b> harus terisi!", "error");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
            // dd($validation->errors());
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
        }

        if (isset($data["stage"])) {
            $is_tender_menang = $data["stage"];
        } else {
            $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        }
        $validation->validate();

        $risk->verifikasi = $data["verifikasi"];
        $risk->id_contract = $data["id-contract"];
        $risk->stage = $is_tender_menang; // Kolom Tender Menang dialihfungsikan menjadi Stage
        $risk->kategori = $data["kategori"];
        $risk->kriteria = $data["kriteria"];
        $risk->probis_1_2 = $data["probis_1_2"];
        $risk->probis_terganggu = $data["probis_terganggu"];
        $risk->penyebab = $data["penyebab"];
        $risk->resiko_peluang = $data["resiko_peluang"];
        $risk->dampak = $data["dampak"];
        $risk->nilai_resiko_r0 = str_replace(".", "", $data["nilai_resiko_r0"]);
        $risk->item_kontrol = $data["item_kontrol"];
        $risk->probabilitas = $data["probabilitas"];
        $risk->tingkat_efektifitas_kontrol = $data["tingkat_efektifitas_kontrol"];
        $risk->nilai_resiko_r1 = str_replace(".", "", $data["nilai_resiko_r1"]);
        $risk->tindak_lanjut_mitigasi = $data["tindak_lanjut_mitigasi"];
        $risk->tingkat_efektifitas_tindak_lanjut = $data["tingkat_efektifitas_tindak_lanjut"];
        $risk->nilai_resiko_r2 = str_replace(".", "", $data["nilai_resiko_r2"]);
        $risk->biaya_proaktif = str_replace(".", "", $data["biaya_proaktif"]);
        $risk->tanggal_mulai = $data["tanggal_mulai"];
        $risk->tanggal_selesai = $data["tanggal_selesai"];
        $risk->tindak_lanjut_reaktif = $data["tindak_lanjut_reaktif"];
        $risk->biaya_reaktif = str_replace(".", "", $data["biaya_reaktif"]);
        $risk->pic_rtl = $data["pic_rtl"];
        $risk->uraian = $data["uraian"];
        $risk->nilai = str_replace(".", "", $data["nilai"]);
        $risk->skor = $data["skor"];
        $risk->is_closed = (bool)$data["status"];
        if ($risk->save()) {
            // moveFileTemp($file, $id_document);
            Alert::success('Success', "Resiko berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Resiko gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Upload Laporan Bulanan of Contract to server or database
    public function monthlyReportUpload(Request $request, MonthlyReports $monthlyReports)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-bulanan");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file-bulanan" => "required|file",
            "document-name-bulanan" => "required|string",
            "note-bulanan" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Review Contract gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        $monthlyReports->id_contract = $data["id-contract"];
        $monthlyReports->id_document = $id_document;
        $monthlyReports->document_name_report = $data["document-name-bulanan"];
        $monthlyReports->note_report = $data["note-bulanan"];
        if ($monthlyReports->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Laporan Bulanan berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Laporan Bulanan gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    // Upload Dokumen Site Instruction to server or database
    public function siteInstruction(Request $request, SiteInstruction $siteInstruction)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-dokumen-instruction" => "required|file",
            "nomor-dokumen-instruction" => "required|string",
            "tanggal-dokumen-instruction" => "required|date",
            "uraian-dokumen-instruction" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-dokumen-instruction");
            Alert::error('Error', "Dokumen Site Instruction gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-dokumen-instruction");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();

        if(isset($data['file-dokumen-instruction'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->profit_center = $data["profit-center"];
            $uploadFinal->category = "Dokumen Site Instruction";

            $siteInstruction->nama_document = $nama_file;
            $siteInstruction->id_document = $id_document;

                
        }

        $siteInstruction->id_contract = $data["id-contract"];
        $siteInstruction->profit_center = $data["profit-center"];
        // $siteInstruction->id_document = $id_document;
        $siteInstruction->nomor_dokumen = $data["nomor-dokumen-instruction"];
        $siteInstruction->tanggal_dokumen = $data["tanggal-dokumen-instruction"];
        $siteInstruction->uraian_dokumen = $data["uraian-dokumen-instruction"];
        if ($siteInstruction->save() && $uploadFinal->save()) {
            // moveFileTemp($file, explode(".", $id_document)[0]);
            $file->move(public_path('words'), $id_document);
            Alert::success('Success', "Dokumen Site Instruction berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Site Instruction gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteSiteInstruction(SiteInstruction $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }
    // Upload Dokumen Technical Form to server or database
    public function technicalForm(Request $request, TechnicalForm $technicalForm)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus date",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-technical-form" => "required|file",
            "nomor-technical-form" => "required|string",
            "tanggal-technical-form" => "required|date",
            "uraian-technical-form" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-technical-form");
            Alert::error('Error', "Dokumen Technical Form gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-technical-form");
        $nama_file = $file->getClientOriginalName();
        $id_document = date("His_") . $file->getClientOriginalName();

        if(isset($data['file-technical-form'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = "Dokumen Technical Form";
            $uploadFinal->profit_center = $data["profit-center"];

            $technicalForm->nama_document = $nama_file;
            $technicalForm->id_document = $id_document;
                
        }

        $technicalForm->id_contract = $data["id-contract"];
        $technicalForm->profit_center = $data["profit-center"];
        // $technicalForm->id_document = $id_document;
        $technicalForm->nomor_dokumen = $data["nomor-technical-form"];
        $technicalForm->tanggal_dokumen = $data["tanggal-technical-form"];
        $technicalForm->uraian_dokumen = $data["uraian-technical-form"];
        if ($technicalForm->save() && $uploadFinal->save()) {
            // moveFileTemp($file, explode(".", $id_document)[0]);
            $file->move(public_path('words'), $id_document);
            Alert::success('Success', "Dokumen Technical Form berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Technical Form gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteTechnicalForm(TechnicalForm $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }
    // Upload Dokumen Technical Query to server or database
    public function technicalQuery(Request $request, TechnicalQuery $technicalQuery)
    {
        $data = $request->all();
        

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus date",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-technical-query" => "required|file",
            "nomor-technical-query" => "required|string",
            "tanggal-technical-query" => "required|date",
            "uraian-technical-query" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-technical-query");
            Alert::error('Error', "Dokumen Technical Query gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-technical-query");
        $nama_file = $file->getClientOriginalName();
        $id_document = date("His_") . $file->getClientOriginalName();

        if(isset($data['file-technical-query'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = "Dokumen Technical Query";
            $uploadFinal->profit_center = $data["profit-center"];

            $technicalQuery->nama_document = $nama_file;
            $technicalQuery->id_document = $id_document;

                
        }

        $technicalQuery->id_contract = $data["id-contract"];
        $technicalQuery->id_document = $id_document;
        $technicalQuery->nomor_dokumen = $data["nomor-technical-query"];
        $technicalQuery->tanggal_dokumen = $data["tanggal-technical-query"];
        $technicalQuery->uraian_dokumen = $data["uraian-technical-query"];
        $technicalQuery->profit_center = $data["profit-center"];

        if ($technicalQuery->save() && $uploadFinal->save()) {
            $file->move(public_path('words'), $id_document);
            // moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success('Success', "Dokumen Technical Query berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Technical Query gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteTechnicalQuery(TechnicalQuery $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }
    // Upload Dokumen Field Design Change to server or database
    public function fieldChange(Request $request, FieldChange $fieldChange)
    {
        $data = $request->all();
        

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus date",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-field-design-change" => "required|file",
            "nomor-field-design-change" => "required|string",
            "tanggal-field-design-change" => "required|date",
            "uraian-field-design-change" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-field-design-change");
            Alert::error('Error', "Dokumen Field Design Change gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-field-design-change");
        $nama_file = $file->getClientOriginalName();
        $id_document = date("His_") . $file->getClientOriginalName();
        if(isset($data['file-field-design-change'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = "Dokumen Field Design Change";
            $uploadFinal->profit_center = $data["profit-center"];

            $fieldChange->nama_document = $nama_file;
            $fieldChange->id_document = $id_document;
                
        }

        $fieldChange->id_contract = $data["id-contract"];
        $fieldChange->id_document = $id_document;
        $fieldChange->nomor_dokumen = $data["nomor-field-design-change"];
        $fieldChange->tanggal_dokumen = $data["tanggal-field-design-change"];
        $fieldChange->uraian_dokumen = $data["uraian-field-design-change"];
        $fieldChange->profit_center = $data["profit-center"];

        if ($fieldChange->save() && $uploadFinal->save()) {
            $file->move(public_path('words'), $id_document);
            // moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success('Success', "Dokumen Field Design Change berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Field Design Change gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteFieldChange(FieldChange $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }
    // Upload Dokumen Contract Change Notice to server or database
    public function changeNotice(Request $request, ContractChangeNotice $changeNotice)
    {
        $data = $request->all();
        

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus date",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-contract-change-notice" => "required|file",
            "nomor-contract-change-notice" => "required|string",
            "tanggal-contract-change-notice" => "required|date",
            "uraian-contract-change-notice" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Contract Change Notice gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-contract-change-notice");
        $nama_file = $file->getClientOriginalName();
        $id_document = date("His_") . $file->getClientOriginalName();
        if(isset($data['file-contract-change-notice'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = "Dokumen Contract Change Notice";
            $uploadFinal->profit_center = $data["profit-center"];

            $changeNotice->nama_document = $nama_file;
            $changeNotice->id_document = $id_document;

                
        }

        $changeNotice->id_contract = $data["id-contract"];
        $changeNotice->id_document = $id_document;
        $changeNotice->nomor_dokumen = $data["nomor-contract-change-notice"];
        $changeNotice->tanggal_dokumen = $data["tanggal-contract-change-notice"];
        $changeNotice->uraian_dokumen = $data["uraian-contract-change-notice"];
        $changeNotice->profit_center = $data["profit-center"];

        if ($changeNotice->save() && $uploadFinal->save()) {
            $file->move(public_path('words'), $id_document);
            // moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success('Success', "Dokumen Change Notice berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Change Notice gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteChangeNotice(ContractChangeNotice $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }
    // Upload Dokumen Contract Change Order to server or database
    public function changeOrder(Request $request, ContractChangeOrder $changeOrder)
    {
        $data = $request->all();
        

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus date",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-contract-change-order" => "required|file",
            "nomor-contract-change-order" => "required|string",
            "tanggal-contract-change-order" => "required|date",
            "uraian-contract-change-order" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Contract Change Order gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-contract-change-order");
        $nama_file = $file->getClientOriginalName();
        $id_document = date("His_") . $file->getClientOriginalName();
        if(isset($data['file-contract-change-order'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = "Dokumen Contract Change Order";
            $uploadFinal->profit_center = $data["profit-center"];

            $changeOrder->nama_document = $nama_file;
            $changeOrder->id_document = $id_document;
                
        }

        $changeOrder->id_contract = $data["id-contract"];
        $changeOrder->id_document = $id_document;
        $changeOrder->nomor_dokumen = $data["nomor-contract-change-order"];
        $changeOrder->tanggal_dokumen = $data["tanggal-contract-change-order"];
        $changeOrder->uraian_dokumen = $data["uraian-contract-change-order"];
        $changeOrder->profit_center = $data["profit-center"];

        if ($changeOrder->save() && $uploadFinal->save()) {
            $file->move(public_path('words'), $id_document);
            // moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success('Success', "Dokumen Change Order berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Change Order gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteChangeOrder(ContractChangeOrder $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }
    // Upload Dokumen Contract Change Proposal to server or database
    public function changeProposal(Request $request, ContractChangeProposal $changeProposal)
    {
        $data = $request->all();
        

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "date" => "Field di atas harus date",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "file-contract-change-proposal" => "required|file",
            "nomor-contract-change-proposal" => "required|string",
            "tanggal-contract-change-proposal" => "required|date",
            "uraian-contract-change-proposal" => "required|string",
            // "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Contract Change Proposal gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        // if (empty($is_id_contract_exist)) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");$request->old("nomor-dokumen-instruction");
        //     Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // return Redirect::back();
        // }
        $file = $request->file("file-contract-change-proposal");
        $nama_file = $file->getClientOriginalName();
        $id_document = date("His_") . $file->getClientOriginalName();

        if(isset($data['file-contract-change-proposal'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $data["id-contract"];
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = "Dokumen Contract Change Proposal";
            $uploadFinal->profit_center = $data["profit-center"];

            $changeProposal->nama_document = $nama_file;
            $changeProposal->id_document = $id_document;
                
        }

        $changeProposal->id_contract = $data["id-contract"];
        $changeProposal->id_document = $id_document;
        $changeProposal->nomor_dokumen = $data["nomor-contract-change-proposal"];
        $changeProposal->tanggal_dokumen = $data["tanggal-contract-change-proposal"];
        $changeProposal->uraian_dokumen = $data["uraian-contract-change-proposal"];
        $changeProposal->profit_center = $data["profit-center"];

        if ($changeProposal->save() && $uploadFinal->save()) {
            $file->move(public_path('words'), $id_document);
            // moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success('Success', "Dokumen Change Proposal berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Dokumen Change Proposal gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect($_SERVER["HTTP_REFERER"]);
    }
    public function deleteChangeProposal(ContractChangeProposal $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }



    // Uplaod Serah Terima of Contract to server or database
    public function handOverUpload(Request $request, HandOvers $handOver)
    {
        $faker = new Uuid();
        $id_document = (string) $faker->uuid3();
        $file = $request->file("attach-file-terima");
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file-terima" => "required|file",
            "document-name-terima" => "required|string",
            "note-terima" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Serah Terima Kontrak gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            Alert::error('Error', "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return Redirect::back();
        }

        $content_word_html = $data["content-word-terima"];
        $handOver->id_contract = $data["id-contract"];
        $handOver->id_document = $id_document;
        $handOver->document_name_terima = $data["document-name-terima"];
        $handOver->note_terima = $data["note-terima"];
        if ($handOver->save()) {
            moveFileTemp($file, $id_document);
            Alert::success('Success', "Serah Terima Kontrak berhasil ditambahkan");
            return Redirect::back();
        }
        Alert::error('Error', "Serah Terima Kontrak gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return Redirect::back();
    }

    public function klarifikasiNegoUpload(Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Hasil Klarifikasi dan Negosiasi CDA gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return redirect()->back();
        }
        $file = $request->file("attach-file");
        $klarifikasi_model = new KlarifikasiNegosiasiCda();
        $klarifikasi_model->id_contract = $data["id-contract"];
        $klarifikasi_model->id_document = Str::uuid();
        $klarifikasi_model->document_name = $data["document-name"];
        $klarifikasi_model->created_by = auth()->user()->id;
        $klarifikasi_model->note = $data["note"];
        if ($klarifikasi_model->save()) {
            moveFileTemp($file, $klarifikasi_model->id_document);
            Alert::success("Success", "Hasil Klarifikasi dan Negosiasi CDA berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Hasil Klarifikasi dan Negosiasi CDA gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function kontrakTandaTanganUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Kontrak Tanda Tangan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new KontrakBertandatangan();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Kontrak Tanda Tangan berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Kontrak Tanda Tangan gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function reviewPembatalanKontrak(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Kontrak Tanda Tangan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new ReviewPembatalanKontrak();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Review Pembatalan Kontrak berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Review Pembatalan Kontrak gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function perjanjianKSO(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Perjanjian KSO gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new PerjanjianKso();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "Perjanjian KSO berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Perjanjian KSO gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function dokumenPendukungUpload(Request $request)
    {
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            // "document-name" => "required|string",
            "note" => "required|string",
            "id-perubahan-kontrak" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Pendukung gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = PerubahanKontrak::find($data["id-perubahan-kontrak"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new DokumenPendukung();
        $model->id_perubahan_kontrak = $data["id-perubahan-kontrak"];
        $model->id_contract = $data["id_contract"];
        // $model->id_document = Str::uuid();
        $id_document = date("His_") . str_replace(' ', '_', $file->getClientOriginalName());
        $model->id_document = $id_document;
        // $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success("Success", "Dokumen Pendukung berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "Dokumen Pendukung gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function dokumenPendukungDelete(DokumenPendukung $id)
    {
        $file = $id;
        if (empty($file)) {
            Alert::error('Error', 'Dokumen Tidak Ditemukan');
            return redirect()->back();
        }

        $nama_file = $file->id_document;
        if ($file->delete()) {
            File::delete(public_path("words/$nama_file"));
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
        }
        return (object)[
            'success' => false,
            'message' => "Dokumen gagal dihapus",
        ];
    }

    public function momMeeting(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "numeric" => "Field di atas harus numeric",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only",
        ];
        $rules = [
            "attach-file" => "required|file",
            "document-name" => "required|string",
            "note" => "required|string",
            "id-contract" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "MoM Kick Off Meeting gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        $file = $request->file("attach-file");
        $model = new MomKickOffMeeting();
        $model->id_contract = $data["id-contract"];
        $model->id_document = Str::uuid();
        $model->document_name = $data["document-name"];
        $model->created_by = auth()->user()->id;
        $model->note = $data["note"];
        if ($model->save()) {
            moveFileTemp($file, $model->id_document);
            Alert::success("Success", "MoM Kick Off Meeting berhasil dibuat");
            return redirect()->back();
        }
        Alert::error("Error", "MoM Kick Off Meeting gagal dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function documentBastContractUpload(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $faker = new Uuid();
        $dokumen = new ContractBast();
        $id_document = $faker->uuid3();
        $file_name = $data['dokumen-bast-1']->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($data['dokumen-bast-1'], $id_document);
        $dokumen->nomor_dokumen = $data["nomor-dokumen"];
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_contract =  $data["id-contract"];
        $dokumen->bast =  (int) $data["bast"];
        $dokumen->jenis_dokumen =  $data["jenis-bast"] ?? "";
        $dokumen->status_dokumen =  $data["status_dokumen"] ?? "";
        $dokumen->tanggal_dokumen =  $data["tanggal-dokumen"];
        $dokumen->id_document = $id_document;
        // dd($dokumen);

        if($dokumen->save()){
            Alert::success("Success", "Dokumen Bast berhasil dibuat");
            return redirect()->back();
        };

        // $messages = [
        //     "required" => "Field di atas wajib diisi",
        //     "file" => "This field must be file only",
        // ];
        // $rules = [
        //     "dokumen-bast-1" => "required|file",
        //     "dokumen-bast-2" => "required|file",
        //     "id-contract" => "required",
        // ];
        // $validation = Validator::make($data, $rules, $messages);
        // if ($validation->fails()) {
        //     Alert::error('Error', "Dokument Bast gagal ditambahkan");
        //     return Redirect::back();
        //     // dd($validation->errors());
        // }
        // $validation->validate();

        // $faker = new Uuid();
        // $contract_managements = ContractManagements::find($data["id-contract"]);

        // if (isset($data["dokumen-bast-1"])) {
        //     if (!empty($contract_managements->dokumen_bast_1)) {
        //         $get_dokumen = File::get(public_path("/words/$contract_managements->dokumen_bast_1.docx"));
        //         if (!empty($get_dokumen)) {
        //             File::delete(public_path("/words/$contract_managements->dokumen_bast_1.docx"));
        //         }
        //     }
        //     $id_document = $faker->uuid3();
        //     $contract_managements->dokumen_bast_1 = $id_document;
        //     moveFileTemp($data["dokumen-bast-1"], $id_document);
        // }

        // if (isset($data["dokumen-bast-2"])) {
        //     if (!empty($contract_managements->dokumen_bast_2)) {
        //         $get_dokumen = File::get(public_path("/words/$contract_managements->dokumen_bast_2.docx"));
        //         if (!empty($get_dokumen)) {
        //             File::delete(public_path("/words/$contract_managements->dokumen_bast_2.docx"));
        //         }
        //     }
        //     $id_document = $faker->uuid3();
        //     $contract_managements->dokumen_bast_2 = $id_document;
        //     moveFileTemp($data["dokumen-bast-2"], $id_document);
        // }


        // if ($contract_managements->save()) {
        //     Alert::success("Success", "Dokument Bast berhasil ditambahkan");
        //     return redirect()->back();
        // }
        // Alert::error("Erorr", "Dokument Bast gagal ditambahkan");
        // return Redirect::back();
        return redirect()->back();
    }

    public function documentBastContractEdit(Request $request, $id_bast) 
    {
        $data = $request->all();
        // dd($data);
        $faker = new Uuid();
        $dokumen = ContractBast::find($id_bast);

        if (!empty($data['dokumen-bast-1'])) {
            $old_file = $dokumen->id_document;
            File::delete(public_path("words/$old_file"));

            $id_document = $faker->uuid3();
            $file_name = $data['dokumen-bast-1']->getClientOriginalName();
            $nama_document = date("His_") . $file_name;

            moveFileTemp($data['dokumen-bast-1'], $id_document);
            $dokumen->nomor_dokumen = $data["nomor-dokumen"];
            $dokumen->nama_dokumen = $nama_document;
            $dokumen->id_document = $id_document;
        }
        $dokumen->id_contract =  $data["id-contract"];
        $dokumen->bast =  (int) $data["bast"];
        if (isset($data["jenis-bast"])) {
            $dokumen->jenis_dokumen =  $data["jenis-bast"] ?? "";
        }
        $dokumen->status_dokumen =  $data["status_dokumen"] ?? "";
        $dokumen->tanggal_dokumen =  $data["tanggal-dokumen"];
        // dd($dokumen);

        if ($dokumen->save()) {
            Alert::success("Success", "Dokumen Bast berhasil diubah");
            return redirect()->back();
        };
        return redirect()->back();
    }

    public function deleteBast($id_document){
        // dd($id_document);
        $documentBast = ContractBast::where('id_document', '=', $id_document)->first();
        if (str_contains($documentBast->nama_dokumen, '.pdf')) {
            File::delete(public_path("words/" . $id_document . '.pdf'));
        } else {
            File::delete(public_path("words/" . $id_document . '.docx'));
        }
        if($documentBast->delete()){
            // Alert::success("Success", "Dokumen berhasil dihapus");
            // return redirect()->back();
            return (object)[
                'success' => true,
                'message' => 'Dokumen BAST berhasil dihapus'
            ];
        }
        return (object)[
            'success' => false,
            'message' => 'Dokumen BAST gagal dihapus'
        ];
        // Alert::success("Error", "Dokumen gagal dihapus");
        // return redirect()->back();
    }

    public function baDefectContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "ba-defect" => "required",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "BA Defect gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $faker = new Uuid();
        if (count($data["ba-defect"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["ba-defect"] as $dokumen_ba_defect) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_ba_defect, $id_document);
            }
            $contract->list_dokumen_ba_defect = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["ba-defect"][0], $id_document);
            $contract->list_dokumen_ba_defect = $id_document;
        }

        if ($contract->save()) {
            Alert::success("Success", "BA Defect berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "BA Defect gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function dokumenPendukungContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "dokumen-pendukung" => "required",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "BA Defect gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        if (!empty($contract->dokumen_kontrak_dan_addendum)) {
            $list_dokumen_kontrak_dan_addendum = collect(explode(", ", $contract->dokumen_pendukung));
            foreach ($list_dokumen_kontrak_dan_addendum as $dokumen) {
                $get_dokumen = File::get(public_path("/words/$dokumen.docx"));
                if (!empty($get_dokumen)) {
                    File::delete(public_path("/words/$dokumen.docx"));
                }
            }
        }

        $faker = new Uuid();
        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
            $contract->dokumen_pendukung = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $contract->dokumen_pendukung = $id_document;
        }

        if ($contract->save()) {
            Alert::success("Success", "Dokumen berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Dokumen gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function pendingIssueContractUpload(Request $request, PendingIssue $pendingIssue)
    {
        $data = $request->all();
        $file = $request->file("file-document");

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "pending-issue" => "required",
            "penyebab-issue" => "required",
            // "resiko-biaya" => "required",
            // "resiko-waktu" => "required",
            // "resiko-mutu" => "required",
            "rencana-tindak-lanjut" => "required",
            // "ancaman" => "required",
            "id-contract" => "required",
            // "peluang" => "required",
        ];

        if (isset($data["file-document"])) {
            $rules["file-document"] = "required|file";
            $id_document = date("His_") . $file->getClientOriginalName();
            $nama_file = $file->getClientOriginalName();
        } else {
            $rules["pending-issue"] = "required";
        }
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Pending Issue gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        // dd(isset($data['kategori']));
        if(isset($data['file-document'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $contract->id_contract;
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = $data["kategori"];

            $pendingIssue->nama_document = $nama_file;
            $pendingIssue->id_document = $id_document;

            $uploadFinal->save();
            if (!$uploadFinal->save() || !moveFileTemp($file, explode(".", $id_document)[0])) {
                Alert::error("Erorr", "Dokumen gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
            }
                
        }

        
        $pendingIssue->stage = $data["stage"];
        $pendingIssue->issue = $data["pending-issue"];
        $pendingIssue->status = true;
        $pendingIssue->id_contract = $contract->id_contract;
        $pendingIssue->penyebab = $data["penyebab-issue"];
        $pendingIssue->biaya = str_replace(".", "", $data["resiko-biaya"]);
        $pendingIssue->waktu = $data["resiko-waktu"];
        $pendingIssue->mutu = $data["resiko-mutu"];
        $pendingIssue->ancaman = $data["ancaman"];
        $pendingIssue->peluang = $data["peluang"];
        $pendingIssue->rencana_tindak_lanjut = $data["rencana-tindak-lanjut"];
        $pendingIssue->target_waktu_penyelesaian = $data["target-waktu-penyelesaian"];
        if ($pendingIssue->save()) {
            Alert::success("Success", "Pending Issue berhasil ditambahkan");
            return Redirect::back();
            // return redirect()->back();
        }
        Alert::error("Erorr", "Pending Issue gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }
    
    public function pendingIssueContractEdit(Request $request, PendingIssue $pendingIssue)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "pending-issue" => "required",
            "penyebab-issue" => "required",
            // "resiko-biaya" => "required",
            // "resiko-waktu" => "required",
            // "resiko-mutu" => "required",
            "rencana-tindak-lanjut" => "required",
            // "ancaman" => "required",
            "id-contract" => "required",
            // "peluang" => "required",
        ];
        if (isset($data["pending-issue-file"])) {
            $rules["pending-issue-file"] = "required|file";
        } else {
            $rules["pending-issue"] = "required";
        }
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Pending Issue gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $is_exist_pd = PendingIssue::find($data["id"]);
        // dd($is_exist_pd);
        if(empty($is_exist_pd)){
            Alert::error("Error", "Pending Issue belum dibuat!");
            return Redirect::back()->with("modal", $data["modal-name"]);
        }
        
        $is_exist_pd->stage = $data["stage"];
        $is_exist_pd->issue = $data["pending-issue"];
        $is_exist_pd->status = (bool) $data["status"];
        $is_exist_pd->id_contract = $contract->id_contract;
        $is_exist_pd->penyebab = $data["penyebab-issue"];
        $is_exist_pd->biaya = str_replace(".", "", $data["resiko-biaya"]);
        $is_exist_pd->waktu = $data["resiko-waktu"];
        $is_exist_pd->mutu = $data["resiko-mutu"];
        $is_exist_pd->ancaman = $data["ancaman"];
        $is_exist_pd->peluang = $data["peluang"];
        $is_exist_pd->rencana_tindak_lanjut = $data["rencana-tindak-lanjut"];
        $is_exist_pd->target_waktu_penyelesaian = $data["target-waktu-penyelesaian"];
        if ($is_exist_pd->save()) {
            Alert::success("Success", "Pending Issue berhasil diubah");
            return Redirect::back();
            // return redirect()->back();
        }
        Alert::error("Erorr", "Pending Issue gagal diubah");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function penutupanProyekContractUpload(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "kontrak-dan-addendum-file" => "required",
            "id-contract" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen Kontrak dan Addendum gagal ditambahkan");
            return Redirect::back();
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back();
            // return redirect()->back();
        }

        $contract = ContractManagements::find($data["id-contract"]);
        $faker = new Uuid();

        if (!empty($contract->dokumen_kontrak_dan_addendum)) {
            $list_dokumen_kontrak_dan_addendum = collect(explode(",", $contract->dokumen_kontrak_dan_addendum));
            foreach ($list_dokumen_kontrak_dan_addendum as $dokumen) {
                $get_dokumen = File::get(public_path("/words/$dokumen.docx"));
                if (!empty($get_dokumen)) {
                    File::delete(public_path("/words/$dokumen.docx"));
                }
            }
        }

        if (count($data["kontrak-dan-addendum-file"]) > 1) {
            $list_id_document_kontrak_dan_addendum = [];
            foreach ($data["kontrak-dan-addendum-file"] as $dokumen) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_kontrak_dan_addendum, $id_document);
                moveFileTemp($dokumen, $id_document);
            }
            $contract->dokumen_kontrak_dan_addendum = join(",", $list_id_document_kontrak_dan_addendum);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["kontrak-dan-addendum-file"][0], $id_document);
            $contract->dokumen_kontrak_dan_addendum = $id_document;
        }

        if ($contract->save()) {
            Alert::success("Success", "Dokumen Kontrak dan Addendum berhasil ditambahkan");
            // return redirect()->back();
            return Redirect::back();
        }
        Alert::error("Error", "Dokumen Kontrak dan Addendum gagal ditambahkan");
        // return redirect()->back();
        return Redirect::back();
    }

    public function usulanPerubahanDraftContractUpload(Request $request, UsulanPerubahanDraft $usulanPerubahanDraft)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            // "file" => "This field must be file only",
        ];
        $rules = [
            "kategori" => "required",
            "id-contract" => "required",
            "deskripsi-klausul-awal" => "required",
            "usulan-perubahan-klausul" => "required",
            "isu" => "required",
            "keterangan" => "required",
            // "pasals" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Usulan Perubahan Draft gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
        }

        // $pasals = collect($data["pasals"]);
        // $pasals = $pasals->join("|");

        $usulanPerubahanDraft->id_contract = $contract->id_contract;
        $usulanPerubahanDraft->deskripsi_klausul_awal = $data["deskripsi-klausul-awal"];
        $usulanPerubahanDraft->isu = $data["isu"];
        $usulanPerubahanDraft->usulan_perubahan_klausul = $data["usulan-perubahan-klausul"];
        $usulanPerubahanDraft->kategori = $data["kategori"];
        $usulanPerubahanDraft->keterangan = $data["keterangan"];
        // $usulanPerubahanDraft->pasal_perbaikan = $pasals;
        if ($usulanPerubahanDraft->save()) {
            Alert::success("Success", "Usulan Perubahan Draft berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Usulan Perubahan Draft gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
    }

    public function rencanaKerjaManajemenContractUpload(Request $request, RencanKerjaManajemenKontrak $rencanKerjaManajemenKontrak)
    {
        $data = $request->all();
        $file = $request->file("file-document");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "id-contract" => "required",
            "file-document" => "required|file",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Rencana Kerja Manajemen Kontrak gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $rencanKerjaManajemenKontrak->id_contract = $contract->id_contract;
        $rencanKerjaManajemenKontrak->id_document = $id_document;
        $rencanKerjaManajemenKontrak->nama_document = $nama_file;

        if ($rencanKerjaManajemenKontrak->save()) {
            moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success("Success", "Rencana Kerja Manajemen Kontrak berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Rencana Kerja Manajemen Kontrak gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
    }

    public function uploadChecklistKontrak(Request $request) {
        $data = $request->all();
        // dd($data);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be string only"
        ];
        $rules = [
            "id-contract" => "required",
            "jawaban-1" => "required",
            "jawaban-2" => "required",
            "jawaban-3" => "required",
            "jawaban-4" => "required",
            "jawaban-5" => "required",
            "jawaban-6" => "required",
            "jawaban-7" => "required",
            "jawaban-8" => "required",
            "jawaban-9" => "required",
            "jawaban-10" => "required",
            "jawaban-11" => "required",
            "jawaban-12" => "required",
            "jawaban-13" => "required",
            "jawaban-14" => "required",
            "jawaban-15" => "required",
            "jawaban-16" => "required",
            "jawaban-17" => "required",
            "jawaban-18" => "required",
            "jawaban-19" => "required",
            "jawaban-20" => "required",
            "jawaban-21" => "required",
            "jawaban-22" => "required",
            "jawaban-23" => "required",
            "jawaban-24" => "required",
            "jawaban-25" => "required",
        ];
        // $validation = Validator::make($data, $rules, $messages);
        // if ($validation->fails()) {
        //     Alert::error('Error', "Rencana Kerja Manajemen Kontrak gagal ditambahkan");
        //     return Redirect::back()->with("modal", $data["modal-name"]);
        //     // dd($validation->errors());
        // }
        // if($validation->validate()){
        //     echo("success!");
        // }
        // function progressAwal($data){
        //     return $data->filter(function($s1, $key) use($data) {
        //          return !empty($data[0]) || !empty($data[1]);
        //      });
        //  }
        // $sub_1 = progressAwal(collect($data["sub-jawaban-1"]));

        // Check kalo index 0 dan 1 di sub jawab 1 ada
        // $is_sub_0_1_exist = $sub_1->count() > 0;
        // $subJawaban_1 = $sub_1->first();
        // $kategori = "";
        // if($is_sub_0_1_exist) {
        //     $kategori = "Progress 0-20";
        // } else {
        //     $kategori = "Progress 20-90";
        // }

        // $kategori_2 = "";
        // $sub_2 = progressAwal(collect($data["sub-jawaban-2"]));
        // // Check kalo index 0 dan 1 di sub jawab 2 ada
        // $is_sub_exist = $sub_2->count() > 0;
        // $subJawaban_2 = $sub_2->first();
        // if($is_sub_exist) {
        //     $kategori_2 = "Progress 0-20";
        // } else {
        //     $kategori_2 = "Progress 20-90";
        // }
        // $data["sub-jawaban-1"] = $subJawaban_1;
        // $data["sub-jawaban-2"] = $subJawaban_2;
        // dd($subJawaban_1, $subJawaban);

        $test_keys = collect($data)->keys();
        $new_data = collect();
        $test_keys->each(function($tk) use($data, &$new_data) {
            // $checklist_model = new ContractChecklist();
            if($tk != "modal-name" && $tk != "_token") {
                $key_column_formatted = str_replace('-', "_", $tk);
                $new_data[$key_column_formatted] = $data[$tk];
            }
        });
        $new_data = $new_data->map(function($nd) {
            if(is_array($nd)) {
                $nd_collect = collect($nd)->filter(function($ndc, $key) use($nd) {
                    return !empty($nd[$key]);
                })->first();
                if(str_contains($nd_collect, ".")){
                    $nd_collect = str_replace(".", "", $nd_collect);
                }
                return $nd_collect;
            }
            
            
            return $nd;
        });
        
        // $new_data->each(function($data, $key) {
            
        // });
        $checklist_model = new ContractChecklist();
        $fillable_attributes = $checklist_model->getFillable();
        $checklist_model->fillable($new_data->keys()->toArray());
        $checklist_model->fill($new_data->toArray());
        $checklist_model->exists = true;
        $checklist_model->fillable($fillable_attributes);
        // $checklist_model->timestamps = true;
        $checklist_model->created_at = Carbon::now();
        $checklist_model->updated_at = null;
        $checklist_model->syncOriginal();
        // dd($checklist_model);
        

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        try {
            if(ContractChecklist::insert($new_data->toArray())){
                Alert::success("Success", "Checklist Manajemen Kontrak Berhasil Dibuat");
                return Redirect::back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        Alert::error("Error", "Checklist Manajemen Kontrak Berhasil Dibuat");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // return redirect()->back();
        
    }

    public function uploadAsuransi(Request $request, ContractAsuransi $asuransi) {
        $data = $request->all();
        $file = $request->file("file-document");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be string only",
        ];
        $rules = [
            "kategori-asuransi" => "required",
            "id-contract" => "required",
            "nomor-polis-asuransi" => "required",
            "penerbit-polis-asuransi" => "required",
            "tanggal-penerbitan-asuransi" => "required",
            "tanggal-berakhir-asuransi" => "required",
            // "status-asuransi" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Data Asuransi gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        if(isset($data['file-document'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $contract->id_contract;
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = $data["kategori"];
            $asuransi->id_document = $id_document;
            $asuransi->nama_document = $nama_file;
            $uploadFinal->save();
            if (!$uploadFinal->save() || !moveFileTemp($file, explode(".", $id_document)[0])) {
                Alert::error("Erorr", "Dokumen gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
            }
        }

        $asuransiExpired = new DateTime($data["tanggal-berakhir-asuransi"]);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($asuransiExpired);
        $is_expired = $interval->invert == 1 ? true : false;

        $asuransi->id_contract = $data["id-contract"];
        $asuransi->kategori_asuransi = $data["kategori-asuransi"];
        $asuransi->nomor_polis = $data["nomor-polis-asuransi"];
        $asuransi->penerbit_polis = $data["penerbit-polis-asuransi"];
        $asuransi->tanggal_penerbitan = $data["tanggal-penerbitan-asuransi"];
        $asuransi->tanggal_berakhir = $data["tanggal-berakhir-asuransi"];
        $asuransi->is_expired = $is_expired;
        // $asuransi->status = $data["status-asuransi"];

        if ($asuransi->save()) {
            Alert::success("Success", "Data Asuransi berhasil ditambahkan");
            return redirect()->back();
        }
            Alert::error("Erorr", "Data Asuransi gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
    }
    
    public function editAsuransi(Request $request, ContractAsuransi $asuransi) {
        $data = $request->all();
        $file = $request->file("file-document");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be string only",
        ];
        $rules = [
            "kategori-asuransi" => "required",
            "id-contract" => "required",
            "nomor-polis-asuransi" => "required",
            "penerbit-polis-asuransi" => "required",
            "tanggal-penerbitan-asuransi" => "required",
            "tanggal-berakhir-asuransi" => "required",
            // "status-asuransi" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Data Asuransi gagal Edit");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        if(isset($data['file-document'])){
            $asuransi_get = $contract->Asuransi->where('kategori_asuransi', '=', $data["kategori-asuransi"])->sortByDesc('created_at')->first();
            $id_document_asuransi = $asuransi_get->id_document;
            // dd($id_document_asuransi);

            if(!empty($id_document_asuransi)){
                $document = ContractUploadFinal::where('id_document', '=', $id_document_asuransi)->first();
                // dd($document);
                $old_file = $document->id_document;
                File::delete(public_path("words/$old_file"));
                $document->id_document = $id_document;
                $document->nama_document = $nama_file;
                $asuransi->id_document = $id_document;
                $asuransi->nama_document = $nama_file;
                    if($document->save()){
                        moveFileTemp($file, explode(".", $id_document)[0]);
                    }else{
                        Alert::error("Erorr", "Dokumen gagal ditambahkan");
                        return Redirect::back();
                    }

            }else{
                $uploadFinal = new ContractUploadFinal();
                $uploadFinal->id_contract = $contract->id_contract;
                $uploadFinal->id_document = $id_document;
                $uploadFinal->nama_document = $nama_file;
                $uploadFinal->category = $data["kategori"];
                $asuransi->id_document = $id_document;
                $asuransi->nama_document = $nama_file;
                // dd($uploadFinal);
                if($uploadFinal->save()){
                    moveFileTemp($file, explode(".", $id_document)[0]);
                }else{
                    Alert::error("Erorr", "Dokumen gagal ditambahkan");
                    return Redirect::back();
                }
            }

        }


        
        $asuransiExpired = new DateTime($data["tanggal-berakhir-asuransi"]);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($asuransiExpired);
        $is_expired = $interval->invert == 1 ? true : false;
        
        // $editAsuransi = ContractAsuransi::where("nomor_polis", "=", $data["nomor-polis-asuransi"])->first();
        
        $asuransi->id_contract = $data["id-contract"];
        $asuransi->kategori_asuransi = $data["kategori-asuransi"];
        $asuransi->nomor_polis = $data["nomor-polis-asuransi"];
        $asuransi->penerbit_polis = $data["penerbit-polis-asuransi"];
        $asuransi->tanggal_penerbitan = $data["tanggal-penerbitan-asuransi"];
        $asuransi->tanggal_berakhir = $data["tanggal-berakhir-asuransi"];
        $asuransi->is_expired = $is_expired;
        // dd($asuransi);
        // $asuransi->status = $data["status-asuransi"];

        if ($asuransi->save()) {
            Alert::success("Success", "Data Asuransi berhasil diubah");
            return redirect()->back();
        }
        Alert::error("Erorr", "Data Asuransi gagal diubah");
        return Redirect::back()->with("modal", $data["modal-name"]);
        
    }

    public function uploadJaminan(Request $request, ContractJaminan $jaminan) {
        $data = $request->all();
        $file = $request->file("file-document");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be string only",
        ];
        $rules = [
            "kategori-jaminan" => "required",
            "id-contract" => "required",
            "nomor-jaminan" => "required",
            "penerbit-jaminan" => "required",
            "tanggal-penerbitan-jaminan" => "required",
            "tanggal-berakhir-jaminan" => "required",
            // "status-jaminan" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Data Jaminan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        if(isset($data['file-document'])){
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $contract->id_contract;
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = $data["kategori"];
            $jaminan->id_document = $id_document;
            $jaminan->nama_document = $nama_file;
            $uploadFinal->save();
            if (!$uploadFinal->save() || !moveFileTemp($file, explode(".", $id_document)[0])) {
                Alert::error("Erorr", "Dokumen gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
            }
        }

        $jaminanExpired = new DateTime($data["tanggal-berakhir-jaminan"]);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($jaminanExpired);
        $is_expired = $interval->invert == 1 ? true : false;

        $jaminan->id_contract = $data["id-contract"];
        $jaminan->kategori_jaminan = $data["kategori-jaminan"];
        $jaminan->nomor_jaminan = $data["nomor-jaminan"];
        $jaminan->penerbit_jaminan = $data["penerbit-jaminan"];
        $jaminan->tanggal_penerbitan = $data["tanggal-penerbitan-jaminan"];
        $jaminan->tanggal_berakhir = $data["tanggal-berakhir-jaminan"];
        $jaminan->is_expired = $is_expired;

        if ($jaminan->save()) {
            Alert::success("Success", "Data Jaminan berhasil ditambahkan");
            return redirect()->back();
        }
            Alert::error("Erorr", "Data Jaminan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
    }

    public function editJaminan(Request $request, ContractJaminan $jaminan) {
        $data = $request->all();
        $file = $request->file("file-document");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "This field must be string only",
        ];
        $rules = [
            "kategori-jaminan" => "required",
            "id-contract" => "required",
            "nomor-jaminan" => "required",
            "penerbit-jaminan" => "required",
            "tanggal-penerbitan-jaminan" => "required",
            "tanggal-berakhir-jaminan" => "required",
            // "status-jaminan" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Data Jaminan gagal diedit");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }
        // dd();

        if(isset($data['file-document'])){
            $jaminan_get = $contract->Jaminan->where('kategori_jaminan', '=', $data["kategori-jaminan"])->sortByDesc('created_at')->first();
            $id_document_jaminan = $jaminan_get->id_document;
            // dd($id_document_jaminan);

            if(!empty($id_document_jaminan)){
                $document = ContractUploadFinal::where('id_document', '=', $id_document_jaminan)->first();
                // dd($document);
                $old_file = $document->id_document;
                File::delete(public_path("words/$old_file"));
                $document->id_document = $id_document;
                $document->nama_document = $nama_file;
                $jaminan->id_document = $id_document;
                $jaminan->nama_document = $nama_file;
                    if($document->save()){
                        moveFileTemp($file, explode(".", $id_document)[0]);
                    }else{
                        Alert::error("Erorr", "Dokumen gagal ditambahkan");
                        return Redirect::back();
                    }

            }else{
                $uploadFinal = new ContractUploadFinal();
                $uploadFinal->id_contract = $contract->id_contract;
                $uploadFinal->id_document = $id_document;
                $uploadFinal->nama_document = $nama_file;
                $uploadFinal->category = $data["kategori"];
                $jaminan->id_document = $id_document;
                $jaminan->nama_document = $nama_file;
                // dd($uploadFinal);
                if($uploadFinal->save()){
                    moveFileTemp($file, explode(".", $id_document)[0]);
                }else{
                    Alert::error("Erorr", "Dokumen gagal ditambahkan");
                    return Redirect::back();
                }
            }

        }

        $jaminanExpired = new DateTime($data["tanggal-berakhir-jaminan"]);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($jaminanExpired);
        $is_expired = $interval->invert == 1 ? true : false;

        $jaminan->id_contract = $data["id-contract"];
        $jaminan->kategori_jaminan = $data["kategori-jaminan"];
        $jaminan->nomor_jaminan = $data["nomor-jaminan"];
        $jaminan->penerbit_jaminan = $data["penerbit-jaminan"];
        $jaminan->tanggal_penerbitan = $data["tanggal-penerbitan-jaminan"];
        $jaminan->tanggal_berakhir = $data["tanggal-berakhir-jaminan"];
        $jaminan->is_expired = $is_expired;

        if ($jaminan->save()) {
            Alert::success("Success", "Data Jaminan berhasil ditambahkan");
            return redirect()->back();
        }
            Alert::error("Erorr", "Data Jaminan gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
    }

    public function uploadDokumenFinal(Request $request)
    {
        $data = $request->all();
        $file = $request->file("file-document");

        if (is_array($file)) {
            $collectFile = [];
            foreach ($file as $f) {
                $collectNameFile = [];
                $collectNameFile["id_document"] = date("His_") . str_replace(' ', '-', $f->getClientOriginalName());
                $collectNameFile["nama_file"] = $f->getClientOriginalName();
                array_push($collectFile, $collectNameFile);
            }
        } else {
            $nama_file = $file->getClientOriginalName();
            $id_document = date("His_") . str_replace(' ', '-', $file->getClientOriginalName());
        }

        $filterAddRecord = [
            "Dokumen Kontrak",
            "Dokumen Amandemen",
            "Dokumen Bill Of Quantity",
            "Dokumen Kontrak - Pemeliharaan",
            "Dokumen Amandemen - Pemeliharaan",
            "Dokumen Rencana Kerja Manajemen Kontrak (BAB 12)",
            "Dokumen Kick Off Meeting",
            "Dokumen Minutes of Meeting (MoM)",
            "Dokumen Lesson Learned",
            "Dokumen Monitoring Status",
            "Dokumen Aanwitjzing",
            "Tinjauan Dokumen Kontrak - Perolehan",
            "Tinjauan Dokumen Kontrak - Pelaksanaan",
            "Usulan Perubahan Draft Kontrak",
            "Dokumen NDA",
            "Dokumen MOU",
            "Dokumen ECA",
            "Dokumen ICA",
            "Dokumen ITB/TOR",
            "Dokumen RKS / Project Spesification",
            "Dokumen Draft Kontrak",
            "Dokumen LOI",
        ];

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "id-contract" => "required",
            "file-document" => "required",
        ];
        if (isset($data['status_dokumen'])) {
            $addRules = ['status_dokumen' => "required|string"];
            array_push($rules, $addRules);
        }
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $kategori = ContractUploadFinal::where([['id_contract', '=', $data['id-contract']],['category', '=', $data['kategori']]])->first();
        // dd($kategori);

        if (in_array($data["kategori"], $filterAddRecord)) {
            // if(!empty($data["kategori"]) && $data["kategori"] == "resiko-pelaksanaan") {
            //     $periode = $data["periode-resiko"] . "-" . $data["tahun-resiko"];
            //     $kategori->periode = $periode;
            // }
            // dd("insert empty");
            if (is_array($file)) {
                foreach ($file as $i => $f) {
                    $uploadFinal = new ContractUploadFinal();
                    $uploadFinal->id_contract = $contract->id_contract;
                    $uploadFinal->id_document = $collectFile[$i]["id_document"];
                    $uploadFinal->nama_document = $collectFile[$i]["nama_file"];
                    $uploadFinal->category = $data["kategori"];
                    if (isset($data['stage'])) {
                        $uploadFinal->stage = $data['stage'];
                    }
                    if (isset($data['status'])) {
                        $uploadFinal->status = $data['status'];
                    }
                    if (isset($data['status_dokumen'])) {
                        $uploadFinal->status_dokumen = $data['status_dokumen'];
                    }


                    if (!$uploadFinal->save()) {
                        Alert::error("Error", "Dokumen " . $collectFile[$i]["nama_file"] . " ditambahkan");
                        return redirect()->back();
                    }
                    
                    $f->move(public_path('words'), $collectFile[$i]["id_document"]);
                }
                Alert::success("Success", "Dokumen berhasil ditambahkan");
                return redirect()->back();
            } else {
                $uploadFinal = new ContractUploadFinal();
                $uploadFinal->id_contract = $contract->id_contract;
                $uploadFinal->id_document = $id_document;
                $uploadFinal->nama_document = $nama_file;
                $uploadFinal->category = $data["kategori"];
                if (isset($data['stage'])) {
                    $uploadFinal->stage = $data['stage'];
                }
                if (isset($data['status'])) {
                    $uploadFinal->status = $data['status'];
                }
                if (isset($data['status_dokumen'])) {
                    $uploadFinal->status_dokumen = $data['status_dokumen'];
                }
                if ($uploadFinal->save()) {
                    // moveFileTemp($file, explode(".", $id_document)[0]);
                    $file->move(public_path('words'), $id_document);
                    Alert::success("Success", "Dokumen berhasil ditambahkan");
                    return redirect()->back();
                }
                Alert::error("Erorr", "Dokumen gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
            }
        }else if(!empty($kategori)){
            // dd("update not empty");
            $old_file = $kategori->id_document;
            File::delete(public_path("words/$old_file"));
            $kategori->id_document = $id_document;
            $kategori->nama_document = $nama_file;
            $kategori->save();
            moveFileTemp($file, explode(".", $id_document)[0]);
            Alert::success("Success", "Dokumen berhasil ditambahkan");
            return redirect()->back();
        } else{
            // dd("insert empty 2");
            // if(!empty($data["kategori"]) && $data["kategori"] == "resiko-pelaksanaan") {
            //     $periode = $data["periode-resiko"] . "-" . $data["tahun-resiko"];
            //     $uploadFinal->periode = $periode;
            // }
            $uploadFinal = new ContractUploadFinal();
            $uploadFinal->id_contract = $contract->id_contract;
            $uploadFinal->id_document = $id_document;
            $uploadFinal->nama_document = $nama_file;
            $uploadFinal->category = $data["kategori"];
            if (isset($data['stage'])) {
                $uploadFinal->stage = $data['stage'];
            }
            if (isset($data['status'])) {
                $uploadFinal->status = $data['status'];
            }
            if (isset($data['status_dokumen'])) {
                $uploadFinal->status_dokumen = $data['status_dokumen'];
            }
 
            if ($uploadFinal->save()) {
                moveFileTemp($file, explode(".", $id_document)[0]);
                Alert::success("Success", "Dokumen berhasil ditambahkan");
                return redirect()->back();
            }
                Alert::error("Erorr", "Dokumen gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
                // return redirect()->back();
        }

    }

    public function editDokumenFinal(Request $request, $id)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field di atas wajib diisi",
            "file" => "This field must be file only",
        ];
        $rules = [
            "id-contract" => "required",
            "file-document" => "file",
        ];
        if (isset($data['status_dokumen'])) {
            $addRules = ['status_dokumen' => "required|string"];
            array_push($rules, $addRules);
        }
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Dokumen gagal ditambahkan");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // dd($validation->errors());
        }
        $validation->validate();

        $contract = ContractManagements::find($data["id-contract"]);
        if (empty($contract)) {
            Alert::error("Error", "Pastikan contract sudah dibuat terlebih dahulu");
            return Redirect::back()->with("modal", $data["modal-name"]);
            // return redirect()->back();
        }

        $kategori = ContractUploadFinal::where([['id_contract', '=', $data['id-contract']], ['id', '=', $id]])->first();
        if (!empty($data["status_dokumen"])) {
            $kategori->status_dokumen = $data["status_dokumen"];
        }
        if (!empty($data["file-document"])) {
            $file = $request->file("file-document");
            $id_document = date("His_") . str_replace(' ', '-', $file->getClientOriginalName());
            $nama_file = $file->getClientOriginalName();
            $old_file = $kategori->id_document;
            File::delete(public_path("words/$old_file"));
            $kategori->id_document = $id_document;
            $kategori->nama_document = $nama_file;
        }
        if (isset($data['status'])) {
            $kategori->status = $data['status'];
        }

        if ($kategori->save()) {
            if (!empty($data["file-document"])) {
                moveFileTemp($file, explode(".", $id_document)[0]);
            }
            Alert::success("Success", "Dokumen berhasil diubah");
            return redirect()->back();
        }
        Alert::error("Error", "Dokumen gagal diubah");
        return redirect()->back();
    }

    public function deleteDokumenFinal(Request $request, $id)
    {
        $data = $request->all();
        $kategori = ContractUploadFinal::where([['id_contract', '=', $data['id-contract']], ['id', '=', $id]])->first();
        // dd($kategori);
        $old_file = $kategori->id_document;
        File::delete(public_path("words/$old_file"));
        if ($kategori->delete()) {
            return (object)[
                'success' => true,
                'message' => "Dokumen berhasil dihapus",
            ];
            return (object)[
                'success' => false,
                'message' => "Dokumen gagal dihapus",
            ];
        }
    }

    public function uploadPasalKontraktual(Request $request) {
        $data = $request->all();
        // dd($data);
        $kontraktual = new PasalKontraktual();
        $kontraktual->id_contract = $data["id-contract"];
        $kontraktual->item = $data["item"];
        $kontraktual->pasal = $data["pasal"];
        // $kontraktual->perpanjangan_waktu = $data["perpanjangan-waktu"];
        // $kontraktual->tambahan_biaya = str_replace(".", "", $data["tambahan-biaya"]);
        $kontraktual->is_perpanjangan_waktu = $data["is_perpanjangan_waktu"] == "true" ? true : false;
        $kontraktual->is_tambahan_biaya = $data["is_tambahan_biaya"] == "true" ? true : false;
        if ($kontraktual->save()) {
            Alert::success("Success", "Pasal Kontraktual berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Pasal Kontraktual gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
    }

    // public function uploadPerubahanKontrak(Request $request) {
    //     $data = $request->all();
    //     if(isset($data["id-perubahan-kontrak"])) {
    //         $perubahan_kontrak = PerubahanKontrak::find($data["id-perubahan-kontrak"]);
    //         $perubahan_kontrak->id_contract = $data["id-contract"];
    //         $perubahan_kontrak->jenis_perubahan = $data["jenis-perubahan"];
    //         $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
    //         $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
    //         // $perubahan_kontrak->jenis_dokumen = $data["jenis-dokumen"];
    //         // $perubahan_kontrak->instruksi_owner = $data["instruksi-owner"];
    //         $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
    //         $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
    //         $perubahan_kontrak->biaya_pengajuan = str_replace(".", "", $data["biaya-pengajuan"]);
    //         $perubahan_kontrak->waktu_pengajuan = $data["waktu-pengajuan"];
    //         $perubahan_kontrak->stage = 1;
    //         if ($perubahan_kontrak->save()) {
    //             Alert::success("Success", "Perubahan Kontrak berhasil diperbarui");
    //             return redirect()->back();
    //         }
    //         Alert::error("Erorr", "Perubahan Kontrak gagal diperbarui");
    //         return Redirect::back();
    //     } else {
    //         $perubahan_kontrak = new PerubahanKontrak();
    //         $perubahan_kontrak->id_contract = $data["id-contract"];
    //         $perubahan_kontrak->jenis_perubahan = $data["jenis-perubahan"];
    //         $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
    //         $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
    //         // $perubahan_kontrak->jenis_dokumen = $data["jenis-dokumen"];
    //         // $perubahan_kontrak->instruksi_owner = $data["instruksi-owner"];
    //         $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
    //         $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
    //         $perubahan_kontrak->biaya_pengajuan = str_replace(".", "", $data["biaya-pengajuan"]);
    //         $perubahan_kontrak->waktu_pengajuan = $data["waktu-pengajuan"];
    //         $perubahan_kontrak->stage = 1;
    //         if ($perubahan_kontrak->save()) {
    //             Alert::success("Success", "Perubahan Kontrak berhasil ditambahkan");
    //             return redirect()->back();
    //         }
    //         Alert::error("Erorr", "Perubahan Kontrak gagal ditambahkan");
    //         return Redirect::back()->with("modal", $data["modal-name"]);
    //     }
    // }

    public function perubahanKontrakViewOld(Request $request, $id_contract, $id_perubahan_kontrak)
    {

        $data = $request->all();
        $filterBulan = isset($data['periode']) ? $data['periode'] : date('m');
        $filterTahun = isset($data['tahun']) ? $data['tahun'] : date('Y');

        if (isset($data['periode']) && isset($data['tahun'])) {
            $perubahan_kontrak = ContractApproval::find($id_perubahan_kontrak);
        } else {
            $perubahan_kontrak = PerubahanKontrak::find($id_perubahan_kontrak);
        }

        $contract = ContractManagements::find(url_decode($id_contract));

        // dd($data, $perubahan_kontrak);
        return view("perubahanKontrak/view", compact(["contract", "perubahan_kontrak"]));
    }

    public function perubahanKontrakView(Request $request, $profit_center, $id_perubahan_kontrak)
    {

        $data = $request->all();
        $filterBulan = isset($data['periode']) ? $data['periode'] : date('m');
        $filterTahun = isset($data['tahun']) ? $data['tahun'] : date('Y');

        if (isset($data['periode']) && isset($data['tahun'])) {
            $perubahan_kontrak = ContractApproval::find($id_perubahan_kontrak);
        } else {
            $perubahan_kontrak = PerubahanKontrak::find($id_perubahan_kontrak);
        }

        // $contract = ContractManagements::find(url_decode($id_contract));
        $contract = ContractManagements::where('profit_center', $profit_center)->first();

        // dd($data, $perubahan_kontrak);
        return view("perubahanKontrak/view", compact(["contract", "perubahan_kontrak"]));
    }

    public function getChecklistManajemenKontrak(ContractManagements $id_contract, ContractChecklist $id) {
        // dd($id_contract, $id);
        // dd($id);
        $html = '';
        if($id->kategori == 'Progress 0-20%') {
            $html = "
            <div id='progress_0-20'>
                <div id='slide-2' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label'>
                        <span style='font-weight: normal'>Kategori</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->kategori</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah SPK telah diterima?</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <!--end::Input-->
                    <h6>$id->jawaban_1," . ($id->jawaban_1 == "Ya" ? Carbon::parse($id->sub_jawaban_2)->translatedFormat('d F Y') : $id->sub_jawaban_1) . "</h6>
                    <br>
                    <!--end::Input-->
                </div>
                
                <div id='slide-3' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah sudah ada berita Acara serah terima lapangan?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_2, " . ($id->jawaban_2 == "Ya" ? Carbon::parse($id->sub_jawaban_2)->translatedFormat('d F Y') : $id->sub_jawaban_2) . "</h6>
                    <br>
                </div>
                
                <div id='slide-4' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jadwal Pelaksanaan telah disetujui oleh Engineer?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_3</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah jadwal diatas mengutamakan ketergantungan kegiatan WIKA kepada Pemberi Kerja dan Mitranya?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_4</h6>
                    <br>
                </div>

                <div id='slide-5' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Siapa yang membuat Construction Schedule?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_5</h6>
                    <br>
                </div>

                <div id='slide-6' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek memiliki Buku Harian tentang?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_6" . ($id->jawaban_6 == "Lainnya" ? ", $id->sub_jawaban_6" : "") . "</h6>
                    <br>
                </div>

                <div id='slide-6' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Penanggung Jawab Pelaksanaan Penghitungan / Pengukuran Nilai Pekerjaan Terlaksana?</span>
                    </label>
                    <!--end::Label-->
                    <h6> - </h6>
                    <br>
                </div>

                <div id='slide-7' class='data'>
                    <h6 class='fw-normal'>Siapa?</h6>
                    <h6>$id->jawaban_7</h6><br>
                    <h5 class='fw-normal'>Kapan</h5>
                    <h6>$id->jawaban_8, ". Carbon::parse($id->sub_jawaban_8)->translatedFormat('d F Y') . "</h6><br>
                    <h5 class='fw-normal'>Bagaimana cara melaksanakannya ?</h5>
                    <h6>$id->jawaban_9, ". ($id->jawaban_9 == "Cara Lain" ? $id->sub_jawaban_9 : "") ."</h6>
                    <br>
                </div>

                <div id='slide-8' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek memiliki Identifikasi Gambar ?</span>
                    </label>
                    <h6>$id->jawaban_10</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek memiliki Pengarsipan Surat-menyurat ?</span>
                    </label>
                    <h6>$id->jawaban_11</h6>
                    <br>
                </div>

                <div id='slide-9' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek memiliki Sistem Pendistribusian Dokumen ?</span>
                    </label>
                    <h6>$id->jawaban_12</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek memiliki ketetapan tertulis tentang <b>Bench Mark</b> ?</span>
                    </label>
                    <h6>$id->jawaban_13</h6>
                    <br>
                </div>

                <div id='slide-10' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jaminan Penawaran telah ditarik Kembali ?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_14</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jaminan Pelaksanaan telah Diterbitkan ?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_15</h6>
                    <br>
                </div>

                <div id='slide-11' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jaminan Uang Muka telah Diterbitkan ?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_16</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Program Asuransi telah disetujui oleh Pemberi Tugas (Employer) ?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_17</h6>
                    <br>
                </div>
                
                <div id='slide-12' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Material Damage</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_18</h6>
                    
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Third Party Liability</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_19</h6>
                    
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Polis tersebut dibuat atas nama</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_20</h6>
                    <br>
                </div>

                <div id='slide-13' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Perubahan-perubahan yang terjadi telah dilaporkan kepada Asuransi (antisipasi atas perpanjangan waktu dan/atau No Risk Period) ?</span>
                    </label>
                    <h6>$id->jawaban_21</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah upaya penghindaran kecelakaan sudah dilaksanakan ?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_22</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah kerugian yang terjadi akibat kejadian yang diasuransikan telah dilaporkan kepada Perusahaan Asuransi? ?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_23</h6>
                    <br>
                </div>
            </div>";
        } else if($id->kategori == 'Progress 20%-90%') {
            $html = "
            <div id='progress_20-90'>
                <div id='slide-2' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label'>
                        <span style='font-weight: normal'>Kategori</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->kategori</h6>
                    <br>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek mengalami keterlambatan?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_1, $id->sub_jawaban_1%</h6>
                    <!--end::Input-->
                </div><br>

                <div id='slide-3' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek mengadakan Rapat rutin?</span>
                    </label>
                    <h6>$id->jawaban_2, $id->sub_jawaban_2</h6>
                    <!--end::Label-->
                </div><br>

                <div id='slide-4' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah ada kejadian yang dapat menyebabkan perubahan jadwal?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_3</h6>

                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah ada kejadian yang dapat menyebabkan Perubahan Pekerjaan / Change Order / Variation Order?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_4</h6>
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah ada kejadian yang dapat menyebabkan Penghentian Pekerjaan (Suspension)?</span>
                    </label>
                    <h6>$id->jawaban_5</h6>
                    <!--end::Label-->
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah ada kemungkinan kegiatan/kejadian yang mungkin menyebabkan Percepatan / Acceleration Pekerjaan?</span>
                    </label>
                    <h6>$id->jawaban_6</h6>
                    <!--end::Label-->
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Perintah/Instruksi resmi Lapangan mengenai perubahan telah terbit?</span>
                    </label>
                    <h6>$id->jawaban_7</h6>
                    <!--end::Label-->
                    
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah perubahan yang terjadi telah dimintakan konfirmasi dari Engineer / Pengawas Ahli?</span>
                    </label>
                    <h6>$id->jawaban_8</h6>
                    <!--end::Label-->
                    
                    <br>

                </div>

                <div id='slide-5' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Tahapan yang telah dicapai dalam pengajuan Kompensasi atas perubahan - perubahan yang terjadi :</span>
                    </label>
                    <h6>$id->jawaban_9</h6>
                    <!--end::Label-->
                    <br>
                </div>

                <div id='slide-6' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Klausul Kontrak yang mengatur tentang perubahan (waktu/biaya/mutu)</span>
                    </label>
                    <h6>$id->jawaban_10, " . ($id->jawaban_10 == "Addenda" ? $id->sub_jawaban_10 : "") ." </h6>
                    <!--end::Label-->
                    <br>
                </div>

                <div id='slide-7' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Proyek akan membutuhkan Perpanjangan Waktu?</span>
                    </label>
                    <h6>$id->jawaban_11</h6>
                    <!--end::Label-->
                    <br>

                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah keinginan ini telah disampaikan kepada Engineer secara formal?</span>
                    </label>
                    <h6>$id->jawaban_12</h6>
                    <!--end::Label-->
                    <br>
                </div>

                <div id='slide-8' class='data'>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apa yang menjadi dasar kebutuhan akan Perpanjangan Waktu?</span>
                    </label>
                    <h6>$id->jawaban_13, " . ($id->jawaban_13 == "Lain-lain" ? $id->sub_jawaban_13 : "") . " </h6>
                </div>
            </div>
            ";
        } else if($id->kategori == 'Progress 90%-100%') {
            $html = "
            <div id='progress_90-100'>
                <div id='slide-2' class='data'>
                    <label class='fs-6 fw-bold form-label'>
                        <span style='font-weight: normal'>Kategori</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->kategori</h6>
                    <br>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah besarnya Jaminan Uang Muka telah disesuaikan dengan jumlah Uang Muka yang masih terhutang?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_1</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jaminan Uang Muka telah ditarik kembali?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_2</h6>
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah permohonan untuk melaksanakan Serah Terima Pertama telah diajukan kepada Engineer?</span>
                    </label>
                    <!--end::Label-->
                    <h6>$id->jawaban_3</h6>
                    <br>
                </div>
                <div id='slide-3' class='data'>
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Tahapan yang telah dicapai dalam program Serah Terima Pertama :</span>
                    </label>
                    <h6>$id->jawaban_4</h6>
                    <br>
                    <!--end::Label-->
                    <br>
                </div>
                <div id='slide-4' class='data'>
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jaminan Pelaksanaan telah ditarik kembali?</span>
                    </label>
                    <h6>$id->jawaban_5</h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah Jaminan Pemeliharaan telah diganti dengan Bank Garansi?</span>
                    </label>
                    <h6>$id->jawaban_6</h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Bank Garansi seluruhnya akan ditarik kembali pada tanggal</span>
                    </label>
                    <h6>". Carbon::create($id->sub_jawaban_7)->translatedFormat("d F Y") ."</h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Masa Pemeliharaan akan berakhir pada tanggal</span>
                    </label>
                    <h6>". Carbon::create($id->sub_jawaban_8)->translatedFormat("d F Y") ."</h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Permohonan Serah Terima Akhir akan diajukan pada tanggal</span>
                    </label>
                    <h6>". Carbon::create($id->sub_jawaban_9)->translatedFormat("d F Y") ."</h6>
                    <!--end::Label-->
                    <br>
                </div>
                <div id='slide-5' class='data'>
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Nilai Kontrak Akhir :</span>
                    </label>
                    <h6>$id->jawaban_10</h6>
                    <!--end::Label-->
                    <br>
                </div>
                <div id='slide-6' class='data'>
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Pembayaran Akhir (Final Payment) akan dilaksanakan pada tanggal</span>
                    </label>
                    <h6>". Carbon::create($id->sub_jawaban_11)->translatedFormat("d F Y") ." </h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Termin yang sudah diterima</span>
                    </label>
                    <h6>Rp. " . number_format((int) $id->jawaban_12, 0, ".", ".") . "</h6>
                    <br>
                    <!--end::Label-->
                </div>
                <div id='slide-7' class='data'>
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah ada kejadian yang dapat menyebabkan perubahan pekerjaan (Change Order) / Variation Order?</span>
                    </label>
                    <h6>$id->jawaban_13</h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah perintah/Instruksi resmi lapangan mengenai perubahan telah diterbitkan?</span>
                    </label>
                    <h6>$id->jawaban_14</h6>
                    <!--end::Label-->
                    <br>
                    <!--begin::Label-->
                    <label class='fs-6 fw-bold form-label mt-3'>
                        <span style='font-weight: normal'>Apakah perubahan yang telah terjadi telah dikonfirmasikan kepada konsultan/pengawas?</span>
                    </label>
                    <h6>$id->jawaban_15</h6><br>
                    <!--end::Label-->
                    <br>
                </div>
            </div>
            ";
        }

        return response($html);
    }

    static function input_name_to_label(SupportCollection $keys) : string {
        return $keys->map(function($val) {
            if(str_contains($val, "_")) {
                $exploded_val = collect(explode("_", $val));
                return $exploded_val->map(function($exval) {
                    $exval[0] = strtoupper($exval[0]);
                    strtoupper($exval[0]);
                    return $exval;
                })->join(" ");

            }
            $val[0] = strtoupper($val[0]);
            return $val;
        })->join(", ", " dan ");
    }

    public function reviewKontrakView($id_contract, $stage){
        // dd($stage);
        // dd($id_contract);
        // if (Session::has("pasals")) {
        //     Session::forget("pasals");
        // }
        
        // $projects = Proyek::all();
        $review_contracts = ReviewContracts::where("id_contract", "=", $id_contract)->orderBy('index')->get();
        $review = $review_contracts->where("stage", "=", $stage);
        if($stage == 1){
            // $review =  $review_contracts->where("stage", "=", 1)->where("uraian", "!=", null);
            $review =  $review_contracts->where("stage", "=", 1);
        }else{
            $review = $review_contracts->where("stage", "=", 2);
        };
        
        // dd($review);
        // $ccmNew = $ccm->reviewProjects->groupBy('stage');
        // $ccmNew = $ccm->reviewProjects->where('stage', "=", $stage);
        // dd($review_contracts);
        // dd($ccmNew);
        
        return view("Contract/viewReview", ["contract" => ContractManagements::find(urldecode(urldecode($id_contract))), "review" => $review, "stage" => $stage]);
    }

    public function getDataProgressPIS(Request $request){
        $data = $request->all();
        // dd($data);

        $contract = ContractManagements::where("id_contract", "=", $data["id_contract"])->first();
        $kode_spk = $contract->project?->kode_spk;
        // dd($kode_spk);
        // $kode_spk = "MJBG08";
        $current = new DateTime();
        $str_current = $current->format('Ym');
        $is_exist_progress_period = ProyekProgress::where("kode_spk", "=", $kode_spk)->where("periode", "=", $str_current)->first();
        // dd($is_exist_progress_period);
        
        if($kode_spk){

            if ($this->getDataProgressPIS2($contract->project->kode_proyek, $kode_spk, $str_current)) {
                $response = Http::post('http://pis.wika.co.id/wpapi/files/getAPIQISList', [
                    "kdspk" => $kode_spk,
                    "period" => "$str_current"
                ]);

                // dd($response->collect($key = "data")->first());

                if ($response->successful()) {
                    $data_response = $response->collect($key = "data")->first();
                    $calculate_progress = (int)$data_response['ok_review'] && (int)$data_response['progress_fisik_ri'] ? round(((int)$data_response['ok_review'] / (int)$data_response['progress_fisik_ri']), 2) : 0;

                    if ($is_exist_progress_period) {
                        $data = $is_exist_progress_period;
                        $data->kode_proyek = $contract->project->kode_proyek;
                        $data->kode_spk = $kode_spk;
                        $data->ok_review = (int)$data_response["ok_review"];
                        $data->progress_fisik_ri = (int)$data_response["progress_fisik_ri"];
                        $data->lama_proyek = $data_response["lamaproyek"];
                        $data->laba_kotor_ri = (int)$data_response["laba_kotor_ri"];
                        $data->progress_fisik_ra = (int) $data_response["progress_fisik_ra"];
                        $data->pu_berelasi = (int) $data_response["pu_berelasi"];
                        $data->pu_ketiga = (int) $data_response["pu_ketiga"];
                        $data->ra_bl = (int) $data_response["ra_bl"];
                        $data->ri_bl = (int) $data_response["ri_bl"];
                        $data->ra_btl = (int) $data_response["ra_btl"];
                        $data->ri_btl = (int) $data_response["ri_btl"];
                        $data->ri_pdpk = (int) $data_response["ri_pdpk"];
                        $data->bdd = (int) $data_response["bdd"];
                        $data->persekot = (int) $data_response["persekot"];
                        $data->laba_kotor_ra = (int) $data_response["laba_kotor_ra"];
                        $data->piutang = (int) $data_response["piutang"];
                        $data->tagbrut = (int) $data_response["tagbrut"];
                        $data->periode = $str_current;
                    } else {
                        $data = new ProyekProgress();
                        $data->kode_proyek = $contract->project->kode_proyek;
                        $data->kode_spk = $kode_spk;
                        $data->ok_review = (int)$data_response["ok_review"];
                        $data->progress_fisik_ri = (int)$data_response["progress_fisik_ri"];
                        $data->lama_proyek = $data_response["lamaproyek"];
                        $data->laba_kotor_ri = (int)$data_response["laba_kotor_ri"];
                        $data->progress_fisik_ra = (int) $data_response["progress_fisik_ra"];
                        $data->pu_berelasi = (int) $data_response["pu_berelasi"];
                        $data->pu_ketiga = (int) $data_response["pu_ketiga"];
                        $data->ra_bl = (int) $data_response["ra_bl"];
                        $data->ri_bl = (int) $data_response["ri_bl"];
                        $data->ra_btl = (int) $data_response["ra_btl"];
                        $data->ri_btl = (int) $data_response["ri_btl"];
                        $data->ri_pdpk = (int) $data_response["ri_pdpk"];
                        $data->bdd = (int) $data_response["bdd"];
                        $data->persekot = (int) $data_response["persekot"];
                        $data->laba_kotor_ra = (int) $data_response["laba_kotor_ra"];
                        $data->piutang = (int) $data_response["piutang"];
                        $data->tagbrut = (int) $data_response["tagbrut"];
                        $data->periode = $str_current;
                    }
                    if ($data->save()) {
                        $status = [
                            'kode_proyek' => $contract->project->kode_proyek,
                            'periode' => $str_current,
                            'status' => 'SUCCESS',
                            'progress' => $calculate_progress,
                            'dataPIS' => $data_response
                        ];
                        // Alert::success
                        setLogging("Get_Progress_PIS", "[Progress=>" . $contract->project->kode_proyek . '=>' . $calculate_progress . ']', $status);
                        toast("Data berhasil disimpan", "success")->autoClose(3000);
                        return response()->json([
                            "status" => "success",
                            "link" => true
                        ], 200);
                        // dd("success");
                    }
    
                    $status = [
                        'kode_proyek' => $contract->project->kode_proyek,
                        'periode' => $str_current,
                        'status' => 'FAILED',
                        'progress' => $calculate_progress,
                        'dataPIS' => $response
                    ];
                    // Alert::success
                    setLogging("Get_Progress_PIS", "[Progress=>" . $contract->project->kode_proyek . '=>' . $calculate_progress . ']', $status);
                    toast("Data gagal disimpan", "error")->autoClose(3000);
                    return response()->json([
                        "status" => "success",
                        "link" => true
                    ], 500);
                    
                    // dd($data);
                }
            } else {
                toast("Get Progress gagal", "error")->autoClose(3000);
                return response()->json([
                    "status" => "success",
                    "link" => true
                ], 200);
            }

        // return response()->json($response->json(["link" => true]), 200);

        }
        toast("Kode SPK belum ada", "error")->autoClose(3000);
        return response()->json([
            "status" => "success",
            "link" => true
        ], 200);
    }

    function getDataProgressPIS2($kode_proyek, $kode_spk, $period)
    {
        $login = Http::post('https://pis.wika.co.id/wpapi/auth/token', [
            "grant_type" => "client_credentials",
            "client_id" => "app-she",
            "secret_key" => "y7sdyf7sdhfuerwe7ry383rwriwu3894u2"
        ]);

        if ($login->successful()) {
            $login_response = $login->object();
            $token = $login_response->access_token ?? null;

            $is_exist_progress_period = ProyekPIS::where("kode_spk", "=", $kode_spk)->where("period", "=", $period)->first();

            if (!empty($token)) {
                $response = Http::withHeaders(["x-access-token" => $token])
                ->post('https://pis.wika.co.id/wpapi/proyek/getProyekResume', [
                    "no_spk" => $kode_spk,
                    "period" => $period
                ]);

                if ($response->successful()) {
                    $dataResponse = $response->collect($key = "data");
                    // dd($dataResponse);
                    if ($is_exist_progress_period) {
                        $data = $is_exist_progress_period;
                        $data->kode_proyek = $kode_proyek;
                        $data->kode_spk = $kode_spk;
                        $data->spk_intern_no = $dataResponse['spk_intern_no'];
                        $data->proyek_shortname = $dataResponse['proyek_shortname'];
                        $data->proyek_name = $dataResponse['proyek_name'];
                        $data->type_code = $dataResponse['type_code'];
                        $data->period = $dataResponse['period'];
                        $data->start_date = $dataResponse['start_date'];
                        $data->finish_date = $dataResponse['finish_date'];
                        $data->bast1_date = $dataResponse['bast1_date'];
                        $data->bast2_date = $dataResponse['bast2_date'];
                        $data->divisi_name = $dataResponse['divisi_name'];
                        $data->departemen_name = $dataResponse['departemen_name'];
                        $data->departemen_code = $dataResponse['departemen_code'];
                        $data->direktorat_name = $dataResponse['direktorat_name'];
                        $data->pemberi_kerja_code = $dataResponse['pemberi_kerja_code'];
                        $data->pemberi_kerja_name = $dataResponse['pemberi_kerja_name'];
                        $data->sumber_dana = $dataResponse['sumber_dana'];
                        $data->sbu = $dataResponse['sbu'];
                        $data->country = $dataResponse['country'];
                        $data->province = $dataResponse['province'];
                        $data->longitude = $dataResponse['longitude'];
                        $data->latitude = $dataResponse['latitude'];
                        $data->mp_nip = $dataResponse['mp_nip'];
                        $data->mp_name = $dataResponse['mp_name'];
                        $data->mp_phone = $dataResponse['mp_phone'];
                        $data->mp_email = $dataResponse['mp_email'];
                        $data->is_strategis_nas = $dataResponse['is_strategis_nas'];
                        $data->is_strategis_wika = $dataResponse['is_strategis_wika'];
                        $data->status_autorisasi = $dataResponse['status_autorisasi'];
                        $data->is_req_unlock = $dataResponse['is_req_unlock'];
                        $data->ok_awal = $dataResponse['ok_awal'];
                        $data->ok_review = $dataResponse['ok_review'];
                        $data->nilai_ok = $dataResponse['nilai_ok'];
                        $data->ra_penjualan = $dataResponse['ra_penjualan'];
                        $data->ri_penjualan = $dataResponse['ri_penjualan'];
                        $data->ra_progress = $dataResponse['ra_progress'];
                        $data->ri_progress = $dataResponse['ri_progress'];
                        $data->ra_biaya_progress_diakui = $dataResponse['ra_biaya_progress_diakui'];
                        $data->ri_biaya_progress_diakui = $dataResponse['ri_biaya_progress_diakui'];
                        $data->ra_margin = $dataResponse['ra_margin'];
                        $data->ri_margin = $dataResponse['ri_margin'];
                        $data->pi_margin = $dataResponse['pi_margin'];
                        $data->saldo_rkjo = $dataResponse['saldo_rkjo'];
                        $data->piutang_retensi = $dataResponse['piutang_retensi'];
                        $data->piutang_usaha = $dataResponse['piutang_usaha'];
                        $data->tagihan_bruto = $dataResponse['tagihan_bruto'];
                        $data->bad = $dataResponse['bad'];
                        $data->pdpk = $dataResponse['pdpk'];
                        $data->bdd = $dataResponse['bdd'];
                        $data->persediaan = $dataResponse['persediaan'];
                        $data->rk = $dataResponse['rk'];
                    } else {
                        $data = new ProyekPIS();
                        $data->kode_proyek = $kode_proyek;
                        $data->kode_spk = $kode_spk;
                        $data->spk_intern_no = $dataResponse['spk_intern_no'];
                        $data->proyek_shortname = $dataResponse['proyek_shortname'];
                        $data->proyek_name = $dataResponse['proyek_name'];
                        $data->type_code = $dataResponse['type_code'];
                        $data->period = $dataResponse['period'];
                        $data->start_date = $dataResponse['start_date'];
                        $data->finish_date = $dataResponse['finish_date'];
                        $data->bast1_date = $dataResponse['bast1_date'];
                        $data->bast2_date = $dataResponse['bast2_date'];
                        $data->divisi_name = $dataResponse['divisi_name'];
                        $data->departemen_name = $dataResponse['departemen_name'];
                        $data->departemen_code = $dataResponse['departemen_code'];
                        $data->direktorat_name = $dataResponse['direktorat_name'];
                        $data->pemberi_kerja_code = $dataResponse['pemberi_kerja_code'];
                        $data->pemberi_kerja_name = $dataResponse['pemberi_kerja_name'];
                        $data->sumber_dana = $dataResponse['sumber_dana'];
                        $data->sbu = $dataResponse['sbu'];
                        $data->country = $dataResponse['country'];
                        $data->province = $dataResponse['province'];
                        $data->longitude = $dataResponse['longitude'];
                        $data->latitude = $dataResponse['latitude'];
                        $data->mp_nip = $dataResponse['mp_nip'];
                        $data->mp_name = $dataResponse['mp_name'];
                        $data->mp_phone = $dataResponse['mp_phone'];
                        $data->mp_email = $dataResponse['mp_email'];
                        $data->is_strategis_nas = $dataResponse['is_strategis_nas'];
                        $data->is_strategis_wika = $dataResponse['is_strategis_wika'];
                        $data->status_autorisasi = $dataResponse['status_autorisasi'];
                        $data->is_req_unlock = $dataResponse['is_req_unlock'];
                        $data->ok_awal = $dataResponse['ok_awal'];
                        $data->ok_review = $dataResponse['ok_review'];
                        $data->nilai_ok = $dataResponse['nilai_ok'];
                        $data->ra_penjualan = $dataResponse['ra_penjualan'];
                        $data->ri_penjualan = $dataResponse['ri_penjualan'];
                        $data->ra_progress = $dataResponse['ra_progress'];
                        $data->ri_progress = $dataResponse['ri_progress'];
                        $data->ra_biaya_progress_diakui = $dataResponse['ra_biaya_progress_diakui'];
                        $data->ri_biaya_progress_diakui = $dataResponse['ri_biaya_progress_diakui'];
                        $data->ra_margin = $dataResponse['ra_margin'];
                        $data->ri_margin = $dataResponse['ri_margin'];
                        $data->pi_margin = $dataResponse['pi_margin'];
                        $data->saldo_rkjo = $dataResponse['saldo_rkjo'];
                        $data->piutang_retensi = $dataResponse['piutang_retensi'];
                        $data->piutang_usaha = $dataResponse['piutang_usaha'];
                        $data->tagihan_bruto = $dataResponse['tagihan_bruto'];
                        $data->bad = $dataResponse['bad'];
                        $data->pdpk = $dataResponse['pdpk'];
                        $data->bdd = $dataResponse['bdd'];
                        $data->persediaan = $dataResponse['persediaan'];
                        $data->rk = $dataResponse['rk'];
                    }
                    setLogging("Get_Progress_PIS_2", "[Proyek=>" . $kode_proyek . "]", $dataResponse->toArray());
                    return $data->save();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getProgressFromTableProyekPISNew(Request $request)
    {
        $proyeks = ProyekPISNew::where('spk_intern_no', '!=', null)->get();
        if (!empty($proyeks)) {
            $proyeks->each(function ($proyek) {
                $this->getDataProgressPISNew($proyek->spk_intern_no);
            });
            return response()->json([
                "status" => "success",
                "message" => null
            ]);
        }
    }

    function getDataProgressPISNew($nospk)
    {
        // dd($data);

        // $contract = ContractManagements::where("id_contract", "=", $data["id_contract"])->first();
        // $kode_spk = $contract->project?->kode_spk;
        $kode_spk = $nospk;
        $proyek = ProyekPISNew::select('pemberi_kerja_code')->where('spk_intern_no', $kode_spk)->first();
        // dd($kode_spk);
        // $kode_spk = "MJBG08";
        $current = new DateTime();
        $str_current = $current->format('Ym');
        $is_exist_progress_period = ProyekProgress::where("kode_spk", "=", $kode_spk)->where("periode", "=", $str_current)->first();
        // dd($is_exist_progress_period);
        try {
            if ($kode_spk) {

                $response = Http::post('http://pis.wika.co.id/wpapi/files/getAPIQISList', [
                    "kdspk" => $kode_spk,
                    "period" => "$str_current"
                ]);

                // dd($response->collect($key = "data")->first());

                if ($response->successful()) {
                    $data_response = $response->collect($key = "data")->first();
                    $calculate_progress = (int)$data_response['ok_review'] && (int)$data_response['progress_fisik_ri'] ? round(((int)$data_response['ok_review'] / (int)$data_response['progress_fisik_ri']), 2) : 0;

                    // $newCsi = new Csi();
                    // $newCsi->id_customer = $proyek->Customer?->id_customer;
                    // $newCsi->id_struktur_organisasi = null;
                    // $newCsi->no_spk = $kode_spk;
                    // $newCsi->tanggal = $current;
                    // $newCsi->status = "Not Sent";
                    // $newCsi->progress = $calculate_progress;

                    if ($is_exist_progress_period) {
                        $data = $is_exist_progress_period;
                        // $data->kode_proyek = $contract->project->kode_proyek;
                        $data->kode_spk = $kode_spk;
                        $data->ok_review = (int)$data_response["ok_review"];
                        $data->progress_fisik_ri = (int)$data_response["progress_fisik_ri"];
                        $data->lama_proyek = $data_response["lamaproyek"];
                        $data->laba_kotor_ri = (int)$data_response["laba_kotor_ri"];
                        $data->progress_fisik_ra = (int) $data_response["progress_fisik_ra"];
                        $data->pu_berelasi = (int) $data_response["pu_berelasi"];
                        $data->pu_ketiga = (int) $data_response["pu_ketiga"];
                        $data->ra_bl = (int) $data_response["ra_bl"];
                        $data->ri_bl = (int) $data_response["ri_bl"];
                        $data->ra_btl = (int) $data_response["ra_btl"];
                        $data->ri_btl = (int) $data_response["ri_btl"];
                        $data->ri_pdpk = (int) $data_response["ri_pdpk"];
                        $data->bdd = (int) $data_response["bdd"];
                        $data->persekot = (int) $data_response["persekot"];
                        $data->laba_kotor_ra = (int) $data_response["laba_kotor_ra"];
                        $data->piutang = (int) $data_response["piutang"];
                        $data->tagbrut = (int) $data_response["tagbrut"];
                        $data->periode = $str_current;
                    } else {
                        $data = new ProyekProgress();
                        // $data->kode_proyek = $contract->project->kode_proyek;
                        $data->kode_spk = $kode_spk;
                        $data->ok_review = (int)$data_response["ok_review"];
                        $data->progress_fisik_ri = (int)$data_response["progress_fisik_ri"];
                        $data->lama_proyek = $data_response["lamaproyek"];
                        $data->laba_kotor_ri = (int)$data_response["laba_kotor_ri"];
                        $data->progress_fisik_ra = (int) $data_response["progress_fisik_ra"];
                        $data->pu_berelasi = (int) $data_response["pu_berelasi"];
                        $data->pu_ketiga = (int) $data_response["pu_ketiga"];
                        $data->ra_bl = (int) $data_response["ra_bl"];
                        $data->ri_bl = (int) $data_response["ri_bl"];
                        $data->ra_btl = (int) $data_response["ra_btl"];
                        $data->ri_btl = (int) $data_response["ri_btl"];
                        $data->ri_pdpk = (int) $data_response["ri_pdpk"];
                        $data->bdd = (int) $data_response["bdd"];
                        $data->persekot = (int) $data_response["persekot"];
                        $data->laba_kotor_ra = (int) $data_response["laba_kotor_ra"];
                        $data->piutang = (int) $data_response["piutang"];
                        $data->tagbrut = (int) $data_response["tagbrut"];
                        $data->periode = $str_current;
                    }
                    // if ($data->save() && $newCsi->save()) {
                    if ($data->save()) {
                        $status = [
                            'kode_proyek' => $nospk,
                            'periode' => $str_current,
                            'status' => 'SUCCESS',
                            'progress' => $calculate_progress,
                            'dataPIS' => $data_response
                        ];
                        // Alert::success
                        setLogging("Get_Progress_PIS", "[Progress=>" . $nospk . '=>' . $calculate_progress . ']', $status);
                        // toast("Data berhasil disimpan", "success")->autoClose(3000);
                        return response()->json([
                            "status" => "success",
                            // "link" => true
                            "message" => "Success"
                        ], 200);
                        // dd("success");
                    }
                    $status = [
                        'kode_proyek' => $nospk,
                        'periode' => $str_current,
                        'status' => 'FAILED',
                        'progress' => $calculate_progress,
                        'dataPIS' => $response
                    ];
                    // Alert::success
                    setLogging("Get_Progress_PIS", "[Progress=>" . $nospk . '=>' . $calculate_progress . ']', $status);
                    // toast("Data gagal disimpan", "error")->autoClose(3000);
                    return response()->json([
                        "status" => "success",
                        // "link" => true
                        "message" => "Failed"
                    ], 500);

                    // dd($data);
                }

                // return response()->json($response->json(["link" => true]), 200);

            }
        } catch (\Exception $e) {
            // toast("Kode SPK belum ada", "error")->autoClose(3000);
            // return response()->json([
            //     "status" => "failed",
            //     // "link" => true,
            //     "message" => $e->getMessage()
            // ], 200);
            dd($e->getMessage());
        }
    }
}
