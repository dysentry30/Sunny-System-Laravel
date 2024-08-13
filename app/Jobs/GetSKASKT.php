<?php

namespace App\Jobs;

use App\Models\IntegrationLog;
use App\Models\SKASKTProyek;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetSKASKT implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $limit = 20;

        $jumlahInsert = 0;
        $totalData = 0;

        $url = 'https://hcms.wika.co.id/apiwika/?method=get_sertifikat&client=crm&key=aksesaku&page=';
        // $url = 'https://hcms-dev.wika.co.id/apiwika/?method=get_sertifikat&client=crm&key=aksesaku&page='; //DEV

        DB::beginTransaction();

        try {
            for ($i = 0; $i < $limit; $i++) {

                $response = Http::withOptions([
                    "verify" => false
                ])->timeout(60)->get($url . $i);

                $newLog = new IntegrationLog();
                $newLog->category = "SKA SKT";
                $newLog->request_body = '[]';
                $newLog->response_header = collect($response->headers())->toJson();

                if ($response->successful()) {
                    $collect = $response->collect();
                    $data = collect($collect['data']);

                    if ($data->count() < 1) {
                        break;
                    }

                    $totalData = $totalData + $collect['total_seluruh_data'];

                    $data->each(function ($item) use (&$jumlahInsert) {
                        $isExistSKASKT = SKASKTProyek::where('nip', $item['nip'])?->where('no_sertifikat', $item['no_sertifikat'])->first();

                        if (!empty($isExistSKASKT)) {
                            $isExistSKASKT->emp_name = $item['emp_name'];
                            $isExistSKASKT->nm_fungsi_bidang = $item['nm_fungsi_bidang'];
                            $isExistSKASKT->no_sertifikat = $item['no_sertifikat'];
                            $isExistSKASKT->nama_sertifikat = $item['nama_sertifikat'];
                            $isExistSKASKT->institusi_penerbit_sertifikat = $item['institusi_penerbit_sertifikat'];
                            $isExistSKASKT->category_sertifikat = $item['category_sertifikat'];
                            $isExistSKASKT->issued_date = Carbon::create($item['issued_date']);
                            $isExistSKASKT->expired_date = Carbon::create($item['expired_date']);
                            $isExistSKASKT->emp_position = $item['emp_position'];
                            $isExistSKASKT->emp_position_name = $item['emp_position_name'];
                            $isExistSKASKT->emp_og_unit = $item['emp_og_unit'];
                            $isExistSKASKT->emp_og_unit_name = $item['emp_og_unit_name'];
                            $isExistSKASKT->level_sertifikat = $item['level_sertifikat'];
                            $isExistSKASKT->file_sertifikat = $item['file_sertifikat'];
                            $isExistSKASKT->status_kepegawaian = $item['status_kepegawaian'];
                            $isExistSKASKT->emp_start_date = $item['emp_start_date'];
                            $isExistSKASKT->emp_end_date = $item['emp_start_date'];
                            $isExistSKASKT->save();
                        } else {
                            $newSKASKT = new SKASKTProyek();
                            $newSKASKT->nip = $item['nip'];
                            $newSKASKT->emp_name = $item['emp_name'];
                            $newSKASKT->nm_fungsi_bidang = $item['nm_fungsi_bidang'];
                            $newSKASKT->no_sertifikat = $item['no_sertifikat'];
                            $newSKASKT->nama_sertifikat = $item['nama_sertifikat'];
                            $newSKASKT->institusi_penerbit_sertifikat = $item['institusi_penerbit_sertifikat'];
                            $newSKASKT->category_sertifikat = $item['category_sertifikat'];
                            $newSKASKT->issued_date = Carbon::create($item['issued_date']);
                            $newSKASKT->expired_date = Carbon::create($item['expired_date']);
                            $newSKASKT->emp_position = $item['emp_position'];
                            $newSKASKT->emp_position_name = $item['emp_position_name'];
                            $newSKASKT->emp_og_unit = $item['emp_og_unit'];
                            $newSKASKT->emp_og_unit_name = $item['emp_og_unit_name'];
                            $newSKASKT->level_sertifikat = $item['level_sertifikat'];
                            $newSKASKT->file_sertifikat = $item['file_sertifikat'];
                            $newSKASKT->status_kepegawaian = $item['status_kepegawaian'];
                            $newSKASKT->emp_start_date = $item['emp_start_date'];
                            $newSKASKT->emp_end_date = $item['emp_start_date'];
                            if ($newSKASKT->save()) {
                                $jumlahInsert++;
                            }
                        }

                        // $newSKASKT = new SKASKTProyek();
                        // $newSKASKT->nip = $item['nip'];
                        // $newSKASKT->emp_name = $item['emp_name'];
                        // $newSKASKT->nm_fungsi_bidang = $item['nm_fungsi_bidang'];
                        // $newSKASKT->no_sertifikat = $item['no_sertifikat'];
                        // $newSKASKT->nama_sertifikat = $item['nama_sertifikat'];
                        // $newSKASKT->institusi_penerbit_sertifikat = $item['institusi_penerbit_sertifikat'];
                        // $newSKASKT->category_sertifikat = $item['category_sertifikat'];
                        // $newSKASKT->issued_date = Carbon::create($item['issued_date']);
                        // $newSKASKT->expired_date = Carbon::create($item['expired_date']);
                        // //Baru
                        // $newSKASKT->emp_position = $item['emp_position'];
                        // $newSKASKT->emp_position_name = $item['emp_position_name'];
                        // $newSKASKT->emp_og_unit = $item['emp_og_unit'];
                        // $newSKASKT->emp_og_unit_name = $item['emp_og_unit_name'];
                        // $newSKASKT->level_sertifikat = $item['level_sertifikat'];
                        // $newSKASKT->file_sertifikat = $item['file_sertifikat'];
                        // $newSKASKT->status_kepegawaian = $item['status_kepegawaian'];
                        // $newSKASKT->emp_start_date = $item['emp_start_date'];
                        // $newSKASKT->emp_end_date = $item['emp_start_date'];
                        // if ($newSKASKT->save()) {
                        //     $jumlahInsert++;
                        // }
                    });

                    $newLog->status = 'success';
                    $newLog->status_code = $collect['status'];
                    $newLog->response_body = $response->body();

                    $newLog->save();
                }
            }

            DB::commit();

            setLogging("api", "GET SKA SKT SUCCESS => ", ["message" => "Get Data Success. Total Data Baru Masuk :  $jumlahInsert"]);
        } catch (\Exception $e) {
            DB::rollBack();
            setLogging("api", "GET SKA SKT ERROR => ", ["message" => $e->getMessage()]);
            // return response()->json([
            //     'Success' => true,
            //     'Message' => $e->getMessage()
            // ]);
        }
    }
}
