<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\NotaRekomendasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\PenilaianPenggunaJasa;
use App\Models\MatriksApprovalRekomendasi;


class OwnerSelectionServices
{
    public $userSelected;
    public $isnomorTargetActive;

    public function __construct($nip)
    {
        $this->userSelected = User::where("nip", $nip)->first();
        $this->isnomorTargetActive = env('IS_SEND_EMAIL');
    }


    public function listProyek(Request $request)
    {
        try {
            $is_super_user = $this->userSelected->check_administrator;
            $unit_kerjas = $is_super_user ?
                ["J", "P", "H", "G"] : (str_contains($this->userSelected->unit_kerja, ",") ?
                    collect(explode(",", $this->userSelected->unit_kerja)) :
                    collect($this->userSelected->unit_kerja))->toArray();

            $matriks_user = $this->userSelected?->Pegawai?->MatriksApproval ?? null;

            $is_pic = $this->userSelected->check_administrator ? true : (empty($matriks_user) || $matriks_user->isEmpty() ? true : false);

            if ($is_pic) {
                $matriks_user = MatriksApprovalRekomendasi::all();
            }

            $matriks_category = [];

            if ($is_super_user) {
                $proyeks_proses_rekomendasi = NotaRekomendasi::whereIn("unit_kerja", $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->get()?->whereNull("is_disetujui")->filter(function ($p) {
                    return !$p->Proyek?->is_cancel;
                });
                $proyeks_rekomendasi_final = NotaRekomendasi::whereIn("unit_kerja", $unit_kerjas)->get()->whereNotNull("is_disetujui")->filter(function ($p) use ($matriks_user) {
                    return $p->Proyek?->is_cancel;
                });
                $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori']);
            } else {
                $proyeks_rekomendasi_final = NotaRekomendasi::whereIn('unit_kerja', $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->get()?->whereNotNull("is_disetujui")->filter(function ($p) use ($matriks_user) {
                    if ($matriks_user->contains(function ($item) {
                        return $item->kategori == "Penyusun" && $item->kode_unit_kerja != "RMD";
                    })) {
                        return $p->Proyek->is_cancel;
                    }
                    return $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0 || $p->Proyek->is_cancel;
                });
                $proyeks_proses_rekomendasi = NotaRekomendasi::whereIn('unit_kerja', $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->get()?->whereNull("is_disetujui")->filter(function ($p) use ($matriks_user) {
                    if ($matriks_user->contains(function ($item) {
                        return $item->kategori == "Penyusun" && $item->kode_unit_kerja != "RMD";
                    })) {
                        return !$p->Proyek->is_cancel;
                    }
                    return $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0 && !$p->Proyek->is_cancel;
                });

                $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori', 'departemen']);
            }

            // return collect(["proyeks_proses_rekomendasi" => $proyeks_proses_rekomendasi->values(), "proyeks_rekomendasi_final" => $proyeks_rekomendasi_final->values(), "matriks_category" => $matriks_category]);
            $proyeks_list = $proyeks_proses_rekomendasi->values()->merge($proyeks_rekomendasi_final->values());
            return collect(["proyeks_list" => $proyeks_list->values()]);
        } catch (\Exception $e) {
            if (empty($this->userSelected)) {
                response()->json([
                    "success" => false,
                    "message" => "User tidak ditemukan",
                    "data" => null
                ])->throwResponse();
            } else {
                response()->json([
                    "success" => false,
                    "message" => $e->getMessage(),
                    "data" => null
                ])->throwResponse();
            }
        }
    }

    public function getProyek($kode_proyek, $posisiSekarang)
    {
        try {

            $proyekSelected = NotaRekomendasi::where("kode_proyek", $kode_proyek)->first();

            if (empty($proyekSelected)) {
                Log::error("Proyek tidak ditemukan. Hubungi Admin");
                return "Proyek tidak ditemukan. Hubungi Admin";
            }

            $checkUserAccsess = $this->userSelected->Pegawai?->MatriksApproval;

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

            $proyekSelected = NotaRekomendasi::where("kode_proyek", $kode_proyek)->first();
            $proyek = $proyekSelected->Proyek;

            if (empty($proyekSelected)) {
                return [false, "Proyek tidak ditemukan. Hubungi Admin."];
            }

            $dataPengajuanApproved = collect(json_decode($proyekSelected->approved_rekomendasi));
            $dataPengajuanApproved = $dataPengajuanApproved->push([
                "user_id" => $this->userSelected->id,
                "status" => "approved",
                "tanggal" => Carbon::now(),
            ]);

            $proyekSelected->approved_rekomendasi = $dataPengajuanApproved->toJson();


            if ($buttonSelected == "Approved") {
                $hasil_assessment = collect(performAssessment($proyekSelected->Proyek->proyekBerjalan->Customer, $proyekSelected->Proyek));
                $proyekSelected->review_assessment = true;
                $proyekSelected->is_request_rekomendasi = false;
                $proyekSelected->hasil_assessment = $hasil_assessment;
                $proyekSelected->approved_rekomendasi = $dataPengajuanApproved->toJson();
                $proyekSelected->is_revisi_pengajuan = null;
                $proyekSelected->Proyek->is_request_rekomendasi = false;

                $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;

                createWordNotaRekomendasiPengajuan($proyekSelected, $request);
                createWordRekomendasi($proyek, $hasil_assessment, $is_proyek_mega);
                $nomorTarget = self::getNomorMatriksApproval($proyekSelected->divisi_id, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_code, "Penyusun")->where('urutan', '=', 1);
                foreach ($nomorTarget as $target) {
                    if (empty($proyek->is_revisi_pengajuan)) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_kriteria_" . $proyekSelected->kode_proyek;
                        $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                    } else {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_kriteria_" . $proyek->kode_proyek;
                        $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil revisi Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Hasil Revisi Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                    }

                    if (!$sendEmailUser) {
                        return [false, "Error sending email."];
                    }
                }

                if ($proyekSelected->save() && $proyekSelected->Proyek->save()) {
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

                $revisi_note = collect(json_decode($proyekSelected->revisi_pengajuan_note));
                $revisi_note->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "revisi",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $data["notes"]
                ]);

                $proyekSelected->revisi_pengajuan_note = $revisi_note;
                $proyekSelected->is_revisi_pengajuan = true;

                $request_pengajuan = collect(json_decode($proyekSelected->request_pengajuan));
                $userRequestPengajuan = User::find($request_pengajuan["user_id"]);

                $url = $request->schemeAndHttpHost() . "?nip=" . $userRequestPengajuan->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                $message = nl2br("Yth Bapak/Ibu " . $userRequestPengajuan->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi pengajuan " . $proyek->proyekBerjalan->customer->name . " untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                $sendEmailUser = sendNotifEmail($userRequestPengajuan->Pegawai, "Pemberitahuan Revisi Dokumen Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                if (!$sendEmailUser) {
                    return [false, "Error sending email"];
                }

                if (!empty($notaRekomendasi->file_pengajuan)) {
                    File::delete(public_path('file-pengajuan/' . $proyekSelected->file_pengajuan));
                }

                if (!empty($notaRekomendasi->file_rekomendasi)) {
                    File::delete(public_path('file-rekomendasi/' . $proyekSelected->file_rekomendasi));
                }

                $proyekSelected->review_assessment = null;
                $proyekSelected->hasil_assessment = null;
                $proyekSelected->file_rekomendasi = null;
                $proyekSelected->file_pengajuan = null;
                $proyekSelected->approved_rekomendasi = null;
                $proyekSelected->is_request_rekomendasi = null;
                $proyek->is_request_rekomendasi = null;

                if ($proyekSelected->save() && $proyek->save()) {
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

            $notaRekomendasi = NotaRekomendasi::where("kode_proyek", $kode_proyek)->first();
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
                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Verifikasi");

                if ($is_checked) {
                    $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                    foreach ($nomorTarget as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                        $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk permohonan pemberian rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pemberian Rekomendasi Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return [false, "Error sending email."];
                        }
                    }
                    // $proyek->is_verifikasi_approved = true;
                    $notaRekomendasi->is_verifikasi_approved = true;
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang($this->userSelected->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_$proyek->kode_proyek";
                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk proses tandatangan penyusun Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Penyusun Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return [false, "Error sending email."];
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

                $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", 1);

                foreach ($get_nomor as $user) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                    $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi asesmen " . $proyek->proyekBerjalan->customer->name . " untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                    $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Revisi Assessment Nota Rekomendasi I", $message, $this->isnomorTargetActive);
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

            $notaRekomendasi = NotaRekomendasi::where("kode_proyek", $kode_proyek)->first();
            $proyek = $notaRekomendasi->Proyek;

            if (empty($notaRekomendasi)) {
                return [false, "Proyek tidak ditemukan. Hubungi Admin."];
            }

            $kategoriRekomendasiSelected = isset($data["kategori-rekomendasi"]) ? $data["kategori-rekomendasi"] : null;

            if (empty($kategoriRekomendasiSelected)) {
                return [false, "Mohon isi kategori rekomendasi terlebih dahulu."];
            }

            if (!empty($notaRekomendasi->approved_rekomendasi_final)) {
                $is_has_not_recommended = collect(json_decode($notaRekomendasi->approved_rekomendasi_final))->where('status', 'rejected')->count() > 0;
            }

            if ($kategoriRekomendasiSelected == "Direkomendasikan Dengan Catatan") {

                if (empty($request["notes"])) {
                    return [false, "Mohon isi catatan terlebih dahulu"];
                }

                $approved_rekomendasi_final = collect(json_decode($notaRekomendasi->approved_rekomendasi_final));
                $approved_rekomendasi_final->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_rekomendasi_final, "Rekomendasi");

                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_recommended = false;
                        $notaRekomendasi->is_disetujui = false;

                        $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                        $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                        $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                    } else {
                        $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Persetujuan");
                        foreach ($matriks_approval as $key => $user) {
                            $user = $user->Pegawai->User;
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return [false, "Error sending email"];
                            }
                        }
                        $notaRekomendasi->is_recommended_with_note = true;
                        $notaRekomendasi->is_recommended = true;
                    }
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang($this->userSelected->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
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

                $approved_rekomendasi_final = collect(json_decode($notaRekomendasi->approved_rekomendasi_final));
                $approved_rekomendasi_final->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_rekomendasi_final, "Rekomendasi");
                if ($is_checked) {
                    if ($is_has_not_recommended) {

                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_recommended = false;
                        $notaRekomendasi->is_disetujui = false;


                        $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                        $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                        $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                    }
                }

                $message = "Proyek berhasil ditolak";
            } elseif ($kategoriRekomendasiSelected == "Direkomendasikan") {
                $approved_rekomendasi_final = collect(json_decode($notaRekomendasi->approved_rekomendasi_final));
                $approved_rekomendasi_final->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["notes"],
                ]);

                $notaRekomendasi->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_rekomendasi_final, "Rekomendasi");

                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_recommended = false;
                        $notaRekomendasi->is_disetujui = false;

                        $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                        $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                        $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                    } else {
                        $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Persetujuan");
                        foreach ($matriks_approval as $key => $user) {
                            $user = $user->Pegawai->User;
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap I untuk " . $proyek->proyekBerjalan->customer->name . " pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return [false, "Error sending email"];
                            }
                        }

                        $notaRekomendasi->is_recommended = true;
                    }
                }

                $message = "Proyek berhasil disetujui";
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang($this->userSelected->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return [false, "Error sending email"];
                            }
                        }
                    }
                }
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

            $notaRekomendasi = NotaRekomendasi::where("kode_proyek", $kode_proyek)->first();
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
                    "catatan" => $data["notes"]
                ]);
                $notaRekomendasi->approved_persetujuan = $approved_persetujuan->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_persetujuan, "Persetujuan");
                if ($is_checked) {
                    $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                    $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                    $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));

                    $notaRekomendasi->is_disetujui = true;
                    $notaRekomendasi->persetujuan_note = $request["catatan-persetujuan"];
                    $proyek->is_disetujui = true;

                    $message = "Proyek berhasil disetujui";
                }
            } elseif ($buttonSelected == "Rejected") {

                $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;

                $approved_persetujuan = collect(json_decode($notaRekomendasi->approved_persetujuan));
                $approved_persetujuan->push([
                    "user_id" => $this->userSelected->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $data["notes"],
                ]);

                $notaRekomendasi->approved_persetujuan = $approved_persetujuan->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_persetujuan, "Persetujuan");

                $notaRekomendasi->persetujuan_note = $request["catatan-persetujuan"];
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






    private function checkValidateUserMatriks($nip, Proyek $proyek, $kategori)
    {
        try {
            $matriksSelected = MatriksApprovalRekomendasi::where('nama_pegawai', $nip)
                ?->where("unit_kerja", $proyek->UnitKerja?->Divisi?->id_divisi)
                ?->where("departemen", $proyek->departemen_proyek)
                ?->where("kategori", $kategori)
                ?->where("klasifikasi_proyek", $proyek->departemen_proyek)
                ?->where("is_active", true)
                ?->first();

            return $matriksSelected;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }

    private function getNomorMatriksApproval($id_divisi, $klasifikasi_pasdin, $departemen, $kategori, $urutan = null)
    {
        $matriks_approval = MatriksApprovalRekomendasi::where("is_active", true)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori);
        if (empty($urutan)) {
            if ($kategori == "Persetujuan") {
                return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->get();
            } else {
                if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi" || $kategori == "Penyusun") {
                    return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->get();
                }
                return $matriks_approval->get();
            }
        } else {
            if ($kategori == "Persetujuan") {
                return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->where('urutan', '=', $urutan)->get();
            } else {
                if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi" || $kategori == "Penyusun") {
                    return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->where('urutan', '=', $urutan)->get();
                }
                return $matriks_approval->where('urutan', '=', $urutan)->get();
            }
        }
    }

    private function checkMatriksApproval($unit_kerja, $klasifikasi_proyek, $departemen, $approved_data, $kategori): bool
    {
        $matriks_approval = MatriksApprovalRekomendasi::where("start_tahun", "=", (int) date("Y"))->get();
        if ($kategori == "Penyusun") {
            if ($matriks_approval->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("kategori", "=", $kategori)->where("urutan", "=", 1)->count() > 1) {
                return ($matriks_approval->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("kategori", "=", $kategori)->count() - 1) == $approved_data->count();
            } else {
                return $matriks_approval->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("kategori", "=", $kategori)->count() == $approved_data->count();
            }
        }
        return $matriks_approval->where("unit_kerja", "=", $unit_kerja)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where('departemen', $departemen)->where("kategori", "=", $kategori)->count() == $approved_data->count();
    }

    private function getUserMatriksApproval($unit_kerja, $klasifikasi_pasdin, $departemen, $kategori, $user_selected = null)
    {
        if (empty($user_selected)) {
            return MatriksApprovalRekomendasi::where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori)->get();
        } else {
            return MatriksApprovalRekomendasi::where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori)->where('nama_pegawai', '=', $user_selected)->first();
        }
    }

    private function getUrutanUserMatriksApprovalSekarang($nip, $unit_kerja, $klasifikasi_pasdin, $departemen, $kategori)
    {
        return MatriksApprovalRekomendasi::where("nama_pegawai", "=", $nip)->where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori)->first()->urutan;
    }
}
