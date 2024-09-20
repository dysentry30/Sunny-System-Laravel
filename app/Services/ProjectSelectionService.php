<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TimTender;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\NotaRekomendasi2;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\MatriksApprovalPaparan;
use App\Models\MatriksApprovalNotaRekomendasi2;


class ProjectSelectionService
{
    public $userSelected;
    public $isnomorTargetActive;
    public $matriks_approvals;

    public function __construct($nip)
    {
        $this->userSelected = User::where("nip", $nip)->first();
        $this->isnomorTargetActive = env('IS_SEND_EMAIL');
        $this->matriks_approvals = MatriksApprovalNotaRekomendasi2::where("is_active", true)->get();
    }

    public function listProyek()
    {
        $is_super_user = str_contains($this->userSelected->name, "PIC") || $this->userSelected->check_administrator;
        $unit_kerjas = $is_super_user && str_contains($this->userSelected->name, "Admin") ?
            UnitKerja::select('divcode')->get()->map(function ($unit_kerja) {
                return $unit_kerja["divcode"];
            }) : (str_contains($this->userSelected->unit_kerja, ",") ?
                collect(explode(",", $this->userSelected->unit_kerja)) :
                collect($this->userSelected->unit_kerja))->toArray();

        $all_super_user_counter = MatriksApprovalNotaRekomendasi2::all()->filter(function ($user) {
            if ($user->is_ktt) {
                return TimTender::where('nip_pegawai', $this->userSelected->nip)->where('posisi', 'Ketua')->first();
            } else {
                return $user->Pegawai->nip == $this->userSelected->nip;
            }
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            if ($user->is_ktt) {
                return TimTender::where('nip_pegawai', $this->userSelected->nip)->where('posisi', 'Ketua')->first();
            } else {
                return $user->Pegawai->nip == $this->userSelected->nip;
            }
        });

        $is_matriks_has_ktt = $all_super_user_counter->contains(function ($value) {
            return $value->is_ktt;
        });

        if ($this->userSelected->check_administrator) {
            $matriks_user = MatriksApprovalNotaRekomendasi2::all();
            $matriks_paparan = MatriksApprovalPaparan::all();
            $collectKlasifikasi = $matriks_user?->groupBy('klasifikasi_proyek')?->keys()?->toArray();
            $unit_kerjas = ['H', 'G', 'P', 'J'];
            $collectDivisi = $matriks_user?->groupBy('divisi_id')?->keys()?->toArray();
            $collectDepartement = $matriks_user?->groupBy('departemen_code')?->keys()?->toArray();
            $collectKlasifikasiPaparan = $matriks_paparan?->map(function ($item) {
                return $item->klasifikasi_proyek;
            })->toArray();

            $collectDivisiPaparan = $matriks_paparan?->map(function ($item) {
                return $item->divisi_id;
            })->toArray();

            $collectDepartementPaparan = $matriks_paparan?->map(function ($item) {
                return $item->departemen_code;
            })->toArray();
        } else {
            $matriks_paparan = MatriksApprovalPaparan::all()->filter(function ($user) {
                return $user->Pegawai->nama_pegawai == $this->userSelected->name;
            });
            if ($is_matriks_has_ktt) {
                $matriks_user = $all_super_user_counter;
                $collectKlasifikasi = $matriks_user?->map(function ($item) {
                    return $item->klasifikasi_proyek;
                })->toArray();

                $collectDivisi = $matriks_user?->map(function ($item) {
                    return $item->divisi_id;
                })->toArray();

                $collectDepartement = $matriks_user?->map(function ($item) {
                    return $item->departemen_code;
                })->toArray();

                $collectKlasifikasiPaparan = $matriks_paparan?->map(function ($item) {
                    return $item->klasifikasi_proyek;
                })->toArray();

                $collectDivisiPaparan = $matriks_paparan?->map(function ($item) {
                    return $item->divisi_id;
                })->toArray();

                $collectDepartementPaparan = $matriks_paparan?->map(function ($item) {
                    return $item->departemen_code;
                })->toArray();
            } else {
                $matriks_user = $this->userSelected->Pegawai?->MatriksApproval2;
                $collectKlasifikasi = $matriks_user?->map(function ($item) {
                    return $item->klasifikasi_proyek;
                })->toArray();

                $collectDivisi = $matriks_user?->map(function ($item) {
                    return $item->divisi_id;
                })->toArray();

                $collectDepartement = $matriks_user?->map(function ($item) {
                    return $item->departemen_code;
                })->toArray();

                $collectKlasifikasiPaparan = $matriks_paparan?->map(function ($item) {
                    return $item->klasifikasi_proyek;
                })->toArray();

                $collectDivisiPaparan = $matriks_paparan?->map(function ($item) {
                    return $item->divisi_id;
                })->toArray();

                $collectDepartementPaparan = $matriks_paparan?->map(function ($item) {
                    return $item->departemen_code;
                })->toArray();
            }
        }

        $proyeks = NotaRekomendasi2::all();

        $proyeks_proses_paparan = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasiPaparan)->whereIn('departemen_proyek', $collectDepartementPaparan)->whereIn('divisi_id', $collectDivisiPaparan)->whereNotNull('is_request_paparan')->whereNull('is_disetujui')->filter(function ($p) {
            return !$p->Proyek->is_cancel;
        });
        $proyeks_proses_rekomendasi = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasi)->whereIn('departemen_proyek', $collectDepartement)->whereIn('divisi_id', $collectDivisi)->whereNull('is_disetujui')->filter(function ($p) {
            return !$p->Proyek->is_cancel;
        });
        $proyeks_rekomendasi_final = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasi)->whereIn('departemen_proyek', $collectDepartement)->whereIn('divisi_id', $collectDivisi)->filter(function ($p) {
            return !is_null($p->is_disetujui) || $p->Proyek->is_cancel;
        });

        if ($matriks_user->isEmpty() && $this->userSelected->canany(["admin-crm"])) {
            $collectKlasifikasi = $collectKlasifikasiPaparan = ["Proyek Kecil", "Proyek Menengah", "Proyek Besar", "Mega Proyek"];
            $proyeks_proses_paparan = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasiPaparan)->whereNotNull('is_request_paparan')->whereNull('is_disetujui')->filter(function ($p) {
                return !$p->Proyek->is_cancel;
            });
            $proyeks_proses_rekomendasi = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasi)->whereNull('is_disetujui')->filter(function ($p) {
                return !$p->Proyek->is_cancel;
            });
            $proyeks_rekomendasi_final = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasi)->filter(function ($p) {
                return !is_null($p->is_disetujui) || $p->Proyek->is_cancel;
            });
        }

        $proyeks_list = $proyeks_proses_rekomendasi->values()->merge($proyeks_rekomendasi_final, $proyeks_proses_paparan);
        return collect(["proyeks_list" => $proyeks_list->values()]);
    }

    public function getProyek($kode_proyek)
    {
        try {

            $proyekSelected = NotaRekomendasi2::where("kode_proyek", $kode_proyek)->first();

            if (empty($proyekSelected)) {
                Log::error("Proyek tidak ditemukan. Hubungi Admin");
                return "Proyek tidak ditemukan. Hubungi Admin";
            }

            $checkUserAccsess = $this->userSelected->Pegawai?->MatriksApproval2;

            return ["proyeks" => $proyekSelected, "userAccess" => $checkUserAccsess];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function approvalPengajuan(Request $request, $kode_proyek)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $buttonSelected = $data["button-selected"];

            $notaRekomendasi = NotaRekomendasi2::where("kode_proyek", $kode_proyek)->first();
            $proyek = $notaRekomendasi->Proyek;

            if (empty($notaRekomendasi)) {
                return [false, "Proyek tidak ditemukan. Hubungi Admin."];
            }



            if ($buttonSelected == "Approved") {

                $dataPengajuanApproved = collect(json_decode($notaRekomendasi->approved_rekomendasi));
                $dataPengajuanApproved = $dataPengajuanApproved->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => Carbon::now(),
                ]);

                $notaRekomendasi->approved_pengajuan = $dataPengajuanApproved->toJson();

                if (empty($notaRekomendasi->is_revisi_pengajuan)) {;
                    $matriks_paparan = MatriksApprovalPaparan::where("divisi_id", "=", $proyek->UnitKerja->Divisi->id_divisi)->where("klasifikasi_proyek", "=", $notaRekomendasi->klasifikasi_proyek)->where("departemen_code", $notaRekomendasi->departemen_proyek)->where("kategori", "=", "Pengajuan")->where('is_active', true)->get();
                    if ($matriks_paparan->isEmpty()) {
                        return [false, "Matriks untuk paparan tidak ditemukan. Hubungi Admin!"];
                    }

                    foreach ($matriks_paparan as $user) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_req_paparan_$notaRekomendasi->kode_proyek";
                        $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan pengajuan tanggal paparan untuk Nota Rekomendasi II, " . $proyek->proyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Pengajuan Waktu Paparan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return [false, "Error sending email"];
                        }
                    }
                } else {
                    $nomorTarget = self::getNomorMatriksApproval($notaRekomendasi->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Penyusun")->where('urutan', '=', 1);
                    foreach ($nomorTarget as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_rekomendasi_" . $notaRekomendasi->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil revisi untuk proyek " . $proyek->nama_proyek . " untuk permohonan pengajuan rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Revisi Pengajuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return [false, "Error sending email"];
                        }
                    }
                }


                createWordPengajuanNota2($notaRekomendasi, $this->userSelected->nip);
                $notaRekomendasi->is_pengajuan_approved = true;
                $notaRekomendasi->is_request_rekomendasi = false;
                $notaRekomendasi->is_request_paparan = true;

                if ($notaRekomendasi->save() && $proyek->save()) {
                    DB::commit();
                    return [true, "Proyek Berhasil Disetujui"];
                } else {
                    DB::rollBack();
                    return [false, "Proyek Gagal Disetujui"];
                }
            } else {
                if (!isset($data["notes"])) {
                    return [false, "Catatan Revisi Wajib Diisi"];
                }

                $revisi_note = collect(json_decode($notaRekomendasi->revisi_pengajuan_note));
                $revisi_note->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "revisi",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $data["notes"]
                ]);

                $notaRekomendasi->revisi_pengajuan_note = $revisi_note->toJson();
                $notaRekomendasi->is_revisi_pengajuan = true;

                $request_pengajuan = collect(json_decode($notaRekomendasi->request_pengajuan));
                $userRequestPengajuan = User::find($request_pengajuan["user_id"]);

                $url = $request->schemeAndHttpHost() . "?nip=" . $userRequestPengajuan->Pegawai?->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_history_revisi_pengajuan_$notaRekomendasi->kode_proyek";
                $message = "Yth Bapak/Ibu " . $userRequestPengajuan->Pegawai?->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan revisi untuk Nota Rekomendasi II, " . $notaRekomendasi->proyekBerjalan->name_customer . " untuk Proyek $notaRekomendasi->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $sendEmailUser = sendNotifEmail($userRequestPengajuan->Pegawai, "Pemberitahuan Revisi Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);

                if (!$sendEmailUser) {
                    return [false, "Error sending email"];
                }

                if (!empty($notaRekomendasi->file_pengajuan)) {
                    File::delete(public_path('nota-rekomendasi-2/file-pengajuan/' . $notaRekomendasi->file_pengajuan));
                }

                $notaRekomendasi->is_request_rekomendasi = null;

                if ($notaRekomendasi->save() && $proyek->save()) {
                    DB::commit();
                    return [true, "Proyek Berhasil Direvisi"];
                } else {
                    DB::rollBack();
                    return [false, "Proyek Gagal Direvisi"];
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return [false, $th->getMessage()];
        }
    }

    public function approvalVerifikasi(Request $request, $kode_proyek)
    {
        try {
            DB::beginTransaction();

            $is_paralel = false;

            $data = $request->all();
            $buttonSelected = $data["button-selected"];

            $notaRekomendasi = NotaRekomendasi2::where("kode_proyek", $kode_proyek)->first();
            $proyek = $notaRekomendasi->Proyek;

            if (empty($notaRekomendasi)) {
                return [false, "Proyek tidak ditemukan. Hubungi Admin."];
            }

            if ($buttonSelected == "Approved") {
                $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_verifikasi));
                $approved_verifikasi->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                ]);

                $notaRekomendasi->approved_verifikasi = $approved_verifikasi->toJson();
                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, $approved_verifikasi, "Verifikasi");

                if ($is_checked) {
                    $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi");
                    foreach ($nomorTarget as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_rekomendasi_" . $notaRekomendasi->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen untuk proyek " . $proyek->nama_proyek . " untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return [false, "Error sending email."];
                        }
                    }
                    // $proyek->is_verifikasi_approved = true;
                    $notaRekomendasi->is_verifikasi_approved = true;
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Verifikasi");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang($this->userSelected->nip, $proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Verifikasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Verifikasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                if ($user->is_ktt) {
                                    $user = $proyek->TimTender->where('posisi', 'Ketua')->first();
                                }

                                if (empty($user->Pegawai)) {
                                    return [false, "KTT Belum Ditentukan, Mohon untuk mengisi KTT Terlebih dahulu."];
                                }
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_verifikasi_$notaRekomendasi->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen untuk proyek " . $proyek->nama_proyek . " untuk proses tandatangan penyusun Nota Rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return [false, 'Error sending email.'];
                                }
                            }
                        }
                    }
                }

                $message = "Proyek Berhasil Disetujui";
            } elseif ($buttonSelected == "Revisi") {
                if (!isset($data["notes"])) {
                    return [false, "Catatan Revisi Wajib Diisi"];
                }

                $revisi_note = collect(json_decode($notaRekomendasi->revisi_note));
                $revisi_note->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "revisi",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"]
                ]);

                $notaRekomendasi->revisi_note = $revisi_note;
                $notaRekomendasi->is_revisi = true;

                $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Penyusun", 1);

                foreach ($get_nomor as $user) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_persetujuan_$proyek->kode_proyek";
                    $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi asesmen untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Revisi Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return [false, "Error sending email."];
                    }
                }

                $notaRekomendasi->is_penyusun_approved = null;
                $notaRekomendasi->approved_penyusun = null;
                $notaRekomendasi->approved_verifikasi = null;
                $notaRekomendasi->is_draft_recommend_note = null;

                $message = "Proyek Berhasil Direvisi";
            } else {

                if (!isset($data["notes"])) {
                    return [false, "Catatan Revisi Wajib Diisi"];
                }

                $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_verifikasi));
                $approved_verifikasi->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $data["notes"]
                ]);

                $notaRekomendasi->approved_verifikasi = $approved_verifikasi->toJson();
                $notaRekomendasi->is_verifikasi_approved = false;
                $notaRekomendasi->is_disetujui = false;
                $proyek->is_disetujui = false;

                $proyek->save();

                $message = "Proyek Berhasil Ditolak";
            }

            $notaRekomendasi->save();
            DB::commit();

            return [true, $message];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [false, $th->getMessage()];
        }
    }

    public function approvalRekomendasi(Request $request, $kode_proyek)
    {
        try {
            DB::beginTransaction();

            $is_paralel = true;
            $is_has_not_recommended = false;

            $data = $request->all();
            $buttonSelected = $data["button-selected"];

            $notaRekomendasi = NotaRekomendasi2::where("kode_proyek", $kode_proyek)->first();
            $proyek = $notaRekomendasi->Proyek;

            if (empty($notaRekomendasi)) {
                return [false, "Proyek tidak ditemukan. Hubungi Admin."];
            }

            $kategoriRekomendasiSelected = isset($data["kategori-rekomendasi"]) ? $data["kategori-rekomendasi"] : null;

            if (empty($kategoriRekomendasiSelected)) {
                return [false, "Mohon isi kategori rekomendasi terlebih dahulu."];
            }

            if (!empty($notaRekomendasi->approved_rekomendasi)) {
                $is_has_not_recommended = collect(json_decode($notaRekomendasi->approved_rekomendasi))->where('status', 'rejected')->count() > 0;
            }

            if ($kategoriRekomendasiSelected == "Direkomendasikan Dengan Catatan") {

                if (empty($request["notes"])) {
                    return [false, "Mohon isi catatan terlebih dahulu"];
                }

                $approved_rekomendasi = collect(json_decode($notaRekomendasi->approved_rekomendasi));
                $approved_rekomendasi->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_rekomendasi = $approved_rekomendasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, $approved_rekomendasi, "Rekomendasi");

                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_rekomendasi_approved = false;
                        $notaRekomendasi->is_disetujui = false;
                    } else {
                        $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Persetujuan");
                        foreach ($matriks_approval as $key => $user) {
                            $user = $user->Pegawai->User;
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $notaRekomendasi->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return [false, "Error sending email"];
                            }
                        }
                        $notaRekomendasi->is_recommended_with_note = true;
                        $notaRekomendasi->is_rekomendasi_approved = true;
                    }
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang($this->userSelected->nip, $proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $notaRekomendasi->kode_proyek;
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    }
                }

                $message = "Proyek berhasil disetujui dengan catatan";
            } elseif ($kategoriRekomendasiSelected == "Tidak Direkomendasikan") {
                if (empty($request["notes"])) {
                    return [false, "Mohon isi catatan terlebih dahulu"];
                }

                $approved_rekomendasi = collect(json_decode($notaRekomendasi->approved_rekomendasi));
                $approved_rekomendasi->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_rekomendasi = $approved_rekomendasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, $approved_rekomendasi, "Rekomendasi");
                if ($is_checked) {
                    if ($is_has_not_recommended) {

                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_rekomendasi_approved = false;
                        $notaRekomendasi->is_disetujui = false;
                    }
                }

                $message = "Proyek berhasil ditolak";
            } elseif ($kategoriRekomendasiSelected == "Direkomendasikan") {
                $approved_rekomendasi = collect(json_decode($notaRekomendasi->approved_rekomendasi));
                $approved_rekomendasi->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_rekomendasi = $approved_rekomendasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, $approved_rekomendasi, "Rekomendasi");

                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_rekomendasi_approved = false;
                        $notaRekomendasi->is_disetujui = false;
                    } else {
                        $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Persetujuan");
                        foreach ($matriks_approval as $key => $user) {
                            $user = $user->Pegawai->User;
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $notaRekomendasi->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap II untuk " . $proyek->proyekBerjalan->customer->name . " pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return [false, "Error sending email"];
                            }
                        }

                        $notaRekomendasi->is_rekomendasi_approved = true;
                    }
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang($this->userSelected->nip, $proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $notaRekomendasi->kode_proyek;
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return [false, "Error sending email"];
                                }
                            }
                        }
                    }
                }

                $message = "Proyek berhasil disetujui";
            }

            if ($notaRekomendasi->save() && $proyek->save()) {
                DB::commit();
                return [true, $message];
            }

            DB::rollBack();
            return [false, $message];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [false, $th->getMessage()];
        }
    }

    public function approvalPersetujuan(Request $request, $kode_proyek)
    {
        try {
            DB::beginTransaction();

            $is_paralel = false;

            $data = $request->all();
            $buttonSelected = $data["button-selected"];

            $notaRekomendasi = NotaRekomendasi2::where("kode_proyek", $kode_proyek)->first();
            $proyek = $notaRekomendasi->Proyek;

            if (empty($notaRekomendasi)) {
                return [false, "Proyek tidak ditemukan. Hubungi Admin."];
            }

            if ($buttonSelected == "Approved") {
                $approved_persetujuan = collect(json_decode($notaRekomendasi->approved_persetujuan));
                $approved_persetujuan->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"]
                ]);
                $notaRekomendasi->approved_persetujuan = $approved_persetujuan->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, $approved_persetujuan, "Persetujuan");
                if ($is_checked) {
                    $notaRekomendasi->is_disetujui = true;
                    $notaRekomendasi->persetujuan_note = $request["notes"];

                    $message = "Proyek berhasil disetujui";
                }
            } elseif ($buttonSelected == "Rejected") {
                $approved_persetujuan = collect(json_decode($notaRekomendasi->approved_persetujuan));
                $approved_persetujuan->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_persetujuan = $approved_persetujuan->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $notaRekomendasi->klasifikasi_proyek, $notaRekomendasi->departemen_proyek, $approved_persetujuan, "Persetujuan");

                $notaRekomendasi->persetujuan_note = $request["notes"];
                $notaRekomendasi->is_disetujui = false;

                $message = "Proyek berhasil ditolak";
            }

            if ($notaRekomendasi->save() && $proyek->save()) {
                DB::commit();
                return [true, $message];
            }

            DB::rollBack();
            return [false, $message];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [false, $th->getMessage()];
        }
    }




    private function checkMatriksApproval($divisi_id, $klasifikasi_proyek, $departemen_code, $approved_data, $kategori): bool
    {
        if ($kategori == "Penyusun") {
            return $this->matriks_approvals->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("kategori", "=", $kategori)->count() == $approved_data->count();
        }
        return $this->matriks_approvals->where("divisi_id", "=", $divisi_id)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where('departemen_code', $departemen_code)->where("kategori", "=", $kategori)->count() == $approved_data->count();
    }

    private function getUserMatriksApproval($divisi_id, $klasifikasi_proyek, $departemen_code, $kategori, $user_selected = null)
    {
        if (empty($user_selected)) {
            return $this->matriks_approvals->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("kategori", "=", $kategori);
        } else {
            return $this->matriks_approvals->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("kategori", "=", $kategori)->where('nama_pegawai', '=', $user_selected)->first();
        }
    }

    private function getUrutanUserMatriksApprovalSekarang($nama_pegawai, $divisi_id, $klasifikasi_proyek, $departemen_code, $kategori)
    {
        return $this->matriks_approvals->where("nama_pegawai", "=", $nama_pegawai)->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("kategori", "=", $kategori)->first()->urutan;
    }

    private function getNomorMatriksApproval($divisi_id, $klasifikasi_proyek, $departemen_code, $kategori, $urutan = null)
    {
        $matriks_approval = $this->matriks_approvals->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("kategori", "=", $kategori);
        if (empty($urutan)) {
            return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code);
        } else {
            return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->where('urutan', '=', $urutan);
        }
    }
}
