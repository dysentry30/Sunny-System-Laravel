<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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
        $count = 0;
        for ($i = 1; $i < 300; $i++) {
            $data = Http::withOptions([
                "verify" => false
                // "debug" => $test_debug
            ])->get("https://hcms.wika.co.id/apiwika/?method=get_pegawai&key=93hDk1L&client=crm&page=$i");
            $response = json_decode($data->body(), true);
            if ($data->ok() && !empty($data->body()) && $response["status"] == 200) {
                $pegawaiData = collect($data->json()["data"])->where('active', '!=', 0);
                if (!empty($pegawaiData)) {
                    $pegawaiData->each(function ($pegawai) use ($i, $count) {
                        setLogging("api", "GET DATA PEGAWAI => ", [$pegawai]);
                        $is_pegawai_exist = Pegawai::where('nip', $pegawai["nip"])->first();
                        if (!empty($is_pegawai_exist)) {
                            $is_pegawai_exist->nama_pegawai = $pegawai["nm_peg"] ?? null;
                            $is_pegawai_exist->handphone = $pegawai["telepon"] ?? null;
                            $is_pegawai_exist->email = $pegawai["email"] ?? null;
                            $is_pegawai_exist->save();
                        } else {
                            $new_pegawai = new Pegawai();
                            $new_pegawai->nip = $pegawai["nip"] ?? null;
                            $new_pegawai->nama_pegawai = $pegawai["nm_peg"] ?? null;
                            $new_pegawai->handphone = $pegawai["telepon"] ?? null;
                            $new_pegawai->email = $pegawai["email"] ?? null;
                            // $new_pegawai->kode_jabatan = (int)$pegawai["kd_kantor"] ?? null;
                            $new_pegawai->kode_jabatan_sap = (int)$pegawai["kd_jabatan"] ?? null;
                            $new_pegawai->kode_fungsi_bidang_sap = (int)$pegawai["kd_fungsi_bidang"];
                            $new_pegawai->kode_fungsi_bidang = (int)$pegawai["kd_posisi"] ?? null;
                            $new_pegawai->nama_fungsi_bidang = $pegawai["nm_fungsi_bidang"] ?? null;
                            $new_pegawai->kode_kantor_sap = $pegawai["kd_kantor"] ? 'A' . $pegawai["kd_kantor"] : null;
                            $new_pegawai->nama_kantor = $pegawai["jns_kantor"] ?? null;
                            $new_pegawai->save();
                        }
                        dump([
                            "page" => $i,
                            "count" => $count++,
                            "success" => true,
                            "status" => "Success"
                        ]);
                    });
                } else {
                    dump([
                        "page" => $i,
                        "count" => $count,
                        "success" => false,
                        "status" => "Error",
                        "message" => "Data Not Found"
                    ]);
                    break;
                }
            } else {
                dump([
                    "page" => $i,
                    "count" => $count,
                    "success" => false,
                    "status" => "Error",
                    "message" => "Internal Server Error"
                ]);
                break;
            }
        }
    } catch (Exception $e) {
        dump([
            "page" => $i,
            "count" => $count,
            "success" => false,
            "status" => "Error",
            "message" => $e->getMessage()
        ]);
        // dd($e->getMessage());
    }
});