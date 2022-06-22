<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Proyek;
use App\Models\Forecast;
use App\Models\HistoryForecast;
use Illuminate\Http\Request;
use App\Models\UnitKerja;
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
        $historyForecast = HistoryForecast::where("periode_prognosa", "=", date("m"))->get();
        return view(
            'Forecast/viewForecast',
            [
                // 'forecast' => Forecast::all(),
                "historyForecast" => $historyForecast, 
                'dops' => Dop::all(),
                'proyeks' => Proyek::all()
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
        return response()->json([
            'dops' => Dop::all(),
            'proyeks' => Proyek::all()
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
