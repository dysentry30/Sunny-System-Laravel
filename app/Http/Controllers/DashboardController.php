<?php

namespace App\Http\Controllers;

use App\Models\ContractManagements;
use App\Models\Forecast;
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
    function index(Request $request)
    {
        // function flatten(array $array)
        // {
        //     $return = array();
        //     array_walk_recursive($array, function ($a) use (&$return) {
        //         $return[] = $a;
        //     });
        //     return $return;
        // }

        //begin::History Forecast
        // $nilaiHistoryForecast = HistoryForecast::select('nilai_forecast')->get()->toArray();
        // $nilaiHistoryForecast = HistoryForecast::select(['nilai_forecast','month_forecast','periode_prognosa'])->get();
        // $nilaiHistoryForecast[1];   
        // dd(HistoryForecast::select(['nilai_forecast','month_forecast','periode_prognosa'])->get());
        // $arrayHistoryForecast = flatten($nilaiHistoryForecast);
        
        if ($request->get("periode-prognosa") || $request->get("tahun-history")) {
            $nilaiHistoryForecast = HistoryForecast::where("periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))
            ->whereYear("created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
            $year = $request->get("tahun-history") ?? "";
            $month = $request->get("periode-prognosa") ?? "";
            // dd($nilaiHistoryForecast);
        } else {
            $year = "";
            $month = "";
            $nilaiHistoryForecast = HistoryForecast::all();
            // dd($nilaiHistoryForecast);
        }
        
        // dd($nilaiHistoryForecast);
        $fc2 = 0;
        $fc3 = 0;
        $fc4 = 0;
        $fc5 = 0;
        $fc6 = 0;
        $fc7 = 0;
        $fc8 = 0;
        $fc9 = 0;
        $fc10 = 0;
        $fc11 = 0;
        $fc12 = 0;
        $nilaiForecast = 0;
        $nilaiForecastArray = [];
        $fc1 = 0;
        $per = 1000000; //Dibagi Dalam Jutaan
        $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");

        
        foreach ($historyForecast as $forecast){
            for ($i=1; $i <= 12; $i++) { 
                if ($forecast->month_forecast == $i) {
                    $nilaiForecast += ceil($forecast->nilai_forecast/$per);
                }else{
                    $nilaiForecast == 0;
                }
            }
            array_push($nilaiForecastArray, $nilaiForecast);
            dump($forecast->month_forecast);
        }
        dd();
        dd($nilaiForecastArray);

        // foreach ($nilaiHistoryForecast as $History) {
        //     if ($History->month_forecast == 1)
        //         $fc1 += $History->nilai_forecast;
        //     if ($History->month_forecast == 2)
        //         $fc2 += $History->nilai_forecast;
        //     if ($History->month_forecast == 3)
        //         $fc3 += $History->nilai_forecast;
        //     if ($History->month_forecast == 4)
        //         $fc4 += $History->nilai_forecast;
        //     if ($History->month_forecast == 5)
        //         $fc5 += $History->nilai_forecast;
        //     if ($History->month_forecast == 6)
        //         $fc6 += $History->nilai_forecast;
        //     if ($History->month_forecast == 7)
        //         $fc7 += $History->nilai_forecast;
        //     if ($History->month_forecast == 8)
        //         $fc8 += $History->nilai_forecast;
        //     if ($History->month_forecast == 9)
        //         $fc9 += $History->nilai_forecast;
        //     if ($History->month_forecast == 10)
        //         $fc10 += $History->nilai_forecast;
        //     if ($History->month_forecast == 11)
        //         $fc11 += $History->nilai_forecast;
        //     if ($History->month_forecast == 12)
        //         $fc12 += $History->nilai_forecast;
        // }
        //end::History Forecast

        //begin::Proyek Stage
        $proyeks = Proyek::all();
        $proses = 0;
        $menang = 0;
        $kalah = 0;
        $prakualifikasi = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg < 3) {
                $proses++;
            } else if ($stg == 3) {
                $prakualifikasi++;
            } else if ($stg == 4 || $stg == 5) {
                $proses++;
            } else if ($stg == 6) {
                $menang++;
            } else if ($stg == 7) {
                $kalah++;
            } else {
                $menang++;
            };
        };
        //end::Proyek Stage

        //begin::Marketing PipeLine
        $prosesTender = 0;
        $terkontrak = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg <= 7) {
                $prosesTender++;
            } else {
                $terkontrak++;
            };
        };
        $contracts = ContractManagements::all();
        $pelaksanaan = 0;
        $serahTerima = 0;
        $closing = 0;
        foreach ($contracts as $contract) {
            $stg = $contract->stages;
            if ($stg <= 3) {
                $pelaksanaan++;
            } else if ($stg <= 5) {
                $serahTerima++;
            } else {
                $closing++;
            };
        };
        //end::Marketing PipeLine

        return view('1_Dashboard', compact(["nilaiForecastArray", "fc1", "fc2", "fc3", "fc4", "fc5", "fc6", "fc7", "fc8", "fc9", "fc10", "fc11", "fc12", "year", "month", "proses", "menang", "kalah", "prakualifikasi", "prosesTender", "terkontrak", "pelaksanaan", "serahTerima", "closing", "proyeks"]));
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
    public function getDataFilterPoint($prognosa, $type, $month)
    {
        $arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $data = [];
        if ($type == "Forecast") {
            $month = array_search($month, $arrNamaBulan);
            $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=" , $prognosa)->get()->sortBy("month_forecast")->all();
            // dd($history_forecasts);
            // $history_forecasts = HistoryForecast::select("*")->join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.unit_kerja")->where("month_forecast", "<=" , $month)->get()->all();
            foreach ($history_forecasts as $history) {
                if ($history->month_forecast <= $month) {
                    array_push($data, $history);
                }
            }
            // dd($data);
            // dump($proyek->HistoryForecasts);
            // $data = array_push($proyek->HistoryForecasts);
            // $history_forecast = HistoryForecast::where("month_forecast", "=", $month)->get()->all();
        }
        return response()->json($data);
    }
}
