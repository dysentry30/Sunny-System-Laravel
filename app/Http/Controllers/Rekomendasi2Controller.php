<?php

namespace App\Http\Controllers;

use App\Models\KriteriaProjectSelectionDetail;
use App\Models\KriteriaSelectionNonGreenlane;
use App\Models\MatriksApprovalNotaRekomendasi2;
use App\Models\NotaRekomendasi2;
use App\Models\MasterCatatanNotaRekomendasi2;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Karriere\PdfMerge\PdfMerge;
use RealRashid\SweetAlert\Facades\Alert;

class Rekomendasi2Controller extends Controller
{
    public $matriks_approvals;
    public $isnomorTargetActive;
    public $nomorDefault;

    public function __construct()
    {
        $this->matriks_approvals = MatriksApprovalNotaRekomendasi2::where("is_active", true)->get();
        $this->matriks_approvals = $this->matriks_approvals->first();
        $this->isnomorTargetActive = false;
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

        $matriks_user = Auth::user()->Pegawai->MatriksApproval2 ?? null;
        $all_super_user_counter = MatriksApprovalNotaRekomendasi2::all()->filter(function ($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        $matriks_category = [];

        $collectKlasifikasi = $matriks_user->unique('klasifikasi_proyek')->map(function ($item) {
            return $item->klasifikasi_proyek;
        })->toArray();

        $collectDepartement = $matriks_user->unique('klasifikasi_proyek')->map(function ($item) {
            return $item->departemen_code;
        })->toArray();

        $proyeks = NotaRekomendasi2::all();
        $proyeks_proses_rekomendasi = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasi)->whereIn('departemen_proyek', $collectDepartement)->whereNull('is_disetujui');
        $proyeks_rekomendasi_final = $proyeks->whereIn("unit_kerja", $unit_kerjas)->whereIn('klasifikasi_proyek', $collectKlasifikasi)->whereIn('departemen_proyek', $collectDepartement)->whereNotNull('is_disetujui');

        $matriks_category = MatriksApprovalNotaRekomendasi2::all()->groupBy(['klasifikasi_proyek', 'kategori', 'departemen_code']);

        $kriteriaAssessmentProjectSelection = KriteriaSelectionNonGreenlane::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaAssessmentProjectSelectionDetail = KriteriaProjectSelectionDetail::all();

        $masterCatatanRekomendasi = MasterCatatanNotaRekomendasi2::all()->sortBy('urutan');

        // dd($proyeks_proses_rekomendasi->first()->is_request_rekomendasi == null);

        return view('17_Nota_Rekomendasi_2', [
            "proyeks_proses_rekomendasi" => $proyeks_proses_rekomendasi,
            "proyeks_rekomendasi_final" => $proyeks_rekomendasi_final,
            "matriks_user" => $matriks_user,
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
                // $is_proyek_mega = (str_contains($proyekSelected->klasifikasi_pasdin, "Besar") || str_contains($proyekSelected->klasifikasi_pasdin, "Mega")) ? true : false;

                $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Penyusun")->where('urutan', '=', 1);
                foreach ($nomorTarget as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyekSelected->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyekSelected->ProyekBerjalan->name_customer . "* untuk Proyek *$proyekSelected->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";

                    $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);

                    $send_msg_to_wa->onError(function ($error) {
                        Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                        return redirect()->back();
                    });
                }

                createWordPengajuanNota2($proyekPengajuan);
                $proyekPengajuan->is_pengajuan_approved = true;
                $proyekPengajuan->is_request_rekomendasi = false;
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
     * Proses Pengajuan
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProsesPenyusun(Request $request, $kode_proyek)
    {
        $proyekPenyusun = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $proyekPenyusun->Proyek;

        $is_paralel = false;

        $data = collect(json_decode($proyekPenyusun->approved_penyusun));
        $dataCatatanNota = collect(json_decode($proyekPenyusun->catatan_master));

        $catatanMasterInput = $request->get("catatan_nota_rekomendasi_master");

        foreach ($catatanMasterInput as $key => $catatan) {
            $urutan = null;
            $checked = false;
            if (!empty($request->get("master_selected_" . $key + 1))) {
                $urutan = $request->get("master_selected_" . $key + 1);
                $checked = true;
            }
            $dataCatatanNota = $dataCatatanNota->push([
                "urutan" => $urutan,
                "checked" => $checked,
                "uraian" => $catatan
            ]);
        }

        $proyekPenyusun->catatan_master = $dataCatatanNota->toJson();

        //Proses Save Draft
        if (isset($request["save-draft-note-rekomendasi"])) {
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
            // $proyekPenyusun->approved_penyusun = $note_penyusun;
            $proyekPenyusun->catatan_nota_rekomendasi = $request->get("note-rekomendasi");

            $is_checked = self::checkMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, $data, "Penyusun");

            if ($is_checked) {
                $proyekPenyusun->is_penyusun_approved = true;

                if (is_null($proyekPenyusun->is_revisi)) {
                    if (str_contains($proyekSelected->klasifikasi_pasdin, "Mega")) {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen proyek *" . $proyekSelected->nama_proyek . "* untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);
                            $response->onError(function ($error) {
                                // dd($error);
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
                        }
                    } elseif (str_contains($proyekSelected->klasifikasi_pasdin, "Besar")) {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen proyek *" . $proyekSelected->nama_proyek . "* untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);

                            $response->onError(function ($error) {
                                // dd($error);
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
                        }
                    } else {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen proyek *" . $proyekSelected->nama_proyek . "* untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);

                            $response->onError(function ($error) {
                                // dd($error);
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
                        }

                        $approved_verifikasi = collect(json_decode($proyekPenyusun->approved_verifikasi));
                        $approved_verifikasi->push([
                            "user_id" => Auth::user()->id,
                            "status" => "approved",
                            "tanggal" => \Carbon\Carbon::now(),
                        ]);
                        $proyekPenyusun->approved_verifikasi = $approved_verifikasi->toJson();
                        $proyekPenyusun->is_verifikasi_approved = true;
                    }
                } else {
                    if (str_contains($proyekSelected->klasifikasi_pasdin, "Mega")) {

                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan revisi asesmen untuk proses verifikasi penyusunan Nota Rekomendasi tahap II pada proyek *$proyekPenyusun->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);

                            $response->onError(function ($error) {
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
                        }
                    } elseif (str_contains($proyekSelected->klasifikasi_pasdin, "Besar")) {
                        // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
                        $nomorTarget = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_persetujuan_" . $proyekPenyusun->kode_proyek;
                            $message = "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan revisi asesmen untuk proses verifikasi penyusunan Nota Rekomendasi tahap II pada proyek *$proyekPenyusun->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);

                            $response->onError(function ($error) {
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
                        }
                    }

                    $proyekPenyusun->is_revisi = null;
                }

                $proyekPenyusun->is_draft_recommend_note = false;
                // $mergeLampiran = mergeFileLampiranRisiko($proyekPenyusun->kode_proyek);
                // $profileResiko = createWordProfileRisikoNew($proyekPenyusun->kode_proyek);
                // if (!empty($profileResiko)) {
                //     // if (!empty($mergeLampiran)) {
                //     //     $pdfMerger = new PdfMerge();
                //     //     $pdfMerger->add(public_path('file-profile-risiko' . '/' . $profileResiko));
                //     //     $pdfMerger->add(public_path('file-kriteria-pengguna-jasa' . '/' . $mergeLampiran));

                //     //     $now = \Carbon\Carbon::now();
                //     //     $file_name = $now->format("dmYHis") . "_profile-risiko-final_" . $proyekPenyusun->kode_proyek;
                //     //     sleep(10);
                //     //     // File::delete(public_path('/file-profile-risiko//' . $profileResiko));
                //     //     $pdfMerger->merge(public_path("file-profile-risiko" . "/" . $file_name . ".pdf"));
                //     //     // dd($pdfMerger);
                //     //     $proyekPenyusun->file_penilaian_risiko = $file_name . ".pdf";
                //     // }
                // }
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
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyekPenyusun->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyekPenyusun->ProyekBerjalan->name_customer . "* untuk Proyek *$proyekPenyusun->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                                $response->onError(function ($error) {
                                    Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                    return redirect()->back();
                                });
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
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyekPenyusun->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyekPenyusun->ProyekBerjalan->name_customer . "* untuk Proyek *$proyekPenyusun->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                                $response->onError(function ($error) {
                                    Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                    return redirect()->back();
                                });
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
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyekPenyusun->kode_proyek";
                                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyekPenyusun->ProyekBerjalan->name_customer . "* untuk Proyek *$proyekPenyusun->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                                $response = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                                $response->onError(function ($error) {

                                    Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                    return redirect()->back();
                                });
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
     * Proses Pengajuan
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
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_persetujuan_" . $proyekVerifikasi->kode_proyek;
                    $message = "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen untuk proyek *" . $proyekSelected->nama_proyek . "* untuk permohonan pemberian rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault, $message);

