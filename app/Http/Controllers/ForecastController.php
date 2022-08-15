<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\HistoryForecast;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($periode = "", $year = "")
    {
        // $id = Dop::find('id');
        // $dopProyek = Proyek::find($id);
        $periode = $periode != "" ? (int) $periode : (int) date("m");
        $year = $year != "" ? (int) $year : (int) date("Y");
        $previous_periode_prognosa = $periode != "" ? (int) $periode - 1 : (int) date("m") - 1;
        $year_previous_forecast = $year != "" ? (int) $year : (int) date("Y");
        if($previous_periode_prognosa < 1) {
            $year_previous_forecast--;
            $previous_periode_prognosa = 12;
        }
        
        if ($periode != "" && $year != "" && Auth::user()->check_administrator) {
            $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $historyForecast = HistoryForecast::select("history_forecast.*")->join("proyeks", "proyeks.kode_proyek", "=", "history_forecasts.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $periode)->whereYear("created_at", "=", $year)->get();
            $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->whereYear("f.created_at", "=", $year_previous_forecast)->where("f.periode_prognosa", '=', $periode)->get();
        } else {
            $historyForecast_all = DB::table("history_forecast as history")->select("history.*")->join("proyeks", "proyeks.kode_proyek", "=", "history.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("history.created_at", "=", $year_previous_forecast)->where("history.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $previous_forecast = DB::table("forecasts as f")->select("f.*")->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", "=", $year_previous_forecast)->where("f.periode_prognosa", '=', $previous_periode_prognosa)->get();
            $historyForecast = DB::table("history_forecast as f")->select("f.*")->where("periode_prognosa", "=", (int) $periode)->join("proyeks", "proyeks.kode_proyek", "=", "f.kode_proyek")->where("unit_kerja", "=", Auth::user()->unit_kerja)->whereYear("f.created_at", "=", (int) $year)->get();
        }

        $month_title = \Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F");
        if($periode != "") {
            $month_title = \Carbon\Carbon::createFromDate(2022, $periode, 1)->translatedFormat("F");
        }
        if(Auth::user()->check_administrator) {
            // $proyeks = collect();
            $proyeks = Proyek::all();
            $dops = Dop::all();
        } else {
            // $proyeks = collect();
            $proyeks = Proyek::where("unit_kerja", "=", Auth::user()->unit_kerja)->get();
            $dops = Dop::join("unit_kerjas", "unit_kerjas.dop", "=", "dops.dop")->where("unit_kerjas.divcode", "=", Auth::user()->unit_kerja)->get();
        }
        return view(
            'Forecast/viewForecast',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast, 
                // 'dops' => Dop::all(),
                "historyForecast_all" => $historyForecast_all,
                'dops' => $dops,
                'proyeks' => $proyeks,
                "previous_periode_prognosa" => $previous_periode_prognosa,
                "year_previous_forecast" => $year_previous_forecast,   
                "month_title" => $month_title,
                "periode" => $periode,
                "year" => $year,
                "previous_forecast" => $previous_forecast,
            ]
        );
        // 'unitkerjas' => UnitKerja::all()]);
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
        if(Auth::user()->check_administrator) {
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
    public function getAllDataUnitKerjas(Request $request) {
        $dop_name = $request->dop_name;
        $unit_kerjas = DB::table('unit_kerjas')->where("dop", "=", $dop_name)->get();
        return response()->json([
            "unit_kerjas" => $unit_kerjas,
        ]);
    }
}
