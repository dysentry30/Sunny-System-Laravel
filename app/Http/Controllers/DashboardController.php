<?php

namespace App\Http\Controllers;

use App\Models\HistoryForecast;
use App\Models\Proyek;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index () 
    {
        function flatten(array $array) {
            $return = array();
            array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
            return $return;
        }

        //begin::History Forecast
        $nilaiHistoryForecast = HistoryForecast::select('nilai_forecast')->get()->toArray();
        
        $arrayHistoryForecast = flatten($nilaiHistoryForecast);
        //end::History Forecast
        
        //begin::Proyek Stage
        $proyeks = Proyek::all();
        $proses = 0;
        $menang = 0;
        $kalah = 0;
        $prakualifikasi = 0;
        foreach($proyeks as $proyek){
            $stg = $proyek->stage; 
            if($stg <3 ){
                $proses++;
            }else if($stg ==3){
                $prakualifikasi++;
            }else if($stg<4 && $stg>5 ){
                $proses++;
            }else if($stg ==6){
                $menang++;
            }
            else if($stg ==7){
                $kalah++;
            }else{
                $menang++;
            };
        };
        // dd($menang);
        
        //end::Proyek Stage

        return view('1_Dashboard', compact(["arrayHistoryForecast","proses","menang","kalah","prakualifikasi"]));
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
}
