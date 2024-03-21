<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class DashboardTVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Get Data Forecast Bulanan
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getForecast()
    {
        $per = 1000000; //Dibagi Dalam Jutaan

        $year = (int) date("Y");

        if ((int)date('d') < 5) {
            $month = (int) date("m") - 1;
        } else {
            $month = (int) date("m");
        }

        try {
            $nilaiHistoryForecast = HistoryForecast::select('proyeks.kode_proyek', 'proyeks.is_rkap', 'proyeks.is_cancel', 'proyeks.unit_kerja', 'proyeks.stage', 'rkap_forecast', 'nilai_forecast', 'realisasi_forecast', 'month_rkap', 'month_forecast', 'month_realisasi')->join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("history_forecast.tahun", "=", $year)->get();
            $countUnitKerjaFromHistory = $nilaiHistoryForecast->groupBy('unit_kerja')->count();

            if ($nilaiHistoryForecast->count() < 1 || $countUnitKerjaFromHistory < 11) {
                $nilaiHistoryForecast = Forecast::select('proyeks.kode_proyek', 'proyeks.is_rkap', 'proyeks.is_cancel', 'proyeks.unit_kerja', 'proyeks.stage', 'rkap_forecast', 'nilai_forecast', 'realisasi_forecast', 'month_rkap', 'month_forecast', 'month_realisasi')->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get();
            }

            $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");

            $nilaiForecast = 0;
            $nilaiForecastArray = [];

            $nilaiRkapForecast = 0;
            $nilaiRkapArray = [];

            $nilaiRealisasiForecast = 0;
            $nilaiRealisasiArray = [];

            for ($i = 1; $i <= 12; $i++) {
                foreach ($historyForecast as $forecast) {
                    if ($forecast->is_rkap) {
                        //Untuk OK
                        if ($forecast->month_rkap == $i) {
                            $nilaiRkapForecast += (int) $forecast->rkap_forecast / $per;
                        } else {
                            $nilaiRkapForecast == 0;
                        }
                    }

                    if ($forecast->stage == 8 && !$forecast->is_cancel) {
                        //Untuk Realisasi
                        if ($forecast->month_realisasi == $i && !$forecast->is_cancel && $forecast->month_realisasi <= $month) {
                            $nilaiRealisasiForecast += (int) $forecast->realisasi_forecast / $per;
                        } else {
                            $nilaiRealisasiForecast == 0;
                        }
                    }

                    //Untuk Forecast
                    if ($forecast->month_forecast == $i && !$forecast->is_cancel) {
                        $nilaiForecast += $forecast->nilai_forecast / $per;
                    } else {
                        $nilaiForecast == 0;
                    }
                }

                array_push($nilaiRkapArray, round($nilaiRkapForecast)); // Array Nilai RKAP Forecast
                array_push($nilaiForecastArray, round($nilaiForecast)); // Array Nilai Forecast
                array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast)); // Array Nilai Realisasi
            }

            $data = ["Success" => true, "NilaiRKAP" => $nilaiRkapArray, "NilaiForecast" => $nilaiForecastArray, "NilaiRealisasi" => $nilaiRealisasiArray];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            $data = ["Status" => false, "Message" => $e->getMessage()];

            return response()->json($data, 400);
        }
    }

    /**
     * Get Schedule
     * @param \Illuminate\Support\Facades\Request
     * @return \Illuminate\Support\Facades\Response
     */
    public function getSchedule(Request $request)
    {
        $start = Carbon::create($request->get('start'));
        $end = Carbon::create($request->get('end'));

        $category = $request->get('category');

        $year = date('Y');

        $proyeks = Proyek::select('kode_proyek', 'nama_proyek', 'stage', 'jadwal_pq', 'jadwal_tender')->where('tipe_proyek', 'P')->where('is_cancel', false)->where('tahun_perolehan', $year)->where('is_tidak_lulus_pq', false)->whereIn('stage', [1, 2, 3, 4, 5, 6, 8]);

        if ($category == "jadwal-pq") {
            $proyeks = $proyeks->whereBetween('jadwal_pq', [$start, $end])->get();
            if (!empty($proyeks)) {
                $result = $proyeks->map(function ($proyek) {
                    $newClass = new stdClass();
                    $newClass->title = $proyek->kode_proyek . ' - ' . $proyek->nama_proyek;
                    $newClass->start = !empty($proyek->jadwal_pq) ? Carbon::create($proyek->jadwal_pq)->toDateString() : null;
                    $newClass->setAllDay = true;
                    return $newClass;
                })->toArray();
            } else {
                $result = [];
            }
        } elseif ($category == "jadwal-tender") {
            $proyeks = $proyeks->whereBetween('jadwal_tender', [$start, $end])->get();
            if (!empty($proyeks)) {
                $result = $proyeks->map(function ($proyek) {
                    $newClass = new stdClass();
                    $newClass->title = $proyek->kode_proyek . ' - ' . $proyek->nama_proyek;
                    $newClass->start = !empty($proyek->jadwal_tender) ? Carbon::create($proyek->jadwal_tender)->toDateString() : null;
                    $newClass->setAllDay = true;
                    return $newClass;
                })->toArray();
            } else {
                $result = [];
            }
        }

        // dd($result);

        return response()->json($result);
    }
}
