<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Dop;
use App\Models\Proyek;
use App\Models\PorsiJO;
use App\Models\Customer;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\MasterPefindo;
use App\Models\MasterGrupTierBUMN;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PenilaianPenggunaJasa;
use App\Models\PartnerSelectionDetail;
use App\Models\PenilaianPartnerSelection;
use App\Models\AssessmentPartnerSelection;
use App\Models\KriteriaPenggunaJasaDetail;
use App\Models\KriteriaProjectSelectionDetail;
use App\Models\MasterKriteriaGreenlanePartner;
use App\Models\PenilaianChecklistProjectSelection;

class DashboardFourEyesController extends Controller
{
    public function index(Request $request)
    {
        $tahun = date("Y");

        $dopSelect = $request->get("dop") ?? null;
        $unitKerjaSelect = $request->get("unit-kerja") ?? null;
        $tahunSelect = $request->get("tahun") ?? null;

        
        if (Auth::user()->check_administrator) {
            $exceptUnitkerja = ["B", "C", "D", "8", "F", "L", "N", "O", "U"];
            if ($tahun >= 2023) {
                $unitKerja = UnitKerja::orderBy('unit_kerja')->get()->where("dop", "!=", "EA")->whereNotIn("divcode", $exceptUnitkerja)->sortBy('id_profit_center');
            } else {
                $unitKerja = UnitKerja::orderBy('unit_kerja')->get()->where("dop", "!=", "EA")->whereNotIn("divcode", ["B", "C", "D", "8"])->sortBy('id_profit_center');
            }
            
            $dops = Dop::where("dop", "!=", "EA")->orderBy('dop')->get()?->keyBy('dop')->keys()->sort();
            if (date("Y") >= 2024) {
                $dops = $dops->filter(function ($item) {
                    return $item != "DOP 3";
                });
            }
            $unit_kerja_user = $unitKerja->keyBy("divcode")->keys();
        } else {
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            $exceptUnitkerja = ["B", "C", "D", "8", "F", "L", "N", "O", "U"];
            if ($tahun >= 2023) {
                $unitKerja = UnitKerja::get()->whereIn("divcode", $unit_kerja_user->toArray())->where("dop", "!=", "EA")->whereNotIn("divcode", $exceptUnitkerja)->sortBy('id_profit_center');
            } else {
                $unitKerja = UnitKerja::get()->whereIn("divcode", $unit_kerja_user->toArray())->where("dop", "!=", "EA")->whereNotIn("divcode", ["B", "C", "D", "8"])->sortBy('id_profit_center');
            }

            $dops = $unitKerja->groupBy('dop')->keys()->sort();
            if (date("Y") >= 2024) {
                if ($dops->count() == 3) {
                    $dops = $dops->push("PUSAT");
                }
            } else {
                if ($dops->count() == 4) {
                    $dops = $dops->push("PUSAT");
                }
            }
        }


        $proyeks = Proyek::with(["proyekBerjalan", "SumberDana", "UnitKerja", 'NotaRekomendasi'])
        ->where("tahun_perolehan", $tahun)
        ->where("dop", "!=", "EA")
        ->where("tipe_proyek", "P")
        ->where("is_cancel", false)
            ->whereIn("unit_kerja", $unit_kerja_user->toArray())
        ->when(!empty($dopSelect), function ($query) use ($dopSelect) {
            $query->where("dop", $dopSelect);
        })
        ->when(!empty($unitKerjaSelect), function ($query) use ($unitKerjaSelect) {
            $query->where("unit_kerja", $unitKerjaSelect);
        })
        ->when(!empty($tahunSelect), function ($query) use ($tahunSelect) {
            $query->where("tahun_perolehan", $tahunSelect);
        })
        ->get();

        

        $kriteriaPenggunaJasa = KriteriaPenggunaJasaDetail::all();
        $penilaianPenggunaJasa = PenilaianPenggunaJasa::all();
        $kriteriaProjectDetail = KriteriaProjectSelectionDetail::all();
        $pernilaianProject = PenilaianChecklistProjectSelection::all();
        $kriteriaPartnerDetail = PartnerSelectionDetail::all();
        $pernilaianPartner = PenilaianPartnerSelection::all();

        //Begin::Dashboard Owner Selection
        $dataOwnerSelection = $proyeks->map(function ($proyek) use ($kriteriaPenggunaJasa, $penilaianPenggunaJasa) {
            $kode_proyek = $proyek->kode_proyek;
            $nama_proyek = $proyek->nama_proyek;
            $nama_owner = $proyek->proyekBerjalan->customer?->name ?? "";
            $unit_kerja = $proyek->UnitKerja->unit_kerja;
            $sumber_dana = $proyek->sumber_dana ?? "Tidak isi Sumber Dana";
            $jenis_instansi = !empty($nama_owner) && !empty($proyek->proyekBerjalan->customer?->jenis_instansi) ? $proyek->proyekBerjalan->customer?->jenis_instansi : (!empty($nama_owner) && empty($proyek->proyekBerjalan->customer?->jenis_instansi) ? "Belum Isi Instansi Owner" : "Belum Isi Owner");

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
                        $hasil_assessment = "Dalam Proses";
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
                        $hasil_profile_risiko = "Dalam Proses";
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

        $pieChatOwnerInstansi = $dataOwnerSelection->groupBy("jenis_instansi")->map(function ($proyek, $key) use ($dataOwnerSelection) {
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataOwnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatSumberDana = $dataOwnerSelection->groupBy("sumber_dana")->map(function ($proyek, $key) use ($dataOwnerSelection) {
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataOwnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatProfileRisikoOwner = $dataOwnerSelection->groupBy("hasil_profile_risiko")->map(function ($proyek, $key) use ($dataOwnerSelection) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataOwnerSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataOwnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatHasilAssessmentOwner = $dataOwnerSelection->groupBy("hasil_assessment")->map(function ($proyek, $key) use ($dataOwnerSelection) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataOwnerSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataOwnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();
        //End::Dashboard Owner Selection


        //Begin::Dashboard Project Selection
        $dataProjectSelection = $proyeks->where("stage", ">=", 4)->where("is_tidak_lulus_pq", false)->map(function ($proyek) use ($kriteriaProjectDetail, $pernilaianProject) {
            $kode_proyek = $proyek->kode_proyek;
            $nama_proyek = $proyek->nama_proyek;
            $unit_kerja = $proyek->UnitKerja->unit_kerja;
            $nama_owner = $proyek->proyekBerjalan->customer?->name ?? "";

            $is_uang_muka = !is_null($proyek->is_uang_muka) && $proyek->is_uang_muka ? "Ada Uang Muka" : (!is_null($proyek->is_uang_muka) && !$proyek->is_uang_muka ? "Tida Ada Uang Muka" : "Belum isi");
            $cara_pembayaran = $proyek->sistem_bayar;
            $kategori_proyek = $proyek->klasifikasi_pasdin;
            $jenis_kontrak = $proyek->jenis_terkontrak;

            $kso_non_kso = $proyek->PartnerJO ?? false;

            $proyekGreenlane = checkNonGreenLaneNota2($proyek);

            if ($proyekGreenlane) {
                if (!empty($proyek->NotaRekomendasi2)) {
                    //Profile Risiko
                    if (!is_null($proyek->NotaRekomendasi2->is_verifikasi_approved) && !empty($proyek->NotaRekomendasi2->approved_rekomendasi)) {
                        $total_pengguna_jasa = $kriteriaProjectDetail->where("kode_proyek", $proyek->kode_proyek)->sum("nilai");
                        if ($total_pengguna_jasa != 0) {
                            $hasil_profile_risiko = $pernilaianProject->filter(function ($item) use ($total_pengguna_jasa) {
                                return $item->dari_nilai <= $total_pengguna_jasa && $item->sampai_nilai >= $total_pengguna_jasa;
                            })->first()?->nama ?? "-";
                            $hasil_assessment = "Dalam Proses";
                        } else {
                            $hasil_profile_risiko = "Dalam Proses";
                            $hasil_assessment = "Dalam Proses";
                        }
                    } else {
                        $hasil_profile_risiko = "Dalam Proses";
                        $hasil_assessment = "Dalam Proses";
                    }

                    //Hasil Assessment
                    if (!is_null($proyek->NotaRekomendasi2->is_rekomendasi_approved) && !empty($proyek->NotaRekomendasi2->approved_rekomendasi)) {
                        $collectPerekomendasi = collect(json_decode($proyek->NotaRekomendasi2?->approved_rekomendasi)) ?? null;
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
                            $hasil_profile_risiko = $hasil_profile_risiko != "Dalam Proses" ? $hasil_profile_risiko : "Dalam Proses";
                        } else {
                            $hasil_assessment = "Dalam Proses";
                            $hasil_profile_risiko = $hasil_profile_risiko != "Dalam Proses" ? $hasil_profile_risiko : "Dalam Proses";
                        }
                    } else {
                        $hasil_profile_risiko = "Dalam Proses";
                        $hasil_profile_risiko = $hasil_profile_risiko != "Dalam Proses" ? $hasil_profile_risiko : "Dalam Proses";
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
                "uang_muka" => $is_uang_muka,
                "cara_pembayaran" => $cara_pembayaran,
                "kategori_proyek" => $kategori_proyek,
                "jenis_kontrak" => $jenis_kontrak,
                "hasil_profile_risiko" => $hasil_profile_risiko,
                "hasil_assessment" => $hasil_assessment,
                "kso_non_kso" => $kso_non_kso,
                "klasifikasi_proyek" => $proyek->klasifikasi_pasdin
            ]);
        });

        $pieChatUangMuka = $dataProjectSelection->groupBy("uang_muka")->map(function ($proyek, $key) use ($dataProjectSelection) {
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatCaraPembayaran = $dataProjectSelection->groupBy("cara_pembayaran")->map(function ($proyek, $key) use ($dataProjectSelection) {
            if (empty($key)) {
                return ["name" => "Belum isi", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatKategoriProyek = $dataProjectSelection->groupBy("kategori_proyek")->map(function ($proyek, $key) use ($dataProjectSelection) {
            if (empty($key)) {
                return ["name" => "Belum isi", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatJenisKontrak = $dataProjectSelection->groupBy("jenis_kontrak")->map(function ($proyek, $key) use ($dataProjectSelection) {
            if (empty($key)) {
                return ["name" => "Belum isi", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatProfileRisikoProyek = $dataProjectSelection->groupBy("hasil_profile_risiko")->map(function ($proyek, $key) use ($dataProjectSelection) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatHasilRekomendasiProyek = $dataProjectSelection->groupBy("hasil_assessment")->map(function ($proyek, $key) use ($dataProjectSelection) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataProjectSelection->count()) * 100, 2) : 0];
        })->values()->toJson();
        //End::Dashboard Project Selection


        //Begin::Dashboard Partner Selection
        $partnerKSO = Proyek::with(["UnitKerja", "proyekBerjalan.customer", "PorsiJO.AssessmentPartnerJO"])
        ->select("proyeks.*", "proyeks.porsi_jo as porsi_wika", "porsi_jo_proyeks.porsi_jo as porsi_partner", "porsi_jo_proyeks.id as id_partner", "porsi_jo_proyeks.*")
        ->leftJoin("porsi_jo_proyeks", "porsi_jo_proyeks.kode_proyek", "=", "proyeks.kode_proyek")
        ->where("tahun_perolehan", $tahun)
        ->where("dop", "!=", "EA")
        ->where("tipe_proyek", "P")
        ->where("is_cancel", false)
            ->whereIn("unit_kerja", $unit_kerja_user->toArray())
        ->when(!empty($dopSelect), function ($query) use ($dopSelect) {
            $query->where("dop", $dopSelect);
        })
        ->when(!empty($unitKerjaSelect), function ($query) use ($unitKerjaSelect) {
            $query->where("unit_kerja", $unitKerjaSelect);
        })
        ->when(!empty($tahunSelect), function ($query) use ($tahunSelect) {
            $query->where("tahun_perolehan", $tahunSelect);
        })
        ->get();

        $dataPartnerSelection = $partnerKSO->map(function ($partner) use ($kriteriaPartnerDetail, $pernilaianPartner) {

            $kode_proyek = $partner->kode_proyek;
            $nama_proyek = $partner->nama_proyek;
            $unit_kerja = $partner->UnitKerja->unit_kerja;
            $nama_owner = $partner->proyekBerjalan->customer?->name ?? "Belum isi";

            if (!empty($partner->id_company_jo) || !empty($partner->company_jo)) {

                if ($partner->porsi_partner > $partner->porsi_wika) {
                    $posisiWika = "WIKA Member";
                } else {
                    $posisiWika = "WIKA Leader";
                }

                $partnerProyek = Customer::where(function ($query) use ($partner) {
                    $query->where("id_customer", $partner->id_partner)
                        ->orWhere("name", $partner->company_jo);
                })->first();

                $jenis_instansi = $partnerProyek?->jenis_instansi ?? null;

                // $kriteria_partner = MasterGrupTierBUMN::where('id_pelanggan', $partner->id_company_jo)->first();
                $kriteria_partner_greenlane = MasterKriteriaGreenlanePartner::where('id_pelanggan', $partner->id_company_jo)->first();

                if ($kriteria_partner_greenlane) {
                    $is_greenlane = true;
                    $hasil_profile_risiko = "Greenlane";
                    $hasil_profile_risiko_eksternal = "Greenlane";
                } else {
                    $is_greenlane = false;
                    if ($partner->proyekBerjalan->customer?->nama_holding) {
                        $customerHolding = Customer::find($partner->proyekBerjalan->customer->nama_holding);
                        $parentHoldingExist = MasterKriteriaGreenlanePartner::where('id_pelanggan', $customerHolding->id_customer)->first();
                        if (!empty($parentHoldingExist)) {
                            $is_greenlane = true;
                        }
                    }
                }

                if (!$is_greenlane) {
                    $assessment_partner = AssessmentPartnerSelection::where("kode_proyek", $partner->kode_proyek)->where("partner_id", $partner->id_partner)->first();
                    if (!empty($assessment_partner)) {
                        if (!is_null($assessment_partner->is_penyusun_approved)) {
                            $total_pengguna_jasa = $kriteriaPartnerDetail->where("kode_proyek", $partner->kode_proyek)->where("partner_id", $partner->id_partner)->sum("nilai");
                            if ($total_pengguna_jasa != 0) {
                                $hasil_profile_risiko = $pernilaianPartner->filter(function ($item) use ($total_pengguna_jasa) {
                                    return $item->dari_nilai <= $total_pengguna_jasa && $item->sampai_nilai >= $total_pengguna_jasa;
                                })->first()?->nama ?? "-";
                            } else {
                                $hasil_profile_risiko = "Dalam Proses";
                            }
                        } else {
                            $hasil_profile_risiko = "Dalam Proses";
                        }
                    } else {
                        $hasil_profile_risiko = "Belum Diajukan";
                    }

                    $checkPefindo = MasterPefindo::where(function ($query) use ($partner) {
                        $query->where("id_pelanggan", $partner->id_partner)->orWhere("nama_pelanggan", $partner->company_jo);
                    })->first();

                    if (!empty($checkPefindo)) {
                        $hasil_profile_risiko_eksternal = $checkPefindo->keterangan;
                    } else {
                        $hasil_profile_risiko_eksternal = "Belum isi Pefindo";
                    }
                } else {
                    $hasil_profile_risiko = "Greenlane";
                    $hasil_profile_risiko_eksternal = "Greenlane";
                }
            } else {
                $posisiWika = "Tidak KSO";
                $hasil_profile_risiko = null;
                $hasil_profile_risiko_eksternal = null;
            }


            return collect([
                "kode_proyek" => $kode_proyek,
                "nama_proyek" => $nama_proyek,
                "unit_kerja" => $unit_kerja,
                "nama_owner" => $nama_owner,
                "nama_partner" => $partner->company_jo ?? null,
                "posisi_wika" => $posisiWika,
                "jenis_instansi" => $jenis_instansi ?? null,
                "hasil_profile_risiko_internal" => $hasil_profile_risiko,
                "hasil_profile_risiko_eksternal" => $hasil_profile_risiko_eksternal,
                "klasifikasi_proyek" => $partner->klasifikasi_pasdin ?? "Belum isi",
            ]);
        });

        $pieChatPosisiWika = $dataPartnerSelection->groupBy("posisi_wika")->map(function ($proyek, $key) use ($dataPartnerSelection) {
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataPartnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatJenisInstansiPartner = $dataPartnerSelection->groupBy("jenis_instansi")->map(function ($proyek, $key) use ($dataPartnerSelection) {
            if (empty($key) || $key == "") {
                return ["name" => "Belum isi", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataPartnerSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataPartnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        $pieChatProfileRisikointernalPartner = $dataPartnerSelection->groupBy("hasil_profile_risiko_internal")->map(function ($proyek, $key) use ($dataPartnerSelection) {
            if (empty($key)) {
                return ["name" => "Greenlane", "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataPartnerSelection->count()) * 100, 2) : 0];
            }
            return ["name" => $key, "y" => $proyek->count(), "proyeks" => $proyek, "persentase" => $proyek->count() > 0 ? round(($proyek->count() / $dataPartnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        // $profileRisikoEksternalPartner = MasterPefindo::where("is_active", true)->get()?->groupBy("keterangan");

        // $pieChatProfileRisikoEksternalPartner = $profileRisikoEksternalPartner?->map(function ($partner, $key) use ($profileRisikoEksternalPartner) {
        //     return ["name" => $key, "y" => $partner->count(), "proyeks" => $partner, "persentase" => $partner->count() > 0 ? round(($partner->count() / $profileRisikoEksternalPartner->count()) * 100, 2) : 0];
        // })->values()->toJson();
        $pieChatProfileRisikoEksternalPartner = $dataPartnerSelection?->groupBy("hasil_profile_risiko_eksternal")->filter(function ($partner, $key) {
            return !empty($key);
        })->map(function ($partner, $key) use ($dataPartnerSelection) {
            return ["name" => $key, "y" => $partner->count(), "proyeks" => $partner, "persentase" => $partner->count() > 0 ? round(($partner->count() / $dataPartnerSelection->count()) * 100, 2) : 0];
        })->values()->toJson();

        // dd($pieChatProfileRisikoEksternalPartner);
        //End::Dashboard Partner Selection

        return view("30_Dashboard_Four_Eyes", [
            "tahun" => $tahun,
            "dopSelect" => $dopSelect,
            "unitKerjaSelect" => $unitKerjaSelect,
            "tahunSelect" => $tahunSelect,
            "unitKerja" => $unitKerja,
            "dops" => $dops,
            "pieChatOwnerInstansi" => $pieChatOwnerInstansi,
            "pieChatSumberDana" => $pieChatSumberDana,
            "pieChatProfileRisikoOwner" => $pieChatProfileRisikoOwner,
            "pieChatHasilAssessmentOwner" => $pieChatHasilAssessmentOwner,
            "pieChatUangMuka" => $pieChatUangMuka,
            "pieChatCaraPembayaran" => $pieChatCaraPembayaran,
            "pieChatKategoriProyek" => $pieChatKategoriProyek,
            "pieChatJenisKontrak" => $pieChatJenisKontrak,
            "pieChatProfileRisikoProyek" => $pieChatProfileRisikoProyek,
            "pieChatHasilRekomendasiProyek" => $pieChatHasilRekomendasiProyek,
            "pieChatPosisiWika" => $pieChatPosisiWika,
            "pieChatJenisInstansiPartner" => $pieChatJenisInstansiPartner,
            "pieChatProfileRisikoEksternalPartner" => $pieChatProfileRisikoEksternalPartner,
            "pieChatProfileRisikointernalPartner" => $pieChatProfileRisikointernalPartner
        ]);
    }
}
