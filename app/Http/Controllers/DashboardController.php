<?php

namespace App\Http\Controllers;

use App\Models\ClaimManagements;
use App\Models\ContractManagements;
use App\Models\Dop;
use App\Models\Forecast;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {

        // Begin :: Copy Data Forecast If current month not exists
        self::copyDataForecast();
        // End :: Copy Data Forecast If current month not exists
        
        // begin :: Delete Old Excel Files
        $files = collect(File::allFiles(public_path("excel")));
        $files->each(function($file) {
            $now = Carbon::now();
            $file_date = Carbon::createFromTimestamp($file->getMTime());
            $diff_date = $file_date->diffInDays($now, true);
            if($diff_date > 1) File::delete($file);
        });
        // end :: Delete Old Excel Files
        
        //begin::History Forecast
        if ($request->get("periode-prognosa") || $request->get("tahun-history")) {
            $year = (int) $request->get("tahun-history") ?? (int) date("Y");
            $month = $request->get("periode-prognosa") ?? "";
            $unit_kerja_get = $request->get("unit-kerja") ?? "";
            $dop_get = $request->get("dop") ?? "";
        } else {
            $year = "";
            $month = (int) date("m");
            $unit_kerja_get = "";
            $dop_get = "";
            // $nilaiHistoryForecast = HistoryForecast::all();
        }
        // dd($unit_kerja_get);
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (Auth::user()->check_administrator) {
            // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : (int) date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
            $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.is_cancel", "!=" , true)->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : (int) date("m"))->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // dd($nilaiHistoryForecast, $request->get("periode-prognosa"), (int) date("m"));
            $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->get();
            $unitKerja = UnitKerja::orderBy('unit_kerja')->get()->whereNotIn("divcode", ["B", "C", "D", "8"]);
            // dd($unitKerja);
            $proyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->get();
            $paretoProyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->orderByDesc('nilai_perolehan')->get();
            $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->get();
            $dops = Dop::orderBy('dop')->get();
            // $dopJoin = Dop::join("proyeks", "dops.dop", "=", "proyeks.dop")->get();
            // dd($dops);
            if (!empty($request->get("unit-kerja"))) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $request->get("unit-kerja"));
                $claims = $claims->where("unit_kerja", $request->get("unit-kerja"));
                $proyeks = $proyeks->where("unit_kerja", $request->get("unit-kerja"));
                $contracts = $contracts->where("unit_kerja", $request->get("unit-kerja"));
                // dd($nilaiHistoryForecast);
            }
            if (!empty($request->get("dop"))) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("dop", $request->get("dop"));
                $claims = $claims->where("dop", $request->get("dop"));
                $proyeks = $proyeks->where("dop", $request->get("dop"));
                $contracts = $contracts->where("dop", $request->get("dop"));
                // dd($proyeks);
                // dd($nilaiHistoryForecast, $claims, $proyeks, $contracts);
            }
            // dd($unitKerja, Auth::user());
        } else {
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->get();
                $proyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->get();
                $paretoProyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->orderByDesc('nilai_perolehan')->paginate(25);
                $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->get();
                $unitKerja = UnitKerja::get()->whereIn("divcode", $unit_kerja_user->toArray());
                // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.is_cancel", "!=" , true)->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
                // dd($nilaiHistoryForecast, Auth::user());
                if (!empty($request->get("unit-kerja"))) {
                    // dd($request);
                    // dd($nilaiHistoryForecast);
                    $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $request->get("unit-kerja"));
                    $claims = $claims->where("unit_kerja", $request->get("unit-kerja"));
                    $proyeks = $proyeks->where("unit_kerja", $request->get("unit-kerja"));
                    $contracts = $contracts->where("unit_kerja", $request->get("unit-kerja"));
                } else if (!empty($request->get("dop"))) {
                    $nilaiHistoryForecast = $nilaiHistoryForecast->where("dop", $request->get("dop"));
                    $claims = $claims->where("dop", $request->get("dop"));
                    $proyeks = $proyeks->where("dop", $request->get("dop"));
                    $contracts = $contracts->where("dop", $request->get("dop"));
                    // dd($proyeks);
                    // dd($nilaiHistoryForecast, $claims, $proyeks, $contracts);
                } else {
                    $nilaiHistoryForecast = $nilaiHistoryForecast->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    $claims = $claims->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    $proyeks = $proyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    $contracts = $contracts->whereIn("unit_kerja", $unit_kerja_user->toArray());
                }
            } else {
                $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
                $proyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
                $paretoProyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->orderByDesc('nilai_perolehan')->paginate(25);
                $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
                $unitKerja = UnitKerja::where("divcode", "=", Auth::user()->unit_kerja)->get();
                // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
                $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.is_cancel", "!=" , true)->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->get();
                // dd($nilaiHistoryForecast, Auth::user());
            }
            $unit_kerjas = "";
            $dops = Dop::orderBy('dop')->get();
        }

        // dd($nilaiHistoryForecast);
        $nilaiForecast = 0;
        $nilaiForecastArray = [];
        $historyForecast = $nilaiHistoryForecast->sortBy("month_forecast");
        // dd($historyForecast);

        $nilaiRkapForecast = 0;
        $nilaiRkapArray = [];
        $historyRkap = $nilaiHistoryForecast->sortBy("month_rkap");
        // dd($historyRkap);

        $nilaiRealisasiForecast = 0;
        $nilaiRealisasiArray = [];
        $historyRealisasi = $nilaiHistoryForecast->where("stage", ">" , 7)->sortBy("month_realisasi");
        // dd($historyRealisasi);

        $per = 1000000; //Dibagi Dalam Jutaan


        for ($i = 1; $i <= 12; $i++) {
            foreach ($historyForecast as $forecast) {
                if ($forecast->month_forecast == $i) {
                    $nilaiForecast += $forecast->nilai_forecast / $per;
                } else {
                    $nilaiForecast == 0;
                }
            }
            // dd();
            array_push($nilaiForecastArray, round($nilaiForecast));

            foreach ($historyRkap as $rkap) {
                if ($rkap->month_rkap == $i) {
                    $nilaiRkapForecast += (int) $rkap->rkap_forecast / $per;
                } else {
                    // dump($rkap->month_rkap, $rkap->rkap_forecast);
                    $nilaiRkapForecast == 0;
                }
            }
            array_push($nilaiRkapArray, round($nilaiRkapForecast));

            foreach ($historyRealisasi as $realisasi) {
                if ($realisasi->month_realisasi == $i) {
                    // dump($realisasi->realisasi_forecast);
                    $nilaiRealisasiForecast += (int) $realisasi->realisasi_forecast / $per;
                } else {
                    $nilaiRealisasiForecast == 0;
                }
            }
            array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast));
        }
        // dump($nilaiRkapArray);
        // dump($nilaiRealisasiArray);


        // begin :: Tri Wulan
        $nilaiForecastTriwulan = 0;
        $nilaiForecastTriwunalArray = [];

        $offset_history = 0;
        for ($i = 3; $i <= 12; $i += 3) {
            $filtered_history_forecast = $historyForecast->filter(function ($data) use ($i, $offset_history) {
                return  $data->month_forecast > $offset_history && $data->month_forecast <= $i;
            });
            $nilaiForecastTriwulan += $filtered_history_forecast->sum("nilai_forecast");
            // dump($filtered_history_forecast->all());
            array_push($nilaiForecastTriwunalArray, $nilaiForecastTriwulan);
            $offset_history = $i;
        }
        // end :: Tri Wulan

        // Begin :: Nilai Realisasi Unit Kerja
        $kategoriunitKerja = [];
        $nilaiOkKumulatif = [];
        $nilaiRealisasiKumulatif = [];
        if (!empty($request->get("unit-kerja"))) {
            $unitKerja_nilai_OK = $unitKerja->where("divcode", $request->get("unit-kerja"))->first();
            $nilaiOk = 0;
            $nilaiRealisasi = 0;
            array_push($kategoriunitKerja, $unitKerja_nilai_OK->unit_kerja);
            // dump($kategoriunitKerja);
            foreach ($unitKerja_nilai_OK->proyeks as $proyekUnit) {
                foreach ($proyekUnit->Forecasts as $f) {
                    $nilaiOk += (int) str_replace(",", "", ($f->rkap_forecast));
                    $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                }
            }
            array_push($nilaiOkKumulatif, round($nilaiOk));
            array_push($nilaiRealisasiKumulatif, round($nilaiRealisasi));
        } else if (!empty($request->get("dop"))) {
            $unitKerja_nilai_OK = $proyeks->where("dop", $request->get("dop"))->groupBy("unit_kerja");
            // dd($unitKerja_nilai_OK);
            foreach ($unitKerja_nilai_OK as $key => $proyekUnit) {
                $divcode = UnitKerja::where("divcode", "=", $key)->get()->first();
                array_push($kategoriunitKerja, $divcode->unit_kerja);
                // dd($kategoriunitKerja);
                $nilaiOk = 0;
                $nilaiRealisasi = 0;
                foreach ($proyekUnit as $proyekDOP) {
                    // dump($nilai);
                    foreach ($proyekDOP->Forecasts as $f) {
                        $nilaiOk += (int) str_replace(",", "", ($f->rkap_forecast));
                        $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                    }
                    // $nilaiOk += (int) str_replace(",", "", ($nilai->nilai_rkap / $per));
                    // $nilaiRealisasi += (int) str_replace(",", "", ($nilai->nilai_perolehan / $per));
                }
                array_push($nilaiOkKumulatif, round($nilaiOk));
                array_push($nilaiRealisasiKumulatif, round($nilaiRealisasi));
            }
            // dd($kategoriunitKerja, $nilaiOkKumulatif, $nilaiRealisasiKumulatif);
            // dd();
            // dump($kategoriunitKerja);
        } else {
            // dd($unitKerja);
            foreach ($unitKerja as $unit) {
                // dump($unit->proyeks);
                array_push($kategoriunitKerja, $unit->unit_kerja);
                $nilaiOk = 0;
                $nilaiRealisasi = 0;
                foreach ($unit->proyeks as $proyekUnit) {
                    foreach ($proyekUnit->Forecasts as $f) {
                        $nilaiOk += (int) str_replace(",", "", ($f->rkap_forecast));
                        $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                    }
                }
                array_push($nilaiOkKumulatif, round($nilaiOk));
                array_push($nilaiRealisasiKumulatif, round($nilaiRealisasi));
            }
        }
        // dd($nilaiOkKumulatif);

        // End :: Nilai Realisasi Unit Kerja

        // $proyeks_test = Proyek::all()->whereIn("unit_kerja", ["O", "U"])->whereIn("stage", [1, 2, 4, 5])->count();

        // Begin :: CHART PROYEK KALAH - CANCEL - TIDAK LULUS PQ
        $proyek_kalah_cancel_tidak_lulus_pq = collect();
        $proyek_kalah_cancel_tidak_lulus_pq->push($proyeks->where("stage", 7)->count()); // Kalah
        $proyek_kalah_cancel_tidak_lulus_pq->push($proyeks->where("stage", 0)->count()); // Tidak Lulus PQ
        $proyek_kalah_cancel_tidak_lulus_pq->push($proyeks->where("is_cancel", true)->count()); // Cancel
        // End :: CHART PROYEK KALAH - CANCEL - TIDAK LULUS PQ

        //begin:: Monitoring Proyek
        $proses = 0;
        $menang = 0;
        $kalah = 0;
        $prakualifikasi = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 1 || $stg == 2) {
                $proses++;
            } else if ($stg == 3) {
                $prakualifikasi++;
            } else if ($stg == 4 || $stg == 5) {
                $proses++;
            } else if ($stg == 6 || $stg == 8) {
                $menang++;
            } else if ($stg == 7 || $proyek->is_cancel) {
                $kalah++;
            } else {
                $menang++;
            };
        };
        //end:: Monitoring Proyek

        //Begin::Terendah Terkontrak
        $nilaiTerkontrak = 0;
        $nilaiTerendah = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 8) {
                $nilaiTerkontrak += (int) str_replace(",", "", $proyek->nilai_perolehan);
            } else if ($stg == 6 || ($stg == 5 && $proyek->peringkat_wika == "Peringkat 1")) {
                $nilaiTerendah += (int) str_replace(",", "", $proyek->nilai_perolehan);
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
            if ($stg == 6 || $stg == 8) {
                $jumlahMenang++;
                $nilaiMenang += (int) str_replace(".", "", $proyek->nilai_perolehan);
            } else if ($stg == 7) {
                $jumlahKalah++;
                $nilaiKalah += (int) str_replace(".", "", $proyek->nilai_perolehan);
            };
            // dump($nilaiTerendah, $nilaiTerkontrak);
        };
        //End::Competitive Index

        //begin::Marketing PipeLine
        $prosesTender = 0;
        $terkontrak = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg < 5) {
                $prosesTender++;
            } else if ($stg == 7) {
                continue;
            } else {
                if (empty($proyek->ContractManagements)) {
                    $terkontrak++;
                }
            };
        };
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

        // Begin :: menghitung total dari status dan jenis claim
        $claim_status_array = [];
        $claim_cancel = $claims->where("stages", "=", "5")->where("jenis_claim", "=", "Claim")->count();
        $claim_disetujui = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Claim")->count();
        $claim_ditolak = $claims->where("stages", "=", "6")->where("jenis_claim", "=", "Claim")->count();
        $claim_on_progress = $claims->where("stages", "<=", "3")->where("jenis_claim", "=", "Claim")->count();
        array_push($claim_status_array, $claim_cancel, $claim_disetujui, $claim_ditolak, $claim_on_progress);
        // End :: menghitung total dari status dan jenis claim

        // Begin :: menghitung total dari status dan jenis anti claim
        $anti_claim_status_array = [];
        $anti_claim_cancel = $claims->where("stages", "=", "5")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_disetujui = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_ditolak = $claims->where("stages", "=", "6")->where("jenis_claim", "=", "Anti Claim")->count();
        $anti_claim_on_progress = $claims->where("stages", "<=", "3")->where("jenis_claim", "=", "Anti Claim")->count();
        array_push($anti_claim_status_array, $anti_claim_cancel, $anti_claim_disetujui, $anti_claim_ditolak, $anti_claim_on_progress);
        // End :: menghitung total dari status dan jenis anti claim

        // Begin :: menghitung total dari status dan jenis claim asuransi
        $claim_asuransi_status_array = [];
        $claim_asuransi_cancel = $claims->where("stages", "=", "5")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_disetujui = $claims->where("stages", "=", "4")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_ditolak = $claims->where("stages", "=", "6")->where("jenis_claim", "=", "Claim Asuransi")->count();
        $claim_asuransi_on_progress = $claims->where("stages", "<=", "3")->where("jenis_claim", "=", "Claim Asuransi")->count();
        array_push($claim_asuransi_status_array, $claim_asuransi_cancel, $claim_asuransi_disetujui, $claim_asuransi_ditolak, $claim_asuransi_on_progress);
        // End :: menghitung total dari status dan jenis claim asuransi

        //begin::Pareto
        // $paretoProyek = $proyeks->sortByDesc('forecast');
        $paretoProyek = $paretoProyeks->sortByDesc('nilai_perolehan');
        $paretoClaim = $claims->where("jenis_claim", "=", "Claim")->groupBy("kode_proyek");
        $paretoAntiClaim = $claims->where("jenis_claim", "=", "Anti Claim")->groupBy("kode_proyek");
        $paretoAsuransi = $claims->where("jenis_claim", "=", "Claim Asuransi")->groupBy("kode_proyek");

        // $paretoClaim = ClaimManagements::sortable()->join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("jenis_claim", "=", "Claim")->get()->groupBy("kode_proyek");
        // $paretoClaim = ClaimManagements::sortable()->get();
        // $paretoAntiClaim = ClaimManagements::sortable()->where("jenis_claim", "=", "Anti Claim")->get()->groupBy("kode_proyek");
        // $paretoAsuransi = ClaimManagements::sortable()->where("jenis_claim", "=", "Claim Asuransi")->get()->groupBy("kode_proyek");
        //end::Pareto




        // dd($top_proyeks_close_this_month);

        //begin:: Marketing Pipeline
        $pasarDini = 0;
        $pasarPotensial = 0;
        $stagePrakualifikasi = 0;
        $stageTender = 0;
        $stagePerolehan = 0;
        $stageMenang = 0;
        $stageKalah = 0;
        $stageTerkontrak = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 1) {
                $pasarDini++;
            } else if ($stg == 2) {
                $pasarPotensial++;
            } else if ($stg == 3) {
                $stagePrakualifikasi++;
            } else if ($stg == 4) {
                $stageTender++;
            } else if ($stg == 5) {
                $stagePerolehan++;
            } else if ($stg == 6) {
                $stageMenang++;
            } else if ($stg == 7) {
                $stageKalah++;
            } else if ($stg == 8) {
                $stageTerkontrak++;
            } else {
                // 
            };
        };
        //end:: Marketing Pipeline
        // Begin :: Table Proyek Teratas yang akan tutup bulan ini
        $top_proyeks_close_this_month = $proyeks->where("bulan_ri_perolehan", "=", (int) date("m") - 2)->where("tahun_ri_perolehan", "=", (int) date("Y"))->where("stage", "=", 8)->sortByDesc("nilai_perolehan")->values();
        // End :: Table Proyek Teratas yang akan tutup bulan ini

        // Begin :: SUMBER DANA RKAP
        $totalRKAPSumberDana = collect();
        $proyeksGroupBySumberDana = $proyeks->where("sumber_dana", "!=", "")->sortBy("sumber_dana")->groupBy("sumber_dana");
        foreach ($proyeksGroupBySumberDana as $sumber_dana => $proyeks_sumber_dana) {
            $total_rkap = 0;
            foreach ($proyeks_sumber_dana as $proyek) {
                $total_rkap += (int) $proyek->nilai_rkap / $per;
            }
            $totalRKAPSumberDana->push([
                "name" => $sumber_dana . ": " . number_format($total_rkap, 0, ".", "."),
                "y" => $total_rkap,
                "x" => $sumber_dana . ": " . number_format($total_rkap, 0, ".", "."),
            ]);
        }
        // End :: SUMBER DANA RKAP

        // Begin :: SUMBER DANA REALISASI
        $totalRealisasiSumberDana = collect();
        foreach ($proyeksGroupBySumberDana as $sumber_dana => $proyeks_sumber_dana) {
            $total_realisasi = 0;
            foreach ($proyeks_sumber_dana as $proyek) {
                $total_realisasi += (int) $proyek->nilai_perolehan / $per;
            }
            $totalRealisasiSumberDana->push([
                "name" => $sumber_dana . ": " . number_format($total_realisasi, 0, ".", "."),
                "y" => $total_realisasi,
                "x" => $sumber_dana . ": " . number_format($total_realisasi, 0, ".", "."),
            ]);
        }
        // End :: SUMBER DANA REALISASI

        return view('1_Dashboard', compact(["pasarDini", "pasarPotensial", "stagePrakualifikasi", "stageTender", "stagePerolehan", "stageMenang", "stageKalah", "stageTerkontrak", "top_proyeks_close_this_month", "proyek_kalah_cancel_tidak_lulus_pq", "totalRealisasiSumberDana", "totalRKAPSumberDana", "claim_status_array", "anti_claim_status_array", "claim_asuransi_status_array", "nilaiForecastArray", "nilaiRkapArray", "nilaiRealisasiArray", "nilaiForecastTriwunalArray", "year", "month", "proses", "menang", "kalah", "prakualifikasi", "prosesTender", "terkontrak", "pelaksanaan", "serahTerima", "closing", "proyeks", "paretoProyek", "paretoClaim", "paretoAntiClaim", "paretoAsuransi", "kategoriunitKerja", "nilaiOkKumulatif", "nilaiRealisasiKumulatif", "nilaiTerkontrak", "nilaiTerendah", "jumlahMenang", "jumlahKalah", "nilaiMenang", "nilaiKalah", "unitKerja", "unit_kerja_get", "dop_get", "dops"]));
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
    public function getDataFilterPoint($prognosa, $type, $month, $unit_kerja = "")
    {
        $arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $data = [];
        $counter = 2; // buat excel cell

        // Delete existing file if data date is greater than 1 minute
        $files = File::allFiles(public_path("excel"));
        foreach ($files as $file) {
            $file = File::lastModified($file);
            $file_modified = date_create(strtotime($file));
            $now = date_create("now");
            if ($now->diff($file_modified)->i > 1) {
                File::delete(public_path("excel/$file"));
            }
        }



        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai $type");


        // dd($request->all());   
        // dd($type, $prognosa, $month, $unit_`kerja);   
        if ($type == "Forecast") {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator) {
                $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->sortBy("month_forecast", SORT_NUMERIC);
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_forecasts = $history_forecasts->where("divcode", $unit_kerja);
                    // dd($history_forecasts);
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    $history_forecasts = $history_forecasts->where("dop", $dop);
                    // dd($dop, $history_forecasts);
                }
                $history_forecasts = $history_forecasts->groupBy("kode_proyek");
            } else {
                if (!empty($unit_kerja)) {
                    $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->sortBy("month_forecast", SORT_NUMERIC);
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                    // dd($request->all());
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_forecast", SORT_NUMERIC);
                    } else {
                        $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->sortBy("month_forecast", SORT_NUMERIC);
                    }
                }
                $history_forecasts = $history_forecasts->groupBy("kode_proyek");
                // dd($history_forecasts);

            }
            foreach ($history_forecasts as $kode_proyek => $filter) {
                foreach ($filter as $key => $f) {
                    if ($f->month_forecast <= $month) {
                        if (!array_key_exists($f->kode_proyek, $data)) {
                            $data[$kode_proyek] = $f;
                        } else {
                            $data[$kode_proyek]->nilai_forecast += $f->nilai_forecast;
                            $data[$kode_proyek]->month_forecast = $f->month_forecast;
                        }
                    }
                }
                if (isset($data[$kode_proyek])) {
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("C" . $counter, $stage);
                    $sheet->setCellValue("D" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("E" . $counter, $this->getFullMonth($data[$kode_proyek]->month_forecast));
                    $sheet->setCellValue("F" . $counter, $data[$kode_proyek]->nilai_forecast);
                }
                $counter++;
            }
            $data = collect($data)->sortBy("month_forecast", SORT_NUMERIC);
            // dd($data);
        } elseif ($type == "NilaiOK") {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator) {
                // $history_rkap = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=" , $prognosa)->get()->sortBy("month_rkap");
                $history_rkap = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->sortBy("month_rkap", SORT_NUMERIC);
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_rkap = $history_rkap->where("divcode", $unit_kerja);
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    $history_rkap = $history_rkap->where("dop", $dop);
                }
                $history_rkap = $history_rkap->groupBy("kode_proyek");
            } else {
                if (!empty($unit_kerja)) {
                    $history_rkap = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->sortBy("month_rkap", SORT_NUMERIC);
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $history_rkap = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_rkap", SORT_NUMERIC);
                    } else {
                        $history_rkap = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_rkap", "!=", 0)->get()->sortBy("month_rkap", SORT_NUMERIC);
                    }
                }
                $history_rkap = $history_rkap->groupBy("kode_proyek");
            }
            // dd($history_rkap);
            foreach ($history_rkap as $kode_proyek => $filter) {
                foreach ($filter as $f) {
                    if ($f->month_rkap <= $month) {
                        if (!array_key_exists($f->kode_proyek, $data)) {
                            $data[$kode_proyek] = $f;
                        } else {
                            $data[$kode_proyek]->rkap_forecast += $f->rkap_forecast;
                            $data[$kode_proyek]->month_rkap = $f->month_rkap;
                        }
                    }
                }
                if (isset($data[$kode_proyek])) {
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("C" . $counter, $stage);
                    $sheet->setCellValue("D" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("E" . $counter, $this->getFullMonth($data[$kode_proyek]->month_rkap));
                    $sheet->setCellValue("F" . $counter, $data[$kode_proyek]->rkap_forecast);
                }
                $counter++;
            }
            $data = collect($data)->sortBy("month_rkap", SORT_NUMERIC);
        } else {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator) {
                $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("stage", "=", 8)->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->sortBy("month_realisasi", SORT_NUMERIC);
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_realisasi = $history_realisasi->where("divcode", $unit_kerja);
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    $history_realisasi = $history_realisasi->where("dop", $dop);
                }
                $history_realisasi = $history_realisasi->groupBy("kode_proyek");
            } else {
                if (!empty($unit_kerja)) {
                    $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->sortBy("month_realisasi", SORT_NUMERIC);
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_realisasi", SORT_NUMERIC);
                    } else {
                        $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                }
                $history_realisasi = $history_realisasi->groupBy("kode_proyek");
            }
            // dd($history_realisasi);
            foreach ($history_realisasi as $kode_proyek => $filter) {
                foreach ($filter as $f) {
                    if ($f->month_realisasi <= $month) {
                        if (!array_key_exists($f->kode_proyek, $data)) {
                            $data[$kode_proyek] = $f;
                        } else {
                            $data[$kode_proyek]->realisasi_forecast += $f->realisasi_forecast;
                            $data[$kode_proyek]->month_realisasi = $f->month_realisasi;
                        }
                    }
                }
                if (isset($data[$kode_proyek])) {
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("C" . $counter, $stage);
                    $sheet->setCellValue("D" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("E" . $counter, $this->getFullMonth($data[$kode_proyek]->month_realisasi));
                    $sheet->setCellValue("F" . $counter, $data[$kode_proyek]->realisasi_forecast);
                }
                $counter++;
            }
            // foreach ($history_realisasi as $history) {
            //     if ($history->month_realisasi <= $month) {
            //         array_push($data, $history);
            //     }
            // }
            $data = collect($data)->sortBy("month_realisasi", SORT_NUMERIC);
        }

        $writer = new Xlsx($spreadsheet);
        $file_name = "$type-$prognosa-$month-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));


        return response()->json(["href" => $file_name, "data" => $data]);
    }

    public function getDataFilterPointTriwulan($prognosa, $type, $month, $unit_kerja = "")
    {
        $arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $range_month = explode("-", $month);
        $max_month = array_search($range_month[1], $arrNamaBulan);
        if (Auth::user()->check_administrator) {
            $history_forecasts = Proyek::select("*")->where("month_forecast", "<=", $max_month)->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", "=", $prognosa)->get();
            if ($unit_kerja != "") {
                $history_forecasts = $history_forecasts->where("divcode", $unit_kerja);
            }
        } else {
            $history_forecasts = Proyek::select("*")->where("month_forecast", "<=", $max_month)->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("history_forecast", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->get();
        }
        return response()->json($history_forecasts);
    }

    public function getDataFilterPointRealisasi($prognosa, $type, $unitKerja, $divcode = "")
    {
        $unit_kerja = str_replace("-", " ", $unitKerja);
        $unit_kerja_model = UnitKerja::where("unit_kerja", "=", $unit_kerja)->get()->first();
        if ($unit_kerja_model->divcode == Auth::user()->unit_kerja && !Auth::user()->check_administrator) {
            if ($type == "Nilai-OK-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            } else if ($type == "Nilai-Realisasi-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            }
            return response()->json($proyeks);
        } else {
            if ($type == "Nilai-OK-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.unit_kerja", "=", $unit_kerja_model->divcode)->get();
            } else if ($type == "Nilai-Realisasi-Kumulatif") {
                $proyeks = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("proyeks.unit_kerja", "=", $unit_kerja_model->divcode)->get();
            }
            return response()->json($proyeks);
        }
    }

    public function getDataMonitoringProyek($tipe, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai Penawaran");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
                // $proyeks = Proyek::all()->where("unit_kerja", "=", $filter);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
        }

        $stage = null;
        $column_to_sort = null;
        switch (trim($tipe)) {
            case "Prakualifikasi":
                $stage = 3;
                $column_to_sort = "bulan_pelaksanaan";
                break;
            case "Kalah dan Cancel":
                $stage = [0, 7];
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Proses":
                $stage = [1, 2, 4, 5];
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Menang":
                $stage = [6, 8, 10];
                $column_to_sort = "month_realisasi";
                break;
        }
        if (is_array($stage) && $stage != null) {
            $proyeks = $proyeks->whereIn("stage", $stage)->sortBy($column_to_sort, SORT_NUMERIC);
        } elseif ($stage != null) {
            $proyeks = $proyeks->where("stage", $stage)->sortBy($column_to_sort, SORT_NUMERIC);
        }
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataTerendahTerkontrak($tipe, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai Penawaran");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
        }
        $proyeks = $proyeks->filter(function ($p) {
            return $p->Forecasts->filter(function ($f) {
                return $f->periode_prognosa == (int) date("m");
            });
        });
        $stage = null;
        switch ($tipe) {
            case "Terendah":
                $proyeks = $proyeks->whereIn("stage", [5, 6])->filter(function ($p) {
                    return ($p->stage == 5 && $p->peringkat_wika == "Peringkat 1") || $p->stage == 6;
                })->sortBy("forecasts.month_realisasi", SORT_NUMERIC);
                break;
            case "Terkontrak":
                $stage = 8;
                $proyeks = $proyeks->where("stage", "=", $stage)->sortBy("forecasts.month_realisasi", SORT_NUMERIC);
                break;
        }
        // dd($proyeks);
        $proyeks = $proyeks->filter(function ($p) {
            return $p->Forecasts->count() > 0;
        });
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
            $sheet->setCellValue('F' . $row, $p->nilai_kontrak_keseluruhan);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }


    public function getDataCompetitive($tipe, $filter = false)
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai Perolehan");

        // dd($tipe);

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            }
        }
        $stage = null;
        switch ($tipe) {
            case "Proyek Menang":
                $proyeks = $proyeks->whereIn("stage", [6, 8])->sortBy([
                    ["bulan_pelaksanaan", "asc"],
                ])->values();
                break;
            case "Proyek Kalah":
                $stage = 7;
                $proyeks = $proyeks->where("stage", "=", $stage)->sortBy("bulan_pelaksanaan")->values();
                break;
        }
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
            $sheet->setCellValue('F' . $row, $p->nilai_perolehan);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));
        // dd($proyeks);

        return response()->json(["tipe" => $tipe, "href" => $file_name, "data" => $proyeks]);
    }

    public function getDataCompetitiveNilai($tipe, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Bulan');
        $sheet->setCellValue('F1', "Nilai Penawaran");

        // dd($tipe);    

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            }
        }
        $stage = null;
        switch ($tipe) {
            case "Nilai Menang":
                $proyeks = $proyeks->whereIn("stage", [6, 8])->sortBy("bulan_pelaksanaan", SORT_NUMERIC)->values();
                break;
            case "Nilai Kalah":
                $stage = 7;
                $proyeks = $proyeks->where("stage", "=", $stage)->sortBy("bulan_pelaksanaan", SORT_NUMERIC)->values();
                break;
        }
        // dd($proyeks);
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
            $sheet->setCellValue('F' . $row, $p->nilai_perolehan);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["tipe" => $tipe, "href" => $file_name, "data" => $proyeks]);
    }

    public function getDataSumberDanaRKAP($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai RKAP");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        $tipe_real = "";
        if (str_contains($tipe, "BUMN")) {
            $tipe_real = str_replace("-", " / ", $tipe);
        } else {
            $tipe_real = str_replace("-", " ", $tipe);
        }
        if (!Auth::user()->check_administrator) {
            if ($filter != "") {
                $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
        }

        $proyeks = $proyeks->sortBy("nilai_rkap", SORT_REGULAR, true)->values();
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $p->nilai_rkap);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataSumberDanaRealisasi($tipe, $filter = "")
    {
        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai Realisasi");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        $tipe_real = "";
        if (str_contains($tipe, "BUMN")) {
            $tipe_real = str_replace("-", " / ", $tipe);
        } else {
            $tipe_real = str_replace("-", " ", $tipe);
        }
        if (!Auth::user()->check_administrator) {
            if ($filter != "") {
                $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            $proyeks = Proyek::with("UnitKerja")->where("sumber_dana", "=", $tipe_real)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);
        }

        $proyeks = $proyeks->sortBy("nilai_perolehan", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $p->nilai_perolehan);
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataNilaiOK($tipe, $filter = "") {
        $spreadsheet = new Spreadsheet();
        $tipe = str_replace("-", " ", $tipe);
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai RKAP");
        
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $tipe)->first();
        $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $unit_kerja->divcode)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"]);

        $proyeks = $proyeks->sortBy("nilai_rkap", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $nilaiRKAP = 0;
            $p->Forecasts->each(function($f) use(&$nilaiRKAP) {
                $nilaiRKAP += (int) $f->rkap_forecast;
            });
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $nilaiRKAP);
            $p->nilai_rkap = $nilaiRKAP;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-Nilai-OK-Kumulatif-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getDataNilaiRealisasi($tipe, $filter = "") {
        $spreadsheet = new Spreadsheet();
        $tipe = str_replace("-", " ", $tipe);
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai Realisasi");

        // $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $tipe)->first();
        $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $unit_kerja->divcode)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender"])->where("stage", "=", 8)->where("is_cancel", "!=", true);

        $proyeks = $proyeks->sortBy("nilai_perolehan", SORT_REGULAR, true)->values();

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet) {
            $nilaiRealisasi = 0;
            $p->Forecasts->each(function($f) use(&$nilaiRealisasi) {
                $nilaiRealisasi += (int) $f->realisasi_forecast;
            });
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('D' . $row, $nilaiRealisasi);
            $p->nilai_perolehan = $nilaiRealisasi;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-Nilai-Realisasi-Kumulatif-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }


    public function getFullMonth($month)
    {
        switch ($month) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    public static function getProyekStage($month)
    {
        switch ($month) {
            case 0:
                return "Pasar Dini";
                break;
            case 1:
                return "Pasar Dini";
                break;
            case 2:
                return "Pasar Potensial";
                break;
            case 3:
                return "Prakualifikasi";
                break;
            case 4:
                return "Tender Diikuti";
                break;
            case 5:
                return "Perolehan";
                break;
            case 6:
                return "Menang";
                break;
            case 7:
                return "Terendah";
                break;
            case 8:
                return "Terkontrak";
                break;
        }
    }

    public static function getUnitKerjaProyek($divcode)
    {
        return UnitKerja::where("divcode", "=", $divcode)->first()->unit_kerja;
    }

    static function copyDataForecast() {
        $month = (int) date("m");
        $year = (int) date("Y");
        $is_forecasts_exist = Forecast::where("periode_prognosa", "=", $month)->whereYear("created_at", "=", $year)->get()->count() > 0 ? true : false;
        if(!$is_forecasts_exist) {
            if($month == 1) {
                $forecasts = Forecast::where("periode_prognosa", "=", $month + 11)->whereYear("created_at", "=", $year - 1)->get();
            } else {
                $forecasts = Forecast::where("periode_prognosa", "=", $month - 1)->whereYear("created_at", "=", $year)->get();
            }
            // dd($forecasts);
            // $forecasts->each(function($f) use($month) {
            //     $new_forecast = $f->replicate();
            //     // dd($f);
            //     $new_forecast->created_at = now();
            //     $new_forecast->updated_at = now();
            //     $new_forecast->periode_prognosa = $month;
            //     $new_forecast->save();
            //     // dd($new_forecast);
            // });
        }
    }
}
