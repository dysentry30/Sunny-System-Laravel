<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Proyek;
use App\Models\Forecast;
use Illuminate\Http\Request;
use App\Models\UnitKerja;

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
        return view('Forecast/viewForecast', 
        [
            // 'forecast' => Forecast::all(), 
            'dops' => Dop::all(), 
            'proyeks' => Proyek::all()]); 
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
}
