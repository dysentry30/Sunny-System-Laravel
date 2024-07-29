<?php

namespace App\Console\Commands;

use App\Models\Forecast;
use App\Models\HistoryForecast;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScheduleOtorisasiForecastAnak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:forecast-anak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduller for Automatically Otorisasi Forecasts every first date of month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $dateStart = Carbon::now()->translatedFormat("d F Y H:i:s");
            sendNotifEmail("andias@wikamail.id", "RUNNING JOB OTORISASI FORECAST", "Otorisasi otomatis sedang dijalankan pada hari : $dateStart", true, false);
            sendNotifEmail("fathur.rohman2353@gmail.com", "RUNNING JOB OTORISASI FORECAST", "Otorisasi otomatis sedang dijalankan pada hari : $dateStart", true, false);
            // if (date('d') == 1 && date("m") != 1) {
            $historyForecast = HistoryForecast::join("proyeks", "history_forecast.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", date("m") - 1)->where("tahun", date("Y"))->get();
            $forecastReal = Forecast::join("proyeks", "forecasts.kode_proyek", "=", "proyeks.kode_proyek")->where("periode_prognosa", date("m") - 1)->where("tahun", date("Y"))->get();

            $historyGroup = $historyForecast->groupBy('unit_kerja');

            $unitKerja = UnitKerja::where("id_profit_center", "!=", null)->where("dop", "EA")->where("divcode", "!=", 8)->get()->groupBy("divcode")->keys();

            if ($historyGroup->isNotEmpty() && $historyGroup->keys()->count() != $unitKerja->count()) {
                $historyUnitKerja = $historyGroup->keys();
                $unitKerja = $unitKerja->filter(function ($data) use ($historyUnitKerja) {
                    return !in_array($data, $historyUnitKerja->toArray());
                });
            }

            $forecastReal = $forecastReal->whereIn("unit_kerja", $unitKerja->toArray());

            $farestMonth = 0;
            $total_forecast = 0;
            $total_realisasi = 0;
            $total_rkap = 0;

            $resultRequestToSAP = collect([]);


            if ($forecastReal->count() > 0) {
                $forecastGroupUnitKerja = $forecastReal->groupBy("unit_kerja");

                foreach ($forecastGroupUnitKerja as $unitKerja => $dataForecast) {
                    $unitKerjaProyek = UnitKerja::where("divcode", $unitKerja)->first();
                    $forecastGroupProyek = $dataForecast->groupBy("kode_proyek");

                    foreach ($forecastGroupProyek as $kode_proyek => $forecasts) {
                        $current_proyek = Proyek::find($kode_proyek);

                        if ($current_proyek->tipe_proyek == "R") {
                            $history_forecast_count = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->where("periode_prognosa", "=", date("m") - 1)->where("tahun", "=", date("Y"))->get();
                            if ($history_forecast_count->count() > 0) continue;
                            // dd($current_proyek);
                            foreach ($forecasts as $forecast) {
                                $history_forecast = new HistoryForecast();
                                $history_forecast->kode_proyek = $kode_proyek;
                                if ($forecast->is_cancel == true) {
                                    $history_forecast->nilai_forecast = "0";
                                    $history_forecast->realisasi_forecast = "0";
                                } else if ($current_proyek->stage < 8) {
                                    $history_forecast->nilai_forecast = $forecast->nilai_forecast ?? "0";
                                    $history_forecast->realisasi_forecast = "0";
                                } else {
                                    //Menyamakan nilai realisasi dengan forecast apabila sudah masuk realisasi
                                    if (($forecast->periode_prognosa == $forecast->month_realisasi)) {
                                        $forecast->nilai_forecast = $forecast->realisasi_forecast;

                                        $history_forecast->nilai_forecast = $forecast->realisasi_forecast ?? "0";
                                        $history_forecast->realisasi_forecast = $forecast->realisasi_forecast ?? "0";
                                    } else {
                                        $history_forecast->nilai_forecast = $forecast->nilai_forecast ?? "0";
                                        $history_forecast->realisasi_forecast = $forecast->realisasi_forecast ?? "0";
                                    }
                                }

                                $history_forecast->month_forecast = $forecast->month_forecast;

                                if (!empty($forecast->rkap_forecast)) {
                                    $history_forecast->rkap_forecast = $forecast->rkap_forecast ?? "0";
                                } else {
                                    $history_forecast->rkap_forecast = "0";
                                }
                                $history_forecast->month_rkap = (int) $forecast->month_rkap;
                                $history_forecast->month_realisasi = $forecast->month_realisasi;
                                $history_forecast->periode_prognosa = (int) date("m") - 1;
                                $history_forecast->tahun = (int) date("Y");

                                $history_forecast->is_approved_1 = 't';
                                $history_forecast->is_request_unlock = null;
                                $history_forecast->stage = $current_proyek->stage;

                                $forecast->save();
                                $history_forecast->save();
                            }
                        } else {

                            $history_forecast_count = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->where("periode_prognosa", "=", date("m") - 1)->where("tahun", "=", date("Y"))->get();
                            if ($history_forecast_count->count() > 0) continue;
                            $history_forecast = new HistoryForecast();

                            foreach ($forecasts as $forecast) {
                                if ($forecast->month_forecast > $farestMonth) {
                                    $farestMonth = $forecast->month_forecast;
                                }
                                if ($forecast->is_cancel == true) {
                                    $total_forecast += (int) 0;
                                    $total_realisasi += (int) 0;
                                } else {
                                    $total_realisasi += (int) $forecast->realisasi_forecast;
                                    $total_forecast += (int) $forecast->nilai_forecast ?? 0;
                                }

                                $total_rkap += (int) $forecast->rkap_forecast ?? 0;
                            }

                            // RKAP, REALISASI
                            $history_forecast->kode_proyek = $kode_proyek;
                            $history_forecast->nilai_forecast = (string) $total_forecast;
                            $history_forecast->month_forecast = $farestMonth;
                            $history_forecast->rkap_forecast = (string) $total_rkap;
                            $history_forecast->month_rkap = (int) $current_proyek->bulan_pelaksanaan ?? 1;

                            if ($current_proyek->stage == 8) {
                                $history_forecast->realisasi_forecast = $total_realisasi;
                                $history_forecast->month_realisasi = $forecast->month_realisasi ?? 0;
                            }
                            $history_forecast->periode_prognosa = (int) date("m") - 1;
                            $history_forecast->tahun = (int) date("Y");

                            $history_forecast->is_approved_1 = 't';
                            $history_forecast->is_request_unlock = null;
                            $history_forecast->stage = $current_proyek->stage;

                            if (empty($history_forecast->month_realisasi)) {
                                $history_forecast->realisasi_forecast = 0;
                                $history_forecast->month_realisasi = 0;
                            }

                            $history_forecast->save();
                        }

                        $farestMonth = 0;
                        $total_forecast = 0;
                        $total_realisasi = 0;
                        $total_rkap = 0;

                        foreach ($forecasts as $forecast) {

                            $resultRequestToSAP->push(self::generateRequestSendPrognosaSAP($forecast));

                            //Save Periode Berikutnya
                            if ($forecast->periode_prognosa != 12) {
                                $new_periode_forecast = new Forecast();
                                $new_periode_forecast->kode_proyek = $forecast->kode_proyek;
                                $new_periode_forecast->nilai_forecast = $forecast->nilai_forecast;
                                $new_periode_forecast->month_forecast = $forecast->month_forecast;
                                $new_periode_forecast->rkap_forecast = $forecast->rkap_forecast;
                                $new_periode_forecast->month_rkap = $forecast->month_rkap;
                                $new_periode_forecast->realisasi_forecast = $forecast->realisasi_forecast;
                                $new_periode_forecast->month_realisasi = $forecast->month_realisasi;
                                $new_periode_forecast->periode_prognosa = $forecast->periode_prognosa + 1;
                                $new_periode_forecast->tahun = $forecast->tahun;
                                $new_periode_forecast->save();
                            }
                        }
                    }

                    setLogging("Scheduller/OtorisasiCRM", "[Otorisasi $unitKerjaProyek->unit_kerja Bulan " . Carbon::now() . "]", ["message" => "Success", "timestamp" => Carbon::now()]);
                    self::sendDataPrognosaSAP($resultRequestToSAP);
                }
            }

            DB::commit();
            $dateFinish = Carbon::now()->translatedFormat("d F Y H:i:s");
            sendNotifEmail("andias@wikamail.id", "FINISH RUNNING JOB OTORISASI FORECAST", "Otorisasi otomatis telah selesai dijalankan pada hari : $dateFinish", true, false);
            sendNotifEmail("fathur.rohman2353@gmail.com", "FINISH RUNNING JOB OTORISASI FORECAST", "Otorisasi otomatis telah selesai dijalankan pada hari : $dateFinish", true, false);
            $this->info('The command was successful!');
            return Command::SUCCESS;
            // }
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $dateFinish = Carbon::now()->translatedFormat("d F Y H:i:s");
            sendNotifEmail("andias@wikamail.id", "FAIL RUNNING JOB OTORISASI FORECAST", "Otorisasi otomatis gagal dijalankan pada hari : $dateFinish", true, false);
            sendNotifEmail("fathur.rohman2353@gmail.com", "FAIL RUNNING JOB OTORISASI FORECAST", "Otorisasi otomatis gagal dijalankan pada hari : $dateFinish", true, false);
            setLogging("Scheduller/ErrorOtorisasiCRM", "[Failed Otorisasi Bulan " . Carbon::now() . "]", ["message" => $e->getMessage()]);
            return Command::FAILURE;
        }
    }

    private function generateRequestSendPrognosaSAP($forecast)
    {
        $jenis_proyek = "";
        $cat_project = "";
        switch ($forecast->Proyek->jenis_proyek) {
            case "I":
                $jenis_proyek = "INTERN";
                break;
            case "N":
                $jenis_proyek = "EXTERN";
                break;
            case "J":
                $jenis_proyek = "JO";
                break;
        }
        switch ($forecast->Proyek->tipe_proyek) {
            case "P":
                $cat_project = "Proyek";
                break;
            case "R":
                $cat_project = "Retail";
                break;
        }

        if (strlen($forecast->nama_proyek) <= 60) {
            if ($forecast->stage < 8 || $forecast->Proyek->tipe_proyek == "R") {
                /*
                    ketika proyek bukan retail dan tidak punya bulan prognosa,
                    maka ambil bulan perolehan proyek. Jika proyek itu retail,
                    maka tetap ambil bulan prognosa nya.
                */
                $bulan_perolehan = ($forecast->Proyek->tipe_proyek != "R" && (empty($forecast->month_forecast) || empty($forecast->nilai_forecast))) ? $forecast->bulan_pelaksanaan : $forecast->month_forecast;
                if ((int) $forecast->periode_prognosa <= (int) $forecast->month_forecast) {
                    $data_send_to_sap_prognosa = collect([
                        "/BIC/ZIOCH0008" => (string) $forecast->Proyek->UnitKerja->id_profit_center ?? "",
                        "/BIC/ZIOCH0022" => str_contains($forecast->kode_proyek, "KD") ? DB::table('proyek_code_crm')->where("kode_proyek", "=", $forecast->kode_proyek)->first()->kode_proyek_crm ?? $forecast->kode_proyek : $forecast->kode_proyek,
                        "/BIC/ZIOCH0002" => $forecast->Proyek->UnitKerja->company_code,
                        "/BIC/ZIOCH0098" => (string) $forecast->Proyek->UnitKerja->Departemen?->profit_center_departemen ?? "",
                        "DESCRIPTION" => (string) $forecast->Proyek->nama_proyek,
                        "CAT_FOR_PROJECT" => $cat_project,
                        "STATUS_CONTRACT" => $jenis_proyek,
                        "/BIC/ZIOCH0109" => (int) ($forecast->tahun . str_pad($bulan_perolehan, 2, 0, STR_PAD_LEFT) . str_pad(Carbon::createFromFormat("Y/n/d", "$forecast->tahun/$forecast->periode_prognosa/01")->format("d"), 2, 0, STR_PAD_LEFT)), // Periode
                        "CUSTOMER_CRM" => $forecast->Proyek->proyekBerjalan->customer->name ?? "", // nama customer di customer
                        "CUSTOMER" => $forecast->Proyek->proyekBerjalan->customer->kode_bp ?? "", // kode sap di customer
                        "SBU" => $forecast->Proyek->Sbu->kode_sbu ?? "", // kode sbu di SBU
                        "AMOUNT_PROGNOSA" => (int) $forecast->periode_prognosa <= (int) $forecast->month_forecast ? (int) $forecast->nilai_forecast : 0,
                        // "REPORT_PERIOD" => (int) (date("Y") . str_pad($forecast->periode_prognosa, 3, 0, STR_PAD_LEFT)),
                        "REPORT_PERIOD" => (int) ($forecast->tahun . str_pad($forecast->periode_prognosa, 3, 0, STR_PAD_LEFT)),
                        "VERSION" => "PROG",
                    ]);

                    return $data_send_to_sap_prognosa;
                }
            }

            if (($forecast->stage == 8 || $forecast->tipe_proyek == "R") && !empty($forecast->realisasi_forecast) && (int) $forecast->periode_prognosa == (int) $forecast->month_realisasi) {
                $data_send_to_sap_realisasi = collect([
                    "/BIC/ZIOCH0008" => (string) $forecast->Proyek->UnitKerja->id_profit_center ?? "",
                    "/BIC/ZIOCH0022" => str_contains($forecast->kode_proyek, "KD") ? DB::table('proyek_code_crm')->where("kode_proyek", "=", $forecast->kode_proyek)->first()->kode_proyek_crm ?? $forecast->kode_proyek : $forecast->kode_proyek,
                    "/BIC/ZIOCH0002" => $forecast->Proyek->UnitKerja->company_code,
                    "/BIC/ZIOCH0098" => (string) $forecast->Proyek->UnitKerja->Departemen?->profit_center_departemen ?? "",
                    "DESCRIPTION" => (string) $forecast->Proyek->nama_proyek,
                    "CAT_FOR_PROJECT" => $cat_project,
                    "STATUS_CONTRACT" => $jenis_proyek,
                    "/BIC/ZIOCH0109" => (int) ($forecast->tahun . str_pad($forecast->month_realisasi, 2, 0, STR_PAD_LEFT) . str_pad(Carbon::createFromFormat("Y/n/d", "$forecast->tahun/$forecast->periode_prognosa/01")->format("d"), 2, 0, STR_PAD_LEFT)), // Periode
                    "CUSTOMER_CRM" => $forecast->Proyek->proyekBerjalan->customer->name ?? "", // nama customer di customer
                    "CUSTOMER" => $forecast->Proyek->proyekBerjalan->customer->kode_bp ?? "", // kode sap di customer
                    "SBU" => $forecast->Proyek->Sbu->kode_sbu ?? "", // kode sbu di SBU
                    "AMOUNT_PROGNOSA" => (int) $forecast->periode_prognosa == (int) $forecast->month_realisasi ? (int) $forecast->realisasi_forecast : 0,
                    // "REPORT_PERIOD" => (int) (date("Y") . str_pad($forecast->periode_prognosa, 3, 0, STR_PAD_LEFT)),
                    "REPORT_PERIOD" => (int) ($forecast->tahun . str_pad($forecast->periode_prognosa, 3, 0, STR_PAD_LEFT)),
                    "VERSION" => "ACT",
                ]);
                return $data_send_to_sap_realisasi;
            }
        }
    }

    private function sendDataPrognosaSAP($data)
    {
        $results_response = collect();
        $csrf_token = "";
        $content_location = "";
        // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
        // $http = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022");
        $fp = fopen(storage_path('logs/http_log.log'), 'w+');
        $prognosa_log = fopen(storage_path('logs/prognosa_http_log.log'), 'a');
        $get_token = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/requests");
        $csrf_token = $get_token->header("x-csrf-token");
        $results_response->push($get_token->body());
        $cookie = "";
        collect($get_token->cookies()->toArray())->each(function ($c) use (&$cookie) {
            $cookie .= $c["Name"] . "=" . $c["Value"] . ";";
        });
        fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));

        // SECOND STEP SEND DATA TO BW
        $get_content_location = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/requests");
        $results_response->push($get_content_location->body());
        $content_location = $get_content_location->header("content-location");
        fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));

        $fill_data = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/dataSend?request=$content_location&datapid=1", $data->toArray());
        $results_response->push($fill_data->body());
        fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));


        // FOURTH STEP SEND DATA TO BW
        $closed_request = Http::withOptions(['debug' => $fp])->withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbpc007/requests/$content_location/close");
        $results_response->push($closed_request->body());
        setLogging("prognosa", "Response Prognosa to SAP " . $data["unit_kerja"] . " =>", $results_response->toArray());
        fwrite($prognosa_log, file_get_contents(storage_path("logs/http_log.log")));
        fclose($prognosa_log);
        fclose($fp);
    }
}
