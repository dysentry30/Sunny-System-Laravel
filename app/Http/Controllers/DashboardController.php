<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Dop;
use App\Models\Proyek;
use GuzzleHttp\Client;
use App\Models\Forecast;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use ParagonIE\Sodium\Compat;
use App\Models\ClaimManagements;
use App\Models\PerubahanKontrak;
use App\Models\ContractManagements;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SebastianBergmann\CodeCoverage\Util\Percentage;

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
        self::deleteOldExcelFiles();
        // end :: Delete Old Excel Files

        // begin :: Check User CCM
        if (Auth::user()->check_admin_kontrak) {
            return redirect("/dashboard-ccm/perolehan-kontrak");
        }
        // end :: Check User CCM

        //begin::History Forecast
        if ($request->get("periode-prognosa") || $request->get("tahun-history")) {
            $year = (int) $request->get("tahun-history") ?? (int) date("Y");
            $month = $request->get("periode-prognosa") ?? "";
            $unit_kerja_get = $request->get("unit-kerja") ?? "";
            $dop_get = $request->get("dop") ?? "";
        } else {
            $year = (int) date("Y");
            $month = (int) date("m");
            $unit_kerja_get = "";
            $dop_get = "";
            // $nilaiHistoryForecast = HistoryForecast::all();
        }
        // dd($unit_kerja_get);
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if (Auth::user()->check_administrator) {
            // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : (int) date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
            $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : (int) date("m"))->where("forecasts.tahun", "=", $year)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // dd($nilaiHistoryForecast, $request->get("periode-prognosa"), (int) date("m"));
            $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->get();
            $unitKerja = UnitKerja::orderBy('unit_kerja')->get()->whereNotIn("divcode", ["B", "C", "D", "8"]);
            // dd($unitKerja);
            $proyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements', "SumberDana"])->where("tahun_perolehan", "=", $year)->get();
            $paretoProyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements'])->where("proyeks.jenis_proyek", "!=", "I")->get();
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
            // if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->get();
            $proyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements', "SumberDana"])->where("tahun_perolehan", "=", $year)->get();
            $paretoProyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements'])->where("proyeks.jenis_proyek", "!=", "I")->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            $unitKerja = UnitKerja::get()->whereIn("divcode", $unit_kerja_user->toArray());
            // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get()->whereIn("unit_kerja", $unit_kerja_user->toArray());
            $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : (int) date("m"))->where("forecasts.tahun", "=", $year)->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // dd($nilaiHistoryForecast, Auth::user());
            if (!empty($request->get("unit-kerja"))) {
                // dd($request);
                // dd($nilaiHistoryForecast);
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("unit_kerja", $request->get("unit-kerja"));
                $claims = $claims->where("unit_kerja", $request->get("unit-kerja"));
                $proyeks = $proyeks->where("unit_kerja", $request->get("unit-kerja"));
                $contracts = $contracts->where("unit_kerja", $request->get("unit-kerja"));
                $paretoProyeks = $paretoProyeks->where("unit_kerja", $request->get("unit-kerja"));
            } else if (!empty($request->get("dop"))) {
                $nilaiHistoryForecast = $nilaiHistoryForecast->where("dop", $request->get("dop"));
                $claims = $claims->where("dop", $request->get("dop"));
                $proyeks = $proyeks->where("dop", $request->get("dop"));
                $contracts = $contracts->where("dop", $request->get("dop"));
                $paretoProyeks = $paretoProyeks->where("dop", $request->get("dop"));
                // dd($proyeks);
                // dd($nilaiHistoryForecast, $claims, $proyeks, $contracts);
            } else {
                $nilaiHistoryForecast = $nilaiHistoryForecast->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $claims = $claims->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $proyeks = $proyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $contracts = $contracts->whereIn("unit_kerja", $unit_kerja_user->toArray());
                $paretoProyeks = $paretoProyeks->whereIn("unit_kerja", $unit_kerja_user->toArray());
            }
            // } else {
            //     $contracts = ContractManagements::join("proyeks", "proyeks.kode_proyek", "=", "contract_managements.project_id")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $proyeks = Proyek::with(['UnitKerja', 'ContractManagements'])->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $paretoProyeks = Proyek::with(['Forecasts', 'UnitKerja', 'ContractManagements'])->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $claims = ClaimManagements::join("proyeks", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
            //     $unitKerja = UnitKerja::where("divcode", "=", Auth::user()->unit_kerja)->get();
            //     // $nilaiHistoryForecast = HistoryForecast::join("proyeks", "proyeks.kode_proyek", "=", "history_forecast.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("history_forecast.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->whereYear("history_forecast.created_at", "=", (string) $request->get("tahun-history") != "" ? (string) $request->get("tahun-history") : date("Y"))->get();
            //     $nilaiHistoryForecast = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("proyeks.jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("forecasts.periode_prognosa", "=", $request->get("periode-prognosa") != "" ? (string) $request->get("periode-prognosa") : date("m"))->get();
            //     // dd($nilaiHistoryForecast, Auth::user());
            // }
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
        $historyRealisasi = $nilaiHistoryForecast->where("stage", "=", 8)->sortBy("month_realisasi");
        // dd($historyRealisasi);

        $per = 1000000; //Dibagi Dalam Jutaan


        for ($i = 1; $i <= 12; $i++) {
            foreach ($historyForecast as $forecast) {
                if ($forecast->month_forecast == $i && !$forecast->is_cancel) {
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
                if ($realisasi->month_realisasi == $i && !$realisasi->is_cancel) {
                    // dump($realisasi->realisasi_forecast);
                    $nilaiRealisasiForecast += (int) $realisasi->realisasi_forecast / $per;
                } else {
                    $nilaiRealisasiForecast == 0;
                }
            }
            array_push($nilaiRealisasiArray, round($nilaiRealisasiForecast));
        }
        // dump($nilaiRkapArray);
        // dd($nilaiRealisasiArray);


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
                    if (!$f->is_cancel) {
                        $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                    }
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
                        if (!$f->is_cancel) {
                            $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                        }
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
                        if (!$f->is_cancel) {
                            $nilaiRealisasi += (int) str_replace(",", "", ($f->realisasi_forecast));
                        }
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
            } else if ($stg == 7) {
                $kalah++;
            } else {
                $menang++;
            };
        };
        //end:: Monitoring Proyek

        //Begin::Terendah Terkontrak
        $nilaiTerkontrak = 0;
        $nilaiTerendah = 0;

        $nilaiProyekTerkontrak = $nilaiHistoryForecast->where("stage", "=", 8)->where("is_cancel", "=", false);
        $nilaiProyekTerendah = $nilaiHistoryForecast->filter(function ($p) {
            return ($p->stage == 6 || ($p->stage == 5 && $p->peringkat_wika == "Peringkat 1") || $p->stage == 9);
        })->where("is_cancel", "=", false);
        // $nilaiProyekTerendah = $proyeks->where("is_cancel", "=", false)->where("stage", "!=", 7);
        foreach ($nilaiProyekTerkontrak as $t) {
            // if ($realisasi->month_realisasi == $i && !$forecast->is_cancel) {
            // dump($realisasi->realisasi_forecast);
            if (!empty($t->month_realisasi)) {
                $nilaiTerkontrak += (int) $t->realisasi_forecast;
            }
            // } else {
            //     $nilaiRealisasiForecast == 0;
            // }
        }
        foreach ($nilaiProyekTerendah as $t) {
            // if ($realisasi->month_realisasi == $i && !$forecast->is_cancel) {
            // dump($realisasi->realisasi_forecast);
            if (!empty($t->month_forecast)) {
                $nilaiTerendah += (int) $t->nilai_forecast;
                // dd($nilaiProyekTerendah);
            }
            // } else {
            //     $nilaiRealisasiForecast == 0;
            // }
        }
        $nilaiTerkontrak = $nilaiTerkontrak / $per;
        $nilaiTerendah = $nilaiTerendah / $per;
        //End::Terendah Terkontrak

        //Begin::Competitive Index
        $jumlahMenang = 0;
        $jumlahKalah = 0;
        $nilaiMenang = 0;
        $nilaiKalah = 0;
        foreach ($proyeks as $proyek) {
            $stg = $proyek->stage;
            if ($stg == 6 || $stg == 8) {
                if ($proyek->tipe_proyek == "P"){
                    $jumlahMenang++;
                    $nilaiMenang += (int) str_replace(".", "", $proyek->nilai_perolehan);
                }
            } else if ($stg == 7) {
                if ($proyek->tipe_proyek == "P") {
                    $jumlahKalah++;
                    $nilaiKalah += (int) str_replace(".", "", $proyek->nilai_perolehan);
                }
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
        $sisaProyek = $paretoProyeks->where('stage', '!=', 8)->where('stage', '!=', 7)->where('is_cancel', '!=', true);
        $totalNilaiSisaPareto = 0;
        $sisaForecast = $sisaProyek->map(function ($pp) use (&$totalNilaiSisaPareto, $month) {
            $class = new stdClass();
            $class->nilai_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month)->sum(function ($f) {
                return (int) $f->nilai_forecast;
            });
            $class->month_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month)->max(function ($f) {
                return (int) $f->month_forecast;
            });
            $class->unit_kerja = $pp->UnitKerja->unit_kerja;
            $class->stage = $pp->stage;
            $class->nama_proyek = $pp->nama_proyek;
            $class->kode_proyek = $pp->kode_proyek;
            $class->tipe_proyek = $pp->tipe_proyek;
            $class->bulan_pelaksanaan = $pp->bulan_pelaksanaan;
            $totalNilaiSisaPareto += (int) $class->nilai_forecast;

            return $class;
        });
        $sisaForecast = $sisaForecast->sortByDesc("nilai_forecast");
        // dd($totalNilaiSisaPareto);

        $paretoRealisasi = $paretoProyeks->where('stage', '=', 8);
        $totalNilaiRealisasiPareto = 0;
        $realisasiForecast = $paretoRealisasi->map(function ($pp) use (&$totalNilaiRealisasiPareto, $month) {
            $classRi = new stdClass();
            $classRi->realisasi_forecast = $pp->Forecasts->where("periode_prognosa", "=", $month)->sum(function ($f) {
                return (int) $f->realisasi_forecast;
            });
            $classRi->month_realisasi = $pp->Forecasts->where("periode_prognosa", "=", $month)->max(function ($f) {
                return (int) $f->month_realisasi;
            });
            $classRi->unit_kerja = $pp->UnitKerja->unit_kerja;
            $classRi->stage = $pp->stage;
            $classRi->nama_proyek = $pp->nama_proyek;
            $classRi->kode_proyek = $pp->kode_proyek;
            $classRi->tipe_proyek = $pp->tipe_proyek;
            $classRi->bulan_pelaksanaan = $pp->bulan_pelaksanaan;
            $totalNilaiRealisasiPareto += (int) $classRi->realisasi_forecast;

            return $classRi;
        });
        $realisasiForecast = $realisasiForecast->sortByDesc("realisasi_forecast");
        // dd($sisaForecast);
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
        $total_RKAP_keseluruhan = 0;
        $proyeksGroupBySumberDana = $proyeks->filter(function ($p) {
            return !empty($p->SumberDana->kategori) && $p->tipe_proyek != "R";
        })->groupBy(function ($p) {
            return $p->SumberDana->kategori;
        });
        $proyeksGroupBySumberDanaRetail = $proyeks->filter(function ($p) {
            return $p->tipe_proyek == "R";
        })->groupBy(function ($p) {
            return $p->tipe_proyek;
        });

        $proyeksGroupBySumberDana = $proyeksGroupBySumberDana->mergeRecursive($proyeksGroupBySumberDanaRetail);
        foreach ($proyeksGroupBySumberDana as $sumber_dana => $proyeks_sumber_dana) {
            $total_rkap = 0;
            if($sumber_dana == "R") {
                $sumber_dana = "Retail";
            }
            // $sumber_dana_model = SumberDana::
            foreach ($proyeks_sumber_dana as $proyek) {
                if($proyek->tipe_proyek == "R") {
                    $total_rkap += (int) round($proyek->Forecasts->filter(function($f) use($month, $year) {
                        return $f->periode_prognosa == $month && $f->tahun == $year;
                    })->sum(function($f) {
                        return (int) $f->rkap_forecast;
                    }) / $per);
                } else {
                    $total_rkap += (int) round($proyek->nilai_rkap / $per);
                }
                // $total_RKAP_keseluruhan += (int) $proyek->nilai_rkap / $per;
            }
            $total_RKAP_keseluruhan += $total_rkap;
            $totalRKAPSumberDana->push([
                "name" => $sumber_dana,
                "y" => round($total_rkap),
            ]);
        }
        $totalRKAPSumberDana = $totalRKAPSumberDana->map(function ($item) use ($total_RKAP_keseluruhan) {
            $nilai_persen = (int) Percentage::fromFractionAndTotal($item["y"], $total_RKAP_keseluruhan)->asFloat();
            $item["x"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["name"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["y"] = $nilai_persen;
            return $item;
        });
        // End :: SUMBER DANA RKAP

        // Begin :: SUMBER DANA REALISASI
        $totalRealisasiSumberDana = collect();
        $total_realisasi_keseluruhan = 0;
        foreach ($proyeksGroupBySumberDana as $sumber_dana => $proyeks_sumber_dana) {
            $total_realisasi = 0;
            if($sumber_dana == "R") {
                $sumber_dana = "Retail";
            }
            foreach ($proyeks_sumber_dana as $proyek) {
                $total_realisasi += (int) $proyek->nilai_perolehan / $per;
                $total_realisasi_keseluruhan += (int) $proyek->nilai_perolehan / $per;
            }
            // $totalRealisasiSumberDana->push([
            //     "name" => $sumber_dana . ": " . (int) Percentage::fromFractionAndTotal($total_realisasi, $total_realisasi_keseluruhan)->asFloat(). "%",
            //     "y" => (int) Percentage::fromFractionAndTotal($total_realisasi, $total_realisasi_keseluruhan)->asFloat(),
            //     "x" => $sumber_dana . ": " . (int) Percentage::fromFractionAndTotal($total_realisasi, $total_realisasi_keseluruhan)->asFloat(). "%",
            // ]);
            $totalRealisasiSumberDana->push([
                "name" => $sumber_dana,
                "y" => (int) round($total_realisasi),
            ]);
        }
        $totalRealisasiSumberDana = $totalRealisasiSumberDana->map(function ($item) use ($total_realisasi_keseluruhan) {
            $nilai_persen = (int) Percentage::fromFractionAndTotal($item["y"], $total_realisasi_keseluruhan)->asFloat();
            $item["x"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["name"] = $item["name"] . ": " . $nilai_persen . "%";
            $item["y"] = $nilai_persen;
            return $item;
        });
        // dd($totalRealisasiSumberDana, $total_realisasi_keseluruhan);
        // End :: SUMBER DANA REALISASI
        return view('1_Dashboard', compact(["totalNilaiSisaPareto", "totalNilaiRealisasiPareto", "realisasiForecast", "sisaForecast", "pasarDini", "pasarPotensial", "stagePrakualifikasi", "stageTender", "stagePerolehan", "stageMenang", "stageKalah", "stageTerkontrak", "top_proyeks_close_this_month", "proyek_kalah_cancel_tidak_lulus_pq", "totalRealisasiSumberDana", "totalRKAPSumberDana", "claim_status_array", "anti_claim_status_array", "claim_asuransi_status_array", "nilaiForecastArray", "nilaiRkapArray", "nilaiRealisasiArray", "nilaiForecastTriwunalArray", "year", "month", "proses", "menang", "kalah", "prakualifikasi", "prosesTender", "terkontrak", "pelaksanaan", "serahTerima", "closing", "proyeks", "paretoClaim", "paretoAntiClaim", "paretoAsuransi", "kategoriunitKerja", "nilaiOkKumulatif", "nilaiRealisasiKumulatif", "nilaiTerkontrak", "nilaiTerendah", "jumlahMenang", "jumlahKalah", "nilaiMenang", "nilaiKalah", "unitKerja", "unit_kerja_get", "dop_get", "dops"]));
    }

    public function dashboard_perolehan_kontrak(Request $request)
    {
        $dops = Dop::whereNotIn("dop", ["EA", "PUSAT"])->get();
        $unit_kerjas = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
        $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();
        $dop_get = $request->query("dop") ?? "";
        $unit_kerja_get = $request->query("unit-kerja") ?? "";

        if ($dop_get != "") {
            $proyeks = $proyeks->filter(function ($p) use ($dop_get) {
                return $p->Dop->dop == $dop_get;
            });
        } else if ($unit_kerja_get) {
            $proyeks = $proyeks->filter(function ($p) use ($unit_kerja_get) {
                return $p->UnitKerja->divcode == $unit_kerja_get;
            });
        }


        // Begin :: Kontrak Berdasarkan Stage Chart
        $on_going_counter = $proyeks->where(function ($p) {
            return $p->stage < 6 && !$p->is_cancel;
            // dd($p->ContractManagements);
        })->count();
        $win_counter = $proyeks->where(function ($p) {
            return ($p->stage == 8 || $p->stage == 6 || $p->stage == 9) && !$p->is_cancel;
            // dd($p->ContractManagements);
        })->count();
        $lose_counter = $proyeks->where(function ($p) {
            // return !empty($p->ContractManagements) && $p->ContractManagements->stage < 3;
            return $p->stage == 7;
            // dd($p->ContractManagements);
        })->count();
        $cancel_counter = $proyeks->where(function ($p) {
            // return !empty($p->ContractManagements) && $p->ContractManagements->stage < 3;
            return $p->is_cancel == true;
            // dd($p->ContractManagements);
        })->count();
        $kontrak_by_stage = collect([
            ["On-going", $on_going_counter],
            ["Win", $win_counter],
            ["Lose", $lose_counter],
            ["Cancel", $cancel_counter],
        ]);
        // End :: Kontrak Berdasarkan Stage Chart

        // Begin :: Kontrak Berdasarkan Divisi Chart
        $divisi = collect();
        $divisi_counter = $proyeks->groupBy("unit_kerja");
        $divisi_counter = $divisi_counter->map(function ($p, $key) {
            return collect([preg_replace("/[a-z]|[ ]|[&]/", "", UnitKerja::find($key)->unit_kerja), $p->count()]);
        });
        $divisi_counter->each(function ($p) use ($divisi) {
            $divisi->push($p);
        });
        // End :: Kontrak Berdasarkan Divisi Chart

        // Begin :: Klasifikasi Kontrak Chart
        // $klasifikasi_kontrak = collect();
        // $klasifikasi_kontrak_counter = $proyeks->groupBy("unit_kerja");
        // $klasifikasi_kontrak_counter = $klasifikasi_kontrak_counter->map(function($p, $key) {
        //     return collect([preg_replace("/[a-z][^0-9]|[ ]/", "", UnitKerja::find($key)->divisi), $p->count()]);
        // });
        // $klasifikasi_kontrak_counter->each(function($p) use($divisi) {
        //     $divisi->push($p);
        // });
        // End :: Klasifikasi Kontrak Chart

        // Begin :: Kontrak Berdasarkan JO dan Non-JO Chart
        $JO_Non_JO_counter = $proyeks;
        $JO_counter = $JO_Non_JO_counter->where("jenis_proyek", "=", "J")->count();
        $Non_JO_counter = $JO_Non_JO_counter->where("jenis_proyek", "!=", "J")->count();
        $JO_Non_JO_counter = collect([["JO", $JO_counter], ["Non-JO", $Non_JO_counter]]);
        // End :: Kontrak Berdasarkan JO dan Non-JO Chart

        // Begin :: Nilai Tender Chart
        $nilai_tender_proyeks = $proyeks->groupBy("unit_kerja");
        $nilai_tender_proyeks = $nilai_tender_proyeks->map(function ($p, $key) {
            $nilai_tender = $p->sum(function ($s) {
                return (int) $s->nilai_perolehan;
            });
            return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
        })->values();
        // End :: Nilai Tender Chart

        // Begin :: Success Rate
        $success_rate = (int) Percentage::fromFractionAndTotal($win_counter, $proyeks->count())->asFloat();
        // End :: Success Rate

        // Begin :: Clasification Column
        $cadangan = 0;
        $sasaran = 0;
        $potensial = 0;
        foreach ($proyeks as $key => $p) {
            // dd($p->status_pasar);
            if ($p->status_pasdin == "Cadangan") {
                $cadangan += 1;
            }
            if ($p->status_pasdin == "Sasaran") {
                $sasaran += 1;
            }
            if ($p->status_pasdin == "Potensial") {
                $potensial += 1;
            }
        }
        // End :: Clasification Column
        // Begin :: Tender Status Column
        // End :: Tender Status Column

        $jumlahKontrak = $proyeks->count();

        return view("1_Dashboard_ccm_perolehan_kontrak", compact(["jumlahKontrak", "cadangan", "sasaran", "potensial", "cancel_counter","lose_counter", "win_counter", "on_going_counter", "proyeks", "dops", "unit_kerjas", "dop_get", "unit_kerja_get", "kontrak_by_stage", "divisi", "JO_Non_JO_counter", "nilai_tender_proyeks", "success_rate"]));
    }

    public function dashboard_pelaksanaan_kontrak(Request $request)
    {
        $dops = Dop::whereNotIn("dop", ["EA", "PUSAT"])->get();
        $unit_kerjas = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"])->get();
        $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->where("stage", "=", 8)->get()->filter(function ($p) {
            return !empty($p->ContractManagements) && $p->stage == 8;
        });
        $dop_get = $request->query("dop") ?? "";
        $unit_kerja_get = $request->query("unit-kerja") ?? "";
        $proyek_get = $request->query("kode-proyek") ?? "";
        // $claims = ClaimManagements::all();
        // dd($claims);
        
        if ($dop_get != "") {
            $proyeks = $proyeks->filter(function ($p) use ($dop_get) {
                return $p->Dop->dop == $dop_get;
            });
        } else if ($unit_kerja_get) {
            $proyeks = $proyeks->filter(function ($p) use ($unit_kerja_get) {
                return $p->UnitKerja->divcode == $unit_kerja_get;
            });
        } else if (!empty($proyek_get)) {
            $proyek = $proyeks->where("kode_proyek", "=", $proyek_get)->first();
            $claims = ClaimManagements::where("kode_proyek", "=", $proyek_get)->get();
            $kategori_kontrak = PerubahanKontrak::where("id_contract", "=", $proyek->ContractManagements->id_contract)->get();
            
            // Begin :: Changes Overview
            $kategori_kontrak = $kategori_kontrak->groupBy("jenis_perubahan")->map(function ($kategori, $key) use ($proyek) {
                $pengajuan = $kategori->sum(function ($c) {
                    return (int) $c->biaya_pengajuan; 
                });
                $persen = (float) $pengajuan * 100 / (float) $proyek->nilai_perolehan;
                $potensial = 0;
                $subs = 0;
                $revisi = 0;
                $nego = 0;
                $setuju = 0;
                $tidak = 0;
                $dispute = 0;
                foreach ($kategori as $k) {
                    if ($k->stage == 1) {
                        $potensial += 1;
                    } else if ($k->stage == 2) {
                        $subs += 1;
                    } else if ($k->stage == 3) {
                        $revisi += 1;
                    } else if ($k->stage == 4) {
                        $nego += 1;
                    } else if ($k->stage == 5) {
                        $setuju += 1;
                    } else if ($k->stage == 6 && $k->is_dispute == false) {
                        $tidak += 1;
                    } else {
                        $dispute += 1;
                    }
                }
                return [$key, $kategori->count(), $pengajuan, number_format($persen, 2), $potensial, $subs, $revisi, $nego, $setuju, $tidak, $dispute];
            })->values();
            // dd($kategori_kontrak);
            // End :: Changes Overview
            
            $jumlahKontrak = 0;
            $totalKontrak = 0;
            $totalPersen = 0;
            foreach ($kategori_kontrak as $key => $k) {
                $jumlahKontrak += (int) $k[1] ;
                $totalKontrak += (int) $k[2] ;
                $totalPersen += (float) $k[3] ;
            }

            $insurance = [
                [
                    "CAR/EAR", mt_rand(0, 1)
                ], [
                    "3rd PARTY", mt_rand(0, 1)
                ], [
                    "PROF. INDEMNITY", mt_rand(0, 1)
                ], [
                    "HEAVY EQUIP", mt_rand(0, 1)
                ]
            ];
            $insurance = collect($insurance);
            
            $bond = [
                [
                    "ADV PAYMENT", mt_rand(0, 1)
                ], [
                    "PERFORMANCE", mt_rand(0, 1)
                ], [
                    "WARRANTY", mt_rand(0, 1)
                ], [
                    "PARTNER", mt_rand(0, 1)
                ]
            ];
            $bond = collect($bond);

            return view("/DashboardCCM/Dashboard_pelaksanaan_proyek", compact(["bond", "insurance", "jumlahKontrak", "totalKontrak", "totalPersen", "kategori_kontrak", "proyek_get", "unit_kerja_get", "dop_get", "proyeks", "dops", "unit_kerjas"]));
        }
        
        $claims = ClaimManagements::all()->filter(function($cl) use($proyeks) {
            return $proyeks->firstWhere("kode_proyek", "=", $cl->kode_proyek);
        });

        // Begin :: Pemilik Pekerjaan
        $pemilik_pekerjaan = $proyeks->map(function ($p) {
            $new_class = new stdClass();
            if (!empty($p->SumberDana)) {
                $new_class->kategori = $p->SumberDana->kategori;
            } else {
                $new_class->kategori = "Other";
            }
            return $new_class;
        })->groupBy("kategori")->map(function ($p, $key) {
            return [$key, $p->count()];
        })->values();
        // End :: Pemilik Pekerjaan

        // Begin :: Changes Overview
        // $kategori_kontrak = $claims->groupBy("jenis_claim")->map(function ($c, $key) {
        //     return [$key, $c->count()];
        // })->values();
        $kategori_kontrak = [
            [
                "VO", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
            ], [
                "KLAIM", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
            ], [
                "ANTI-KLAIM", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
            ], [
                "ASURANSI", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
        ]
        ];
        $kategori_kontrak = collect($kategori_kontrak);

        $jumlahKontrak = 0;
        $totalKontrak = 0;
        $totalPersen = 0;
        foreach ($kategori_kontrak as $key => $k) {
            $jumlahKontrak += (int) $k[1];
            $totalKontrak += (int) $k[2];
            $totalPersen += (int) $k[3];
        }
        // End :: Changes Overview
        // dd($kategori_kontrak);

        // Begin :: Jenis Kontrak
        $jenis_kontrak = $proyeks->map(function ($p) {
            // dd($p);
            if (!empty($p->jenis_terkontrak)) {
                if ($p->jenis_terkontrak == "Design & Build") {
                    $p->jenis_terkontrak = "Lumpsum";
                }else if ($p->jenis_terkontrak == "OM") {
                    $p->jenis_terkontrak = "Unit Price";
                } else {
                    $p->jenis_terkontrak = $p->jenis_terkontrak;
                }
            } else {
                $p->jenis_terkontrak = "Uncategorized";
            }
            return $p;
        })->groupBy("jenis_terkontrak")->map(function ($p, $key) {
            return [$key, $p->count()];
        })->values();
        // dd($jenis_kontrak);
        // End :: Jenis Kontrak

        // Begin :: Nilai Tender Chart
        $nilai_tender_proyeks = $proyeks->groupBy("unit_kerja");
        $nilai_tender_proyeks = $nilai_tender_proyeks->map(function ($p, $key) {
            $nilai_tender = $p->sum(function ($s) {
                return (int) $s->nilai_perolehan;
            });
            return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
        })->values();
        // End :: Nilai Tender Chart
        
        // Begin :: Table Nilai Perubahan
        $total_nilai_perubahan = $claims->groupBy("jenis_claim")->map(function($c) {
            $nilai = $c->sum(function($p) {
                return (int) $p->nilai_claim;
            });
            $new_class = new stdClass();
            // $new_class->jenis_claim = $key;
            $new_class->total_nilai = "Rp. " . number_format($nilai, 0, ".", ".");
            $new_class->total_proyek = 10;
            $new_class->total_persen = "20%";
            return $new_class;
            // return (int) $c->nilai_claim;
        });

        // $proyeksDummy = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "8"])->join("claim_managements", "proyeks.kode_proyek", "=", "claim_managements.kode_proyek")->where("stage", "=", 8)->get();
        // $nilai_perubahan_table = $proyeksDummy->groupBy("jenis_claim")->map(function ($c, $key) {
        //     $nilai = $c->sum(function($p) {
        //         return (int) $p->nilai_perolehan;
        //     });
            // dd($c);
        $nilai_perubahan_table = $claims->groupBy("jenis_claim")->map(function ($c, $key) {
            $nilai = $c->sum(function($p) {
                return (int) $p->nilai_claim;
            });
            $new_class = new stdClass();
            $new_class->jenis_claim = $key;
            $new_class->total_nilai = $nilai;
            $new_class->total_proyek = $c->count();
            $new_class->total_persen = "20%";
            return $new_class;
        })->values();
        $totalPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // $persenPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // dd($nilai_perubahan_table);
        // dd($nilai_perubahan_table);
        // End :: Table Nilai Perubahan

        $jumlahKontrak = $proyeks->count();

        return view("1_Dashboard_ccm_pelaksanaan_kontrak", compact(["jumlahKontrak", "totalKontrak", "totalPersen", "totalPerubahan", "jumlahKontrak", "dops", "unit_kerjas", "proyeks", "pemilik_pekerjaan", "kategori_kontrak", "jenis_kontrak", "dop_get", "unit_kerja_get", "proyek_get", "nilai_tender_proyeks", "total_nilai_perubahan", "nilai_perubahan_table"]));
    }

    public function dashboard_pemeliharaan_kontrak(Request $request)
    {
        $dops = Dop::whereNotIn("dop", ["EA", "PUSAT"])->get();
        $unit_kerjas = UnitKerja::whereNotIn("divcode", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->get();
        $proyeks = Proyek::whereNotIn("unit_kerja", ["1", "2", "3", "4", "5", "6", "7", "8", "B", "C", "D", "N"])->where("stage", "=", 8)->get()->filter(function ($p) {
            return !empty($p->ContractManagements) && $p->stage == 8;
        });
        $dop_get = $request->query("dop") ?? "";
        $unit_kerja_get = $request->query("unit-kerja") ?? "";
        $proyek_get = $request->query("kode-proyek") ?? "";
        // $claims = ClaimManagements::all();
        // dd($claims);

        if ($dop_get != "") {
            $proyeks = $proyeks->filter(function ($p) use ($dop_get) {
                return $p->Dop->dop == $dop_get;
            });
        } else if ($unit_kerja_get) {
            $proyeks = $proyeks->filter(function ($p) use ($unit_kerja_get) {
                return $p->UnitKerja->divcode == $unit_kerja_get;
            });
        } else if (!empty($proyek_get)) {
            $proyek = $proyeks->where("kode_proyek", "=", $proyek_get)->first();
            $claims = ClaimManagements::where("kode_proyek", "=", $proyek_get)->get();
            $kategori_kontrak = PerubahanKontrak::where("id_contract", "=", $proyek->ContractManagements->id_contract)->get();

             // Begin :: Changes Overview
            $kategori_kontrak = $kategori_kontrak->groupBy("jenis_perubahan")->map(function ($kategori, $key) use ($proyek) {
                $pengajuan = $kategori->sum(function ($c) {
                    return (int) $c->biaya_pengajuan; 
                });
                $persen = (float) $pengajuan * 100 / (float) $proyek->nilai_perolehan;
                $potensial = 0;
                $subs = 0;
                $revisi = 0;
                $nego = 0;
                $setuju = 0;
                $tidak = 0;
                $dispute = 0;
                foreach ($kategori as $k) {
                    if ($k->stage == 1) {
                        $potensial += 1;
                    } else if ($k->stage == 2) {
                        $subs += 1;
                    } else if ($k->stage == 3) {
                        $revisi += 1;
                    } else if ($k->stage == 4) {
                        $nego += 1;
                    } else if ($k->stage == 5) {
                        $setuju += 1;
                    } else if ($k->stage == 6 && $k->is_dispute == false) {
                        $tidak += 1;
                    } else {
                        $dispute += 1;
                    }
                }
                return [$key, $kategori->count(), $pengajuan, number_format($persen, 2), $potensial, $subs, $revisi, $nego, $setuju, $tidak, $dispute];
            })->values();
            // dd($kategori_kontrak);
            // End :: Changes Overview

            $jumlahKontrak = 0;
            $totalKontrak = 0;
            $totalPersen = 0;
            foreach ($kategori_kontrak as $key => $k) {
                $jumlahKontrak += (int) $k[1];
                $totalKontrak += (int) $k[2];
                $totalPersen += (float) $k[3] ;
            }

            $insurance = [
                [
                    "CAR/EAR", mt_rand(0, 1)
                ], [
                    "3rd PARTY", mt_rand(0, 1)
                ], [
                    "PROF. INDEMNITY", mt_rand(0, 1)
                ], [
                    "HEAVY EQUIP", mt_rand(0, 1)
                ]
            ];
            $insurance = collect($insurance);
            
            $bond = [
                [
                    "ADV PAYMENT", mt_rand(0, 1)
                ], [
                    "PERFORMANCE", mt_rand(0, 1)
                ], [
                    "WARRANTY", mt_rand(0, 1)
                ], [
                    "PARTNER", mt_rand(0, 1)
                ]
            ];
            $bond = collect($bond);

            return view("/DashboardCCM/Dashboard_pemeliharaan_proyek", compact(["bond", "insurance", "jumlahKontrak", "totalKontrak", "totalPersen", "kategori_kontrak", "proyek_get", "unit_kerja_get", "dop_get", "proyeks", "dops", "unit_kerjas"]));
        }

        $claims = ClaimManagements::all()->filter(function ($cl) use ($proyeks) {
            return $proyeks->where("kode_proyek", "=", $cl->kode_proyek)->count() > 0;
        });


        // Begin :: Pemilik Pekerjaan
        $pemilik_pekerjaan = $proyeks->map(function ($p) {
            $new_class = new stdClass();
            if (!empty($p->SumberDana)) {
                $new_class->kategori = $p->SumberDana->kategori;
            } else {
                $new_class->kategori = "Other";
            }
            return $new_class;
        })->groupBy("kategori")->map(function ($p, $key) {
            return [$key, $p->count()];
        })->values();
        // End :: Pemilik Pekerjaan

        // Begin :: Changes Overview
        // $kategori_kontrak = $claims->groupBy("jenis_claim")->map(function ($c, $key) {
        //     return [$key, $c->count()];
        // })->values();
        $kategori_kontrak = [
            [
                "VO", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
            ], [
                "KLAIM", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
            ], [
                "ANTI-KLAIM", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
            ], [
                "ASURANSI", mt_rand(0, 15), mt_rand(1000000000, 20000000000), mt_rand(0, 10)
        ]
        ];
        $kategori_kontrak = collect($kategori_kontrak);

        $jumlahKontrak = 0;
        $totalKontrak = 0;
        $totalPersen = 0;
        foreach ($kategori_kontrak as $key => $k) {
            $jumlahKontrak += (int) $k[1];
            $totalKontrak += (int) $k[2];
            $totalPersen += (int) $k[3];
        }
        // dd($kategori_kontrak);
        // End :: Changes Overview
        // dd($claims);

        // Begin :: Jenis Kontrak
        $jenis_kontrak = $proyeks->map(function ($p) {
            // dd($p);
            if (!empty($p->jenis_terkontrak)) {
                if ($p->jenis_terkontrak == "Design & Build") {
                    $p->jenis_terkontrak = "Lumpsum";
                } else if ($p->jenis_terkontrak == "OM") {
                    $p->jenis_terkontrak = "Unit Price";
                } else {
                    $p->jenis_terkontrak = $p->jenis_terkontrak;
                }
            } else {
                $p->jenis_terkontrak = "Uncategorized";
            }
            return $p;
        })->groupBy("jenis_terkontrak")->map(function ($p, $key) {
            return [$key, $p->count()];
        })->values();
        // dd($jenis_kontrak);
        // End :: Jenis Kontrak

        // Begin :: Nilai Tender Chart
        $nilai_tender_proyeks = $proyeks->groupBy("unit_kerja");
        $nilai_tender_proyeks = $nilai_tender_proyeks->map(function ($p, $key) {
            $nilai_tender = $p->sum(function ($s) {
                return (int) $s->nilai_perolehan;
            });
            return ["name" => UnitKerja::find($key)->unit_kerja, "y" => $nilai_tender];
        })->values();
        // End :: Nilai Tender Chart

        // Begin :: Table Nilai Perubahan
        $total_nilai_perubahan = $claims->groupBy("jenis_claim")->map(function ($c) {
            $nilai = $c->sum(function ($p) {
                return (int) $p->nilai_claim;
            });
            $new_class = new stdClass();
            // $new_class->jenis_claim = $key;
            $new_class->total_nilai = "Rp. " . number_format($nilai, 0, ".", ".");
            $new_class->total_proyek = 10;
            $new_class->total_persen = "20%";
            return $new_class;
            // return (int) $c->nilai_claim;
        });
        $nilai_perubahan_table = $claims->groupBy("jenis_claim")->map(function ($c, $key) {
            $nilai = $c->sum(function ($p) {
                return (int) $p->nilai_claim;
            });
            $new_class = new stdClass();
            $new_class->jenis_claim = $key;
            $new_class->total_nilai = $nilai;
            $new_class->total_proyek = $c->count();
            $new_class->total_persen = "20%";
            return $new_class;
        })->values();
        $totalPerubahan = $nilai_perubahan_table->sum("total_nilai");
        // $persenPerubahan = $nilai_perubahan_table->sum("total_nilai"); 
        // dd($nilai_perubahan_table);
        // dd($nilai_perubahan_table);
        // End :: Table Nilai Perubahan

        $jumlahKontrak = $proyeks->count();

        return view("1_Dashboard_ccm_pemeliharaan_kontrak", compact(["jumlahKontrak", "totalKontrak", "totalPersen", "totalPerubahan", "jumlahKontrak", "dops", "unit_kerjas", "proyeks", "pemilik_pekerjaan", "kategori_kontrak", "jenis_kontrak", "dop_get", "unit_kerja_get", "proyek_get", "nilai_tender_proyeks", "total_nilai_perubahan", "nilai_perubahan_table"]));
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
        $sheet->getStyle("A1:G1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai $type");


        // dd($request->all());   
        // dd($type, $prognosa, $month, $unit_`kerja);   
        if ($type == "Forecast") {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator) {
                $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
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
                    $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                    // dd($request->all());
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->whereIn("divcode", $unit_kerja_user->toArray())->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    } else {
                        $history_forecasts = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_forecast", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_forecast", SORT_NUMERIC);
                    }
                }
                $history_forecasts = $history_forecasts->where("nilai_forecast", "!=", "")->where("nilai_forecast", "!=", "0")->groupBy("kode_proyek");
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
                $tipe_proyek = "";
                if ($data[$kode_proyek]->tipe_proyek == "R") {
                    $tipe_proyek = "Retail";
                } else {
                    $tipe_proyek = "Non-Retail";
                }
                if (isset($data[$kode_proyek])) {
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("C" . $counter, $stage);
                    $sheet->setCellValue("D" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("E" . $counter, $tipe_proyek);
                    $sheet->setCellValue("F" . $counter, $this->getFullMonth($data[$kode_proyek]->month_forecast));
                    $sheet->setCellValue("G" . $counter, $data[$kode_proyek]->nilai_forecast);
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
                $tipe_proyek = "";
                if ($data[$kode_proyek]->tipe_proyek == "R") {
                    $tipe_proyek = "Retail";
                } else {
                    $tipe_proyek = "Non-Retail";
                }
                if (isset($data[$kode_proyek])) {
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("C" . $counter, $stage);
                    $sheet->setCellValue("D" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("E" . $counter, $tipe_proyek);
                    $sheet->setCellValue("F" . $counter, $this->getFullMonth($data[$kode_proyek]->month_rkap));
                    $sheet->setCellValue("G" . $counter, $data[$kode_proyek]->rkap_forecast);
                }
                $counter++;
            }
            $data = collect($data)->sortBy("month_rkap", SORT_NUMERIC);
        } else {
            $month = array_search($month, $arrNamaBulan);
            if (Auth::user()->check_administrator) {
                $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("stage", "=", 8)->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                if ($unit_kerja != "" && strlen($unit_kerja) == 1) {
                    $history_realisasi = $history_realisasi->where("divcode", $unit_kerja);
                } elseif ($unit_kerja != "") {
                    $dop = str_replace("-", " ", $unit_kerja);
                    $history_realisasi = $history_realisasi->where("dop", $dop);
                }
                $history_realisasi = $history_realisasi->groupBy("kode_proyek");
            } else {
                if (!empty($unit_kerja)) {
                    $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", $unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                } else {
                    $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->whereIn("divcode", $unit_kerja_user->toArray())->sortBy("month_realisasi", SORT_NUMERIC);
                    } else {
                        $history_realisasi = Proyek::select("*")->join("unit_kerjas", "proyeks.unit_kerja", "=", "unit_kerjas.divcode")->where("stage", "=", 8)->join("forecasts", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("jenis_proyek", "!=", "I")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("periode_prognosa", "=", $prognosa)->where("month_realisasi", "!=", 0)->get()->where("is_cancel", "!=", true)->sortBy("month_realisasi", SORT_NUMERIC);
                    }
                }
                $history_realisasi = $history_realisasi->filter(function ($p) {
                    return $p->realisasi_forecast != 0;
                })->groupBy("kode_proyek");
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
                    $tipe_proyek = "";
                    if ($data[$kode_proyek]->tipe_proyek == "R") {
                        $tipe_proyek = "Retail";
                    } else {
                        $tipe_proyek = "Non-Retail";
                    }
                    $sheet->setCellValue("A" . $counter, $data[$kode_proyek]->nama_proyek);
                    $sheet->setCellValue("B" . $counter, $data[$kode_proyek]->status_pasdin);
                    $stage = $this->getProyekStage($data[$kode_proyek]->stage);
                    $sheet->setCellValue("C" . $counter, $stage);
                    $sheet->setCellValue("D" . $counter, $data[$kode_proyek]->unit_kerja);
                    $sheet->setCellValue("E" . $counter, $tipe_proyek);
                    $sheet->setCellValue("F" . $counter, $this->getFullMonth($data[$kode_proyek]->month_realisasi));
                    $sheet->setCellValue("G" . $counter, $data[$kode_proyek]->realisasi_forecast);
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

    public function getDataMonitoringProyek($tipe, $prognosa, $filter = false)
    {

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:G1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Status Pasar');
        $sheet->setCellValue('C1', 'Stage');
        $sheet->setCellValue('D1', 'Unit Kerja');
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai Penawaran");
        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
        if (!Auth::user()->check_administrator) {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("is_cancel", "=", false)->where("unit_kerja", "=", $filter)->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek"]);
                // $proyeks = Proyek::all()->where("unit_kerja", "=", $filter);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("is_cancel", "=", false)->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("is_cancel", "=", false)->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("is_cancel", "=", false)->get(["nama_proyek", "kode_proyek", "bulan_awal", "bulan_ri_perolehan", "bulan_pelaksanaan", "nilai_kontrak_keseluruhan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "tipe_proyek"]);
        }
        // $proyeks = $proyeks->where("tipe_proyek", "!=", "R")->where("jenis_proyek", "!=", "I");
        $proyeks = $proyeks->where("jenis_proyek", "!=", "I")->where(function ($p) use ($prognosa) {
            return $p->forecasts->where("periode_prognosa", "=", $prognosa);
        });

        $stage = null;
        $column_to_sort = null;
        $is_menang = false;
        switch (trim($tipe)) {
            case "Prakualifikasi":
                $stage = 3;
                $column_to_sort = "bulan_pelaksanaan";
                break;
            case "Kalah dan Cancel":
                $stage = [0, 7];
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Tender Diikuti":
                $stage = [4, 5];
                $column_to_sort = "bulan_pelaksanaan";
                break;

            case "Menang":
                $is_menang = true;
                $stage = [6, 8];
                $column_to_sort = "bulan_pelaksanaan";
                break;
        }
        if (is_array($stage) && $stage != null) {
            $proyeks = $proyeks->whereIn("stage", $stage)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        } elseif ($stage != null) {
            $proyeks = $proyeks->where("stage", "=", $stage)->sortBy($column_to_sort, SORT_NUMERIC)->values();
        }

        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $is_menang) {
            if ($p->tipe_proyek == "R") {
                $nilai_forecast = $p->forecasts->sortBy("month_realisasi");
                $niai_realisasi = $nilai_forecast->sum(function ($f) {
                    return (int) $f->realisasi_forecast;
                });
                $nilai_forecast = $p->forecasts->sortBy("month_realisasi")->last() ?? null;
                if (!empty($nilai_forecast) && $nilai_forecast->realisasi_forecast != 0 && $nilai_forecast->realisasi_forecast != '') {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($nilai_forecast->month_realisasi));
                    $sheet->setCellValue('G' . $row, $niai_realisasi);
                    $row++;
                }
            } else {
                if ($is_menang && ($p->nilai_perolehan != 0 || !empty($p->nilai_perolehan))) {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Non-Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_ri_perolehan));
                    $sheet->setCellValue('G' . $row, $p->nilai_perolehan);
                    $row++;
                } else if ($p->hps_pagu != 0) {
                    $sheet->setCellValue('A' . $row, $p->nama_proyek);
                    $sheet->setCellValue('B' . $row, $p->status_pasdin);
                    $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
                    $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
                    $sheet->setCellValue('E' . $row, "Non-Retail");
                    $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_pelaksanaan));
                    $sheet->setCellValue('G' . $row, $p->hps_pagu);
                    $row++;
                }
            }
        });
        $writer = new Xlsx($spreadsheet);
        $file_name = "$tipe-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "periode" => $prognosa, "data" => $proyeks]);
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
        $sheet->setCellValue('E1', 'Tipe Proyek');
        $sheet->setCellValue('F1', 'Bulan');
        $sheet->setCellValue('G1', "Nilai $tipe");

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if (!Auth::user()->check_administrator) {
            if ($filter != false) {
                // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);
                $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) date("m"))->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) date("m"))->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"])->where("unit_kerja", $unit_kerja_user);
                    $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) date("m"))->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        // } else {
        //     $proyeks = Forecast::join("proyeks", "proyeks.kode_proyek", "=", "forecasts.kode_proyek")->where("jenis_proyek", "!=", "I")->where("forecasts.periode_prognosa", "=", (int) date("m"))->get()->whereNotIn("unit_kerja", ["B", "C", "D", "8"]);
            // $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu", "bulan_ri_perolehan", "tipe_proyek"]);
        }
        
        // $proyeks = $proyeks->filter(function ($p) {
        //     return $p->Forecasts->filter(function ($f) {
        //         return $f->periode_prognosa == (int) date("m");
        //     });
        // });
        $stage = null;
        switch ($tipe) {
            case "Terendah":
                $proyeks = $proyeks->filter(function ($p) {
                    return ($p->stage == 5 && $p->peringkat_wika == "Peringkat 1") || $p->stage == 6 || $p->stage == 9;
                });
                break;
            case "Terkontrak":
                $stage = 8;
                $proyeks = $proyeks->where("stage", "=", $stage)->where("is_cancel", "!=", true);
                break;
        }
        $row = 2;
        $proyeks = $proyeks->groupBy("kode_proyek");
        $proyeks = $proyeks->map(function ($p) use ($tipe) {
            $new_class = new stdClass();
            $new_class->nilai_perolehan = 0;
            $new_class->kode_proyek = $p->first()->kode_proyek;
            $new_class->nama_proyek = $p->first()->nama_proyek;

            if ($tipe == "Terendah") {
                $new_class->nilai_perolehan = (int) $p->sum(function ($f) {
                    if (!empty($f->month_forecast)) {
                        return (int) $f->nilai_forecast;
                    }
                });
            } else {
                $new_class->nilai_perolehan = (int) $p->sum(function ($f) {
                    if (!empty($f->month_realisasi)) {
                        return (int) $f->realisasi_forecast;
                    }
                });
                // if (!empty($p->month_realisasi)) {
                //     $new_class->nilai_perolehan += (int) $p->realisasi_forecast;
                // }
            }

            if ($p->first()->tipe_proyek == "R") {
                $new_class->tipe_proyek = "Retail";
                $new_class->bulan_pelaksanaan = $p->last()->bulan_pelaksanaan;
                $new_class->bulan_ri_perolehan = $p->last()->bulan_ri_perolehan;
            } else {
                $new_class->bulan_pelaksanaan = $p->last()->bulan_pelaksanaan;
                $new_class->bulan_ri_perolehan = $p->last()->bulan_ri_perolehan;
                $new_class->tipe_proyek = "Non-Retail";
            }
            $new_class->unitKerja = UnitKerja::find($p->first()->unit_kerja)->unit_kerja;
            // $new_class->unitKerja = $p->first()->unit_kerja;
            $new_class->stage = $p->first()->stage;
            $new_class->status_pasdin = $p->first()->status_pasdin;

            return $new_class;
            // return $kp->map(function($p) use($tipe) {
            // });
        })->where("nilai_perolehan", "!=", 0)->each(function ($p) use ($sheet, &$row, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $p->unitKerja);
            $sheet->setCellValue('E' . $row, $p->tipe_proyek);
            if ($tipe == "Terendah") {
                $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_pelaksanaan));
                $p->bulan = $p->bulan_pelaksanaan;
            } else {
                $sheet->setCellValue('F' . $row, $this->getFullMonth($p->bulan_ri_perolehan));
                $p->bulan = $p->bulan_ri_perolehan;
            }
            $sheet->setCellValue('G' . $row, $p->nilai_perolehan);
            $row++;
            // return $kp->each(function ($p) use ($sheet, &$row, $tipe) {
            // });
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
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            }
        }
        $proyeks = $proyeks->where("is_cancel", "=", false);
        switch ($tipe) {
            case "Proyek Menang Tender":
                $proyeks = $proyeks->whereIn("stage", [6, 8])->sortBy([
                    ["bulan_pelaksanaan", "asc"],
                ])->values()->where("nilai_perolehan", "!=", 0);
                break;
            case "Proyek Kalah Tender":
                $proyeks = $proyeks->where(function ($p) {
                    return $p->stage == 7;
                })->sortBy("bulan_pelaksanaan")->values()->where("hps_pagu", "!=", 0);
                break;
        }
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            if ($tipe == "Proyek Menang Tender") {
                $sheet->setCellValue('E' . $row, $p->bulan_ri_perolehan);
                $sheet->setCellValue('F' . $row, $p->nilai_perolehan);
            } else {
                $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
                $sheet->setCellValue('F' . $row, $p->hps_pagu);
            }
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
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            } else {
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"])->where("unit_kerja", $unit_kerja_user);
                }
            }
        } else {
            if ($filter != false) {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->where("unit_kerja", "=", $filter)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            } else {
                $proyeks = Proyek::with(["UnitKerja", "Forecasts"])->where("jenis_proyek", "!=", "I")->where("tipe_proyek", "!=", "R")->where("is_cancel", "!=", true)->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "bulan_ri_perolehan", "nilai_perolehan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "hps_pagu"]);
            }
        }
        $stage = null;
        switch ($tipe) {
            case "Nilai Menang Tender":
                $proyeks = $proyeks->whereIn("stage", [6, 8])->sortBy("bulan_pelaksanaan", SORT_NUMERIC)->values()->where("nilai_perolehan", "!=", 0);
                break;
            case "Nilai Kalah Tender":
                $stage = 7;
                $proyeks = $proyeks->where("stage", "=", $stage)->sortBy("bulan_pelaksanaan", SORT_NUMERIC)->values()->where("hps_pagu", "!=", 0);
                break;
        }
        // dd($proyeks);
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $tipe) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $p->status_pasdin);
            $sheet->setCellValue('C' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('D' . $row, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue('E' . $row, $p->bulan_pelaksanaan);
            switch ($tipe) {
                case "Nilai Menang Tender":
                    $sheet->setCellValue('F' . $row, $p->nilai_perolehan);
                    break;
                case "Nilai Kalah Tender":
                    $sheet->setCellValue('F' . $row, $p->hps_pagu);
                    break;
            }
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
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                }
            } else {
                if($tipe == "Retail") {
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                } else {
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                }
            }
        } else {
            if($tipe == "Retail") {
                $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            } else {
                $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            }
        }
        if($tipe != "Retail") {
            $proyeks = $proyeks->filter(function($p) use($tipe_real) {
                return !empty($p->SumberDana) && $p->SumberDana->kategori == $tipe_real;
            })->sortBy("nilai_rkap", SORT_REGULAR, true)->values();
        } else {
            $proyeks = $proyeks->map(function($p) {
                $new_p = new stdClass();
                $new_p->nama_proyek = $p->nama_proyek;
                $new_p->stage = $p->stage;
                $new_p->unit_kerja = $p->unit_kerja;
                $new_p->nilai_rkap = $p->Forecasts->filter(function($f) {
                    return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
                })->sum(function($f) {
                    return (int) $f->rkap_forecast;
                });
                return $new_p;
            })->sortByDesc("nilai_rkap")->values();
        }


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
                // $proyeks = Proyek::with("UnitKerja")->where("unit_kerja", "=", $filter)->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
                if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                    $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                } else {
                    $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                }
            } else {
                if($tipe == "Retail") {
                    // $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                } else {
                    if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->whereIn("unit_kerja", $unit_kerja_user->toArray());
                    } else {
                        $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "!=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_perolehan", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"])->where("unit_kerja", $unit_kerja_user);
                    }
                }
            }
        } else {
            if($tipe == "Retail") {
                $proyeks = Proyek::with("UnitKerja")->where("tipe_proyek", "=", "R")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            } else {
                $proyeks = Proyek::with("UnitKerja")->get(["peringkat_wika", "nama_proyek", "kode_proyek", "bulan_awal", "bulan_pelaksanaan", "nilai_rkap", "status_pasdin", "stage", "unit_kerja", "penawaran_tender", "sumber_dana"]);
            }        
        }

        if($tipe != "Retail") {
            $proyeks = $proyeks->filter(function($p) use($tipe_real) {
                return !empty($p->SumberDana) && $p->SumberDana->kategori == $tipe_real;
            })->sortByDesc("nilai_perolehan", SORT_REGULAR, true)->values();
        } else {
            $proyeks = $proyeks->map(function($p) {
                $new_p = new stdClass();
                $new_p->nama_proyek = $p->nama_proyek;
                $new_p->stage = $p->stage;
                $new_p->unit_kerja = $p->unit_kerja;
                $new_p->nilai_perolehan = $p->Forecasts->filter(function($f) {
                    return $f->tahun == (int) date("Y") && $f->periode_prognosa == (int) date("m");
                })->sum(function($f) {
                    return (int) $f->realisasi_forecast;
                });
                return $new_p;
            })->sortByDesc("nilai_perolehan")->values();
        }
        
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

    public function getDataNilaiOK($tipe, $filter = "")
    {
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
            $p->Forecasts->each(function ($f) use (&$nilaiRKAP) {
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

    public function getDataNilaiRealisasi($tipe, $filter = "")
    {
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
            $p->Forecasts->each(function ($f) use (&$nilaiRealisasi) {
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


    public static function getFullMonth($month)
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

    static function copyDataForecast()
    {
        $month = (int) date("m");
        $year = (int) date("Y");
        $is_forecasts_exist = Forecast::where("periode_prognosa", "=", $month)->whereYear("created_at", "=", $year)->get()->count() > 0 ? true : false;
        if (!$is_forecasts_exist) {
            if ($month == 1) {
                $forecasts = Forecast::where("periode_prognosa", "=", $month + 11)->whereYear("created_at", "=", $year - 1)->get();
            } else {
                $forecasts = Forecast::where("periode_prognosa", "=", $month - 1)->whereYear("created_at", "=", $year)->get();
            }
            // dd($forecasts);
            $forecasts->each(function ($f) use ($month) {
                $new_forecast = $f->replicate();
                // dd($f);
                $new_forecast->created_at = now();
                $new_forecast->updated_at = now();
                $new_forecast->periode_prognosa = $month;
                $new_forecast->save();
                // dd($new_forecast);
            });
        }
    }

    static function deleteOldExcelFiles()
    {
        $files = collect(File::allFiles(public_path("excel")));
        $files->each(function ($file) {
            $now = Carbon::now();
            $file_date = Carbon::createFromTimestamp($file->getMTime());
            $diff_date = $file_date->diffInMinutes($now, true);
            if ($diff_date > 29) File::delete($file);
        });
    }
}
