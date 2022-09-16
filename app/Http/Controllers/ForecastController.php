<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\UnitKerja;
use DateTime;
use Illuminate\Http\Request;
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
            // $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja->toArray())->groupBy(["periode_prognosa"]);
        } else {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }
        if (Auth::user()->check_administrator) {
            // $proyeks = collect();
            $proyeks = Proyek::with(["Forecasts", "HistoryForecasts"])->get();
            $dops = Dop::all()->sortBy("dop");
            // dd($proyeks);
        } else {
            // $proyeks = collect();
            // $dops = Dop::all()->sortBy("dop");

            // dd($unit_kerja);
            $dops = Dop::all();
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
                "forecast" => true,
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
            // $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja->toArray())->groupBy(["periode_prognosa"]);
        } else {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
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
            // $dops = Dop::all()->sortBy("dop");

            // dd($unit_kerja);
            $dops = Dop::all();
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
            'Forecast/viewForecastInternal',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast,
                // 'dops' => Dop::all(),
                // "historyForecast_all" => $historyForecast_all,
                'dops' => $dops,
                // 'proyeks' => $proyeks,
                "forecast" => true,
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
    //     //     $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
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

    public function viewForecastKumulatifEksternal(Request $request, $periode = "", $year = "")
    {

        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        $periode = $periode != "" ? (int) $periode : (int) date("m");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }

        $periode = $periode != "" ? (int) $periode : (int) date("m");
        $year = $year != "" ? (int) $year : (int) date("Y");


        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;

        $selectForecast = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->select(["proyeks.nama_proyek", "proyeks.kode_proyek", "proyeks.unit_kerja", "proyeks.dop", "forecasts.month_forecast", "forecasts.nilai_forecast", "forecasts.month_rkap", "forecasts.rkap_forecast", "forecasts.month_realisasi", "forecasts.realisasi_forecast", "forecasts.periode_prognosa", "forecasts.created_at"])->where("forecasts.periode_prognosa", "=", $periode, "or")->whereYear("forecasts.created_at", $year);
        if (Auth::user()->check_administrator) {
            $dops = Dop::with(["Proyek"])->get()->sortBy("dop");
            
            $forecastByUnitKerja = $selectForecast->where("proyeks.jenis_proyek", "!=", "I")->get()->groupBy(["dop", "unit_kerja"]);
            // dd($dops);
            
        } elseif ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $dop = Dop::with(["Proyek"])->get()->sortBy("dop");
            $dops =  $dop->filter(function ($dataDop) use($unit_kerja_user) {
                return $dataDop->UnitKerjas->whereIn("divcode", $unit_kerja_user->toArray())->count() > 0 ? true : false;
            });
            // dd($dops);
            $forecastByUnitKerja = $selectForecast->where("proyeks.jenis_proyek", "!=", "I")->get()->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy(["dop", "unit_kerja"]);
        } else {
            $dop = Dop::with(["Proyek"])->get()->sortBy("dop");
            $dops =  $dop->filter(function ($dataDop) {
                return $dataDop->UnitKerjas->where("divcode", "=", Auth::user()->unit_kerja)->first();
            });
            
            $forecastByUnitKerja = $selectForecast->where("proyeks.jenis_proyek", "!=", "I")->get()->where("unit_kerja", "=", Auth::user()->unit_kerja);
        }
        
        // begin::get unit kerja
        // $unit_kerja = array_keys($forecastByUnitKerja->toArray());
        // dd($forecastByUnitKerja);

        $arrayOK1 = [];
        // $ok1 = $forecastByUnitKerja["DOP 1"]->sum(function($unitKerja){
        //     return $unitKerja->sum(function($forecast){
        //         if ($forecast->month_rkap <= 1) {
        //             return $forecast->rkap_forecast;
        //         }
        //     });
        // });
        // $ok2 = $forecastByUnitKerja["DOP 1"]->sum(function($unitKerja){
        //     return $unitKerja->sum(function($forecast){
        //         if ($forecast->month_rkap <= 2) {
        //             return $forecast->rkap_forecast;
        //         }
        //     });
        // });
        // $ok3 = $forecastByUnitKerja["DOP 1"]->sum(function($unitKerja){
        //     return $unitKerja->sum(function($forecast){
        //         if ($forecast->month_rkap <= 3) {
        //             return $forecast->rkap_forecast;
        //         }
        //     });
        // });

        // $array = array_push($arrayOK1, $okDOP1);
        // dd($array);

        
        // dd($ok1);

        foreach ($forecastByUnitKerja as $unitKey => $proyekGroupByDOP) {
            // dump($unitKey, $proyekGroupByDOP);
            foreach ($proyekGroupByDOP as $key => $unit) {
                $ok1 = $unit->sum(function($forecast){
                    if ($forecast->month_rkap <= 1) {
                        return $forecast->rkap_forecast;
                    }
                });
                // dump($key, $unit, $ok1);
                
                // $ok1 = 0;
                // $ok2 = 0;
                // $ok3 = 0;
                // $ok4 = 0;
                // $ok5 = 0;
                // $ok6 = 0;
                // $ok7 = 0;
                // $ok8 = 0;
                // $ok9 = 0;
                // $ok10 = 0;
                // $ok11 = 0;
                // $ok12 = 0;
                //     if ($value->month_rkap == 1) {
                //         $ok1 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 2) {
                //         $ok2 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 3) {
                //         $ok3 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 4) {
                //         $ok4 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 5) {
                //         $ok5 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 6) {
                //         $ok6 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 7) {
                //         $ok7 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 8) {
                //         $ok8 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 10) {
                //         $ok10 += $value->rkap_forecast;
                //     }elseif ($value->month_rkap == 11) {
                //         $ok11 += $value->rkap_forecast;
                //     }else {
                //         $ok12 += $value->rkap_forecast;
                //     }
                // $ok2 += $ok1; 
                // $ok3 += $ok2; 
                // $ok4 += $ok3; 
                // $ok5 += $ok4; 
                // $ok6 += $ok5; 
                // $ok7 += $ok6; 
                // $ok8 += $ok7; 
                // $ok9 += $ok8; 
                // $ok10 += $ok9; 
                // $ok11 += $ok10; 
                // $ok12 += $ok11; 
                
            }

            // foreach ($dops as $dop) {
            //     // dump($unit_kerja, $dop);
            //     $ok1 = 0;
            //     $ok2 = 0;
            //     $ok3 = 0;
            //     $ok4 = 0;
            //     $ok5 = 0;
            //     $ok6 = 0;
            //     $ok7 = 0;
            //     $ok8 = 0;
            //     $ok9 = 0;
            //     $ok10 = 0;
            //     $ok11 = 0;
            //     $ok12 = 0;
            //     // for ($i=1; $i < 12; $i++) { 
            //         if ($dop->month_rkap == 1) {
            //             $ok1 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 2) {
            //             $ok2 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 3) {
            //             $ok3 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 4) {
            //             $ok4 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 5) {
            //             $ok5 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 6) {
            //             $ok6 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 7) {
            //             $ok7 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 8) {
            //             $ok8 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 10) {
            //             $ok10 += $dop->rkap_forecast;
            //         }elseif ($dop->month_rkap == 11) {
            //             $ok11 += $dop->rkap_forecast;
            //         }else {
            //             $ok12 += $dop->rkap_forecast;
            //         }
            //     $ok2 += $ok1; 
            //     $ok3 += $ok2; 
            //     $ok4 += $ok3; 
            //     $ok5 += $ok4; 
            //     $ok6 += $ok5; 
            //     $ok7 += $ok6; 
            //     $ok8 += $ok7; 
            //     $ok9 += $ok8; 
            //     $ok10 += $ok9; 
            //     $ok11 += $ok10; 
            //     $ok12 += $ok11; 
            // }
            // dump($ok1, $ok2, $ok3, $ok4, $ok5, $ok6, $ok7, $ok8, $ok9, $ok10, $ok11, $ok12);
        }


        // dd();


        //     $forecastByDop = Forecast::with(['Proyek'])->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", $periode, "or")->whereYear("forecasts.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja_user->toArray())->groupBy("dop");
        //     // dd($forecastByDop);

        //     foreach ($forecastByDop as $nilaiDop) {
        //         dump($nilaiDop);
        //     //     foreach ($nilaiDop as $nilaiPerbulan) {
        //     //         // dd($nilaiPerbulan);
        //     //     $nilaiOK = 0;   
        //     //     for ($i=1; $i = 12; $i++) {
        //     //         if ($nilaiPerbulan->month_forecast == $i) {
        //     //             $nilaiOK += $nilaiPerbulan->rkap_forecast;
        //     //         }
        //     //         // $nilaiDop1 += $nilaiPerbulan;
        //     //     }
        //     //     }
        //     }
        //     // dd($nilaiOK);
        //     // dd(array_keys($forecastByUnitKerja->toArray()));

        // }

        
        // dd($dops);

        return view( 'Forecast/viewForecastKumulatifEksternal', compact(['dops', 'month_title', 'periode', 'forecastByUnitKerja']) );
        // return view( 'Forecast/viewForecastKumulatifEksternal', compact(['dops', 'month_title', 'periode', 'forecastByUnitKerja', 'ok1', 'ok2', 'ok3', 'ok4', 'ok5', 'ok6', 'ok7', 'ok8', 'ok9', 'ok10', 'ok11', 'ok12']) );
        // 'unitkerjas' => UnitKerja::all()]);
    }

    public function viewForecastKumulatifIncludeInternal(Request $request, $periode = "", $year = "")
    {
        // $id = Dop::find('id');
        // $dopProyek = Proyek::find($id);
        $column = $request->get("column");
        $filter = $request->get("filter");

        $periode = $periode != "" ? (int) $periode : (int) date("m");
        $year = $year != "" ? (int) $year : (int) date("Y");
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
        }
        $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if ($unit_kerja instanceof \Illuminate\Support\Collection) {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", $year)->get()->whereIn("unit_kerja", $unit_kerja->toArray())->groupBy(["periode_prognosa"]);
        } else {
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
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
            // $dops = Dop::all()->sortBy("dop");

            // dd($unit_kerja);
            $dops = Dop::all();
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
            'Forecast/viewForecastKumulatifIncludeInternal',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast,
                // 'dops' => Dop::all(),
                // "historyForecast_all" => $historyForecast_all,
                'dops' => $dops,
                // 'proyeks' => $proyeks,
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

    // public function index(Request $request, $periode = "", $year = "")
    // {
    //     $dops = Dop::all();
    //     $unit_kerjas = UnitKerja::with(["Dop", "proyeks"])->get();
    //     // $unit_kerjas->each(function($unit_kerja) {
    //     //     dump($unit_kerja->proyeks);
    //     // });
    //     // dd();
    //     $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
    //     return view(
    //         'Forecast/viewForecast',
    //         [
    //             "dops" => $dops,
    //             "unit_kerjas" => $unit_kerjas,
    //             "month_title" => $month_title,
    //             "periode" => (int) date("m"),
    //             "historyForecast" => HistoryForecast::all(),
    //             "column" => "",
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
