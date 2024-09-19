<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Dop;
use App\Models\Proyek;
use GuzzleHttp\Client;
use App\Models\Forecast;
use App\Models\UnitKerja;
use App\Models\ProyekPISNew;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use ParagonIE\Sodium\Compat;
use App\Models\ClaimManagements;
use App\Models\PerubahanKontrak;
use App\Models\ContractManagements;
use App\Models\HistoryForecast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SebastianBergmann\CodeCoverage\Util\Percentage;
use DateTime;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {

        // Begin :: Copy Data Forecast If current month not exists
        // self::copyDataForecast();
        // End :: Copy Data Forecast If current month not exists

        // begin :: Delete Old Excel Files
        self::deleteOldExcelFiles();
        // end :: Delete Old Excel Files

        // begin :: Check User CCM
        if (Auth::user()->check_admin_kontrak) {
            return redirect("/dashboard-ccm/perolehan-kontrak");
        }
        // end :: Check User CCM

        //begin::History Forecast
        if (!empty($request->get("periode-prognosa")) || !empty($request->get("tahun-history"))) {
            $year = (int) $request->get("tahun-history") ?? (int) date("Y");
            $month = $request->get("periode-prognosa") ?? "";
            $unit_kerja_get = $request->get("unit-kerja") ?? "";
            $dop_get = $request->get("dop") ?? "";
        } else {
            $year = (int) date("Y");
            if ((int)date('d') < 5) {
                $month = (int) date("m") - 1;
            } else {
                $month = (int) date("m");
            }
            $unit_kerja_get = "";
            $dop_get = "";
            // $nilaiHistoryForecast = HistoryForecast::all();
        }
        if ($year == 2021) {
            $month = 12;
        }
        // dump($unit_kerja_get);
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if (Auth::user()->check_administrator) {
            // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->where("history_forecast.tahun", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            // if($nilaiHistoryForecast->count() < 1) {
            //     $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : (int) date("m"))->where("forecasts.tahun", "=", $year)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // }

            $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("history_forecast.tahun", "=", $year)->get();
            $countUnitKerjaFromHistory = $nilaiHistoryForecast->groupBy('unit_kerja')->count();
            if ($nilaiHistoryForecast->count() < 1 || ($countUnitKerjaFromHistory < 11)) {
            // if ($nilaiHistoryForecast->count() < 1 || ($countUnitKerjaFromHistory < 11 && !$nilaiHistoryForecast->every(function ($history) {
            //     return $history->is_approved_1 == true;
            // }))) {
                // if ((int)date('d') < 5 && $month == (int)date('m')) {
                //     $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month - 1)->where("forecasts.tahun", "=", $year)->get();
                // }else{
                // }
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get();
            }
            // dump($nilaiHistoryForecast);
            // $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->get();
            $exceptUnitkerja = ["B", "C", "D", "8", "F", "L", "N", "O", "U"];
            if ($year >= 2023) {
                $unitKerja = UnitKerja::orderBy('unit_kerja')->get()->whereNotIn("divcode", $exceptUnitkerja)->sortBy('id_profit_center');
            } else {
                $unitKerja = UnitKerja::orderBy('unit_kerja')->get()->whereNotIn("divcode", ["B", "C", "D", "8"])->sortBy('id_profit_center');
            }
            // dd($unitKerja);
            $proyeks = Proyek::with(['Forecasts', 'UnitKerja', "SumberDana"])->where("tahun_perolehan", "=", $year)->get();
            $paretoProyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements'])->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.tahun_perolehan", "=", $year)->where("is_cancel", "!=",
                true
            )->get();
            $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->get();
            $dops = Dop::orderBy('dop')->get()?->keyBy('dop')->keys()->sort();
            if (date("Y") >= 2024) {
                $dops = $dops->filter(function ($item) {
                        return $item != "DOP 3";
                    });
            }
            // $dopJoin = Dop::join("proyeks", "dops.dop", "=", "proyeks.dop")->get();
            // dd($dops);
            if (!empty($request->get("unit-kerja"))) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $request->get("unit-kerja"));
                // dump($nilaiHistoryForecast);
                if ($nilaiHistoryForecast->isEmpty()) {
                    $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month)->where("forecasts.tahun", "=", $year)->get()->where('unit_kerja', $request->get("unit-kerja"));
                }
                $claims = $claims->where("unit_kerja", $request->get("unit-kerja"));
                $proyeks = $proyeks->where("unit_kerja", $request->get("unit-kerja"));
                $contracts = $contracts->where("unit_kerja", $request->get("unit-kerja"));
                $paretoProyeks = $paretoProyeks->where("unit_kerja", $request->get("unit-kerja"));
                // dd($nilaiHistoryForecast);
            }
            if (!empty($request->get("dop"))) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->filter(function ($history) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $history->dop != "EA";
                    } else {
                        return $history->dop == $request->get("dop");
                    }
                });
                $claims = $claims->filter(function ($claim) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $claim->dop != "EA";
                    } else {
                        return $claim->dop == $request->get("dop");
                    }
                });
                $proyeks = $proyeks->filter(function ($proyek) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $proyek->dop != "EA";
                    } else {
                        return $proyek->dop == $request->get("dop");
                    }
                });
                $contracts = $contracts->filter(function ($contract) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $contract->dop != "EA";
                    } else {
                        return $contract->dop == $request->get("dop");
                    }
                });
                $paretoProyeks = $paretoProyeks->filter(function ($pareto) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $pareto->dop != "EA";
                    } else {
                        return $pareto->dop == $request->get("dop");
                    }
                });
                // dd($proyeks);
                // dd($nilaiHistoryForecast, $claims, $proyeks, $contracts);
            }
            // dd($unitKerja, Auth::user());
        } else {
            // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->get();
            $proyeks = Proyek::with(['Forecasts', 'UnitKerja', "SumberDana"])->where("tahun_perolehan", "=", $year)->where("jenis_proyek", "!=", "I")->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            $paretoProyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements'])->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.tahun_perolehan", "=", $year)->where("is_cancel", "!=", true)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());

            $exceptUnitkerja = ["B", "C", "D", "8", "F", "L", "N", "O", "U"];
            if ($year >= 2023) {
                $unitKerja = UnitKerja::get()->whereIn("divcode", $unit_kerja_user->toArray())->whereNotIn("divcode", $exceptUnitkerja)->sortBy('id_profit_center');
            } else {
                $unitKerja = UnitKerja::get()->whereIn("divcode", $unit_kerja_user->toArray())->whereNotIn("divcode", ["B", "C", "D", "8"])->sortBy('id_profit_center');
            }
            // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->where("history_forecast.tahun", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            // dd($paretoProyeks->where('stage', 8)->last());

            $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("history_forecast.tahun", "=", $year)->get();
            $countUnitKerjaFromHistory = $nilaiHistoryForecast->groupBy('unit_kerja')->count();

            if (Gate::allows(["admin-crm"])) {
                if ($nilaiHistoryForecast->count() < 1 || $countUnitKerjaFromHistory < 11) {
                    // if ((int)date('d') < 5) {
                    //     $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month - 1)->where("history_forecast.tahun", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    //     if (empty($nilaiHistoryForecast) || $nilaiHistoryForecast->isEmpty()) {
                    //         $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month - 1)->where("forecasts.tahun", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    //     }
                    // }else{
                    // }
                    $nilaiHistoryForecast = Forecast::join("proyeks",
                        "proyeks.kode_proyek",
                        "=",
                        "forecasts.kode_proyek"
                    )->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                }
            } else {
                if ($nilaiHistoryForecast->count() < 1 || !$nilaiHistoryForecast->every(function ($history) {
                    return $history->is_approved_1 == true;
                })) {
                    // if ((int)date('d') < 5) {
                    //     $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month - 1)->where("history_forecast.tahun", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    //     if (empty($nilaiHistoryForecast) || $nilaiHistoryForecast->isEmpty()) {
                    //         $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month - 1)->where("forecasts.tahun", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    //     }
                    // }else{
                    // }
                    $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                }
            }
            


            // dump($nilaiHistoryForecast);
            if (!empty($request->get("unit-kerja"))) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $request->get("unit-kerja"));
                if (empty($nilaiHistoryForecast) || $nilaiHistoryForecast->isEmpty()) {
                    $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month)->where("forecasts.tahun", "=", $year)->get()->where("unit_kerja", $request->get("unit-kerja"));
                }
                $claims = $claims->where("unit_kerja", $request->get("unit-kerja"));
                $proyeks = $proyeks->where("unit_kerja", $request->get("unit-kerja"));
                $contracts = $contracts->where("unit_kerja", $request->get("unit-kerja"));
                $paretoProyeks = $paretoProyeks->where("unit_kerja", $request->get("unit-kerja"));
            } else if (!empty($request->get("dop"))) {
                // $nilaiHistoryForecast = $nilaiHistoryForecast->where("dop", $request->get("dop"));
                // $claims = $claims->where("dop", $request->get("dop"));
                // $proyeks = $proyeks->where("dop", $request->get("dop"));
                // $contracts = $contracts->where("dop", $request->get("dop"));
                // $paretoProyeks = $paretoProyeks->where("dop", $request->get("dop"));

                $nilaiHistoryForecast = $nilaiHistoryForecast->filter(function ($history) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $history->dop != "EA";
                    } else {
                        return $history->dop == $request->get("dop");
                    }
                });
                $claims = $claims->filter(function ($claim) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $claim->dop != "EA";
                    } else {
                        return $claim->dop == $request->get("dop");
                    }
                });
                $proyeks = $proyeks->filter(function ($proyek) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $proyek->dop != "EA";
                    } else {
                        return $proyek->dop == $request->get("dop");
                    }
                });
                $contracts = $contracts->filter(function ($contract) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $contract->dop != "EA";
                    } else {
                        return $contract->dop == $request->get("dop");
                    }
                });
                $paretoProyeks = $paretoProyeks->filter(function ($pareto) use ($request) {
                    if ($request->get("dop") == "PUSAT") {
                        return $pareto->dop != "EA";
                    } else {
                        return $pareto->dop == $request->get("dop");
                    }
                });
                // dd($proyeks);
                // dd($nilaiHistoryForecast, $claims, $proyeks, $contracts);
            } else {
                $nilaiHistoryForecast = $nilaiHistoryForecast->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $claims = $claims->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $proyeks = $proyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $contracts = $contracts->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $paretoProyeks = $paretoProyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
            }
            // } else {
            //     $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $proyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $paretoProyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements'])->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $unitKerja = UnitKerja::where("divcode", "=", Auth::user()->unit_kerja)->get();
            //     // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
            //     $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->get();
            //     // dd($nilaiHistoryForecast, Auth::user());
            // }
            $unit_kerjas = "";
            // $dops = Dop::orderBy('dop')->get();
            $dops = $unitKerja->groupBy('dop')->keys()->sort();
            if (date("Y") >= 2024) {
                if ($dops->count() == 3) {
                    $dops = $dops->push("PUSAT");
                }
            } else {
                if ($dops->count() == 4) {
                    $dops = $dops->push("PUSAT");
                }
            }
            // dd($dops);
        }

        // dd($nilaiHistoryForecast);
        $nilaiForecast = 0;
        $nilaiForecastArray = [];
        $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");
        // dd($historyForecast);

        $nilaiRkapForecast = 0;
        $nilaiRkapArray = [];
        if($year == 2022) {
            $historyRkap = $nilaiHistoryForecast->sortBy("month_rkap");
        } else {
            $historyRkap = $nilaiHistoryForecast->where("is_rkap", "=", true)->sortBy("month_rkap");
        }
        // dd($historyRkap);

        $nilaiRealisasiForecast = 0;
        $nilaiRealisasiArray = [];
        // if (!empty($request->get("periode-prognosa"))){
        //     $historyRealisasi = $nilaiHistoryForecast->where("month_realisasi", "<=", $month)->where("stage", "=", 8)->where("is_cancel", "!=", true)->sortBy("month_realisasi");
        // } else {
            $historyRealisasi = $nilaiHistoryForecast->where("stage", "=", 8)->where("is_cancel", "!=", true)->sortBy("month_realisasi");
        // }

        // dd($historyRealisasi);

        $per = 1000000; //Dibagi Dalam Jutaan

        for (
            $i = 1;
            $i <= 12;
            $i++
        ) {
            foreach ($historyForecast as $forecast) {
                if ($forecast->is_rkap) {
                    //Untuk OK
                    if ($forecast->month_rkap == $i) {
                        $nilaiRkapForecast += (int) $forecast->rkap_forecast / $per;
                    } else {
                        $nilaiRkapForecast == 0;
                    }
                }

                if ($forecast->stage == 8 && !$forecast->is_cancel) {
                    //Untuk Realisasi
                    if ($forecast->month_realisasi == $i && !$forecast->is_cancel && $forecast->month_realisasi <= $month) {
                        $nilaiRealisasiForecast += (int) $forecast->realisasi_forecast / $per;
                    } else {
                        $nilaiRealisasiForecast == 0;
                    }
                }

                //Untuk Forecast
                if (
                    $forecast->month_forecast == $i && !$forecast->is_cancel
                ) {
                    $nilaiForecast += $forecast->nilai_forecast / $per;
                } else {
                    $nilaiForecast == 0;
                }
            }
            array_push($nilaiRkapArray, round($nilaiRkapForecast)); // Array Nilai RKAP Forecast
            array_push($nilaiForecastArray, round($nilaiForecast)); // Array Nilai Forecast
            array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast)); // Array Nilai Realisasi
        }


        // for ($i = 1; $i <= 12; $i++) {
        //     foreach ($historyForecast as $forecast) {
        //         if ($forecast->month_forecast == $i && !$forecast->is_cancel) {
        //             $nilaiForecast += $forecast->nilai_forecast / $per;
        //         } else {
        //             $nilaiForecast == 0;
        //         }
        //     }
        //     // dd();
        //     array_push($nilaiForecastArray, round($nilaiForecast));
        // }

        // for ($i = 1; $i <= 12; $i++) {
        //     foreach ($historyRkap as $rkap) {
        //         if ($rkap->month_rkap == $i) {
        //             $nilaiRkapForecast += (int) $rkap->rkap_forecast / $per;
        //         } else {
        //             // dump($rkap->month_rkap, $rkap->rkap_forecast);
        //             $nilaiRkapForecast == 0;
        //         }
        //     }
        //     array_push($nilaiRkapArray, round($nilaiRkapForecast));
        
        // }
        // for ($i = 1; $i <= 12; $i++) {
        //     foreach ($historyRealisasi as $realisasi) {
        //         if ($realisasi->month_realisasi == $i && !$realisasi->is_cancel && $realisasi->month_realisasi <= $month) {
        //             if ($i == 11) {
        //                 // dump($realisasi);
        //             }
        //             $nilaiRealisasiForecast += (int) $realisasi->realisasi_forecast / $per;
        //         } else {
        //             $nilaiRealisasiForecast == 0;
        //         }
        //     }
        //     array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast));
        // }

        // dump($nilaiRealisasiArray);
        // dd($nilaiRealisasiArray);


        // begin :: Tri Wulan
        $nilaiForecastTriwulan = 0;
        $nilaiForecastTriwunalArray = [];

        $offset_history = 0;
        for ($i = 3; $i <= 12; $i += 3) {
            $filtered_history_forecast = $historyForecast->filter(function ($data) use ($i, $offset_history) {
                return  $data->month_forecast > $offset_history && $data->month_forecast <= $i;
            });
            $nilaiForecastTriwulan += $filtered_history_forecast->sum("nilai_forecast");
            // dump($filtered_history_forecast->all());
            array_push($nilaiForecastTriwunalArray, $nilaiForecastTriwulan);
            $offset_history = $i;
        }
        // end :: Tri Wulan

        // Begin :: Nilai Realisasi Unit Kerja
        $kategoriunitKerja = [];
        $nilaiOkKumulatif = [];
        $nilaiRealisasiKumulatif = [];
        if (!empty($request->get("unit-kerja"))) {
            $unitKerja_nilai_OK = $unitKerja->where("divcode", $request->get("unit-kerja"))->first();
            $nilaiOk = 0;
            $nilaiRealisasi = 0;
            array_push($kategoriunitKerja, $unitKerja_nilai_OK->unit_kerja);
            // dump($kategoriunitKerja);
            foreach ($unitKerja_nilai_OK->proyeks as $proyekUnit) {
                foreach ($proyekUnit->Forecasts as $f) {
                    $nilaiOk += (int) str_replace(",", "", ($f->rkap_forecast));
                    if (!$f->is_cancel) {
                        $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                    }
                }
            }
            array_push($nilaiOkKumulatif, round($nilaiOk));
            array_push($nilaiRealisasiKumulatif, round($nilaiRealisasi));
        } else if (!empty($request->get("dop"))) {
            $unitKerja_nilai_OK = $proyeks->where("dop", $request->get("dop"))->groupBy("unit_kerja");
            // dd($unitKerja_nilai_OK);
            foreach ($unitKerja_nilai_OK as $key => $proyekUnit) {
                $divcode = UnitKerja::where("divcode", "=", $key)->get()->first();
                array_push($kategoriunitKerja, $divcode->unit_kerja);
                // dd($kategoriunitKerja);
                $nilaiOk = 0;
                $nilaiRealisasi = 0;
                foreach ($proyekUnit as $proyekDOP) {
                    // dump($nilai);
                    foreach ($proyekDOP->Forecasts as $f) {
                        $nilaiOk += (int) str_replace(",", "", ($f->rkap_forecast));
                        if (!$f->is_cancel) {
                            $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                        }
                    }
                    // $nilaiOk += (int) str_replace(",", "", ($nilai->nilai_rkap / $per));
                    // $nilaiRealisasi += (int) str_replace(",", "", ($nilai->nilai_perolehan / $per));
                }
                array_push($nilaiOkKumulatif, round($nilaiOk));
                array_push($nilaiRealisasiKumulatif, round($nilaiRealisasi));
            }
            // dd($kategoriunitKerja, $nilaiOkKumulatif, $nilaiRealisasiKumulatif);
            // dd();
            // dump($kategoriunitKerja);
        } else {
            // dd($unitKerja);
            foreach ($unitKerja as $unit) {
                // dump($unit->proyeks);
                array_push($kategoriunitKerja, $unit->unit_kerja);
                $nilaiOk = 0;
                $nilaiRealisasi = 0;
                foreach ($unit->proyeks as $proyekUnit) {
                    foreach ($proyekUnit->Forecasts as $f) {
                        $nilaiOk += (int) str_replace(",", "", ($f->rkap_forecast));
                        if (!$f->is_cancel) {
                            $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                        }
                    }
                }
                array_push($nilaiOkKumulatif, round($nilaiOk));
                array_push($nilaiRealisasiKumulatif, round($nilaiRealisasi));
            }
        }
        // dd($nilaiOkKumulatif);

        // End :: Nilai Realisasi Unit Kerja

        // $proyeks_test = Proyek::all()->whereIn("unit_kerja", ["O", "U"])->whereIn("stage", [1, 2, 4, 5])->count();

        //begin:: Monitoring Proyek
        $proses = 0;
        $menang = 0;
        $kalah = 0;
        $cancel = 0;
        $perolehan = 0;
        $prakualifikasi = 0;
        $tidakLulusPQ = 0;
        $terkontrakMonitoring = 0;
        foreach ($proyeks as $p) {
            if ($p->tipe_proyek == 'P' && $p->jenis_proyek != "I") {
                if ($p->is_cancel) {
                    $cancel++;
                }
                $stg = $p->stage;
                if ($stg == 1 || $stg == 2) {
                    // $proses++;
                } else if ($stg == 3 && (!$p->is_tidak_lulus_pq && !$p->is_cancel)) {
                    $prakualifikasi++;
                } else if ($stg == 4 && (!$p->is_tidak_lulus_pq && !$p->is_cancel)) {
                    $proses++;
                } else if ($stg == 5 && (!$p->is_tidak_lulus_pq && !$p->is_cancel)) {
                    $perolehan++;
                } else if ($stg == 6 && (!$p->is_tidak_lulus_pq && !$p->is_cancel)) {
                    $menang++;
                } else if ($stg == 7) {
                    $kalah++;
                } elseif ($stg == 3 && ($p->is_tidak_lulus_pq)) {
                    $tidakLulusPQ++;
                } elseif ($stg == 8 && (!$p->is_tidak_lulus_pq && !$p->is_cancel)) {
                    $terkontrakMonitoring++;
                } else {
                    // $menang++;  
                };
            }
        };

        // Begin :: CHART PROYEK KALAH - CANCEL - TIDAK LULUS PQ
        $proyek_kalah_cancel_tidak_lulus_pq = collect();
        $proyek_kalah_cancel_tidak_lulus_pq->push($proyeks->where("stage", 7)->count()); // Kalah
        $proyek_kalah_cancel_tidak_lulus_pq->push($proyeks->where("stage", 0)->count()); // Tidak Lulus PQ
        $proyek_kalah_cancel_tidak_lulus_pq->push($proyeks->where("is_cancel", true)->count()); // Cancel
        // End :: CHART PROYEK KALAH - CANCEL - TIDAK LULUS PQ


        //Begin::Terendah Terkontrak
        $nilaiTerkontrak = 0;
        $nilaiTerendah = 0;

        $nilaiProyekTerkontrak = $nilaiHistoryForecast->where("stage", "=", 8)->where("is_cancel", "=", false);
        $nilaiProyekTerendah = $nilaiHistoryForecast->filter(function ($p) {
            return ($p->stage == 6 || ($p->stage == 5 && $p->peringkat_wika == "Peringkat 1") || $p->stage == 9);
        })->where("is_cancel", "=", false);
        // $nilaiProyekTerendah = $proyeks->where("is_cancel", "=", false)->where("stage", "!=", 7);
        foreach ($nilaiProyekTerkontrak as $t) {
            // if ($realisasi->month_realisasi == $i && !$forecast->is_cancel) {
            // dump($realisasi->realisasi_forecast);
            if (!empty($t->month_realisasi)) {
                $nilaiTerkontrak += (int) $t->realisasi_forecast;
            }
            // } else {
            //     $nilaiRealisasiForecast == 0;
            // }
        }
        foreach ($nilaiProyekTerendah as $t) {
            // if ($realisasi->month_realisasi == $i && !$forecast->is_cancel) {
            // dump($realisasi->realisasi_forecast);
            if (!empty($t->month_forecast)) {
                $nilaiTerendah += (int) $t->nilai_forecast;
                // dd($nilaiProyekTerendah);
            }
            // } else {
            //     $nilaiRealisasiForecast == 0;
            // }
        }
        $nilaiTerkontrak = $nilaiTerkontrak / $per;
        $nilaiTerendah = $nilaiTerendah / $per;
        //End::Terendah Terkontrak

        //Begin::Competitive Index
        $jumlahMenang = 0;
        $jumlahTerkontrakCompetitive = 0;
        $jumlahKalah = 0;
        $jumlahTidakLulusPQ = 0;
        $nilaiMenang = 0;
        $nilaiTerkontrakCompetitive = 0;
        $nilaiKalah = 0;
        $nilaiTidakLulusPQ = 0;
        foreach ($proyeks->where('is_cancel', '!=', true) as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 6) {
                if ($proyek->tipe_proyek == "P" && $proyek->nilai_perolehan != 0 && $proyek->jenis_proyek != "I" && !$proyek->is_tidak_lulus_pq) {
                    $jumlahMenang++;
                    // $nilaiMenang += (int)$proyek->nilai_perolehan != 0 ? (int)$proyek->nilai_perolehan * ($proyek->porsi_jo / 100) : 0;
                    $nilaiMenang += (int)$proyek->nilai_perolehan;
                }
            } else if ($stg == 7) {
                if ($proyek->tipe_proyek == "P" && $proyek->nilai_perolehan != 0 && $proyek->jenis_proyek != "I" && !$proyek->is_tidak_lulus_pq) {
                    $jumlahKalah++;
                    // $nilaiKalah += (int)$proyek->nilai_perolehan != 0 ? (int)$proyek->nilai_perolehan * ($proyek->porsi_jo / 100) : 0;
                    $nilaiKalah += (int)$proyek->nilai_perolehan;
                }
            } else if ($stg == 3 && $proyek->is_tidak_lulus_pq) {
                if ($proyek->tipe_proyek == "P" && $proyek->nilai_perolehan != 0 && $proyek->jenis_proyek != "I") {
                    $jumlahTidakLulusPQ++;
                    // $nilaiTidakLulusPQ += (int)$proyek->nilai_perolehan != 0 ? (int)$proyek->nilai_perolehan * ($proyek->porsi_jo / 100) : 0;
                    $nilaiTidakLulusPQ += (int)$proyek->hps_pagu;
                }
            } else if ($stg == 8) {
                if ($proyek->tipe_proyek == "P" && $proyek->jenis_proyek != "I" && !$proyek->is_tidak_lulus_pq) {
                    $jumlahTerkontrakCompetitive++;
                    $nilaiTerkontrakCompetitive += (int)$proyek->nilai_perolehan;
                }
            };
        };
        // if (Auth::user()->check_administrator) {
        //     dd($nilaiTerkontrakCompetitive);
        // }
        $sumProyekCompetitive = $proyeks->where(
            'is_cancel',
            '!=',
            true
        )->where(
            "is_tidak_lulus_pq",
            false
        )->where(
            'jenis_proyek',
            '!=',
            "I"
        )->whereIn("stage", [6, 7, 8])->count();
        $sumNilaiProyekCompetitive = $proyeks->where('is_cancel', '!=', true)->where('is_tidak_lulus_pq', '!=', true)->where('jenis_proyek', '!=', "I")->whereIn("stage", [6, 7, 8])->sum('nilai_perolehan');
        if ($sumProyekCompetitive > 0) {
            $winRateJumlahCompetitive = round(($jumlahMenang + $jumlahTerkontrakCompetitive) / $sumProyekCompetitive, 2) * 100;
        } else {
            $winRateJumlahCompetitive = 0;
        }
        if ($sumNilaiProyekCompetitive > 0) {
            $winRateNilaiCompetitive = round(($nilaiMenang + $nilaiTerkontrakCompetitive) / $sumNilaiProyekCompetitive, 2) * 100;
        } else {
            $winRateNilaiCompetitive = 0;
        }
        //End::Competitive Index

        //begin::Marketing PipeLine
        $prosesTender = 0;
        $terkontrak = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg < 5) {
                $prosesTender++;
            } else if ($stg == 7) {
                continue;
            } else {
                if (empty($proyek->ContractManagements)) {
                    $terkontrak++;
                }
            };
        };
        $pelaksanaan = 0;
        $serahTerima = 0;
        $closing = 0;
        foreach ($contracts as $contract) {
            $stg = $contract->stages;
            if ($stg <= 3) {
                $pelaksanaan++;
            } else if ($stg < 5) {
                $serahTerima++;
            } else {
                $closing++;
            };
        };
        //end::Marketing PipeLine

        // Begin :: menghitung total dari status dan jenis claim
        $claim_status_array = [];
        $claim_cancel = $claims->where("stages", "=", "5")->where("jenis_claim", "=", "Claim")->count();
        $claim_disetujui = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Claim")->count();
        $claim_ditolak = $claims->where("stages", "=", "6")->where("jenis_claim", "=", "Claim")->count();
        $claim_on_progress = $claims->where("stages", "<=", "3")->where("jenis_claim", "=", "Claim")->count();
        array_push($claim_status_array, $claim_cancel, $claim_disetujui, $claim_ditolak, $claim_on_progress);
        // End :: menghitung total dari status dan jenis claim

        // Begin :: menghitung total dari status dan jenis anti claim
        $anti_claim_status_array = [];
        $anti_claim_cancel = $claims->where("stages", "=", "5")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_disetujui = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_ditolak = $claims->where("stages", "=", "6")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_on_progress = $claims->where("stages", "<=", "3")->where("jenis_claim", "=", "Anti Claim")->count();
        array_push($anti_claim_status_array, $anti_claim_cancel, $anti_claim_disetujui, $anti_claim_ditolak, $anti_claim_on_progress);
        // End :: menghitung total dari status dan jenis anti claim

        // Begin :: menghitung total dari status dan jenis claim asuransi
        $claim_asuransi_status_array = [];
        $claim_asuransi_cancel = $claims->where("stages", "=", "5")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_disetujui = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_ditolak = $claims->where("stages", "=", "6")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_on_progress = $claims->where("stages", "<=", "3")->where("jenis_claim", "=", "Claim Asuransi")->count();
        array_push($claim_asuransi_status_array, $claim_asuransi_cancel, $claim_asuransi_disetujui, $claim_asuransi_ditolak, $claim_asuransi_on_progress);
        // End :: menghitung total dari status dan jenis claim asuransi

        //begin::Pareto
        $paretoRealisasi = $paretoProyeks->where('stage', '=', 8);
        $totalNilaiRealisasiPareto = 0;
        $realisasiForecast = $paretoRealisasi->map(function ($pp) use (&$totalNilaiRealisasiPareto, $month, $year, $countUnitKerjaFromHistory) {
            $classRi = new stdClass();
            $history_forecasts = $pp->HistoryForecasts?->where("periode_prognosa", "=", $month)?->where("tahun", "=", $year);
            $countGroupUnitKerjaHistoryForecast = !empty($history_forecasts) ? $countUnitKerjaFromHistory : 0;
            if (!empty($history_forecasts) && ($history_forecasts->count() > 0 && $countGroupUnitKerjaHistoryForecast == 11)) {
                $classRi->realisasi_forecast = $pp->HistoryForecasts->where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->sum(function ($f) use ($month) {
                    if ($f->month_realisasi <= $month) {
                        return (int) $f->realisasi_forecast;
                    }
                });
                if ($pp->tipe_proyek == 'P') {
                    $classRi->month_realisasi = $pp->HistoryForecasts->where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->max(function ($f) {
                        return (int) $f->month_realisasi;
                    });
                } else {
                    // $classRi->month_realisasi = $month;
                    $classRi->month_realisasi = $pp->HistoryForecasts->where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->where('realisasi_forecast', '!=', null)->where('realisasi_forecast', '!=', '0')->min(function ($f) {
                        if ($f != null) {
                            return (int) $f->month_realisasi;
                        }
                    });
                }
            } else {
                $classRi->realisasi_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->where('month_realisasi', '!=', null)->sum(function ($f) {
                    return (int) $f->realisasi_forecast;
                });
                if ($pp->tipe_proyek == "P") {
                    $classRi->month_realisasi = $pp->Forecasts->where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->where('month_realisasi', '!=', null)->max(function ($f) {
                        return (int) $f->month_realisasi;
                    });
                } else {
                    // $classRi->month_realisasi = $month;
                    $classRi->month_realisasi = $pp->Forecasts->where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->where('realisasi_forecast', '!=', null)->where('realisasi_forecast', '!=', '0')->min(function ($f) {
                        // dump($f);
                        if ($f != null) {
                            return (int) $f->month_realisasi;
                        }
                    });
                }
                
            }
            $classRi->unit_kerja = $pp->UnitKerja->unit_kerja;
            $classRi->stage = $pp->stage;
            $classRi->nama_proyek = $pp->nama_proyek;
            $classRi->kode_proyek = $pp->kode_proyek;
            $classRi->tipe_proyek = $pp->tipe_proyek;
            $classRi->bulan_pelaksanaan = $pp->bulan_pelaksanaan;
            $totalNilaiRealisasiPareto += (int) $classRi->realisasi_forecast;
            return $classRi;
        })->filter(function ($pp) {
            return $pp->realisasi_forecast != 0;
        });
        $realisasiForecast = $realisasiForecast->sortByDesc("realisasi_forecast");

        // $paretoProyek = $proyeks->sortByDesc('forecast');
        $sisaProyek = $paretoProyeks;
        $totalNilaiSisaPareto = 0;
        if ($month == date('m') && date('d') < 5) {
            $month_select = $month - 1;
        } else {
            $month_select = $month;
        }
        $sisaForecast = $sisaProyek->map(function ($pp) use (&$totalNilaiSisaPareto, $month_select, $year, $countUnitKerjaFromHistory) {
            $class = new stdClass();
            // if ($pp->stage != 8) {
            $history_forecasts = $pp->HistoryForecasts?->where("periode_prognosa", "=", $month_select)?->where("tahun", "=", $year);
            $countGroupUnitKerjaHistoryForecast = !empty($history_forecasts) ? $countUnitKerjaFromHistory : 0;
            if (!empty($history_forecasts) && ($history_forecasts->count() > 0 && $countGroupUnitKerjaHistoryForecast == 11)) {
                //if tipe proyek R / P
                //ketika tipe proyek P => tambah stage != 8
                //ketika R stage == 8

                $class->nilai_forecast = 0;
                if ($pp->tipe_proyek == 'P') {
                    $class->nilai_forecast = $pp->HistoryForecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->sum(function ($f) {

                        if ($f->stage != 8) {
                            return (int) $f->nilai_forecast;
                        }
                    });
                    $class->month_forecast = $pp->HistoryForecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->max(function ($f) {
                        return (int) $f->month_forecast;
                    });

                    $class->stage = $pp->HistoryForecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->first()->stage;
                } elseif ($pp->tipe_proyek == 'R') {
                    $class->nilai_forecast = $pp->HistoryForecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->sum(function ($f) use ($month_select) {
                        if ($f->month_forecast > $month_select) {
                            return (int) $f->nilai_forecast;
                        }
                    });
                    $class->month_forecast = $pp->HistoryForecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->max(function ($f) {
                        return (int) $f->month_forecast;
                    });
                    $class->stage = $pp->stage;
                }
            } else {
                $class->nilai_forecast = 0;
                if ($pp->tipe_proyek == 'P' && $pp->stage != 8) {
                    $class->nilai_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->where('month_forecast', '!=', null)->sum(function ($f) {
                        return (int) $f->nilai_forecast;
                    });
                    $class->month_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->where('month_forecast', '!=', null)->max(function ($f) {
                        return (int) $f->month_forecast;
                    });
                } elseif ($pp->tipe_proyek == 'R') {
                    $class->nilai_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->where('month_forecast', '!=', null)->sum(function ($f) use ($month_select) {
                        // if ($f->month_forecast >= $month) {
                        //     return (int) $f->nilai_forecast;
                        // }
                        if ($month_select == 12
                        ) {
                            if ($f->month_forecast == 12) {
                                $total_sisa = (int) $f->nilai_forecast - (int)$f->realisasi_forecast;
                                if ($total_sisa < 0) {
                                    return 0;
                                } else {
                                    return $total_sisa;
                                }
                            }
                        } else {
                            if ($f->month_forecast > $month_select) {
                                return (int) $f->nilai_forecast - $f->realisasi_forecast;
                            }
                        }
                    });

                    $class->month_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month_select)->where("tahun", "=", $year)->where('month_forecast', '!=', null)->max(function ($f) {
                            return (int) $f->month_forecast;
                        });
                }
                $class->stage = $pp->stage;
            }
            $class->unit_kerja = $pp->UnitKerja->unit_kerja;
            // $class->stage = $pp->stage;
            $class->nama_proyek = $pp->nama_proyek;
            $class->kode_proyek = $pp->kode_proyek;
            $class->tipe_proyek = $pp->tipe_proyek;
            $class->bulan_pelaksanaan = $pp->bulan_pelaksanaan;
            // }
            $totalNilaiSisaPareto += (int) $class->nilai_forecast;

            return $class;
        })->filter(function ($pp) {
            return $pp->nilai_forecast != 0;
        });
        $sisaForecast = $sisaForecast->sortByDesc("nilai_forecast");
        // $totalNilaiSisaPareto = $totalNilaiSisaPareto_all - $totalNilaiRealisasiPareto;
        // dump($totalNilaiSisaPareto);
        // dump($totalNilaiRealisasiPareto);
        // dd($realisasiForecast->sum('realisasi_forecast'));
        // dd($sisaForecast);
        $paretoClaim = $claims->where("jenis_claim", "=", "Claim")->groupBy("kode_proyek");
        $paretoAntiClaim = $claims->where("jenis_claim", "=", "Anti Claim")->groupBy("kode_proyek");
        $paretoAsuransi = $claims->where("jenis_claim", "=", "Claim Asuransi")->groupBy("kode_proyek");

        // $paretoClaim = ClaimManagements::sortable()->join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("jenis_claim", "=", "Claim")->get()->groupBy("kode_proyek");
        // $paretoClaim = ClaimManagements::sortable()->get();
        // $paretoAntiClaim = ClaimManagements::sortable()->where("jenis_claim", "=", "Anti Claim")->get()->groupBy("kode_proyek");
        // $paretoAsuransi = ClaimManagements::sortable()->where("jenis_claim", "=", "Claim Asuransi")->get()->groupBy("kode_proyek");
        //end::Pareto




        // dd($top_proyeks_close_this_month);

        //begin:: Marketing Pipeline
        $pasarDini = 0;
        $pasarPotensial = 0;
        $stagePrakualifikasi = 0;
        $stageTender = 0;
        $stagePerolehan = 0;
        $stageMenang = 0;
        $stageKalah = 0;
        $stageTerkontrak = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 1) {
                $pasarDini++;
            } else if ($stg == 2) {
                $pasarPotensial++;
            } else if ($stg == 3) {
                $stagePrakualifikasi++;
            } else if ($stg == 4) {
                $stageTender++;
            } else if ($stg == 5) {
                $stagePerolehan++;
            } else if ($stg == 6) {
                $stageMenang++;
            } else if ($stg == 7) {
                $stageKalah++;
            } else if ($stg == 8) {
                $stageTerkontrak++;
            } else {
                // 
            };
        };
        //end:: Marketing Pipeline
        // Begin :: Table Proyek Teratas yang akan tutup bulan ini
        $top_proyeks_close_this_month = $proyeks->where("bulan_ri_perolehan", "=", (int) date("m") - 2)->where("tahun_ri_perolehan", "=", (int) date("Y"))->where("stage", "=", 8)->sortByDesc("nilai_perolehan")->values();
        // End :: Table Proyek Teratas yang akan tutup bulan ini

        // Begin :: SUMBER DANA RKAP
        $totalRKAPSumberDana = collect();
        $total_RKAP_keseluruhan = 0;
        $proyeksGroupBySumberDana = $proyeks->filter(function ($p) {
            return !empty($p->SumberDana->kategori) && $p->tipe_proyek != "R";
        })->groupBy(function ($p) {
            return $p->SumberDana->kategori;
        });
        $proyeksGroupBySumberDanaRetail = $proyeks->filter(function ($p) {
            return $p->tipe_proyek == "R";
        })->groupBy(function ($p) {
            return $p->tipe_proyek;
        });

        $proyeksGroupBySumberDana = $proyeksGroupBySumberDana->mergeRecursive($proyeksGroupBySumberDanaRetail);
        foreach ($proyeksGroupBySumberDana as $sumber_dana => $proyeks_sumber_dana) {
            $total_rkap = 0;
            if($sumber_dana == "R") {
                $sumber_dana = "Retail";
            }
            // $sumber_dana_model = SumberDana::
            foreach ($proyeks_sumber_dana as $proyek) {
                if($proyek->tipe_proyek == "R") {
                    $total_rkap += (int) round($proyek->Forecasts->filter(function($f) use($month, $year) {
                        return $f->periode_prognosa == $month && $f->tahun == $year;
                    })->sum(function($f) {
                        return (int) $f->rkap_forecast;
                    }) / $per);
                } else {
                    $total_rkap += (int) round($proyek->nilai_rkap / $per);
                }
                // $total_RKAP_keseluruhan += (int) $proyek->nilai_rkap / $per;
            }
            $total_RKAP_keseluruhan += $total_rkap;
            $totalRKAPSumberDana->push([
                "name" => $sumber_dana,
                "y" => round($total_rkap, 2),
            ]);
        }
        $totalRKAPSumberDana = $totalRKAPSumberDana->map(function ($item) use ($total_RKAP_keseluruhan) {
            // $nilai_persen = (int) Percentage::fromFractionAndTotal($item["y"], $total_RKAP_keseluruhan)->asFloat();
            $nilai_persen = $total_RKAP_keseluruhan != 0 ? round($item["y"] / $total_RKAP_keseluruhan * 100, 2) : 0;
            $item["x"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["name"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["y"] = $nilai_persen;
            return $item;
        });
        // End :: SUMBER DANA RKAP

        // Begin :: SUMBER DANA REALISASI
        $totalRealisasiSumberDana = collect();
        $total_realisasi_keseluruhan = 0;
        foreach ($proyeksGroupBySumberDana as $sumber_dana => $proyeks_sumber_dana) {
            $total_realisasi = 0;
            // dd($proyeks_sumber_dana->first());
            $proyeks_sumber_dana = $proyeks_sumber_dana->where('stage', '=', 8); 
            if($sumber_dana == "R") {
                $sumber_dana = "Retail";
            }
            foreach ($proyeks_sumber_dana as $proyek) {
                $total_realisasi += (int) $proyek->nilai_perolehan / $per;
                $total_realisasi_keseluruhan += (int) $proyek->nilai_perolehan / $per;
            }
            // $totalRealisasiSumberDana->push([
            //     "name" => $sumber_dana . ": " . (int) Percentage::fromFractionAndTotal($total_realisasi, $total_realisasi_keseluruhan)->asFloat(). "%",
            //     "y" => (int) Percentage::fromFractionAndTotal($total_realisasi, $total_realisasi_keseluruhan)->asFloat(),
            //     "x" => $sumber_dana . ": " . (int) Percentage::fromFractionAndTotal($total_realisasi, $total_realisasi_keseluruhan)->asFloat(). "%",
            // ]);
            $totalRealisasiSumberDana->push([
                "name" => $sumber_dana,
                "y" => (int) round($total_realisasi, 2),
            ]);
        }
        $totalRealisasiSumberDana = $totalRealisasiSumberDana->map(function ($item) use ($total_realisasi_keseluruhan) {
            // $nilai_persen = (int) Percentage::fromFractionAndTotal($item["y"], $total_realisasi_keseluruhan)->asFloat();
            $nilai_persen = $total_realisasi_keseluruhan != 0 ? round($item["y"] / $total_realisasi_keseluruhan * 100, 2) : 0;
            $item["x"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["name"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["y"] = round($nilai_persen, 2);
            return $item;
        });
        // dump($month);
        // End :: SUMBER DANA REALISASI

        // Begin :: INSTANSI OWNER RKAP
        $totalRKAPInstansiOwner = collect();
        $total_RKAP_instansi_all = 0;
        $categoryInstansiOwner = collect(["BUMN", "Pemerintah", "Swasta"]);

        $proyeksFilterHasOwner = $proyeks->filter(function ($proyek) {
            return !empty($proyek->proyekBerjalan?->customer);
        });

        $proyeksInstansiOwnerGroupChange = $proyeksFilterHasOwner->map(function ($proyek) {
            if (str_contains($proyek->proyekBerjalan?->customer->jenis_instansi, "BUMN")) {
                $proyek->instansi_owner = "BUMN";
            } elseif (str_contains($proyek->proyekBerjalan?->customer->jenis_instansi, "Swasta")) {
                $proyek->instansi_owner = "Swasta";
            } else {
                $proyek->instansi_owner = "Pemerintah";
            }
            return $proyek;
        })->groupBy('instansi_owner');

        // $proyekInstansiNewRKAP = $proyeksInstansiOwnerGroupChange->each(function ($proyek_instansi, $key) use ($per, $month, $year, &$total_RKAP_instansi_all, $totalRKAPInstansiOwner, $categoryInstansiOwner) {
        //     $total_rkap = 0;
        //     // foreach ($proyek_instansi as $proyek) {
        //     //     if ($proyek->tipe_proyek == "R") {
        //     //         $total_rkap += (int) round($proyek->Forecasts->filter(function ($f) use ($month, $year) {
        //     //             return $f->periode_prognosa == $month && $f->tahun == $year;
        //     //         })->sum(function ($f) {
        //     //             return (int) $f->rkap_forecast;
        //     //         }) / $per);
        //     //     } else {
        //     //         $total_rkap += (int) round($proyek->nilai_rkap / $per);
        //     //     }
        //     // }
        //     // $total_RKAP_instansi_all += $total_rkap;
        //     // $totalRKAPInstansiOwner->push([
        //     //     'name' => $key,
        //     //     'y' => (int) round($total_rkap)
        //     // ]);

        //     $total_RKAP_instansi_all += $proyek_instansi->count();
        //     $totalRKAPInstansiOwner->push([
        //         'name' => $key,
        //         'y' => $proyek_instansi->count()
        //     ]);
        // });
        $categoryInstansiOwner->each(function ($value) use (&$total_RKAP_instansi_all, $totalRKAPInstansiOwner, $proyeksInstansiOwnerGroupChange) {
            if ($proyeksInstansiOwnerGroupChange->has($value)) {
                $total_RKAP_instansi_all += $proyeksInstansiOwnerGroupChange[$value]->count();
                $totalRKAPInstansiOwner->push([
                    'name' => $value,
                    'y' => $proyeksInstansiOwnerGroupChange[$value]->count()
                ]);
            } else {
                $totalRKAPInstansiOwner->push([
                    'name' => $value,
                    'y' => 0
                ]);
            }
        });

        $proyeksInstansiRKAPPie = $totalRKAPInstansiOwner->map(function ($item) use ($total_RKAP_instansi_all) {
            // $nilai_persen = ($total_RKAP_instansi_all != 0) ? (int) Percentage::fromFractionAndTotal(
            //     $item["y"],
            //     $total_RKAP_instansi_all
            // )->asFloat() : 0;
            $nilai_persen = $total_RKAP_instansi_all != 0 ? round($item["y"] / $total_RKAP_instansi_all * 100, 2) : 0;
            $item["x"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["name"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["y"] = $nilai_persen;
            return $item;
        });
        // End :: INSTANSI OWNER RKAP

        // Begin :: INSTANSI OWNER RKAP (Lanjutan dari atas)
        $totalRealisasiInstansiOwner = collect();
        $total_realisasi_instansi_all = 0;
        // $proyekInstansiNewRealisasi = $proyeksInstansiOwnerGroupChange->each(function ($proyek_instansi, $key) use ($per, &$total_realisasi_instansi_all, $totalRealisasiInstansiOwner) {
        //         // $total_realisasi = 0;

        //         $proyekRealisasiInstansis = $proyek_instansi->where(
        //             'stage',
        //             8
        //         );
        //         // foreach ($proyekRealisasiInstansis as $proyek) {
        //         //     $total_realisasi += (int) $proyek->nilai_perolehan / $per;
        //         //     $total_realisasi_instansi_all += (int) $proyek->nilai_perolehan / $per;
        //         // }
        //         // $totalRealisasiInstansiOwner->push([
        //         //     'name' => $key,
        //         //     'y' => (int) round($total_realisasi),
        //         // ]);

        //         $total_realisasi_instansi_all += $proyekRealisasiInstansis->count();

        //         $totalRealisasiInstansiOwner->push([
        //             'name' => $key,
        //             'y' => $proyekRealisasiInstansis->count(),
        //         ]);
        //     });
        $categoryInstansiOwner->each(function ($value) use (&$total_realisasi_instansi_all, $totalRealisasiInstansiOwner, $proyeksInstansiOwnerGroupChange) {
            if ($proyeksInstansiOwnerGroupChange->has($value)) {
                $total_realisasi_instansi_all += $proyeksInstansiOwnerGroupChange[$value]->where('stage', 8)->count();
                $totalRealisasiInstansiOwner->push([
                    'name' => $value,
                    'y' => $proyeksInstansiOwnerGroupChange[$value]->where('stage', 8)->count()
                ]);
            } else {
                $totalRealisasiInstansiOwner->push([
                    'name' => $value,
                    'y' => 0
                ]);
            }
        });
        $proyeksInstansiRealisasiPie = $totalRealisasiInstansiOwner->map(function ($item) use ($total_realisasi_instansi_all) {
            // $nilai_persen = ($total_realisasi_instansi_all != 0) ? (int) Percentage::fromFractionAndTotal(
            //     $item["y"],
            //     $total_realisasi_instansi_all
            // )->asFloat() : 0;
            $nilai_persen = $total_realisasi_instansi_all != 0 ? round($item["y"] / $total_realisasi_instansi_all * 100, 2) : 0;
            $item["x"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["name"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["y"] = $nilai_persen;
            return $item;
        });
        // dd($proyeksInstansiRKAPPie, $proyeksInstansiRealisasiPie);
        // End :: INSTANSI OWNER RKAP
        return view('1_Dashboard', compact([
            "totalNilaiSisaPareto",
            "totalNilaiRealisasiPareto",
            "realisasiForecast",
            "sisaForecast",
            "pasarDini",
            "pasarPotensial",
            "stagePrakualifikasi",
            "stageTender",
            "stagePerolehan",
            "stageMenang",
            "stageKalah",
            "stageTerkontrak",
            "top_proyeks_close_this_month",
            "proyek_kalah_cancel_tidak_lulus_pq",
            "totalRealisasiSumberDana",
            "totalRKAPSumberDana",
            "claim_status_array",
            "anti_claim_status_array",
            "claim_asuransi_status_array",
            "nilaiForecastArray",
            "nilaiRkapArray",
            "nilaiRealisasiArray",
            "nilaiForecastTriwunalArray",
            "year",
            "month",
            "proses",
            "menang",
            "kalah",
            "prakualifikasi",
            "prosesTender",
            "terkontrak",
            "pelaksanaan",
            "serahTerima",
            "closing",
            "proyeks",
            "paretoClaim",
            "paretoAntiClaim",
            "paretoAsuransi",
            "kategoriunitKerja",
            "nilaiOkKumulatif",
            "nilaiRealisasiKumulatif",
            "nilaiTerkontrak",
            "nilaiTerendah",
            "jumlahMenang",
            "jumlahKalah",
            "nilaiMenang",
            "nilaiKalah",
            "unitKerja",
            "unit_kerja_get",
            "dop_get",
            "dops",
            "nilaiTerkontrakCompetitive",
            "jumlahTerkontrakCompetitive",
            "winRateJumlahCompetitive",
            "winRateNilaiCompetitive",
            "proyeksInstansiRKAPPie",
            "proyeksInstansiRealisasiPie",
            "cancel",
            "tidakLulusPQ",
            "terkontrakMonitoring",
            "jumlahTidakLulusPQ",
            "nilaiTidakLulusPQ",
            "perolehan"
        ]));
    }

    public function dashboard_perolehan_kontrak(Request $request)
    {

        // $dop_get = $request->query("dop") ?? "";
        // $unit_kerja_get = $request->query("unit-kerja") ?? "";
        // $tahun_get = $request->query("tahun") ?? (int) date("Y");
        // $bulan_get = $request->query("bulan") ?? (int) date("m");
        // $dops = Dop::whereNotIn("dop", ["EA", "PUSAT"])->get();
        // if($tahun_get < 2023) {
        //     $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N", "P", "J"])->get();
        //     $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N", "P", "J"])->get();
        // } else {
        //     $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N", "L", "F", "U", "O"])->get();
        //     $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N", "L", "F", "U", "O"])->get();
        // }
        // // dd(Proyek::whereIn("unit_kerja", $unit_kerjas_all->toArray())->get());
        // if(!empty($dop_get)) {
        //     $unit_kerjas = $unit_kerjas_all->where("dop", "=", $dop_get);
        // } else {
        //     $unit_kerjas = $unit_kerjas_all;
        // }

        // if ($dop_get != "") {
        //     $proyeks = $proyeks->filter(function ($p) use ($dop_get) {
        //         return $p->Dop->dop == $dop_get;
        //     });
        // } else if ($unit_kerja_get) {
        //     $proyeks = $proyeks->filter(function ($p) use ($unit_kerja_get) {
        //         return $p->UnitKerja->divcode == $unit_kerja_get;
        //     });
        // }

        $dop_select = $request->query("dop") ?? "";
        $unit_kerja_select = $request->query("unit-kerja") ?? "";
        $tahun_get = $request->query("tahun") ?? (int) date("Y");
        $bulan_get = $request->query("bulan") ?? "";
        $proyek_get = $request->query("kode-proyek") ?? "";
        $dops = Dop::whereNotIn("dop", [
            "EA", "PUSAT", "DOP 3"
        ])->get("dop");
        $year = date("Y");
        $month = date("m");

        $tahun = Proyek::get()->groupBy("tahun_perolehan")->keys();

        if (Auth::user()->check_administrator || Auth::user()->is_pic) {
            // $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",",Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        // dd($mounth);
        // $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
        // $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();
        
        
        if($tahun_get < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
        } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->get();
        }
        } else {
            $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // dd($mounth);
            // $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
            // $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();


            if ($tahun_get < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
            } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
            }
        }
        // dd($unit_kerjas_all);
        // $unit_kerja_get = !empty($request->query("unit-kerja")) ? [$request->query("unit-kerja")] : $unit_kerjas_all->toArray();
        // $dop_get = !empty( $request->query("dop")) ? [ $request->query("dop") ] : $dops->toArray();
        // dd($dop_get);

        if ($dop_select) {
            $dop_get = [$request->query("dop")];
            $unit_kerja_get = [$unit_kerjas->where("dop", "=", $dop_select)->value("divcode")];
            $unit_kerjas =   $unit_kerjas->where("dop", "=", $dop_select);
        } else {
            $dop_get = $dops->toArray();
            $unit_kerja_get = $unit_kerjas_all->toArray();
            // dd($unit_kerja_get);
        }

        // dd($dop_get, $unit_kerja_get);
        $unit_kerja_get = !empty($request->query("unit-kerja")) ? [$request->query("unit-kerja")] : $unit_kerjas_all->map(function ($item) {
            return $item->divcode;
        })->toArray();

        if (!empty($bulan_get) && $tahun_get == 2023) {
            $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->get();
            $contract_proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->where("stage",
                '!=',
                1
            )->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=",
                "P"
            )->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true)->get();
        } else {
            if ($tahun_get < 2023 && $bulan_get) {
                $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->get();
                $contract_proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true)->get();
            } elseif ($tahun_get < 2023 && empty($bulan_get)) {
                $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->get();
                $contract_proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true)->get();
            } else {
                $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("tipe_proyek", "=", "P")->get();
                $contract_proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->where("stage", '!=', 1)->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->where("is_cancel", "!=", true)->where("is_tidak_lulus_pq", "!=", true)->get();
                // dd("tess");
            }
        }

        // dd($contract_proyeks);


        //2022 - 2023
        // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->whereIn("stage", [2,3,4,5,6,7,8])->whereIn("dop", $dop_get)->where("tipe_proyek", "=", "P")->get();
        //     // dd($proyeks_all);
        //     $proyeks_filter = collect();
            
        //     if(!empty($bulan_get)){
        //         $time = Carbon::createFromFormat("m Y", "$bulan_get $tahun_get");
        //         // dd($time);
        //     }else{
        //         $time = Carbon::now();
        //     }
        //     foreach(range(1,12) as $item){
        //         $proyeks_check = collect();
        //         if(!empty($bulan_get)){
        //             // $proyeks_check = $proyeks_all->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
        //             $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
        //         }else{
        //             $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", 12);
        //         }
        //         // dump($time, (int)$time->format("Y"), (int)$time->format("m"), $proyeks_filter);
        //         $time = $time->subMonth(1);
        //         if($proyeks_all->isNotEmpty()){
        //             $proyeks_filter->push($proyeks_check);
        //         }
        //         // dd($proyeks_all);
        //     }

        //     $proyeks = $proyeks_filter->flatten()->unique()->filter(function($item) use($tahun_get){
        //         if($tahun_get == 2022){
        //             return $item->tahun_perolehan != 2023;
        //         }else{
        //             return $item;
        //         }
        //     });

        


        // Begin :: Kontrak Berdasarkan Stage Chart
        $on_going_counter = $proyeks->where(function ($p) {
            return $p->stage < 6 && !$p->is_cancel;
            // dd($p->ContractManagements);
        })->count();
        // $win_counter = $proyeks->where(function ($p) {
        //     return ($p->stage == 8 && $p->stage == 6 ) && !$p->is_cancel && !$p->is_tidak_lulus_pq;
        //     // dd($p->ContractManagements);
        // })->count();
        $win_counter = $proyeks->where("is_cancel", "!=", true)->whereIn("stage", [6, 8, 9])->count();
        // dd($proyeks);
        $lose_counter = $proyeks->where(function ($p) {
            // return !empty($p->ContractManagements) && $p->ContractManagements->stage < 3;
            return $p->stage == 7 && !$p->is_cancel;
            // dd($p->ContractManagements);
        })->count();
        $cancel_counter = $proyeks->where(function ($p) {
            // return !empty($p->ContractManagements) && $p->ContractManagements->stage <b 3;
            return $p->is_cancel == true;
            // dd($p->ContractManagements);
        })->count();
        $kontrak_by_stage = collect([
            ["On-going ". "<b>" . Percentage::fromFractionAndTotal($on_going_counter, $proyeks->count())->asString() . "</b>", $on_going_counter],
            ["Win "."<b>" . Percentage::fromFractionAndTotal($win_counter, $proyeks->count())->asString() . "</b>", $win_counter],
            ["Lose "."<b>" . Percentage::fromFractionAndTotal($lose_counter, $proyeks->count())->asString() . "</b>", $lose_counter],
            ["Cancel "."<b>" . Percentage::fromFractionAndTotal($cancel_counter, $proyeks->count())->asString() . "</b>", $cancel_counter],
        ]);
        // End :: Kontrak Berdasarkan Stage Chart

        // Begin :: Kontrak Berdasarkan Divisi Chart
        $divisi = collect();
        $divisi_counter = $proyeks->groupBy("unit_kerja");
        $divisi_counter = $divisi_counter->map(function ($p, $key) use($proyeks) {
            return collect([preg_replace("/[a-z]|[ ]|[&]/", "", UnitKerja::find($key)->unit_kerja) ." "."<b>" . Percentage::fromFractionAndTotal($p->count(), $proyeks->count())->asString() . "</b>", $p->count()]);
        });
        $divisi_counter->each(function ($p) use ($divisi) {
            $divisi->push($p);
        });
        // End :: Kontrak Berdasarkan Divisi Chart

        // Begin :: Klasifikasi Kontrak Chart
        // $klasifikasi_kontrak = collect();
        // $klasifikasi_kontrak_counter = $proyeks->groupBy("unit_kerja");
        // $klasifikasi_kontrak_counter = $klasifikasi_kontrak_counter->map(function($p, $key) {
        //     return collect([preg_replace("/[a-z][^0-9]|[ ]/", "", UnitKerja::find($key)->divisi), $p->count()]);
        // });
        // $klasifikasi_kontrak_counter->each(function($p) use($divisi) {
        //     $divisi->push($p);
        // });
        // End :: Klasifikasi Kontrak Chart

        // Begin :: Kontrak Berdasarkan JO dan Non-JO Chart
        $JO_Non_JO_counter = $proyeks;
        $JO_counter = $JO_Non_JO_counter->where("jenis_proyek", "=", "J")->count();
        $Non_JO_counter = $JO_Non_JO_counter->where("jenis_proyek", "!=", "J")->count();
        $JO_Non_JO_counter = collect(
            [["JO "."<b>" . Percentage::fromFractionAndTotal($JO_counter, $proyeks->count())->asString() . "</b>", $JO_counter], 
            ["Non-JO "."<b>" . Percentage::fromFractionAndTotal($Non_JO_counter, $proyeks->count())->asString() . "</b>", $Non_JO_counter]]);
        // End :: Kontrak Berdasarkan JO dan Non-JO Chart

        // Begin :: Nilai Tender Chart
        // $nilai_tender_proyeks = $contract_proyeks->groupBy("unit_kerja");
        // $nilai_tender_proyeks = $nilai_tender_proyeks->map(function ($p, $key) use($proyeks) {
        //     $nilai_tender = $p->sum(function ($s) {
        //         return (int) $s->nilai_perolehan;
        //     });
        //     return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
        //     // return ["name" => UnitKerja::find($key)->unit_kerja." "."<b>" . Percentage::fromFractionAndTotal($nilai_tender, $proyeks->count())->asString() . "</b>", "y" => $nilai_tender];
        // })->values();

        $unit_kerja_tender = $unit_kerjas_all->groupBy("divcode")->keys();
        // dd($unit_kerja_tender);
        $nilai_tender_proyeks = $contract_proyeks->whereIn('stage', [2, 3, 4, 5, 6])->groupBy("unit_kerja");
        // dd($nilai_tender_proyeks, $proyeks);
        $nilai_tender_proyeks = $unit_kerja_tender->map(function ($p) use ($nilai_tender_proyeks) {
                // dump($p);
                $result = collect();
                foreach ($nilai_tender_proyeks as $key => $ukt) {
                    // dump($key);
                    // $nilai_tender = $ukt->sum(function($s){
                    //     return (int) $s->nilai_perolehan;
                    // });
                    $sum = 0;
                    if ($p == $key
                    ) {
                        $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => $sum += $ukt->flatten()->sum("nilai_perolehan"), "urut" => UnitKerja::find($p)->nomor_unit];
                        // dd($p == $ukt);
                    } else {
                        if (!empty($result[$p])) {
                            $data = $result[$p];
                            $data["name"] = $data["name"];
                            $data["y"] = $data["y"];
                            $data["urut"] = $data["urut"];
                            // dump("tes");
                        } else {
                            $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => 0, "urut" => UnitKerja::find($p)->nomor_unit];
                        }
                    }
                }

                return $result;
                // $nilai_tender = $p->sum(function ($s) {
                //     return (int) $s->nilai_perolehan;
                // });
                // return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
            })->flatten(1)->sortBy("urut")->values();
        // End :: Nilai Tender Chart

        // Begin :: Success Rate
        $jumlahMenang = $proyeks->where("stage", 6)->where("jenis_proyek", "!=", "I")->where("is_cancel", false)->where("is_tidak_lulus_pq", false)->count();
        $jumlahTerkontrak = $proyeks->where("stage", 8)->where("jenis_proyek", "!=", "I")->where("is_cancel", false)->where("is_tidak_lulus_pq", false)->count();
        $sumProyekCompetitive = $proyeks->whereIn("stage", [6, 7, 8])->where(
            "jenis_proyek",
            "!=",
            "I"
        )->where("is_cancel", false)->where("is_tidak_lulus_pq", false)->count();
        $success_rate = $sumProyekCompetitive > 0 ? round(($jumlahMenang + $jumlahTerkontrak) / $sumProyekCompetitive, 2) * 100 : 0;
        // $success_rate = (int) Percentage::fromFractionAndTotal($win_counter, $proyeks->count())->asFloat();
        // End :: Success Rate

        // Begin :: Clasification Column
        $cadangan = 0;
        $sasaran = 0;
        $potensial = 0;
        $naTender = 0;
        foreach ($proyeks as $key => $p) {
            // dd($p->status_pasar);
            if ($p->status_pasdin == "Cadangan") {
                $cadangan += 1;
            } else if ($p->status_pasdin == "Sasaran") {
                $sasaran += 1;
            }else if ($p->status_pasdin == "Potensial") {
                $potensial += 1;
            } else {
                $naTender += 1;
            }
        }
        $klasifikasi_tender = collect([
            ["Sasaran " . "<b>" . Percentage::fromFractionAndTotal($cadangan, $proyeks->count())->asString() . "</b>", $cadangan],
            ["Cadangan " . "<b>" . Percentage::fromFractionAndTotal($sasaran, $proyeks->count())->asString() . "</b>", $sasaran],
            ["Potensi " . "<b>" . Percentage::fromFractionAndTotal($potensial, $proyeks->count())->asString() . "</b>", $potensial],
            ["NA " . "<b>" . Percentage::fromFractionAndTotal($naTender, $proyeks->count())->asString() . "</b>", $naTender],
        ]);
        // End :: Clasification Column
        // Begin :: Tender Status Column
        // End :: Tender Status Column

        $jumlahKontrak = $contract_proyeks->whereIn('stage', [2, 3, 4, 5, 6])->count();
        $contract_proyeks_all = $contract_proyeks->map(function ($proyek) {
            return $proyek->ContractManagements;
        });
        // $tender_review = $contract_proyeks->map(function($contract){
        //     $data = $contract->reviewProjects->map(function($item){
        //         return $item;
        //     });
        //     return $data;
        // })->flatten()->groupBy("id_contract")->count();
        // $tender_review = $contract_proyeks->map(function($contract){
        //     return $contract->reviewProjects;
        // })->groupBy("id_contract")->count();
        $tender_review = $contract_proyeks_all->map(function ($contract) {
                return $contract->uploadFinal->where("category", "=", "tinjauan-perolehan");
            })->flatten()->count();

        // dd($tender_review);

        return view("1_Dashboard_ccm_perolehan_kontrak", compact(["klasifikasi_tender", "bulan_get", "unit_kerjas_all", "tahun_get", "tahun", "jumlahKontrak", "cadangan", "sasaran", "naTender", "potensial", "cancel_counter", "lose_counter", "win_counter", "on_going_counter", "proyeks", "dops", "unit_kerjas", "dop_get", "unit_kerja_get", "kontrak_by_stage", "divisi", "JO_Non_JO_counter", "nilai_tender_proyeks", "success_rate", "tender_review", "dop_select", "unit_kerja_select", "contract_proyeks"]));
    }

    public function dashboard_pelaksanaan_kontrak(Request $request)
    {
        $dop_select = $request->query("dop") ?? "";
        $unit_kerja_select = $request->query("unit-kerja") ?? "";
        $tahun_get = $request->query("tahun") ?? (int) date("Y");
        $bulan_get = $request->query("bulan") ?? "";
        $proyek_get = $request->query("kode-proyek") ?? "";
        $dops = Dop::whereNotIn("dop", ["EA", "PUSAT", "DOP 3"])->get("dop");
        $year = date("Y");
        $month = date("m");

        if (Auth::user()->check_administrator || Auth::user()->is_pic) {
            // $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",",Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        // dd($mounth);
        // $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
        // $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();
        
        
        if($tahun_get < 2023) {
            $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N", "P", "J"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
        } else {
            $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->get();
        }
        } else {
            $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // dd($mounth);
            // $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
            // $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();


            if ($tahun_get < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
            } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
            }
        }

        // dd($unit_kerjas_all);
        // $unit_kerja_get = !empty($request->query("unit-kerja")) ? [$request->query("unit-kerja")] : $unit_kerjas_all->toArray();
        // $dop_get = !empty( $request->query("dop")) ? [ $request->query("dop") ] : $dops->toArray();

        if ($dop_select && $unit_kerja_select) {
            $dop_get = [$request->query("dop")];
            $unit_kerja_get = [$request->query("unit-kerja")];
        } else if ($dop_select) {
            $dop_get = [$request->query("dop")];
            $unit_kerja_get = $unit_kerjas->where("dop", "=", $dop_select)->map(function ($item) {
                return $item->divcode;
            })->values();
            $unit_kerjas =   $unit_kerjas->where("dop", "=", $dop_select);
            // dd($dop_get, $unit_kerja_get);
        } else if ($unit_kerja_select) {
            $dop_get = $dops->toArray();
            $unit_kerja_get = [$request->query("unit-kerja")];
        } else {
            $dop_get = $dops->toArray();
            $unit_kerja_get = $unit_kerjas_all->toArray();
        }

        // dd($dop_get, $unit_kerja_get);
        // $unit_kerja_get = !empty($request->query("unit-kerja")) ? [$request->query("unit-kerja")] : $unit_kerjas_all->toArray();

        // if (!empty($bulan_get) && $tahun_get == 2023) {
        //     $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->get();
        // } else {
        //     if ($tahun_get < 2023 && $bulan_get) {
        //         $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->get();
        //     } elseif ($tahun_get < 2023 && empty($bulan_get)) {
        //         $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->get();
        //     } else {
        //         $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->get();
        //     }
        // }

        if (!empty($bulan_get) && $tahun_get >= 2023) {
            $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("start_year", "<=", $tahun_get)->where("stages", 2)->whereIn("kd_divisi", $unit_kerja_get)->get();
        } else {
            if ($tahun_get < 2023 && $bulan_get) {
                $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("start_year", "<=", $tahun_get)->where("stages", 2)->whereIn("kd_divisi", $unit_kerja_get)->get();
            } elseif ($tahun_get < 2023 && empty($bulan_get)) {
                $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("start_year", "<=", $tahun_get)->where("stages", 2)->whereIn("kd_divisi", $unit_kerja_get)->get();
            } else {
                $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("start_year", "<=", $tahun_get)->where("stages", 2)->whereIn("kd_divisi", $unit_kerja_get)->get();
            }
        }
        

        //2022 - 2023
        // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->whereIn("stage", [8,9])->whereIn("dop", $dop_get)->where("tipe_proyek", "=", "P")->get();
        // // dd($proyeks_all);
        // $proyeks_filter = collect();

        // if(!empty($bulan_get)){
        //     $time = Carbon::createFromFormat("m Y", "$bulan_get $tahun_get");
        //     // dd($time);
        // }else{
        //     $time = Carbon::now();
        // }
        // foreach(range(1,12) as $item){
        //     $proyeks_check = collect();
        //     if(!empty($bulan_get)){
        //         // $proyeks_check = $proyeks_all->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
        //         $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
        //     }else{
        //         $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", 12);
        //     }
        //     // dump($time, (int)$time->format("Y"), (int)$time->format("m"), $proyeks_check);
        //     $time = $time->subMonth(1);
        //     if($proyeks_all->isNotEmpty()){
        //         $proyeks_filter->push($proyeks_check);
        //     }
        //     // dd($proyeks_all);
        // }
        // // dd($proyeks_filter->flatten()->unique());

        // $proyeks = $proyeks_filter->flatten()->unique()->filter(function($item) use($tahun_get){
        //     if($tahun_get == 2022){
        //         return $item->tahun_perolehan != 2023;
        //     }else{
        //         return $item;
        //     }
        // });


        // $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6,8,9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "=", $bulan_get)->where("tipe_proyek", "=", "P")->where("stages", "=", 2)->get();
        // $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6,8,9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->get();
        // dd($proyeks);

        // dd($proyeks_filter, $tahun_get, $bulan_get);

        $tahun = Proyek::all()->groupBy(["tahun_perolehan"])->keys();
        // dd($get_proyek);
        // $tahun = $get_proyek->groupBy("tahun_perolehan")->keys();
        // $bulan = $get_proyek->groupBy("bulan_pelaksanaan")->keys();
        
        // if(!empty($tahun_get)){
        //     $proyeks = $proyeks->where("tahun_perolehan", "=", $tahun_get);
        //     // dump($tahun_get, $proyeks); 
        // }else{
        //     $proyeks = $proyeks->where("tahun_perolehan", "=", $year);
        // }

        // if(!empty($bulan_get)){
        //     $proyeks = $proyeks->where("bulan_pelaksanaan", "=", $bulan_get);
        //     // dump($tahun_get, $proyeks); 
        // }else{
        //     $proyeks = $proyeks->where("bulan_pelaksanaan", "=", $month);
        // }

        // if(!empty($dop_get)) {
        //     $unit_kerjas = $unit_kerjas_all->where("dop", "=", $dop_get);
        // } else {
        //     $unit_kerjas = $unit_kerjas_all;
        // }

        // if ($dop_get != "") {
        //     $proyeks = $proyeks->filter(function ($p) use ($dop_get) {
        //         return $p->Dop->dop == $dop_get;
        //     });
        // } else if ($unit_kerja_get) {
        //     $proyeks = $proyeks->filter(function ($p) use ($unit_kerja_get) {
        //         return $p->UnitKerja->divcode == $unit_kerja_get;
        //     });
        // }
        
        // $dops = Dop::whereNotIn("dop", ["EA", "PUSAT"])->get();
        // $proyeks = $proyeks->filter(function ($p) {
        //     return !empty($p->ContractManagements);
        // });
        
        // dd($proyeks);
        $proyek_get = $request->query("kode-proyek") ?? "";
        // $contracts_all = ContractManagements::all();
        $contracts_all = ContractManagements::where("stages", 2)->get();

        // $contracts_pelaksanaan = $proyeks->map(function($item){
        //     return $item->ContractManagements;
        // })->where("stages", "=", 2)->values();

        // $proyekPISNew = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->whereIn("kd_divisi", $unit_kerja_get)->where('contract_managements.stages', '>', 1)->where('contract_managements.profit_center', '!=', null)->where('start_year', '<=', $tahun_get)->get();

        // $contract_pelaksanaan_new = $proyeks->where('stages', '>', 1)->map(function ($item) {
        $contract_pelaksanaan_new = $proyeks->where('stages', 2)->map(function ($item) {
            return $item->ContractManagements;
        });

        // dd($contract_pelaksanaan_new);
        // dd(collect($unit_kerja_get)->flatten());

        if (!empty($proyek_get)) {
            // $proyek = Proyek::where("kode_proyek", "=", $proyek_get)->first();
            $proyek = ProyekPISNew::where("profit_center", "=", $proyek_get)->first();
            // dd($proyek);
            // $claims = ClaimManagements::where("kode_proyek", "=", $proyek_get)->get();
            // $kategori_kontrak = PerubahanKontrak::where("id_contract", "=", $proyek->ContractManagements->id_contract)->get();
            $kategori_kontrak = PerubahanKontrak::where("profit_center", "=", $proyek->profit_center)->get();
            // dd($kategori_kontrak);    
            // dd($contracts_pelaksanaan);

            // Begin :: Changes Overview
            $detail_perubahan_kontrak = $kategori_kontrak->groupBy("jenis_perubahan")->map(function ($kategori, $key) use ($proyek) {
                $pengajuan = $kategori->sum(function ($c) {
                    return (int) $c->biaya_pengajuan; 
                });
                $persen = Percentage::fromFractionAndTotal($pengajuan, $proyek->contract_value_idr)->asString();
                // $persen = (float) $pengajuan * 100 / ((float) $proyek->nilai_perolehan == null ? 1 : $proyek->nilai_perolehan);
                $potensial = 0;
                $subs = 0;
                $revisi = 0;
                $nego = 0;
                $setuju = 0;
                $tidak = 0;
                $dispute = 0;
                foreach ($kategori as $k) {
                    if ($k->stage == 1) {
                        $potensial += 1;
                    } else if ($k->stage == 2) {
                        $subs += 1;
                    } else if ($k->stage == 3) {
                        $revisi += 1;
                    } else if ($k->stage == 4) {
                        $nego += 1;
                    } else if ($k->stage == 5) {
                        $setuju += 1;
                    } else if ($k->stage == 6 && $k->is_dispute == false) {
                        $tidak += 1;
                    } else {
                        $dispute += 1;
                    }
                }
                return [$key, $kategori->count(), $pengajuan, $persen, $potensial, $subs, $revisi, $nego, $setuju, $tidak, $dispute];
            })->values();
            // dd($detail_perubahan_kontrak);

            // $totalKontrakFull = $proyeks->map(function ($p) {
            //     return $p->ContractManagements;
            // })->sum("value");
            $totalKontrakFull = $proyeks->sum("contract_value_idr");
            $total_pengajuan = $proyek->PerubahanKontrak?->sum("biaya_pengajuan");
            if (!empty($proyek->contract_value_idr) && !empty($total_pengajuan)) {
                $persentasePerubahan = Percentage::fromFractionAndTotal($total_pengajuan, $proyek->contract_value_idr)->asString();
            } else {
                $persentasePerubahan = 0;
            }
            // dd($persentasePerubahan);
            // End :: Changes Overview

            //Begin::CCM STATUS
            $kategori = collect(["VO", "Klaim", "Anti Klaim", "Klaim Asuransi"]);
            // dd($contract_pelaksanaan_new->map(function($item){return $item->PerubahanKontrak;}));
            $contracts_perubahan = $kategori_kontrak;
            // dd($contracts_perubahan);
            if (!empty($contracts_perubahan->toArray())) {
                $cat_kontrak = $kategori->map(function ($p) use ($contracts_perubahan) {
                    $result = collect();
                    $counter = 0;
                    $potensial = 0;
                    $potensial_value = 0;
                    $subs = 0;
                    $subs_value = 0;
                    $revisi = 0;
                    $revisi_value = 0;
                    $nego = 0;
                    $nego_value = 0;
                    $setuju = 0;
                    $setuju_value = 0;
                    $tolak = 0;
                    $tolak_value = 0;
                    $dispute = 0;
                    $dispute_value = 0;
                    $nilai = 0;

                    // $data = $result[];
                    $result["jenis_perubahan"] = $p;
                    $filterJenisPerubahan = $contracts_perubahan->filter(function ($item) use ($p) {
                        return $item->jenis_perubahan == $p;
                    });

                    $result["potensial"] = $filterJenisPerubahan->count();
                    $result["potensial_value"] = $filterJenisPerubahan->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterSubs = $filterJenisPerubahan->filter(function ($subs) {
                        return $subs->stage >= 2;
                    });

                    $result["subs"] = $filterSubs->count();
                    $result["subs_value"] = $filterSubs->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterRevision = $filterJenisPerubahan->filter(function ($revisi) {
                        return $revisi->stage == 3;
                    });

                    $result["revisi"] = $filterRevision->count();
                    $result["revisi_value"] = $filterRevision->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterNego = $filterJenisPerubahan->filter(function ($nego) {
                        return $nego->stage == 4;
                    });

                    $result["nego"] = $filterNego->count();
                    $result["nego_value"] = $filterNego->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterApprove = $filterJenisPerubahan->filter(function ($setuju) {
                        return $setuju->stage == 5;
                    });

                    $result["setuju"] = $filterApprove->count();
                    $result["setuju_value"] = $filterApprove->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->nilai_disetujui;
                        } else {
                            $nilai += (int)$item->nilai_disetujui;
                        }

                        return $nilai;
                    });

                    $filterTolak = $filterJenisPerubahan->filter(function ($tolak) {
                        return $tolak->stage == 6 && $tolak->is_dispute == false;
                    });

                    $result["tolak"] = $filterTolak->count();
                    $result["tolak_value"] = $filterTolak->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterDispute = $filterJenisPerubahan->filter(function ($dispute) {
                        return $dispute->stage == 6 && $dispute->is_dispute == true;
                    });

                    $result["dispute"] = $filterDispute->count();
                    $result["dispute_value"] = $filterDispute->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    // return $data;
                    // foreach($contracts_perubahan as $cp) {
                    //     // $qualified_kontrak = collect();
                    //     if(!empty($cp->jenis_perubahan)){
                    //         // dd($result);
                    //         if($cp->jenis_perubahan == $p) {
                    //             // dd("true");
                    //             if(!empty($result[$p])) {
                    //                 $data = $result[$p];
                    //                 // dump($setuju);
                    //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //                 $data["total_item"] = $data["total_item"] + 1;
                    //                 if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                     $data["total_nilai"] = $data["total_nilai"] - $cp->biaya_pengajuan;
                    //                 } else {
                    //                     $data["total_nilai"] = $data["total_nilai"] + $cp->biaya_pengajuan;
                    //                 }
                    //                 if($cp->stage == 1){
                    //                     $data["potensial"] = $data["potensial"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["potensial_value"] = $data["potensial_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["potensial_value"] = $data["potensial_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 2){
                    //                     $data["subs"] = $data["subs"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["subs_value"] = $data["subs_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["subs_value"] = $data["subs_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 3){
                    //                     $data["revisi"] = $data["revisi"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["revisi_value"] = $data["revisi_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["revisi_value"] = $data["revisi_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 4){
                    //                     $data["nego"] = $data["nego"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["nego_value"] = $data["nego_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["nego_value"] = $data["nego_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 5){
                    //                     $data["setuju"] = $data["setuju"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["setuju_value"] = $data["setuju_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["setuju_value"] = $data["setuju_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 6 && $cp->is_dispute == false){
                    //                     $data["tolak"] = $data["tolak"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["tolak_value"] = $data["tolak_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["tolak_value"] = $data["tolak_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }else{
                    //                     $data["dispute"] = $data["dispute"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["dispute_value"] = $data["dispute_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["dispute_value"] = $data["dispute_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }
                    //                 // dump($data);
                    //                 $result[$p] = $data ;
                    //                 // dump($potensial);
                    //             } else {
                    //                 if($cp->stage == 1){
                    //                     $potensial += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $potensial_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $potensial_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 2){
                    //                     $subs += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $subs_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $subs_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 3){
                    //                     $revisi += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $revisi_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $revisi_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 4){
                    //                     $nego += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $nego_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $nego_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 5){
                    //                     $setuju += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $setuju_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $setuju_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 6 && $cp->is_dispute == false){
                    //                     $tolak += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $tolak_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $tolak_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }else{
                    //                     $dispute += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $dispute_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $dispute_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }
                    //                 $result[$p] = ["jenis_perubahan" => $p, "total_item" => ++$counter, "total_nilai" => $nilai += $cp->biaya_pengajuan, "potensial"=>$potensial, "subs" => $subs, "revisi" => $revisi, "nego" => $nego, "setuju" => $setuju, "tolak" => $tolak, "dispute" => $dispute, "potensial_value"=>$potensial_value, "subs_value" => $subs_value, "revisi_value" => $revisi_value, "nego_value" => $nego_value, "setuju_value" => $setuju_value, "tolak_value" => $tolak_value, "dispute_value" => $dispute_value];
                    //             }
                    //         } else {
                    //             if(!empty($result[$p])) {
                    //                 $data = $result[$p];
                    //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //                 $data["total_item"] = $data["total_item"] + 1;
                    //                 $data["total_nilai"] = $data["total_nilai"];
                    //                 // dump($data);
                    //             } else {
                    //                 $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "potensial" => 0, "subs" => 0, "revisi" => 0, "nego" => 0, "setuju" => 0, "tolak" => 0, "dispute" => 0, "potensial_value" => 0, "subs_value" => 0, "revisi_value" => 0, "nego_value" => 0, "setuju_value" => 0, "tolak_value" => 0, "dispute_value" => 0];
                    //             }
                    //         }
                    //         // foreach($cp->PerubahanKontrak as $pk) {
                    //         //     if($pk->jenis_perubahan == $p) {
                    //         //         $result[$p] = ["jenis_perubahan" => $p, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                    //         //     } else {
                    //         //         if(!empty($result[$p])) {
                    //         //             $data = $result[$p];
                    //         //             $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //         //             $data["total_item"] = $data["total_item"];
                    //         //             $data["total_nilai"] = $data["total_nilai"];
                    //         //         } else {
                    //         //             $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0];
                    //         //         }
                    //         //     }
                    //         //     // dump($pk->jenis_perubahan == $p);
                    //         // }
                    //         // dump($result);
                    //     }else{
                    //         $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "potensial" => 0, "subs" => 0, "revisi" => 0, "nego" => 0, "setuju" => 0, "tolak" => 0, "dispute" => 0, "potensial_value" => 0, "subs_value" => 0, "revisi_value" => 0, "nego_value" => 0, "setuju_value" => 0, "tolak_value" => 0, "dispute_value" => 0];
                    //     }
                    // }
                    return $result;
                })->values();
                // dd($perubahan);
                // $cat_kontrak = $perubahan->map(function($p, $key) use($perubahan, $totalKontrakFull) {
                //     $data = $perubahan[$key]->first();
                //     // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                //     // $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                //     return $data;
                // })->values();
                // dd($cat_kontrak);
                $perubahan_total = $cat_kontrak->sum('total_nilai');
                // $kategori_kontrak = $perubahan->groupBy("jenis_perubahan")->map(function($item, $key) use ($totalKontrakFull){
                //     $biaya_total = (int) $item->sum('biaya_pengajuan');
                //     $persentase_kategori = (float) $biaya_total * 100 / (float) $totalKontrakFull;
                //     return[$key, $item->count(), $biaya_total, number_format($persentase_kategori, 2)];
                // })->values();
                // dd($kategori_kontrak);
            } else {
                $perubahan_total = 0;
                $perubahan = $kategori->map(function ($item) use ($contract_pelaksanaan_new) {
                    $result = collect();
                    $counter = 0;
                    $nilai = 0;
                    // foreach($contracts_pelaksanaan as $cp) {
                    //     // $qualified_kontrak = collect();

                    //     foreach($cp->PerubahanKontrak as $pk) {
                    //         if($pk->jenis_perubahan == $item) {
                    //             $result[$item] = ["jenis_perubahan" => $item, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                    //         } else {
                    //             if(!empty($result[$item])) {
                    //                 $data = $result[$item];
                    //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //                 $data["total_item"] = $data["total_item"];
                    //                 $data["total_nilai"] = $data["total_nilai"];
                    //             } else {
                    //             }
                    //         }
                    //     }
                    // }
                    $result[$item] = ["jenis_perubahan" => $item, "total_item" => 0, "total_nilai" => 0];
                    return $result;
                });
                $cat_kontrak = $perubahan->map(function ($p, $key) use ($perubahan, $totalKontrakFull) {
                    $data = $perubahan[$key]->first();
                    // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                    $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                    return $data;
                })->values();
                $perubahan_total = $cat_kontrak->sum('total_nilai');
            }
            // dd($cat_kontrak);
            if (!empty($totalKontrakFull)) {
                $persentasePerubahan = Percentage::fromFractionAndTotal($perubahan_total, $totalKontrakFull)->asString();
            } else {
                $persentasePerubahan = 0;
            }
            //End::CCM STATUS
            
            $jumlahKontrak = 0;
            $totalKontrak = 0;
            $totalPersen = 0;
            foreach ($kategori_kontrak as $key => $k) {
                $jumlahKontrak += (int) $k[1] ;
                $totalKontrak += (int) $k[2] ;
                $totalPersen += (float) $k[3] ;
            }


            $total_changes = $kategori_kontrak->count();
            $changes_overview = $kategori_kontrak->groupBy("jenis_perubahan")->map(function ($c, $key) use ($total_changes) {
                return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($c->count(), $total_changes)->asString() . "</b>", $c->count()];
            })->values();
            // dd($changes_overview);

            // Begin :: Changes Status
            // $change_status = $proyeks->map(function($item){
            //     return PerubahanKontrak::where("id_contract", "=", $item->ContractManagements->id_contract)->get();
            // });
            // dd($kategori_kontrak);
            $change_status = $kategori_kontrak->map(function ($pcs) {
                // dd($pcs);
                $new_class = new stdClass;
                if ($pcs->stage == 1) {
                    $new_class->perubahan = "Draft";
                } else if ($pcs->stage == 2) {
                    $new_class->perubahan = "Sub";
                } else if ($pcs->stage == 3) {
                    $new_class->perubahan = "Revisi";
                } else if ($pcs->stage == 4) {
                    $new_class->perubahan = "Negosiasi";
                } else if ($pcs->stage == 5) {
                    $new_class->perubahan = "Approve";
                } else if ($pcs->stage == 6 && $pcs->is_dispute == true) {
                    $new_class->perubahan = "Dispute";
                } else if ($pcs->stage == 6) {
                    $new_class->perubahan = "Reject";
                };
                return $new_class;
            });
            // dd($change_status);
            $change_status_out = $change_status->groupBy("perubahan")->map(function ($p, $key) use ($change_status) {
                // dump($p);
                return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $change_status->count())->asString() . "</b>", $p->count()];
            })->values();


            $potensial_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage >= 1;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $submission_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage >= 2;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $revision_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 3;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $negotiation_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 4;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $approve_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 5;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $dispute_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 6 && $cp->is_dispute == true;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $reject_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 6;
            })->groupBy('jenis_perubahan')->flatten()->count();



            // $potensial_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 1;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $submission_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 2;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $revision_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 3;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $negotiation_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 4;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $approve_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 5;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $reject_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 6;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $dispute_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 6 && $cp->is_dispute == true;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');
            $potensial_total_value = 0;

            $submission_total_value = 0;

            $revision_total_value = 0;

            $negotiation_total_value = 0;

            $approve_total_value = 0;

            $reject_total_value = 0;

            $dispute_total_value = 0;

            foreach ($cat_kontrak as $ck) {
                $potensial_total_value += $ck["potensial_value"] ?? 0;

                $submission_total_value += $ck["subs_value"] ?? 0;

                $revision_total_value += $ck["revisi_value"] ?? 0;

                $negotiation_total_value += $ck["nego_value"] ?? 0;

                $approve_total_value += $ck["setuju_value"] ?? 0;

                $reject_total_value += $ck["tolak_value"] ?? 0;

                $dispute_total_value += $ck["dispute_value"] ?? 0;
            }




            // $tanggal_awal = new DateTime($proyek->tanggal_mulai_terkontrak);
            // $tanggal_akhir = new DateTime($proyek->tanggal_akhir_terkontrak);
            $tanggal_awal = new DateTime($proyek->start_date);
            $tanggal_akhir = new DateTime($proyek->finish_date);
            $date_now = new DateTime();

            $diff_1 = $date_now->diff($tanggal_awal);
            $diff_2 = $tanggal_akhir->diff($tanggal_awal);
            $time_status = Percentage::fromFractionAndTotal((int)$diff_1->format("%a"), (int)$diff_2->format("%a"))->asString();
            // dd($diff_1->format("%a"),$diff_2->format("%a"),$time_status);

            // $total_potensial = $kategori_kontrak->where("stage", "=", 1)->count();
            $total_potensial = $kategori_kontrak->count();
            // $total_sub = $kategori_kontrak->where("stage", "=", 2)->count();
            $total_sub = $kategori_kontrak->where("stage", ">=", 2)->count();
            $total_approve_reject = $kategori_kontrak->whereIn("stage", [5, 6])->count();

            $total_sub_value = $kategori_kontrak->where("stage", ">=", 2)->sum("biaya_pengajuan");
            $total_approve_value = $kategori_kontrak->where("stage", "=", 5)->sum(function ($item) {
                return (int) $item->nilai_disetujui;
            });

            // $percen_pre_claim = Percentage::fromFractionAndTotal($total_sub, $total_potensial)->asString();
            // $percen_during_claim = Percentage::fromFractionAndTotal($total_approve_reject, $total_sub)->asString();
            // $percen_post_claim = Percentage::fromFractionAndTotal($total_approve_value, $total_sub_value)->asString();
            $percen_pre_claim = Percentage::fromFractionAndTotal($submission_total_value, $potensial_total_value)->asString();
            $percen_during_claim = Percentage::fromFractionAndTotal($approve_total_value, $potensial_total_value)->asString();
            $percen_post_claim = Percentage::fromFractionAndTotal($approve_total_value, $submission_total_value)->asString();

            $proyek_progress = $proyek->ProyekProgress?->sortByDesc("created_at")->first();
            if ($proyek_progress) {
                $total_ok_review = $proyek_progress->ok_review ?? 0;
                $total_progress_fisik_ri = $proyek_progress->progress_fisik_ri ?? 0;
                $percen_progress_status = Percentage::fromFractionAndTotal((int)$total_progress_fisik_ri, (int)$total_ok_review)->asString();
            } else {
                $percen_progress_status = "0%";
            }


            //Begin::Asuransi
            $kategori_asuransi = collect(["CAR/EAR", "Third Party Liability", "Professional Indemnity", "Heavy Equipment", "CECR"]);
            $contract_asuransi = $proyek->ContractManagements?->Asuransi->groupBy("kategori_asuransi")->sortByDesc("created_at");
            // dd($contract_asuransi);
            if (!empty($contract_asuransi->toArray())) {
                $asuransi_proyek = $kategori_asuransi->map(function ($ka) use ($contract_asuransi) {
                    $result = collect();
                    $id = 0;
                    foreach ($contract_asuransi as $key => $ca) {
                        if ($ka == $key) {
                            if (!empty($result[$key])) {
                                $data = $result[$key];
                                $data["kategori"] = $data["kategori"];
                                $data["tgl_penerbitan"] = $data["tgl_penerbitan"];
                                $data["tgl_berakhir"] = $data["tgl_berakhir"];
                                $data["status"] = $data["status"];
                                $data["id"] = $data["id"] + 1;
                                // dump($data);
                                $result[$key] = $data;
                            } else {
                                $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => $ca->first()->tanggal_penerbitan, "tgl_berakhir" => $ca->first()->tanggal_berakhir, "status" => $ca->first()->is_expired == false ? "VALID" : "EXPIRED", "id" => ++$id];
                                // dump($result[$key]);
                            }
                        } else {
                            $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                        }
                    }
                    return $result;
                })->flatten(1)->sortByDesc("id")->unique("kategori")->values();
            } else {
                $result = collect();
                $asuransi_proyek = $kategori_asuransi->map(function ($item) {
                    $result[$item] = ["kategori" => $item, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                    return $result;
                })->flatten(1);
            }

            // dd($asuransi_proyek);
            //End::Asuransi


            //Begin::Janminan
            // $kategori_jaminan = $proyek->jenis_proyek == "J" ? collect(["Advance Payment", "Performance", "Warranty", "Partner"]) : collect(["Advance Payment", "Performance", "Warranty"]);
            $kategori_jaminan = collect(["Advance Payment", "Performance", "Warranty", "Partner"]);
            $contract_jaminan = $proyek->ContractManagements?->Jaminan->groupBy("kategori_jaminan")->sortByDesc("created_at");
            // dd($contract_asuransi);
            if (!empty($contract_jaminan->toArray())) {
                $jaminan_proyek = $kategori_jaminan->map(function ($ka) use ($contract_jaminan) {
                    $result = collect();
                    $id = 0;
                    foreach ($contract_jaminan as $key => $cj) {
                        if ($ka == $key) {
                            if (!empty($result[$key])) {
                                $data = $result[$key];
                                $data["kategori"] = $data["kategori"];
                                $data["tgl_penerbitan"] = $data["tgl_penerbitan"];
                                $data["tgl_berakhir"] = $data["tgl_berakhir"];
                                $data["status"] = $data["status"];
                                $data["id"] = $data["id"] + 1;
                                // dump($data);
                                $result[$key] = $data;
                            } else {
                                $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => $cj->first()->tanggal_penerbitan, "tgl_berakhir" => $cj->first()->tanggal_berakhir, "status" => $cj->first()->is_expired == false ? "VALID" : "EXPIRED", "id" => ++$id];
                                // dump($result[$key]);
                            }
                        } else {
                            $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                        }
                    }
                    return $result;
                })->flatten(1)->sortByDesc("id")->unique("kategori")->values();
            } else {
                $result = collect();
                $jaminan_proyek = $kategori_jaminan->map(function ($item) {
                    $result[$item] = ["kategori" => $item, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                    return $result;
                })->flatten(1);
            }

            // dd($asuransi_proyek);
            //End::Asuransi



            // dd($percen_pre_claim);

            // $insurance = [
            //     [
            //         "CAR/EAR", mt_rand(0, 1)
            //     ], [
            //         "3rd PARTY", mt_rand(0, 1)
            //     ], [
            //         "PROF. INDEMNITY", mt_rand(0, 1)
            //     ], [
            //         "HEAVY EQUIP", mt_rand(0, 1)
            //     ]
            // ];
            // $insurance = collect($insurance);

            // $bond = [
            //     [
            //         "ADV PAYMENT", mt_rand(0, 1)
            //     ], [
            //         "PERFORMANCE", mt_rand(0, 1)
            //     ], [
            //         "WARRANTY", mt_rand(0, 1)
            //     ], [
            //         "PARTNER", mt_rand(0, 1)
            //     ]
            // ];
            // $bond = collect($bond);
            // dd($proyek->ContractManagements);

            return view("/DashboardCCM/Dashboard_pelaksanaan_proyek", compact([
                "bulan_get",
                "change_status_out",
                "unit_kerjas_all",
                "tahun_get",
                "tahun",
                "jumlahKontrak",
                "totalKontrak",
                "totalPersen",
                "detail_perubahan_kontrak",
                "proyek_get",
                "unit_kerja_get",
                "dop_get",
                "proyek",
                "proyeks",
                "dops",
                "unit_kerjas",
                "changes_overview",
                "total_pengajuan",
                "persentasePerubahan",
                "contract_pelaksanaan_new",
                "month",
                "time_status",
                "percen_pre_claim",
                "percen_during_claim",
                "percen_post_claim",
                "unit_kerja_select",
                "dop_select",
                "percen_progress_status",
                "cat_kontrak",
                "persentasePerubahan",
                "perubahan_total",
                "asuransi_proyek",
                "jaminan_proyek",
                "potensial_total_item",
                "submission_total_item",
                "revision_total_item",
                "negotiation_total_item",
                "approve_total_item",
                "dispute_total_item",
                "reject_total_item",
                "potensial_total_value",
                "submission_total_value",
                "revision_total_value",
                "negotiation_total_value",
                "approve_total_value",
                "dispute_total_value",
                "reject_total_value"
            ]));
        }
        // dd($proyeks);
        // $claims = PerubahanKontrak::all()->filter(function($cl) use($proyeks) {
        //     return $cl->ContractManagements->PerubahanKontrak->isNotEmpty() && $cl->ContractManagements->PerubahanKontrak->firstWhere("kode_proyek", "=", $cl->kode_proyek);
        // });
        // $claims = $proyeks->map(function ($item) {
        //     return PerubahanKontrak::where("id_contract", "=", $item->ContractManagements->id_contract)->get();
        // })->flatten();

        $claims = $proyeks->map(function ($item) {
            return PerubahanKontrak::where("profit_center", "=", $item->profit_center)->get();
        })->flatten();
        // dd($claims);
        // $sumberDanas = SumberDana::count();

        // Begin :: Pemilik Pekerjaan
        $get_pemilik_pekerjaan = $proyeks->map(function ($p) {
            $new_class = new stdClass();
            if (!empty($p->SumberDana)) {
                $new_class->kategori = $p->SumberDana->kategori;
            } else {
                $new_class->kategori = "Other";
            }
            return $new_class;
        });
        // dd($get_pemilik_pekerjaan);

        $pemilik_pekerjaan = $get_pemilik_pekerjaan->groupBy("kategori")->map(function ($p, $key) use ($get_pemilik_pekerjaan) {
            return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_pemilik_pekerjaan->count())->asString() . "</b>", $p->count()];
        })->values();

        // dd($pemilik_pekerjaan, $get_pemilik_pekerjaan);
        // End :: Pemilik Pekerjaan

        // Begin :: Tender Menang
        $get_menang = $proyeks->map(function ($p) {
            $new_class = new stdClass;
            if ($p->stage == 6) {
                $new_class->menang = "Menang Belum Kontrak";
            } else if ($p->stage == 8 || $p->stage == 9) {
                $new_class->menang = "Menang Sudah Kontrak";
            };
            return $new_class;
        });
        // dd($get_menang);
        $menang_kontrak = $get_menang->groupBy("menang")->map(function ($p, $key) use ($get_menang) {
            return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_menang->count())->asString() . "</b>", $p->count()];
        })->values();        
        // End :: Tender Menang

        $get_jenis_proyek = $proyeks->map(function($p){
            $new_class = new stdClass;
            // if ($p->jenis_proyek == "JO") {
            if ($p->type_code == "JO") {
                $new_class->jenis_proyek = "JO"; 
            }else{
                $new_class->jenis_proyek = "Non JO";
            };
            return $new_class;
        });
        // dd($get_jenis_proyek);
        $jenis_proyek = $get_jenis_proyek->groupBy("jenis_proyek")->map(function ($p, $key) use ($get_jenis_proyek) {
            return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_jenis_proyek->count())->asString() . "</b>", $p->count()];
        })->values();
        // dd($jenis_proyek);

        // Begin :: Changes Overview
        $total_changes = $claims->count();
        $changes_overview = $claims->groupBy("jenis_perubahan")->map(function ($c, $key) use($total_changes){
            return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($c->count(), $total_changes)->asString() . "</b>", $c->count()];
        })->values();

        // Begin :: Changes Status
        // $change_status = $proyeks->map(function($item){
        //     return PerubahanKontrak::where("id_contract", "=", $item->ContractManagements->id_contract)->get();
        // });
        $change_status = $proyeks->where(function ($item) {
            return $item->PerubahanKontrak->isNotEmpty();
        })->map(function ($item) {
            return $item->PerubahanKontrak;
        })->values();
        // dd($change_status);
        $change_status = $change_status->map(function ($pcs) {
            // dd($pcs);
            if ($pcs->isNotEmpty()) {
                foreach ($pcs as $p) {
                    $new_class = new stdClass;
                    if ($p->stage == 1) {
                        $new_class->perubahan = "Draft";
                    } else if ($p->stage == 2) {
                        $new_class->perubahan = "Sub";
                    } else if ($p->stage == 3) {
                        $new_class->perubahan = "Revisi";
                    } else if ($p->stage == 4) {
                        $new_class->perubahan = "Negosiasi";
                    } else if ($p->stage == 5) {
                        $new_class->perubahan = "Approve";
                    } else if ($p->stage == 6 && $p->is_dispute == true) {
                        $new_class->perubahan = "Dispute";
                    } else if ($p->stage == 6) {
                        $new_class->perubahan = "Reject";
                    };
                return $new_class;
                }
            }
        });
        // dd();
        $change_status_out = $change_status->groupBy("perubahan")->map(function ($p, $key) use ($change_status) {
            // dump($p);
            return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $change_status->count())->asString() . "</b>", $p->count()];
        })->values();
        

        $jumlahKontrak = 0;
        $totalKontrak = 0;
        $totalPersen = 0;
        // foreach ($kategori_kontrak as $key => $k) {
        //     $jumlahKontrak += (int) $k[1];
        //     $totalKontrak += (int) $k[2];
        //     $totalPersen += (int) $k[3];
        // }
        // End :: Changes Overview
        // dd($kategori_kontrak);

        // Begin :: Jenis Kontrak
        $get_jenis_kontrak = $proyeks->map(function ($p) {
            // dd($p);
            switch ($p->jenis_kontrak) {
                case "JKT01":
                    $jenis_terkontrak = "Cost-Plus/Provisional Sum";
                    break;
                case "JKT02":
                    $jenis_terkontrak = "Turnkey";
                    break;
                case "JKT06":
                    $jenis_terkontrak = "Design & Build";
                    break;
                case "JKT05":
                    $jenis_terkontrak = "OM";
                    break;
                case "JKT05":
                    $jenis_terkontrak = "Unit Price";
                    break;
                case "JKT06":
                    $jenis_terkontrak = "Lumpsum";
                    break;
                case "JKT05":
                    $jenis_terkontrak = "Fixed Price";
                    break;
                case "JKT08":
                    $jenis_terkontrak = "Lumsump+Unit Price";
                    break;
                default:
                    $jenis_terkontrak = '';
                    break;
            };
            if (!empty($jenis_terkontrak)) {
                if ($jenis_terkontrak == "Design & Build") {
                    $jenis_terkontrak = "Lumpsum";
                } else if ($jenis_terkontrak == "OM") {
                    $jenis_terkontrak = "Unit Price";
                } else {
                    $jenis_terkontrak = $jenis_terkontrak;
                }
            } else {
                $jenis_terkontrak = "Uncategorized";
            }
            // if (!empty($p->jenis_terkontrak)) {
            //     if ($p->jenis_terkontrak == "Design & Build") {
            //         $p->jenis_terkontrak = "Lumpsum";
            //     }else if ($p->jenis_terkontrak == "OM") {
            //         $p->jenis_terkontrak = "Unit Price";
            //     } else {
            //         $p->jenis_terkontrak = $p->jenis_terkontrak;
            //     }
            // } else {
            //     $p->jenis_terkontrak = "Uncategorized";
            // }
            // return $p;
            $new_class = new stdClass;
            $new_class->jenis_terkontrak = $jenis_terkontrak;
            return $new_class;
        });

        $jenis_kontrak = $get_jenis_kontrak->groupBy("jenis_terkontrak")->map(function ($p, $key) use($get_jenis_kontrak){
            return [$key ."<br>" . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_jenis_kontrak->count())->asString() . "</b>", $p->count()];
        })->values();
        // dd($jenis_kontrak);
        // End :: Jenis Kontrak

        // Begin :: Nilai Tender Chart
        $unit_kerja_tender = $unit_kerjas_all->groupBy("divcode")->keys();
        // dd($unit_kerja_tender);
        // $nilai_tender_proyeks = $proyeks->groupBy("unit_kerja");
        $nilai_tender_proyeks = $proyeks->groupBy("kd_divisi");
        // dd($nilai_tender_proyeks, $proyeks);
        $nilai_tender_proyeks = $unit_kerja_tender->map(function ($p) use ($nilai_tender_proyeks) {
            // dump($p);
            $result = collect();
            foreach ($nilai_tender_proyeks as $key => $ukt) {
                // dump($key);
                // $nilai_tender = $ukt->sum(function($s){
                //     return (int) $s->nilai_perolehan;
                // });
                $sum = 0;
                if ($p == $key) {
                    // $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => $sum += $ukt->flatten()->sum("nilai_perolehan"), "urut" => UnitKerja::find($p)->nomor_unit];
                    $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => $sum += $ukt->flatten()->sum("contract_value_idr"), "urut" => UnitKerja::find($p)->nomor_unit];
                    // dd($p == $ukt);
                } else {
                    if (!empty($result[$p])) {
                        $data = $result[$p];
                        $data["name"] = $data["name"];
                        $data["y"] = $data["y"];
                        $data["urut"] = $data["urut"];
                        // dump("tes");
                    } else {
                        $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => 0, "urut" => UnitKerja::find($p)->nomor_unit];
                    }
                }
            }

            return $result;
            // $nilai_tender = $p->sum(function ($s) {
            //     return (int) $s->nilai_perolehan;
            // });
            // return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
        })->flatten(1)->sortBy("urut")->values();
        // dd($nilai_tender_proyeks);
        // End :: Nilai Tender Chart
        
        // Begin :: Table Nilai Perubahan
        // $total_nilai_perubahan = $claims->groupBy("jenis_perubahan")->map(function($c) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_claim;
        //     });
        //     $new_class = new stdClass();
        //     // $new_class->jenis_claim = $key;
        //     $new_class->total_nilai = "Rp. " . number_format($nilai, 0, ".", ".");
        //     $new_class->total_proyek = 10;
        //     $new_class->total_persen = "20%";
        //     return $new_class;
        //     // return (int) $c->nilai_claim;
        // });

        // $proyeksDummy = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "8"])->join("claim_managements", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("stage", "=", 8)->get();
        // $nilai_perubahan_table = $proyeksDummy->groupBy("jenis_claim")->map(function ($c, $key) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_perolehan;
        //     });
            // dd($c);
        // $nilai_perubahan_table = $claims->groupBy("jenis_perubahan")->map(function ($c, $key) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_claim;
        //     });
        //     $new_class = new stdClass();
        //     $new_class->jenis_claim = $key;
        //     $new_class->total_nilai = $nilai;
        //     $new_class->total_proyek = $c->count();
        //     $new_class->total_persen = "20%";
        //     return $new_class;
        // })->values();
        // $totalPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // $persenPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // dd($nilai_perubahan_table);
        // dd($nilai_perubahan_table);
        // End :: Table Nilai Perubahan

        $jumlahKontrak = $proyeks->count();
        // $totalKontrakFull = $proyeks->map(function($p){
        //     return $p->ContractManagements;
        // })->sum("value");
        $totalKontrakFull = $proyeks->sum(function ($item) {
            return (int)$item->contract_value_idr;
        });
        // dump($totalKontrakFull);

        $kategori = collect(["VO", "Klaim", "Anti Klaim", "Klaim Asuransi"]);
        // dd($contract_pelaksanaan_new->map(function($item){return $item->PerubahanKontrak;}));
        $contracts_perubahan = $proyeks->map(function ($item) {
            return $item->PerubahanKontrak;
        })->flatten();
        // dd($contracts_perubahan);
        if (!empty($contracts_perubahan->toArray())) {
            $perubahan = $kategori->map(function ($p) use ($contracts_perubahan) {
                $result = collect();
                $counter = 0;
                $nilai = 0;
                $nilaiApproved = 0;
                $counterApproved = 0;
                foreach ($contracts_perubahan as $cp) {
                    // dump($cp);
                    // $qualified_kontrak = collect();
                    if (!empty($cp->jenis_perubahan)) {
                        // dd($result);
                        if ($cp->jenis_perubahan == $p) {
                            if (!empty($result[$p])) {
                                $data = $result[$p];
                                // dump($data);
                                $data["jenis_perubahan"] = $data["jenis_perubahan"];
                                $data["total_item"] = $data["total_item"] + 1;
                                if ($p == "VO" && $cp->nilai_negatif) {
                                    $data["total_nilai"] = $data["total_nilai"] - (int)$cp->biaya_pengajuan;
                                } else {
                                    $data["total_nilai"] = $data["total_nilai"] + (int)$cp->biaya_pengajuan;
                                }

                                if ($cp->stage == 5) {
                                    $data["total_item_approved"] = $data["total_item_approved"] + 1;
                                    if ($p == "VO" && $cp->nilai_negatif) {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] - (int)$cp->nilai_disetujui;
                                    } else {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] + (int)$cp->nilai_disetujui;
                                    }
                                }
                                // dump($data);
                                $result[$p] = $data;
                                // dump($result[$p]);
                            } else {
                                $result[$p] = [
                                    "jenis_perubahan" => $p,
                                    "total_item" => ++$counter,
                                    "total_nilai" => $p == "VO" && $cp->nilai_negatif ? $nilai -= (int)$cp->biaya_pengajuan : $nilai += (int)$cp->biaya_pengajuan,
                                    "total_item_approved" => $cp->stage == 5 ? ++$counterApproved : 0,
                                    "total_nilai_approved" => $cp->stage == 5 && $p == "VO" && $cp->nilai_negatif ? $nilaiApproved -= (int)$cp->nilai_disetujui : ($cp->stage == 5 ? $nilaiApproved += (int)$cp->nilai_disetujui : 0)
                                ];
                            }
                        } else {
                            if (!empty($result[$p])) {
                                $data = $result[$p];
                                $data["jenis_perubahan"] = $data["jenis_perubahan"];
                                $data["total_item"] = $data["total_item"] + 1;
                                if ($p == "VO" && $cp->nilai_negatif) {
                                    $data["total_nilai"] = $data["total_nilai"] - (int)$cp->biaya_pengajuan;
                                } else {
                                    $data["total_nilai"] = $data["total_nilai"] + (int)$cp->biaya_pengajuan;
                                }

                                if ($cp->stage == 5) {
                                    $data["total_item_approved"] = $data["total_item_approved"] + 1;
                                    if ($p == "VO" && $cp->nilai_negatif) {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] - (int)$cp->nilai_disetujui;
                                    } else {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] + (int)$cp->nilai_disetujui;
                                    }
                                }
                                // dump($data);
                            } else {
                                $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "total_item_approved" => 0, "total_nilai_approved" => 0];
                            }
                        }
                        // foreach($cp->PerubahanKontrak as $pk) {
                        //     if($pk->jenis_perubahan == $p) {
                        //         $result[$p] = ["jenis_perubahan" => $p, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                        //     } else {
                        //         if(!empty($result[$p])) {
                        //             $data = $result[$p];
                        //             $data["jenis_perubahan"] = $data["jenis_perubahan"];
                        //             $data["total_item"] = $data["total_item"];
                        //             $data["total_nilai"] = $data["total_nilai"];
                        //         } else {
                        //             $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0];
                        //         }
                        //     }
                        //     // dump($pk->jenis_perubahan == $p);
                        // }
                        // dump($result);
                    } else {
                        $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "total_item_approved" => 0, "total_nilai_approved" => 0];
                    }
                }
                return $result;
            });
            // dd($perubahan);
            $kategori_kontrak = $perubahan->map(function($p, $key) use($perubahan, $totalKontrakFull) {
                $data = $perubahan[$key]->first();
                // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                // $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $totalKontrakFull)->asString() : "0%";
                $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $data["total_nilai"])->asString() : "0%";
                return $data;
            })->values();
            $perubahan_total = $kategori_kontrak->sum('total_nilai');
            $perubahan_total_approved = $kategori_kontrak->sum('total_nilai_approved');
            // dd($kategori_kontrak);
            // $kategori_kontrak = $perubahan->groupBy("jenis_perubahan")->map(function($item, $key) use ($totalKontrakFull){
            //     $biaya_total = (int) $item->sum('biaya_pengajuan');
            //     $persentase_kategori = (float) $biaya_total * 100 / (float) $totalKontrakFull;
            //     return[$key, $item->count(), $biaya_total, number_format($persentase_kategori, 2)];
            // })->values();
            // dd($kategori_kontrak);
        }else{
            $perubahan_total = 0;
            $perubahan_total_approved = 0;
            $perubahan = $kategori->map(function ($item) use ($contract_pelaksanaan_new) {
                $result = collect();
                $counter = 0;
                $nilai = 0;
                // foreach($contracts_pelaksanaan as $cp) {
                //     // $qualified_kontrak = collect();

                //     foreach($cp->PerubahanKontrak as $pk) {
                //         if($pk->jenis_perubahan == $item) {
                //             $result[$item] = ["jenis_perubahan" => $item, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                //         } else {
                //             if(!empty($result[$item])) {
                //                 $data = $result[$item];
                //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                //                 $data["total_item"] = $data["total_item"];
                //                 $data["total_nilai"] = $data["total_nilai"];
                //             } else {
                //             }
                //         }
                //     }
                // }
                $result[$item] = ["jenis_perubahan" => $item, "total_item" => 0, "total_nilai" => 0, "total_item_approved" => 0, "total_nilai_approved" => 0];
                return $result;
            });
            $kategori_kontrak = $perubahan->map(function($p, $key) use($perubahan, $totalKontrakFull) {
                $data = $perubahan[$key]->first();
                // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                // $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $totalKontrakFull)->asString() : "0%";
                $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $data["total_nilai"])->asString() : "0%";
                return $data;
            })->values();
            $perubahan_total = $kategori_kontrak->sum('total_nilai');
            $perubahan_total_approved = $kategori_kontrak->sum('total_nilai_approved');
        }
        // dd($kategori_kontrak);
        if (!empty($totalKontrakFull)) {
            $persentasePerubahan = Percentage::fromFractionAndTotal($perubahan_total, $totalKontrakFull)->asString();
            // $persentasePerubahanApproved = Percentage::fromFractionAndTotal($perubahan_total_approved, $totalKontrakFull)->asString();
            $persentasePerubahanApproved = Percentage::fromFractionAndTotal($perubahan_total_approved, $perubahan_total)->asString();
        } else {
            $persentasePerubahan = 0;
            $persentasePerubahanApproved = 0;
        }
        
        // dd($kategori_kontrak);

        // dd($persentasePerubahan);

        return view("1_Dashboard_ccm_pelaksanaan_kontrak",
            compact(["change_status_out", "menang_kontrak", "changes_overview", "bulan_get", "unit_kerjas_all", "tahun_get", "tahun", "jumlahKontrak", "totalKontrak", "totalKontrakFull", "totalPersen", "persentasePerubahan", "persentasePerubahanApproved", "jumlahKontrak", "dops", "unit_kerjas", "proyeks", "pemilik_pekerjaan", "jenis_proyek", "jenis_kontrak", "dop_get", "unit_kerja_get", "proyek_get", "nilai_tender_proyeks",   "perubahan_total", "perubahan_total_approved", "kategori_kontrak", "month", "contract_pelaksanaan_new", "unit_kerja_select", "dop_select"])
        );
    }

    public function dashboard_pemeliharaan_kontrak(Request $request)
    {
        $dop_select = $request->query("dop") ?? "";
        $unit_kerja_select = $request->query("unit-kerja") ?? "";
        $tahun_get = $request->query("tahun") ?? (int) date("Y");
        $bulan_get = $request->query("bulan") ?? "";
        $proyek_get = $request->query("kode-proyek") ?? "";
        $dops = Dop::whereNotIn("dop", ["EA", "PUSAT", "DOP 3"])->get("dop");
        $year = date("Y");
        $month = date("m");

        if (Auth::user()->check_administrator || Auth::user()->is_pic) {
            // $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",",Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // dd($mounth);
            // $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
            // $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();


            if ($tahun_get < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
            } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->get();
            }
        } else {
            $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            // dd($mounth);
            // $unit_kerjas_all = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
            // $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();


            if ($tahun_get < 2023) {
                $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "P", "J"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
            } else {
                $unit_kerja_code =   ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N", "L", "F", "U", "O"];
                $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
                $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
            }
        }
        // dd($proyeks);
        // $unit_kerja_get = !empty($request->query("unit-kerja")) ? [$request->query("unit-kerja")] : $unit_kerjas_all->toArray();
        // $dop_get = !empty( $request->query("dop")) ? [ $request->query("dop") ] : $dops->toArray();

        if ($dop_select && $unit_kerja_select) {
            $dop_get = [$request->query("dop")];
            $unit_kerja_get = [$request->query("unit-kerja")];
        } else if ($dop_select) {
            $dop_get = [$request->query("dop")];
            $unit_kerja_get = $unit_kerjas->where("dop", "=", $dop_select)->map(function ($item) {
                return $item->divcode;
            })->values();
            $unit_kerjas =   $unit_kerjas->where("dop", "=", $dop_select);
            // dd($dop_get, $unit_kerja_get);
        } else if ($unit_kerja_select) {
            $dop_get = $dops->toArray();
            $unit_kerja_get = [$request->query("unit-kerja")];
        } else {
            $dop_get = $dops->toArray();
            $unit_kerja_get = $unit_kerjas_all->toArray();
        }


        // if (!empty($bulan_get) && $tahun_get == 2023) {
        //     $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6, 8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->get();
        // } else {
        //     if ($tahun_get < 2023 && $bulan_get) {
        //         $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6, 8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", $bulan_get)->where("tipe_proyek", "=", "P")->get();
        //     } elseif ($tahun_get < 2023 && empty($bulan_get)) {
        //         $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6, 8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->get();
        //     } else {
        //         $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6, 8, 9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "<=", 12)->where("tipe_proyek", "=", "P")->get();
        //     }
        // }

        if (!empty($bulan_get) && $tahun_get >= 2023) {
            $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("contract_managements.stages", 3)->where("start_year", "<=", $tahun_get)->whereIn("kd_divisi", $unit_kerja_get)->get();
        } else {
            if ($tahun_get < 2023 && $bulan_get) {
                $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("contract_managements.stages", 3)->where("start_year", "<=", $tahun_get)->whereIn("kd_divisi", $unit_kerja_get)->get();
            } elseif ($tahun_get < 2023 && empty($bulan_get)) {
                $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("contract_managements.stages", 3)->where("start_year", "<=", $tahun_get)->whereIn("kd_divisi", $unit_kerja_get)->get();
            } else {
                $proyeks = ProyekPISNew::join("contract_managements", "contract_managements.profit_center", "=", "proyek_pis_new.profit_center")->where("contract_managements.stages", 3)->where("start_year", "<=", $tahun_get)->whereIn("kd_divisi", $unit_kerja_get)->get();
            }
        }

        //2022 - 2023
        // $proyeks_all = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerja_get)->whereIn("stage", [8,9])->whereIn("dop", $dop_get)->where("tipe_proyek", "=", "P")->where("stages", "=", 3)->get();
        //     // dd($proyeks_all);
        //     $proyeks_filter = collect();

        //     if(!empty($bulan_get)){
        //         $time = Carbon::createFromFormat("m Y", "$bulan_get $tahun_get");
        //         // dd($time);
        //     }else{
        //         $time = Carbon::now();
        //     }
        //     foreach(range(1,12) as $item){
        //         $proyeks_check = collect();
        //         if(!empty($bulan_get)){
        //             // $proyeks_check = $proyeks_all->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
        //             $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", (int)$time->format("m"));
        //         }else{
        //             $proyeks_check = $proyeks_all->where("tahun_perolehan", "<=", (int)$time->format("Y"))->where("bulan_pelaksanaan", "<=", 12);
        //         }
        //         // dump($time, (int)$time->format("Y"), (int)$time->format("m"), $proyeks_filter);
        //         $time = $time->subMonth(1);
        //         if($proyeks_all->isNotEmpty()){
        //             $proyeks_filter->push($proyeks_check);
        //         }
        //         // dd($proyeks_all);
        //     }

        //     $proyeks = $proyeks_filter->flatten()->unique()->filter(function($item) use($tahun_get){
        //         if($tahun_get == 2022){
        //             return $item->tahun_perolehan != 2023;
        //         }else{
        //             return $item;
        //         }
        //     });


        // $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6,8,9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "=", $bulan_get)->where("tipe_proyek", "=", "P")->where("stages", "=", 3)->get();
        // $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6,8,9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->where("bulan_pelaksanaan", "=", $bulan_get)->get();
        // $proyeks = Proyek::where("tahun_perolehan", "=", $tahun_get)->whereIn("stage", [6,8,9])->whereIn("unit_kerja", $unit_kerja_get)->whereIn("dop", $dop_get)->get();


        // dd($proyeks, $unit_kerja_get, $dop_get);

        $tahun = Proyek::all()->groupBy(["tahun_perolehan"])->keys();
        // dd($get_proyek);
        // $tahun = $get_proyek->groupBy("tahun_perolehan")->keys();
        // $bulan = $get_proyek->groupBy("bulan_pelaksanaan")->keys();

        // if(!empty($tahun_get)){
        //     $proyeks = $proyeks->where("tahun_perolehan", "=", $tahun_get);
        //     // dump($tahun_get, $proyeks); 
        // }else{
        //     $proyeks = $proyeks->where("tahun_perolehan", "=", $year);
        // }

        // if(!empty($bulan_get)){
        //     $proyeks = $proyeks->where("bulan_pelaksanaan", "=", $bulan_get);
        //     // dump($tahun_get, $proyeks); 
        // }else{
        //     $proyeks = $proyeks->where("bulan_pelaksanaan", "=", $month);
        // }

        // if(!empty($dop_get)) {
        //     $unit_kerjas = $unit_kerjas_all->where("dop", "=", $dop_get);
        // } else {
        //     $unit_kerjas = $unit_kerjas_all;
        // }

        // if ($dop_get != "") {
        //     $proyeks = $proyeks->filter(function ($p) use ($dop_get) {
        //         return $p->Dop->dop == $dop_get;
        //     });
        // } else if ($unit_kerja_get) {
        //     $proyeks = $proyeks->filter(function ($p) use ($unit_kerja_get) {
        //         return $p->UnitKerja->divcode == $unit_kerja_get;
        //     });
        // }

        // $dops = Dop::whereNotIn("dop", ["EA", "PUSAT"])->get();
        // $proyeks = $proyeks->filter(function ($p) {
        //     return !empty($p->ContractManagements);
        // });
        $contracts_all = ContractManagements::all();
        // dd($proyeks);
        $proyek_get = $request->query("kode-proyek") ?? "";
        // $contracts_pemeliharaan = $proyeks->map(function($item){
        //     return $item->ContractManagements;
        // })->where("stages", "=", 3)->values();

        $contracts_pemeliharaan = $proyeks->map(function($item){
            return $item->ContractManagements;
        })->where("stages", "=", 3)->values();
        // dd($contracts_pemeliharaan);
        // dd(collect($unit_kerja_get)->flatten());

        if (!empty($proyek_get)) {
            // $proyek = Proyek::where("kode_proyek", "=", $proyek_get)->first();
            $proyek = ProyekPISNew::where("profit_center", "=", $proyek_get)->first();
            // $proyeks = Proyek::where("tahun_perolehan", "=", $proyek->tahun_perolehan)->get();
            // dd($proyek->nilai_perolehan);
            // $kategori_kontrak = PerubahanKontrak::where("id_contract", "=", $proyek->ContractManagements->id_contract)->get();
            $kategori_kontrak = PerubahanKontrak::where("profit_center", "=", $proyek->profit_center)->get();

            // Begin :: Changes Overview
            $detail_perubahan_kontrak = $kategori_kontrak->groupBy("jenis_perubahan")->map(function ($kategori, $key) use ($proyek) {
                $pengajuan = $kategori->sum(function ($c) {
                    return (int) $c->biaya_pengajuan; 
                });
                // $persen = Percentage::fromFractionAndTotal($pengajuan, $proyek->nilai_perolehan)->asString();
                $persen = Percentage::fromFractionAndTotal($pengajuan, $proyek->contract_value_idr)->asString();
                // $persen = (float) $pengajuan * 100 / ((float) $proyek->nilai_perolehan == null ? 1 : $proyek->nilai_perolehan);
                $potensial = 0;
                $subs = 0;
                $revisi = 0;
                $nego = 0;
                $setuju = 0;
                $tidak = 0;
                $dispute = 0;
                foreach ($kategori as $k) {
                    if ($k->stage == 1) {
                        $potensial += 1;
                    } else if ($k->stage == 2) {
                        $subs += 1;
                    } else if ($k->stage == 3) {
                        $revisi += 1;
                    } else if ($k->stage == 4) {
                        $nego += 1;
                    } else if ($k->stage == 5) {
                        $setuju += 1;
                    } else if ($k->stage == 6 && $k->is_dispute == false) {
                        $tidak += 1;
                    } else {
                        $dispute += 1;
                    }
                }
                return [$key, $kategori->count(), $pengajuan, $persen, $potensial, $subs, $revisi, $nego, $setuju, $tidak, $dispute];
            })->values();

            // $totalKontrakFull = $proyeks->map(function($p){
            //     return $p->ContractManagements;
            // })->sum("value");
            $totalKontrakFull = $proyeks->sum("contract_value_idr");
            $total_pengajuan = $proyek->PerubahanKontrak->sum("biaya_pengajuan");
            if (!empty($proyek->nilai_perolehan)) {
                // $persentasePerubahan = Percentage::fromFractionAndTotal($total_pengajuan, (int)$proyek->nilai_perolehan)->asString();
                $persentasePerubahan = Percentage::fromFractionAndTotal($total_pengajuan, (int)$proyek->contract_value_idr)->asString();
            } else {
                $persentasePerubahan = 0;
            }
            // dd($proyeks);

            //Begin::CCM STATUS
            $kategori = collect(["VO", "Klaim", "Anti Klaim", "Klaim Asuransi"]);
            // dd($contract_pelaksanaan_new->map(function($item){return $item->PerubahanKontrak;}));
            $contracts_perubahan = $kategori_kontrak;
            // dd($contracts_perubahan);
            if (!empty($contracts_perubahan->toArray())) {
                $cat_kontrak = $kategori->map(function ($p) use ($contracts_perubahan) {
                    $result = collect();
                    $counter = 0;
                    $potensial = 0;
                    $potensial_value = 0;
                    $subs = 0;
                    $subs_value = 0;
                    $revisi = 0;
                    $revisi_value = 0;
                    $nego = 0;
                    $nego_value = 0;
                    $setuju = 0;
                    $setuju_value = 0;
                    $tolak = 0;
                    $tolak_value = 0;
                    $dispute = 0;
                    $dispute_value = 0;
                    $nilai = 0;

                    // $data = $result[];
                    $result["jenis_perubahan"] = $p;
                    $filterJenisPerubahan = $contracts_perubahan->filter(function ($item) use ($p) {
                        return $item->jenis_perubahan == $p;
                    });

                    $result["potensial"] = $filterJenisPerubahan->count();
                    $result["potensial_value"] = $filterJenisPerubahan->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterSubs = $filterJenisPerubahan->filter(function ($subs) {
                        return $subs->stage >= 2;
                    });

                    $result["subs"] = $filterSubs->count();
                    $result["subs_value"] = $filterSubs->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterRevision = $filterJenisPerubahan->filter(function ($revisi) {
                        return $revisi->stage == 3;
                    });

                    $result["revisi"] = $filterRevision->count();
                    $result["revisi_value"] = $filterRevision->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterNego = $filterJenisPerubahan->filter(function ($nego) {
                        return $nego->stage == 4;
                    });

                    $result["nego"] = $filterNego->count();
                    $result["nego_value"] = $filterNego->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterApprove = $filterJenisPerubahan->filter(function ($setuju) {
                        return $setuju->stage == 5;
                    });

                    $result["setuju"] = $filterApprove->count();
                    $result["setuju_value"] = $filterApprove->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->nilai_disetujui;
                        } else {
                            $nilai += (int)$item->nilai_disetujui;
                        }

                        return $nilai;
                    });

                    $filterTolak = $filterJenisPerubahan->filter(function ($tolak) {
                        return $tolak->stage == 6 && $tolak->is_dispute == false;
                    });

                    $result["tolak"] = $filterTolak->count();
                    $result["tolak_value"] = $filterTolak->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    $filterDispute = $filterJenisPerubahan->filter(function ($dispute) {
                        return $dispute->stage == 6 && $dispute->is_dispute == true;
                    });

                    $result["dispute"] = $filterDispute->count();
                    $result["dispute_value"] = $filterDispute->sum(function ($item) use ($p) {
                        $nilai = 0;
                        if ($p == "VO" && $item->nilai_negatif) {
                            $nilai -= (int)$item->biaya_pengajuan;
                        } else {
                            $nilai += (int)$item->biaya_pengajuan;
                        }

                        return $nilai;
                    });

                    // return $data;
                    // foreach($contracts_perubahan as $cp) {
                    //     // $qualified_kontrak = collect();
                    //     if(!empty($cp->jenis_perubahan)){
                    //         // dd($result);
                    //         if($cp->jenis_perubahan == $p) {
                    //             // dd("true");
                    //             if(!empty($result[$p])) {
                    //                 $data = $result[$p];
                    //                 // dump($setuju);
                    //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //                 $data["total_item"] = $data["total_item"] + 1;
                    //                 if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                     $data["total_nilai"] = $data["total_nilai"] - $cp->biaya_pengajuan;
                    //                 } else {
                    //                     $data["total_nilai"] = $data["total_nilai"] + $cp->biaya_pengajuan;
                    //                 }
                    //                 if($cp->stage == 1){
                    //                     $data["potensial"] = $data["potensial"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["potensial_value"] = $data["potensial_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["potensial_value"] = $data["potensial_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 2){
                    //                     $data["subs"] = $data["subs"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["subs_value"] = $data["subs_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["subs_value"] = $data["subs_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 3){
                    //                     $data["revisi"] = $data["revisi"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["revisi_value"] = $data["revisi_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["revisi_value"] = $data["revisi_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 4){
                    //                     $data["nego"] = $data["nego"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["nego_value"] = $data["nego_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["nego_value"] = $data["nego_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 5){
                    //                     $data["setuju"] = $data["setuju"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["setuju_value"] = $data["setuju_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["setuju_value"] = $data["setuju_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 6 && $cp->is_dispute == false){
                    //                     $data["tolak"] = $data["tolak"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["tolak_value"] = $data["tolak_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["tolak_value"] = $data["tolak_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }else{
                    //                     $data["dispute"] = $data["dispute"] + 1;
                    //                     if($data["jenis_perubahan"] == "Anti Klaim") {
                    //                         $data["dispute_value"] = $data["dispute_value"] - $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $data["dispute_value"] = $data["dispute_value"] + $cp->biaya_pengajuan;
                    //                     }
                    //                 }
                    //                 // dump($data);
                    //                 $result[$p] = $data ;
                    //                 // dump($potensial);
                    //             } else {
                    //                 if($cp->stage == 1){
                    //                     $potensial += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $potensial_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $potensial_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 2){
                    //                     $subs += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $subs_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $subs_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 3){
                    //                     $revisi += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $revisi_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $revisi_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 4){
                    //                     $nego += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $nego_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $nego_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 5){
                    //                     $setuju += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $setuju_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $setuju_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }elseif($cp->stage == 6 && $cp->is_dispute == false){
                    //                     $tolak += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $tolak_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $tolak_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }else{
                    //                     $dispute += 1;
                    //                     if($p == "Anti Klaim") {
                    //                         $dispute_value -= $cp->biaya_pengajuan;
                    //                     } else {
                    //                         $dispute_value += $cp->biaya_pengajuan;
                    //                     }
                    //                 }
                    //                 $result[$p] = ["jenis_perubahan" => $p, "total_item" => ++$counter, "total_nilai" => $nilai += $cp->biaya_pengajuan, "potensial"=>$potensial, "subs" => $subs, "revisi" => $revisi, "nego" => $nego, "setuju" => $setuju, "tolak" => $tolak, "dispute" => $dispute, "potensial_value"=>$potensial_value, "subs_value" => $subs_value, "revisi_value" => $revisi_value, "nego_value" => $nego_value, "setuju_value" => $setuju_value, "tolak_value" => $tolak_value, "dispute_value" => $dispute_value];
                    //             }
                    //         } else {
                    //             if(!empty($result[$p])) {
                    //                 $data = $result[$p];
                    //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //                 $data["total_item"] = $data["total_item"] + 1;
                    //                 $data["total_nilai"] = $data["total_nilai"];
                    //                 // dump($data);
                    //             } else {
                    //                 $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "potensial" => 0, "subs" => 0, "revisi" => 0, "nego" => 0, "setuju" => 0, "tolak" => 0, "dispute" => 0, "potensial_value" => 0, "subs_value" => 0, "revisi_value" => 0, "nego_value" => 0, "setuju_value" => 0, "tolak_value" => 0, "dispute_value" => 0];
                    //             }
                    //         }
                    //         // foreach($cp->PerubahanKontrak as $pk) {
                    //         //     if($pk->jenis_perubahan == $p) {
                    //         //         $result[$p] = ["jenis_perubahan" => $p, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                    //         //     } else {
                    //         //         if(!empty($result[$p])) {
                    //         //             $data = $result[$p];
                    //         //             $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //         //             $data["total_item"] = $data["total_item"];
                    //         //             $data["total_nilai"] = $data["total_nilai"];
                    //         //         } else {
                    //         //             $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0];
                    //         //         }
                    //         //     }
                    //         //     // dump($pk->jenis_perubahan == $p);
                    //         // }
                    //         // dump($result);
                    //     }else{
                    //         $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "potensial" => 0, "subs" => 0, "revisi" => 0, "nego" => 0, "setuju" => 0, "tolak" => 0, "dispute" => 0, "potensial_value" => 0, "subs_value" => 0, "revisi_value" => 0, "nego_value" => 0, "setuju_value" => 0, "tolak_value" => 0, "dispute_value" => 0];
                    //     }
                    // }
                    return $result;
                })->values();
                // dd($perubahan);
                // $cat_kontrak = $perubahan->map(function($p, $key) use($perubahan, $totalKontrakFull) {
                //     $data = $perubahan[$key]->first();
                //     // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                //     // $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                //     return $data;
                // })->values();
                // dd($cat_kontrak);
                $perubahan_total = $cat_kontrak->sum('total_nilai');
                // $kategori_kontrak = $perubahan->groupBy("jenis_perubahan")->map(function($item, $key) use ($totalKontrakFull){
                //     $biaya_total = (int) $item->sum('biaya_pengajuan');
                //     $persentase_kategori = (float) $biaya_total * 100 / (float) $totalKontrakFull;
                //     return[$key, $item->count(), $biaya_total, number_format($persentase_kategori, 2)];
                // })->values();
                // dd($kategori_kontrak);
            } else {
                $perubahan_total = 0;
                $perubahan = $kategori->map(function ($item) use ($contracts_pemeliharaan) {
                    $result = collect();
                    $counter = 0;
                    $nilai = 0;
                    // foreach($contracts_pelaksanaan as $cp) {
                    //     // $qualified_kontrak = collect();

                    //     foreach($cp->PerubahanKontrak as $pk) {
                    //         if($pk->jenis_perubahan == $item) {
                    //             $result[$item] = ["jenis_perubahan" => $item, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                    //         } else {
                    //             if(!empty($result[$item])) {
                    //                 $data = $result[$item];
                    //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                    //                 $data["total_item"] = $data["total_item"];
                    //                 $data["total_nilai"] = $data["total_nilai"];
                    //             } else {
                    //             }
                    //         }
                    //     }
                    // }
                    $result[$item] = ["jenis_perubahan" => $item, "total_item" => 0, "total_nilai" => 0];
                    return $result;
                });
                $cat_kontrak = $perubahan->map(function ($p, $key) use ($perubahan, $totalKontrakFull) {
                    $data = $perubahan[$key]->first();
                    // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                    $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                    return $data;
                })->values();
                $perubahan_total = $cat_kontrak->sum('total_nilai');
            }
            // dd($cat_kontrak);
            if (!empty($totalKontrakFull)) {
                $persentasePerubahan = Percentage::fromFractionAndTotal($perubahan_total, $totalKontrakFull)->asString();
            } else {
                $persentasePerubahan = 0;
            }
            //End::CCM STATUS
            

            // End :: Changes Overview
            
            $jumlahKontrak = 0;
            $totalKontrak = 0;
            $totalPersen = 0;
            foreach ($kategori_kontrak as $key => $k) {
                $jumlahKontrak += (int) $k[1];
                $totalKontrak += (int) $k[2];
                $totalPersen += (float) $k[3] ;
            }


            $total_changes = $kategori_kontrak->count();
            $changes_overview = $kategori_kontrak->groupBy("jenis_perubahan")->map(function ($c, $key) use ($total_changes) {
                return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($c->count(), $total_changes)->asString() . "</b>", $c->count()];
            })->values();
            // dd($changes_overview);

            // Begin :: Changes Status
            // $change_status = $proyeks->map(function($item){
            //     return PerubahanKontrak::where("id_contract", "=", $item->ContractManagements->id_contract)->get();
            // });
            // dd($kategori_kontrak);
            $change_status = $kategori_kontrak->map(function ($pcs) {
                // dd($pcs);
                $new_class = new stdClass;
                if ($pcs->stage == 1) {
                    $new_class->perubahan = "Draft";
                } else if ($pcs->stage == 2) {
                    $new_class->perubahan = "Sub";
                } else if ($pcs->stage == 3) {
                    $new_class->perubahan = "Revisi";
                } else if ($pcs->stage == 4) {
                    $new_class->perubahan = "Negosiasi";
                } else if ($pcs->stage == 5) {
                    $new_class->perubahan = "Approve";
                } else if ($pcs->stage == 6 && $pcs->is_dispute == true) {
                    $new_class->perubahan = "Dispute";
                } else if ($pcs->stage == 6) {
                    $new_class->perubahan = "Reject";
                };
                return $new_class;
            });
            // dd($change_status);

            //Begin::Asuransi
            $kategori_asuransi = collect(["CAR/EAR", "Third Party Liability", "Professional Indemnity", "Heavy Equipment", "CECR"]);
            $contract_asuransi = $proyek->ContractManagements->Asuransi->groupBy("kategori_asuransi")->sortByDesc("created_at");
            // dd($contract_asuransi);

            if (!empty($contract_asuransi->toArray())) {
                $asuransi_proyek = $kategori_asuransi->map(function ($ka) use ($contract_asuransi) {
                    $result = collect();
                    $id = 0;
                    foreach ($contract_asuransi as $key => $ca) {
                        if ($ka == $key) {
                            if (!empty($result[$key])) {
                                $data = $result[$key];
                                $data["kategori"] = $data["kategori"];
                                $data["tgl_penerbitan"] = $data["tgl_penerbitan"];
                                $data["tgl_berakhir"] = $data["tgl_berakhir"];
                                $data["status"] = $data["status"];
                                $data["id"] = $data["id"] + 1;
                                // dump($data);
                                $result[$key] = $data;
                            } else {
                                $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => $ca->first()->tanggal_penerbitan, "tgl_berakhir" => $ca->first()->tanggal_berakhir, "status" => $ca->first()->is_expired == false ? "VALID" : "EXPIRED", "id" => ++$id];
                                // dump($result[$key]);
                            }
                        } else {
                            $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                        }
                    }
                    return $result;
                })->flatten(1)->sortByDesc("id")->unique("kategori");
            } else {
                $result = collect();
                $asuransi_proyek = $kategori_asuransi->map(function ($item) {
                    $result[$item] = ["kategori" => $item, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                    return $result;
                })->flatten(1);
            }

            // dd($asuransi_proyek);
            //End::Asuransi


            //Begin::Janminan
            $kategori_jaminan = collect(["Advance Payment", "Performance", "Warranty", "Partner"]);
            $contract_jaminan = $proyek->ContractManagements->Jaminan->groupBy("kategori_jaminan")->sortByDesc("created_at");
            // dd($contract_asuransi);

            if (!empty($contract_jaminan->toArray())) {
                $jaminan_proyek = $kategori_jaminan->map(function ($ka) use ($contract_jaminan) {
                    $result = collect();
                    $id = 0;
                    foreach ($contract_jaminan as $key => $cj) {
                        if ($ka == $key) {
                            if (!empty($result[$key])) {
                                $data = $result[$key];
                                $data["kategori"] = $data["kategori"];
                                $data["tgl_penerbitan"] = $data["tgl_penerbitan"];
                                $data["tgl_berakhir"] = $data["tgl_berakhir"];
                                $data["status"] = $data["status"];
                                $data["id"] = $data["id"] + 1;
                                // dump($data);
                                $result[$key] = $data;
                            } else {
                                $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => $cj->first()->tanggal_penerbitan, "tgl_berakhir" => $cj->first()->tanggal_berakhir, "status" => $cj->first()->is_expired == false ? "VALID" : "EXPIRED", "id" => ++$id];
                                // dump($result[$key]);
                            }
                        } else {
                            $result[$key] = ["kategori" => $ka, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                        }
                    }
                    return $result;
                })->flatten(1)->sortByDesc("id")->unique("kategori");
            } else {
                $result = collect();
                $jaminan_proyek = $kategori_jaminan->map(function ($item) {
                    $result[$item] = ["kategori" => $item, "tgl_penerbitan" => null, "tgl_berakhir" => null, "status" => null];
                    return $result;
                })->flatten(1);
            }

            // dd($asuransi_proyek);
            //End::Asuransi


            $change_status_out = $change_status->groupBy("perubahan")->map(function ($p, $key) use ($change_status) {
                // dump($p);
                return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $change_status->count())->asString() . "</b>", $p->count()];
            })->values();


            $potensial_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage >= 1;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $submission_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage >= 2;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $revision_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 3;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $negotiation_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 4;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $approve_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 5;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $dispute_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 6 && $cp->is_dispute == true;
            })->groupBy('jenis_perubahan')->flatten()->count();

            $reject_total_item = $contracts_perubahan->filter(function ($cp) {
                return $cp->stage == 6;
            })->groupBy('jenis_perubahan')->flatten()->count();



            // $potensial_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 1;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $submission_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 2;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $revision_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 3;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $negotiation_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 4;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $approve_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 5;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $reject_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 6;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            // $dispute_total_value = $contracts_perubahan->filter(function($cp){
            //     return $cp->stage == 6 && $cp->is_dispute == true;
            // })->groupBy('jenis_perubahan')->flatten()->sum('biaya_pengajuan');

            $potensial_total_value = 0;

            $submission_total_value = 0;

            $revision_total_value = 0;

            $negotiation_total_value = 0;

            $approve_total_value = 0;

            $reject_total_value = 0;

            $dispute_total_value = 0;

            foreach ($cat_kontrak as $ck) {
                $potensial_total_value += $ck["potensial_value"] ?? 0;

                $submission_total_value += $ck["subs_value"] ?? 0;

                $revision_total_value += $ck["revisi_value"] ?? 0;

                $negotiation_total_value += $ck["nego_value"] ?? 0;

                $approve_total_value += $ck["setuju_value"] ?? 0;

                $reject_total_value += $ck["tolak_value"] ?? 0;

                $dispute_total_value += $ck["dispute_value"] ?? 0;
            }



            // $tanggal_awal = new DateTime($proyek->tanggal_mulai_terkontrak);
            // $tanggal_akhir = new DateTime($proyek->tanggal_akhir_terkontrak);
            $tanggal_awal = new DateTime($proyek->start_date);
            $tanggal_akhir = new DateTime($proyek->finish_date);
            $date_now = new DateTime();

            $diff_1 = $date_now->diff($tanggal_awal);
            $diff_2 = $tanggal_akhir->diff($tanggal_awal);
            $time_status = Percentage::fromFractionAndTotal((int)$diff_1->format("%a"), (int)$diff_2->format("%a"))->asString();
            // dd($diff_1->format("%a"),$diff_2->format("%a"),$time_status);

            // $total_potensial = $kategori_kontrak->where("stage", "=", 1)->count();
            $total_potensial = $kategori_kontrak->count();
            // $total_sub = $kategori_kontrak->where("stage", "=", 2)->count();
            $total_sub = $kategori_kontrak->where("stage", ">=", 2)->count();
            $total_approve_reject = $kategori_kontrak->whereIn("stage", [5, 6])->count();
            $total_sub_value = $kategori_kontrak->where("stage", ">=", 2)->sum("biaya_pengajuan");
            // $total_approve_value = $kategori_kontrak->where("stage", "=", 5)->sum("nilai_disetujui");
            $total_approve_value = $kategori_kontrak->where("stage", "=", 5)->sum(function ($item) {
                return (int) $item->nilai_disetujui;
            });

            // $percen_pre_claim = Percentage::fromFractionAndTotal($total_sub, $total_potensial)->asString();
            // $percen_during_claim = Percentage::fromFractionAndTotal($total_approve_reject, $total_sub)->asString();
            // $percen_post_claim = Percentage::fromFractionAndTotal($total_approve_value, $total_sub_value)->asString();

            $percen_pre_claim = Percentage::fromFractionAndTotal($submission_total_value, $potensial_total_value)->asString();
            $percen_during_claim = Percentage::fromFractionAndTotal($approve_total_value, $potensial_total_value)->asString();
            $percen_post_claim = Percentage::fromFractionAndTotal($approve_total_value, $submission_total_value)->asString();

            $proyek_progress = $proyek->ProyekProgress?->sortByDesc("created_at")->first();
            if ($proyek_progress) {
                $total_ok_review = $proyek_progress->ok_review ?? 0;
                $total_progress_fisik_ri = $proyek_progress->progress_fisik_ri ?? 0;
                $percen_progress_status = Percentage::fromFractionAndTotal((int)$total_progress_fisik_ri, (int)$total_ok_review)->asString();
            } else {
                $percen_progress_status = "0%";
            }
            // dd($percen_progress_status);

            // $insurance = [
            //     [
            //         "CAR/EAR", mt_rand(0, 1)
            //     ], [
            //         "3rd PARTY", mt_rand(0, 1)
            //     ], [
            //         "PROF. INDEMNITY", mt_rand(0, 1)
            //     ], [
            //         "HEAVY EQUIP", mt_rand(0, 1)
            //     ]
            // ];
            // $insurance = collect($insurance);

            // $bond = [
            //     [
            //         "ADV PAYMENT", mt_rand(0, 1)
            //     ], [
            //         "PERFORMANCE", mt_rand(0, 1)
            //     ], [
            //         "WARRANTY", mt_rand(0, 1)
            //     ], [
            //         "PARTNER", mt_rand(0, 1)
            //     ]
            // ];
            // $bond = collect($bond);

            return view("/DashboardCCM/Dashboard_pemeliharaan_proyek", compact([
                "bulan_get",
                "change_status_out",
                "unit_kerjas_all",
                "tahun_get",
                "tahun",
                "jumlahKontrak",
                "totalKontrak",
                "totalPersen",
                "detail_perubahan_kontrak",
                "proyek_get",
                "unit_kerja_get",
                "dop_get",
                "proyek",
                "proyeks",
                "dops",
                "unit_kerjas",
                "changes_overview",
                "total_pengajuan",
                "persentasePerubahan",
                "contracts_pemeliharaan",
                "month",
                "time_status",
                "percen_pre_claim",
                "percen_during_claim",
                "percen_post_claim",
                "unit_kerja_select",
                "dop_select",
                "percen_progress_status",
                "cat_kontrak",
                "persentasePerubahan",
                "perubahan_total",
                "asuransi_proyek",
                "jaminan_proyek",
                "potensial_total_item",
                "submission_total_item",
                "revision_total_item",
                "negotiation_total_item",
                "approve_total_item",
                "dispute_total_item",
                "reject_total_item",
                "potensial_total_value",
                "submission_total_value",
                "revision_total_value",
                "negotiation_total_value",
                "approve_total_value",
                "dispute_total_value",
                "reject_total_value"
            ]));
        }
        // dd($proyeks);
        // $claims = PerubahanKontrak::all()->filter(function($cl) use($proyeks) {
        //     return $cl->ContractManagements->PerubahanKontrak->isNotEmpty() && $cl->ContractManagements->PerubahanKontrak->firstWhere("kode_proyek", "=", $cl->kode_proyek);
        // });
        // $claims = $proyeks->map(function ($item) {
        //     return PerubahanKontrak::where("id_contract", "=", $item->ContractManagements->id_contract)->get();
        // })->flatten();
        $claims = $proyeks->map(function ($item) {
            return PerubahanKontrak::where("profit_center", "=", $item->profit_center)->get();
        })->flatten();
        // dd($claims);
        // $sumberDanas = SumberDana::count();

        // Begin :: Pemilik Pekerjaan
        $get_pemilik_pekerjaan = $proyeks->map(function ($p) {
            $new_class = new stdClass();
            if (!empty($p->SumberDana)) {
                $new_class->kategori = $p->SumberDana->kategori;
            } else {
                $new_class->kategori = "Other";
            }
            return $new_class;
        });
        // dd($get_pemilik_pekerjaan);

        $pemilik_pekerjaan = $get_pemilik_pekerjaan->groupBy("kategori")->map(function ($p, $key) use ($get_pemilik_pekerjaan) {
            return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_pemilik_pekerjaan->count())->asString() . "</b>", $p->count()];
        })->values();

        // dd($pemilik_pekerjaan, $get_pemilik_pekerjaan);
        // End :: Pemilik Pekerjaan

        // Begin :: Tender Menang
        $get_menang = $proyeks->map(function ($p) {
            $new_class = new stdClass;
            if ($p->stage == 6) {
                $new_class->menang = "Menang Belum Kontrak";
            } else if ($p->stage == 8 || $p->stage == 9) {
                $new_class->menang = "Menang Sudah Kontrak";
            };
            return $new_class;
        });
        // dd($get_menang);
        $menang_kontrak = $get_menang->groupBy("menang")->map(function ($p, $key) use ($get_menang) {
            return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_menang->count())->asString() . "</b>", $p->count()];
        })->values();
        // End :: Tender Menang

        $get_jenis_proyek = $proyeks->map(function ($p) {
            $new_class = new stdClass;
            // if ($p->jenis_proyek == "J") {
            if ($p->jenis_proyek == "JO") {
                $new_class->jenis_proyek = "JO";
            } else {
                $new_class->jenis_proyek = "Non JO";
            };
            return $new_class;
        });
        // dd($get_jenis_proyek);
        $jenis_proyek = $get_jenis_proyek->groupBy("jenis_proyek")->map(function ($p, $key) use ($get_jenis_proyek) {
            return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_jenis_proyek->count())->asString() . "</b>", $p->count()];
        })->values();
        // dd($jenis_proyek);

        // Begin :: Changes Overview
        $total_changes = $claims->count();
        $changes_overview = $claims->groupBy("jenis_perubahan")->map(function ($c, $key) use ($total_changes) {
            return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($c->count(), $total_changes)->asString() . "</b>", $c->count()];
        })->values();

        // Begin :: Changes Status
        // $change_status = $proyeks->map(function ($item) {
        //     return PerubahanKontrak::where("id_contract", "=", $item->ContractManagements->id_contract)->get();
        // });
        $change_status = $proyeks->where(function ($item) {
            return $item->PerubahanKontrak->isNotEmpty();
        })->map(function ($item) {
            return $item->PerubahanKontrak;
        })->values();
        // dd($change_status);
        $change_status = $change_status->map(function ($pcs) {
            // dd($pcs);
            if ($pcs->isNotEmpty()) {
                foreach ($pcs as $p) {
                    $new_class = new stdClass;
                    if ($p->stage == 1) {
                        $new_class->perubahan = "Draft";
                    } else if ($p->stage == 2) {
                        $new_class->perubahan = "Sub";
                    } else if ($p->stage == 3) {
                        $new_class->perubahan = "Revisi";
                    } else if ($p->stage == 4) {
                        $new_class->perubahan = "Negosiasi";
                    } else if ($p->stage == 5) {
                        $new_class->perubahan = "Approve";
                    } else if ($p->stage == 6 && $p->is_dispute == true) {
                        $new_class->perubahan = "Dispute";
                    } else if ($p->stage == 6) {
                        $new_class->perubahan = "Reject";
                    };
                    return $new_class;
                }
            }
        });
        // dd();
        $change_status_out = $change_status->groupBy("perubahan")->map(function ($p, $key) use ($change_status) {
            // dump($p);
            return [$key . " <b>" . Percentage::fromFractionAndTotal($p->count(), $change_status->count())->asString() . "</b>", $p->count()];
        })->values();
        

        $jumlahKontrak = 0;
        $totalKontrak = 0;
        $totalPersen = 0;
        // foreach ($kategori_kontrak as $key => $k) {
        //     $jumlahKontrak += (int) $k[1];
        //     $totalKontrak += (int) $k[2];
        //     $totalPersen += (int) $k[3];
        // }
        // End :: Changes Overview
        // dd($kategori_kontrak);

        // Begin :: Jenis Kontrak
        $get_jenis_kontrak = $proyeks->map(function ($p) {
            // dd($p);
            switch ($p->jenis_kontrak) {
                case "JKT01":
                    $jenis_terkontrak = "Cost-Plus/Provisional Sum";
                    break;
                case "JKT02":
                    $jenis_terkontrak = "Turnkey";
                    break;
                case "JKT06":
                    $jenis_terkontrak = "Design & Build";
                    break;
                case "JKT05":
                    $jenis_terkontrak = "OM";
                    break;
                case "JKT05":
                    $jenis_terkontrak = "Unit Price";
                    break;
                case "JKT06":
                    $jenis_terkontrak = "Lumpsum";
                    break;
                case "JKT05":
                    $jenis_terkontrak = "Fixed Price";
                    break;
                case "JKT08":
                    $jenis_terkontrak = "Lumsump+Unit Price";
                    break;
                default:
                    $jenis_terkontrak = '';
                    break;
            };
            if (!empty($jenis_terkontrak)) {
                if ($jenis_terkontrak == "Design & Build") {
                    $jenis_terkontrak = "Lumpsum";
                } else if ($jenis_terkontrak == "OM") {
                    $jenis_terkontrak = "Unit Price";
                } else {
                    $jenis_terkontrak = $jenis_terkontrak;
                }
            } else {
                $jenis_terkontrak = "Uncategorized";
            }
            // if (!empty($p->jenis_terkontrak)) {
            //     if ($p->jenis_terkontrak == "Design & Build") {
            //         $p->jenis_terkontrak = "Lumpsum";
            //     }else if ($p->jenis_terkontrak == "OM") {
            //         $p->jenis_terkontrak = "Unit Price";
            //     } else {
            //         $p->jenis_terkontrak = $p->jenis_terkontrak;
            //     }
            // } else {
            //     $p->jenis_terkontrak = "Uncategorized";
            // }
            // return $p;
            $new_class = new stdClass;
            $new_class->jenis_terkontrak = $jenis_terkontrak;
            return $new_class;
        });

        $jenis_kontrak = $get_jenis_kontrak->groupBy("jenis_terkontrak")->map(function ($p, $key) use ($get_jenis_kontrak) {
            return [$key . "<br>" . " <b>" . Percentage::fromFractionAndTotal($p->count(), $get_jenis_kontrak->count())->asString() . "</b>", $p->count()];
        })->values();
        // dd($jenis_kontrak);
        // End :: Jenis Kontrak

        // Begin :: Nilai Tender Chart
        $unit_kerja_tender = $unit_kerjas_all->groupBy("divcode")->keys();
        // dd($unit_kerja_tender);
        $proyeks_tender = $contracts_pemeliharaan->map(function ($item) {
            return $item->project;
        });
        // $nilai_tender_proyeks = $proyeks_tender->groupBy("unit_kerja");
        // $nilai_tender_proyeks = $proyeks_tender->groupBy("kd_divisi");
        $nilai_tender_proyeks = $proyeks->groupBy("kd_divisi");
        // dd($nilai_tender_proyeks, $proyeks);
        $nilai_tender_proyeks = $unit_kerja_tender->map(function ($p) use ($nilai_tender_proyeks) {
            // dump($p);
            $result = collect();
            foreach ($nilai_tender_proyeks as $key => $ukt) {
                // dump($key);
                // $nilai_tender = $ukt->sum(function($s){
                //     return (int) $s->nilai_perolehan;
                // });
                $sum = 0;
                if ($p == $key) {
                    // $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => $sum += $ukt->flatten()->sum("nilai_perolehan"), "urut" => UnitKerja::find($p)->nomor_unit];
                    $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => $sum += $ukt->flatten()->sum("contract_value_idr"), "urut" => UnitKerja::find($p)->nomor_unit];
                    // dd($p == $ukt);
                } else {
                    if (!empty($result[$p])) {
                        $data = $result[$p];
                        $data["name"] = $data["name"];
                        $data["y"] = $data["y"];
                        $data["urut"] = $data["urut"];
                        // dump("tes");
                    } else {
                        $result[$p] = ["name" => UnitKerja::find($p)->unit_kerja, "y" => 0, "urut" => UnitKerja::find($p)->nomor_unit];
                    }
                }
            }

            return $result;
            // $nilai_tender = $p->sum(function ($s) {
            //     return (int) $s->nilai_perolehan;
            // });
            // return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
        })->flatten(1)->sortBy("urut")->values();
        // dd($nilai_tender_proyeks);
        // End :: Nilai Tender Chart

        // Begin :: Table Nilai Perubahan
        // $total_nilai_perubahan = $claims->groupBy("jenis_perubahan")->map(function($c) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_claim;
        //     });
        //     $new_class = new stdClass();
        //     // $new_class->jenis_claim = $key;
        //     $new_class->total_nilai = "Rp. " . number_format($nilai, 0, ".", ".");
        //     $new_class->total_proyek = 10;
        //     $new_class->total_persen = "20%";
        //     return $new_class;
        //     // return (int) $c->nilai_claim;
        // });

        // $proyeksDummy = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "8"])->join("claim_managements", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("stage", "=", 8)->get();
        // $nilai_perubahan_table = $proyeksDummy->groupBy("jenis_claim")->map(function ($c, $key) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_perolehan;
        //     });
        // dd($c);
        // $nilai_perubahan_table = $claims->groupBy("jenis_perubahan")->map(function ($c, $key) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_claim;
        //     });
        //     $new_class = new stdClass();
        //     $new_class->jenis_claim = $key;
        //     $new_class->total_nilai = $nilai;
        //     $new_class->total_proyek = $c->count();
        //     $new_class->total_persen = "20%";
        //     return $new_class;
        // })->values();
        // $totalPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // $persenPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // dd($nilai_perubahan_table);
        // dd($nilai_perubahan_table);
        // End :: Table Nilai Perubahan

        // $jumlahKontrak = $proyeks_tender->count();
        // $totalKontrakFull = $proyeks_tender->map(function ($p) {
        //     return $p->ContractManagements;
        // })->sum("value");
        $jumlahKontrak = $proyeks->count();
        // $totalKontrakFull = $proyeks->map(function ($p) {
        //     return $p->ContractManagements;
        // })->sum("value");
        $totalKontrakFull = $proyeks->sum(function ($item) {
            return (int)$item->contract_value_idr;
        });

        $kategori = collect(["VO", "Klaim", "Anti Klaim", "Klaim Asuransi"]);
        // dd($contract_pelaksanaan_new->map(function($item){return $item->PerubahanKontrak;}));
        $contracts_perubahan = $proyeks->map(function ($item) {
            return $item->PerubahanKontrak;
        })->flatten();
        if (!empty($contracts_perubahan->toArray())) {
            $perubahan = $kategori->map(function ($p) use ($contracts_perubahan) {
                $result = collect();
                $counter = 0;
                $nilai = 0;
                $nilaiApproved = 0;
                $counterApproved = 0;
                foreach ($contracts_perubahan as $cp) {
                    // dump($cp);
                    // $qualified_kontrak = collect();
                    if (!empty($cp->jenis_perubahan)) {
                        // dd($result);
                        if ($cp->jenis_perubahan == $p) {
                            if (!empty($result[$p])) {
                                $data = $result[$p];
                                // dump($data);
                                $data["jenis_perubahan"] = $data["jenis_perubahan"];
                                $data["total_item"] = $data["total_item"] + 1;
                                if ($p == "VO" && $cp->nilai_negatif) {
                                    $data["total_nilai"] = $data["total_nilai"] - (int)$cp->biaya_pengajuan;
                                } else {
                                    $data["total_nilai"] = $data["total_nilai"] + (int)$cp->biaya_pengajuan;
                                }

                                if ($cp->stage == 5) {
                                    $data["total_item_approved"] = $data["total_item_approved"] + 1;
                                    if ($p == "VO" && $cp->nilai_negatif) {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] - (int)$cp->nilai_disetujui;
                                    } else {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] + (int)$cp->nilai_disetujui;
                                    }
                                }
                                // dump($data);
                                $result[$p] = $data;
                                // dump($result[$p]);
                            } else {
                                $result[$p] = [
                                    "jenis_perubahan" => $p,
                                    "total_item" => ++$counter,
                                    "total_nilai" => $p == "VO" && $cp->nilai_negatif ? $nilai -= (int)$cp->biaya_pengajuan : $nilai += (int)$cp->biaya_pengajuan,
                                    "total_item_approved" => $cp->stage == 5 ? ++$counterApproved : 0,
                                    "total_nilai_approved" => $cp->stage == 5 && $p == "VO" && $cp->nilai_negatif ? $nilaiApproved -= (int)$cp->nilai_disetujui : ($cp->stage == 5 ? $nilaiApproved += (int)$cp->nilai_disetujui : 0)
                                ];
                            }
                        } else {
                            if (!empty($result[$p])) {
                                $data = $result[$p];
                                $data["jenis_perubahan"] = $data["jenis_perubahan"];
                                $data["total_item"] = $data["total_item"] + 1;
                                if ($p == "VO" && $cp->nilai_negatif) {
                                    $data["total_nilai"] = $data["total_nilai"] - (int)$cp->biaya_pengajuan;
                                } else {
                                    $data["total_nilai"] = $data["total_nilai"] + (int)$cp->biaya_pengajuan;
                                }

                                if ($cp->stage == 5) {
                                    $data["total_item_approved"] = $data["total_item_approved"] + 1;
                                    if ($p == "VO" && $cp->nilai_negatif) {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] - (int)$cp->nilai_disetujui;
                                    } else {
                                        $data["total_nilai_approved"] = $data["total_nilai_approved"] + (int)$cp->nilai_disetujui;
                                    }
                                }
                                // dump($data);
                            } else {
                                $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "total_item_approved" => 0, "total_nilai_approved" => 0];
                            }
                        }
                        // foreach($cp->PerubahanKontrak as $pk) {
                        //     if($pk->jenis_perubahan == $p) {
                        //         $result[$p] = ["jenis_perubahan" => $p, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                        //     } else {
                        //         if(!empty($result[$p])) {
                        //             $data = $result[$p];
                        //             $data["jenis_perubahan"] = $data["jenis_perubahan"];
                        //             $data["total_item"] = $data["total_item"];
                        //             $data["total_nilai"] = $data["total_nilai"];
                        //         } else {
                        //             $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0];
                        //         }
                        //     }
                        //     // dump($pk->jenis_perubahan == $p);
                        // }
                        // dump($result);
                    } else {
                        $result[$p] = ["jenis_perubahan" => $p, "total_item" => 0, "total_nilai" => 0, "total_item_approved" => 0, "total_nilai_approved" => 0];
                    }
                }
                return $result;
            });
            // dd($perubahan);
            $kategori_kontrak = $perubahan->map(function ($p, $key) use ($perubahan, $totalKontrakFull) {
                $data = $perubahan[$key]->first();
                // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                // $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $totalKontrakFull)->asString() : "0%";
                $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $data["total_nilai"])->asString() : "0%";
                return $data;
            })->values();
            // dd($kategori_kontrak);
            $perubahan_total = $kategori_kontrak->sum('total_nilai');
            $perubahan_total_approved = $kategori_kontrak->sum('total_nilai_approved');
            // $kategori_kontrak = $perubahan->groupBy("jenis_perubahan")->map(function($item, $key) use ($totalKontrakFull){
            //     $biaya_total = (int) $item->sum('biaya_pengajuan');
            //     $persentase_kategori = (float) $biaya_total * 100 / (float) $totalKontrakFull;
            //     return[$key, $item->count(), $biaya_total, number_format($persentase_kategori, 2)];
            // })->values();
            // dd($kategori_kontrak);
        }else{
            $perubahan_total = 0;
            $perubahan_total_approved = 0;
            $perubahan = $kategori->map(function ($item) use ($contracts_pemeliharaan) {
                $result = collect();
                $counter = 0;
                $nilai = 0;
                // foreach($contracts_pelaksanaan as $cp) {
                //     // $qualified_kontrak = collect();

                //     foreach($cp->PerubahanKontrak as $pk) {
                //         if($pk->jenis_perubahan == $item) {
                //             $result[$item] = ["jenis_perubahan" => $item, "total_item" => ++$counter, "total_nilai" => $nilai += $pk->biaya_pengajuan];
                //         } else {
                //             if(!empty($result[$item])) {
                //                 $data = $result[$item];
                //                 $data["jenis_perubahan"] = $data["jenis_perubahan"];
                //                 $data["total_item"] = $data["total_item"];
                //                 $data["total_nilai"] = $data["total_nilai"];
                //             } else {
                //             }
                //         }
                //     }
                // }
                $result[$item] = ["jenis_perubahan" => $item, "total_item" => 0, "total_nilai" => 0, "total_item_approved" => 0, "total_nilai_approved" => 0];
                return $result;
            });
            $kategori_kontrak = $perubahan->map(function ($p, $key) use ($perubahan, $totalKontrakFull) {
                $data = $perubahan[$key]->first();
                // $data["persen"] = ($data["total_nilai"] / $totalKontrakFull) * 100;
                $data["persen"] = $data["total_nilai"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai"], $totalKontrakFull)->asString() : "0%";
                // $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $totalKontrakFull)->asString() : "0%";
                $data["persen_approved"] = $data["total_nilai_approved"] != 0 ? Percentage::fromFractionAndTotal($data["total_nilai_approved"], $data["total_nilai"])->asString() : "0%";
                return $data;
            })->values();
            $perubahan_total = $kategori_kontrak->sum('total_nilai');
            $perubahan_total_approved = $kategori_kontrak->sum('total_nilai_approved');
        }
        // dd($kategori_kontrak, $totalKontrakFull);
        if (!empty($totalKontrakFull)) {
            $persentasePerubahan = Percentage::fromFractionAndTotal($perubahan_total, $totalKontrakFull)->asString();
            // $persentasePerubahanApproved = Percentage::fromFractionAndTotal($perubahan_total_approved, $totalKontrakFull)->asString();
            $persentasePerubahanApproved = Percentage::fromFractionAndTotal($perubahan_total_approved, $perubahan_total)->asString();
        } else {
            $persentasePerubahan = 0;
            $persentasePerubahanApproved = 0;
        }

        // dd($kategori_kontrak);

        // dd($persentasePerubahan);

        return view(
            "1_Dashboard_ccm_pemeliharaan",
            compact(["change_status_out", "menang_kontrak", "changes_overview", "bulan_get", "unit_kerjas_all", "tahun_get", "tahun", "jumlahKontrak", "totalKontrak", "totalKontrakFull", "totalPersen", "persentasePerubahan", "persentasePerubahanApproved", "jumlahKontrak", "dops", "unit_kerjas", "proyeks", "pemilik_pekerjaan", "jenis_proyek", "jenis_kontrak", "dop_get", "unit_kerja_get", "proyek_get", "nilai_tender_proyeks",   "perubahan_total", "perubahan_total_approved", "kategori_kontrak", "month", "contracts_pemeliharaan", "unit_kerja_select", "dop_select"])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get Data filter berdasarkan point
     * @param mixed $type
     * @param mixed $month
     * 
     * @return [type]
     */
    public function getDataFilterPoint($year, $prognosa, $type, $month, $unit_kerja = "")
    {
        $arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $data = [];
        $counter = 2; // buat excel cell
        $year = !empty($year) ? $year : (int) date("Y");

        // Delete existing file if data date is greater than 1 minute
        $files = File::allFiles(public_path("excel"));
        foreach ($files as $file) {
            $file = File::lastModified($file);
            // try {
            //     $file_modified = date_create(strtotime($file));
            // } catch (\Exception $e) {
            //     $file_modified = date_create($file);
            // }
            // if (!empty($file)) {
            //     $file_modified = date_create($file);
            // } else {
            //     $file_modified = date_create(strtotime($file));
            // }
            // $file_modified = date_create(strtotime($file));
            $file_modified = date_create($file);
            $now = date_create("now");
            if ($now->diff($file_modified)->i > 1) {
                File::delete(public_path("excel/$file"));
            }
        }



        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:G1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Pelanggan');
        $sheet->setCellValue('C1', 'Status Pasar');
        $sheet->setCellValue('D1', 'Stage');
        $sheet->setCellValue('E1', 'Unit Kerja');
        $sheet->setCellValue('F1', 'Tipe Proyek');
        $sheet->setCellValue('G1', 'Bulan');
        $sheet->setCellValue('H1', "Nilai $type");

        // dd($request->all());   
        // dd($type, $prognosa, $month, $unit_`kerja);
        if ($type == "Forecast") {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator || Gate::any(['admin-crm'])) {
                $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
                $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                
                $countUnitKerjaFromHistory = $history_forecasts->groupBy('unit_kerja')->count();
                if ($history_forecasts->count() < 1 || $countUnitKerjaFromHistory < 11) {
                    $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                }
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_forecasts = $history_forecasts->where("divcode", $unit_kerja);
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->where("divcode", $unit_kerja)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                    // dd($history_forecasts);
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->where("divcode", $unit_kerja)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                    if ($unit_kerja == "PUSAT") {
                        $history_forecasts = $history_forecasts->whereIn("dop", ["DOP 1", "DOP 2", "DOP 3"]);
                    } else {
                        $history_forecasts = $history_forecasts->where("dop", $dop);
                    }
                    // dd($dop, $history_forecasts);
                }
                if (Gate::any(["admin-crm"])) {
                    $history_forecasts = $history_forecasts->whereIn('divcode', $unit_kerja_user);
                }
                $history_forecasts = $history_forecasts->where("nilai_forecast", "!=", "")->where("nilai_forecast", "!=", "0")->where("tahun_perolehan", "=", $year)->groupBy("kode_proyek");
                // if (Gate::allows(['super-admin'])) {
                //     dd($history_forecasts);
                // }
            } else {
                if (!empty($unit_kerja)) {
                    $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    if($history_forecasts->count() < 1) {
                        $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
                    // dd($request->all());
                    $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    if($history_forecasts->count() < 1) {
                        $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                }
                $history_forecasts = $history_forecasts->where("nilai_forecast", "!=", "")->where("nilai_forecast", "!=", "0")->where("tahun_perolehan", "=", $year)->groupBy("kode_proyek");

            }
            foreach ($history_forecasts as $kode_proyek => $filter) {
                foreach ($filter as $key => $f) {
                    if ($f->month_forecast <= $month) {
                        if (!array_key_exists($f->kode_proyek, $data)) {
                            $data[$kode_proyek] = $f;
                        } else {
                            $data[$kode_proyek]->nilai_forecast += $f->nilai_forecast;
                            $data[$kode_proyek]->month_forecast = $f->month_forecast;
                        }
                    }
                }
                $tipe_proyek = "";
                if (isset($data[$kode_proyek])) {
                    if ($data[$kode_proyek]->tipe_proyek == "R") {
                        $tipe_proyek = "Retail";
                    } else {
                        $tipe_proyek = "Non-Retail";
                    }
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->proyekBerjalan->name_customer ?? "-");
                    $sheet->setCellValue("C" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("D" . $counter, $stage);
                    $sheet->setCellValue("E" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("F" . $counter, $tipe_proyek);
                    $sheet->setCellValue("G" . $counter, $this->getFullMonth($data[$kode_proyek]->month_forecast));
                    $sheet->setCellValue("H" . $counter, $data[$kode_proyek]->nilai_forecast);
                }
                $counter++;
            }
            $data = collect($data)->sortBy("month_forecast", SORT_NUMERIC);
            // dd($data);
        } elseif ($type == "NilaiOKRKAP") {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator || Gate::any(['admin-crm'])) {
                $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
                $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->sortBy("month_rkap", SORT_NUMERIC);
                $countUnitKerjaFromHistory = $history_rkap->groupBy('unit_kerja')->count();
                if ($history_rkap->count() < 1 || $countUnitKerjaFromHistory < 11) {
                    $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->sortBy("month_rkap", SORT_NUMERIC);
                }
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_rkap = $history_rkap->where("divcode", $unit_kerja);
                    if (empty($history_rkap) || $history_rkap->isEmpty()) {
                        $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->where("divcode", $unit_kerja)->get()->sortBy("month_rkap", SORT_NUMERIC);
                    }
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    if (empty($history_rkap) || $history_rkap->isEmpty()) {
                        $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->where("divcode", $unit_kerja)->get()->where("is_cancel", "!=", true)->sortBy("month_rkap", SORT_NUMERIC);
                    }
                    if ($unit_kerja == "PUSAT") {
                        $history_rkap = $history_rkap->whereIn("dop", ["DOP 1", "DOP 2", "DOP 3"]);
                    } else {
                        $history_rkap = $history_rkap->where("dop", $dop);
                    }
                }
                // dd($year, $history_rkap->first());
                if (Gate::any(["admin-crm"])) {
                    $history_rkap = $history_rkap->whereIn('divcode', $unit_kerja_user);
                }
                if ($year == 2022) {
                    $history_rkap = $history_rkap->where("tahun_perolehan", "=", $year)->groupBy("kode_proyek");
                } else {
                    $history_rkap = $history_rkap->where("tahun_perolehan", "=", $year)->where("is_rkap", "=", true)->groupBy("kode_proyek");
                }
            } else {
                if (!empty($unit_kerja)) {
                    $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tahun", "=", $year)->sortBy("month_rkap", SORT_NUMERIC);
                    if($history_rkap->count() < 1) {
                        $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tahun", "=", $year)->sortBy("month_rkap", SORT_NUMERIC);
                    }
                    if (empty($history_rkap) || $history_rkap->isEmpty()) {
                        $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tahun", "=", $year)->sortBy("month_rkap", SORT_NUMERIC);
                    }
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
                    $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereNotIn("divcode", ["B", "C", "D", "8"])->where("tahun", "=", $year)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_rkap", SORT_NUMERIC);
                    if($history_rkap->count() < 1) {
                        $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereNotIn("divcode", ["B", "C", "D", "8"])->where("tahun", "=", $year)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_rkap", SORT_NUMERIC);
                    }
                    if (empty($history_rkap) || $history_rkap->isEmpty()) {
                        $history_rkap = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereNotIn("divcode", ["B", "C", "D", "8"])->where("tahun", "=", $year)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_rkap", SORT_NUMERIC);
                    }
                }
                if ($year == 2022) {
                    $history_rkap = $history_rkap->where("tahun_perolehan", "=", $year)->groupBy("kode_proyek");
                } else {
                    $history_rkap = $history_rkap->where("tahun_perolehan", "=", $year)->where("is_rkap", "=", true)->groupBy("kode_proyek");
                }
            }
            // dd($history_rkap);
            foreach ($history_rkap as $kode_proyek => $filter) {
                foreach ($filter as $f) {
                    if ($f->month_rkap <= $month) {
                        if (!array_key_exists($f->kode_proyek, $data)) {
                            $data[$kode_proyek] = $f;
                        } else {
                            $data[$kode_proyek]->rkap_forecast += $f->rkap_forecast;
                            $data[$kode_proyek]->month_rkap = $f->month_rkap;
                        }
                    }
                }
                $tipe_proyek = "";
                if (isset($data[$kode_proyek])) {
                    if ($data[$kode_proyek]->tipe_proyek == "R") {
                        $tipe_proyek = "Retail";
                    } else {
                        $tipe_proyek = "Non-Retail";
                    }
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->proyekBerjalan->name_customer ?? "-");
                    $sheet->setCellValue("C" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("D" . $counter, $stage);
                    $sheet->setCellValue("E" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("F" . $counter, $tipe_proyek);
                    $sheet->setCellValue("G" . $counter, $this->getFullMonth($data[$kode_proyek]->month_rkap));
                    $sheet->setCellValue("H" . $counter, $data[$kode_proyek]->rkap_forecast);
                }
                $counter++;
            }
            $data = collect($data)->sortBy("month_rkap", SORT_NUMERIC);
        } else {
            $month = array_search($month, $arrNamaBulan);

            if (Auth::user()->check_administrator || Gate::allows(['admin-crm'])) {
                $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
                $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.stage", "=", 8)->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                $countUnitKerjaFromHistory = $history_realisasi->groupBy('unit_kerja')->count();
                if ($history_realisasi->count() < 1 || $countUnitKerjaFromHistory < 11) {
                    $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.stage", "=", 8)->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                }
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_realisasi = $history_realisasi->where("divcode", $unit_kerja);
                    if (empty($history_realisasi) || $history_realisasi->isEmpty()) {
                        $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.stage", "=", 8)->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->where("divcode", $unit_kerja)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    if (empty($history_realisasi) || $history_realisasi->isEmpty()) {
                        $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.stage", "=", 8)->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->where("divcode", $unit_kerja)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                    if ($unit_kerja == "PUSAT") {
                        $history_realisasi = $history_realisasi->whereIn("dop", ["DOP 1", "DOP 2", "DOP 3"]);
                    } else {
                        $history_realisasi = $history_realisasi->where("dop", $dop);
                    }
                }
                if (Gate::any(["admin-crm"])) {
                    $history_realisasi = $history_realisasi->whereIn('divcode', $unit_kerja_user);
                }
                $history_realisasi = $history_realisasi->where("tahun_perolehan", "=", $year)->filter(function ($p) {
                    return $p->realisasi_forecast != 0;
                })->groupBy("kode_proyek");
            } else {
                $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
                if (!empty($unit_kerja)) {
                    $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.stage", "=", 8)->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                    if($history_realisasi->count() < 1) {
                        $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                    if (empty($history_realisasi) || $history_realisasi->isEmpty()) {
                        $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                } else {
                    $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.stage", "=", 8)->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_realisasi", SORT_NUMERIC);
                    if($history_realisasi->count() < 1) {
                        $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                    if (empty($history_realisasi) || $history_realisasi->isEmpty()) {
                        $history_realisasi = Proyek::with(["proyekBerjalan"])->select("proyeks.*", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $year)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                }
                $history_realisasi = $history_realisasi->where("tahun_perolehan", "=", $year)->filter(function ($p) {
                    return $p->realisasi_forecast != 0;
                })->groupBy("kode_proyek");
                // dd($history_realisasi);

            }
            // dd($history_realisasi);
            foreach ($history_realisasi as $kode_proyek => $filter) {
                foreach ($filter as $f) {
                    if ($f->month_realisasi <= $month) {
                        if (!array_key_exists($f->kode_proyek, $data)) {
                            $data[$kode_proyek] = $f;
                        } else {
                            $data[$kode_proyek]->realisasi_forecast += $f->realisasi_forecast;
                            $data[$kode_proyek]->month_realisasi = $f->month_realisasi;
                        }
                    }
                }
                if (isset($data[$kode_proyek])) {
                    $tipe_proyek = "";
                    if ($data[$kode_proyek]->tipe_proyek == "R") {
                        $tipe_proyek = "Retail";
                    } else {
                        $tipe_proyek = "Non-Retail";
                    }
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->proyekBerjalan->name_customer ?? "-");
                    $sheet->setCellValue("C" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("D" . $counter, $stage);
                    $sheet->setCellValue("E" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("F" . $counter, $tipe_proyek);
                    $sheet->setCellValue("G" . $counter, $this->getFullMonth($data[$kode_proyek]->month_realisasi));
                    $sheet->setCellValue("H" . $counter, $data[$kode_proyek]->realisasi_forecast);
                }
                $counter++;
            }
            // foreach ($history_realisasi as $history) {
            //     if ($history->month_realisasi <= $month) {
            //         array_push($data, $history);
            //     }
            // }
            $data = collect($data)->sortBy("month_realisasi", SORT_NUMERIC);
        }

        $writer = new Xlsx($spreadsheet);
        $file_name = "$type-$prognosa-$month-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        // dump($file_name);
        return response()->json(["href" => $file_name, "data" => $data]);
    }

    public function getDataFilterPointTriwulan($prognosa, $type, $month, $unit_kerja = "")
    {
        $arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $range_month = explode("-", $month);
        $max_month = array_search($range_month[1], $arrNamaBulan);
        if (Auth::user()->check_administrator) {
            $history_forecasts = Proyek::select("*")->where("month_forecast", "<=", $max_month)->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("proyek_berjalans", "proyeks.kode_proyek", "=", "proyek_berjalans.kode_proyek", "left")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=", $prognosa)->get();
            if ($unit_kerja != "") {
                $history_forecasts = $history_forecasts->where("divcode", $unit_kerja);
            }
        } else {
            $history_forecasts = Proyek::select("*")->where("month_forecast", "<=", $max_month)->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("proyek_berjalans", "proyeks.kode_proyek", "=", "proyek_berjalans.kode_proyek", "left")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->get();
        }
        return response()->json($history_forecasts);
    }

    public function getDataFilterPointRealisasi($prognosa, $type, $unitKerja, $divcode = "")
    {
        $unit_kerja = str_replace("-", " ", $unitKerja);
        $unit_kerja_model = UnitKerja::where("unit_kerja", "=", $unit_kerja)->get()->first();
        if ($unit_kerja_model->divcode == Auth::user()->unit_kerja && !Auth::user()->check_administrator) {
            if ($type == "Nilai-OK-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("proyek_berjalans", "proyeks.kode_proyek", "=", "proyek_berjalans.kode_proyek", "left")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            } else if ($type == "Nilai-Realisasi-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("proyek_berjalans", "proyeks.kode_proyek", "=", "proyek_berjalans.kode_proyek", "left")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            }
            return response()->json($proyeks);
        } else {
            if ($type == "Nilai-OK-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("proyek_berjalans", "proyeks.kode_proyek", "=", "proyek_berjalans.kode_proyek", "left")->where("proyeks.unit_kerja", "=", $unit_kerja_model->divcode)->get();
            } else if ($type == "Nilai-Realisasi-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("proyek_berjalans", "proyeks.kode_proyek", "=", "proyek_berjalans.kode_proyek", "left")->where("proyeks.unit_kerja", "=", $unit_kerja_model->divcode)->get();
            }
            return response()->json($proyeks);
        }
    }

    public function getDataMonitoringProyek($tipe, $prognosa, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:G1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai Penawaran");

        $year = (int) date("Y");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator || Gate::any(['admin-crm'])) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get();
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek"]);
                // $proyeks = Proyek::all()->where("unit_kerja", "=", $filter);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", "=", $filter);
                    // dd($filter, $proyeks->first());
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    // dd($dop, $proyeks->first());
                    $proyeks = $proyeks->where("dop", "=", $dop);
                }
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nilai_perolehan", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel", "is_tidak_lulus_pq", "porsi_jo"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nilai_perolehan", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel", "is_tidak_lulus_pq", "porsi_jo"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get();
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek"]);
                // $proyeks = Proyek::all()->where("unit_kerja", "=", $filter);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", "=", $filter);
                    // dd($filter, $proyeks->first());
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    // dd($dop, $proyeks->first());
                    $proyeks = $proyeks->where("dop", "=", $dop);
                }
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nilai_perolehan", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel", "is_tidak_lulus_pq", "porsi_jo"]);
            }
        }
        // $proyeks = $proyeks->where("tipe_proyek", "!=", "R")->where("jenis_proyek", "!=", "I");
        // $proyeks = $proyeks->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "=", "P")->where("tahun_perolehan", "=", $year)->where(function ($p) use ($prognosa) {
        //     return $p->forecasts->where("periode_prognosa", "=", $prognosa);
        // });
        $proyeks = $proyeks->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "=", "P")->where("tahun_perolehan", "=", $year);

        $stage = null;
        $column_to_sort = null;
        $is_menang = false;
        $is_cancel = false;
        switch (trim($tipe)) {
            case "Prakualifikasi":
                $stage = 3;
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Kalah":
                // $stage = [0, 7];
                $stage = [3, 7];
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Tidak Lolos PQ":
                // $stage = [0, 7];
                $stage = 3;
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Tender Diikuti":
                $stage = 4;
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Perolehan":
                $is_menang = true;
                $stage = 5;
                $column_to_sort = "bulan_perolehan";
                break;

            case "Menang":
                $is_menang = true;
                $stage = 6;
                $column_to_sort = "bulan_perolehan";
                break;

            case "Terkontrak":
                $is_menang = true;
                $stage = 8;
                $column_to_sort = "bulan_perolehan";
                break;
            case "Terkontrak":
                $is_menang = true;
                $stage = 8;
                $column_to_sort = "bulan_perolehan";
                break;

            case "Cancel":
                // $stage = [1, 2, 3, 4, 5, 6, 7, 8];
                $is_cancel = true;
                $column_to_sort = "bulan_pelaksanaan";
                break;
        }

        if (is_array($stage) && $stage != null) {
            $proyeks = $proyeks->whereIn("stage", $stage)->where('is_cancel', $is_cancel)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        } elseif ($stage != null) {
            $proyeks = $proyeks->where("stage", "=", $stage)->where('is_cancel', $is_cancel)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        } elseif ($is_cancel) {
            $proyeks = $proyeks->where("is_cancel", "=", $is_cancel)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        }


        if ($tipe == "Prakualifikasi") {
            $proyeks = $proyeks->where('is_tidak_lulus_pq', false)->values();
        } elseif ($tipe == "Kalah") {
            $proyeks = $proyeks->filter(function ($proyek) {
                return $proyek->stage == 7;
            })->values();
        } elseif ($tipe == "Cancel") {
            $proyeks = $proyeks->where('is_cancel', true)->values();
        } elseif ($tipe == "Tidak Lolos PQ") {
            $proyeks = $proyeks->filter(function ($proyek) {
                return $proyek->is_tidak_lulus_pq;
            });
        }

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $is_menang) {
            if ($p->tipe_proyek == "R") {
                $nilai_forecast = $p->forecasts->sortBy("month_realisasi");
                $niai_realisasi = $nilai_forecast->sum(function ($f) {
                    return (int) $f->realisasi_forecast;
                });
                $nilai_forecast = $p->forecasts->sortBy("month_realisasi")->last() ?? null;
                if (!empty($nilai_forecast) && $nilai_forecast->realisasi_forecast != 0 && $nilai_forecast->realisasi_forecast != '') {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($nilai_forecast->month_realisasi));
                    $sheet->setCellValue('G' . $row, $niai_realisasi);
                    $row++;
                }
            } else {
                if ($is_menang && ($p->nilai_perolehan != 0 || !empty($p->nilai_perolehan))) {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Non-Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_perolehan));
                    $sheet->setCellValue('G' . $row, $p->nilai_perolehan != 0 ? $p->nilai_perolehan : 0);
                    $row++;
                } else if ($p->hps_pagu != 0) {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Non-Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_pelaksanaan));
                    $sheet->setCellValue('G' . $row, $p->hps_pagu);
                    $row++;
                }
            }
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "periode" => $prognosa, "data" => $proyeks]);
    }

    public function getDataTerendahTerkontrakOld($tipe, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai $tipe");

        $year = (int) date("Y");
        $month = date("d") <= 5 ? date("m") - 1 : date("m");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if (!Auth::user()->check_administrator || str_contains(Auth::user()->name, "(PIC)") ) {
            $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("history_forecast.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tipe_proyek", "P")->get();
            $countUnitKerjaFromHistory = $proyeks->groupBy('unit_kerja')->count();

            if ($proyeks->count() < 1 || $countUnitKerjaFromHistory < 11 || $proyeks->every(function ($history) {
                return $history->is_approved_1 == true;
            })) {
                $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tipe_proyek", "P")->get();
            }
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);


                // dd($proyeks);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    $proyeks = $proyeks->where("dop", $dop);
                    // dd($dop, $proyeks);
                }
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    $proyeks = $proyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->where("unit_kerja", $unit_kerja_user);
                    $proyeks = $proyeks->where("unit_kerja", $unit_kerja_user);
                }
            }
            // dd($proyeks);
        } else {
            $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("history_forecast.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tipe_proyek", "P")->get();
            $countUnitKerjaFromHistory = $proyeks->groupBy('unit_kerja')->count();

            if ($proyeks->count() < 1 || $countUnitKerjaFromHistory < 11 || $proyeks->every(function ($history) {
                return $history->is_approved_1 == true;
            })) {
                $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("tipe_proyek", "P")->get();
            }
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);
                // $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
                // dd($proyeks);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    $proyeks = $proyeks->where("dop", $dop);
                    // dd($dop, $proyeks);
                }
            } else {
                // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                //     // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                //     $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
                // } else {
                //     // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->where("unit_kerja", $unit_kerja_user);
                //     $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
                // }
                $proyeks = $proyeks;
            }
            // $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) date("m"))->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);
        }

        // $proyeks = $proyeks->filter(function ($p) {
        //     return $p->Forecasts->filter(function ($f) {
        //         return $f->periode_prognosa == (int) date("m");
        //     });
        // });

        // $proyeks = $proyeks->where("proyeks.tahun_perolehan", "=", $year)->where("forecasts.tahun", "=", $year)->get();
        // $proyeks = $proyeks->get();
        
        $stage = null;
        switch ($tipe) {
            case "Terendah":
                $proyeks = $proyeks->filter(function ($p) {
                    return ($p->stage == 5 && $p->peringkat_wika == "Peringkat 1") || $p->stage == 6 || $p->stage == 9;
                });
                break;
            case "Terkontrak":
                $stage = 8;
                $proyeks = $proyeks->where("stage", "=", $stage);
                break;
        }
        $row = 2;
        $proyeks = $proyeks->groupBy("kode_proyek");
        $proyeks = $proyeks->map(function ($p) use ($tipe) {
            $new_class = new stdClass();
            $new_class->nilai_perolehan = 0;
            $new_class->kode_proyek = $p->first()->kode_proyek;
            $new_class->nama_proyek = $p->first()->nama_proyek;

            if ($tipe == "Terendah") {
                $new_class->nilai_perolehan = (int) $p->sum(function ($f) {
                    if (!empty($f->month_forecast)) {
                        return (int) $f->nilai_forecast;
                    }
                });
            } else {
                $new_class->nilai_perolehan = (int) $p->sum(function ($f) {
                    if (!empty($f->month_realisasi) && $f->month_realisasi <= date('m')) {
                        return (int) $f->realisasi_forecast;
                    }
                });
                // if (!empty($p->month_realisasi)) {
                //     $new_class->nilai_perolehan += (int) $p->realisasi_forecast;
                // }
            }

            if ($p->first()->tipe_proyek == "R") {
                $new_class->tipe_proyek = "Retail";
                $new_class->bulan_pelaksanaan = $p->last()->bulan_pelaksanaan;
                $new_class->bulan_ri_perolehan = $p->last()->bulan_ri_perolehan;
            } else {
                $new_class->bulan_pelaksanaan = $p->last()->bulan_pelaksanaan;
                $new_class->bulan_ri_perolehan = $p->last()->bulan_ri_perolehan;
                $new_class->tipe_proyek = "Non-Retail";
            }
            $new_class->unitKerja = UnitKerja::find($p->first()->unit_kerja)->unit_kerja;
            // $new_class->unitKerja = $p->first()->unit_kerja;
            $new_class->stage = $p->first()->stage;
            $new_class->status_pasdin = $p->first()->status_pasdin;

            return $new_class;
            // return $kp->map(function($p) use($tipe) {
            // });
        })->where("nilai_perolehan", "!=", 0)->each(function ($p) use ($sheet, &$row, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $p->unitKerja);
            $sheet->setCellValue('E' . $row, $p->tipe_proyek);
            if ($tipe == "Terendah") {
                $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_pelaksanaan));
                $p->bulan = $p->bulan_pelaksanaan;
            } else {
                $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_ri_perolehan));
                $p->bulan = $p->bulan_ri_perolehan;
            }
            $sheet->setCellValue('G' . $row, $p->nilai_perolehan);
            $row++;
            // return $kp->each(function ($p) use ($sheet, &$row, $tipe) {
            // });
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataTerendahTerkontrakOld2($tipe, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:G1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai Penawaran");

        $year = (int) date("Y");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator || Gate::any(['admin-crm'])) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get();
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek"]);
                // $proyeks = Proyek::all()->where("unit_kerja", "=", $filter);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", "=", $filter);
                    // dd($filter, $proyeks->first());
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    // dd($dop, $proyeks->first());
                    $proyeks = $proyeks->where("dop", "=", $dop);
                }
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nilai_perolehan", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel", "is_tidak_lulus_pq", "porsi_jo"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nilai_perolehan", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel", "is_tidak_lulus_pq", "porsi_jo"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get();
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek"]);
                // $proyeks = Proyek::all()->where("unit_kerja", "=", $filter);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", "=", $filter);
                    // dd($filter, $proyeks->first());
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    // dd($dop, $proyeks->first());
                    $proyeks = $proyeks->where("dop", "=", $dop);
                }
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nilai_perolehan", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel", "is_tidak_lulus_pq", "porsi_jo"]);
            }
        }
        // $proyeks = $proyeks->where("tipe_proyek", "!=", "R")->where("jenis_proyek", "!=", "I");
        // $proyeks = $proyeks->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "=", "P")->where("tahun_perolehan", "=", $year)->where(function ($p) use ($prognosa) {
        //     return $p->forecasts->where("periode_prognosa", "=", $prognosa);
        // });
        $proyeks = $proyeks->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year);

        $stage = null;
        $column_to_sort = null;
        $is_menang = false;
        $is_cancel = false;
        switch (trim($tipe)) {
            case "Menang":
                $is_menang = true;
                $stage = 6;
                $column_to_sort = "bulan_perolehan";
                break;

            case "Terkontrak":
                $is_menang = true;
                $stage = 8;
                $column_to_sort = "bulan_perolehan";
                break;

            case "Cancel":
                // $stage = [1, 2, 3, 4, 5, 6, 7, 8];
                $is_cancel = true;
                $column_to_sort = "bulan_pelaksanaan";
                break;
        }

        if (is_array($stage) && $stage != null) {
            $proyeks = $proyeks->whereIn("stage", $stage)->where('is_cancel', $is_cancel)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        } elseif ($stage != null) {
            $proyeks = $proyeks->where("stage", "=", $stage)->where('is_cancel', $is_cancel)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        } elseif ($is_cancel) {
            $proyeks = $proyeks->where("is_cancel", "=", $is_cancel)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        }

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $is_menang) {
            if ($p->tipe_proyek == "R") {
                $nilai_forecast = $p->forecasts->sortBy("month_realisasi");
                $niai_realisasi = $nilai_forecast->sum(function ($f) {
                    return (int) $f->realisasi_forecast;
                });
                $nilai_forecast = $p->forecasts->sortBy("month_realisasi")->last() ?? null;
                if (!empty($nilai_forecast) && $nilai_forecast->realisasi_forecast != 0 && $nilai_forecast->realisasi_forecast != '') {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($nilai_forecast->month_realisasi));
                    $sheet->setCellValue('G' . $row, $niai_realisasi);
                    $row++;
                }
            } else {
                if ($is_menang && ($p->nilai_perolehan != 0 || !empty($p->nilai_perolehan))) {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Non-Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_perolehan));
                    $sheet->setCellValue('G' . $row, $p->nilai_perolehan != 0 ? $p->nilai_perolehan : 0);
                    $row++;
                } else if ($p->hps_pagu != 0) {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Non-Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_pelaksanaan));
                    $sheet->setCellValue('G' . $row, $p->hps_pagu);
                    $row++;
                }
            }
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataTerendahTerkontrak($tipe, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai $tipe");

        $year = (int) date("Y");
        $month = date("d") <= 5 ? date("m") - 1 : date("m");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if (!Auth::user()->check_administrator || str_contains(Auth::user()->name, "(PIC)")) {
            $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("history_forecast.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->get();
            $countUnitKerjaFromHistory = $proyeks->groupBy('unit_kerja')->count();

            if ($proyeks->count() < 1 || $countUnitKerjaFromHistory < 11 || $proyeks->every(function ($history) {
                return $history->is_approved_1 == true;
            })) {
                $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->get();
            }
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);


                // dd($proyeks);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    $proyeks = $proyeks->where("dop", $dop);
                    // dd($dop, $proyeks);
                }
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    $proyeks = $proyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->where("unit_kerja", $unit_kerja_user);
                    $proyeks = $proyeks->where("unit_kerja", $unit_kerja_user);
                }
            }
            // dd($proyeks);
        } else {
            $proyeks = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("history_forecast.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->get();
            $countUnitKerjaFromHistory = $proyeks->groupBy('unit_kerja')->count();

            if ($proyeks->count() < 1 || $countUnitKerjaFromHistory < 11 || $proyeks->every(function ($history) {
                return $history->is_approved_1 == true;
            })) {
                $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->where("tahun_perolehan", $year)->where("tahun", $year)->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->get();
            }
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);
                // $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
                // dd($proyeks);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                    $proyeks = $proyeks->where("dop", $dop);
                    // dd($dop, $proyeks);
                }
            } else {
                // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                //     // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                //     $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
                // } else {
                //     // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->where("unit_kerja", $unit_kerja_user);
                //     $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) $month)->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
                // }
                $proyeks = $proyeks;
            }
            // $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) date("m"))->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);
        }

        // $proyeks = $proyeks->filter(function ($p) {
        //     return $p->Forecasts->filter(function ($f) {
        //         return $f->periode_prognosa == (int) date("m");
        //     });
        // });

        // $proyeks = $proyeks->where("proyeks.tahun_perolehan", "=", $year)->where("forecasts.tahun", "=", $year)->get();
        // $proyeks = $proyeks->get();

        $stage = null;
        switch ($tipe) {
            case "Menang":
                $proyeks = $proyeks->filter(function ($p) {
                    return $p->stage == 6;
                });
                break;
            case "Terkontrak":
                $stage = 8;
                $proyeks = $proyeks->where("stage", "=", $stage);
                break;
        }
        $row = 2;
        $proyeks = $proyeks->groupBy("kode_proyek");
        $proyeks = $proyeks->map(function ($p) use ($tipe) {
            $new_class = new stdClass();
            $new_class->nilai_perolehan = 0;
            $new_class->kode_proyek = $p->first()->kode_proyek;
            $new_class->nama_proyek = $p->first()->nama_proyek;

            if ($tipe == "Menang") {
                // $new_class->nilai_perolehan = (int) $p->sum(function ($f) {
                //     if (!empty($f->month_forecast)) {
                //         return (int) $f->nilai_forecast;
                //     }
                // });
                $new_class->nilai_perolehan = (int) $p->first()->nilai_perolehan;
            } else {
                $new_class->nilai_perolehan = (int) $p->sum(function ($f) {
                    if (!empty($f->month_realisasi) && $f->month_realisasi <= date('m')) {
                        return (int) $f->realisasi_forecast;
                    }
                });
            }

            if ($p->first()->tipe_proyek == "R") {
                $new_class->tipe_proyek = $p->first()->tipe_proyek;
                $new_class->bulan_pelaksanaan = $p->last()->bulan_pelaksanaan;
                $new_class->bulan_ri_perolehan = $p->last()->bulan_ri_perolehan;
            } else {
                $new_class->bulan_pelaksanaan = $p->last()->bulan_pelaksanaan;
                $new_class->bulan_ri_perolehan = $p->last()->bulan_ri_perolehan;
                $new_class->tipe_proyek = $p->first()->tipe_proyek;
            }
            $new_class->unit_kerja = UnitKerja::find($p->first()->unit_kerja)->unit_kerja;
            // $new_class->unit_kerja = $p->first()->unit_kerja;
            $new_class->stage = $p->first()->stage;
            $new_class->status_pasdin = $p->first()->status_pasdin;

            return $new_class;
        })->where("nilai_perolehan", "!=", 0)->each(function ($p) use ($sheet, &$row, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $p->unit_kerja);
            $sheet->setCellValue('E' . $row, $p->tipe_proyek);
            if ($tipe == "Terendah") {
                $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_pelaksanaan));
                $p->bulan = $p->bulan_pelaksanaan;
            } else {
                $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_ri_perolehan));
                $p->bulan = $p->bulan_ri_perolehan;
            }
            $sheet->setCellValue('G' . $row, $p->nilai_perolehan);
            $row++;
            // return $kp->each(function ($p) use ($sheet, &$row, $tipe) {
            // });
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }


    public function getDataCompetitive($tipe, $filter = false, $year)
    {
        $year = (int) $year;
        if ($filter == "false") {
            $filter = false;
        }
        
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai Perolehan");

        // dd($tipe);
        // $year = (int) date("Y");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator || Gate::any(['admin-crm'])) {
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tahun_perolehan", "jenis_proyek"]);
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get();
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    // $dop = str_replace("-", " ", $filter);
                    if ($filter == "PUSAT") {
                        $proyeks = $proyeks->whereIn("dop", ["DOP 1", "DOP 2"]);
                    } else {
                        $proyeks = $proyeks->where("dop", $filter);
                    }
                    // dd($filter);
                    // dd($dop, $proyeks);
                }
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu", "unit_kerja", "dop"]);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    if ($filter == "PUSAT") {
                        $proyeks = $proyeks->whereIn("dop", ["DOP 1", "DOP 2"]);
                    } else {
                        $proyeks = $proyeks->where("dop", $filter);
                    }
                    // dd($dop, $proyeks);
                }
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu", "unit_kerja", "dop"]);
            }
        }
        $proyeks = $proyeks->where("is_cancel", "=", false)->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year);
        switch ($tipe) {
            case "Terkontrak Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 8  && !$p->is_tidak_lulus_pq;
                })->sortBy([
                    ["bulan_pelaksanaan", "asc"],
                ])->values()->where("nilai_perolehan", "!=", 0);
                break;
            case "Menang Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 6  && !$p->is_tidak_lulus_pq;
                })->sortBy([
                    ["bulan_pelaksanaan", "asc"],
                ])->values()->where("nilai_perolehan", "!=", 0);
                break;
            case "Kalah Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 7 && !$p->is_tidak_lulus_pq;
                })->sortBy("bulan_pelaksanaan")->values();
                break;
            case "Tidak Lolos PQ Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->is_tidak_lulus_pq;
                })->sortBy("bulan_pelaksanaan")->values();
                break;
        }
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            if ($tipe == "Menang Tender") {
                $sheet->setCellValue('E' . $row, $p->bulan_ri_perolehan);
                $sheet->setCellValue('F' . $row, $p->nilai_perolehan != 0 ? $p->nilai_perolehan : 0);
            } elseif ($tipe == "Terkontrak Non Retail") {
                $sheet->setCellValue('E' . $row, $p->bulan_ri_perolehan);
                $sheet->setCellValue('F' . $row, $p->nilai_perolehan);
            } else {
                $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
                $sheet->setCellValue('F' . $row, $p->nilai_perolehan != 0 ? $p->nilai_perolehan : 0);
            }
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));
        // dd($proyeks);

        return response()->json(["tipe" => $tipe, "href" => $file_name, "data" => $proyeks]);
    }

    public function getDataCompetitiveNilai($tipe, $filter = false, $year)
    {
        $year = (int) $year;
        if ($filter == "false") {
            $filter = false;
        }
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai Penawaran");

        // dd($tipe);    
        // $year = (int) date("Y");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator || Gate::any(['admin-crm'])) {
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tahun_perolehan", "jenis_proyek"]);
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get();
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    // $dop = str_replace("-", " ", $filter);
                    if ($filter == "PUSAT") {
                        $proyeks = $proyeks->whereIn("dop", ["DOP 1", "DOP 2"]);
                    } else {
                        $proyeks = $proyeks->where("dop", $filter);
                    }
                    // dd($filter);
                    // dd($dop, $proyeks);
                }
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu", "unit_kerja", "dop"]);
                if ($filter != "" && strlen($filter) == 1) {
                    $proyeks = $proyeks->where("unit_kerja", $filter);
                    // dd($filter, $proyeks);
                } elseif ($filter != "") {
                    if ($filter == "PUSAT") {
                        $proyeks = $proyeks->whereIn("dop", ["DOP 1", "DOP 2"]);
                    } else {
                        $proyeks = $proyeks->where("dop", $filter);
                    }
                    // dd($dop, $proyeks);
                }
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "penawaran_tender", "tahun_perolehan", "jenis_proyek", "porsi_jo", "hps_pagu", "unit_kerja", "dop"]);
            }
        }
        $proyeks = $proyeks->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year);
        $stage = null;
        switch ($tipe) {
            case "Terkontrak Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 8  && !$p->is_tidak_lulus_pq;
                })->sortBy([
                    ["bulan_pelaksanaan", "asc"],
                ])->values()->where("nilai_perolehan", "!=", 0);
                break;
            case "Menang Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 6  && !$p->is_tidak_lulus_pq;
                })->sortBy([
                    ["bulan_pelaksanaan", "asc"],
                ])->values()->where("nilai_perolehan", "!=", 0);
                break;
            case "Kalah Non Retail":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 7 && !$p->is_tidak_lulus_pq;
                })->sortBy("bulan_pelaksanaan")->values();
                break;
            case "Tidak Lolos PQ Non Retail":
                // $stage = 3;
                $proyeks = $proyeks->where("is_tidak_lulus_pq", "=", true)->sortBy("bulan_pelaksanaan", SORT_NUMERIC)->values()->where("penawaran_tender", "!=", 0);
                break;
        }
        // dd($proyeks);
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
            switch ($tipe) {
                case "Terkontrak Non Retail":
                    $sheet->setCellValue('F' . $row, $p->nilai_perolehan);
                    break;
                case "Menang Non Retail":
                    $sheet->setCellValue('F' . $row, $p->nilai_perolehan != 0 ? $p->nilai_perolehan : 0);
                    break;
                case "Kalah Non Retail":
                    $sheet->setCellValue('F' . $row, $p->nilai_perolehan != 0 ? $p->nilai_perolehan : 0);
                    break;
                case "Tidak Lolos PQ Non Retail":
                    $sheet->setCellValue('F' . $row, $p->hps_pagu);
                    break;
            }
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["tipe" => $tipe, "href" => $file_name, "data" => $proyeks]);
    }

    public function getDataSumberDanaRKAP($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai RKAP");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        $tipe_real = "";
        if (str_contains($tipe, "BUMN")) {
            $tipe_real = str_replace("-", " / ", $tipe);
        } else {
            $tipe_real = str_replace("-", " ", $tipe);
        }
        if (!Auth::user()->check_administrator) {
            if ($filter != "") {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                }
            } else {
                if($tipe == "Retail") {
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                } else {
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                }
            }
        } else {
            if($tipe == "Retail") {
                $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            } else {
                $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            }
        }
        if($tipe != "Retail") {
            $proyeks = $proyeks->filter(function($p) use($tipe_real) {
                return !empty($p->SumberDana) && $p->SumberDana->kategori == $tipe_real;
            })->sortBy("nilai_rkap", SORT_REGULAR, true)->values();
        } else {
            $proyeks = $proyeks->map(function($p) {
                $new_p = new stdClass();
                $new_p->nama_proyek = $p->nama_proyek;
                $new_p->stage = $p->stage;
                $new_p->unit_kerja = $p->unit_kerja;
                $new_p->nilai_rkap = $p->Forecasts->filter(function($f) {
                    return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
                })->sum(function($f) {
                    return (int) $f->rkap_forecast;
                });
                return $new_p;
            })->sortByDesc("nilai_rkap")->values();
        }


        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $p->nilai_rkap);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataSumberDanaRealisasi($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai Realisasi");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        $tipe_real = "";
        if (str_contains($tipe, "BUMN")) {
            $tipe_real = str_replace("-", " / ", $tipe);
        } else {
            $tipe_real = str_replace("-", " ", $tipe);
        }
        if (!Auth::user()->check_administrator) {
            if ($filter != "") {
                // $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                }
            } else {
                if($tipe == "Retail") {
                    // $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                } else {
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                }
            }
        } else {
            if ($filter != "" && strlen($filter) == 1) {
                if($tipe == "Retail") {
                    $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "=", "R")->get();
                } else {
                    $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->get();
                }
            } elseif ($filter != "") {
                    $dop = str_replace("-", " ", $filter);
                if($tipe == "Retail") {
                    $proyeks = Proyek::with("UnitKerja")->where("dop", "=", $dop)->where("tipe_proyek", "=", "R")->get();
                } else {
                    $proyeks = Proyek::with("UnitKerja")->where("dop", "=", $dop)->get();
                }
            }
        }
        
        // $proyeks = $proyeks->where("stage", "=", 8)->filter(function($p) use($filter) {
        //     return !empty($p->SumberDana) && str_contains($p->SumberDana->kategori, $filter);
        // });
        $proyeks = $proyeks->where("stage", "=", 8)->filter(function($p) {
            return !empty($p->SumberDana);
        });

        if($tipe != "Retail") {
            $proyeks = $proyeks->filter(function($p) use($tipe_real) {
                return !empty($p->SumberDana) && $p->SumberDana->kategori == $tipe_real;
            })->sortByDesc("nilai_perolehan", SORT_REGULAR, true)->values();
        } else {
            $proyeks = $proyeks->map(function($p) {
                $new_p = new stdClass();
                $new_p->nama_proyek = $p->nama_proyek;
                $new_p->stage = $p->stage;
                $new_p->unit_kerja = $p->unit_kerja;
                $new_p->nilai_perolehan = $p->Forecasts->filter(function($f) {
                    return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
                })->sum(function($f) {
                    return (int) $f->realisasi_forecast;
                });
                return $new_p;
            })->sortByDesc("nilai_perolehan")->values();
        }
        
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $p->nilai_perolehan);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataInstansiOwnerRealisasi($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Instansi Owner');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', "Nilai");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        // $tipe_real = "";
        if (!Auth::user()->check_administrator) {
            // if ($filter != "") {
            //     // $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            //     // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //     $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     // } else {
            //     //     $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     // }
            // } else {
            //     // if($tipe == "Retail") {
            //     //     // $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            //     //     if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     //     } else {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     //     }
            //     // } else {
            //     //     if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     //     } else {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     //     }
            //     // }
            //     // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //     $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     // } else {
            //     //     $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     // }
            // }
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            } else {
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            }
        } else {
            if ($filter != "" && strlen($filter) == 1) {
                // if($tipe == "Retail") {
                //     $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "=", "R")->get();
                // } else {
                //     $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->get();
                // }
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->where("unit_kerja", "=", $filter)->get();
            } elseif ($filter != "") {
                $dop = str_replace("-", " ", $filter);
                // if($tipe == "Retail") {
                //     $proyeks = Proyek::with("UnitKerja")->where("dop", "=", $dop)->where("tipe_proyek", "=", "R")->get();
                // } else {
                //     $proyeks = Proyek::with("UnitKerja")->where("dop", "=", $dop)->get();
                // }
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->where("dop", "=", $dop)->get();
            } else {
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get();
            }
        }

        // if($tipe != "Retail") {
        //     $proyeks = $proyeks->filter(function($p) use($tipe) {
        //         return !empty($p->proyekBerjalan?->customer?->jenis_instansi) && str_contains($p->proyekBerjalan?->customer?->jenis_instansi, $tipe);
        //     })->sortByDesc("nilai_perolehan", SORT_REGULAR, true)->values();
        // } else {
        //     $proyeks = $proyeks->map(function($p) {
        //         $new_p = new stdClass();
        //         $new_p->nama_proyek = $p->nama_proyek;
        //         $new_p->stage = $p->stage;
        //         $new_p->unit_kerja = $p->unit_kerja;
        //         $new_p->nilai_perolehan = $p->Forecasts->filter(function($f) {
        //             return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
        //         })->sum(function($f) {
        //             return (int) $f->realisasi_forecast;
        //         });
        //         return $new_p;
        //     })->sortByDesc("nilai_perolehan")->values();
        // }

        $proyeksMapRetail = $proyeks->where('stage', 8)?->map(function ($p) {
            if ($p->tipe_proyek == "R") {
                $p->nilai_perolehan = $p->Forecasts->filter(function ($f) {
                    return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
                })->sum(function ($f) {
                    return (int) $f->realisasi_forecast;
                });
            }
            return $p;
        });

        $proyeks = $proyeksMapRetail->filter(function ($p) use ($tipe) {
            return !empty($p->proyekBerjalan?->customer?->jenis_instansi) && str_contains($p->proyekBerjalan?->customer?->jenis_instansi, $tipe);
        })->sortByDesc("nilai_perolehan", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->proyekBerjalan->customer->jenis_instansi);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->nilai_perolehan);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataInstansiOwnerRKAP($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Instansi Owner');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', "Nilai");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        // $tipe_real = "";
        if (!Auth::user()->check_administrator) {
            // if ($filter != "") {
            //     // $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            //     // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //     $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     // } else {
            //     //     $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     // }
            // } else {
            //     // if($tipe == "Retail") {
            //     //     // $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            //     //     if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     //     } else {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     //     }
            //     // } else {
            //     //     if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     //     } else {
            //     //         $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     //     }
            //     // }
            //     // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            //     //     $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            //     // } else {
            //     //     $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            //     // }
            // }
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            } else {
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
            }
        } else {
            if ($filter != "" && strlen($filter) == 1) {
                // if($tipe == "Retail") {
                //     $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "=", "R")->get();
                // } else {
                //     $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->get();
                // }
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->where("unit_kerja", "=", $filter)->get();
            } elseif ($filter != "") {
                $dop = str_replace("-", " ", $filter);
                // if($tipe == "Retail") {
                //     $proyeks = Proyek::with("UnitKerja")->where("dop", "=", $dop)->where("tipe_proyek", "=", "R")->get();
                // } else {
                //     $proyeks = Proyek::with("UnitKerja")->where("dop", "=", $dop)->get();
                // }
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->where("dop", "=", $dop)->get();
            } else {
                $proyeks = Proyek::with("UnitKerja", "proyekBerjalan")->get();
            }
        }

        // if($tipe != "Retail") {
        //     $proyeks = $proyeks->filter(function($p) use($tipe) {
        //         return !empty($p->proyekBerjalan?->customer?->jenis_instansi) && str_contains($p->proyekBerjalan?->customer?->jenis_instansi, $tipe);
        //     })->sortByDesc("nilai_perolehan", SORT_REGULAR, true)->values();
        // } else {
        //     $proyeks = $proyeks->map(function($p) {
        //         $new_p = new stdClass();
        //         $new_p->nama_proyek = $p->nama_proyek;
        //         $new_p->stage = $p->stage;
        //         $new_p->unit_kerja = $p->unit_kerja;
        //         $new_p->nilai_perolehan = $p->Forecasts->filter(function($f) {
        //             return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
        //         })->sum(function($f) {
        //             return (int) $f->realisasi_forecast;
        //         });
        //         return $new_p;
        //     })->sortByDesc("nilai_perolehan")->values();
        // }

        $proyeksMapRetail = $proyeks->map(function ($p) {
            if ($p->tipe_proyek == "R") {
                $p->nilai_rkap = $p->Forecasts->filter(function ($f) {
                    return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
                })->sum(function ($f) {
                    return (int) $f->rkap_forecast;
                });
            }
            return $p;
        });

        $proyeks = $proyeksMapRetail->filter(function ($p) use ($tipe) {
            return !empty($p->proyekBerjalan?->customer?->jenis_instansi) && str_contains($p->proyekBerjalan?->customer?->jenis_instansi, $tipe);
        })->sortByDesc("nilai_rkap", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->proyekBerjalan->customer->jenis_instansi);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->nilai_rkap);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataNilaiOK($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        $tipe = str_replace("-", " ", $tipe);
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai RKAP");

        $unit_kerja = UnitKerja::where("unit_kerja", "=", $tipe)->first();
        $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $unit_kerja->divcode)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);

        $proyeks = $proyeks->sortBy("nilai_rkap", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $nilaiRKAP = 0;
            $p->Forecasts->each(function ($f) use (&$nilaiRKAP) {
                $nilaiRKAP += (int) $f->rkap_forecast;
            });
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $nilaiRKAP);
            $p->nilai_rkap = $nilaiRKAP;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-Nilai-OK-Kumulatif-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataNilaiRealisasi($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        $tipe = str_replace("-", " ", $tipe);
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai Realisasi");

        // $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $tipe)->first();
        $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $unit_kerja->divcode)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->where("stage", "=", 8)->where("is_cancel", "!=", true);

        $proyeks = $proyeks->sortBy("nilai_perolehan", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $nilaiRealisasi = 0;
            $p->Forecasts->each(function ($f) use (&$nilaiRealisasi) {
                $nilaiRealisasi += (int) $f->realisasi_forecast;
            });
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $nilaiRealisasi);
            $p->nilai_perolehan = $nilaiRealisasi;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-Nilai-Realisasi-Kumulatif-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }


    public static function getFullMonth($month)
    {
        switch ($month) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    public static function getProyekStage($month)
    {
        switch ($month) {
            case 0:
                return "Pasar Dini";
                break;
            case 1:
                return "Pasar Dini";
                break;
            case 2:
                return "Pasar Potensial";
                break;
            case 3:
                return "Prakualifikasi";
                break;
            case 4:
                return "Tender Diikuti";
                break;
            case 5:
                return "Perolehan";
                break;
            case 6:
                return "Menang";
                break;
            case 7:
                return "Terendah";
                break;
            case 8:
                return "Terkontrak";
                break;
        }
    }

    public static function getUnitKerjaProyek($divcode)
    {
        return UnitKerja::where("divcode", "=", $divcode)->first()->unit_kerja;
    }

    static function copyDataForecast()
    {
        $month = (int) date("m");
        $year = (int) date("Y");
        $is_forecasts_exist = Forecast::where("periode_prognosa", "=", $month)->where("tahun", "=", $year)->get()->count() > 0 ? true : false;
        if (!$is_forecasts_exist) {
            if ($month == 1) {
                return;
                // $forecasts = Forecast::where("periode_prognosa", "=", $month + 11)->where("tahun", "=", $year - 1)->get();
            } else {
                $forecasts = Forecast::where("periode_prognosa", "=", $month - 1)->where("tahun", "=", $year)->get();
            }
            $forecasts->each(function ($f) use ($month, $year) {
                $new_forecast = $f->replicate();
                // dd($f);
                $new_forecast->created_at = now();
                $new_forecast->updated_at = now();
                $new_forecast->periode_prognosa = $month;
                $new_forecast->tahun = $year;
                $new_forecast->save();
                // dd($new_forecast);
            });
        }
    }

    static function deleteOldExcelFiles()
    {
        $files = collect(File::allFiles(public_path("excel")));
        $files->each(function ($file) {
            $now = Carbon::now();
            $file_date = Carbon::createFromTimestamp($file->getMTime());
            $diff_date = $file_date->diffInMinutes($now, true);
            if ($diff_date > 29) File::delete($file);
        });
    }
}
