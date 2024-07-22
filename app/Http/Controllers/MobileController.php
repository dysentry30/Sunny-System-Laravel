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
    public function GetDataForecastNew(Request $request, $yearFilter, $monthFilter)
    {
        $per = 1_000_000; //Dibagi Dalam Jutaan
        // $per = 1_000_000_000; //Dibagi Dalam Jutaan
        $unitKerja = $request->get("unit_kerja");
        $departemen = $request->get("direktorat");

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
            $nilaiHistoryForecast = HistoryForecast::select('proyeks.kode_proyek', 'proyeks.is_rkap', 'proyeks.dop', 'proyeks.is_cancel', 'proyeks.unit_kerja', 'proyeks.stage', 'rkap_forecast', 'nilai_forecast', 'realisasi_forecast', 'month_rkap', 'month_forecast', 'month_realisasi')->join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("history_forecast.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("history_forecast.tahun", "=", $year)->get();
            $countUnitKerjaFromHistory = $nilaiHistoryForecast->groupBy('unit_kerja')->count();

            if ($nilaiHistoryForecast->count() < 1 || $countUnitKerjaFromHistory < 11) {
                $nilaiHistoryForecast = Forecast::select('proyeks.kode_proyek', 'proyeks.is_rkap', 'proyeks.dop', 'proyeks.is_cancel', 'proyeks.unit_kerja', 'proyeks.stage', 'rkap_forecast', 'nilai_forecast', 'realisasi_forecast', 'month_rkap', 'month_forecast', 'month_realisasi')->join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("tahun_perolehan", "=", $year)->where("forecasts.periode_prognosa", "=", $month != "" ? (string) $month : (int) date("m"))->where("forecasts.tahun", "=", $year)->get();
            }

            if (!empty($unitKerja)) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $unitKerja);
            }

            if (!empty($departemen)) {
                if ($departemen == "PUSAT") {
                    $nilaiHistoryForecast = $nilaiHistoryForecast->where("dop", "!=", "EA");
                } else {
                    $nilaiHistoryForecast = $nilaiHistoryForecast->where("dop", $departemen);
                }
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
     * Get Data Total Monitoring Proyek
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function GetTotalMonitoringProyek(Request $request)
    {
        try {
            $filterDepartemen = $request->get("departemen");
            $filterUnitKerja = $request->get("unitKerja");
            $tahunSelect = $request->get("tahun") ?? date("Y");
            $proyeksSelected =  Proyek::select(["nama_proyek", "kode_proyek", "dop", "unit_kerja", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
            ->where('tahun_perolehan', $tahunSelect)
                ->where('jenis_proyek', '!=', 'I')
                ->whereNotIn('stage', [1, 2])
                ->where('tipe_proyek', 'P')
                ->get();

            $proyeksSelected = $proyeksSelected->when(!empty($filterDepartemen), function ($query) use ($filterDepartemen) {
                if ($filterDepartemen == "PUSAT") {
                    return $query->where('dop', "!=", "EA");
                } else {
                    return $query->where('dop', $filterDepartemen);
                }
            })
            ->when(!empty($filterUnitKerja), function ($query) use ($filterUnitKerja) {
                return $query->where('unit_kerja', $filterUnitKerja);
            });

            $proyeksGroup = $proyeksSelected?->groupBy("stage");

            $proyeks = $proyeksGroup->map(function ($proyek, $key) {
                $newClass = new stdClass();
                $newClass->category = $this->getStage((int) $key);

                switch ($newClass->category) {
                    case 'Tender Diikuti':
                        $jumlah = $proyek->where('is_cancel', false)->count();
                        $total = $proyek->where('is_cancel', false)->sum('hps_pagu');
                        break;
                    case 'Prakualifikasi':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum('hps_pagu');
                        break;
                    case 'Menang':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum('nilai_perolehan');
                        break;
                    case 'Kalah':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum('nilai_perolehan');
                        break;
                    case 'Perolehan':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum('nilai_perolehan');
                        break;
                    case 'Terkontrak':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum('nilai_perolehan');
                        break;

                    default:
                        $jumlah = 0;
                        $total = 0;
                        break;
                }

                $newClass->jumlah = $jumlah;
                $newClass->total_nilai = $total;
                return $newClass;
            })->values();

            $totalProyekTidakLulusPQ = $proyeksSelected->where("stage", ">=", 3)->where("is_tidak_lulus_pq", true)->count();
            $totalProyekCancel = $proyeksSelected->where("is_cancel", true)->count();

            $proyekIsTidakLulusPQ = new stdClass();
            $proyekIsTidakLulusPQ->category = "Tidak Lulus PQ";
            $proyekIsTidakLulusPQ->jumlah = $totalProyekTidakLulusPQ;
            $proyekIsTidakLulusPQ->total_nilai = $proyeksSelected->where("stage", ">=", 3)->where("is_tidak_lulus_pq", true)->sum("hps_pagu");

            $proyekIsCancel = new stdClass();
            $proyekIsCancel->category = "Cancel";
            $proyekIsCancel->jumlah = $totalProyekCancel;
            $proyekIsCancel->total_nilai = $proyeksSelected->where("is_cancel", true)->sum("hps_pagu");

            $proyeks->push($proyekIsTidakLulusPQ);
            $proyeks->push($proyekIsCancel);

            $data = ['data' => $proyeks->toArray()];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = ["Status" => false, "Message" => $e->getMessage(), "data" => []];
            return response()->json($data);
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
            $filterKategori = $request->get('category');
            $filterDepartemen = $request->get('departemen');
            $filterUnitKerja = $request->get('unitKerja');
            $filterTahun = $request->get('tahun') ?? date("Y");

            $proyeks =  Proyek::select(["nama_proyek", "kode_proyek", "dop", "unit_kerja", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
                ->where('tahun_perolehan', $filterTahun)
                ->where('jenis_proyek', '!=', 'I')
                ->where('tipe_proyek', 'P')
            ->whereNotIn('stage', [1, 2])
                ->when(!empty($filterDepartemen), function ($query) use ($filterDepartemen) {
                if ($filterDepartemen == "PUSAT") {
                    $query->where('dop', "!=", "EA");
                } else {
                    $query->where('dop', $filterDepartemen);
                }
                    
                })
                ->when(!empty($filterUnitKerja), function ($query) use ($filterUnitKerja) {
                    $query->where('unit_kerja', $filterUnitKerja);
                })->get();

            switch ($filterKategori) {
                case 'Tender Diikuti':
                    $proyeks = $proyeks->whereIn('stage', [4, 5])->where('is_cancel', false)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Prakualifikasi':
                    $proyeks = $proyeks->where('stage', 3)->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Menang':
                    $proyeks = $proyeks->where('stage', 6)->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sortBy('bulan_perolehan', SORT_NUMERIC)->values();
                    break;
                case 'Kalah':
                    $proyeks = $proyeks->where('stage', 7)->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Cancel':
                    $proyeks = $proyeks->where('is_cancel', true)->sortBy('bulan_pelaksanaan', SORT_NUMERIC)->values();
                    break;
                case 'Perolehan':
                    $proyeks = $proyeks->where('stage', 5)->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sortBy('bulan_perolehan', SORT_NUMERIC)->values();
                    break;
                case 'Terkontrak':
                    $proyeks = $proyeks->where('stage', 8)->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sortBy('bulan_perolehan', SORT_NUMERIC)->values();
                    break;

                default:
                    $proyeks;
                    break;
            }

            $proyeks = $proyeks->map(function ($proyek) {
                $proyek->hps_pagu = $proyek->hps_pagu ?: "0";
                $proyek->nilai_perolehan = $proyek->nilai_perolehan ?: "0";

                $newClass = new stdClass();
                $newClass->nama_proyek = $proyek->nama_proyek;
                $newClass->status_pasar = $proyek->status_pasdin;
                $newClass->stage = self::getStage($proyek->stage);
                $newClass->unit_kerja = $proyek->UnitKerja->unit_kerja;
                $newClass->tipe_proyek = $proyek->tipe_proyek == "P" ? 'Non-Retail' : 'Retail';
                $newClass->bulan = $proyek->stage != 6 ? self::getNamaBulan((int)$proyek->bulan_pelaksanaan) : self::getNamaBulan((int)$proyek->bulan_perolehan);
                $newClass->total_forecast = $proyek->stage != 6 ? $proyek->hps_pagu : $proyek->nilai_perolehan;
                return $newClass;
            });
            $data = ['data' => $proyeks->toArray()];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = ["data" => []];
            return response()->json($data);
        }
    }

    /**
     * Get Data Total Monitoring Proyek
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function GetTotalCompetitiveIndex(Request $request)
    {
        try {
            $tahunSelect = $request->get("tahun") ?? date("Y");
            $filterDepartemen = $request->get("departemen");
            $filterUnitKerja = $request->get("unitKerja");
            $tahunSelect = $request->get("tahun") ?? date("Y");
            $proyeksSelected =  Proyek::select(["nama_proyek", "kode_proyek", "dop", "unit_kerja", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
            ->where('tahun_perolehan', $tahunSelect)
                ->where('jenis_proyek', '!=', 'I')
                ->whereIn('stage', [6, 7, 8])
                ->where('tipe_proyek', 'P')
            ->when(!empty($filterDepartemen), function ($query) use ($filterDepartemen) {
                if ($filterDepartemen == "PUSAT") {
                    $query->where('dop', "!=", "EA");
                } else {
                    $query->where('dop', $filterDepartemen);
                }
            })
                ->when(!empty($filterUnitKerja), function ($query) use ($filterUnitKerja) {
                    $query->where('unit_kerja', $filterUnitKerja);
                })
                ->orderBy("stage")
                ->get();

            $proyeksGroup = $proyeksSelected?->groupBy("stage");

            $proyekMenang = 0;
            $proyekTerkontrak = 0;
            $proyeks = $proyeksGroup->map(function ($proyek, $key) use (&$proyekMenang, &$proyekTerkontrak) {
                $newClass = new stdClass();
                $newClass->category = $this->getStage((int) $key);

                switch ($newClass->category) {
                    case 'Menang':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum(function ($proyek) {
                            if ($proyek->nilai_perolehan != 0) {
                                return (int)$proyek->nilai_perolehan * ($proyek->porsi_jo / 100);
                            } else {
                                return 0;
                            }
                        });
                        $proyekMenang++;
                        break;
                    case 'Kalah':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum(function ($proyek) {
                            if ($proyek->nilai_perolehan != 0) {
                                return (int)$proyek->nilai_perolehan * ($proyek->porsi_jo / 100);
                            } else {
                                return 0;
                            }
                        });
                        break;
                    case 'Terkontrak':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', false)->where('is_cancel', false)->sum(function ($proyek) {
                            if ($proyek->nilai_perolehan != 0) {
                                return (int)$proyek->nilai_perolehan * ($proyek->porsi_jo / 100);
                            } else {
                                return 0;
                            }
                        });
                        $proyekTerkontrak++;
                        break;

                    default:
                        $jumlah = 0;
                        $total = 0;
                        break;
                }

                $newClass->jumlah = $jumlah;
                $newClass->total_nilai = $total;
                return $newClass;
            })->values();

            $winRate = "0%";
            if ($proyeksSelected->count() > 0) {
                $winRate = round(($proyekMenang + $proyekTerkontrak) / $proyeksSelected->count(), 2) . "%";
            }

            $data = ['data' => $proyeks->toArray(), 'winRate' => $winRate];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = ["Status" => false, "Message" => $e->getMessage(), "data" => [], 'winRate' => $winRate];
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
        $unit_kerjas = UnitKerja::with(["proyeks"])->where('id_profit_center', '!=', null)->orderBy("id_profit_center")->get()->map(function ($unit_kerja) {
            $new_class = new stdClass();
            $new_class->divcode = $unit_kerja->divcode;
            $new_class->unit_kerja = $unit_kerja->unit_kerja;
            $new_class->direktorat = $unit_kerja->dop;
            $new_class->tahun = $unit_kerja->proyeks->isNotEmpty() ? $unit_kerja->proyeks->groupBy("tahun_perolehan")->keys()->max() : 0;
            return $new_class;
        })->whereNotIn("divcode", ["C", "B", "D", "8"]);
        if ($departemen == "PUSAT") {
            $unit_kerjas = $unit_kerjas->where("direktorat", "!=", "EA");
        } else {
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

            if ($page == "list-proyek-forecast" || $page == "realisasi-ok") {
                $data = [];

                $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.is_rkap", "proyeks.dop", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "history_forecast.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->get()->where("is_cancel", "!=", true);
                // dd($history_forecasts);
                $countUnitKerjaFromHistory = $history_forecasts->groupBy('unit_kerja')->count();
                if ($history_forecasts->count() < 1 || $countUnitKerjaFromHistory < 11) {
                    $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.is_rkap", "proyeks.dop", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->get()->where("is_cancel", "!=", true);
                }
                if ($unitKerja != "" && strlen($unitKerja) == 1) {
                    $history_forecasts = $history_forecasts->where("divcode", $unitKerja);
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.is_rkap", "proyeks.dop", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->where("divcode", $unitKerja)->get()->where("is_cancel", "!=", true);
                    }
                    // dd($history_forecasts);
                } elseif (empty($unitKerja) && !empty($departemen)) {
                    // $dop = str_replace("-", " ", $unitKerja);
                    if (empty($history_forecasts) || $history_forecasts->isEmpty()) {
                        $history_forecasts = Proyek::select("proyeks.nama_proyek", "proyeks.stage", "proyeks.status_pasdin", "proyeks.is_rkap", "proyeks.dop", "proyeks.tipe_proyek", "proyeks.tahun_perolehan", "forecasts.*", "unit_kerjas.unit_kerja as unit_kerja", "unit_kerjas.divcode as divcode")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("tahun", "=", $tahun)->where("periode_prognosa", "=", $periodePrognosa)->get()->where("is_cancel", "!=", true);
                    }
                    if ($departemen == "PUSAT") {
                        $history_forecasts = $history_forecasts->where("dop", "!=", "EA");
                    } else {
                        $history_forecasts = $history_forecasts->where("dop", $departemen);
                    }
                    // dd($departemen, $history_forecasts);
                }

                $history_forecasts = $history_forecasts
                    ->when($category == "Forecast", function ($history) {
                    return $history->where("nilai_forecast", "!=", "")
                        ->where("nilai_forecast", "!=", "0")
                            ->where("month_forecast", "!=", 0)
                        ->sortBy("month_forecast", SORT_NUMERIC);
                    })
                    ->when($category == "RKAP", function ($history) {
                    return $history->where("is_rkap", true)
                            ->where("rkap_forecast", "!=", "")
                            ->where("rkap_forecast", "!=", "0")
                            ->where("month_rkap", "!=", 0)
                        ->sortBy("month_rkap", SORT_NUMERIC);
                    })
                    ->when($category == "Realisasi", function ($history) {
                    return $history->where("stage", 8)
                        ->where("realisasi_forecast", "!=", "")
                        ->where("realisasi_forecast", "!=", "0")
                            ->where("month_realisasi", "!=", 0)
                    ->sortBy("month_realisasi", SORT_NUMERIC);
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
                            $data[$kode_proyek]->total_forecast = $data[$kode_proyek]->nilai_forecast;
                            $data[$kode_proyek]->bulan = $this->getNamaBulan($data[$kode_proyek]->month_forecast);
                        } elseif ($category == "RKAP") {
                            $data[$kode_proyek]->total_forecast = $data[$kode_proyek]->rkap_forecast;
                            $data[$kode_proyek]->bulan = $this->getNamaBulan($data[$kode_proyek]->month_rkap);
                        } elseif ($category == "Realisasi") {
                            $data[$kode_proyek]->total_forecast = $data[$kode_proyek]->realisasi_forecast;
                            $data[$kode_proyek]->bulan = $this->getNamaBulan($data[$kode_proyek]->month_realisasi);
                        }
                        // $data[$kode_proyek]->rkap_forecast;
                    }
                }
                $data = collect($data)?->map(function ($item) {
                    $item->total_forecast = (string)$item->total_forecast;
                    return $item;
                })->filter(function ($item) {
                    return $item->total_forecast != "0";
                })->sortByDesc('total_forecast')->values();
                return response()->json(["data" => $data]);
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
