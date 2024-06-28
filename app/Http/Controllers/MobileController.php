<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use stdClass;

class MobileController extends Controller
{
    /**
     * Get Data Forecast
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function GetDataForecast(Request $request)
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
     * Get Data Forecast
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function GetDataForecastNew(Request $request, $unitKerja = null, $yearFilter, $monthFilter)
    {
        $per = 1_000_000; //Dibagi Dalam Jutaan
        // $per = 1_000_000_000; //Dibagi Dalam Jutaan

        $year = (int)date("m") == 1 && (int)date("d") < 5 ? (int) date("Y") : (int) date("Y") - 1;

        if (!empty($yearFilter)) {
            $year = $yearFilter;
        }

        if ((int)date('d') < 5) {
            $month = (int) date("m") - 1;
        } else {
            $month = (int) date("m");
        }

        if (!empty($monthFilter)) {
            $month = $monthFilter;
        }

        try {
            $nilaiHistoryForecast = HistoryForecast::select('proyeks.kode_proyek', 'proyeks.is_rkap', 'proyeks.is_cancel', 'proyeks.unit_kerja', 'proyeks.stage', 'rkap_forecast', 'nilai_forecast', 'realisasi_forecast', 'month_rkap', 'month_forecast', 'month_realisasi')->join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("history_forecast.tahun", "=", $year)->get();
            $countUnitKerjaFromHistory = $nilaiHistoryForecast->groupBy('unit_kerja')->count();

            if ($nilaiHistoryForecast->count() < 1 || $countUnitKerjaFromHistory < 11) {
                $nilaiHistoryForecast = Forecast::select('proyeks.kode_proyek', 'proyeks.is_rkap', 'proyeks.is_cancel', 'proyeks.unit_kerja', 'proyeks.stage', 'rkap_forecast', 'nilai_forecast', 'realisasi_forecast', 'month_rkap', 'month_forecast', 'month_realisasi')->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get();
            }

            if (!empty($unitKerja)) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $unitKerja);
            }


            $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");

            $nilaiForecast = 0;
            $nilaiForecastArray = [];

            $nilaiRkapForecast = 0;
            $nilaiRkapArray = [];

            $nilaiRealisasiForecast = 0;
            $nilaiRealisasiArray = [];

            $collectDataDashboardForecast = collect([]);

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

                // array_push($nilaiRkapArray, round($nilaiRkapForecast)); // Array Nilai RKAP Forecast
                // array_push($nilaiForecastArray, round($nilaiForecast)); // Array Nilai Forecast
                // array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast)); // Array Nilai Realisasi

                $stdClass = new stdClass();
                $stdClass->nilaiRKAPPerBulan = round($nilaiRkapForecast);
                $stdClass->nilaiForecastPerBulan = round($nilaiForecast);
                $stdClass->nilaiRealisasiPerBulan = round($nilaiRealisasiForecast);

                $collectDataDashboardForecast->push($stdClass);
            }

            // $data = ["Success" => true, "NilaiRKAP" => $nilaiRkapArray, "NilaiForecast" => $nilaiForecastArray, "NilaiRealisasi" => $nilaiRealisasiArray];

            $data = [
                "tahun" => $year,
                "periodePrognosa" => $month,
                "unitKerja" => UnitKerja::where("divcode", $unitKerja)->first()?->unit_kerja,
                "data" => $collectDataDashboardForecast->toArray(),
                "success" => true,
                "message" => null
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            // $data = ["Status" => false, "Message" => $e->getMessage()];
            $data = [
                "tahun" => null,
                "periodePrognosa" => null,
                "unitKerja" => UnitKerja::where("divcode", $unitKerja)->first()?->unit_kerja,
                "data" => [],
                "success" => false,
                "message" => $e->getMessage()
            ];
            return response()->json($data, 400);
        }
    }

    /**
     * Get Data Forecast
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function GetDataForecastAll(Request $request)
    {
        $data = $request->all();
        $per = 1_000_000; //Dibagi Dalam Jutaan
        // $per = 1_000_000_000; //Dibagi Dalam Jutaan

        $year = (int)date("m") == 1 && (int)date("d") < 5 ? (int) date("Y") - 1 : (int) date("Y");

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


            if (str_contains($data["unit_kerja"], ',')) {
                $arrUnitKerja = explode(',', $data["unit_kerja"]);
                $nilaiHistoryForecast = $nilaiHistoryForecast->whereIn("unit_kerja", $arrUnitKerja);
            } else if (empty($data["unit_kerja"])) {
                $nilaiHistoryForecast = $nilaiHistoryForecast;
            } else {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $data["unit_kerja"]);

            }


            $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");

            $nilaiForecast = 0;
            $nilaiForecastArray = [];

            $nilaiRkapForecast = 0;
            $nilaiRkapArray = [];

            $nilaiRealisasiForecast = 0;
            $nilaiRealisasiArray = [];

            $collectDataDashboardForecast = collect([]);

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

                // array_push($nilaiRkapArray, round($nilaiRkapForecast)); // Array Nilai RKAP Forecast
                // array_push($nilaiForecastArray, round($nilaiForecast)); // Array Nilai Forecast
                // array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast)); // Array Nilai Realisasi

                $stdClass = new stdClass();
                $stdClass->nilaiRKAPPerBulan = round($nilaiRkapForecast);
                $stdClass->nilaiForecastPerBulan = round($nilaiForecast);
                $stdClass->nilaiRealisasiPerBulan = round($nilaiRealisasiForecast);

                $collectDataDashboardForecast->push($stdClass);
            }

            // $data = ["Success" => true, "NilaiRKAP" => $nilaiRkapArray, "NilaiForecast" => $nilaiForecastArray, "NilaiRealisasi" => $nilaiRealisasiArray];

            $data = [
                "tahun" => $year,
                "periodePrognosa" => $month,
                // "unitKerja" => UnitKerja::where("divcode", $unitKerja)->first()?->unit_kerja,
                "data" => $collectDataDashboardForecast->toArray(),
                "success" => true,
                "message" => null
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            // $data = ["Status" => false, "Message" => $e->getMessage()];
            $data = [
                "tahun" => null,
                "periodePrognosa" => null,
                // "unitKerja" => UnitKerja::where("divcode", $unitKerja)->first()?->unit_kerja,
                "data" => [],
                "success" => false,
                "message" => $e->getMessage()
            ];
            return response()->json($data, 400);
        }
    }

    /**
     * Get Data Monitoring Proyek
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function GetMonitoringProyek(Request $request)
    {
        try {
            $filterKategori = $request->get('kategori');

            $proyeks =  Proyek::with(["UnitKerja", "Forecasts"])
                ->select(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
                ->where('tahun_perolehan', date('Y'))
                ->where('jenis_proyek', '!=', 'I')
                ->where('tipe_proyek', 'P')
                ->get();

            switch ($filterKategori) {
                case 'Tender Diikuti':
                    $proyeks = $proyeks->whereIn('stage', [4, 5])->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Prakualifikasi':
                    $proyeks = $proyeks->where('stage', 3)->where('is_tidak_lulus_pq', false)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Menang':
                    $proyeks = $proyeks->where('stage', 6)->where('is_tidak_lulus_pq', false)->sortBy('bulan_perolehan', SORT_NUMERIC)->values();
                    break;
                case 'Kalah':
                    $proyeks = $proyeks->where('stage', 7)->where('is_tidak_lulus_pq', false)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Cancel':
                    $proyeks = $proyeks->where('is_cancel', true)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;

                default:
                    $proyeks;
                    break;
            }

            $proyeks = $proyeks->map(function ($proyek) {
                $newClass = new stdClass();
                $newClass->nama_proyek = $proyek->nama_proyek;
                $newClass->status_pasar = $proyek->status_pasdin;
                $newClass->stage = self::getStage($proyek->stage);
                $newClass->unit_kerja = $proyek->UnitKerja->unit_kerja;
                $newClass->tipe_proyek = $proyek->tipe_proyek == "P" ? 'Non-Retail' : 'Retail';
                $newClass->bulan_ra = $proyek->stage != 6 ? self::getNamaBulan((int)$proyek->bulan_pelaksanaan) : self::getNamaBulan((int)$proyek->bulan_perolehan);
                $newClass->nilai_proyek = $proyek->stage != 6 ? $proyek->hps_pagu : $proyek->nilai_perolehan;
                return $newClass;
            });
            $data = ["Status" => true, "Message" => "Success", 'data' => $proyeks->toArray()];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = ["Status" => false, "Message" => $e->getMessage(), "data" => []];
            return response()->json($data);
        }
    }

    /**
     * Get Unit Kerja
     * 
     * @return 
     */
    public function GetUnitKerja(string $departemen)
    {
        $curYear = 2022;
        $unit_kerjas = UnitKerja::with(["proyeks"])->get()->map(function ($unit_kerja) {
            $new_class = new stdClass();
            $new_class->divcode = $unit_kerja->divcode;
            $new_class->unit_kerja = $unit_kerja->unit_kerja;
            $new_class->direktorat = $unit_kerja->dop;
            $new_class->tahun = $unit_kerja->proyeks->isNotEmpty() ? $unit_kerja->proyeks->groupBy("tahun_perolehan")->keys()->max() : 0;
            return $new_class;
        })->whereNotIn("divcode", ["C", "B", "D", "8"]);
        if ($departemen != "All Direktorat") {
            $unit_kerjas = $unit_kerjas->where("direktorat", "=", $departemen);
        }
        return response()->json($unit_kerjas->values());
    }

