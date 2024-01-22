<?php

use App\Models\Pegawai;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('pegawai:get', function () {
    try {
        for ($i = 1; $i < 100; $i++) {
            $data = Http::withOptions([
                "verify" => false
                // "debug" => $test_debug
            ])->get("https://hcms.wika.co.id/apiwika/?method=get_pegawai&key=93hDk1L&client=crm&page=$i");
            setLogging("api", "GET DATA PEGAWAI => ", [$data->json()]);
            $response = json_decode($data->body(), true);
            if ($data->ok() && !empty($data->body()) && $response["status"] == 200) {
                $pegawaiData = collect($data->json()["data"])->where('active', '!=', 0);
                if (!empty($pegawaiData)) {
                    $pegawaiData->each(function ($pegawai) use ($i) {
                        $is_pegawai_exist = Pegawai::where('nip', $pegawai["nip"])->first();
                        if (!empty($is_pegawai_exist)) {
                            $is_pegawai_exist->nip = (int) $pegawai["nip"] ?? null;
                            $is_pegawai_exist->nama_pegawai = (int) $pegawai["nm_peg"] ?? null;
                            $is_pegawai_exist->handphone = $pegawai["telepon"] ?? null;
                            $is_pegawai_exist->email = $pegawai["email"] ?? null;
                            $is_pegawai_exist->kode_jabatan = (int)$pegawai["kd_kantor"] ?? null;
                            $is_pegawai_exist->kode_jabatan_sap = (int)$pegawai["kd_jabatan"] ?? null;
                            $is_pegawai_exist->kode_fungsi_bidang_sap = (int)$pegawai["kd_fungsi_bidang"];
                            $is_pegawai_exist->kode_fungsi_bidang = (int)$pegawai["kd_posisi"] ?? null;
                            $is_pegawai_exist->nama_fungsi_bidang = $pegawai["nm_fungsi_bidang"] ?? null;
                            $is_pegawai_exist->kode_kantor_sap = $pegawai["cmp_id"] ?? null;
                            $is_pegawai_exist->nama_kantor = $pegawai["jns_kantor"] ?? null;
                            $is_pegawai_exist->save();
                        } else {
                            $new_pegawai = new Pegawai();
                            $new_pegawai->nip = (int) $pegawai["nip"] ?? null;
                            $new_pegawai->nama_pegawai = (int) $pegawai["nm_peg"] ?? null;
                            $new_pegawai->handphone = $pegawai["telepon"] ?? null;
                            $new_pegawai->email = $pegawai["email"] ?? null;
                            $new_pegawai->kode_jabatan = (int)$pegawai["kd_kantor"] ?? null;
                            $new_pegawai->kode_jabatan_sap = (int)$pegawai["kd_jabatan"] ?? null;
                            $new_pegawai->kode_fungsi_bidang_sap = (int)$pegawai["kd_fungsi_bidang"];
                            $new_pegawai->kode_fungsi_bidang = (int)$pegawai["kd_posisi"] ?? null;
                            $new_pegawai->nama_fungsi_bidang = $pegawai["nm_fungsi_bidang"] ?? null;
                            $new_pegawai->kode_kantor_sap = $pegawai["cmp_id"] ?? null;
                            $new_pegawai->nama_kantor = $pegawai["jns_kantor"] ?? null;
                            $new_pegawai->save();
                        }
                        dd([
                            "count" => $i,
                            "success" => true,
                            "status" => "Success"
                        ]);
                    });
                } else {
                    dd([
                        "count" => $i,
                        "success" => false,
                        "status" => "Error",
                        "message" => "Data Not Found"
                    ]);
                    break;
                }
            } else {
                dd([
                    "count" => $i,
                    "success" => false,
                    "status" => "Error",
                    "message" => "Internal Server Error"
                ]);
                break;
            }
        }
    } catch (Exception $e) {
        dd([
            "count" => $i,
            "success" => false,
            "status" => "Error",
            "message" => $e->getMessage()
        ]);
        // dd($e->getMessage());
    }
});
