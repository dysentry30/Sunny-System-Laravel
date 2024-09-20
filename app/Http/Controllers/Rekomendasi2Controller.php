<?php

namespace App\Http\Controllers;

use App\Models\KriteriaProjectSelectionDetail;
use App\Models\KriteriaSelectionNonGreenlane;
use App\Models\MatriksApprovalNotaRekomendasi2;
use App\Models\NotaRekomendasi2;
use App\Models\MasterCatatanNotaRekomendasi2;
use App\Models\DokumenNotaRekomendasi2;
use App\Models\MatriksApprovalPaparan;
use App\Models\TimTender;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Karriere\PdfMerge\PdfMerge;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class Rekomendasi2Controller extends Controller
{
    public $matriks_approvals;
    public $isnomorTargetActive;
    public $nomorDefault;

    public function __construct()
    {
        $this->matriks_approvals = MatriksApprovalNotaRekomendasi2::where("is_active", true)->get();
        $this->matriks_approvals = $this->matriks_approvals->first();
        $this->isnomorTargetActive = env('IS_SEND_EMAIL');
        $this->nomorDefault = "085881028391";
        // $this->nomorDefault = "6285376444701";
    }

    public function index(Request $request)
    {

        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
        $unit_kerjas = $is_super_user && str_contains(Auth::user()->name, "Admin") ?
            UnitKerja::select('divcode')->get()->map(function ($unit_kerja) {
                return $unit_kerja["divcode"];
            }) : (str_contains(Auth::user()->unit_kerja, ",") ?
                collect(explode(",", Auth::user()->unit_kerja)) :
                collect(Auth::user()->unit_kerja))->toArray();

        $all_super_user_counter = MatriksApprovalNotaRekomendasi2::all()->filter(function ($user) {
            if ($user->is_ktt) {
                return TimTender::where('nip_pegawai', Auth::user()->nip)->where('posisi', 'Ketua')->first();
            } else {
                return $user->Pegawai->nip == Auth::user()->nip;
            }
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            if ($user->is_ktt) {
                return TimTender::where('nip_pegawai', Auth::user()->nip)->where('posisi', 'Ketua')->first();
            } else {
                return $user->Pegawai->nip == Auth::user()->nip;
            }
        });
        $matriks_category = [];

        $is_matriks_has_ktt = $all_super_user_counter->contains(function ($value) {
            return $value->is_ktt;
        });

        // dd($all_super_user_counter);

        if (Gate::allows('super-admin')) {
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
                return $user->Pegawai->nama_pegawai == Auth::user()->name;
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
                $matriks_user = Auth::user()->Pegawai?->MatriksApproval2;
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

        if ($matriks_user->isEmpty() && Gate::any(["admin-crm"])) {
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

        $matriks_category = MatriksApprovalNotaRekomendasi2::all()->groupBy(['klasifikasi_proyek', 'kategori', 'departemen_code']);

        $kriteriaAssessmentProjectSelection = KriteriaSelectionNonGreenlane::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaAssessmentProjectSelectionDetail = KriteriaProjectSelectionDetail::all();

        $masterCatatanRekomendasi = MasterCatatanNotaRekomendasi2::all()->sortBy('urutan')->values();

        return view('17_Nota_Rekomendasi_2', [
            "proyeks_proses_paparan" => $proyeks_proses_paparan,
            "proyeks_proses_rekomendasi" => $proyeks_proses_rekomendasi,
            "proyeks_rekomendasi_final" => $proyeks_rekomendasi_final,
            "matriks_user" => $matriks_user,
            "matriks_paparan" => $matriks_paparan,
            "matriks_category" => $matriks_category,
            "is_user_exist_in_matriks_approval" => $is_user_exist_in_matriks_approval,
            "kriteriaAssessmentProjectSelection" => $kriteriaAssessmentProjectSelection,
            "kriteriaAssessmentProjectSelectionDetail" => $kriteriaAssessmentProjectSelectionDetail,
            "masterCatatanRekomendasi" => $masterCatatanRekomendasi
        ]);
    }

    /**
     * Proses Pengajuan
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProsesPengajuan(Request $request, $kode_proyek)
    {
        $proyekPengajuan = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekPengajuan->Proyek;

        if (empty($proyekPengajuan)) {
            Alert::error('Error', 'Proyek Tidak ditemukan, Silahkan Hubungi Admin');
            return redirect()->back();
        }

        //Flow Disetujui

        if (isset($request->setuju)) {
            $is_paralel = false;

            //Memasukkan Record User yg Approved
            $data = collect(json_decode($proyekPengajuan->approved_pengajuan));
            $data = $data->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => Carbon::now(),
            ]);

            $proyekPengajuan->approved_pengajuan = $data->toJson();

            //Check Matriksnya apakah sudah semuanya melakukan approval atau belum
            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $data, "Pengajuan");

            if ($is_checked) {
                if (is_null($proyekPengajuan->revisi_pengajuan_note)) {
                    $matriks_paparan = MatriksApprovalPaparan::where("divisi_id", "=", $proyekSelected->UnitKerja->Divisi->id_divisi)->where("klasifikasi_proyek", "=", $proyekSelected->klasifikasi_pasdin)->where("departemen_code", $proyekSelected->departemen_proyek)->where("kategori", "=", "Pengajuan")->where('is_active', true)->get();
                    if ($matriks_paparan->isEmpty()) {
                        Alert::error('Error', 'Matriks untuk paparan tidak ditemukan. Hubungi Admin!');
                        return redirect()->back();
                    }

                    foreach ($matriks_paparan as $user) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_req_paparan_$proyekSelected->kode_proyek";
                        $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan pengajuan tanggal paparan untuk Nota Rekomendasi II, " . $proyekSelected->proyekBerjalan->name_customer . " untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Pengajuan Waktu Paparan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                } else {
                    $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun")->where('urutan', '=', 1);
                    foreach ($nomorTarget as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_rekomendasi_" . $proyekPengajuan->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil revisi untuk proyek " . $proyekSelected->nama_proyek . " untuk permohonan pengajuan rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Revisi Pengajuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                }

                createWordPengajuanNota2($proyekPengajuan, Auth::user()->nip);
                $proyekPengajuan->is_pengajuan_approved = true;
                $proyekPengajuan->is_request_rekomendasi = false;
                $proyekPengajuan->is_request_paparan = true;
                $proyekPengajuan->approved_pengajuan = $data->toJson();
            }

            if ($proyekPengajuan->save()) {
                Alert::html("Success", "Pengajuan Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> berhasil disetujui", "success");
                return redirect()->back();
            }
        } else {
            $data = collect(json_decode($proyekPengajuan->approved_pengajuan));
            $data = $data->push(
                [
                    "user_id" => Auth::user()->id,
                    "status" => "rejected",
                    "alasan" => $request->get("alasan-ditolak"),
                    "tanggal" => \Carbon\Carbon::now(),
                ]
            );
            // dd($data);
            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $data, "Pengajuan");
            if ($is_checked) {
                $proyekPengajuan->is_rekomendasi_approved = false;
                $proyekPengajuan->is_request_rekomendasi = false;
                $proyekPengajuan->is_disetujui = false;
            }
            $proyekPengajuan->approved_rekomendasi = $data->toJson();
            if ($proyekPengajuan->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> ditolak", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        }
    }


    /**
     * Proses Penyusun
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProsesPenyusun(Request $request, $kode_proyek)
    {
        $proyekPenyusun = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekPenyusun->Proyek;

        $is_paralel = false;

        $data = collect(json_decode($proyekPenyusun->approved_penyusun));
        $proyekPenyusun->catatan_master = null;
        $dataCatatanNota = collect([]);

        $catatanMasterInput = $request->get("catatan_nota_rekomendasi_master");

        foreach ($catatanMasterInput as $key => $catatan) {
            $urutan = null;
            $checked = false;
            if (!empty($request->get("master_selected_" . $key + 1))) {
                $urutan = (int)$request->get("master_selected_" . $key + 1);
                $checked = true;
            } else {
                $urutan = $key + 1;
                $checked = false;
            }
            
            $dataCatatanNota = $dataCatatanNota->push([
                "urutan" => $urutan,
                "checked" => $checked,
                "uraian" => $catatan
            ]);
        }

        
        //Proses Save Draft
        if (isset($request["save-draft-note-rekomendasi"])) {
            $proyekPenyusun->catatan_master = $dataCatatanNota->toJson();
            $proyekPenyusun->is_draft_recommend_note = true;

            $data = collect(json_decode($proyekPenyusun->approved_penyusun));
            if ($data->isNotEmpty()) {
                $data = $data->where('user_id', Auth::user()->id);
                if ($data->isNotEmpty()) {
                    $key_data = $data->keys()->first();
                    $data->forget($key_data);
                }
            }
            $data = $data->push(
                [
                    "user_id" => Auth::user()->id,
                    "status" => "draft",
                    "catatan" => $request->get("note-rekomendasi"),
                    "tanggal" => \Carbon\Carbon::now()
                ]
            );
            $proyekPenyusun->approved_penyusun = $data->values()->toJson();
            $proyekPenyusun->catatan_nota_rekomendasi = $request->get("note-rekomendasi");
            if ($proyekPenyusun->save()) {
                Alert::html("Success", "Penyusunan dengan nama proyek <b>$proyekSelected->nama_proyek</b> berhasil disimpan sebagai draft", "success");
                return redirect()->back();
            }
        } else {
            //Proses Save Final
            if ($data->where('user_id', Auth::user()->id)->isEmpty()) {
                $data = $data->push(
                    [
                        "user_id" => Auth::user()->id,
                        "status" => "approved",
                        "catatan" => $request->get("note-rekomendasi") ?? '-',
                        "tanggal" => \Carbon\Carbon::now()
                    ]
                );
                $proyekPenyusun->approved_penyusun = $data->toJson();
            } elseif ($data->where('user_id', Auth::user()->id)->isNotEmpty()) {
                $data = $data->where('user_id', Auth::user()->id);
                $key_data = $data->keys()->first();
                $data->forget($key_data);

                $data = $data->push(
                    [
                        "user_id" => Auth::user()->id,
                        "status" => "approved",
                        "catatan" => $request->get("note-rekomendasi") ?? '-',
                        "tanggal" => \Carbon\Carbon::now()
                    ]
                );

                $proyekPenyusun->approved_penyusun = $data->values()->toJson();
            }

            $proyekPenyusun->catatan_nota_rekomendasi = $request->get("note-rekomendasi");
            $proyekPenyusun->catatan_master = $dataCatatanNota->toJson();

            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $data, "Penyusun");

            if ($is_checked) {
                $proyekPenyusun->is_penyusun_approved = true;
                createWordKriteriaProjectSelection($proyekPenyusun);
                sleep(5);
                mergeFileDokumenAssessmentProject($proyekPenyusun);

                if (is_null($proyekPenyusun->is_revisi)) {
                    if (str_contains($proyekSelected->klasifikasi_pasdin, "Mega")) {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen proyek " . $proyekSelected->nama_proyek . " untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } elseif (str_contains($proyekSelected->klasifikasi_pasdin, "Besar")) {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen proyek " . $proyekSelected->nama_proyek . " untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } else {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_rekomendasi_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen proyek " . $proyekSelected->nama_proyek . " untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }

                        $approved_verifikasi = collect(json_decode($proyekPenyusun->approved_penyusun));
                        // $approved_verifikasi->push([
                        //     "user_id" => Auth::user()->id,
                        //     "status" => "approved",
                        //     "tanggal" => \Carbon\Carbon::now(),
                        // ]);
                        $proyekPenyusun->approved_verifikasi = $approved_verifikasi->toJson();
                        $proyekPenyusun->is_verifikasi_approved = true;
                    }
                } else {
                    if (str_contains($proyekSelected->klasifikasi_pasdin, "Mega")) {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan revisi asesmen untuk proses verifikasi penyusunan Nota Rekomendasi tahap II pada proyek $proyekPenyusun->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Revisi Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } elseif (str_contains($proyekSelected->klasifikasi_pasdin, "Besar")) {
                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan revisi asesmen untuk proses verifikasi penyusunan Nota Rekomendasi tahap II pada proyek $proyekPenyusun->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Revisi Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    }

                    $proyekPenyusun->is_revisi = null;
                }

                $proyekPenyusun->is_draft_recommend_note = false;
            } else {
                if (!$is_paralel) {
                    if (str_contains($proyekSelected->klasifikasi_pasdin, "Mega")) {
                        $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                if ($user->is_ktt) {
                                    $user = $proyekSelected->TimTender->where('posisi', 'Ketua')->first();
                                }

                                if (empty($user->Pegawai)) {
                                    Alert::error('Error', 'KTT Belum ditentukan, mohon untuk mengisi KTT');
                                    return redirect()->back();
                                }
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_$proyekPenyusun->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi II, " . $proyekPenyusun->Proyek->proyekBerjalan->name_customer . " untuk Proyek $proyekPenyusun->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Hasil Revisi Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                                
                            }
                        }
                    } elseif (str_contains($proyekSelected->klasifikasi_pasdin, "Besar")) {
                        $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang, $proyekPenyusun) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                if ($user->is_ktt) {
                                    $user = $proyekSelected->TimTender->where('posisi', 'Ketua')->first();
                                }

                                if (empty($user->Pegawai)) {
                                    Alert::error('Error', 'KTT Belum ditentukan, mohon untuk mengisi KTT');
                                    return redirect()->back();
                                }
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_$proyekPenyusun->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi II, " . $proyekPenyusun->Proyek->proyekBerjalan->name_customer . " untuk Proyek $proyekPenyusun->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Pengajuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    } else {
                        $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun");

                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang, $proyekPenyusun) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);

                            foreach ($get_nomor as $user) {
                                if ($user->is_ktt) {
                                    $user = $proyekSelected->TimTender->where('posisi', 'Ketua')->first();
                                }

                                if (empty($user->Pegawai)) {
                                    Alert::error('Error', 'KTT Belum ditentukan, mohon untuk mengisi KTT');
                                    return redirect()->back();
                                }

                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_$proyekPenyusun->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi II, " . $proyekPenyusun->Proyek->proyekBerjalan->name_customer . " untuk Proyek $proyekPenyusun->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Pengajuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    }
                }
            }

            if ($proyekPenyusun->save()) {
                Alert::html("Success", "Penyusunan dengan nama proyek <b>$proyekPenyusun->nama_proyek</b> berhasil", "success");
                // createWordPersetujuan($proyekPenyusun, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
            Alert::html("Failed", "Penyusunan dengan nama proyek <b>$proyekPenyusun->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        }
    }


    /**
     * Proses Penyusun Revisi ke PIC NR 2
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProyekPengajuanRevisi(Request $request, $kode_proyek)
    {
        $proyekPengajuanRevisi = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekPengajuanRevisi->Proyek;

        if (empty($request["revisi-note"]) || empty($request['revisi-pengajuan'])) {
            Alert::error('Proses Gagal', 'Mohon isi catatan revisi terlebih dahulu');
            return redirect()->back();
        }

        $data = collect(json_decode($proyekPengajuanRevisi->revisi_pengajuan_note));

        $data = $data->push([
            "user_id" => Auth::user()->id,
            "status" => "revisi",
            "catatan" => $request->get("revisi-note") ?? '-',
            "tanggal" => \Carbon\Carbon::now()
        ]);

        try {
            //Hapus progress history penyusun yg sudah ada sebelumnya
            $proyekPengajuanRevisi->is_draft_recommend_note = null;
            $proyekPengajuanRevisi->is_recommended_with_note = null;
            $proyekPengajuanRevisi->catatan_nota_rekomendasi = null;
            $proyekPengajuanRevisi->catatan_master = null;
            $proyekPengajuanRevisi->is_penyusun_approved = null;
            $proyekPengajuanRevisi->approved_penyusun = null;

            //Hapus progress history pengajuan yg sudah ada sebelumnya
            $proyekPengajuanRevisi->is_pengajuan_approved = null;
            $proyekPengajuanRevisi->approved_pengajuan = null;

            //Delete file pengajuan yg tergenerate sebelumnya
            File::delete(public_path('nota-rekomendasi-2/file-pengajuan/' . $proyekPengajuanRevisi->file_pengajuan));
            $proyekPengajuanRevisi->file_pengajuan = null;

            //Setting is_request_rekomendasi menjadi true kembali
            $proyekPengajuanRevisi->is_request_rekomendasi = true;

            //Setting is_revisi_pengajuan = true & input catatan
            $proyekPengajuanRevisi->is_revisi_pengajuan = true;
            $proyekPengajuanRevisi->revisi_pengajuan_note = $data->toJson();

            //Save perubahan
            $proyekPengajuanRevisi->save();

            //Check matriks ke verifikasi pengajuan dari SM Marketing
            $nomorTarget = self::getNomorMatriksApprovalPaparan($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Pengajuan");
            foreach ($nomorTarget as $user) {

                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai?->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_history_revisi_pengajuan_$proyekSelected->kode_proyek";
                $message = "Yth Bapak/Ibu " . $user->Pegawai?->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan revisi untuk Nota Rekomendasi II, " . $proyekSelected->proyekBerjalan->name_customer . " untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Revisi Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }
            }

            Alert::html("Success", "Nota Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> berhasil dikembalikan ke PIC", "success");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }


    /**
     * Proses Verifikasi
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProyekVerifikasi(Request $request, $kode_proyek)
    {
        $proyekVerifikasi = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekVerifikasi->Proyek;

        if (isset($request["verifikasi-setujui"])) {
            $is_paralel = false;
            $approved_verifikasi = collect(json_decode($proyekVerifikasi->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $proyekVerifikasi->approved_verifikasi = $approved_verifikasi->toJson();
            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $approved_verifikasi, "Verifikasi");

            if ($is_checked) {
                $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                foreach ($nomorTarget as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_rekomendasi_" . $proyekVerifikasi->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen untuk proyek " . $proyekSelected->nama_proyek . " untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }
                $proyekVerifikasi->is_verifikasi_approved = true;
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi");

                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi");
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            if ($user->is_ktt) {
                                $user = $proyekSelected->TimTender->where('posisi', 'Ketua')->first();
                            }

                            if (empty($user->Pegawai)) {
                                Alert::error('Error', 'KTT Belum ditentukan, mohon untuk mengisi KTT');
                                return redirect()->back();
                            }
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_verifikasi_$proyekVerifikasi->kode_proyek";
                            $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen untuk proyek " . $proyekSelected->nama_proyek . " untuk proses tandatangan penyusun Nota Rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Hasil Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    }
                }
            }
            if ($proyekVerifikasi->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> telah disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 2</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 2</b>", "error");
            return redirect()->back();
        } elseif (isset($request["verifikasi-revisi"])) {
            if (empty($request["revisi-note"])) {
                Alert::error('Mohon isi catatan revisi');
                return redirect()->back();
            }

            $revisi_note = collect(json_decode($proyekVerifikasi->revisi_note));
            $revisi_note->push([
                "user_id" => Auth::user()->id,
                "status" => "revisi",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["revisi-note"]
            ]);

            $proyekVerifikasi->revisi_note = $revisi_note;
            $proyekVerifikasi->is_revisi = true;

            $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun", 1);

            foreach ($get_nomor as $user) {
                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_proyek_persetujuan_$proyekSelected->kode_proyek";
                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi asesmen untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Revisi Assessment Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }
            }

            $proyekVerifikasi->is_penyusun_approved = null;
            $proyekVerifikasi->approved_penyusun = null;
            $proyekVerifikasi->approved_verifikasi = null;
            $proyekVerifikasi->is_draft_recommend_note = null;

            if ($proyekVerifikasi->save()) {
                Alert::html("Success", "Proyek dengan nama proyek <b>$proyekSelected->nama_proyek</b> berhasil dikembalikan ke Penyusun", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Proyek dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal dikembalikan ke Penyusun", "error");
            return redirect()->back();
        } elseif (isset($request["verifikasi-tolak"])) {

            $approved_verifikasi = collect(json_decode($proyekVerifikasi->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $proyekVerifikasi->approved_verifikasi = $approved_verifikasi->toJson();
            $proyekVerifikasi->is_verifikasi_approved = false;
            $proyekVerifikasi->is_disetujui = false;

            createWordPersetujuanNota2($proyekVerifikasi, $request->schemeAndHttpHost());

            if ($proyekVerifikasi->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> telah ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 2</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 2</b>", "error");
            return redirect()->back();
        }
    }

    /**
     * Proses Rekomendasi
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProyekRekomendasi(Request $request, $kode_proyek)
    {
        $is_paralel = true;
        $proyekRekomendasi = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekRekomendasi->Proyek;
        $data = $request->all();

        if (!isset($data["kategori-rekomendasi"]) && is_null($data["kategori-rekomendasi"])) {
            Alert::html("Failed", "<b>Kategori Rekomendasi</b> harap diisi!", "error");
            return redirect()->back();
        }

        if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan dengan catatan") {
            $approved_rekomendasi = collect(json_decode($proyekRekomendasi->approved_rekomendasi));
            $approved_rekomendasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            $proyekRekomendasi->approved_rekomendasi = $approved_rekomendasi->toJson();

            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $approved_rekomendasi, "Rekomendasi");
            // dd($is_checked);
            if ($is_checked) {
                $matriks_approval = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Persetujuan");

                foreach ($matriks_approval as $key => $user) {
                    $user = $user->Pegawai->User;
                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $proyekSelected->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }
                $proyekRekomendasi->is_recommended_with_note = true;
                $proyekRekomendasi->is_rekomendasi_approved = true;
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $proyekSelected->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    }
                }
            }
            Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> disetujui oleh tim Rekomendasi dengan catatan", "success");
        } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Tidak Direkomendasikan") {
            $approved_verifikasi = collect(json_decode($proyekRekomendasi->approved_rekomendasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            $proyekRekomendasi->approved_rekomendasi = $approved_verifikasi->toJson();

            $proyekRekomendasi->is_rekomendasi_approved = false;
            $proyekRekomendasi->is_disetujui = false;

            if ($proyekRekomendasi->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> ditolak oleh tim Rekomendasi", "success");
                return redirect()->back();
            }
        } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan") {
            $approved_verifikasi = collect(json_decode($proyekRekomendasi->approved_rekomendasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            $proyekRekomendasi->approved_rekomendasi = $approved_verifikasi->toJson();

            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $approved_verifikasi, "Rekomendasi");
            if ($is_checked) {
                $matriks_approval = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Persetujuan");
                foreach ($matriks_approval as $key => $user) {
                    $user = $user->Pegawai->User;
                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $proyekSelected->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap II untuk " . $proyekSelected->proyekBerjalan->customer->name . " pada proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }
                $proyekRekomendasi->is_rekomendasi_approved = true;
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $proyekSelected->kode_proyek;
                            $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    }
                }
            }
            Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> disetujui oleh tim Rekomendasi", "success");
        }

        if ($proyekRekomendasi->save()) {
            return redirect()->back();
        }
        Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 2</b>", "error");
        return redirect()->back();
    }

    /**
     * Proses Persetujuan
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProyekPersetujuan(Request $request, $kode_proyek)
    {
        $proyekPersetujuan = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekPersetujuan->Proyek;

        if (isset($request["persetujuan-setujui"])) {
            $approved_persetujuan = collect(json_decode($proyekPersetujuan->approved_persetujuan));
            $approved_persetujuan->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["catatan-persetujuan"]
            ]);
            $proyekPersetujuan->approved_persetujuan = $approved_persetujuan->toJson();

            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $approved_persetujuan, "Persetujuan");
            if ($is_checked) {
                $proyekPersetujuan->is_disetujui = true;
                $proyekPersetujuan->persetujuan_note = $request["catatan-persetujuan"];
                // createWordPersetujuanNota2($proyekPersetujuan, $request->schemeAndHttpHost());
            }
            if ($proyekPersetujuan->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekPersetujuan->nama_proyek</b> telah disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 2</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekPersetujuan->nama_proyek</b> gagal disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 2</b>", "error");
            return redirect()->back();
        } elseif ($request["persetujuan-tolak"]) {
            $approved_verifikasi = collect(json_decode($proyekPersetujuan->approved_persetujuan));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            $proyekPersetujuan->approved_persetujuan = $approved_verifikasi->toJson();

            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $approved_verifikasi, "Persetujuan");
            $proyekPersetujuan->persetujuan_note = $request["catatan-persetujuan"];
            $proyekPersetujuan->is_disetujui = false;

            if ($proyekPersetujuan->save()) {
                // createWordPersetujuanNota2($proyekPersetujuan, $request->schemeAndHttpHost());
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> telah ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        }
    }

    /**
     * Proses Paparan Proyek
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProyekPemaparan(Request $request, $kode_proyek)
    {
        $ProyekPemaparan = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $ProyekPemaparan->Proyek;

        $data = $request->all();
        $kategori = $data['kategori'];

        if ($kategori == "Pengajuan") {
            $ProyekPemaparan->tanggal_paparan_diajukan = $data["tanggal-pengajuan-paparan"];
            $nomorTargetPaparan = self::getNomorMatriksApprovalPaparan($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Persetujuan");
            $inputFileNotulen = isset($data['file-pemaparan']) ? $data['file-pemaparan'] : [];
            $inputFileAbsensi = isset($data['file-absensi-paparan']) ? $data['file-absensi-paparan'] : [];

            // if (empty($inputFileNotulen) || empty($inputFileAbsensi)) {
            //     Alert::error('Dokumen Belum Lengkap', "Mohon lengkapi dokumen paparan");
            //     return redirect()->back();
            // }

            if (!empty($inputFileNotulen)) {
                $collectFileNotulen = collect([]);
                foreach ($inputFileNotulen as $fileNotulen) {
                    $id_document = date("His_") .  str_replace(' ', '-', $fileNotulen->getClientOriginalName());
                    $collectFileNotulen->push($id_document);
                    $fileNotulen->move(public_path('file-nota-rekomendasi-2/file-notulen-paparan/'), $id_document);
                }
                $ProyekPemaparan->file_pemaparan = $collectFileNotulen->toJson();
            }

            if (!empty($inputFileAbsensi)) {
                $collectFileAbsensi = collect([]);
                foreach ($inputFileAbsensi as $fileAbsensi) {
                    $id_document = date("His_") .  str_replace(' ', '-', $fileAbsensi->getClientOriginalName());
                    $collectFileAbsensi->push($id_document);
                    $fileAbsensi->move(public_path('file-nota-rekomendasi-2/file-absensi-paparan/'), $id_document);
                }
                $ProyekPemaparan->file_absensi_paparan = $collectFileAbsensi->toJson();
            }

            foreach ($nomorTargetPaparan as $user) {
                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai?->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_req_paparan_setuju_$proyekSelected->kode_proyek";
                $message = "Yth Bapak/Ibu " . $user->Pegawai?->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan waktu paparan untuk Nota Rekomendasi II, " . $proyekSelected->proyekBerjalan->name_customer . " untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Persetujuan Waktu Paparan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }
            }
        } else {
            $ProyekPemaparan->tanggal_paparan_disetujui = $data["tanggal-persetujuan-paparan"];
            $nomorTargetPaparan = self::getNomorMatriksApprovalPaparan($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Pengajuan");
            mergeDokumenKelengkapanProject($ProyekPemaparan);

            foreach ($nomorTargetPaparan as $user) {
                // if ($user->is_ktt) {
                //     $user = $proyekSelected->TimTender->where('posisi', 'Ketua')->first();
                // }

                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai?->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_req_paparan_setuju_$proyekSelected->kode_proyek";
                $message = "Yth Bapak/Ibu " . $user->Pegawai?->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan waktu paparan untuk Nota Rekomendasi II, " . $proyekSelected->proyekBerjalan->name_customer . " untuk Proyek $proyekSelected->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Waktu Paparan Nota Rekomendasi II", nl2br($message), $this->isnomorTargetActive);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }
            }

            $ProyekPemaparan->is_request_paparan = false;
            $ProyekPemaparan->is_sudah_pemaparan = true;
        }

        if ($ProyekPemaparan->save()) {
            $messageAllert = $kategori == "Pengajuan" ?
            "<b>Tanggal Pengajuan Paparan</b> dengan nama proyek <b>$proyekSelected->nama_proyek</b> berhasil" :
            "<b>Tanggal Pengajuan Paparan</b> dengan nama proyek <b>$proyekSelected->nama_proyek</b> berhasil";

            Alert::html("Success", $messageAllert, "success");
            return redirect()->back();
        }

        $messageAllert = $kategori == "Pengajuan" ?
        "<b>Tanggal Pengajuan Paparan</b> dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal" :
        "<b>Tanggal Pengajuan Paparan</b> dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal";

        Alert::html("Error", $messageAllert, "error");
        return redirect()->back();
    }

    // public function UploadDokumenFinal(Request $request, $kode_proyek)
    // {
    //     $data = $request->all();

    //     if (!isset($data['file-document'])) {
    //         Alert::error('Error', "Mohon tambahkan file terlebih dahulu");
    //         return redirect()->back();
    //     }

    //     try {
    //         $file = $data['file-document'];

    //         $nama_file = $file->getClientOriginalName();
    //         $id_document = date('dmYHis_') . str_replace(' ', '', $file->getClientOriginalName());

    //         $newDocument = new DokumenNotaRekomendasi2();
    //         $newDocument->nama_document = $nama_file;
    //         $newDocument->id_document = $id_document;

    //         if ($newDocument->save()) {
    //             $file->move(public_path('file-nota-rekomendasi-2/file-final-rekomendasi-2'), $id_document);
    //             Alert::success('Success', "Dokumen Final Nota Rekomendasi 2 Berhasil ditambahkan");
    //             return redirect()->back();
    //         }
    //     } catch (\Exception $e) {
    //         Alert::error('Error', $e->getMessage());
    //         return redirect()->back();
    //     }
    // }

    public function viewProyekQrCode(Request $request, $kode_proyek, $nip)
    {
        try {
            $ProyekNotaQrSelected = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
            $proyekSelected = $ProyekNotaQrSelected->Proyek;

            $kategori = $request->get("kategori");

            switch ($kategori) {
                case 'pengajuan':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_pengajuan));
                    break;
                case 'penyusun':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_verifikasi));
                    break;
                case 'rekomendasi':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_rekomendasi));
                    break;
                case 'persetujuan':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_persetujuan));
                    break;

                default:
                    $collectPenandatangan = null;
                    break;
            }

            $userSelected = User::where('nip', $nip)->first();

            $penandatanganSelected = $collectPenandatangan->where('user_id', $userSelected->id)->first();

            if (!empty($penandatanganSelected)) {
                $penandatanganSelected->user_id = $userSelected->name;

                $penandatanganSelected->jabatan = $userSelected->Pegawai?->Jabatan?->nama_jabatan ?? null;

                $penandatanganSelected->tanggal = Carbon::parse($penandatanganSelected->tanggal)->translatedFormat('d F Y, H:i:s');
            }


            return view('22_View_TTD_Barcode_Nota_2', ["penandatanganSelected" => $penandatanganSelected, "dataNotaRekomendasi" => $ProyekNotaQrSelected, "proyek" => $proyekSelected]);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'Attempt to read property "id" on null') {
                throw new \Exception('Pegawai tidak ditemukan. Mohon Hubungi Admin!', 0, $e);
            } else {
                throw $e;
            }
        }
    }

    public function mergeFinalFile(Request $request, $kode_proyek)
    {
        try {
            $proyekPersetujuan = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
            createWordPersetujuanNota2($proyekPersetujuan, $request->schemeAndHttpHost());

            $pdfMerge = new pdfMerge();
            $file_name = date("dmYHis_") . "Dokumen_Nota_Rekomendasi_" . $proyekPersetujuan->Proyek->nama_proyek . "_Final.pdf";

            sleep(5);

            if (!empty($proyekPersetujuan->file_persetujuan)) {
                $pdfMerge->add(public_path('file-nota-rekomendasi-2/file-persetujuan/' . $proyekPersetujuan->file_persetujuan));
            }

            if (!empty($proyekPersetujuan->file_assessment_merge)) {
                $pdfMerge->add(public_path('file-nota-rekomendasi-2/file-kriteria-project-selection/' . $proyekPersetujuan->file_assessment_merge));
            }

            if (!empty($proyekPersetujuan->file_kelengkapan_merge)) {
                $pdfMerge->add(public_path('file-nota-rekomendasi-2/file-kelengkapan-project/' . $proyekPersetujuan->file_kelengkapan_merge));
            }

            $pdfMerge->merge(public_path("file-nota-rekomendasi-2/file-persetujuan" . "/" . $file_name));

            $proyekPersetujuan->file_persetujuan = $file_name;
            $proyekPersetujuan->save();

            return response()->json([
                "success" => true,
                "message" => "Dokumen berhasil di generate"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Dokumen gagal di generate"
            ]);
        }
    }


    /**
     * Private Function
     * 
     * Function untuk check Matriks Approval
     */
    private function checkMatriksApproval($divisi_id, $klasifikasi_proyek, $departemen_code, $approved_data, $kategori): bool
    {
        if ($kategori == "Penyusun") {
            return $this->matriks_approvals->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("kategori", "=", $kategori)->count() == $approved_data->count();
        }
        return $this->matriks_approvals->where("divisi_id", "=", $divisi_id)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where('departemen_code', $departemen_code)->where("kategori", "=", $kategori)->count() == $approved_data->count();
    }

    private function getUserMatriksApproval($divisi_id, $klasifikasi_pasdin, $departemen_code, $kategori, $user_selected = null)
    {
        if (empty($user_selected)) {
            return $this->matriks_approvals->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori)->get();
        } else {
            return $this->matriks_approvals->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori)->where('nama_pegawai', '=', $user_selected)->first();
        }
    }

    private function getUrutanUserMatriksApprovalSekarang($nama_pegawai, $divisi_id, $klasifikasi_pasdin, $departemen_code, $kategori)
    {
        return $this->matriks_approvals->where("nama_pegawai", "=", $nama_pegawai)->where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori)->first()->urutan;
    }

    private function getNomorMatriksApproval($divisi_id, $klasifikasi_pasdin, $departemen_code, $kategori, $urutan = null)
    {
        $matriks_approval = $this->matriks_approvals->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori);
        if (empty($urutan)) {
            return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->get();
        } else {
            return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->where('urutan', '=', $urutan)->get();
        }
    }

    private function getNomorMatriksApprovalPaparan($divisi_id, $klasifikasi_pasdin, $departemen_code, $kategori, $urutan = null)
    {
        $matriks_approval = MatriksApprovalPaparan::where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori);
        if (empty($urutan)) {
            return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->get();
        } else {
            return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->where('urutan', '=', $urutan)->get();
        }
    }

    /**
     * 
     * Function Untuk Send WA
     * 
     * @param string $nomorUser "nomor user matriks approval step berikutnya ataupun step saat itu"
     * @param string $message "isi pesan yg ingin di tampilkan di WA"
     */
    private function sendWAToUser($nomorUser, $message)
    {
        $response = Http::post(env("API_WHATSAPP_BLAST"), [
            "api_key" => env("API_KEY_WHATSAPP_BLAST"),
            "sender" => env("NO_WHATSAPP_BLAST"),
            "number" => $nomorUser,
            "message" => $message
        ]);

        return $response;
    }
}
