<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\UnitKerja;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class ForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $periode = "", $year = "")
    {

        // $id = Dop::find('id');
        // $dopProyek = Proyek::find($id);
        $column = $request->get("column");
        $filter = $request->get("filter");

        $periode = $periode != "" ? (int) $periode : (int) date("m");
        $year = $year != "" ? (int) $year : (int) date("Y");

        if (Auth::user()->check_administrator) {
            $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", $periode)->get();
            $nilaiRKAP = Proyek::all()->where("jenis_proyek", "!=", "I");
        } else {
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", $periode)->whereYear("forecasts.created_at", "=", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $nilaiRKAP = Proyek::all()->whereIn("unit_kerja", $unit_kerja_user->toArray())->where("jenis_proyek", "!=", "I");
            } else {
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("forecasts.periode_prognosa", "=", $periode)->whereYear("forecasts.created_at", "=", $year)->get();
                $nilaiRKAP = Proyek::all()->whereIn("unit_kerja", Auth::user()->unit_kerja)->where("jenis_proyek", "!=", "I");
            }
        }

        if (isset($filter)) {
            $nilaiHistoryForecast = $nilaiHistoryForecast->filter(function ($p) use ($filter) {
                return preg_match("/$filter/i", $p->nama_proyek);
            });
            $nilaiRKAP = $nilaiRKAP->filter(function ($p) use ($filter) {
                return preg_match("/$filter/i", $p->nama_proyek);
            });
        }
        // dd($nilaiRKAP);
        $nilaiTotalRKAPTahun = $nilaiHistoryForecast->sum(function ($n) {
            return (int) $n->rkap_forecast;
        });
        $nilaiTotalForecastTahun = $nilaiHistoryForecast->sum(function ($n) {
            return (int) $n->nilai_forecast;
        });
        $nilaiTotalRealisasiTahun = $nilaiHistoryForecast->sum(function ($n) {
            if ($n->stage == 8) {
                return (int) $n->realisasi_forecast;
            }
        });
        // dd($nilaiForecast);
        // $nilaiForecastArray = [];
        // $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");

        // for ($i = 1; $i <= 12; $i++) {
        //     foreach ($historyForecast as $forecast) {
        //         if ($forecast->month_forecast == $i) {
        //             $nilaiForecast += $forecast->nilai_forecast / 1000000;
        //         } else {
        //             $nilaiForecast == 0;
        //         }
        //         array_push($nilaiForecastArray, round($nilaiForecast));
        //     }
        // }

        $previous_periode_prognosa = $periode != "" ? (int) $periode - 1 : (int) date("m") - 1;
        $year_previous_forecast = $year != "" ? (int) $year : (int) date("Y");
        if ($previous_periode_prognosa < 1) {
            $year_previous_forecast--;
            $previous_periode_prognosa = 12;
        }

        if (($periode != "" && $year != "") || Auth::user()->check_administrator) {
            // $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $historyForecast = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->where("history.periode_prognosa", "=", $periode, "or")->whereYear("history.created_at", $year)->get();
            // $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", "=", $year)->where("f.periode_prognosa", '=', $periode)->get()->groupBy(["periode_prognosa"]);
            $previous_forecast = DB::table("forecasts as f")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("dops", "proyeks.dop", "=", "dops.dop")->get();
            // $previous_forecast = DB::table("forecasts as f")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("dops", "proyeks.dop", "=", "dops.dop")->get()->sortByDesc("nilai_forecast", SORT_NUMERIC)->groupBy(["dop", "unit_kerja", "kode_proyek"]);
            // $previous_forecast = [0 => $previous_forecast];
            // $previous_forecast->map(function($data) {
            //     $data->map(function($d) {
            //         dd($d);
            //     });
            // });
            // dd($previous_forecast);
        } else {
            // $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->join("unit_kerjas", "proyeks.kode_proyek", "=", "unit_kerjas.divcode")->whereYear("f.created_at", "=", $year)->where("f.periode_prognosa", '=', $periode)->join("dops", "proyeks.dop", "=", "dops.dop")->get()->sortByDesc("nilai_forecast", SORT_NUMERIC)->groupBy(["dop", "kode_proyek"]);
            // $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            $historyForecast = DB::table("history_forecast as f")->select(["f.*", "proyeks.unit_kerja"])->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja->toArray())->where("is_approved_1", "!=", "f")->groupBy("unit_kerja");
        } else {
            $historyForecast = DB::table("history_forecast as f")->select(["f.*", "proyeks.unit_kerja"])->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", $year)->where("is_approved_1", "!=", "f")->get()->groupBy("unit_kerja");
        }
        $historyForecast = $historyForecast->keys()->map(function($key) {
            $unit_kerja = UnitKerja::where("divcode", "=", $key)->first()->unit_kerja;
            return $unit_kerja;
        });
        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }
        if (Auth::user()->check_administrator) {
            // $proyeks = collect();
            $dops = Dop::all()->sortBy("dop");
            // dd($proyeks);
        } else {
            // $proyeks = collect();
            // $dops = Dop::all()->sortBy("dop");

            // dd($unit_kerja);
            $dops = Dop::all()->sortBy("dop");
            // if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            //     // $proyeks = Proyek::with("Forecasts")->get()->whereIn("unit_kerja", $unit_kerja->toArray());
            //     // dd($dops);
            //     // dd($dops);
            //     // foreach ($dops as $dop_name => $dop) {
            //     //     $divcodes = $dop->map(function($data) {
            //     //         return $data->divcode;
            //     //     });
            //     //     foreach ($dop as $item_dop) {
            //     //         dd($item_dop->UnitKerjas->whereIn("divcode", $divcodes->toArray()));
            //     //     }
            //     // }
            // } 
        }

        // if (!empty($column) && !empty($filter)) {
        //     // $dops = $dops->where("dop", "=", $filter);
        //     $dops = $dops->filter(function ($data) use ($filter, $column, $proyeks) {
        //         switch ($column) {
        //             case "dop":
        //                 return str_contains(strtolower($data->dop), strtolower($filter));
        //             case "unit_kerja":
        //                 $unit_kerjas = UnitKerja::all()->filter(function ($unit_kerja) use ($filter) {
        //                     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
        //                 });
        //                 foreach ($unit_kerjas as $unit_kerja) {
        //                     if ($unit_kerja->dop == $data->dop) {
        //                         return $data;
        //                     }
        //                 }
        //             case "nama_proyek":
        //                 $proyeks_arr = $proyeks->filter(function ($data) use ($filter) {
        //                     // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
        //                     // return false !== stripos($data->nama_proyek, $filter);
        //                     return preg_match("/$filter/", $data->nama_proyek);
        //                 });
        //                 // $unit_kerjas = UnitKerja::all()->filter(function($unit_kerja) use($filter) {
        //                 //     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
        //                 // });

        //                 foreach ($proyeks_arr as $proyek) {
        //                     if ($proyek->dop == $data->dop) {
        //                         return $data;
        //                     }
        //                 }
        //                 // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
        //         }
        //     });

        //     $proyeks = $proyeks->filter(function ($data) use ($filter, $column) {
        //         switch ($column) {
        //             case "dop":
        //                 return str_contains(strtolower($data->dop), strtolower($filter));
        //             case "unit_kerja":
        //                 $unit_kerjas = UnitKerja::all()->filter(function ($unit_kerja) use ($data, $filter) {
        //                     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
        //                 });
        //                 foreach ($unit_kerjas as $unit_kerja) {
        //                     if ($unit_kerja->divcode == $data->unit_kerja) {
        //                         return $data;
        //                     }
        //                 }
        //             case "nama_proyek":
        //                 // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
        //                 return preg_match("/$filter/", $data->nama_proyek);
        //         }
        //     });
        //     // $proyeks_eksternal = $proyeks->filter()
        // }

        // dd($proyeks->groupBy(["dop", "unit_kerja"]));

        return view(
            'Forecast/viewForecast',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast,
                // 'dops' => Dop::all(),
                // "historyForecast_all" => $historyForecast_all,
                'dops' => $dops,
                // 'proyeks' => $proyeks,
                "nilaiTotalRKAPTahun" => $nilaiTotalRKAPTahun,
                "nilaiTotalForecastTahun" => $nilaiTotalForecastTahun,
                "nilaiTotalRealisasiTahun" => $nilaiTotalRealisasiTahun,
                "is_forecast" => true,
                "previous_periode_prognosa" => $previous_periode_prognosa,
                "year_previous_forecast" => $year_previous_forecast,
                "month_title" => $month_title,
                "periode" => $periode,
                "per_sejuta" => 1000000,
                "year" => $year,
                "previous_forecast" => $previous_forecast,
                "column" => $column,
                "filter" => $filter,
            ]
        );
        // 'unitkerjas' => UnitKerja::all()]);
    }

    public function viewForecastInternal(Request $request, $periode = "", $year = "")
    {
        // $id = Dop::find('id');
        // $dopProyek = Proyek::find($id);
        $column = $request->get("column");
        $filter = $request->get("filter");

        $periode = $periode != "" ? (int) $periode : (int) date("m");
        $year = $year != "" ? (int) $year : (int) date("Y");

        if (Auth::user()->check_administrator) {
            $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("forecasts.periode_prognosa", "=", $periode)->get();
            $nilaiRKAP = Proyek::all();
        } else {
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $nilaiRKAP = Proyek::all()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("forecasts.periode_prognosa", "=", $periode)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            } else {
                $nilaiRKAP = Proyek::all()->whereIn("unit_kerja", Auth::user()->unit_kerja);
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("forecasts.periode_prognosa", "=", $periode)->get();
            }
        }

        // $nilaiTotalRKAPTahun = $nilaiRKAP->sum(function ($p) {
        //     if($p->tipe_proyek == "R") {
        //         return $p->forecasts->sum(function($f) {
        //             return (int) $f->rkap_forecast;
        //         });
        //     } else {
        //         return (int) $p->nilai_rkap;
        //     }
        // });
        $nilaiTotalForecastTahun = $nilaiHistoryForecast->sum(function ($n) {
            return (int) $n->nilai_forecast;
        });
        $nilaiTotalRealisasiTahun = $nilaiHistoryForecast->sum(function ($n) {
            if ($n->stage == 8) {
                return (int) $n->realisasi_forecast;
            }
        });

        $previous_periode_prognosa = $periode != "" ? (int) $periode - 1 : (int) date("m") - 1;
        $year_previous_forecast = $year != "" ? (int) $year : (int) date("Y");
        if ($previous_periode_prognosa < 1) {
            $year_previous_forecast--;
            $previous_periode_prognosa = 12;
        }

        if (($periode != "" && $year != "") || Auth::user()->check_administrator) {
            // $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $historyForecast = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->where("history.periode_prognosa", "=", $periode, "or")->whereYear("history.created_at", $year)->get();
            // $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", "=", $year)->where("f.periode_prognosa", '=', $periode)->get()->groupBy(["periode_prognosa"]);
            $previous_forecast = DB::table("forecasts as f")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("dops", "proyeks.dop", "=", "dops.dop")->get();
            // $previous_forecast = DB::table("forecasts as f")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("dops", "proyeks.dop", "=", "dops.dop")->get()->sortByDesc("nilai_forecast", SORT_NUMERIC)->groupBy(["dop", "unit_kerja", "kode_proyek"]);
            // $previous_forecast = [0 => $previous_forecast];
            // $previous_forecast->map(function($data) {
            //     $data->map(function($d) {
            //         dd($d);
            //     });
            // });
            // dd($previous_forecast);
        } else {
            // $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->join("unit_kerjas", "proyeks.kode_proyek", "=", "unit_kerjas.divcode")->whereYear("f.created_at", "=", $year)->where("f.periode_prognosa", '=', $periode)->join("dops", "proyeks.dop", "=", "dops.dop")->get()->sortByDesc("nilai_forecast", SORT_NUMERIC)->groupBy(["dop", "kode_proyek"]);
            // $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja->toArray())->groupBy(["periode_prognosa"]);
        } else {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }
        if (Auth::user()->check_administrator) {
            // $proyeks = collect();
            // $proyeks = Proyek::with(["Forecasts", "HistoryForecasts"])->get();
            $dops = Dop::all()->sortBy("dop");
            // dd($proyeks);
        } else {
            // $proyeks = collect();
            $dops = Dop::all()->sortBy("dop");

            // dd($unit_kerja);
            // $dops = Dop::all();
            // if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            //     // $proyeks = Proyek::with("Forecasts")->get()->whereIn("unit_kerja", $unit_kerja->toArray());
            //     // dd($dops);
            //     // dd($dops);
            //     // foreach ($dops as $dop_name => $dop) {
            //     //     $divcodes = $dop->map(function($data) {
            //     //         return $data->divcode;
            //     //     });
            //     //     foreach ($dop as $item_dop) {
            //     //         dd($item_dop->UnitKerjas->whereIn("divcode", $divcodes->toArray()));
            //     //     }
            //     // }
            // } 
        }

        // if (!empty($column) && !empty($filter)) {
        //     // $dops = $dops->where("dop", "=", $filter);
        //     $dops = $dops->filter(function ($data) use ($filter, $column, $proyeks) {
        //         switch ($column) {
        //             case "dop":
        //                 return str_contains(strtolower($data->dop), strtolower($filter));
        //             case "unit_kerja":
        //                 $unit_kerjas = UnitKerja::all()->filter(function ($unit_kerja) use ($filter) {
        //                     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
        //                 });
        //                 foreach ($unit_kerjas as $unit_kerja) {
        //                     if ($unit_kerja->dop == $data->dop) {
        //                         return $data;
        //                     }
        //                 }
        //             case "nama_proyek":
        //                 $proyeks_arr = $proyeks->filter(function ($data) use ($filter) {
        //                     // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
        //                     // return false !== stripos($data->nama_proyek, $filter);
        //                     return preg_match("/$filter/", $data->nama_proyek);
        //                 });
        //                 // $unit_kerjas = UnitKerja::all()->filter(function($unit_kerja) use($filter) {
        //                 //     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
        //                 // });

        //                 foreach ($proyeks_arr as $proyek) {
        //                     if ($proyek->dop == $data->dop) {
        //                         return $data;
        //                     }
        //                 }
        //                 // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
        //         }
        //     });

        //     $proyeks = $proyeks->filter(function ($data) use ($filter, $column) {
        //         switch ($column) {
        //             case "dop":
        //                 return str_contains(strtolower($data->dop), strtolower($filter));
        //             case "unit_kerja":
        //                 $unit_kerjas = UnitKerja::all()->filter(function ($unit_kerja) use ($data, $filter) {
        //                     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
        //                 });
        //                 foreach ($unit_kerjas as $unit_kerja) {
        //                     if ($unit_kerja->divcode == $data->unit_kerja) {
        //                         return $data;
        //                     }
        //                 }
        //             case "nama_proyek":
        //                 // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
        //                 return preg_match("/$filter/", $data->nama_proyek);
        //         }
        //     });
        //     // $proyeks_eksternal = $proyeks->filter()
        // }

        // dd($proyeks->groupBy(["dop", "unit_kerja"]));

        return view(
            'Forecast/viewForecast',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast,
                // 'dops' => Dop::all(),
                // "historyForecast_all" => $historyForecast_all,
                'dops' => $dops,
                // 'proyeks' => $proyeks,
                // "forecast" => true,
                // "nilaiTotalRKAPTahun" => $nilaiTotalRKAPTahun,
                "nilaiTotalForecastTahun" => $nilaiTotalForecastTahun,
                "nilaiTotalRealisasiTahun" => $nilaiTotalRealisasiTahun,
                "previous_periode_prognosa" => $previous_periode_prognosa,
                "year_previous_forecast" => $year_previous_forecast,
                "month_title" => $month_title,
                "periode" => $periode,
                "per_sejuta" => 1000000,
                "year" => $year,
                "previous_forecast" => $previous_forecast,
                "column" => $column,
                "filter" => $filter,
            ]
        );
        // 'unitkerjas' => UnitKerja::all()]);
    }

    public function viewForecastKumulatifEksternal(Request $request, $periode = "", $year = "")
    {

        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        $periode = $periode != "" ? (int) $periode : (int) date("m");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }

        $year = $year != "" ? (int) $year : (int) date("Y");
        $unitKerjas = UnitKerja::all();
        $historyForecast = HistoryForecast::where("periode_prognosa", "=", $periode, "or")->get();
        // $historyForecast = HistoryForecast::where("periode_prognosa", "=", $periode)->get();


        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;

        // $selectForecast = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->select(["proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja", "proyeks.jenis_proyek", "proyeks.tipe_proyek", "proyeks.dop", "forecasts.month_forecast", "forecasts.nilai_forecast", "forecasts.month_rkap", "forecasts.rkap_forecast", "forecasts.month_realisasi", "forecasts.realisasi_forecast", "forecasts.periode_prognosa", "forecasts.created_at"])->where("forecasts.periode_prognosa", "=", $periode, "or")->where("proyeks.jenis_proyek", "!=", "I");
        // $selectForecastInternal = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->select(["proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja", "proyeks.jenis_proyek", "proyeks.tipe_proyek", "proyeks.dop", "forecasts.month_forecast", "forecasts.nilai_forecast", "forecasts.month_rkap", "forecasts.rkap_forecast", "forecasts.month_realisasi", "forecasts.realisasi_forecast", "forecasts.periode_prognosa", "forecasts.created_at"])->where("forecasts.periode_prognosa", "=", $periode, "or");
        $selectForecast = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->select(["proyeks.stage", "proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja", "proyeks.jenis_proyek", "proyeks.tipe_proyek", "proyeks.dop", "forecasts.month_forecast", "forecasts.nilai_forecast", "forecasts.month_rkap", "forecasts.rkap_forecast", "forecasts.month_realisasi", "forecasts.realisasi_forecast", "forecasts.periode_prognosa", "forecasts.created_at"])->where("forecasts.periode_prognosa", "=", $periode)->whereYear("forecasts.created_at", $year)->where("proyeks.jenis_proyek", "!=", "I");
        // $selectForecastInternal = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->select(["proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja", "proyeks.jenis_proyek", "proyeks.tipe_proyek", "proyeks.dop", "forecasts.month_forecast", "forecasts.nilai_forecast", "forecasts.month_rkap", "forecasts.rkap_forecast", "forecasts.month_realisasi", "forecasts.realisasi_forecast", "forecasts.periode_prognosa", "forecasts.created_at"])->where("forecasts.periode_prognosa", "=", $periode, "or")->whereYear("forecasts.created_at", $year);
        if (Auth::user()->check_administrator) {
            // $dops = Dop::with(["Proyek"])->get()->sortBy("dop");

            $forecastKumulatifEksternal = $selectForecast->get()->sortBy("dop")->groupBy(["dop", "unit_kerja"]);
            // $forecastKumulatifIncludeInternal = $selectForecastInternal->get()->sortBy("dop")->groupBy(["dop", "unit_kerja"]);
        } elseif ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            // $dop = Dop::with(["Proyek"])->get()->sortBy("dop");
            // $dops =  $dop->filter(function ($dataDop) use($unit_kerja_user) {
            //     return $dataDop->UnitKerjas->whereIn("divcode", $unit_kerja_user->toArray())->count() > 0 ? true : false;
            // });
            $forecastKumulatifEksternal = $selectForecast->where("proyeks.jenis_proyek", "!=", "I")->get()->sortBy("dop")->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy(["dop", "unit_kerja"]);
            // $forecastKumulatifIncludeInternal = $selectForecastInternal->get()->sortBy("dop")->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy(["dop", "unit_kerja"]);
        } else {
            // $dop = Dop::with(["Proyek"])->get()->sortBy("dop");
            // $dops =  $dop->filter(function ($dataDop) {
            //     return $dataDop->UnitKerjas->where("divcode", "=", Auth::user()->unit_kerja)->first();
            // });
            $forecastKumulatifEksternal = $selectForecast->where("proyeks.jenis_proyek", "!=", "I")->get()->where("unit_kerja", "=", Auth::user()->unit_kerja)->groupBy(["dop", "unit_kerja"]);
            // $forecastKumulatifIncludeInternal = $selectForecastInternal->get()->where("unit_kerja", "=", Auth::user()->unit_kerja)->groupBy(["dop", "unit_kerja"]);
        }

        // dd($selectForecast->get());
        $forecastEkstenal = true;

        return view('Forecast/viewForecastKumulatifEksternal', compact(['month_title', 'periode', 'forecastKumulatifEksternal', 'unitKerjas', 'historyForecast', 'forecastEkstenal']));
    }

    public function viewForecastKumulatifIncludeInternal(Request $request, $periode = "", $year = "")
    {

        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        $periode = $periode != "" ? (int) $periode : (int) date("m");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }

        $year = $year != "" ? (int) $year : (int) date("Y");
        $unitKerjas = UnitKerja::all();
        $historyForecast = HistoryForecast::where("periode_prognosa", "=", $periode, "or")->get();

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;

        $selectForecast = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->select(["proyeks.stage", "proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja", "proyeks.jenis_proyek", "proyeks.tipe_proyek", "proyeks.dop", "forecasts.month_forecast", "forecasts.nilai_forecast", "forecasts.month_rkap", "forecasts.rkap_forecast", "forecasts.month_realisasi", "forecasts.realisasi_forecast", "forecasts.periode_prognosa", "forecasts.created_at"])->where("forecasts.periode_prognosa", "=", $periode)->whereYear("forecasts.created_at", $year);
        if (Auth::user()->check_administrator) {

            $forecastKumulatifEksternal = $selectForecast->get()->sortBy("dop")->groupBy(["dop", "unit_kerja"]);
        } elseif ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $forecastKumulatifEksternal = $selectForecast->get()->sortBy("dop")->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy(["dop", "unit_kerja"]);
        } else {
            $forecastKumulatifEksternal = $selectForecast->get()->where("unit_kerja", "=", Auth::user()->unit_kerja)->groupBy(["dop", "unit_kerja"]);
        }

        $forecastInternal = true;

        return view('Forecast/viewForecastKumulatifEksternal', compact(['month_title', 'periode', 'forecastKumulatifEksternal', 'unitKerjas', 'historyForecast', 'forecastInternal']));
    }

    // public function viewForecastInternal(Request $request, $periode = "", $year = "")
    // {
    //     // $id = Dop::find('id');
    //     // $dopProyek = Proyek::find($id);
    //     $column = $request->get("column");
    //     $filter = $request->get("filter");

    //     $periode = $periode != "" ? (int) $periode : (int) date("m");
    //     $year = $year != "" ? (int) $year : (int) date("Y");
    //     $previous_periode_prognosa = $periode != "" ? (int) $periode - 1 : (int) date("m") - 1;
    //     $year_previous_forecast = $year != "" ? (int) $year : (int) date("Y");
    //     if ($previous_periode_prognosa < 1) {
    //         $year_previous_forecast--;
    //         $previous_periode_prognosa = 12;
    //     }

    //     if (($periode != "" && $year != "") || Auth::user()->check_administrator) {
    //         // $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
    //         // $historyForecast = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->where("history.periode_prognosa", "=", $periode, "or")->whereYear("history.created_at", $year)->get();
    //         // $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", "=", $year)->where("f.periode_prognosa", '=', $periode)->get()->groupBy(["periode_prognosa"]);
    //         // $previous_forecast = DB::table("forecasts as f")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("dops", "proyeks.dop", "=", "dops.dop")->get();
    //         // $previous_forecast = DB::table("forecasts as f")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("dops", "proyeks.dop", "=", "dops.dop")->get()->sortByDesc("nilai_forecast", SORT_NUMERIC)->groupBy(["dop", "unit_kerja", "kode_proyek"]);
    //         // $previous_forecast = [0 => $previous_forecast];
    //         // $previous_forecast->map(function($data) {
    //         //     $data->map(function($d) {
    //         //         dd($d);
    //         //     });
    //         // });
    //         // dd($previous_forecast);
    //     } else {
    //         // $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
    //         // $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->join("unit_kerjas", "proyeks.kode_proyek", "=", "unit_kerjas.divcode")->whereYear("f.created_at", "=", $year)->where("f.periode_prognosa", '=', $periode)->join("dops", "proyeks.dop", "=", "dops.dop")->get()->sortByDesc("nilai_forecast", SORT_NUMERIC)->groupBy(["dop", "kode_proyek"]);
    //     }
    //     $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
    //     // if ($unit_kerja instanceof \Illuminate\Support\Collection) {
    //     //     $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja->toArray())->groupBy(["periode_prognosa"]);
    //     // } else {
    //     //     $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
    //     // }
    //     $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
    //     if ($periode != "") {
    //         $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
    //     }
    //     if (Auth::user()->check_administrator) {
    //         // $proyeks = collect();
    //         // $proyeks = Proyek::with(["Forecasts", "HistoryForecasts"])->get();
    //         $dops = Dop::cursor()->sortBy("dop");
    //         // dd($proyeks);
    //     } else {
    //         // $proyeks = collect();
    //         // $dops = Dop::cursor()->sortBy("dop");

    //         // dd($unit_kerja);
    //         $dops = Dop::cursor();
    //         // if ($unit_kerja instanceof \Illuminate\Support\Collection) {
    //         //     // $proyeks = Proyek::with("Forecasts")->get()->whereIn("unit_kerja", $unit_kerja->toArray());
    //         //     // dd($dops);
    //         //     // dd($dops);
    //         //     // foreach ($dops as $dop_name => $dop) {
    //         //     //     $divcodes = $dop->map(function($data) {
    //         //     //         return $data->divcode;
    //         //     //     });
    //         //     //     foreach ($dop as $item_dop) {
    //         //     //         dd($item_dop->UnitKerjas->whereIn("divcode", $divcodes->toArray()));
    //         //     //     }
    //         //     // }
    //         // } 
    //     }

    //     if (!empty($column) && !empty($filter)) {
    //         // $dops = $dops->where("dop", "=", $filter);
    //         $dops = $dops->filter(function ($data) use ($filter, $column, $proyeks) {
    //             switch ($column) {
    //                 case "dop":
    //                     return str_contains(strtolower($data->dop), strtolower($filter));
    //                 case "unit_kerja":
    //                     $unit_kerjas = UnitKerja::all()->filter(function ($unit_kerja) use ($filter) {
    //                         return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
    //                     });
    //                     foreach ($unit_kerjas as $unit_kerja) {
    //                         if ($unit_kerja->dop == $data->dop) {
    //                             return $data;
    //                         }
    //                     }
    //                 case "nama_proyek":
    //                     $proyeks_arr = $proyeks->filter(function ($data) use ($filter) {
    //                         // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
    //                         // return false !== stripos($data->nama_proyek, $filter);
    //                         return preg_match("/$filter/", $data->nama_proyek);
    //                     });
    //                     // $unit_kerjas = UnitKerja::all()->filter(function($unit_kerja) use($filter) {
    //                     //     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
    //                     // });

    //                     foreach ($proyeks_arr as $proyek) {
    //                         if ($proyek->dop == $data->dop) {
    //                             return $data;
    //                         }
    //                     }
    //                     // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
    //             }
    //         });

    //         $proyeks = $proyeks->filter(function ($data) use ($filter, $column) {
    //             switch ($column) {
    //                 case "dop":
    //                     return str_contains(strtolower($data->dop), strtolower($filter));
    //                 case "unit_kerja":
    //                     $unit_kerjas = UnitKerja::all()->filter(function ($unit_kerja) use ($data, $filter) {
    //                         return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
    //                     });
    //                     foreach ($unit_kerjas as $unit_kerja) {
    //                         if ($unit_kerja->divcode == $data->unit_kerja) {
    //                             return $data;
    //                         }
    //                     }
    //                 case "nama_proyek":
    //                     // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
    //                     return preg_match("/$filter/", $data->nama_proyek);
    //             }
    //         });
    //         // $proyeks_eksternal = $proyeks->filter()
    //     }

    //     // dd($proyeks->groupBy(["dop", "unit_kerja"]));

    //     return view(
    //         'Forecast/viewForecastInternal',
    //         [
    //             // 'forecast' => Forecast::all(),
    //             // "historyForecast" => $historyForecast,
    //             // 'dops' => Dop::all(),
    //             // "historyForecast_all" => $historyForecast_all,
    //             'dops' => $dops,
    //             // 'proyeks' => $proyeks,
    //             "forecast_internal" => true,
    //             "previous_periode_prognosa" => $previous_periode_prognosa,
    //             "year_previous_forecast" => $year_previous_forecast,
    //             "month_title" => $month_title,
    //             "periode" => $periode,
    //             "per_sejuta" => 1000000,
    //             "year" => $year,
    //             // "previous_forecast" => $previous_forecast,
    //             "column" => $column,
    //             "filter" => $filter,
    //         ]
    //     );
    //     // 'unitkerjas' => UnitKerja::all()]);
    // }



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
     * @param  \App\Models\Forecast  $forecast
     * @return \Illuminate\Http\Response
     */
    public function show(Forecast $forecast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forecast  $forecast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forecast $forecast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forecast  $forecast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forecast $forecast)
    {
        //
    }

    /**
     * Getting all data when reload trigger in forecast page
     * 
     * @return \Illuminate\Http\Response
     */
    public function getAllData()
    {
        if (Auth::user()->check_administrator) {
            $proyeks = Proyek::all();
        } else {
            $proyeks = Proyek::where("unit_kerja", "=", Auth::user()->unit_kerja)->get();
        }
        return response()->json([
            'dops' => Dop::all(),
            'proyeks' => $proyeks
        ]);
    }

    /**
     * Getting all data from unit kerja
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getAllDataUnitKerjas(Request $request)
    {
        $dop_name = $request->dop_name;
        $unit_kerjas = DB::table('unit_kerjas')->where("dop", "=", $dop_name)->get();
        return response()->json([
            "unit_kerjas" => $unit_kerjas,
        ]);
    }

    public function requestApprovalHistoryView(Request $request)
    {
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator) {
            if ($unit_kerja_user instanceof Collection) {
                $historyForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->select(["proyeks.nama_proyek", "unit_kerjas.divcode", "proyeks.dop", "unit_kerjas.unit_kerja", "history_forecast.*", "history_forecast.created_at", "proyeks.stage", "proyeks.is_cancel"])->whereYear("history_forecast.created_at", "=", (int) date("Y"))->get()->whereIn("divcode", $unit_kerja_user->toArray())->groupBy(["dop", "unit_kerja", "periode_prognosa"]);
            } else {
                $historyForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->select(["proyeks.nama_proyek", "unit_kerjas.divcode", "proyeks.dop", "unit_kerjas.unit_kerja", "history_forecast.*", "history_forecast.created_at", "proyeks.stage", "proyeks.is_cancel"])->whereYear("history_forecast.created_at", "=", (int) date("Y"))->get()->where("divcode", "=", $unit_kerja_user)->groupBy(["dop", "unit_kerja", "periode_prognosa"]);
            }
        } else {
            $historyForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->select(["proyeks.nama_proyek", "unit_kerjas.divcode", "proyeks.dop", "unit_kerjas.unit_kerja", "history_forecast.*", "history_forecast.created_at", "proyeks.stage", "proyeks.is_cancel"])->whereYear("history_forecast.created_at", "=", (int) date("Y"))->get()->groupBy(["dop", "unit_kerja", "periode_prognosa"]);
        }
        // dd($historyForecast);
        $is_user_unit_kerja = $historyForecast->contains(function ($h) use ($unit_kerja_user) {
            return $h->contains(function ($p) use ($unit_kerja_user) {
                if(!empty($unit_kerja_user)) {
                    if ($unit_kerja_user instanceof Collection) {
                        return $p->whereIn("divcode", $unit_kerja_user->toArray())->count() > 0;
                    } else {
                        return $p->where("divcode", "=", $unit_kerja_user)->count() > 0;
                    }
                }
                // return $p->contains(function ($hp) use ($unit_kerja_user) {
                //     dd($hp);
                // });
            });
        });
        $historyForecast = $historyForecast->map(function ($h) {
            return $h->map(function ($histories) {
                return $histories->map(function($ph) {
                    $newClass = new stdClass();
                    $newClass->rkap_forecast = $ph->sum(function($f) {
                        return (int) $f->rkap_forecast;
                    });
                    $newClass->nilai_forecast = $ph->sum(function($f) {
                        if($f->stage != 7 || !$f->is_cancel || !empty($f->is_cancel)) {
                            return (int) $f->nilai_forecast;
                        }
                    });
                    $newClass->realisasi_forecast = $ph->sum(function($f) {
                        return (int) $f->realisasi_forecast;
                    });
                    $newClass->periode_prognosa = (int) $ph->avg(function($f) {
                        return (int) $f->periode_prognosa;
                    });
                    $newClass->created_at = $ph->first()->created_at;
                    if($ph->contains(function($history) { return $history->is_approved_1 == null;})) {
                        $newClass->is_approved_1 = null;
                    }else if($ph->contains(function($history) { return  $history->is_approved_1 == "f";})) {
                        $newClass->is_approved_1 = "f";
                    } else {
                        $newClass->is_approved_1 = "t";
                    }
                    if($ph->contains(function($history) { return $history->is_request_unlock == null;})) {
                        $newClass->is_request_unlock = null;
                    }else if($ph->contains(function($history) { return  $history->is_request_unlock == "f";})) {
                        $newClass->is_request_unlock = "f";
                    } else {
                        $newClass->is_request_unlock = "t";
                    }
                    return $newClass;
                });
            });
        });
        // dd($historyForecast);
        return view("Forecast/viewRequestApproval", compact(["historyForecast", "is_user_unit_kerja"]));
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
}
