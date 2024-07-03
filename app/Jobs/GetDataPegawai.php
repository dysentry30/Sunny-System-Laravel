<?php

namespace App\Jobs;

use App\Models\Pegawai;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetDataPegawai implements ShouldQueue
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
        try {
            $totalData = 0;
            $totalDataUpdate = 0;
            $totalDataCreate = 0;
            for ($i = 1; $i < 300; $i++) {
                $data = Http::withOptions([
                    "verify" => false,
                    // "debug" => $test_debug
                ])->timeout(60)->get("https://hcms.wika.co.id/apiwika/?method=get_pegawai&key=93hDk1L&client=crm&page=$i");
                // setLogging("api", "GET DATA PEGAWAI => ", [$data->json()]);
                $response = json_decode($data->body(), true);
                if ($data->ok() && !empty($data->body()) && $response["status"] == 200) {
                    $totalData += $data->json()["total_seluruh_data"];
                    $pegawaiData = collect($data->json()["data"]);
                    if (!empty($pegawaiData)) {
                        $pegawaiData->where('active', '!=', "0")->each(function ($pegawai) use (&$totalDataUpdate, &$totalDataCreate) {
                            $is_pegawai_exist = Pegawai::where('nip', $pegawai["nip"])->first();
                            // dd($is_pegawai_exist, $pegawai);
                            if (!empty($is_pegawai_exist)) {
                                $is_pegawai_exist->nip = $pegawai["nip"] ?? null;
                                $is_pegawai_exist->nama_pegawai = $pegawai["nm_peg"] ?? null;
                                $is_pegawai_exist->handphone = $pegawai["telepon"] ?? null;
                                $is_pegawai_exist->email = $pegawai["email"] ?? null;
                                // $is_pegawai_exist->kode_jabatan = (int)$pegawai["kd_kantor"] ?? null;
                                $is_pegawai_exist->kode_jabatan_sap = (int)$pegawai["kd_jabatan"] ?? null;
                                $is_pegawai_exist->kode_fungsi_bidang_sap = (int)$pegawai["kd_fungsi_bidang"];
                                // $is_pegawai_exist->kode_fungsi_bidang = (int)$pegawai["kd_posisi"] ?? null;
                                $is_pegawai_exist->nama_fungsi_bidang = $pegawai["nm_fungsi_bidang"] ?? null;
                                $is_pegawai_exist->kode_kantor_sap = $pegawai["kd_kantor"] ?? null;
                                $is_pegawai_exist->nama_kantor = $pegawai["nm_kantor"] ?? null;
                                $is_pegawai_exist->kd_posisi = $pegawai["kd_posisi"] ?? null;
                                $is_pegawai_exist->posisi = $pegawai["posisi"] ?? null;
                                $is_pegawai_exist->save();
                                $totalDataUpdate++;
                            } else {
                                $new_pegawai = new Pegawai();
                                $new_pegawai->nip = $pegawai["nip"] ?? null;
                                $new_pegawai->nama_pegawai = $pegawai["nm_peg"] ?? null;
                                $new_pegawai->handphone = $pegawai["telepon"] ?? null;
                                $new_pegawai->email = $pegawai["email"] ?? null;
                                // $new_pegawai->kode_jabatan = (int)$pegawai["kd_kantor"] ?? null;
                                $new_pegawai->kode_jabatan_sap = (int)$pegawai["kd_jabatan"] ?? null;
                                $new_pegawai->kode_fungsi_bidang_sap = (int)$pegawai["kd_fungsi_bidang"];
                                // $new_pegawai->kode_fungsi_bidang = (int)$pegawai["kd_posisi"] ?? null;
                                $new_pegawai->nama_fungsi_bidang = $pegawai["nm_fungsi_bidang"] ?? null;
                                $new_pegawai->kode_kantor_sap = $pegawai["kd_kantor"] ?? null;
                                $new_pegawai->nama_kantor = $pegawai["nm_kantor"] ?? null;
                                $new_pegawai->kd_posisi = $pegawai["kd_posisi"] ?? null;
                                $new_pegawai->posisi = $pegawai["posisi"] ?? null;
                                $new_pegawai->save();
                                $totalDataCreate++;
                            }
                        });
                    } else {
                        setLogging("api", "GET PEGAWAI => ", ["message" => "FETCH DATA IS SUCCESSFULY", "total_data" => $totalData, "new_data" => $totalDataCreate, "update_data" => $totalDataUpdate]);
                        break;
                    }
                } else {
                    setLogging("api", "GET PEGAWAI => ", ["message" => "API GET PEGAWAI FROM HCMS ERROR"]);
                    break;
                }
            }
        } catch (\Exception $e) {
            setLogging("api", "ERROR GET PEGAWAI => ", ["message" => $e->getMessage()]);
            // return response()->json([
            //     "success" => false,
            //     "message" => $e->getMessage()
            // ]);
            // dd($e->getMessage());
        }
    }
}
