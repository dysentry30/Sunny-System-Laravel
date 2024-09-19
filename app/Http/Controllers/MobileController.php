<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Proyek;
use App\Models\Pegawai;
use App\Models\Forecast;
use App\Models\UnitKerja;
use Carbon\CarbonInterface;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HistoryForecast;
use App\Models\MobileNotification;
use App\Services\sendNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Models\PenilaianPenggunaJasa;
use App\Models\ApprovalTerkontrakProyek;
use App\Services\OwnerSelectionServices;
use App\Services\ApprovalTerkontrakClass;
use App\Services\ProjectSelectionService;
use App\Models\MatriksApprovalTerkontrakProyek;


class MobileController extends Controller
{
    public $isNomorTargetActive;

    public function __construct()
    {
        $this->isNomorTargetActive = env('IS_SEND_EMAIL');
    }

    //? Dashboard Controller
    /**
     * Get Data Forecast
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




    //? Calendar Controller

    /**
     * Get Schedule Proyek
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




    //? Notification Controller

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

    /**
     * Inject Data Notification in Database
     * @return Illuminate\Http\Response JSON
     */
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
                            'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
                            'parts' => 1,
                            'options' => CarbonInterface::ONE_DAY_WORDS,
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

    /**
     * Change Flaging Is Read and get Proyek Detail
     * @return Illuminate\Http\Response JSON
     */
    public function readNotification(Request $request, MobileNotification $notification)
    {
        try {

            DB::beginTransaction();
            if (!empty($notification)) {
                $notification->is_read = true;
                $notification->save();

                switch ($notification->category) {
                    case "Scheduler":
                        $proyeks = Proyek::with(["proyekBerjalan"])->select('kode_proyek', 'nama_proyek', 'unit_kerja', 'stage', 'sumber_dana', 'jenis_proyek', 'nilaiok_awal', 'porsi_jo', 'hps_pagu', 'penawaran_tender', 'jenis_terkontrak', 'sistem_bayar', 'is_uang_muka', 'uang_muka', 'jadwal_pq', 'jadwal_tender')->where("kode_proyek", $notification->kode_proyek)->first();
                        $proyeks->divisi = self::getUnitKerjaProyek($proyeks->unit_kerja);
                        $proyeks->jenis_proyek = $proyeks->jenis_proyek == "J" ? "JO" : ($proyeks->jenis_proyek == "I" ? "Internal" : ($proyeks->jenis_proyek == "N" ? "External" : ""));
                        $proyeks->nilai_ok = "Rp. " . number_format((int)$proyeks->nilaiok_proyek, 0, '.', ',');
                        $proyeks->nama_pelanggan = $proyeks->proyekBerjalan->customer->name ?? "-";
                        $proyeks->porsi_jo = !str_contains($proyeks->porsi_jo, '%') ? $proyeks->porsi_jo . ' %' : $proyeks->porsi_jo;
                        $proyeks->hps_pagu = "Rp. " . number_format((int)$proyeks->hps_pagu, 0, '.', ',');
                        $proyeks->nilai_penawaran_keseluruhan = "Rp. " . number_format((int)$proyeks->penawaran_tender, 0, '.', ',');
                        $proyeks->uang_muka = !empty($proyeks->uang_muka) && !str_contains($proyeks->uang_muka, "%") ? $proyeks->uang_muka . ' %' : (!empty($proyeks->uang_muka) && str_contains($proyeks->uang_muka, "%") ? $proyeks->uang_muka : '-');
                        break;
                    case "Approval":
                        $proyeks = ApprovalTerkontrakProyek::where('kode_proyek', $notification->kode_proyek)->first();
                        $status = "";
                        if ($proyeks->is_revisi) {
                            $status = "Revisi";
                        } elseif ($proyeks->is_approved) {
                            $status = "Disetujui";
                        } elseif ($proyeks->is_request_approval) {
                            $status = "Pengajuan";
                        }

                        $proyeks = collect([
                            "kode_proyek" => $proyeks->kode_proyek,
                            "status" => $status,
                        ]);
                        break;
                }
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

    /**
     * Set Is Read Notification to False
     * @return Illuminate\Http\Response JSON
     */
    public function falseNotification()
    {
        try {
            $notification = MobileNotification::where("is_read", true)->update(["is_read" => false]);
            return response()->json("Success");
        } catch (\Exception $e) {
            throw $e;
        }
    }





    //? Approval Terkontrak Controller
    /**
     * Get List Proyek Approval Terkontrak
     * @return Illuminate\Http\Response JSON
     */
    public function getListApprovalTerkontrak(Request $request, $nip)
    {
        try {
            $user = User::where("nip", $nip)->where("is_active", true)->first();

            if (!empty($user)) {
                $is_super_admin = $user->check_administrator;
                $matriks_user = !$is_super_admin ? $user->Pegawai->MatriksTerkontrakProyek->where("is_active", true) : MatriksApprovalTerkontrakProyek::where("is_active", true)->get();
                if ($matriks_user->isNotEmpty()) {
                    $unitKerja = $matriks_user->map(function ($item) {
                        return $item->unit_kerja;
                    })->toArray();
                } else {
                    $unitKerja = $is_super_admin ? UnitKerja::get("divcode")->toArray() : [];
                }

                $proyeks = ApprovalTerkontrakProyek::whereIn("unit_kerja", $unitKerja)->get();

                if ($proyeks->isNotEmpty()) {
                    $proyeks = $proyeks->map(function ($item) {
                        $status = "";

                        if ($item->is_revisi) {
                            $status = "Revisi";
                        } elseif ($item->is_approved) {
                            $status = "Disetujui";
                        } elseif ($item->is_request_approval) {
                            $status = "Pengajuan";
                        }


                        $newClass = new stdClass();
                        $newClass->kode_proyek = $item->Proyek->kode_proyek;
                        $newClass->nama_proyek = $item->Proyek->nama_proyek;
                        $newClass->nilai_perolehan = number_format((int)$item->Proyek->nilai_perolehan, 0, ',', '.');
                        $newClass->status = $status;
                        $newClass->tanggal_proyek = $status == "Disetujui" ? Carbon::parse($item->approved_on)->format('d/m/Y') : Carbon::parse($item->request_on)->format('d/m/Y');

                        return $newClass;
                    });
                }

                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    'message' => null,
                    'data' => $proyeks->toArray()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'message' => "User is Not Active",
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

    /**
     * Get List Proyek Approval Terkontrak
     * @return Illuminate\Http\Response JSON
     */
    public function getProyekApprovalTerkontrak(Request $request, $nip, Proyek $proyek)
    {
        try {
            $user = User::where("nip", $nip)->where("is_active", true)->first();

            if (!empty($user)) {
                $is_super_admin = $user->check_administrator;
                $matriks_user = !$is_super_admin ? $user->Pegawai->MatriksTerkontrakProyek->where("is_active", true) : MatriksApprovalTerkontrakProyek::where("is_active", true)->get();
                if ($matriks_user->isNotEmpty()) {
                    $unitKerja = $matriks_user->map(function ($item) {
                        return $item->unit_kerja;
                    })->toArray();
                } else {
                    $unitKerja = $is_super_admin ? UnitKerja::get("divcode")->toArray() : [];
                }

                $proyekApproval = $proyek->ApprovalTerkontrakProyek;

                if (empty($proyekApproval)) {
                    return response()->json([
                        'success' => false,
                        'status' => 'failed',
                        'message' => "Proyek tidak ditemukan, Hubungi admin!",
                        'data' => []
                    ]);
                }


                $proyek = [
                    "kode_proyek" => $proyek->kode_proyek ?? '',
                    "nama_proyek" => $proyek->nama_proyek ?? '',
                    "no_spk_eksternal" => $proyek->nospk_external ?? '',
                    "tgl_spk_internal" => Carbon::parse($proyek->tglspk_internal)->format('d/m/Y') ?? '',
                    "tahun_ri_perolehan" => (string)$proyek->tahun_ri_perolehan ?? '',
                    "bulan_ri_perolehan" => self::getNamaBulan($proyek->bulan_ri_perolehan) ?? '',
                    "no_kontrak" => $proyek->nomor_terkontrak ?? '',
                    "tgl_kontrak" => Carbon::parse($proyek->tanggal_terkontrak)->format('d/m/Y') ?? '',
                    "tgl_mulai_kontrak" => Carbon::parse($proyek->tanggal_mulai_terkontrak)->format('d/m/Y') ?? '',
                    "tgl_akhir_kontrak" => Carbon::parse($proyek->tanggal_akhir_terkontrak)->format('d/m/Y') ?? '',
                    "tgl_selesai_bash_pho" => Carbon::parse($proyek->tanggal_selesai_pho)->format('d/m/Y') ?? '',
                    "jenis_proyek" => $proyek->jenis_proyek == 'I' ? "Internal" : ($proyek->jenis_proyek == 'N' ? "Eksternal" : ($proyek->jenis_proyek == 'J' ? "JO" : '')) ?? '',
                    "porsi_jo" => $proyek->porsi_jo ?? '',
                    "mata_uang" => $proyek->mata_uang ?? '',
                    "nilai_kontrak_keseluruhan" => number_format((int)($proyek->nilai_perolehan * 100 / (float) $proyek->porsi_jo), 0, ',', '.') ?? '',
                    "nilai_kontrak_porsi_wika" => number_format((int)$proyek->nilai_perolehan, 0, ',', '.') ?? '',
                    "klasifikasi_proyek" => $proyek->klasifikasi_pasdin ?? '',
                    "jenis_kontrak" => $proyek->jenis_terkontrak ?? '',
                    "laporan_terkontrak" => $proyek->laporan_terkontrak ?? '',
                    "data_approval_terkontrak" => $proyekApproval
                ];



                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    'message' => null,
                    'data' => $proyek
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'message' => "User is Not Active",
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

    /**
     * Set Approve Proyek Approval Terkontrak
     * @return Illuminate\Http\Response JSON
     */
    public function setApproveTerkontrak(Request $request, $nip, Proyek $proyek)
    {
        try {
            DB::beginTransaction();

            $userAction = $request->get("button-selected");

            $user = User::where("nip", $nip)->where("is_active", true)->first();

            if (!empty($user)) {
                $matriks_user = !$user->check_administrator ? $user->Pegawai->MatriksTerkontrakProyek->where("is_active", true) : MatriksApprovalTerkontrakProyek::where("is_active", true)->get();

                if ($matriks_user->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'status' => 'failed',
                        'message' => "Anda tidak dapat melakukan approval. Silahkan hubungi Admin",
                        'data' => []
                    ], 400);
                }

                $proyekApprovalSelected = ApprovalTerkontrakProyek::where("kode_proyek", $proyek->kode_proyek)->first();

                if (empty($proyekApprovalSelected)) {
                    return response()->json([
                        'success' => false,
                        'status' => 'failed',
                        'message' => "Proyek tidak dapat ditemukan. Silahkan hubungi Admin",
                        'data' => []
                    ], 400);
                }

                $selectPicCrm = Pegawai::where("nip", $proyekApprovalSelected->request_by)->first();

                if ($userAction == "approved") {
                    $proyekApprovalSelected->is_approved = true;
                    $proyekApprovalSelected->approved_by = $user->nip;
                    $proyekApprovalSelected->approved_on = Carbon::now();
                    $proyekApprovalSelected->is_request_approval = false;

                    if ($proyekApprovalSelected->save()) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $selectPicCrm->nip . "&redirectTo=/approval-terkontrak-proyek";
                        $message = "Yth Bapak/Ibu " . $selectPicCrm->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan Approval Proyek CRM Terkontrak untuk proyek " . $proyek->nama_proyek . " telah disetujui.\nSilahkan tekan link di bawah ini untuk melihatnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($selectPicCrm, "Pemberitahuan Approval Proyek CRM Terkontrak", nl2br($message), $this->isNomorTargetActive);
                        if (!$sendEmailUser) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'status' => 'failed',
                                    'message' => "Send Notifikasi Email Gagal. Mohon hubungi Admin.",
                                    'data' => []
                                ],
                                400
                            );
                        }
                        $generateDataNasabahOnline = ApprovalTerkontrakClass::generateNasabahOnline($proyek);

                        if ($proyek->dop != "EA" && env("APP_ENV") == "production" && empty($proyek->proyekBerjalan->customer->kode_bp)) {
                            $sendToNasabahOnline = ApprovalTerkontrakClass::sendDataNasabahOnline($generateDataNasabahOnline);
                        }

                        $proyek->is_need_approval_terkontrak = false;
                        $proyek->save();

                        $sendNotification = new sendNotification();
                        $sendNotification->sendNotificationFirebase($selectPicCrm->nip, "Approval", "Terkontrak", $proyek->kode_proyek, "Persetujuan", "approve");
                    }

                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'status' => 'success',
                        'message' => "Proyek berhasil disetujui",
                        'data' => []
                    ]);
                } else {
                    if (empty($request->get("revisi-nota"))) {
                        return response()->json([
                            'success' => false,
                            'status' => 'failed',
                            'message' => "Catatan Revisi wajib diisi",
                            'data' => []
                        ], 400);
                    }

                    $proyekApprovalSelected->is_revisi = true;
                    $proyekApprovalSelected->revisi_by = $user->nip;
                    $proyekApprovalSelected->revisi_on = Carbon::now();
                    $proyekApprovalSelected->revisi_note = $request->get("revisi-nota");

                    if ($proyekApprovalSelected->save()) {
                        $selectPicCrm = Pegawai::where("nip", $proyekApprovalSelected->request_by)->first();
                        $url = $request->schemeAndHttpHost() . "?nip=" . $selectPicCrm->nip . "&redirectTo=/proyek/view/$proyekApprovalSelected->kode_proyek";
                        $message = "Yth Bapak/Ibu " . $selectPicCrm->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan Revisi Approval Proyek CRM Terkontrak untuk proyek " . $proyek->nama_proyek . ".\nSilahkan tekan link di bawah ini untuk melihatnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($selectPicCrm, "Pemberitahuan Revisi Approval Proyek CRM Terkontrak", nl2br($message), $this->isNomorTargetActive);
                        if (!$sendEmailUser) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'status' => 'failed',
                                    'message' => "Send Notifikasi Email Gagal. Mohon hubungi Admin.",
                                    'data' => []
                                ],
                                400
                            );
                        }
                        $sendNotification = new sendNotification();
                        $sendNotification->sendNotificationFirebase($selectPicCrm->nip, "Approval", "Terkontrak", $proyek->kode_proyek, "Persetujuan", "revisi");
                    }

                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'status' => 'success',
                        'message' => "Proyek berhasil direvisi",
                        'data' => []
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'message' => "User is Not Active",
                    'data' => []
                ], 400);
            }
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

    public function setBackApprovalTerkontrak(Proyek $proyek)
    {
        $selectedProyek = ApprovalTerkontrakProyek::where("kode_proyek", $proyek->kode_proyek)->first();

        $selectedProyek->is_request_approval = true;
        $selectedProyek->is_approved = null;
        $selectedProyek->approved_by = null;
        $selectedProyek->approved_on = null;
        $selectedProyek->is_revisi = null;
        $selectedProyek->revisi_by = null;
        $selectedProyek->revisi_on = null;
        $selectedProyek->revisi_note = null;
        $selectedProyek->save();

        return response()->json("Success");
    }






    //? Owner Selection Controller

    /**
     * List Proyek Owner Selection
     */
    public function listProyekOwnerSelection(Request $request, $nip)
    {
        try {
            $ownerSelectionService = new OwnerSelectionServices($nip);
            $resultOwnerSelection = $ownerSelectionService->listProyek($request);

            // $proyeks_proses_rekomendasi = $resultOwnerSelection["proyeks_proses_rekomendasi"];
            // $proyeks_proses_rekomendasi = $proyeks_proses_rekomendasi->map(function ($proyek) {
            //     $newClass = new stdClass();
            //     $newClass->kode_proyek = $proyek->kode_proyek;
            //     $newClass->nama_proyek = $proyek->Proyek?->nama_proyek;
            //     $newClass->unit_kerja = !empty($proyek->Proyek?->unit_kerja) ? self::getUnitKerjaProyek($proyek->Proyek?->unit_kerja) : null;
            //     $newClass->sumber_dana = $proyek->Proyek?->sumber_dana;
            //     $newClass->nilai_ok = $proyek->Proyek?->nilaiok_awal;
            //     $newClass->tanggal_request = Carbon::parse($proyek->updated_at)->translatedFormat('d/m/Y');
            //     $newClass->stage = self::getStageOwnerSelection($proyek);
            //     return $newClass;
            // });

            // $proyeks_rekomendasi_final = $resultOwnerSelection["proyeks_rekomendasi_final"];
            // $proyeks_rekomendasi_final = $proyeks_rekomendasi_final->map(function ($proyek) {
            //     $newClass = new stdClass();
            //     $newClass->kode_proyek = $proyek->kode_proyek;
            //     $newClass->nama_proyek = $proyek->Proyek?->nama_proyek;
            //     $newClass->unit_kerja = !empty($proyek->Proyek?->unit_kerja) ? self::getUnitKerjaProyek($proyek->Proyek?->unit_kerja) : null;
            //     $newClass->sumber_dana = $proyek->Proyek?->sumber_dana;
            //     $newClass->nilai_ok = $proyek->Proyek?->nilaiok_awal;
            //     $newClass->tanggal_request = Carbon::parse($proyek->updated_at)->translatedFormat('d/m/Y');
            //     $newClass->stage = self::getStageOwnerSelection($proyek);
            //     return $newClass;
            // });

            $proyeks_list = $resultOwnerSelection["proyeks_list"]->map(function ($proyek) {
                $newClass = new stdClass();
                $newClass->kode_proyek = $proyek->kode_proyek;
                $newClass->nama_proyek = $proyek->Proyek?->nama_proyek;
                $newClass->unit_kerja = !empty($proyek->Proyek?->unit_kerja) ? self::getUnitKerjaProyek($proyek->Proyek?->unit_kerja) : null;
                $newClass->sumber_dana = $proyek->Proyek?->sumber_dana;
                $newClass->nilai_ok = "Rp." . number_format($proyek->Proyek?->nilaiok_awal, 0, '.', '.') ?? "-";
                $newClass->tanggal_request = Carbon::parse($proyek->updated_at)->translatedFormat('d/m/Y');
                $newClass->stage = self::getStageOwnerSelection($proyek);
                return $newClass;
            });

            return response()->json([
                "success" => true,
                "message" => null,
                // "data" => ["proyeks_proses_rekomendasi" => $proyeks_proses_rekomendasi->toArray(), "proyeks_rekomendasi_final" => $proyeks_rekomendasi_final->toArray()]
                "data" => ["proyeks_list" => $proyeks_list->toArray()]
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * List Detail Owner Selection
     */
    public function listDetailProyekOwnerSelection($nip, $kode_proyek)
    {
        try {
            $user = User::where("nip", $nip)->first();
            $ownerSelectionService = new OwnerSelectionServices($nip);
            $proyekGet = $ownerSelectionService->getProyek($kode_proyek);

            if (is_string($proyekGet)) {
                return response()->json([
                    "success" => false,
                    "message" => $proyekGet,
                    "data" => null
                ]);
            }

            $proyekSelected = $proyekGet["proyeks"];
            $userAccess = $proyekGet["userAccess"];

            if (!empty($proyekSelected->hasil_assessment)) {
                $hasil_assessment = collect(json_decode($proyekSelected->hasil_assessment));

                $internal_score = 0;
                $eksternal_score = 0;

                if ($hasil_assessment->isNotEmpty()) {
                    $internal_score = $hasil_assessment->sum(function ($ra) {
                        if ($ra->kategori == 'Internal') {
                            return $ra->score;
                        }
                    });
                    $eksternal_score = $hasil_assessment->sum(function ($ra) {
                        if ($ra->kategori == 'Eksternal') {
                            return $ra->score;
                        }
                    });
                }
            } else {
                $internal_score = "Belum melaksanakan Assessment";
                $eksternal_score = "Belum melaksanakan Assessment";
            }

            if ($proyekSelected->KriteriaPenggunaJasaDetail->isNotEmpty() && !$proyekSelected->KriteriaPenggunaJasaDetail->every("nilai", 0)) {
                $nilaiKriteriaPenggunaJasa = $proyekSelected->KriteriaPenggunaJasaDetail
                    ?->filter(function ($score) {
                        return $score->item != null;
                    })
                    ->sum('nilai') ?? null;

                if (!empty($nilaiKriteriaPenggunaJasa)) {
                    $hasilProfileRisiko = PenilaianPenggunaJasa::all()->filter(function ($item) use ($nilaiKriteriaPenggunaJasa) {
                        if ($item->dari_nilai <= $nilaiKriteriaPenggunaJasa && $item->sampai_nilai >= $nilaiKriteriaPenggunaJasa) {
                            return $item;
                        }
                    })->first()->nama ?? 'Belum Ditentukan';
                }
            } else {
                $nilaiKriteriaPenggunaJasa = "Belum Ditentukan";
                $hasilProfileRisiko = "Belum Ditentukan";
            }

            //=========================================================================================================================================//
            //File - file
            //=========================================================================================================================================//

            if (!empty($proyekSelected->Proyek?->DokumenPendukungPasarDini)) {
                $filePendukungPasdin = $proyekSelected->Proyek->DokumenPendukungPasarDini->map(function ($file) {
                    return url("dokumen-pendukung-pasdin") . '/' . $file->id_document;
                });
            } else {
                $filePendukungPasdin = [];
            }

            if (!empty($proyekSelected->Proyek?->proyekBerjalan?->customer?->AHU)) {
                $fileAHU = $proyekSelected->Proyek?->proyekBerjalan?->customer?->AHU->map(function ($file) {
                    return url("customer-file") . '/' . $file->file_document;
                });
            } else {
                $fileAHU = [];
            }

            if (!empty($proyekSelected->Proyek?->proyekBerjalan?->customer?->CompanyProfile)) {
                $fileCompanyProfile = $proyekSelected->Proyek?->proyekBerjalan?->customer?->CompanyProfile->map(function ($file) {
                    return url("customer-file") . '/' . $file->file_document;
                });
            } else {
                $fileCompanyProfile = [];
            }

            if (!empty($proyekSelected->Proyek?->proyekBerjalan?->customer?->LaporanKeuangan)) {
                $fileLaporanKeuangan = $proyekSelected->Proyek?->proyekBerjalan?->customer?->LaporanKeuangan->map(function ($file) {
                    return url("customer-file") . '/' . $file->file_document;
                });
            } else {
                $fileLaporanKeuangan = [];
            }

            if (!empty($proyekSelected->file_pengajuan)) {
                $filePengajuan = url("file-pengajuan") . '/' . $proyekSelected->file_pengajuan;
            } else {
                $filePengajuan = null;
            }

            if (!empty($proyekSelected->file_rekomendasi)) {
                $fileAssessment = url("file-rekomendasi") . '/' . $proyekSelected->file_rekomendasi;
            } else {
                $fileAssessment = null;
            }

            if (!empty($proyekSelected->file_penilaian_risiko)) {
                $filePenilaianRisiko = url("file-profile-risiko") . '/' . $proyekSelected->file_penilaian_risiko;
            } else {
                $filePenilaianRisiko = null;
            }

            //=========================================================================================================================================//


            //=========================================================================================================================================//
            //Is Edit
            //=========================================================================================================================================//
            if (!empty($userAccess)) {
                if ($userAccess->contains('kategori', 'Persetujuan')  && $userAccess->where('kategori', 'Persetujuan')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first() && $proyekSelected->is_recommended) {
                    if ($proyekSelected->is_disetujui || (collect(json_decode($proyekSelected->approved_persetujuan))->contains('user_id', $user->id) && collect(json_decode($proyekSelected->approved_persetujuan))?->first()?->status == 'approved')) {
                        $isEdit = false;
                    } else {
                        $isEdit = true;
                    }
                } elseif ($userAccess->contains('kategori', 'Rekomendasi') && $userAccess->where('kategori', 'Rekomendasi')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first() && $proyekSelected->is_verifikasi_approved) {
                    if ($proyekSelected->is_recommended || (collect(json_decode($proyekSelected->approved_rekomendasi_final))->contains('user_id', $user->id) && collect(json_decode($proyekSelected->approved_rekomendasi_final))?->first()?->status == 'approved')) {
                        $isEdit = false;
                    } else {
                        $isEdit = true;
                    }
                } elseif ($userAccess->contains('kategori', 'Verifikasi') && $userAccess->where('kategori', 'Verifikasi')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first() && $proyekSelected->is_penyusun_approved) {
                    if ($proyekSelected->is_request_rekomendasi || (($userAccess->filter(function ($value) use ($proyekSelected) {
                        return $value->unit_kerja == $proyekSelected->divisi_id &&
                            $value->klasifikasi_proyek == $proyekSelected->klasifikasi_pasdin &&
                            $value->departemen == $proyekSelected->departemen_code &&
                            $value->kategori == "Verifikasi" &&
                            $value->urutan > 1;
                    })->count() > 0 && (collect(json_decode($proyekSelected->approved_verifikasi))->isEmpty())))) {
                        $isEdit = false;
                    } else {
                        if ($proyekSelected->is_verifikasi_approved || (collect(json_decode($proyekSelected->approved_verifikasi))->contains('user_id', $user->id) && collect(json_decode($proyekSelected->approved_verifikasi))?->first()?->status == 'approved')) {
                            $isEdit = false;
                        } else {
                            $isEdit = true;
                        }
                    }
                } elseif ($userAccess->contains('kategori', 'Pengajuan') && $userAccess->where('kategori', 'Pengajuan')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first()) {
                    if (!empty($proyekSelected->approved_rekomendasi)) {
                        $isEdit = false;
                    } else {
                        $isEdit = true;
                    }
                } else {
                    $isEdit = false;
                }
            } else {
                $isEdit = false;
            }
            //=========================================================================================================================================//


            //=========================================================================================================================================//
            //Catatan
            //=========================================================================================================================================//
            $catatanRekomendasi = [];
            $catatanPersetujuan = [];

            if (!empty($proyekSelected->approved_rekomendasi_final)) {
                $catatanRekomendasi = collect(json_decode($proyekSelected->approved_rekomendasi_final))->map(function ($user) {
                    return ["user" => User::find($user->user_id)?->name, "catatan" => $user->catatan ?? "-"];
                });
            }

            if (!empty($proyekSelected->approved_persetujuan)) {
                $catatanPersetujuan = collect(json_decode($proyekSelected->approved_persetujuan))->map(function ($user) {
                    return ["user" => User::find($user->user_id)?->name, "catatan" => $user->catatan ?? "-"];
                });
            }

            $notaRekomendasiNewClass = collect([]);
            $notaRekomendasiNewClass->push([
                "nama_proyek" => $proyekSelected->Proyek->nama_proyek,
                "kode_proyek" => $proyekSelected->Proyek->kode_proyek,
                "lokasi_proyek" => $proyekSelected->Proyek->Provinsi->province_name ?? "-",
                "nama_instansi" => $proyekSelected->Proyek?->proyekBerjalan?->name_customer ?? "-",
                "jenis_instansi" => $proyekSelected->Proyek?->proyekBerjalan?->Customer->jenis_instansi ?? "-",
                "sumber_dana" => $proyekSelected->Proyek?->sumber_dana ?? "-",
                "klasifikasi_proyek" => $proyekSelected->Proyek?->klasifikasi_pasdin ?? "-",
                "nilai_ok" => "Rp." . number_format($proyekSelected->Proyek?->nilaiok_awal, 0, '.', '.') ?? "-",
                "assessment_internal" => $internal_score,
                "assessment_eksternal" => $eksternal_score,
                "hasil_profile_risiko" => $hasilProfileRisiko,
                "nilai_profile_risiko" => $nilaiKriteriaPenggunaJasa,
                "catatan_assessment" => $proyekSelected->catatan_nota_rekomendasi,
                "files_owner_selection" => [
                    "file_pendukung_pasdin" => $filePendukungPasdin,
                    "file_ahu" => $fileAHU,
                    "file_company_profile" => $fileCompanyProfile,
                    "file_laporan_keuangan" => $fileLaporanKeuangan,
                    "file_form_pengajuan_rekomendasi" => $filePengajuan,
                    "file_hasil_assessment" => $fileAssessment,
                    "file_profile_risiko" => $filePenilaianRisiko,
                ],
                "catatan_nota_rekomendasi" => [
                    "catatan_perekomendasi" => $catatanRekomendasi,
                    "catatan_persetujuan" => $catatanPersetujuan
                ],
                "stage" => self::getStageOwnerSelection($proyekSelected),
                "is_edit" => $isEdit
            ]);

            return response()->json([
                "success" => true,
                "message" => null,
                "data" => $notaRekomendasiNewClass->toArray()
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Pengajuan
     */
    public function setApprovePengajuan(Request $request, $nip, $kode_proyek)
    {
        try {
            $ownerSelectionService = new OwnerSelectionServices($nip);
            $prosesApproval = $ownerSelectionService->approvalPengajuan($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Verifikasi
     */
    public function setApproveVerifikasi(Request $request, $nip, $kode_proyek)
    {
        try {
            $ownerSelectionService = new OwnerSelectionServices($nip);
            $prosesApproval = $ownerSelectionService->approvalVerifikasi($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Rekomendasi
     */
    public function setApproveRekomendasi(Request $request, $nip, $kode_proyek)
    {
        try {
            $ownerSelectionService = new OwnerSelectionServices($nip);
            $prosesApproval = $ownerSelectionService->approvalRekomendasi($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Persetujuan
     */
    public function setApprovePersetujuan(Request $request, $nip, $kode_proyek)
    {
        try {
            $ownerSelectionService = new OwnerSelectionServices($nip);
            $prosesApproval = $ownerSelectionService->approvalPersetujuan($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }



    //? Project Selection Controller

    /**
     * List Proyek Project Selection
     */
    public function listProyekProjectSelection(Request $request, $nip)
    {
        try {
            $projectSelectionService = new ProjectSelectionService($nip);
            $resultProjectSelection = $projectSelectionService->listProyek($request);

            $proyeks_list = $resultProjectSelection["proyeks_list"]->map(function ($proyek) {
                $newClass = new stdClass();
                $newClass->kode_proyek = $proyek->kode_proyek;
                $newClass->nama_proyek = $proyek->Proyek?->nama_proyek;
                $newClass->unit_kerja = !empty($proyek->Proyek?->unit_kerja) ? self::getUnitKerjaProyek($proyek->Proyek?->unit_kerja) : null;
                $newClass->sumber_dana = $proyek->Proyek?->sumber_dana;
                $newClass->nilai_ok = "Rp." . number_format($proyek->Proyek?->nilaiok_awal, 0, '.', '.') ?? "-";
                $newClass->tanggal_request = Carbon::parse($proyek->updated_at)->translatedFormat('d/m/Y');
                $newClass->stage = self::getStageProjectSelection($proyek);
                return $newClass;
            });

            return response()->json([
                "success" => true,
                "message" => null,
                "data" => ["proyeks_list" => $proyeks_list->toArray()]
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * List Detail Project Selection
     */
    public function listDetailProyekProjectSelection($nip, $kode_proyek)
    {
        try {
            $user = User::where("nip", $nip)->first();
            $ownerSelectionService = new ProjectSelectionService($nip);
            $proyekGet = $ownerSelectionService->getProyek($kode_proyek);

            if (is_string($proyekGet)) {
                return response()->json([
                    "success" => false,
                    "message" => $proyekGet,
                    "data" => null
                ]);
            }

            $proyekSelected = $proyekGet["proyeks"];
            $userAccess = $proyekGet["userAccess"];

            // File-file
            if (!empty($proyekSelected->file_pengajuan)) {
                $filePengajuan = url("file-nota-rekomendasi-2/file-pengajuan") . '/' . $proyekSelected->file_pengajuan;
            } else {
                $filePengajuan = null;
            }

            if (!empty($proyekSelected->file_kelengkapan_merge)) {
                $fileKelengkapan = url("file-nota-rekomendasi-2/file-kelengkapan-project") . '/' . $proyekSelected->file_kelengkapan_merge;
            } else {
                $fileKelengkapan = null;
            }

            if (!empty($proyekSelected->file_assessment_merge)) {
                $fileAssessment = url("file-nota-rekomendasi-2/file-kriteria-project-selection") . '/' . $proyekSelected->file_assessment_merge;
            } else {
                $fileAssessment = null;
            }

            //Catatan Proses
            $catatanRekomendasi = [];
            $catatanPersetujuan = [];

            if (!empty($proyekSelected->approved_rekomendasi)) {
                $catatanRekomendasi = collect(json_decode($proyekSelected->approved_rekomendasi))->map(function ($user) {
                    return ["user" => User::find($user->user_id)?->name, "catatan" => $user->catatan ?? "-"];
                });
            }

            if (!empty($proyekSelected->approved_persetujuan)) {
                $catatanPersetujuan = collect(json_decode($proyekSelected->approved_persetujuan))->map(function ($user) {
                    return ["user" => User::find($user->user_id)?->name, "catatan" => $user->catatan ?? "-"];
                });
            }


            //=========================================================================================================================================//
            //Is Edit
            //=========================================================================================================================================//
            if (!empty($userAccess)) {
                if ($userAccess->contains('kategori', 'Persetujuan')  && $userAccess->where('kategori', 'Persetujuan')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first() && $proyekSelected->is_recommended) {
                    if ($proyekSelected->is_disetujui || (collect(json_decode($proyekSelected->approved_persetujuan))->contains('user_id', $user->id) && collect(json_decode($proyekSelected->approved_persetujuan))?->first()?->status == 'approved')) {
                        $isEdit = false;
                    } else {
                        $isEdit = true;
                    }
                } elseif ($userAccess->contains('kategori', 'Rekomendasi') && $userAccess->where('kategori', 'Rekomendasi')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first() && $proyekSelected->is_verifikasi_approved) {
                    if ($proyekSelected->is_rekomendasi_approved || (collect(json_decode($proyekSelected->approved_rekomendasi))->contains('user_id', $user->id) && collect(json_decode($proyekSelected->approved_rekomendasi))?->first()?->status == 'approved')) {
                        $isEdit = false;
                    } else {
                        $isEdit = true;
                    }
                } elseif ($userAccess->contains('kategori', 'Verifikasi') && $userAccess->where('kategori', 'Verifikasi')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first() && $proyekSelected->is_penyusun_approved) {
                    if ($proyekSelected->is_request_rekomendasi || (($userAccess->filter(function ($value) use ($proyekSelected) {
                        return $value->unit_kerja == $proyekSelected->divisi_id &&
                            $value->klasifikasi_proyek == $proyekSelected->klasifikasi_pasdin &&
                            $value->departemen == $proyekSelected->departemen_code &&
                            $value->kategori == "Verifikasi" &&
                            $value->urutan > 1;
                    })->count() > 0 && (collect(json_decode($proyekSelected->approved_verifikasi))->isEmpty())))) {
                        $isEdit = false;
                    } else {
                        if ($proyekSelected->is_verifikasi_approved || (collect(json_decode($proyekSelected->approved_verifikasi))->contains('user_id', $user->id) && collect(json_decode($proyekSelected->approved_verifikasi))?->first()?->status == 'approved')) {
                            $isEdit = false;
                        } else {
                            $isEdit = true;
                        }
                    }
                } elseif ($userAccess->contains('kategori', 'Pengajuan') && $userAccess->where('kategori', 'Pengajuan')?->where('departemen', $proyekSelected->departemen_code)?->where('unit_kerja', $proyekSelected->divisi_id)?->where("klasifikasi_proyek", $proyekSelected->klasifikasi_pasdin)?->first()) {
                    if (!empty($nota_rekomendasi->approved_pengajuan)) {
                        $isEdit = false;
                    } else {
                        $isEdit = true;
                    }
                } else {
                    $isEdit = false;
                }
            } else {
                $isEdit = false;
            }

            $notaRekomendasiNewClass = collect([]);
            $notaRekomendasiNewClass->push([
                "nama_proyek" => $proyekSelected->Proyek->nama_proyek,
                "kode_proyek" => $proyekSelected->Proyek->kode_proyek,
                "lokasi_proyek" => $proyekSelected->Proyek->Provinsi->province_name ?? "-",
                "nama_instansi" => $proyekSelected->Proyek?->proyekBerjalan?->name_customer ?? "-",
                "jenis_instansi" => $proyekSelected->Proyek?->proyekBerjalan?->Customer->jenis_instansi ?? "-",
                "sumber_dana" => $proyekSelected->Proyek?->sumber_dana ?? "-",
                "klasifikasi_proyek" => $proyekSelected->Proyek?->klasifikasi_pasdin ?? "-",
                "nilai_ok" => "Rp." . number_format($proyekSelected->Proyek?->nilaiok_awal, 0, '.', '.') ?? "-",
                "catatan_assessment" => $proyekSelected->catatan_nota_rekomendasi,
                "files_owner_selection" => [
                    "file_pengajuan" => $filePengajuan,
                    "file_kelengkapan" => $fileKelengkapan,
                    "file_profile_risiko" => $fileAssessment,
                ],
                "catatan_nota_rekomendasi" => [
                    "catatan_perekomendasi" => $catatanRekomendasi,
                    "catatan_persetujuan" => $catatanPersetujuan
                ],
                "stage" => self::getStageProjectSelection($proyekSelected),
                "is_edit" => $isEdit
            ]);

            return response()->json([
                "success" => true,
                "message" => null,
                "data" => $notaRekomendasiNewClass->toArray()
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Pengajuan
     */
    public function setApprovePengajuanProjectSelection(Request $request, $nip, $kode_proyek)
    {
        try {
            $projectSelectionService = new ProjectSelectionService($nip);
            $prosesApproval = $projectSelectionService->approvalPengajuan($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Verifikasi
     */
    public function setApproveVerifikasiProjectSelection(Request $request, $nip, $kode_proyek)
    {
        try {
            $projectSelectionService = new ProjectSelectionService($nip);
            $prosesApproval = $projectSelectionService->approvalVerifikasi($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Rekomendasi
     */
    public function setApproveRekomendasiProjectSelection(Request $request, $nip, $kode_proyek)
    {
        try {
            $projectSelectionService = new ProjectSelectionService($nip);
            $prosesApproval = $projectSelectionService->approvalRekomendasi($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }

    /**
     * Proses Approval Persetujuan
     */
    public function setApprovePersetujuanProjectSelection(Request $request, $nip, $kode_proyek)
    {
        try {
            $projectSelectionService = new ProjectSelectionService($nip);
            $prosesApproval = $projectSelectionService->approvalPersetujuan($request, $kode_proyek);

            if ($prosesApproval[0]) {
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            } else {
                Log::error($prosesApproval[1]);
                return response()->json([
                    "success" => true,
                    "message" => $prosesApproval[1],
                    "data" => null
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
        }
    }



    //? Private Controller

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

    private function getStageOwnerSelection($notaRekomendasi)
    {
        if (empty($notaRekomendasi)) {
            return null;
        }

        if ($notaRekomendasi->is_request_rekomendasi && !$notaRekomendasi->review_assessment) {
            $stage = "Proses Pengajuan";
        } elseif ($notaRekomendasi->review_assessment == true && (is_null($notaRekomendasi->is_draft_recommend_note) || $notaRekomendasi->is_draft_recommend_note)) {
            $stage = "Proses Penyusunan";
        } elseif (!is_null($notaRekomendasi->is_penyusun_approved) && $notaRekomendasi->is_penyusun_approved && is_null($notaRekomendasi->is_verifikasi_approved)) {
            $stage = "Proses Verifikasi";
        } elseif ($notaRekomendasi->is_verifikasi_approved == true && is_null($notaRekomendasi->is_recommended)) {
            $stage = "Proses Rekomendasi";
        } elseif ($notaRekomendasi->is_recommended == true && is_null($notaRekomendasi->is_disetujui)) {
            $stage = "Proses Penyetujuan";
        } elseif (!is_null($notaRekomendasi->is_disetujui) && $notaRekomendasi->is_disetujui == false) {
            $stage = "Ditolak";
        } elseif ($notaRekomendasi->is_disetujui) {
            $stage = "Disetujui";
        } else {
            $stage = "Error";
        }

        return $stage;
    }

    private function getStageProjectSelection($notaRekomendasi)
    {
        if (empty($notaRekomendasi)) {
            return null;
        }

        if ($notaRekomendasi->is_request_rekomendasi && !$notaRekomendasi->is_pengajuan_approved) {
            $stage = "Proses Pengajuan";
        } elseif ($notaRekomendasi->is_pengajuan_approved == true && is_null($notaRekomendasi->tanggal_paparan_disetujui)) {
            $stage = "Proses Paparan";
        } elseif ($notaRekomendasi->is_pengajuan_approved == true && $notaRekomendasi->tanggal_paparan_disetujui == true && (is_null($notaRekomendasi->is_draft_recommend_note) || $notaRekomendasi->is_draft_recommend_note)) {
            $stage = "Proses Penyusunan";
        } elseif (!is_null($notaRekomendasi->is_penyusun_approved) && $notaRekomendasi->is_penyusun_approved && is_null($notaRekomendasi->is_verifikasi_approved)) {
            $stage = "Proses Verifikasi";
        } elseif ($notaRekomendasi->is_verifikasi_approved == true && is_null($notaRekomendasi->is_recommended)) {
            $stage = "Proses Rekomendasi";
        } elseif ($notaRekomendasi->is_recommended == true && is_null($notaRekomendasi->is_disetujui)) {
            $stage = "Proses Penyetujuan";
        } elseif (!is_null($notaRekomendasi->is_disetujui) && $notaRekomendasi->is_disetujui == false) {
            $stage = "Ditolak";
        } elseif ($notaRekomendasi->is_disetujui) {
            $stage = "Disetujui";
        } else {
            $stage = "Error";
        }

        return $stage;
    }
}
