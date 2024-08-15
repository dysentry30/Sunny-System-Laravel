<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Models\KriteriaPenggunaJasaDetail;
use App\Models\PenilaianPenggunaJasa;

class DashboardFourEyesController extends Controller
{
    public function index(Request $request)
    {
        $tahun = date("Y");

        $proyeks = Proyek::with(["proyekBerjalan", "SumberDana", "UnitKerja", 'NotaRekomendasi'])->where("tahun_perolehan", $tahun)->where("dop", "!=", "EA")->where("tipe_proyek", "P")->get();
        $kriteriaPenggunaJasa = KriteriaPenggunaJasaDetail::all();
        $penilaianPenggunaJasa = PenilaianPenggunaJasa::all();

        $dataOwnerSelection = $proyeks->map(function ($proyek) use ($kriteriaPenggunaJasa, $penilaianPenggunaJasa) {
            $kode_proyek = $proyek->kode_proyek;
            $nama_proyek = $proyek->nama_proyek;
            $nama_owner = $proyek->proyekBerjalan->customer?->name ?? "";
            $unit_kerja = $proyek->UnitKerja->unit_kerja;
            $sumber_dana = $proyek->sumber_dana ?? "Tidak isi Sumber Dana";
            $jenis_instansi = !empty($nama_owner) && !empty($proyek->proyekBerjalan->customer?->jenis_instansi) ? $proyek->proyekBerjalan->customer?->jenis_instansi : (!empty($nama_owner) && empty($proyek->proyekBerjalan->customer?->jenis_instansi) ? "Belum Isi Instansi" : "Belum Isi Owner");

            $proyekGreenlane = checkGreenLine($proyek);

            if (!$proyekGreenlane) {
                if (!empty($proyek->NotaRekomendasi)) {
                    $total_pengguna_jasa = $kriteriaPenggunaJasa->where("kode_proyek", $proyek->kode_proyek)->sum("nilai");
                    if ($total_pengguna_jasa != 0) {
                        $hasil_profile_risiko = $penilaianPenggunaJasa->filter(function ($item) use ($total_pengguna_jasa) {
                            return $item->dari_nilai <= $total_pengguna_jasa && $item->sampai_nilai >= $total_pengguna_jasa;
                        })->first()?->nama ?? "-";
                    } else {
                        $hasil_profile_risiko = "Dalam Proses";
                    }

                    $collectPerekomendasi = collect(json_decode($proyek->NotaRekomendasi?->approved_rekomendasi_final)) ?? null;

                    if (!empty($collectPerekomendasi)) {
                        switch ($collectPerekomendasi) {
                            case $collectPerekomendasi->contains("status", "rejected"):
                                $hasil_assessment = "Tidak Direkomendasikan";
                                break;
                            case $collectPerekomendasi->every("status", "approved") && $collectPerekomendasi->every("catatan", "!=", null):
                                $hasil_assessment = "Direkomendasikan Dengan Catatan";
                                break;
                            case $collectPerekomendasi->every("status", "approved"):
                                $hasil_assessment = "Direkomendasikan";
                                break;

                            default:
                                $hasil_assessment = "-";
                                break;
                        }
                    } else {
                        $hasil_assessment = "Dalam Proses";
                    }
                } else {
                    $hasil_profile_risiko = "Belum Pengajuan";
                    $hasil_assessment = "Belum Pengajuan";
                }
            } else {
                $hasil_profile_risiko = null;
                $hasil_assessment = null;
            }

            return collect([
                "kode_proyek" => $kode_proyek,
                "nama_proyek" => $nama_proyek,
                "nama_owner" => $nama_owner,
                "unit_kerja" => $unit_kerja,
                "jenis_instansi" => $jenis_instansi,
                "sumber_dana" => $sumber_dana,
                "hasil_profile_risiko" => $hasil_profile_risiko,
                "hasil_assessment" => $hasil_assessment,
            ]);
        });

        $pieChatOwnerInstansi = $dataOwnerSelection->groupBy("jenis_instansi")->map(function ($proyek, $key) {
            return ["name" => $key, "y" => $proyek->count()];
        })->values()->toJson();

        $pieChatSumberDana = $dataOwnerSelection->groupBy("sumber_dana")->map(function ($proyek, $key) {
            return ["name" => $key, "y" => $proyek->count()];
        })->values()->toJson();

        $pieChatProfileRisikoOwner = $dataOwnerSelection->groupBy("hasil_profile_risiko")->map(function ($proyek, $key) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count()];
            }
            return ["name" => $key, "y" => $proyek->count()];
        })->values()->toJson();

        $pieChatHasilAssessmentOwner = $dataOwnerSelection->groupBy("hasil_assessment")->map(function ($proyek, $key) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count()];
            }
            return ["name" => $key, "y" => $proyek->count()];
        })->values()->toJson();

        return view("30_Dashboard_Four_Eyes", [
            "pieChatOwnerInstansi" => $pieChatOwnerInstansi,
            "pieChatSumberDana" => $pieChatSumberDana,
            "pieChatProfileRisikoOwner" => $pieChatProfileRisikoOwner,
            "pieChatHasilAssessmentOwner" => $pieChatHasilAssessmentOwner,
        ]);
    }
}