    /**
     * Get Data Detail Proyek Forecast
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function getListProyek(Request $request, string $page)
    {
        try {
            $category = $request->get("category");
            $departemen = $request->get("departemen");
            $unitKerja = $request->get("unitKerja");
            $periodePrognosa = $request->get("periodePrognosa") ?? 3;
            $tahun = $request->get("tahun") ?? date("Y");

            if ($page == "list-proyek-forecast") {
                $data = [];

                $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->get()->where("is_cancel", "!=", true);
                // dd($history_forecasts);
                $countUnitKerjaFromHistory = $history_forecasts->groupBy('unit_kerja')->count();
                if ($history_forecasts->count() < 1 || $countUnitKerjaFromHistory < 11) {
                    $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->get()->where("is_cancel", "!=", true);
                }
                if ($unitKerja != "" && strlen($unitKerja) == 1) {
                    $history_forecasts = $history_forecasts->where("divcode", $unitKerja);
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->where("divcode", $unitKerja)->get()->where("is_cancel", "!=", true);
                    }
                    // dd($history_forecasts);
                } elseif ($unitKerja != "") {
                    $dop = str_replace("-", " ", $unitKerja);
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->where("divcode", $unitKerja)->get()->where("is_cancel", "!=", true);
                    }
                    if ($unitKerja == "PUSAT") {
                        $history_forecasts = $history_forecasts->whereIn("dop", ["DOP 1", "DOP 2", "DOP 3"]);
                    } else {
                        $history_forecasts = $history_forecasts->where("dop", $dop);
                    }
                    // dd($dop, $history_forecasts);
                }

                $history_forecasts = $history_forecasts
                    ->when($category == "Forecast", function ($history) {
                        $history->where("nilai_forecast", "!=", "")
                        ->where("nilai_forecast", "!=", "0")
                            ->where("month_forecast", "!=", 0)
                            ->where("month_forecast", SORT_NUMERIC);
                    })
                    ->when($category == "RKAP", function ($history) {
                        $history->where("is_rkap", "=", true)
                            ->where("rkap_forecast", "!=", "")
                            ->where("rkap_forecast", "!=", "0")
                            ->where("month_rkap", "!=", 0)
                            ->where("month_rkap", SORT_NUMERIC);
                    })
                    ->when($category == "Realisasi", function ($history) {
                        $history->where("stage", 8)
                        ->where("realisasi_forecast", "!=", "")
                        ->where("realisasi_forecast", "!=", "0")
                            ->where("month_realisasi", "!=", 0)
                            ->where("month_realisasi", SORT_NUMERIC);
                    })
                    ->groupBy("kode_proyek");

                foreach ($history_forecasts as $kode_proyek => $filter) {
                    foreach ($filter as $f) {
                        if ($f->month_rkap <= $periodePrognosa) {
                            if (!array_key_exists($f->kode_proyek, $data)) {
                                $data[$kode_proyek] = $f;
                            } else {
                                if ($category == "Forecast") {
                                    $data[$kode_proyek]->nilai_forecast += $f->nilai_forecast;
                                    $data[$kode_proyek]->month_forecast = $f->month_forecast;
                                } elseif ($category == "RKAP") {
                                    $data[$kode_proyek]->rkap_forecast += $f->rkap_forecast;
                                    $data[$kode_proyek]->month_rkap = $f->month_rkap;
                                } elseif ($category == "Realisasi") {
                                    $data[$kode_proyek]->realisasi_forecast += $f->realisasi_forecast;
                                    $data[$kode_proyek]->month_realisasi = $f->month_realisasi;
                                }
                            }
                        }
                    }
                    if (isset($data[$kode_proyek])) {
                        if ($data[$kode_proyek]->tipe_proyek == "R") {
                            $tipe_proyek = "Retail";
                        } else {
                            $tipe_proyek = "Non-Retail";
                        }
                        $data[$kode_proyek]->nama_proyek;
                        $data[$kode_proyek]->status_pasdin;
                        $data[$kode_proyek]->stage = $this->getStage($data[$kode_proyek]->stage);
                        $data[$kode_proyek]->tipe_proyek = $tipe_proyek;

                        if ($category == "Forecast") {
                            $data[$kode_proyek]->bulan = $this->getNamaBulan($data[$kode_proyek]->month_forecast);
                        } elseif ($category == "RKAP") {
                            $data[$kode_proyek]->bulan = $this->getNamaBulan($data[$kode_proyek]->month_rkap);
                        } elseif ($category == "Realisasi") {
                            $data[$kode_proyek]->bulan = $this->getNamaBulan($data[$kode_proyek]->month_realisasi);
                        }
                        // $data[$kode_proyek]->rkap_forecast;
                    }
                }
                $data = collect($data)->values();
                return response()->json($data);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }





    private function getStage(int $stage)
    {
        switch ($stage) {
            case 1:
                $stg = "Pasar Dini";
                break;
            case 2:
                $stg = "Pasar Potensial";
                break;
            case 3:
                $stg = "Prakualifikasi";
                break;
            case 4:
                $stg = "Tender Diikuti";
                break;
            case 5:
                $stg = "Perolehan";
                break;
            case 6:
                $stg = "Menang";
                break;
            case 7:
                $stg = "Kalah";
                break;
            case 8:
                $stg = "Terkontrak";
                break;

            default:
                $stg = "";
                break;
        }

        return $stg;
    }

    private function getNamaBulan($bulan)
    {
        if (!empty($bulan)) {
            switch ($bulan) {
                case 1:
                    $namaBulan = "Januari";
                    break;
                case 2:
                    $namaBulan = "Februari";
                    break;
                case 3:
                    $namaBulan = "Maret";
                    break;
                case 4:
                    $namaBulan = "April";
                    break;
                case 5:
                    $namaBulan = "Mei";
                    break;
                case 6:
                    $namaBulan = "Juni";
                    break;
                case 7:
                    $namaBulan = "Juli";
                    break;
                case 8:
                    $namaBulan = "Agustus";
                    break;
                case 9:
                    $namaBulan = "September";
                    break;
                case 10:
                    $namaBulan = "Oktober";
                    break;
                case 11:
                    $namaBulan = "November";
                    break;
                case 12:
                    $namaBulan = "Desember";
                    break;

                default:
                    $namaBulan = "";
                    break;
            }
        } else {
            $namaBulan = "";
        }

        return $namaBulan;
    }

    private function getUnitKerjaProyek(string $unitKerja): string
    {
        $unitKerjaSelected = UnitKerja::where("divcode", $unitKerja)->first();
        return $unitKerjaSelected->unit_kerja;
    }
}
