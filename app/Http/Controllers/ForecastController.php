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
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja, "or")->whereYear("f.created_at", $year)->get()->groupBy(["periode_prognosa"]);
        }
        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        if ($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }
        if (Auth::user()->check_administrator) {
            // $proyeks = collect();
            $proyeks = Proyek::with(["Forecasts", "HistoryForecasts"])->get();
            $dops = Dop::all();
            // dd($proyeks);
        } else {
            // $proyeks = collect();
            $proyeks = Proyek::with("Forecasts")->where("unit_kerja", "=", Auth::user()->unit_kerja)->get();
            $dops = Dop::join("unit_kerjas", "unit_kerjas.dop", "=", "dops.dop")->where("unit_kerjas.divcode", "=", Auth::user()->unit_kerja)->get();
        }

        if (!empty($column) && !empty($filter)) {
            // $dops = $dops->where("dop", "=", $filter);
            $dops = $dops->filter(function ($data) use ($filter, $column, $proyeks) {
                switch ($column) {
                    case "dop":
                        return str_contains(strtolower($data->dop), strtolower($filter));
                    case "unit_kerja":
                        $unit_kerjas = UnitKerja::all()->filter(function($unit_kerja) use($filter) {
                            return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
                        });
                        foreach($unit_kerjas as $unit_kerja) {
                            if($unit_kerja->dop == $data->dop) {
                                return $data;
                            }
                        }
                    case "nama_proyek":
                        $proyeks_arr = $proyeks->filter(function($data) use($filter) {
                            return str_contains(strtolower($data->nama_proyek), strtolower($filter));
                        });
                        // $unit_kerjas = UnitKerja::all()->filter(function($unit_kerja) use($filter) {
                        //     return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
                        // });

                        foreach($proyeks_arr as $proyek) {
                            if($proyek->dop == $data->dop) {
                                return $data;
                            }
                        }
                        // return str_contains(strtolower($data->nama_proyek), strtolower($filter));
                }
            });
            
            $proyeks = $proyeks->filter(function ($data) use ($filter, $column) {
                switch ($column) {
                    case "dop":
                        return str_contains(strtolower($data->dop), strtolower($filter));
                    case "unit_kerja":
                        $unit_kerjas = UnitKerja::all()->filter(function($unit_kerja) use($data, $filter) {
                            return str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter));
                        });
                        foreach ($unit_kerjas as $unit_kerja) {
                            if ($unit_kerja->divcode == $data->unit_kerja) {
                                return $data;
                            }
                        }
                    case "nama_proyek":
                        return str_contains(strtolower($data->nama_proyek), strtolower($filter));
                }
            });
            // $proyeks_eksternal = $proyeks->filter()
        }

        // dd($proyeks->groupBy(["dop", "unit_kerja"]));

        return view(
            'Forecast/viewForecast',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast,
                // 'dops' => Dop::all(),
                // "historyForecast_all" => $historyForecast_all,
                'dops' => $dops,
                'proyeks' => $proyeks,
                "previous_periode_prognosa" => $previous_periode_prognosa,
                "year_previous_forecast" => $year_previous_forecast,
                "month_title" => $month_title,
                "periode" => $periode,
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
