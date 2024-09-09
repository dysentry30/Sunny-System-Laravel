<?php

namespace App\Http\Controllers;

use DateTime;
use stdClass;
use Carbon\Carbon;
use Faker\Core\Uuid;
use App\Models\Pasals;
use App\Models\Proyek;
use App\Models\UnitKerja;
use App\Models\FieldChange;
use App\Models\ClaimDetails;
use App\Models\JenisDokumen;
use App\Models\ProyekPISNew;
use Illuminate\Http\Request;
use App\Models\TechnicalForm;
use App\Models\TechnicalQuery;
use App\Models\ReviewContracts;
use App\Models\SiteInstruction;
use App\Models\ClaimManagements;
use App\Models\ContractApproval;
use App\Models\DokumenPendukung;
use App\Models\PerubahanKontrak;
use Illuminate\Support\Facades\DB;
use App\Models\ClaimContractDrafts;
use App\Models\ContractChangeOrder;
use App\Models\ContractManagements;
use Illuminate\Support\Facades\Log;
use App\Models\ContractChangeNotice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\ClaimContractDiajukan;
use App\Models\ClaimContractDisetujui;
use App\Models\ClaimContractNegoisasi;
use App\Models\ContractChangeProposal;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Google\Service\FactCheckTools\Resource\Claims;

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

    public function indexOld(Request $request)
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
        $filterTahun = !empty($request->query("tahun-proyek")) ? (int) $request->query("tahun-proyek") : (int) date("Y");
        $filterBulan = !empty($request->query("bulan-proyek")) ? (int) $request->query("bulan-proyek") : (int) date("m");

        $year = (int) date("Y");
        $month = (int) date("m");

        // $unitkerjas = UnitKerja::get()->whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8"]);
        // dd($unitkerjas);
        $tahun_proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->get()->groupBy("tahun_perolehan")->keys();
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

            // $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            // if (!empty($filterBulan) && $filterTahun == 2023) {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            // } else {
            //     if ($filterTahun < 2023 && !empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } elseif ($filterTahun < 2023 && empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } else {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //         // dd("test");
            //     }
            // }
            if ($filterBulan == (int) date("m") && $filterTahun == (int) date("Y")) {
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->get();
                $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->where('contract_managements.profit_center', '!=', null)->get();

                $proyeks_all = $proyeks_all->map(function ($proyek) {
                    $result = [];
                    $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $proyek->ContractManagements->profit_center;
                    $result['nama_proyek'] = $proyek->nama_proyek;
                    $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->UnitKerja->unit_kerja;

                    if (!empty($proyek->PerubahanKontrak)) {
                        $claim = $proyek->PerubahanKontrak;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        // $item_vo = $cat_vo->count();
                        $item_vo = $cat_vo->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });


                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        // $item_klaim = $cat_klaim->count();
                        $item_klaim = $cat_klaim->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        // $item_anti_klaim = $cat_anti_klaim->count();
                        $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        // $item_klaim_asuransi = $cat_klaim_asuransi->count();
                        $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                    }

                    return $result;
                });
            } else {

                $proyeks_all = ContractApproval::join(
                    "proyeks",
                    "proyeks.kode_proyek",
                    "=",
                    "contract_approval.kode_proyek"
                )->where("periode", '=', $filterBulan)->where(
                    "tahun",
                    "=",
                    $filterTahun
                )->get()->groupBy('kode_proyek');


                $proyeks_all = $proyeks_all->map(function ($claim) {
                    $cat_vo = $claim->where(
                        "jenis_perubahan",
                        "=",
                        "VO"
                    );
                    // $item_vo = $cat_vo->count();
                    $item_vo = $cat_vo->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    // dd($item_vo, $jumlah_vo);

                    //Kategori Klaim
                    $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                    // $item_klaim = $cat_klaim->count();
                    $item_klaim = $cat_klaim->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    // dd($item_klaim, $jumlah_klaim);

                    //Kategori ANti Klaim
                    $cat_anti_klaim = $claim->where(
                        "jenis_perubahan",
                        "=",
                        "Anti Klaim"
                    );
                    // $item_anti_klaim = $cat_anti_klaim->count();
                    $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    // dd($item_anti_klaim, $jumlah_anti_klaim);

                    //Kategori Klaim Asuransi
                    $cat_klaim_asuransi = $claim->where(
                        "jenis_perubahan",
                        "=",
                        "Klaim Asuransi"
                    );
                    // $item_klaim_asuransi = $cat_klaim_asuransi->count();
                    $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    return [
                        'kode_proyek' => $claim->first()->kode_proyek,
                        'profit_center' => $claim->first()->ContractManagements->profit_center,
                        'nama_proyek' => $claim->first()->Proyeks->nama_proyek,
                        'id_contract' => $claim->first()->id_contract,
                        'unit_kerja' => $claim->first()->Proyeks->UnitKerja->unit_kerja,
                        'total_vo' => $item_vo,
                        'total_klaim' => $item_klaim,
                        'total_anti_klaim' => $item_anti_klaim,
                        'total_klaim_asuransi' => $item_klaim_asuransi,
                    ];
                });
            }
        } else {
            // $tahun_proyeks = Proyek::get()->groupBy("tahun_perolehan")->keys();

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

            // $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            // if (!empty($filterBulan) && $filterTahun == 2023) {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            // } else {
            //     if ($filterTahun < 2023 && !empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } elseif ($filterTahun < 2023 && empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } else {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //         // dd("test");
            //     }
            // }

            if ($filterBulan == (int) date("m") && $filterTahun == (int) date("Y")) {
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->get();
                $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->where('contract_managements.profit_center', '!=', null)->get();

                $proyeks_all = $proyeks_all->map(function ($proyek) {
                    $result = [];
                    $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $proyek->ContractManagements->profit_center;
                    $result['nama_proyek'] = $proyek->nama_proyek;
                    $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->UnitKerja->unit_kerja;

                    if (!empty($proyek->PerubahanKontrak)) {
                        $claim = $proyek->PerubahanKontrak;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        // $item_vo = $cat_vo->count();
                        $item_vo = $cat_vo->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        // $item_klaim = $cat_klaim->count();
                        $item_klaim = $cat_klaim->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        // $item_anti_klaim = $cat_anti_klaim->count();
                        $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        // $item_klaim_asuransi = $cat_klaim_asuransi->count();
                        $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                            return (int) $item->biaya_pengajuan;
                        });
                        $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                            return (int) $item->nilai_disetujui;
                        });

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });
            } else {

                $proyeks_all = ContractApproval::join(
                    "proyeks",
                    "proyeks.kode_proyek",
                    "=",
                    "contract_approval.kode_proyek"
                )->where("periode", '=', $filterBulan)->where(
                    "tahun",
                    "=",
                    $filterTahun
                )->get()->groupBy('kode_proyek');

                $proyeks_all = $proyeks_all->map(function ($claim) {
                    $cat_vo = $claim->where(
                        "jenis_perubahan",
                        "=",
                        "VO"
                    );
                    // $item_vo = $cat_vo->count();
                    $item_vo = $cat_vo->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    // dd($item_vo, $jumlah_vo);

                    //Kategori Klaim
                    $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                    // $item_klaim = $cat_klaim->count();
                    $item_klaim = $cat_klaim->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    // dd($item_klaim, $jumlah_klaim);

                    //Kategori ANti Klaim
                    $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                    // $item_anti_klaim = $cat_anti_klaim->count();
                    $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    // dd($item_anti_klaim, $jumlah_anti_klaim);

                    //Kategori Klaim Asuransi
                    $cat_klaim_asuransi = $claim->where(
                        "jenis_perubahan",
                        "=",
                        "Klaim Asuransi"
                    );
                    // $item_klaim_asuransi = $cat_klaim_asuransi->count();
                    $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        return (int) $item->biaya_pengajuan;
                    });
                    return [
                        'kode_proyek' => $claim->first()->kode_proyek,
                        'profit_center' => $claim->first()->ContractManagements->profit_center,
                        'nama_proyek' => $claim->first()->Proyeks->nama_proyek,
                        'id_contract' => $claim->first()->id_contract,
                        'unit_kerja' => $claim->first()->Proyeks->UnitKerja->unit_kerja,
                        'total_vo' => $item_vo,
                        'total_klaim' => $item_klaim,
                        'total_anti_klaim' => $item_anti_klaim,
                        'total_klaim_asuransi' => $item_klaim_asuransi,
                    ];
                });
            }
        }

        $claims = $proyeks_all;
        // dd($claims);

        return view(
            "5_Claim",
            compact([
                "claims", "filterUnitKerja", "filterJenis", "unitkerjas", "tahun_proyeks", "filterTahun", "month", "filterBulan", "unit_kerjas_select"
            ])
        );
    }
    public function view($kode_proyek, $id_contract, Request $request)
    {
        // $filterBulan = $request->query("bulan-perubahan");
        $filterStatus = $request->query("stage");
        // dd($filterStatus);
        // $filterBulan = $data["bulan-perubahan"];
        $data = $request->all();
        $link = $data["link"] ?? "kt_user_view_claim_VO";
        $periode = isset($data["periode"]) ? (int) $data["periode"] : '';

        $tahun = isset($data["tahun"]) ? (int) $data["tahun"] : "";
        // dd($periode);
        $user = Auth::user();
        // dd($user->Pegawai);

        // $monthNow = new DateTime("M");
        $contracts = ContractManagements::where("id_contract", "=", $id_contract)->first();
        $proyek = Proyek::where("kode_proyek", "=", $kode_proyek)->first();

        if (empty($periode)) {
            if (!empty($filterStatus)) {
                $claims = PerubahanKontrak::where("id_contract", "=", $id_contract)->where("stage", "=", $filterStatus)->get();
            } else {
                $claims = PerubahanKontrak::where("id_contract", "=", $id_contract)->get();
            }
        } else {
            if (!empty($filterStatus)) {
                $claims = ContractApproval::where("id_contract", "=", $id_contract)->where("stage", "=", $filterStatus)->where("periode", "=", $periode)->where("tahun", "=", $tahun)->get();
            } else {
                $claims = ContractApproval::where("id_contract", "=", $id_contract)->where("periode", "=", $periode)->where("tahun", "=", $tahun)->get();
            }
        }

        // dd(ContractApproval::where("id_contract", "=", $id_contract)->where("periode", "<=", $periode)->get());

        $claim_all = PerubahanKontrak::where(
            "id_contract",
            "=",
            $id_contract
        )->get();

        // dd($contract);

        $claims_vo = $claims->where("jenis_perubahan", "=", "VO");
        $claims_klaim = $claims->where("jenis_perubahan", "=", "Klaim");
        $claims_anti_klaim = $claims->where("jenis_perubahan", "=", "Anti Klaim");
        $claims_klaim_asuransi = $claims->where("jenis_perubahan", "=", "Klaim Asuransi");
        // dd($claims_vo);

        return view("claimManagement/viewDetail", compact([
            "contracts",
            "claims_vo",
            "claims_klaim",
            "claims_anti_klaim",
            "claims_klaim_asuransi",
            "proyek",
            "claim_all",
            "link",
            "periode",
            "user"
        ]));
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

    public function claimDeleteOld(Request $request)
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

    public function perubahanKontrakEdit(Request $request)
    {
        $data = $request->all();
        $file = $request->file("dokumen-approve");

        $validateInput = validateInput($data, [
            'tanggal-disetujui' => 'required|date',
            'dokumen-approve' => 'required|file|mimes:pdf',
        ]);

        if (!empty($validateInput)) {
            Alert::html("Error", "Pastikan field <b>$validateInput</b> terisi dengan benar!", "error");
            return redirect()->back();
        }

        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();

        $perubahan_kontrak = PerubahanKontrak::find($data["id-perubahan-kontrak"]);
        // dd($perubahan_kontrak->DokumenPendukungs);

        // if ($perubahan_kontrak->DokumenPendukungs->isEmpty()) {
        //     Alert::error("Erorr", "Input Dokumen Pendukung terlebih dahulu");
        //     return redirect()->back();
        // }

        $perubahan_kontrak->stage = $data["stage"];
        $perubahan_kontrak->nilai_disetujui = str_replace(".", "", $data["nilai-disetujui"]);
        $perubahan_kontrak->tanggal_disetujui = $data["tanggal-disetujui"];
        // $perubahan_kontrak->waktu_disetujui = $data["waktu-disetujui"];
        $perubahan_kontrak->id_dokumen = $id_document;
        $perubahan_kontrak->nilai_negatif = isset($data['nilai-negatif']);
        $perubahan_kontrak->waktu_disetujui_new = $data['waktu-disetujui'];
        $perubahan_kontrak->dokumen_approve = $nama_file;

        $perubahan_kontrak->save();
        moveFileTemp($file, explode(".", $id_document)[0]);
        Alert::success("Success", "Perubahan Kontrak berhasil ditambahkan");
        return redirect()->back();
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
    public function newClaimOld(Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "Field di atas wajib diisi string",
        ];
        $rules = [
            // "kode-proyek" => "required|string",
            "jenis-perubahan" => "required|string",
            "tanggal-perubahan" => "required|string",
            "uraian-perubahan" => "required|string",
            "proposal-klaim" => "required|string",
            "tanggal-pengajuan" => "required|string",
            // "biaya-pengajuan" => "required|string",
            // "waktu-pengajuan" => "required|string",
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
        $perubahan_kontrak->profit_center = $data["profit-center"];
        $perubahan_kontrak->id_contract = $contract->id_contract;
        $perubahan_kontrak->jenis_perubahan = $data["jenis-perubahan"];
        $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
        $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
        $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
        $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
        $perubahan_kontrak->biaya_pengajuan = !empty($data["biaya-pengajuan"]) ? str_replace(".", "", $data["biaya-pengajuan"]) : null;
        $perubahan_kontrak->waktu_pengajuan = !empty($data["biaya-pengajuan"]) ? $data["waktu-pengajuan"] : null;
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





    //===============================================================================================================================//
    /**
     * Controller yg dipakai sekarang
     */
    //===============================================================================================================================//

    public function index(Request $request)
    {

        $filterUnitKerja = $request->query("filter-unit");
        $filterJenis = $request->query("filter-jenis");
        $filterTahun = !empty($request->query("tahun-proyek")) ? (int) $request->query("tahun-proyek") : (int) date("Y");
        $filterBulan = !empty($request->query("bulan-proyek")) ? (int) $request->query("bulan-proyek") : (int) date("m");

        $year = (int) date("Y");
        $month = (int) date("m");

        // $unitkerjas = UnitKerja::get()->whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8"]);
        // dd($unitkerjas);
        $tahun_proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->get()->groupBy("start_year")->keys()->sortDesc();
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

            // $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            // if (!empty($filterBulan) && $filterTahun == 2023) {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            // } else {
            //     if ($filterTahun < 2023 && !empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } elseif ($filterTahun < 2023 && empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } else {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //         // dd("test");
            //     }
            // }

            $totalVOAll = 0;
            $totalClaimAll = 0;
            $totalAntiClaimAll = 0;
            $totalClaimAsuransiAll = 0;
            $totalVOAllApproved = 0;
            $totalClaimAllApproved = 0;
            $totalAntiClaimAllApproved = 0;
            $totalClaimAsuransiAllApproved = 0;
            $jumlahVOAll = 0;
            $jumlahClaimAll = 0;
            $jumlahAntiClaimAll = 0;
            $jumlahClaimAsuransiAll = 0;
            $jumlahVOAllApproved = 0;
            $jumlahClaimAllApproved = 0;
            $jumlahAntiClaimAllApproved = 0;
            $jumlahClaimAsuransiAllApproved = 0;

            $totalVOAllPemeliharaan = 0;
            $totalClaimAllPemeliharaan = 0;
            $totalAntiClaimAllPemeliharaan = 0;
            $totalClaimAsuransiAllPemeliharaan = 0;
            $totalVOAllApprovedPemeliharaan = 0;
            $totalClaimAllApprovedPemeliharaan = 0;
            $totalAntiClaimAllApprovedPemeliharaan = 0;
            $totalClaimAsuransiAllApprovedPemeliharaan = 0;
            $jumlahVOAllPemeliharaan = 0;
            $jumlahClaimAllPemeliharaan = 0;
            $jumlahAntiClaimAllPemeliharaan = 0;
            $jumlahClaimAsuransiAllPemeliharaan = 0;
            $jumlahVOAllApprovedPemeliharaan = 0;
            $jumlahClaimAllApprovedPemeliharaan = 0;
            $jumlahAntiClaimAllApprovedPemeliharaan = 0;
            $jumlahClaimAsuransiAllApprovedPemeliharaan = 0;

            if ($filterBulan == (int) date("m") && $filterTahun == (int) date("Y")) {
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->get();
                $proyeks_all = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', 2)->where('contract_managements.profit_center', '!=', null)->get();
                $proyeks_all_pemeliharaan = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', 3)->where('contract_managements.profit_center', '!=', null)->get();
                //Pelaksanaan
                $proyeks_all = $proyeks_all->map(function ($proyek) use (&$totalVOAll, &$totalClaimAll, &$totalAntiClaimAll, &$totalClaimAsuransiAll, &$totalVOAllApproved, &$totalClaimAllApproved, &$totalAntiClaimAllApproved, &$totalClaimAsuransiAllApproved, &$jumlahVOAll, &$jumlahClaimAll, &$jumlahAntiClaimAll, &$jumlahClaimAsuransiAll, &$jumlahVOAllApproved, &$jumlahClaimAllApproved, &$jumlahAntiClaimAllApproved, &$jumlahClaimAsuransiAllApproved) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $proyek->profit_center;
                    $result['nama_proyek'] = $proyek->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->UnitKerja->unit_kerja;

                    if ($proyek->PerubahanKontrak->isNotEmpty()) {
                        $claim = $proyek->PerubahanKontrak;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAll += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApproved += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            // $item_vo += $item->biaya_pengajuan;
                            // if ($item->stage == 5) {
                            //     $item_vo_approved += (int)$item->nilai_disetujui;
                            // }
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAll += $item_vo;
                        $totalVOAllApproved += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAll += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApproved += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAll += $item_klaim;
                        $totalClaimAllApproved += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAll += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApproved += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAll += $item_anti_klaim;
                        $totalAntiClaimAllApproved += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAll += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApproved += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAll += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApproved += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });
                //Pemeliharaan
                $proyeks_all_pemeliharaan = $proyeks_all_pemeliharaan->map(function ($proyek) use (
                    &$totalVOAllPemeliharaan,
                    &$totalClaimAllPemeliharaan,
                    &$totalAntiClaimAllPemeliharaan,
                    &$totalClaimAsuransiAllPemeliharaan,
                    &$totalVOAllApprovedPemeliharaan,
                    &$totalClaimAllApprovedPemeliharaan,
                    &$totalAntiClaimAllApprovedPemeliharaan,
                    &$totalClaimAsuransiAllApprovedPemeliharaan,
                    &$jumlahVOAllPemeliharaan,
                    &$jumlahClaimAllPemeliharaan,
                    &$jumlahAntiClaimAllPemeliharaan,
                    &$jumlahClaimAsuransiAllPemeliharaan,
                    &$jumlahVOAllApprovedPemeliharaan,
                    &$jumlahClaimAllApprovedPemeliharaan,
                    &$jumlahAntiClaimAllApprovedPemeliharaan,
                    &$jumlahClaimAsuransiAllApprovedPemeliharaan
                ) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $proyek->profit_center;
                    $result['nama_proyek'] = $proyek->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->UnitKerja->unit_kerja;

                    if ($proyek->PerubahanKontrak->isNotEmpty()) {
                        $claim = $proyek->PerubahanKontrak;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAllPemeliharaan += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApprovedPemeliharaan += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAllPemeliharaan += $item_vo;
                        $totalVOAllApprovedPemeliharaan += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAllPemeliharaan += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApprovedPemeliharaan += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAllPemeliharaan += $item_klaim;
                        $totalClaimAllApprovedPemeliharaan += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAllPemeliharaan += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApprovedPemeliharaan += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAllPemeliharaan += $item_anti_klaim;
                        $totalAntiClaimAllApprovedPemeliharaan += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAllPemeliharaan += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApprovedPemeliharaan += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAllPemeliharaan += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApprovedPemeliharaan += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });
            } else {

                $proyeks_all = ContractApproval::join(
                    "proyek_pis_new",
                    "proyek_pis_new.profit_center",
                    "=",
                    "contract_approval_new.profit_center"
                )->where("periode_laporan", '=', $filterBulan)->where(
                    "tahun",
                    "=",
                    $filterTahun
                )->get()->groupBy('profit_center');

                $proyeks_all_pemeliharaan = ContractApproval::join(
                    "proyek_pis_new",
                    "proyek_pis_new.profit_center",
                    "=",
                    "contract_approval_new.profit_center"
                )->where("periode_laporan", '=', $filterBulan)->where("tahun", $filterTahun)->get()->filter(function ($item) {
                    return $item->ContractManagements->stages == 3;
                })->groupBy('profit_center');

                $proyeks_all = $proyeks_all->map(function ($proyek, $key) use (&$totalVOAll, &$totalClaimAll, &$totalAntiClaimAll, &$totalClaimAsuransiAll, &$totalVOAllApproved, &$totalClaimAllApproved, &$totalAntiClaimAllApproved, &$totalClaimAsuransiAllApproved, &$jumlahVOAll, &$jumlahClaimAll, &$jumlahAntiClaimAll, &$jumlahClaimAsuransiAll, &$jumlahVOAllApproved, &$jumlahClaimAllApproved, &$jumlahAntiClaimAllApproved, &$jumlahClaimAsuransiAllApproved) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $key;
                    $result['nama_proyek'] = $proyek->first()->ProyekPISNew->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->first()->ProyekPISNew->UnitKerja?->unit_kerja;

                    if ($proyek->isNotEmpty()) {
                        $claim = $proyek;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAll += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApproved += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            // $item_vo += $item->biaya_pengajuan;
                            // if ($item->stage == 5) {
                            //     $item_vo_approved += (int)$item->nilai_disetujui;
                            // }
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAll += $item_vo;
                        $totalVOAllApproved += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAll += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApproved += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAll += $item_klaim;
                        $totalClaimAllApproved += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAll += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApproved += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAll += $item_anti_klaim;
                        $totalAntiClaimAllApproved += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAll += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApproved += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAll += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApproved += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });

                //Pemeliharaan
                $proyeks_all_pemeliharaan = $proyeks_all_pemeliharaan->map(function ($proyek, $key) use (
                    &$totalVOAllPemeliharaan,
                    &$totalClaimAllPemeliharaan,
                    &$totalAntiClaimAllPemeliharaan,
                    &$totalClaimAsuransiAllPemeliharaan,
                    &$totalVOAllApprovedPemeliharaan,
                    &$totalClaimAllApprovedPemeliharaan,
                    &$totalAntiClaimAllApprovedPemeliharaan,
                    &$totalClaimAsuransiAllApprovedPemeliharaan,
                    &$jumlahVOAllPemeliharaan,
                    &$jumlahClaimAllPemeliharaan,
                    &$jumlahAntiClaimAllPemeliharaan,
                    &$jumlahClaimAsuransiAllPemeliharaan,
                    &$jumlahVOAllApprovedPemeliharaan,
                    &$jumlahClaimAllApprovedPemeliharaan,
                    &$jumlahAntiClaimAllApprovedPemeliharaan,
                    &$jumlahClaimAsuransiAllApprovedPemeliharaan
                ) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $key;
                    $result['nama_proyek'] = $proyek->first()->ProyekPISNew->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->first()->ProyekPISNew->UnitKerja?->unit_kerja;

                    if ($proyek->isNotEmpty()) {
                        $claim = $proyek;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAllPemeliharaan += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApprovedPemeliharaan += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAllPemeliharaan += $item_vo;
                        $totalVOAllApprovedPemeliharaan += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAllPemeliharaan += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApprovedPemeliharaan += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAllPemeliharaan += $item_klaim;
                        $totalClaimAllApprovedPemeliharaan += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAllPemeliharaan += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApprovedPemeliharaan += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAllPemeliharaan += $item_anti_klaim;
                        $totalAntiClaimAllApprovedPemeliharaan += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAllPemeliharaan += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApprovedPemeliharaan += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAllPemeliharaan += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApprovedPemeliharaan += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });
            }
        } else {
            // $tahun_proyeks = Proyek::get()->groupBy("tahun_perolehan")->keys();

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

            // $jenis_proyeks = JenisProyek::all("kode_jenis");
            // dd($unitkerjas);

            // $jenis_proyek_get = !empty($request->query("filter-jenis")) ? [$request->query("filter-jenis")] : $jenis_proyeks->toArray();
            $unit_kerja_get = !empty($request->query("filter-unit")) ? [$request->query("filter-unit")] : $unitkerjas->toArray();

            // if (!empty($filterBulan) && $filterTahun == 2023) {
            //     $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            // } else {
            //     if ($filterTahun < 2023 && !empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", $filterBulan)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } elseif ($filterTahun < 2023 && empty($filterBulan)) {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //     } else {
            //         $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $filterTahun)->where("bulan_pelaksanaan", "<=", 12)->whereIn("unit_kerja", $unit_kerja_get)->get();
            //         // dd("test");
            //     }
            // }


            $totalVOAll = 0;
            $totalClaimAll = 0;
            $totalAntiClaimAll = 0;
            $totalClaimAsuransiAll = 0;
            $totalVOAllApproved = 0;
            $totalClaimAllApproved = 0;
            $totalAntiClaimAllApproved = 0;
            $totalClaimAsuransiAllApproved = 0;
            $jumlahVOAll = 0;
            $jumlahClaimAll = 0;
            $jumlahAntiClaimAll = 0;
            $jumlahClaimAsuransiAll = 0;
            $jumlahVOAllApproved = 0;
            $jumlahClaimAllApproved = 0;
            $jumlahAntiClaimAllApproved = 0;
            $jumlahClaimAsuransiAllApproved = 0;

            $totalVOAllPemeliharaan = 0;
            $totalClaimAllPemeliharaan = 0;
            $totalAntiClaimAllPemeliharaan = 0;
            $totalClaimAsuransiAllPemeliharaan = 0;
            $totalVOAllApprovedPemeliharaan = 0;
            $totalClaimAllApprovedPemeliharaan = 0;
            $totalAntiClaimAllApprovedPemeliharaan = 0;
            $totalClaimAsuransiAllApprovedPemeliharaan = 0;
            $jumlahVOAllPemeliharaan = 0;
            $jumlahClaimAllPemeliharaan = 0;
            $jumlahAntiClaimAllPemeliharaan = 0;
            $jumlahClaimAsuransiAllPemeliharaan = 0;
            $jumlahVOAllApprovedPemeliharaan = 0;
            $jumlahClaimAllApprovedPemeliharaan = 0;
            $jumlahAntiClaimAllApprovedPemeliharaan = 0;
            $jumlahClaimAsuransiAllApprovedPemeliharaan = 0;

            if ($filterBulan == (int) date("m") && $filterTahun == (int) date("Y")) {
                // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->get();
                $proyeks_all = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', 2)->where('contract_managements.profit_center', '!=', null)->get();
                $proyeks_all_pemeliharaan = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', 3)->where('contract_managements.profit_center', '!=', null)->get();

                $proyeks_all = $proyeks_all->map(function ($proyek) use (&$totalVOAll, &$totalClaimAll, &$totalAntiClaimAll, &$totalClaimAsuransiAll, &$totalVOAllApproved, &$totalClaimAllApproved, &$totalAntiClaimAllApproved, &$totalClaimAsuransiAllApproved, &$jumlahVOAll, &$jumlahClaimAll, &$jumlahAntiClaimAll, &$jumlahClaimAsuransiAll, &$jumlahVOAllApproved, &$jumlahClaimAllApproved, &$jumlahAntiClaimAllApproved, &$jumlahClaimAsuransiAllApproved) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $proyek->profit_center;
                    $result['nama_proyek'] = $proyek->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->UnitKerja->unit_kerja;

                    if ($proyek->PerubahanKontrak->isNotEmpty()) {
                        $claim = $proyek->PerubahanKontrak;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAll += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApproved += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAll += $item_vo;
                        $totalVOAllApproved += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAll += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApproved += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAll += $item_klaim;
                        $totalClaimAllApproved += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAll += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApproved += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAll += $item_anti_klaim;
                        $totalAntiClaimAllApproved += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAll += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApproved += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAll += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApproved += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });

                $proyeks_all_pemeliharaan = $proyeks_all_pemeliharaan->map(function ($proyek) use (
                    &$totalVOAllPemeliharaan,
                    &$totalClaimAllPemeliharaan,
                    &$totalAntiClaimAllPemeliharaan,
                    &$totalClaimAsuransiAllPemeliharaan,
                    &$totalVOAllApprovedPemeliharaan,
                    &$totalClaimAllApprovedPemeliharaan,
                    &$totalAntiClaimAllApprovedPemeliharaan,
                    &$totalClaimAsuransiAllApprovedPemeliharaan,
                    &$jumlahVOAllPemeliharaan,
                    &$jumlahClaimAllPemeliharaan,
                    &$jumlahAntiClaimAllPemeliharaan,
                    &$jumlahClaimAsuransiAllPemeliharaan,
                    &$jumlahVOAllApprovedPemeliharaan,
                    &$jumlahClaimAllApprovedPemeliharaan,
                    &$jumlahAntiClaimAllApprovedPemeliharaan,
                    &$jumlahClaimAsuransiAllApprovedPemeliharaan
                ) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $proyek->profit_center;
                    $result['nama_proyek'] = $proyek->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->UnitKerja->unit_kerja;

                    if ($proyek->PerubahanKontrak->isNotEmpty()) {
                        $claim = $proyek->PerubahanKontrak;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAllPemeliharaan += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApprovedPemeliharaan += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAllPemeliharaan += $item_vo;
                        $totalVOAllApprovedPemeliharaan += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAllPemeliharaan += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApprovedPemeliharaan += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAllPemeliharaan += $item_klaim;
                        $totalClaimAllApprovedPemeliharaan += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAllPemeliharaan += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApprovedPemeliharaan += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAllPemeliharaan += $item_anti_klaim;
                        $totalAntiClaimAllApprovedPemeliharaan += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAllPemeliharaan += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApprovedPemeliharaan += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAllPemeliharaan += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApprovedPemeliharaan += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });
            } else {

                $proyeks_all = ContractApproval::join("proyeks", "proyeks.profit_center", "=", "contract_approval_new.profit_center")->where("periode_laporan", '=', $filterBulan)->where("tahun", "=", $filterTahun)->get()->filter(function ($item) {
                    return $item->ContractManagements->stages == 2;
                })->groupBy('profit_center');

                $proyeks_all_pemeliharaan = ContractApproval::join("proyek_pis_new", "proyek_pis_new.profit_center", "=", "contract_approval_new.profit_center")->where("periode_laporan", '=', $filterBulan)->where("tahun", "=", $filterTahun)->get()->filter(function ($item) {
                    return $item->ContractManagements->stages == 3;
                })->groupBy('profit_center');


                $proyeks_all = $proyeks_all->map(function ($proyek, $key) use (&$totalVOAll, &$totalClaimAll, &$totalAntiClaimAll, &$totalClaimAsuransiAll, &$totalVOAllApproved, &$totalClaimAllApproved, &$totalAntiClaimAllApproved, &$totalClaimAsuransiAllApproved, &$jumlahVOAll, &$jumlahClaimAll, &$jumlahAntiClaimAll, &$jumlahClaimAsuransiAll, &$jumlahVOAllApproved, &$jumlahClaimAllApproved, &$jumlahAntiClaimAllApproved, &$jumlahClaimAsuransiAllApproved) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $key;
                    $result['nama_proyek'] = $proyek->first()->ProyekPISNew->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->first()->ProyekPISNew->UnitKerja?->unit_kerja;

                    if ($proyek->isNotEmpty()) {
                        $claim = $proyek;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAll += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApproved += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            // $item_vo += $item->biaya_pengajuan;
                            // if ($item->stage == 5) {
                            //     $item_vo_approved += (int)$item->nilai_disetujui;
                            // }
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAll += $item_vo;
                        $totalVOAllApproved += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAll += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApproved += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAll += $item_klaim;
                        $totalClaimAllApproved += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAll += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApproved += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAll += $item_anti_klaim;
                        $totalAntiClaimAllApproved += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAll += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApproved += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAll += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApproved += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });

                //Pemeliharaan
                $proyeks_all_pemeliharaan = $proyeks_all_pemeliharaan->map(function ($proyek, $key) use (
                    &$totalVOAllPemeliharaan,
                    &$totalClaimAllPemeliharaan,
                    &$totalAntiClaimAllPemeliharaan,
                    &$totalClaimAsuransiAllPemeliharaan,
                    &$totalVOAllApprovedPemeliharaan,
                    &$totalClaimAllApprovedPemeliharaan,
                    &$totalAntiClaimAllApprovedPemeliharaan,
                    &$totalClaimAsuransiAllApprovedPemeliharaan,
                    &$jumlahVOAllPemeliharaan,
                    &$jumlahClaimAllPemeliharaan,
                    &$jumlahAntiClaimAllPemeliharaan,
                    &$jumlahClaimAsuransiAllPemeliharaan,
                    &$jumlahVOAllApprovedPemeliharaan,
                    &$jumlahClaimAllApprovedPemeliharaan,
                    &$jumlahAntiClaimAllApprovedPemeliharaan,
                    &$jumlahClaimAsuransiAllApprovedPemeliharaan
                ) {
                    $result = [];
                    // $result['kode_proyek'] = $proyek->kode_proyek;
                    $result['profit_center'] = $key;
                    $result['nama_proyek'] = $proyek->first()->ProyekPISNew->proyek_name;
                    // $result['id_contract'] = $proyek->ContractManagements->id_contract;
                    $result['unit_kerja'] = $proyek->first()->ProyekPISNew->UnitKerja?->unit_kerja;

                    if ($proyek->isNotEmpty()) {
                        $claim = $proyek;
                        $item_vo = 0;
                        $item_vo_approved = 0;
                        $cat_vo = $claim->where("jenis_perubahan", "=", "VO");
                        $result["jumlah_vo"] = $cat_vo->count();
                        $jumlahVOAllPemeliharaan += $cat_vo->count();
                        $result["jumlah_vo_approved"] = $cat_vo->where("stage", 5)->count();
                        $jumlahVOAllApprovedPemeliharaan += $cat_vo->where("stage", 5)->count();
                        // $item_vo = $cat_vo->count();
                        // $item_vo = $cat_vo->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_vo_approved = $cat_vo->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        foreach ($cat_vo as $item) {
                            if (!$item->nilai_negatif) {
                                $item_vo += $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved += (int)$item->nilai_disetujui;
                                }
                            } else {
                                $item_vo -= $item->biaya_pengajuan;
                                if ($item->stage == 5) {
                                    $item_vo_approved -= (int)$item->nilai_disetujui;
                                }
                            }
                        }

                        $totalVOAllPemeliharaan += $item_vo;
                        $totalVOAllApprovedPemeliharaan += $item_vo_approved;

                        //Kategori Klaim
                        $cat_klaim = $claim->where("jenis_perubahan", "=", "Klaim");
                        $result["jumlah_klaim"] = $cat_klaim->count();
                        $jumlahClaimAllPemeliharaan += $cat_klaim->count();
                        $result["jumlah_klaim_approved"] = $cat_klaim->where("stage", 5)->count();
                        $jumlahClaimAllApprovedPemeliharaan += $cat_klaim->where("stage", 5)->count();
                        // $item_klaim = $cat_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_approved = $cat_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim = 0;
                        $item_klaim_approved = 0;
                        foreach ($cat_klaim as $item) {
                            $item_klaim += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAllPemeliharaan += $item_klaim;
                        $totalClaimAllApprovedPemeliharaan += $item_klaim_approved;

                        //Kategori ANti Klaim
                        $cat_anti_klaim = $claim->where("jenis_perubahan", "=", "Anti Klaim");
                        $result["jumlah_anti_klaim"] = $cat_anti_klaim->count();
                        $jumlahAntiClaimAllPemeliharaan += $cat_anti_klaim->count();
                        $result["jumlah_anti_klaim_approved"] = $cat_anti_klaim->where("stage", 5)->count();
                        $jumlahAntiClaimAllApprovedPemeliharaan += $cat_anti_klaim->where("stage", 5)->count();
                        // $item_anti_klaim = $cat_anti_klaim->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_anti_klaim_approved = $cat_anti_klaim->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_anti_klaim = 0;
                        $item_anti_klaim_approved = 0;
                        foreach ($cat_anti_klaim as $item) {
                            $item_anti_klaim -= $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_anti_klaim += $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved += (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_anti_klaim -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_anti_klaim_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalAntiClaimAllPemeliharaan += $item_anti_klaim;
                        $totalAntiClaimAllApprovedPemeliharaan += $item_anti_klaim_approved;

                        //Kategori Klaim Asuransi
                        $cat_klaim_asuransi = $claim->where("jenis_perubahan", "=", "Klaim Asuransi");
                        $result["jumlah_klaim_asuransi"] = $cat_klaim_asuransi->count();
                        $jumlahClaimAsuransiAllPemeliharaan += $cat_klaim_asuransi->count();
                        $result["jumlah_klaim_asuransi_approved"] = $cat_klaim_asuransi->where("stage", 5)->count();
                        $jumlahClaimAsuransiAllApprovedPemeliharaan += $cat_klaim_asuransi->where("stage", 5)->count();
                        // $item_klaim_asuransi = $cat_klaim_asuransi->sum(function ($item) {
                        //     return (int) $item->biaya_pengajuan;
                        // });
                        // $item_klaim_asuransi_approved = $cat_klaim_asuransi->where("stage", 5)->sum(function ($item) {
                        //     return (int) $item->nilai_disetujui;
                        // });
                        $item_klaim_asuransi = 0;
                        $item_klaim_asuransi_approved = 0;
                        foreach ($cat_klaim_asuransi as $item) {
                            $item_klaim_asuransi += $item->biaya_pengajuan;
                            if ($item->stage == 5) {
                                $item_klaim_asuransi_approved += (int)$item->nilai_disetujui;
                            }
                            // if (!$item->nilai_negatif) {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // } else {
                            //     $item_klaim_asuransi -= $item->biaya_pengajuan;
                            //     if ($item->stage == 5) {
                            //         $item_klaim_asuransi_approved -= (int)$item->nilai_disetujui;
                            //     }
                            // }
                        }
                        $totalClaimAsuransiAllPemeliharaan += $item_klaim_asuransi;
                        $totalClaimAsuransiAllApprovedPemeliharaan += $item_klaim_asuransi_approved;

                        $result['total_vo'] = $item_vo;
                        $result['total_klaim'] = $item_klaim;
                        $result['total_anti_klaim'] = $item_anti_klaim;
                        $result['total_klaim_asuransi'] = $item_klaim_asuransi;
                        $result['total_vo_approved'] = $item_vo_approved;
                        $result['total_klaim_approved'] = $item_klaim_approved;
                        $result['total_anti_klaim_approved'] = $item_anti_klaim_approved;
                        $result['total_klaim_asuransi_approved'] = $item_klaim_asuransi_approved;
                    } else {
                        $result['total_vo'] = 0;
                        $result['total_klaim'] = 0;
                        $result['total_anti_klaim'] = 0;
                        $result['total_klaim_asuransi'] = 0;
                        $result['total_vo_approved'] = 0;
                        $result['total_klaim_approved'] = 0;
                        $result['total_anti_klaim_approved'] = 0;
                        $result['total_klaim_asuransi_approved'] = 0;
                        $result['jumlah_vo'] = 0;
                        $result['jumlah_klaim'] = 0;
                        $result['jumlah_anti_klaim'] = 0;
                        $result['jumlah_klaim_asuransi'] = 0;
                        $result['jumlah_vo_approved'] = 0;
                        $result['jumlah_klaim_approved'] = 0;
                        $result['jumlah_anti_klaim_approved'] = 0;
                        $result['jumlah_klaim_asuransi_approved'] = 0;
                    }

                    return $result;
                });
            }
        }

        $claims = $proyeks_all;
        $claims_pemeliharaan = $proyeks_all_pemeliharaan;
        // dd($claims);

        return view(
            "5_Claim",
            compact([
                "claims", "filterUnitKerja", "filterJenis", "unitkerjas", "tahun_proyeks", "filterTahun", "month", "filterBulan", "unit_kerjas_select",
                "claims_pemeliharaan",
                "totalVOAll",
                "totalClaimAll",
                "totalAntiClaimAll",
                "totalClaimAsuransiAll",
                "totalVOAllApproved",
                "totalClaimAllApproved",
                "totalAntiClaimAllApproved",
                "totalClaimAsuransiAllApproved",
                "jumlahVOAll",
                "jumlahClaimAll",
                "jumlahAntiClaimAll",
                "jumlahClaimAsuransiAll",
                "jumlahVOAllApproved",
                "jumlahClaimAllApproved",
                "jumlahAntiClaimAllApproved",
                "jumlahClaimAsuransiAllApproved",
                "totalVOAllPemeliharaan",
                "totalClaimAllPemeliharaan",
                "totalAntiClaimAllPemeliharaan",
                "totalClaimAsuransiAllPemeliharaan",
                "totalVOAllApprovedPemeliharaan",
                "totalClaimAllApprovedPemeliharaan",
                "totalAntiClaimAllApprovedPemeliharaan",
                "totalClaimAsuransiAllApprovedPemeliharaan",
                "jumlahVOAllPemeliharaan",
                "jumlahClaimAllPemeliharaan",
                "jumlahAntiClaimAllPemeliharaan",
                "jumlahClaimAsuransiAllPemeliharaan",
                "jumlahVOAllApprovedPemeliharaan",
                "jumlahClaimAllApprovedPemeliharaan",
                "jumlahAntiClaimAllApprovedPemeliharaan",
                "jumlahClaimAsuransiAllApprovedPemeliharaan",
            ])
        );
    }
    
    public function viewClaimNew(Request $request, $profitCenter)
    {
        // $filterBulan = $request->query("bulan-perubahan");
        $filterStatus = $request->query("stage");
        // dd($filterStatus);
        // $filterBulan = $data["bulan-perubahan"];
        $data = $request->all();
        $link = $data["link"] ?? "kt_user_view_claim_VO";
        $periode = isset($data["periode"]) ? (int) $data["periode"] : '';

        $tahun = isset($data["tahun"]) ? (int) $data["tahun"] : "";
        // dd($periode);
        $user = Auth::user();
        // dd($user->Pegawai);

        // $monthNow = new DateTime("M");
        $proyek = ProyekPISNew::where("profit_center", "=", $profitCenter)->first();
        $contracts = ContractManagements::where("profit_center", "=", $profitCenter)->first();
        // dd($contracts);

        if (empty($periode)) {
            if (!empty($filterStatus)) {
                $claims = PerubahanKontrak::where("profit_ceter", "=", $profitCenter)->where("stage", "=", $filterStatus)->get();
            } else {
                $claims = PerubahanKontrak::where("profit_center", "=", $profitCenter)->get();
            }
        } else {
            if (!empty($filterStatus)) {
                $claims = ContractApproval::where("profit_center", "=", $profitCenter)->where("stage", "=", $filterStatus)->where("periode", "=", $periode)->where("tahun", "=", $tahun)->get();
            } else {
                $claims = ContractApproval::where("profit_center", "=", $profitCenter)->where("periode", "=", $periode)->where("tahun", "=", $tahun)->get();
            }
        }

        // dd(ContractApproval::where("id_contract", "=", $id_contract)->where("periode", "<=", $periode)->get());


        // dd($contract);

        $totalClaimVO = 0;
        $totalClaimKlaim = 0;
        $totalClaimAntiKlaim = 0;
        $totalClaimKlaimAsuransi = 0;
        $totalClaimAll = 0;

        $claim_all = PerubahanKontrak::where(
            "profit_center",
            "=",
            $profitCenter
        )->get()?->map(function ($item) use (&$totalClaimAll) {
            if ($item->jenis_perubahan == "VO") {
                if ($item->nilai_negatif) {
                    $item->biaya_pengajuan = 0 - (int) $item->biaya_pengajuan;
                }
            } elseif ($item->jenis_perubahan == "Anti Klaim") {
                $item->biaya_pengajuan = 0 - (int) $item->biaya_pengajuan;
            }

            $totalClaimAll += $item->biaya_pengajuan;

            return $item;
        })->sortByDesc("biaya_pengajuan");

        $claims_vo = $claims->where("jenis_perubahan", "=", "VO")?->map(function ($item) use (&$totalClaimVO) {
            if ($item->nilai_negatif) {
                $item->biaya_pengajuan = 0 - (int) $item->biaya_pengajuan;
                $item->nilai_disetujui = 0 - (int) $item->nilai_disetujui;
            }

            $totalClaimVO += $item->biaya_pengajuan;

            return $item;
        })->sortByDesc("tanggal_pengajuan");

        $claims_klaim = $claims->where(
            "jenis_perubahan",
            "=",
            "Klaim"
        )?->each(function ($item) use (&$totalClaimKlaim) {
            $totalClaimKlaim += $item->biaya_pengajuan;
        })->sortByDesc("tanggal_pengajuan");

        $claims_anti_klaim = $claims->where("jenis_perubahan", "=", "Anti Klaim")?->map(function ($item) use (&$totalClaimAntiKlaim) {
            $item->biaya_pengajuan = 0 - (int) $item->biaya_pengajuan;
            $item->nilai_disetujui = 0 - (int) $item->nilai_disetujui;
            $totalClaimAntiKlaim += $item->biaya_pengajuan;
            return $item;
        })->sortByDesc("tanggal_pengajuan");

        $claims_klaim_asuransi = $claims->where(
            "jenis_perubahan",
            "=",
            "Klaim Asuransi"
        )?->each(function ($item) use (&$totalClaimKlaimAsuransi) {
            $totalClaimKlaimAsuransi += $item->biaya_pengajuan;
        })->sortByDesc("tanggal_pengajuan");
        // dd($claims_vo);

        return view("claimManagement/viewDetail", compact([
            "contracts", "claims_vo", "claims_klaim", "claims_anti_klaim", "claims_klaim_asuransi", "proyek", "claim_all", "link", "periode", "user", "profitCenter", "totalClaimVO", "totalClaimKlaim", "totalClaimAntiKlaim", "totalClaimKlaimAsuransi", "totalClaimAll"
        ]));
    }

    public function newClaim(Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "Field di atas wajib diisi string",
        ];
        $rules = [
            // "kode-proyek" => "required|string",
            "jenis-perubahan" => "required|string",
            "tanggal-perubahan" => "required|string",
            "uraian-perubahan" => "required|string",
            "proposal-klaim" => "required|string",
            "tanggal-pengajuan" => "required|string",
            "profit-center" => "required|string"
            // "biaya-pengajuan" => "required|string",
            // "waktu-pengajuan" => "required|string",
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
        // $contract = ContractManagements::where("project_id", "=", $data["kode-proyek"])->first();
        $perubahan_kontrak = new PerubahanKontrak();
        // $perubahan_kontrak->kode_proyek = $data["kode-proyek"];
        $perubahan_kontrak->profit_center = $data["profit-center"];
        $perubahan_kontrak->id_contract = $data["id-contract"] ?? null;
        $perubahan_kontrak->jenis_perubahan = $data["jenis-perubahan"];
        $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
        $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
        $perubahan_kontrak->keterangan = $data["keterangan"];
        $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
        $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
        $perubahan_kontrak->biaya_pengajuan = !empty($data["biaya-pengajuan"]) ? str_replace(".", "", $data["biaya-pengajuan"]) : null;
        // $perubahan_kontrak->waktu_pengajuan = !empty($data["biaya-pengajuan"]) ? $data["waktu-pengajuan"] : null;
        $perubahan_kontrak->nilai_negatif = isset($data["nilai-negatif"]);
        $perubahan_kontrak->waktu_pengajuan_new = $data['waktu-pengajuan'];
        $perubahan_kontrak->stage = 2;
        // dd($perubahan_kontrak);
        if ($perubahan_kontrak->save()) {
            Alert::success("Success", "Perubahan Kontrak berhasil ditambahkan");
            return redirect()->back();
        }
        Alert::error("Erorr", "Perubahan Kontrak gagal ditambahkan");
        return Redirect::back()->with("modal", $data["modal-name"]);
        // }
    }

    public function editClaim(Request $request, $id)
    {
        $data = $request->all();
        $perubahan_kontrak = PerubahanKontrak::find($id);

        $messages = [
            "required" => "Field di atas wajib diisi",
            "string" => "Field di atas wajib diisi string",
        ];
        $rules = [
            "tanggal-perubahan" => "required|string",
            "uraian-perubahan" => "required|string",
            "proposal-klaim" => "required|string",
            "tanggal-pengajuan" => "required|string",
            // "biaya-pengajuan" => "required|string",
            // "waktu-pengajuan" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Alert::error('Error', "Perubahan Kontrak gagal diperbaharui");
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
        $perubahan_kontrak->tanggal_perubahan = $data["tanggal-perubahan"];
        $perubahan_kontrak->uraian_perubahan = $data["uraian-perubahan"];
        $perubahan_kontrak->keterangan = $data["keterangan"];
        $perubahan_kontrak->proposal_klaim = $data["proposal-klaim"];
        $perubahan_kontrak->tanggal_pengajuan = $data["tanggal-pengajuan"];
        $perubahan_kontrak->biaya_pengajuan = !empty($data["biaya-pengajuan"]) ? str_replace(".", "", $data["biaya-pengajuan"]) : null;
        // $perubahan_kontrak->waktu_pengajuan = !empty($data["waktu-pengajuan"]) ? $data["waktu-pengajuan"] : null;
        $perubahan_kontrak->nilai_negatif = isset($data["nilai-negatif"]);
        $perubahan_kontrak->waktu_pengajuan_new = $data['waktu-pengajuan'];
        // dd($perubahan_kontrak);
        if ($perubahan_kontrak->save()) {
            Alert::success("Success", "Perubahan Kontrak berhasil diperbaharui");
            return redirect()->back();
        }
        Alert::error("Erorr", "Perubahan Kontrak gagal diperbaharui");
        // return Redirect::back()->with("modal", $data["modal-name"]);
        return Redirect::back();
        // }
    }

    public function claimDelete(PerubahanKontrak $id)
    {
        if (empty($id)) {
            Alert::error('Error', 'Claim gagal dihapus. Hubungi Admin');
            return redirect()->back();
        }
        $profit_center = $id->profit_center;
        JenisDokumen::where('id_perubahan_kontrak', $id->id_perubahan_kontrak)->get()?->each(function ($jd) {
            $jd->delete();
        });
        DokumenPendukung::where('id_perubahan_kontrak', $id->id_perubahan_kontrak)->get()?->each(function ($dp) {
            $nama_file = $dp->id_document;
            File::delete(public_path("words/$nama_file"));
            $dp->delete();
        });

        if ($id->delete()) {
            return (object)[
                'success' => true,
                'message' => "Claim berhasil dihapus",
            ];
        }
        return (object)[
            'success' => false,
            'message' => "Claim gagal dihapus",
        ];
    }

    public function dokumenClaim(Request $request, $kategori)
    {
        $data = $request->all();
        $maxSize = env('MAX_FILE_SIZE');

        try {
            DB::beginTransaction();
            $perubahan_kontrak = PerubahanKontrak::find($data["id-perubahan-kontrak"]);

            if (empty($perubahan_kontrak)) {
                Alert::error("Error", "Terjadi kesalahan. Silahkan Hubungi Admin!");
                return redirect()->back();
            }

            $messages = [
                "required" => "Field :attribute wajib diisi",
                "string" => "Field :attribute harus text",
                "date" => "Field :attribute harus format tanggal",
                "max" => "Ukuran file max 70MB",
                "mimes" => "Dokumen wajib format PDF",
            ];
            $rules = [
                "upload-dokumen" => "required|file|mimes:pdf|max:$maxSize",
                "nomor-dokumen" => "required|string",
                "tanggal-dokumen" => "required|date",
                "uraian-dokumen" => "required|string",
            ];

            $validation = Validator::make($data, $rules, $messages);
            if ($validation->fails()) {
                $errors = $validation->errors();
                $collectMessage = "";
                foreach ($errors->all() as $error) {
                    $collectMessage .= ucwords(str_replace("-", " ", $error)) . "<br>";
                }

                Alert::html("Error", $collectMessage, "error");
                return redirect()->back();
            }

            $validation->validate();

            switch ($kategori) {
                case 'site-instruction':
                    $newDokumen = new SiteInstruction();
                    break;
                case 'technical-form':
                    $newDokumen = new TechnicalForm();
                    break;
                case 'technical-query':
                    $newDokumen = new TechnicalQuery();
                    break;
                case 'field-design-change':
                    $newDokumen = new FieldChange();
                    break;
                case 'change-notice':
                    $newDokumen = new ContractChangeNotice();
                    break;
                case 'change-order':
                    $newDokumen = new ContractChangeOrder();
                    break;
                case 'change-proposal':
                    $newDokumen = new ContractChangeProposal();
                    break;

                default:
                    $newDokumen = null;
                    break;
            }

            $file = $request->file("upload-dokumen");
            $nama_file = $file->getClientOriginalName();
            $id_document = date("dmYHis_") . str_replace(' ', '', $file->getClientOriginalName());

            $newDokumen->nomor_dokumen = $data['nomor-dokumen'];
            $newDokumen->tanggal_dokumen = $data['tanggal-dokumen'];
            $newDokumen->uraian_dokumen = $data['uraian-dokumen'];
            $newDokumen->id_document = $perubahan_kontrak->id_contract;
            $newDokumen->profit_center = $perubahan_kontrak->profit_center;
            $newDokumen->perubahan_id = $perubahan_kontrak->id_perubahan_kontrak;
            $newDokumen->id_document = $id_document;
            $newDokumen->nama_document = $nama_file;
            $newDokumen->save();

            DB::commit();
            $file->move(public_path('contract-managements/dokumen-' . $kategori), $id_document);
            Alert::success("Success", "Dokumen Berhasil Ditambahkan");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function dokumenClaimDelete(Request $request)
    {
        $kategori = $request->get("kategori");
        $profit_center = $request->get("profit-center");
        $id_document = $request->get("id-document");
        if (empty($kategori)) {
            return response()->json([
                "success" => false,
                "message" => "Kategori tidak ditemukan. Hubungi Admin",
            ]);
        }

        try {
            DB::beginTransaction();
            switch ($kategori) {
                case 'site-instruction':
                    $documentSelected = SiteInstruction::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;
                case 'technical-form':
                    $documentSelected = TechnicalForm::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;
                case 'technical-query':
                    $documentSelected = TechnicalQuery::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;
                case 'field-design-change':
                    $documentSelected = FieldChange::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;
                case 'change-notice':
                    $documentSelected = ContractChangeNotice::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;
                case 'change-order':
                    $documentSelected = ContractChangeOrder::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;
                case 'change-proposal':
                    $documentSelected = ContractChangeProposal::where("profit_center", $profit_center)->where("id_document", $id_document)->first();
                    break;

                default:
                    $documentSelected = null;
                    break;
            }

            File::delete(public_path('contract-managements/dokumen-' . $kategori));
            $documentSelected->delete();
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Dokumen berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }



    }
}
