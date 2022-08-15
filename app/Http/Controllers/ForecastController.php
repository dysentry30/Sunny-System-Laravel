<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\HistoryForecast;
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
    public function index()
    {
        // $id = Dop::find('id');
        // $dopProyek = Proyek::find($id);
        $historyForecast_all = HistoryForecast::all()->groupBy("periode_prognosa");
        $historyForecast = HistoryForecast::where("periode_prognosa", "=", date("m"))->get();
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
                'proyeks' => $proyeks
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
