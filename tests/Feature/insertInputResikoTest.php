<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class insertInputResiko extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_input_risk()
    {
        $response = $this->post("/input-risk/upload", [
            "verifikasi" => $this->faker()->text(),
            "id_contract" => $this->faker()->text(),
            "stage" => $this->faker()->text(),
            "kategori" => $this->faker()->text(),
            "kriteria" => $this->faker()->text(),
            "probis_1_2" => $this->faker()->text(),
            "probis_terganggu" => $this->faker()->text(),
            "penyebab" => $this->faker()->text(),
            "resiko_peluang" => $this->faker()->text(),
            "dampak" => $this->faker()->text(),
            "nilai_resiko_r0" => $this->faker()->text(),
            "item_kontrol" => $this->faker()->text(),
            "probabilitas" => $this->faker()->text(),
            "tingkat_efektifitas_kontrol" => $this->faker()->text(),
            "nilai_resiko_r1" => $this->faker()->text(),
            "tindak_lanjut_mitigasi" => $this->faker()->text(),
            "tingkat_efektifitas_tindak_lanjut" => $this->faker()->text(),
            "nilai_resiko_r2" => $this->faker()->text(),
            "biaya_proaktif" => $this->faker()->text(),
            "tanggal_mulai" => now(),
            "tanggal_selesai" => now(),
            "tindak_lanjut_reaktif" => $this->faker()->text(),
            "biaya_reaktif" => $this->faker()->text(),
            "pic_rtl" => $this->faker()->text(),
            "uraian" => $this->faker()->text(),
            "nilai" => $this->faker()->text(),
            "skor" => $this->faker()->text(),
        ]);

        $response->assertStatus(302);
        // $response->assertRedirect(redirect()->back());
    }

    public function test_input_risk_pelaksanaan()
    {
        $response = $this->post("/input-risk/upload", [
            "verifikasi" => $this->faker()->text(),
            "id_contract" => $this->faker()->text(),
            "stage" => $this->faker()->text(),
            "kategori" => $this->faker()->text(),
            "kriteria" => $this->faker()->text(),
            "probis_1_2" => $this->faker()->text(),
            "probis_terganggu" => $this->faker()->text(),
            "penyebab" => $this->faker()->text(),
            "resiko_peluang" => $this->faker()->text(),
            "dampak" => $this->faker()->text(),
            "nilai_resiko_r0" => $this->faker()->text(),
            "item_kontrol" => $this->faker()->text(),
            "probabilitas" => $this->faker()->text(),
            "tingkat_efektifitas_kontrol" => $this->faker()->text(),
            "nilai_resiko_r1" => $this->faker()->text(),
            "tindak_lanjut_mitigasi" => $this->faker()->text(),
            "tingkat_efektifitas_tindak_lanjut" => $this->faker()->text(),
            "nilai_resiko_r2" => $this->faker()->text(),
            "biaya_proaktif" => $this->faker()->text(),
            "tanggal_mulai" => now(),
            "tanggal_selesai" => now(),
            "tindak_lanjut_reaktif" => $this->faker()->text(),
            "biaya_reaktif" => $this->faker()->text(),
            "pic_rtl" => $this->faker()->text(),
            "uraian" => $this->faker()->text(),
            "nilai" => $this->faker()->text(),
            "skor" => $this->faker()->text(),
            "stage" => 3
        ]);

        $response->assertStatus(302);
        // $response->assertRedirect(redirect()->back());
    }
}