                    $send_msg_to_wa->onError(function ($error) {
                        // dd($error);
                        Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                        return redirect()->back();
                    });
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
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyekVerifikasi->kode_proyek";
                            $message = "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen untuk proyek *" . $proyekSelected->nama_proyek . "* untuk proses tandatangan penyusun Nota Rekomendasi tahap II.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                            $send_msg_to_wa->onError(function ($error) {
                                // dd($error);
                                Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                return redirect()->back();
                            });
                        }
                    }
                }
            }
            if ($proyekVerifikasi->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
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
                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_$proyekSelected->kode_proyek";
                $message = "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan permintaan revisi asesmen untuk perbaikan Nota Rekomendasi tahap I pada proyek *$proyekSelected->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                $send_msg_to_wa->onError(function ($error) {
                    Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                    return redirect()->back();
                });
            }

            $proyekVerifikasi->is_penyusun_approved = null;
            $proyekVerifikasi->approved_penyusun = null;
            $proyekVerifikasi->approved_penyusun = null;
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

            createWordPersetujuanNota2($proyekVerifikasi);

            if ($proyekVerifikasi->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> telah ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 2</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 2</b>", "error");
            return redirect()->back();
        }
    }

    /**
     * Proses Pengajuan
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
                    $message = "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek *$proyekSelected->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                    $send_msg_to_wa->onError(function ($error) {
                        Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                        return redirect()->back();
                    });
                }
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
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
                            $message = "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap II untuk Proyek *$proyekSelected->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                            $send_msg_to_wa->onError(function ($error) {
                                // dd($error);
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
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

            // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            // $is_proyek_mega = str_contains($proyekSelected->klasifikasi_pasdin, "Mega") ? true : false;
            // $is_proyek_besar = str_contains($proyekSelected->klasifikasi_pasdin, "Besar") ? true : false;
            createWordPersetujuanNota2($proyekRekomendasi);

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
            // dd($is_checked);
            if ($is_checked) {
                // $matriks_approval = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Persetujuan");
                $matriks_approval = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Persetujuan");
                foreach ($matriks_approval as $key => $user) {
                    $user = $user->Pegawai->User;
                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $proyekSelected->kode_proyek;
                    $message = "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap I untuk *" . $proyekSelected->proyekBerjalan->customer->name . "* pada proyek *$proyekSelected->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                    $send_msg_to_wa->onError(function ($error) {
                        // dd($error);
                        Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                        return redirect()->back();
                    });
                }
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                $proyekRekomendasi->is_rekomendasi_approved = true;
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                    // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->first()->urutan;
                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi");
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyekSelected->UnitKerja->Divisi->id_divisi, $proyekSelected->klasifikasi_pasdin, $proyekSelected->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_user_view_rekomendasi_" . $proyekSelected->kode_proyek;
                            $message = "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyekSelected->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                            $send_msg_to_wa = self::sendWAToUser(!empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault, $message);

                            $send_msg_to_wa->onError(function ($error) {
                                // dd($error);
                                Alert::error(
                                    'Error',
                                    "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                );
                                return redirect()->back();
                            });
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
                createWordPersetujuanNota2($proyekPersetujuan);
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
                createWordPersetujuanNota2($proyekPersetujuan);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> telah ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> gagal ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        }
    }

    /**
     * Proses Persetujuan
     * @param Request $request
     * @param string $kode_proyek
     */
    public function ProyekPemaparan(Request $request, $kode_proyek)
    {
        $ProyekPemaparan = NotaRekomendasi2::where('kode_proyek', $kode_proyek)->first();
        $proyekSelected = $ProyekPemaparan->Proyek;

        if (isset($request->sudah_pemaparan)) {
            $ProyekPemaparan->is_sudah_pemaparan = true;
            if ($ProyekPemaparan->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyekSelected->nama_proyek</b> telah dilakukan pemaparan", "success");
                return redirect()->back();
            }
            Alert::html("Error", "<b>Terjadi Kesalahan.</b> Silahkan hubungi admin!", "error");
            return redirect()->back();
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
            if ($kategori == "Persetujuan") {
                return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->get();
            } else {
                if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi" || $kategori == "Penyusun") {
                    return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->get();
                }
                return $matriks_approval->get();
            }
        } else {
            if ($kategori == "Persetujuan") {
                return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->where('urutan', '=', $urutan)->get();
            } else {
                if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi" || $kategori == "Penyusun") {
                    return $matriks_approval->where("divisi_id", $divisi_id)->where("departemen_code", $departemen_code)->where('urutan', '=', $urutan)->get();
                }
                return $matriks_approval->where('urutan', '=', $urutan)->get();
            }
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
