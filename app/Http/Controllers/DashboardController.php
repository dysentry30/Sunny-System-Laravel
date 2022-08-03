<?php

namespace App\Http\Controllers;

use App\Models\ClaimManagements;
use App\Models\ContractManagements;
use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\Proyek;
use App\Models\UnitKerja;
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
        if ($request->get("periode-prognosa") || $request->get("tahun-history")) {
            $year = (int) $request->get("tahun-history") ?? "";
            $month = $request->get("periode-prognosa") ?? "";
        } else {
            $year = "";
            $month = "";
            // $nilaiHistoryForecast = HistoryForecast::all();
        }

        $nilaiHistoryForecast = HistoryForecast::where("periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))
        ->whereYear("created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
        
        // dd($nilaiHistoryForecast);
        $nilaiForecast = 0;
        $nilaiForecastArray = [];
        $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");

        $nilaiRkap = 0;
        $nilaiRkapArray = [];
        $historyRkap = $nilaiHistoryForecast->sortBy("month_rkap");

        $nilaiRealisasi = 0;
        $nilaiRealisasiArray = [];
        $historyRealisasi = $nilaiHistoryForecast->sortBy("month_realisasi");
        // dd($historyRealisasi);
        
        $per = 1000000; //Dibagi Dalam Jutaan
        
        
        for ($i=1; $i <= 12; $i++) { 
            foreach ($historyForecast as $forecast){
                if ($forecast->month_forecast == $i) {
                    $nilaiForecast += ceil($forecast->nilai_forecast/$per);
                }else{
                    $nilaiForecast == 0;
                }
            }
            array_push($nilaiForecastArray, $nilaiForecast);

            foreach ($historyForecast as $rkap){
                if ($rkap->month_rkap == $i) {
                    $nilaiRkap += ceil($rkap->rkap_forecast/$per);
                }else{
                    $nilaiRkap == 0;
                }
            }
            array_push($nilaiRkapArray, $nilaiRkap);
            
            foreach ($historyForecast as $realisasi){
                if ($realisasi->month_realisasi == $i) {
                    $nilaiRealisasi += ceil($realisasi->realisasi_forecast/$per);
                }else{
                    $nilaiRealisasi == 0;
                }
            }
            array_push($nilaiRealisasiArray, $nilaiRealisasi);
        }
        // dump($nilaiRealisasiArray);
        // dd();


        
        // begin :: Tri Wulan
        $nilaiForecastTriwulan = 0;
        $nilaiForecastTriwunalArray = [];
        
        $offset_history = 0;
        for ($i = 3; $i <= 12; $i+=3) {
            $filtered_history_forecast = $historyForecast->filter(function($data) use ($i, $offset_history){
                return  $data->month_forecast > $offset_history && $data->month_forecast <= $i;
            });
            $nilaiForecastTriwulan += $filtered_history_forecast->sum("nilai_forecast");
            // dump($filtered_history_forecast->all());
            array_push($nilaiForecastTriwunalArray, $nilaiForecastTriwulan);
            $offset_history = $i;
        }
        // end :: Tri Wulan
        
        // Begin :: Nilai Realisasi Unit Kerja
        $unitKerja = UnitKerja::all();
        $kategoriunitKerja = [];
        $nilaiOkKumulatif = [];
        $nilaiRealisasiKumulatif = [];
        foreach ($unitKerja as $unit) {
            // dump($unit->proyeks);
            array_push($kategoriunitKerja, $unit->unit_kerja);
            $nilaiOk = 0;
            $nilaiRealisasi = 0;
            foreach($unit->proyeks as $proyekUnit){
                $nilaiOk += (int) str_replace(",", "", $proyekUnit->nilai_rkap); 
                $nilaiRealisasi += (int) str_replace(",", "", $proyekUnit->nilai_kontrak_keseluruhan); 
                // dump((int) str_replace(",", "", $proyekUnit->nilai_rkap));
            }
            array_push($nilaiOkKumulatif, $nilaiOk);
            array_push($nilaiRealisasiKumulatif, $nilaiRealisasi);
        }
        // dd($nilaiOkKumulatif);
        
        // End :: Nilai Realisasi Unit Kerja

        
        // Begin :: menghitung total dari status dan jenis claim
        $claims = ClaimManagements::all();
        // dd($claims);
        $claim_status_array = [];
        $claim_cancel = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Claim")->count();
        $claim_disetujui = $claims->where("stages", "=", "2")->where("jenis_claim", "=", "Claim")->count();
        $claim_ditolak = $claims->where("stages", "=", "3")->where("jenis_claim", "=", "Claim")->count();
        $claim_on_progress = $claims->where("stages", "=", "1")->where("jenis_claim", "=", "Claim")->count();
        array_push($claim_status_array, $claim_cancel, $claim_disetujui, $claim_ditolak, $claim_on_progress);
        // End :: menghitung total dari status dan jenis claim

        // Begin :: menghitung total dari status dan jenis anti claim
        $anti_claim_status_array = [];
        $anti_claim_cancel = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_disetujui = $claims->where("stages", "=", "2")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_ditolak = $claims->where("stages", "=", "3")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_on_progress = $claims->where("stages", "=", "1")->where("jenis_claim", "=", "Anti Claim")->count();
        array_push($anti_claim_status_array, $anti_claim_cancel, $anti_claim_disetujui, $anti_claim_ditolak, $anti_claim_on_progress);
        // End :: menghitung total dari status dan jenis anti claim
        
        // Begin :: menghitung total dari status dan jenis claim asuransi
        $claim_asuransi_status_array = [];
        $claim_asuransi_cancel = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_disetujui = $claims->where("stages", "=", "2")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_ditolak = $claims->where("stages", "=", "3")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_on_progress = $claims->where("stages", "=", "1")->where("jenis_claim", "=", "Claim Asuransi")->count();
        array_push($claim_asuransi_status_array, $claim_asuransi_cancel, $claim_asuransi_disetujui, $claim_asuransi_ditolak, $claim_asuransi_on_progress);
        // End :: menghitung total dari status dan jenis claim asuransi

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

        //Begin::Terendah Terkontrak
        $nilaiTerkontrak = 0;
        $nilaiTerendah = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 8) {
                $nilaiTerkontrak += (int) str_replace(",", "", $proyek->nilai_kontrak_keseluruhan);
            } else if ($stg == 9) {
                $nilaiTerendah += (int) str_replace(",", "", $proyek->nilai_kontrak_keseluruhan);
            };
            // dump($nilaiTerendah, $nilaiTerkontrak);
        };
        //End::Terendah Terkontrak
        
        //Begin::Competitive Index
        $jumlahMenang = 0;
        $jumlahKalah = 0;
        $nilaiMenang = 0;
        $nilaiKalah = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 6) {
                $jumlahMenang++;
                $nilaiMenang += (int) str_replace(",", "", $proyek->nilai_rkap);
            } else if ($stg == 9) {
                $jumlahKalah++;
                $nilaiKalah += (int) str_replace(",", "", $proyek->nilai_rkap);
            };
            // dump($nilaiTerendah, $nilaiTerkontrak);
        };
        //End::Competitive Index

        //begin::Marketing PipeLine
        $prosesTender = 0;
        $terkontrak = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg <= 7) {
                $prosesTender++;
            } else {
                if(empty($proyek->ContractManagements)){
                    $terkontrak++;
                }
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
            } else if ($stg < 5) {
                $serahTerima++;
            } else {
                $closing++;
            };
        };
        //end::Marketing PipeLine
        
        //begin::Pareto
        $paretoProyek = Proyek::sortable()->orderByDesc('forecast')->get();
        
        $paretoClaim = ClaimManagements::sortable()->where("jenis_claim", "=", "Claim")->get()->groupBy("kode_proyek");
        // $paretoClaim = ClaimManagements::sortable()->get();
        // dd($paretoClaim);
        $paretoAntiClaim = ClaimManagements::sortable()->where("jenis_claim", "=", "Anti Claim")->get()->groupBy("kode_proyek");
        $paretoAsuransi = ClaimManagements::sortable()->where("jenis_claim", "=", "Claim Asuransi")->get()->groupBy("kode_proyek");
        //end::Pareto


        return view('1_Dashboard', compact(["claim_status_array","anti_claim_status_array","claim_asuransi_status_array","nilaiForecastArray", "nilaiRkapArray", "nilaiRealisasiArray", "nilaiForecastTriwunalArray", "year", "month", "proses", "menang", "kalah", "prakualifikasi", "prosesTender", "terkontrak", "pelaksanaan", "serahTerima", "closing", "proyeks", "paretoProyek", "paretoClaim", "paretoAntiClaim", "paretoAsuransi", "kategoriunitKerja", "nilaiOkKumulatif", "nilaiRealisasiKumulatif", "nilaiTerkontrak", "nilaiTerendah", "jumlahMenang", "jumlahKalah", "nilaiMenang", "nilaiKalah"]));
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
        } elseif ($type == "NilaiOK") {
            $month = array_search($month, $arrNamaBulan);
            $history_rkap = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=" , $prognosa)->get()->sortBy("month_rkap")->all();
            // dd($history_rkap);
            foreach ($history_rkap as $history) {
                if ($history->month_rkap <= $month) {
                    array_push($data, $history);
                }
            }
        } else {
            $month = array_search($month, $arrNamaBulan);
            $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=" , $prognosa)->get()->sortBy("month_realisasi")->all();
            // dd($history_realisasi);
            foreach ($history_realisasi as $history) {
                if ($history->month_realisasi <= $month) {
                    array_push($data, $history);
                }
            }
        }
        return response()->json($data);
    }
    public function getDataFilterPointTriwulan($prognosa, $type, $month)
    {
        $arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $range_month = explode("-", $month);
        $max_month = array_search($range_month[1], $arrNamaBulan);
        $history_forecasts = Proyek::select("*")->where("month_forecast", "<=", $max_month)->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=", $prognosa)->get();
        return response()->json($history_forecasts);
    }

    public function getDataFilterPointRealisasi($prognosa, $type, $unitKerja)
    {
        if ($type == "Nilai-OK-Kumulatif") {
            $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("unit_kerjas.unit_kerja", "=", str_replace("-", " ", $unitKerja))->get();
        } else if ($type == "Nilai-Realisasi-Kumulatif") {
            $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("unit_kerjas.unit_kerja", "=", str_replace("-", " ", $unitKerja))->get();
        }
        return response()->json($proyeks);
    }
}
