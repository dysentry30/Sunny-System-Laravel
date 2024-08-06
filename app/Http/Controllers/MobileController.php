<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\MobileNotification;
use App\Models\Proyek;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use stdClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


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
            $proyeksSelected =  Proyek::select(["nama_proyek", "kode_proyek", "dop", "unit_kerja", "bulan_awal", "is_tidak_lulus_pq", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
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
                    case 'Tidak Lolos PQ':
                        $jumlah = $proyek->where('is_tidak_lulus_pq', true)->count();
                        $total = $proyek->where('is_tidak_lulus_pq', true)->sum('hps_pagu');
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
            $proyekIsTidakLulusPQ->category = "Tidak Lolos PQ";
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

            $proyeks =  Proyek::select(["nama_proyek", "kode_proyek", "dop", "unit_kerja", "bulan_awal", "is_tidak_lulus_pq", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
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
                })
                ->get();

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
                case 'Tidak Lolos PQ':
                    $proyeks = $proyeks->where('is_tidak_lulus_pq', true)->sortBy('bulan_perolehan', SORT_NUMERIC)->values();
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
                $newClass->total_forecast = $proyek->stage < 6 ? $proyek->hps_pagu : $proyek->nilai_perolehan;
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
            $proyeksSelected =  Proyek::select(["nama_proyek", "kode_proyek", "dop", "unit_kerja", "bulan_awal", "is_tidak_lulus_pq", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek", "tahun_perolehan", "jenis_proyek", "is_cancel"])
            ->where('tahun_perolehan', $tahunSelect)
                ->where('jenis_proyek', '!=', 'I')
                ->whereIn('stage', [6, 7, 8])
                ->where('tipe_proyek', 'P')
            ->where(function ($query) {
                $query->where("is_tidak_lulus_pq", null)
                    ->orWhere("is_tidak_lulus_pq", false);
            })
                ->where(function ($query) {
                    $query->where("is_cancel", null)
                        ->orWhere("is_cancel", false);
                })
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
            // dd($proyeksGroup["6"]->toArray());

            $proyekMenang = 0;
            $proyekTerkontrak = 0;
            $proyeks = $proyeksGroup->map(function ($proyek, $key) use (&$proyekMenang, &$proyekTerkontrak) {
                $newClass = new stdClass();
                $newClass->category = $this->getStage((int) $key);

                switch ($newClass->category) {
                    case 'Menang':
                        $jumlah = $proyek->where("nilai_perolehan", "!=", 0)->count();
                        $total = $proyek->where("nilai_perolehan", "!=", 0)->sum(function ($proyek) {
                            if ($proyek->nilai_perolehan != 0 || $proyek->nilai_perolehan != "" || $proyek->nilai_perolehan != "0") {
                                return (int)$proyek->nilai_perolehan;
                            } else {
                                return 0;
                            }
                        });
                        $proyekMenang += $jumlah;
                        break;
                    case 'Kalah':
                        $jumlah = $proyek->where("nilai_perolehan", "!=", 0)->count();
                        $total = $proyek->where("nilai_perolehan", "!=", 0)->sum(function ($proyek) {
                            if ($proyek->nilai_perolehan != 0 || $proyek->nilai_perolehan != "" || $proyek->nilai_perolehan != "0") {
                                return (int)$proyek->nilai_perolehan;
                            } else {
                                return 0;
                            }
                        });
                        break;
                    case 'Terkontrak':
                        $jumlah = $proyek->where("nilai_perolehan", "!=", 0)->count();
                        $total = $proyek->where("nilai_perolehan", "!=", 0)->sum(function ($proyek) {
                            if ($proyek->nilai_perolehan != 0 || $proyek->nilai_perolehan != "" || $proyek->nilai_perolehan != "0") {
                                return (int)$proyek->nilai_perolehan;
                            } else {
                                return 0;
                            }
                        });
                        $proyekTerkontrak += $jumlah;
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
                $proyekMenang = $proyeks->where("category", "Menang")?->first()->total_nilai;
                $proyekTerkontrak = $proyeks->where("category", "Terkontrak")?->first()->total_nilai;
                // $winRate = round(($proyekMenang + $proyekTerkontrak) / $proyeksSelected->count(), 2) * 100 . "%";
                $winRate = round(($proyekMenang + $proyekTerkontrak) / $proyeks->sum("total_nilai"), 2) * 100 . "%";
            }

            $data = ['data' => $proyeks->toArray(), 'winRate' => $winRate];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = ["Status" => false, "Message" => $e->getMessage(), "data" => [], 'winRate' => 0];
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

    /**
     * Get Schedule Proyek
     * 
     * @return Illuminate\Http\Response JSON
     */
    public function getSchedule(Request $request)
    {
        $bulan = $request->get("bulan") ?? date("m");
        $tahun = $request->get("tahun") ?? date("Y");
        $unitKerja = $request->get("unitKerja");

        try {
            $proyeks = Proyek::with(["proyekBerjalan"])->select('kode_proyek', 'nama_proyek', 'unit_kerja', 'stage', 'sumber_dana', 'jenis_proyek', 'nilaiok_awal', 'porsi_jo', 'hps_pagu', 'penawaran_tender', 'jenis_terkontrak', 'sistem_bayar', 'is_uang_muka', 'uang_muka', 'jadwal_pq', 'jadwal_tender')->where('tipe_proyek', 'P')->where('is_cancel', false)->where('tahun_perolehan', $tahun)->where('is_tidak_lulus_pq', false)->whereIn('stage', [1, 2, 3, 4, 5, 6, 8])->get();
            
            if (str_contains($unitKerja, ',')) {
                $arrUnitKerja = explode(',', $unitKerja);
                $proyeks = $proyeks->whereIn("unit_kerja", $arrUnitKerja);
            } else if (empty($unitKerja)) {
                $proyeks = $proyeks;
            } else {
                $proyeks = $proyeks->where("unit_kerja", $unitKerja);
            }

            if (!empty($proyeks)) {
                $proyekPrakualifikasi = $proyeks->where("jadwal_pq", "!=", null);
                $proyekTender = $proyeks->where("jadwal_tender", "!=", null);

                if (!empty($proyekPrakualifikasi)) {
                    $proyekPrakualifikasi = $proyekPrakualifikasi->map(function ($proyek) {
                        $proyek->divisi = self::getUnitKerjaProyek($proyek->unit_kerja);
                        $proyek->jenis_proyek = $proyek->jenis_proyek == "J" ? "JO" : ($proyek->jenis_proyek == "I" ? "Internal" : ($proyek->jenis_proyek == "N" ? "External" : ""));
                        $proyek->nilai_ok = "Rp. " . number_format((int)$proyek->nilaiok_proyek, 0, '.', ',');
                        $proyek->nama_pelanggan = $proyek->proyekBerjalan->customer->name ?? "-";
                        $proyek->porsi_jo = !str_contains($proyek->porsi_jo, '%') ? $proyek->porsi_jo . ' %' : $proyek->porsi_jo;
                        $proyek->hps_pagu = "Rp. " . number_format((int)$proyek->hps_pagu, 0, '.', ',');
                        $proyek->uang_muka = !empty($proyek->uang_muka) && !str_contains($proyek->uang_muka, "%") ? $proyek->uang_muka . ' %' : (!empty($proyek->uang_muka) && str_contains($proyek->uang_muka, "%") ? $proyek->uang_muka : '-');
                        $proyek->tgl_event = $proyek->jadwal_pq;
                        $proyek->event = "Pemasukan Prakualifikasi";
                        return $proyek;
                    })->makeHidden(["unit_kerja", "nilaiok_awal"]);
                }

                if (!empty($proyekTender)) {
                    $proyekTender = $proyekTender->map(function ($proyek) {
                        $proyek->divisi = self::getUnitKerjaProyek($proyek->unit_kerja);
                        $proyek->jenis_proyek = $proyek->jenis_proyek == "J" ? "JO" : ($proyek->jenis_proyek == "I" ? "Internal" : ($proyek->jenis_proyek == "N" ? "External" : ""));
                        $proyek->nilai_ok = "Rp. " . number_format((int)$proyek->nilaiok_proyek, 0, '.', ',');
                        $proyek->nama_pelanggan = $proyek->proyekBerjalan->customer->name ?? "-";
                        $proyek->porsi_jo = !str_contains($proyek->porsi_jo, '%') ? $proyek->porsi_jo . ' %' : $proyek->porsi_jo;
                        $proyek->hps_pagu = "Rp. " . number_format((int)$proyek->hps_pagu, 0, '.', ',');
                        $proyek->nilai_penawaran_keseluruhan = "Rp. " . number_format((int)$proyek->penawaran_tender, 0, '.', ',');
                        $proyek->uang_muka = !empty($proyek->uang_muka) && !str_contains($proyek->uang_muka, "%") ? $proyek->uang_muka . ' %' : (!empty($proyek->uang_muka) && str_contains($proyek->uang_muka, "%") ? $proyek->uang_muka : '-');
                        $proyek->tgl_event = $proyek->jadwal_tender;
                        $proyek->event = "Pemasukan Tender";
                        return $proyek;
                    })->makeHidden(["unit_kerja", "nilaiok_awal"]);
                }

                $proyeks = $proyekPrakualifikasi->merge($proyekTender)->groupBy("tgl_event");

                $proyeks = $proyeks->mapWithKeys(function ($proyek, $key) {
                    return [Carbon::create($key)->format('Y-m-d H:i:s') . ".000Z" => $proyek];
                });
            }

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => null,
                'data' => $proyeks->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'fail',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Get Notification In Apps
     * @return Illuminate\Http\Response JSON
     */
    public function getNotificationInApps(Request $request)
    {
        try {
            $nip = $request->get("nip");

            if (!empty($nip)) {
                $notifications = MobileNotification::where("nip", $nip)->get();

                if ($notifications->isNotEmpty()) {
                    $notifications = $notifications->map(function ($value) {
                        if ($value->sub_category == "Pemasukan Tender") {
                            $value->date_sort = strtotime($value->Proyek->jadwal_tender);
                        } elseif ($value->sub_category == "Pemasukan Prakualifikasi") {
                            $value->date_sort = strtotime($value->Proyek->jadwal_pq);
                        } else {
                            $value->date_sort = null;
                        }
                        return $value;
                    });
                    $notifications = $notifications->makeHidden(["Proyek"])->sortByDesc("date_sort")->values();
                    // dd($notifications->sortBy("date_sort"));
                }

                if (!empty($notifications)) {                    
                    return response()->json([
                        'success' => true,
                        'status' => 'success',
                        'message' => null,
                        'data' => $notifications->toArray()
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'status' => 'success',
                        'message' => "Notifikasi Belum Tersedia",
                        'data' => []
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'message' => "NIP Tidak ditemukan",
                    'data' => []
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function inputNotification()
    {
        $proyeks = Proyek::where("tahun_perolehan", 2024)->where("tipe_proyek", "P")->whereIn("stage", [3, 4])->get();

        $collectNotif = collect([]);



        $proyeksMap = $proyeks->each(function ($item) use ($collectNotif) {
            // if (!empty($item->jadwal_pq) && $item->jadwal_pq >= Carbon::now()) {
            $pegawaiUnitKerja = User::where("unit_kerja", "like", "%$item->unit_kerja%")->where(function ($query) {
                $query->where("check_administrator", true)->orWhere("check_user_mobile", true);
            })->where("is_active", true)->get();

            if ($pegawaiUnitKerja->isNotEmpty()) {

                foreach ($pegawaiUnitKerja as $pegawai) {

                    if (!empty($item->jadwal_pq)) {
                        Carbon::setLocale('id');
                        $tanggalPQ = Carbon::parse($item->jadwal_pq);
                        $messagePQ = $tanggalPQ->diffForHumans(Carbon::now(), [
                            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
                            'parts' => 1,
                            'options' => Carbon::ONE_DAY_WORDS,
                        ]);

                        $collectNotif->push([
                            "id" => Str::uuid(),
                            "kode_proyek" => $item->kode_proyek,
                            "category" => "Scheduler",
                            "sub_category" => "Pemasukan Prakualifikasi",
                            "message" => "Waktu Pemasukan Prakualifikasi dilakukan dalam $messagePQ",
                            "item_date" => Carbon::create($item->jadwal_pq)->translatedFormat("d F Y"),
                            "nip" => $pegawai->nip,
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ]);
                    }

                    // if (!empty($item->jadwal_tender) && $item->jadwal_tender >= Carbon::now()) {
                    if (!empty($item->jadwal_tender)) {
                        Carbon::setLocale('id');
                        $tanggalTender = Carbon::parse($item->jadwal_tender);
                        $messageTender = $tanggalTender->diffForHumans(Carbon::now(), [
                            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
                            'parts' => 1,
                            'options' => Carbon::ONE_DAY_WORDS,
                        ]);

                        $collectNotif->push([
                            "id" => Str::uuid(),
                            "kode_proyek" => $item->kode_proyek,
                            "category" => "Scheduler",
                            "sub_category" => "Pemasukan Tender",
                            "message" => "Waktu Pemasukan Tender dilakukan dalam $messageTender",
                            "item_date" => Carbon::create($item->jadwal_tender)->translatedFormat("d F Y"),
                            "nip" => $pegawai->nip,
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ]);
                    }
                }
            }
        });

        if ($collectNotif->isNotEmpty()) {
            MobileNotification::insert($collectNotif->toArray());
        }
    }

    public function readNotification(Request $request, MobileNotification $notification)
    {
        try {

            DB::beginTransaction();
            if (!empty($notification)) {
                $notification->is_read = true;
                $notification->save();
                $proyeks = Proyek::with(["proyekBerjalan"])->select('kode_proyek', 'nama_proyek', 'unit_kerja', 'stage', 'sumber_dana', 'jenis_proyek', 'nilaiok_awal', 'porsi_jo', 'hps_pagu', 'penawaran_tender', 'jenis_terkontrak', 'sistem_bayar', 'is_uang_muka', 'uang_muka', 'jadwal_pq', 'jadwal_tender')->where("kode_proyek", $notification->kode_proyek)->first();
                $proyeks->divisi = self::getUnitKerjaProyek($proyeks->unit_kerja);
                $proyeks->jenis_proyek = $proyeks->jenis_proyek == "J" ? "JO" : ($proyeks->jenis_proyek == "I" ? "Internal" : ($proyeks->jenis_proyek == "N" ? "External" : ""));
                $proyeks->nilai_ok = "Rp. " . number_format((int)$proyeks->nilaiok_proyek, 0, '.', ',');
                $proyeks->nama_pelanggan = $proyeks->proyekBerjalan->customer->name ?? "-";
                $proyeks->porsi_jo = !str_contains($proyeks->porsi_jo, '%') ? $proyeks->porsi_jo . ' %' : $proyeks->porsi_jo;
                $proyeks->hps_pagu = "Rp. " . number_format((int)$proyeks->hps_pagu, 0, '.', ',');
                $proyeks->nilai_penawaran_keseluruhan = "Rp. " . number_format((int)$proyeks->penawaran_tender, 0, '.', ',');
                $proyeks->uang_muka = !empty($proyeks->uang_muka) && !str_contains($proyeks->uang_muka, "%") ? $proyeks->uang_muka . ' %' : (!empty($proyeks->uang_muka) && str_contains($proyeks->uang_muka, "%") ? $proyeks->uang_muka : '-');
            } else {
                $proyeks = collect([]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => null,
                'data' => $proyeks->toArray()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function falseNotification()
    {
        try {
            $notification = MobileNotification::where("is_read", true)->update(["is_read" => false]);
            return response()->json("Success");
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
