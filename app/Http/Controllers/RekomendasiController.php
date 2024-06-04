<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyek;
use App\Models\JenisProyek;
use App\Models\TipeProyek;
use App\Models\Customer;
use App\Models\DokumenNotaRekomendasi1;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\MatriksApprovalRekomendasi;
use App\Models\KriteriaPenggunaJasaDetail;
use App\Models\NotaRekomendasi;
use App\Models\UnitKerja;
use Karriere\PdfMerge\PdfMerge;

class RekomendasiController extends Controller
{
    public $isnomorTargetActive;

    public function __construct()
    {
        $this->isnomorTargetActive = env('NR_ACTIVE');
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $nip = null;
        if (!empty($data["signature"])) {
            if (!$request->hasValidSignature()) {
                return errorPage(404, "Link has expired", "Oops! This link has expired", "");
            }
        }
        if (empty(Auth::user())) {
            $nip = $data["user"];
            $user = User::where("nip", "=", $nip)->first();
            Auth::setUser($user);
        }
        $all_super_user_counter = MatriksApprovalRekomendasi::all()->filter(function ($user) {
            return $user->Pegawai?->nama_pegawai == Auth::user()->name;
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            return $user->Pegawai?->nama_pegawai == Auth::user()->name;
        });
        $all_super_user_counter = $all_super_user_counter->groupBy("Pegawai.nama_pegawai")->count();
        // dd($all_super_user_counter);
        // $all_super_user_counter = 1;
        $rekomendasi_open = $request->query("open") ?? "";
        $is_has_not_recommended = false;
        $proyek = Proyek::find($request->get("kode-proyek"));
        if (!empty($proyek)) {
            $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();
        }

        // if (!empty($proyek->approved_rekomendasi_final)) {
        //     $is_has_not_recommended = collect(json_decode($proyek->approved_rekomendasi_final))->where('status', 'rejected')->count() > 0;
        // }
        if (!empty($notaRekomendasi->approved_rekomendasi_final)) {
            $is_has_not_recommended = collect(json_decode($notaRekomendasi->approved_rekomendasi_final))->where('status', 'rejected')->count() > 0;
        }

        // Begin Prosess Approval
        if (!empty($request->setuju)) {
            $is_paralel = false;
            $data = collect(json_decode($notaRekomendasi->approved_rekomendasi));
            $data = $data->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $check_user_approval_counter = is_array(collect($data->first())->values()->first()) ? collect($data->first())->values()->count() == $all_super_user_counter : $data->count() == $all_super_user_counter;
            $is_user_id_exist = $data->filter(function ($d) {
                if (is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            // dd($data, $check_user_approval_counter);
            $notaRekomendasi->approved_rekomendasi = $data->toJson();


            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $data, "Pengajuan");
            // dd($is_checked);
            //Flow setelah setuju rekomendasi pengajuan

            // if ($is_checked) {

            //     $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;
            //     $hasil_assessment = collect(performAssessment($proyek->proyekBerjalan->Customer, $proyek));
            //     // dd($hasil_assessment);
            //     // createWord($proyek, $hasil_assessment, $is_proyek_mega);

            //     // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun")->where('urutan', '=', 1) : $this->nomorDefault;
            //     $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun")->where('urutan', '=', 1);
            //     // dd($nomorTarget);
            //     foreach ($nomorTarget as $target) {
            //         // dd($target->Pegawai->handphone);
            //         if (empty($proyek->is_revisi_pengajuan)) {
            //             $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_kriteria_" . $proyek->kode_proyek;
            //             $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            //             $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
            //         } else {
            //             $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
            //             $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil revisi Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            //             $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Hasil Revisi Nota Rekomendasi I", $message, $this->isnomorTargetActive);
            //         }

            //         // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            //         //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
            //         //     "sender" => env("NO_WHATSAPP_BLAST"),
            //         //     // "sender" => "6281188827008",
            //         //     // "sender" => "62811881227",
            //         //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
            //         //     // "number" => "085881028391",
            //         //     "message" => "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
            //         //     // "url" => $url
            //         // ]);
            //         if (!$sendEmailUser) {
            //             return redirect()->back();
            //         }

            //         // $send_msg_to_wa->onError(function ($error) {
            //         //     // dd($error);
            //         //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            //         //     return redirect()->back();
            //         // });
            //     }


            //     // QrCode::size(50)->generate($request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_", public_path('/qr-code' . '/' . $proyek->kode_proyek . '.svg'));
            //     // $fileQrCode = generateQrCode($proyek->kode_proyek, Auth::user()->nip, $request->schemeAndHttpHost() . "?nip=" . Auth::user()->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek");
            //     createWordPengajuan($proyek, $hasil_assessment, $is_proyek_mega, null);
            //     createWordRekomendasi($proyek, $hasil_assessment, $is_proyek_mega);
            //     $notaRekomendasi->review_assessment = true;
            //     $notaRekomendasi->is_request_rekomendasi = false;
            //     $notaRekomendasi->hasil_assessment = $hasil_assessment;
            //     $notaRekomendasi->approved_rekomendasi = $data->toJson();
            //     $notaRekomendasi->is_revisi_pengajuan = null;
            //     $proyek->is_request_rekomendasi = false;
            // } else {
            //     if (!$is_paralel) {
            //         $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan");
            //         $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan");
            //         // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->first()->urutan;
            //         $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
            //             return $user->urutan == $matriks_sekarang + 1;
            //         });

            //         if ($check_urutan_user) {
            //             $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan", (int)$matriks_sekarang + 1);
            //             foreach ($get_nomor as $user) {
            //                 $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
            //                 // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            //                 //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
            //                 //     "sender" => env("NO_WHATSAPP_BLAST"),
            //                 //     // "sender" => "6281188827008",
            //                 //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
            //                 //     // "number" => "085881028391",
            //                 //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
            //                 //     // "url" => $url
            //                 // ]);
            //                 $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            //                 $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Penandatanganan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
            //                 if (!$sendEmailUser) {
            //                     return redirect()->back();
            //                 }
            //                 // $send_msg_to_wa->onError(function ($error) {
            //                 //     // dd($error);
            //                 //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            //                 //     return redirect()->back();
            //                 // });
            //             }
            //         }
            //     }
            // }

            $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;
            $hasil_assessment = collect(performAssessment($proyek->proyekBerjalan->Customer, $proyek));
            // dd($hasil_assessment);
            // createWord($proyek, $hasil_assessment, $is_proyek_mega);

            // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun")->where('urutan', '=', 1) : $this->nomorDefault;
            $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun")->where('urutan', '=', 1);
            // dd($nomorTarget);
            foreach ($nomorTarget as $target) {
                // dd($target->Pegawai->handphone);
                if (empty($proyek->is_revisi_pengajuan)) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_kriteria_" . $proyek->kode_proyek;
                    $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                } else {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_kriteria_" . $proyek->kode_proyek;
                    $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil revisi Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Hasil Revisi Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                }

                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                //     "sender" => env("NO_WHATSAPP_BLAST"),
                //     // "sender" => "6281188827008",
                //     // "sender" => "62811881227",
                //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                //     // "number" => "085881028391",
                //     "message" => "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                //     // "url" => $url
                // ]);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }

                // $send_msg_to_wa->onError(function ($error) {
                //     // dd($error);
                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                //     return redirect()->back();
                // });
            }


            // QrCode::size(50)->generate($request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_", public_path('/qr-code' . '/' . $proyek->kode_proyek . '.svg'));
            // $fileQrCode = generateQrCode($proyek->kode_proyek, Auth::user()->nip, $request->schemeAndHttpHost() . "?nip=" . Auth::user()->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek");
            // createWordPengajuan($proyek, $hasil_assessment, $is_proyek_mega, $url);
            // createWordPengajuan($proyek, $hasil_assessment, $is_proyek_mega, $request->schemaAndHttpHost());
            // createWordNotaRekomendasiPengajuan($notaRekomendasi, $request);
            // createWordRekomendasi($proyek, $hasil_assessment, $is_proyek_mega);
            $notaRekomendasi->review_assessment = true;
            $notaRekomendasi->is_request_rekomendasi = false;
            $notaRekomendasi->hasil_assessment = $hasil_assessment;
            $notaRekomendasi->approved_rekomendasi = $data->toJson();
            $notaRekomendasi->is_revisi_pengajuan = null;
            $proyek->is_request_rekomendasi = false;

            // if ($proyek->save()) {
            //     Alert::html("Success", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disetujui", "success");
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save() && $proyek->save()) {
                Alert::html("Success", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disetujui", "success");
                return redirect()->back();
            }
            // if(!$is_user_id_exist) {
            // }
            Alert::html("Failed", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui", "error");
            return redirect()->back();
        } else if (!empty($request->tolak)) {
            // $data = collect(json_decode($proyek->approved_rekomendasi));
            $data = collect(json_decode($notaRekomendasi->approved_rekomendasi));
            // dd($data);
            $is_user_id_exist = $data->filter(function ($d) {
                if (is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            $data = $data->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "alasan" => $request->get("alasan-ditolak"),
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            // dd($data);
            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $data, "Pengajuan");
            if ($is_checked) {
                // $proyek->is_recommended = false;
                // $proyek->is_request_rekomendasi = false;
                // $proyek->is_disetujui = false;
                $notaRekomendasi->is_recommended = false;
                $notaRekomendasi->is_request_rekomendasi = false;
                $notaRekomendasi->is_disetujui = false;
                $proyek->is_disetujui = false;
            }
            // $proyek->approved_rekomendasi = $data->toJson();
            $notaRekomendasi->approved_rekomendasi = $data->toJson();
            // if ($proyek->save()) {
            //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak", "success");
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save() && $proyek->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        } else if (!empty($request["input-rekomendasi-with-note"])) {

            $is_paralel = str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;

            // $data = collect(json_decode($proyek->approved_penyusun));
            $data = collect(json_decode($notaRekomendasi->approved_penyusun));

            if ($data->where('user_id', Auth::user()->id)->isEmpty()) {
                $data = $data->push(
                    [
                        "user_id" => Auth::user()->id,
                        "status" => "approved",
                        "catatan" => $request->get("note-rekomendasi") ?? '-',
                        "tanggal" => \Carbon\Carbon::now()
                    ]
                );
                // $proyek->approved_penyusun = $data->toJson();
                $notaRekomendasi->approved_penyusun = $data->toJson();
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

                // $proyek->approved_penyusun = $data->values()->toJson();
                $notaRekomendasi->approved_penyusun = $data->values()->toJson();
            }
            //// $proyek->approved_penyusun = $note_penyusun;
            // $proyek->catatan_nota_rekomendasi = $request->get("note-rekomendasi");
            $notaRekomendasi->catatan_nota_rekomendasi = $request->get("note-rekomendasi");

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $data, "Penyusun");

            if ($is_checked) {
                // $proyek->is_penyusun_approved = true;
                $notaRekomendasi->is_penyusun_approved = true;
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
                $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));

                // if (is_null($proyek->is_revisi)) {
                if (is_null($notaRekomendasi->is_revisi)) {
                    if (str_contains($proyek->klasifikasi_pasdin, "Mega")) {
                        // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error(
                            //         'Error',
                            //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                            //     );
                            //     return redirect()->back();
                            // });

                            $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk permohonan pemberian rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } elseif (str_contains($proyek->klasifikasi_pasdin, "Besar")) {
                        // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error(
                            //         'Error',
                            //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                            //     );
                            //     return redirect()->back();
                            // });

                            $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk permohonan pemberian rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } else {
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error(
                            //         'Error',
                            //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                            //     );
                            //     return redirect()->back();
                            // });
                            $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk permohonan pemberian rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }

                        // $approved_verifikasi = collect(json_decode($proyek->approved_penyusun));
                        $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_penyusun));
                        $approved_verifikasi->push([
                            "user_id" => Auth::user()->id,
                            "status" => "approved",
                            "tanggal" => \Carbon\Carbon::now(),
                        ]);
                        // $proyek->approved_verifikasi = $approved_verifikasi->toJson();
                        // $proyek->is_verifikasi_approved = true;
                        $notaRekomendasi->approved_verifikasi = $approved_verifikasi->toJson();
                        $notaRekomendasi->is_verifikasi_approved = true;
                    }
                } else {
                    if (str_contains($proyek->klasifikasi_pasdin, "Mega")) {
                        // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan revisi asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk proses verifikasi penyusunan Nota Rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error(
                            //         'Error',
                            //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                            //     );
                            //     return redirect()->back();
                            // });
                            $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan revisi asesmen " . $proyek->proyekBerjalan->customer->name . " untuk proses verifikasi penyusunan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Revisi Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } elseif (str_contains($proyek->klasifikasi_pasdin, "Besar")) {
                        // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi")?->where('urutan', '=', 1);
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan revisi asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk proses verifikasi penyusunan Nota Rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error(
                            //         'Error',
                            //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                            //     );
                            //     return redirect()->back();
                            // });

                            $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan revisi asesmen " . $proyek->proyekBerjalan->customer->name . " untuk proses verifikasi penyusunan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Revisi Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    } else {
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error(
                            //         'Error',
                            //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                            //     );
                            //     return redirect()->back();
                            // });
                            $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk permohonan pemberian rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Hasil Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }

                        // $approved_verifikasi = collect(json_decode($proyek->approved_penyusun));
                        $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_penyusun));
                        $approved_verifikasi->push([
                            "user_id" => Auth::user()->id,
                            "status" => "approved",
                            "tanggal" => \Carbon\Carbon::now(),
                        ]);
                        // $proyek->approved_verifikasi = $approved_verifikasi->toJson();
                        // $proyek->is_verifikasi_approved = true;
                        $notaRekomendasi->approved_verifikasi = $approved_verifikasi->toJson();
                        $notaRekomendasi->is_verifikasi_approved = true;
                    }

                    // $proyek->is_revisi = null;
                    $notaRekomendasi->is_revisi = null;
                }

                // $proyek->is_draft_recommend_note = false;
                $notaRekomendasi->is_draft_recommend_note = false;
                // createWordProfileRisiko($proyek->kode_proyek);
                $mergeLampiran = mergeFileLampiranRisiko($proyek->kode_proyek);
                $profileResiko = createWordProfileRisikoNew($proyek->kode_proyek);
                // dd($profileResiko);
                if (!empty($profileResiko)) {
                    // dd($mergeLampiran);
                    $pdfMerger = new PdfMerge();
                    if (!empty($mergeLampiran)) {
                        $pdfMerger->add(public_path('file-profile-risiko' . '/' . $profileResiko));
                        $pdfMerger->add(public_path('file-kriteria-pengguna-jasa' . '/' . $mergeLampiran));

                        $now = \Carbon\Carbon::now();
                        $file_name = $now->format("dmYHis") . "_profile-risiko-final_" . $proyek->kode_proyek;
                        sleep(10);
                        // File::delete(public_path('/file-profile-risiko//' . $profileResiko));
                        $pdfMerger->merge(public_path("file-profile-risiko" . "/" . $file_name . ".pdf"));
                        // dd($pdfMerger);
                        // $proyek->file_penilaian_risiko = $file_name . ".pdf";
                        $notaRekomendasi->file_penilaian_risiko = $file_name . ".pdf";
                    } else {
                        $pdfMerger->add(public_path('file-profile-risiko' . '/' . $profileResiko));
                        $now = \Carbon\Carbon::now();
                        $file_name = $now->format("dmYHis") . "_profile-risiko-final_" . $proyek->kode_proyek;
                        sleep(10);
                        // File::delete(public_path('/file-profile-risiko//' . $profileResiko));
                        $pdfMerger->merge(public_path("file-profile-risiko" . "/" . $file_name . ".pdf"));
                        // dd($pdfMerger);
                        // $proyek->file_penilaian_risiko = $file_name . ".pdf";
                        $notaRekomendasi->file_penilaian_risiko = $file_name . ".pdf";
                    }
                }
            } else {
                if (!$is_paralel) {
                    if (str_contains($proyek->klasifikasi_pasdin, "Mega")) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                //     return redirect()->back();
                                // });

                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    } elseif (str_contains($proyek->klasifikasi_pasdin, "Besar")) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang, $proyek) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });
                        // dd($matriks_sekarang);

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            // dd($get_nomor);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                //     return redirect()->back();
                                // });

                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    } else {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->where('klasifikasi_proyek', $proyek->klasifikasi_pasdin)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where('kategori', "Penyusun")?->first()->urutan;
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang, $proyek) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            if (is_null($proyek->is_revisi)) {
                                $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                                // dd($get_nomor);
                                foreach ($get_nomor as $user) {
                                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                                    // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                    //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                    //     "sender" => env("NO_WHATSAPP_BLAST"),
                                    //     // "sender" => "6281188827008",
                                    //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                    //     // "number" => "085881028391",
                                    //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                    //     // "url" => $url
                                    // ]);
                                    // $send_msg_to_wa->onError(function ($error) {
                                    //     // dd($error);
                                    //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                    //     return redirect()->back();
                                    // });

                                    $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                    $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                    if (!$sendEmailUser) {
                                        return redirect()->back();
                                    }
                                }
                            } else {
                                $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                                foreach ($get_nomor as $user) {
                                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                                    // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                    //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                    //     "sender" => env("NO_WHATSAPP_BLAST"),
                                    //     // "sender" => "6281188827008",
                                    //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                    //     // "number" => "085881028391",
                                    //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                    //     // "url" => $url
                                    // ]);
                                    // $send_msg_to_wa->onError(function ($error) {
                                    //     // dd($error);
                                    //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                    //     return redirect()->back();
                                    // });

                                    $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan revisi asesmen " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                    $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Revisi Assessment Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                    if (!$sendEmailUser) {
                                        return redirect()->back();
                                    }
                                }
                            }
                        } else {
                            Alert::error('Error', 'Penyusun selanjutnya belum ditentukan. Hubungi Admin!');
                            return redirect()->back();
                        }
                    }
                } else {
                    if (str_contains($proyek->klasifikasi_pasdin, "Mega")) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                //     return redirect()->back();
                                // });

                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    } elseif (str_contains($proyek->klasifikasi_pasdin, "Besar")) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang, $proyek) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });
                        // dd($matriks_sekarang);

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            // dd($get_nomor);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                //     return redirect()->back();
                                // });

                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    } else {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun");
                        // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->where('klasifikasi_proyek', $proyek->klasifikasi_pasdin)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where('kategori', "Penyusun")?->first()->urutan;
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang, $proyek) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", (int)$matriks_sekarang + 1);
                            // dd($get_nomor);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                                //     return redirect()->back();
                                // });

                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    }
                }
            }

            // dd($proyek);
            // if ($proyek->save()) {
            if ($proyek->save() && $notaRekomendasi->save()) {
                Alert::html("Success", "Penyusunan dengan nama proyek <b>$proyek->nama_proyek</b> berhasil", "success");
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
            Alert::html("Failed", "Penyusunan dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        } else if (!empty($request["save-draft-note-rekomendasi"])) {
            // $proyek->is_draft_recommend_note = true;
            $notaRekomendasi->is_draft_recommend_note = true;

            // $data = collect(json_decode($proyek->approved_penyusun));
            $data = collect(json_decode($notaRekomendasi->approved_penyusun));

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

            // $proyek->approved_penyusun = $data->values()->toJson();
            // $proyek->catatan_nota_rekomendasi = $request->get("note-rekomendasi");
            $notaRekomendasi->approved_penyusun = $data->values()->toJson();
            $notaRekomendasi->catatan_nota_rekomendasi = $request->get("note-rekomendasi");
            // if ($proyek->save()) {
            //     Alert::html("Success", "Penyusun dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disimpan sebagai draft", "success");
            //     // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save()) {
                Alert::html("Success", "Penyusun dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disimpan sebagai draft", "success");
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
        } else if (!empty($request["revisi-pengajuan"])) {
            // $proyek = Proyek::find($request->get("kode-proyek"));
            if (empty($request["revisi-pengajuan-note"])) {
                Alert::error('Mohon isi catatan revisi');
                return redirect()->back();
            }

            // $revisi_note = collect(json_decode($proyek->revisi_pengajuan_note));
            $revisi_note = collect(json_decode($notaRekomendasi->revisi_pengajuan_note));
            $revisi_note->push([
                "user_id" => Auth::user()->id,
                "status" => "revisi",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["revisi-pengajuan-note"]
            ]);

            // $proyek->revisi_pengajuan_note = $revisi_note;
            // $proyek->is_revisi_pengajuan = true;
            $notaRekomendasi->revisi_pengajuan_note = $revisi_note;
            $notaRekomendasi->is_revisi_pengajuan = true;

            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan", 1);

            // foreach ($get_nomor as $user) {
            //     $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
            //     $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi pengajuan " . $proyek->proyekBerjalan->customer->name . " untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            //     $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Revisi Dokumen Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
            //     if (!$sendEmailUser) {
            //         return redirect()->back();
            //     }
            // }

            $request_pengajuan = collect(json_decode($notaRekomendasi->request_pengajuan));
            $userRequestPengajuan = User::find($request_pengajuan["user_id"]);

            $url = $request->schemeAndHttpHost() . "?nip=" . $userRequestPengajuan->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
            $message = nl2br("Yth Bapak/Ibu " . $userRequestPengajuan->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi pengajuan " . $proyek->proyekBerjalan->customer->name . " untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            $sendEmailUser = sendNotifEmail($userRequestPengajuan->Pegawai, "Pemberitahuan Revisi Dokumen Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
            if (!$sendEmailUser) {
                return redirect()->back();
            }

            // if (!empty($proyek->file_pengajuan)) {
            //     File::delete(public_path('file-pengajuan/' . $proyek->file_pengajuan));
            // }
            if (!empty($notaRekomendasi->file_pengajuan)) {
                File::delete(public_path('file-pengajuan/' . $proyek->file_pengajuan));
            }

            // if (!empty($proyek->file_rekomendasi)) {
            //     File::delete(public_path('file-rekomendasi/' . $proyek->file_rekomendasi));
            // }
            if (!empty($notaRekomendasi->file_rekomendasi)) {
                File::delete(public_path('file-rekomendasi/' . $proyek->file_rekomendasi));
            }

            // $proyek->review_assessment = null;
            // $proyek->hasil_assessment = null;
            // $proyek->file_rekomendasi = null;
            // $proyek->file_pengajuan = null;
            // $proyek->approved_rekomendasi = null;
            // $proyek->is_request_rekomendasi = true;
            $notaRekomendasi->review_assessment = null;
            $notaRekomendasi->hasil_assessment = null;
            $notaRekomendasi->file_rekomendasi = null;
            $notaRekomendasi->file_pengajuan = null;
            $notaRekomendasi->approved_rekomendasi = null;
            $notaRekomendasi->is_request_rekomendasi = true;
            $proyek->is_request_rekomendasi = true;



            // if ($proyek->save()) {
            //     // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
            //     Alert::html("Success", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> berhasil dikembalikan ke Pengajuan", "success");
            //     return redirect()->back();
            // }
            if ($proyek->save() && $notaRekomendasi->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> berhasil dikembalikan ke Pengajuan", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> gagal dikembalikan ke Pengajuan", "error");
            return redirect()->back();
        } else if (!empty($request["verifikasi-setujui"])) {
            $is_paralel = false;
            // $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
            $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            // $proyek->approved_verifikasi = $approved_verifikasi->toJson();
            $notaRekomendasi->approved_verifikasi = $approved_verifikasi->toJson();
            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Verifikasi");
            // dd($is_checked);
            // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
            if ($is_checked) {
                $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                foreach ($nomorTarget as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                    // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                    //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                    //     "sender" => env("NO_WHATSAPP_BLAST"),
                    //     // "sender" => "6281188827008",
                    //     // "sender" => "62811881227",
                    //     "number" => !empty($this->isnomorTargetActive) ? $target->Pegawai->handphone : $this->nomorDefault,
                    //     // "number" => "085881028391",
                    //     "message" => "Yth Bapak/Ibu *" . $target->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                    //     // "url" => $url
                    // ]);

                    // $send_msg_to_wa->onError(function ($error) {
                    //     // dd($error);
                    //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                    //     return redirect()->back();
                    // });

                    $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk permohonan pemberian rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pemberian Rekomendasi Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }
                // $proyek->is_verifikasi_approved = true;
                $notaRekomendasi->is_verifikasi_approved = true;
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi");
                    // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->first()->urutan;
                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi");
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });
                    // dd($check_urutan_user);

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_$proyek->kode_proyek";
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk proses tandatangan penyusun Nota Rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);
                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                            //     return redirect()->back();
                            // });
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan hasil asesmen " . $proyek->proyekBerjalan->customer->name . " untuk proses tandatangan penyusun Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Penyusun Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                    }
                }
            }


            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            // if ($proyek->save()) {
            //     // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
            //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } elseif (!empty($request["verifikasi-revisi"])) {
            if (empty($request["revisi-note"])) {
                Alert::error('Mohon isi catatan revisi');
                return redirect()->back();
            }

            // $revisi_note = collect(json_decode($proyek->revisi_note));
            $revisi_note = collect(json_decode($notaRekomendasi->revisi_note));
            $revisi_note->push([
                "user_id" => Auth::user()->id,
                "status" => "revisi",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["revisi-note"]
            ]);

            // $proyek->revisi_note = $revisi_note;
            // $proyek->is_revisi = true;
            $notaRekomendasi->revisi_note = $revisi_note;
            $notaRekomendasi->is_revisi = true;

            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", 1);

            foreach ($get_nomor as $user) {
                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_$proyek->kode_proyek";
                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                //     "sender" => env("NO_WHATSAPP_BLAST"),
                //     // "sender" => "6281188827008",
                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                //     // "number" => "085881028391",
                //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan permintaan revisi asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk perbaikan Nota Rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                //     // "url" => $url
                // ]);
                // $send_msg_to_wa->onError(function ($error) {
                //     // dd($error);
                //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                //     return redirect()->back();
                // });

                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permintaan revisi asesmen " . $proyek->proyekBerjalan->customer->name . " untuk perbaikan Nota Rekomendasi tahap I pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                $sendEmailUser = sendNotifEmail($user->Pegawai, "Pemberitahuan Revisi Assessment Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }
            }
            // $kriteria_detail = KriteriaPenggunaJasaDetail::where('kode_proyek', $proyek->kode_proyek);

            //Begin::delete file kriteria pengguna jasa
            // $filter_file = $kriteria_detail->get()->map(function ($detail) {
            //     return json_decode($detail->id_document);
            // })->flatten();

            // $filter_file->each(function ($file) {
            //     if (!empty($file)) {
            //         File::delete(public_path('/file-kriteria-pengguna-jasa//' . $file));
            //     }
            // });

            // $kriteria_detail->delete();
            //End::delete file kriteria pengguna jasa

            // $proyek->is_penyusun_approved = null;
            // $proyek->approved_penyusun = null;
            // $proyek->approved_verifikasi = null;
            // $proyek->is_draft_recommend_note = null;
            $notaRekomendasi->is_penyusun_approved = null;
            $notaRekomendasi->approved_penyusun = null;
            $notaRekomendasi->approved_verifikasi = null;
            $notaRekomendasi->is_draft_recommend_note = null;



            // if ($proyek->save()) {
            //     // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
            //     Alert::html("Success", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> berhasil dikembalikan ke Penyusun", "success");
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> berhasil dikembalikan ke Penyusun", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> gagal dikembalikan ke Penyusun", "error");
            return redirect()->back();
        } else if (!empty($request["verifikasi-tolak"])) {
            // $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
            $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
            ]);

            // $proyek->approved_verifikasi = $approved_verifikasi->toJson();
            // $proyek->is_verifikasi_approved = false;
            // $proyek->is_disetujui = false;
            $notaRekomendasi->approved_verifikasi = $approved_verifikasi->toJson();
            $notaRekomendasi->is_verifikasi_approved = false;
            $notaRekomendasi->is_disetujui = false;
            $proyek->is_disetujui = false;

            // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            // if ($proyek->save()) {
            //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
            //     // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
            //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save() && $proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["rekomendasi-setujui"])) {
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
            $is_paralel = true;

            if (!isset($data["kategori-rekomendasi"]) && is_null($data["kategori-rekomendasi"])) {
                Alert::html("Failed", "<b>Kategori Rekomendasi</b> harap diisi!", "error");
                return redirect()->back();
            }

            if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan dengan catatan") {
                // $approved_rekomendasi_final = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_rekomendasi_final = collect(json_decode($notaRekomendasi->approved_rekomendasi_final));
                $approved_rekomendasi_final->push([
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["alasan-ditolak"],
                ]);
                // $proyek->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();
                $notaRekomendasi->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_rekomendasi_final, "Rekomendasi");
                // dd($is_checked);
                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        // $proyek->is_recommended = false;
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_recommended = false;
                        $notaRekomendasi->is_disetujui = false;

                        // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
                        $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                        $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                        $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                        // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                    } else {
                        $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Persetujuan");
                        // dd($matriks_approval);
                        // $matriks_approval = MatriksApprovalRekomendasi::where("unit_kerja", "=", $proyek->UnitKerja->Divisi->id_divisi)->where("klasifikasi_proyek", "=", $proyek->klasifikasi_pasdin)->where("kategori", "=", "Persetujuan")->get();
                        foreach ($matriks_approval as $key => $user) {
                            $user = $user->Pegawai->User;
                            // URL::forceScheme("https");
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $url = URL::temporarySignedRoute("rekomendasi", now()->addHours(3), ["open" => "kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek, "user" => $user->nip]);
                            // $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek . "&token=$token";
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                            //     return redirect()->back();
                            // });
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                        // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                        // $proyek->is_recommended_with_note = true;
                        // $proyek->is_recommended = true;
                        $notaRekomendasi->is_recommended_with_note = true;
                        $notaRekomendasi->is_recommended = true;
                    }
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error(
                                //         'Error',
                                //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                //     );
                                //     return redirect()->back();
                                // });
                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    }
                }
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi dengan catatan", "success");
            } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Tidak Direkomendasikan") {
                // $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_rekomendasi_final));
                $approved_verifikasi->push([
                    "user_id" => Auth::user()->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["alasan-ditolak"],
                ]);
                // $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();
                $notaRekomendasi->approved_rekomendasi_final = $approved_verifikasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Rekomendasi");
                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        // $proyek->is_recommended = false;
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_recommended = false;
                        $notaRekomendasi->is_disetujui = false;

                        // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
                        $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                        $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                        $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                        // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                    }
                }

                // if ($proyek->save()) {
                //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak oleh tim Rekomendasi", "success");
                //     return redirect()->back();
                // }
                if ($notaRekomendasi->save() && $proyek->save()) {
                    Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak oleh tim Rekomendasi", "success");
                    return redirect()->back();
                }
            } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan") {
                // $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_rekomendasi_final));
                $approved_verifikasi->push([
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["alasan-ditolak"],
                ]);
                // $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();
                $notaRekomendasi->approved_rekomendasi_final = $approved_verifikasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Rekomendasi");
                // dd($is_checked);
                if ($is_checked) {
                    if ($is_has_not_recommended) {
                        // $proyek->is_recommended = false;
                        $proyek->is_disetujui = false;
                        $notaRekomendasi->is_recommended = false;
                        $notaRekomendasi->is_disetujui = false;

                        // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
                        $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                        $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                        $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                        // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                    } else {
                        // $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Persetujuan");
                        $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Persetujuan");
                        foreach ($matriks_approval as $key => $user) {
                            $user = $user->Pegawai->User;
                            // URL::forceScheme("https");
                            // $url = URL::temporarySignedRoute("rekomendasi", now()->addHours(3), ["open" => "kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek, "user" => $user->User->nip]);
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                            // $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek . "&token=$token";
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     // "sender" => "62811881227",
                            //     "number" => $this->isnomorTargetActive ? $user->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     // "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap I untuk *" . $proyek->proyekBerjalan->customer->name . "* pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);

                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                            //     return redirect()->back();
                            // });
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap I untuk " . $proyek->proyekBerjalan->customer->name . " pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                        }
                        // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                        // $proyek->is_recommended = true;
                        $notaRekomendasi->is_recommended = true;
                    }
                } else {
                    if (!$is_paralel) {
                        $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->first()->urutan;
                        $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                            return $user->urutan == $matriks_sekarang + 1;
                        });

                        if ($check_urutan_user) {
                            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi", (int)$matriks_sekarang + 1);
                            foreach ($get_nomor as $user) {
                                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                                // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                                //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                                //     "sender" => env("NO_WHATSAPP_BLAST"),
                                //     // "sender" => "6281188827008",
                                //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                                //     // "number" => "085881028391",
                                //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                                //     // "url" => $url
                                // ]);
                                // $send_msg_to_wa->onError(function ($error) {
                                //     // dd($error);
                                //     Alert::error(
                                //         'Error',
                                //         "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                                //     );
                                //     return redirect()->back();
                                // });
                                $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Persetujuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                                if (!$sendEmailUser) {
                                    return redirect()->back();
                                }
                            }
                        }
                    }
                }
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi", "success");
            }

            // if ($proyek->save()) {
            //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
            //     return redirect()->back();
            // }
            if ($notaRekomendasi->save() && $proyek->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["rekomendasi-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            $notaRekomendasi->approved_rekomendasi_final = $approved_verifikasi->toJson();

            $notaRekomendasi->is_recommended = false;
            $proyek->is_disetujui = false;
            $notaRekomendasi->is_disetujui = false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save() && $notaRekomendasi->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["persetujuan-setujui"])) {
            // $approved_persetujuan = collect(json_decode($proyek->approved_persetujuan));
            $approved_persetujuan = collect(json_decode($notaRekomendasi->approved_persetujuan));
            $approved_persetujuan->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["catatan-persetujuan"]
            ]);
            // $proyek->approved_persetujuan = $approved_persetujuan->toJson();
            $notaRekomendasi->approved_persetujuan = $approved_persetujuan->toJson();

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_persetujuan, "Persetujuan");
            if ($is_checked) {
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
                $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
                // $proyek->is_disetujui = true;
                // $proyek->persetujuan_note = $request["catatan-persetujuan"];
                $notaRekomendasi->is_disetujui = true;
                $notaRekomendasi->persetujuan_note = $request["catatan-persetujuan"];
                $proyek->is_disetujui = true;
            }
            // if ($proyek->save()) {
            //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
            //     return redirect()->back();
            // }
            if (
                $notaRekomendasi->save() && $proyek->save()
            ) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["persetujuan-tolak"])) {
            // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $approved_verifikasi = collect(json_decode($proyek->approved_persetujuan));
            $approved_verifikasi = collect(json_decode($notaRekomendasi->approved_persetujuan));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            // $proyek->approved_persetujuan = $approved_verifikasi->toJson();
            $notaRekomendasi->approved_persetujuan = $approved_verifikasi->toJson();

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Persetujuan");
            // dd($is_checked);
            // $proyek->persetujuan_note = $request["catatan-persetujuan"];
            // $proyek->is_disetujui = false;
            $notaRekomendasi->persetujuan_note = $request["catatan-persetujuan"];
            $notaRekomendasi->is_disetujui = false;
            // $proyek->is_disetujui = false;
            // if($is_checked) {
            //     $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            //     $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            //     $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
            // }
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            // if ($proyek->save()) {
            //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
            //     // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
            //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
            //     return redirect()->back();
            // }
            if ($proyek->save() && $notaRekomendasi->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                createWordNotaRekomendasiSetuju($notaRekomendasi, $hasil_assessment, $request);
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        }
        // End Prosess Approval
        if (!empty($data["verify-otp"]) || !empty(!empty($data["signature"]))) {
            $otp_controller = new OTPController();
            if (!empty($data["verify-otp"])) {
                $otp = collect($data["otp"])->join("");
                $is_otp_validated = $otp_controller->validateOTP($otp, $user);
                if (!$is_otp_validated) {
                    Alert::error("OTP Invalid", "Oops! OTP is invalid. Please try again!");
                    // return $otp_controller->index($request, $user);
                    return redirect()->back();
                    // return errorPage(403, "OTP Invalid", "Oops! OTP is invalid.", "");
                }
            } else {
                // Check if the user has submitted approval
                $open_modal = explode("_", $data["open"]);
                $proyek = Proyek::find($open_modal[count($open_modal) - 1]);
                $data_approval_persetujuan = collect(json_decode($proyek->approved_persetujuan));
                if ($data_approval_persetujuan->isNotEmpty() && $data_approval_persetujuan->where("user_id", "=", $user->id)->count() > 0) {
                    return errorPage(403, "Link has expired", "Link has expired", "Oops! This link has expired. You already submitted for this link.");
                }
                return $otp_controller->index($request, $user);
            }
        }

        // get proyek from WA
        $proyek_from_url = null;
        if (!empty($data["open"])) {
            $kode_proyek_url = explode("_", $data["open"]);
            // dd(count($kode_proyek_url));
            if (count($kode_proyek_url) > 5) {
                $proyek_from_url = Proyek::where("kode_proyek", "=", $kode_proyek_url[5])->first();
            } else {
                $proyek_from_url = Proyek::where("kode_proyek", "=", $kode_proyek_url[4])->first();
            }
        }

        // $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator || Gate::any(['super-admin']);
        $is_super_user = Gate::any(['super-admin']);
        $unit_kerjas = $is_super_user || str_contains(Auth::user()->name, "Admin") ? UnitKerja::addSelect(["divcode"])->get()->toArray() : (str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja))->toArray();
        $matriks_user = Auth::user()->Pegawai->MatriksApproval ?? null;
        $is_pic = Auth::user()->check_administrator ? true : (empty($matriks_user) || $matriks_user->isEmpty() ? true : false);
        if ($is_pic) {
            $matriks_user = MatriksApprovalRekomendasi::all();
        }
        $matriks_category = [];

        if ($is_super_user) {
            // $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) {
            //     return ($p->is_request_rekomendasi || !empty($p->approved_rekomendasi)) && !$p->review_assessment;
            // });
            // $proyeks_penyusun = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) {
            //     return $p->review_assessment == true && (is_null($p->is_draft_recommend_note) || $p->is_draft_recommend_note);
            // });
            // $proyeks_verifikasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) {
            //     return (!is_null($p->is_draft_recommend_note) && !$p->is_draft_recommend_note) && is_null($p->is_verifikasi_approved);
            // });
            // $proyeks_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($all_super_user_counter) {
            //     // $approved_rekomendasi = collect(json_decode($p->approved_rekomendasi));
            //     return $p->review_assessment && empty($p->is_recommended);
            // });
            // $proyeks_persetujuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->get()->filter(function ($p) {
            //     return $p->is_recommended;
            // });

            $proyeks_proses_rekomendasi = NotaRekomendasi::whereIn("unit_kerja", $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->where('is_disetujui', '=', null)->get()?->filter(function ($p) {
                return is_null($p->is_disetujui) || !$p->Proyek->is_cancel;
            });
            $proyeks_rekomendasi_final = NotaRekomendasi::whereIn("unit_kerja", $unit_kerjas)->get()->filter(function ($p) use ($matriks_user) {
                return $p->is_disetujui == true && !is_null($p->is_disetujui) || $p->Proyek->is_cancel;
                // return !is_null($p->is_disetujui) || $p->Proyek->is_cancel;
            });
            $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori']);
        } else {
            $proyeks_rekomendasi_final = NotaRekomendasi::whereIn('unit_kerja', $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->get()->filter(function ($p) use ($matriks_user) {
                return (!is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0 || $p->Proyek->is_cancel);
            });
            $proyeks_proses_rekomendasi = NotaRekomendasi::whereIn('unit_kerja', $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->get()->filter(function ($p) use ($matriks_user) {
                return (is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0 && !$p->Proyek->is_cancel);
            });
            $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori', 'departemen']);
            // dd($matriks_category);
            $all_proyeks = NotaRekomendasi::whereIn('unit_kerja', $unit_kerjas)->get()->filter(function ($p) use ($matriks_user) {
                return $p->is_disetujui && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            });
        }
        if (!empty($rekomendasi_open)) {
            return view('13_Rekomendasi', compact(["proyek_from_url", "nip", "all_super_user_counter", "rekomendasi_open", "is_user_exist_in_matriks_approval", "matriks_user", "matriks_category", "proyeks_rekomendasi_final", "proyeks_proses_rekomendasi", "is_pic"]));
        }
        return view('13_Rekomendasi', compact(["proyek_from_url", "nip", "all_super_user_counter", "is_user_exist_in_matriks_approval", "matriks_user", "matriks_category", "proyeks_rekomendasi_final", "proyeks_proses_rekomendasi", "is_pic"]));
    }

    public function indexGreenLane(Request $request)
    {
        $filter = $request->query("filter");
        $filterStage = $request->query("filter-stage");
        $filterJenis = $request->query("filter-jenis");
        $filterTipe = $request->query("filter-tipe");
        $filterUnit = $request->query("filter-unit");
        $subtitle = "Proyek Green Lane";

        $jenisProyek = JenisProyek::all();
        $customers = Customer::all();
        $sumberdanas = SumberDana::all();
        $tipeProyek = TipeProyek::all();

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $unitkerjas = UnitKerja::all()->whereIn("divcode", $unit_kerja_user->toArray());
            $proyeks = Proyek::with(['UnitKerja', 'proyekBerjalan'])->whereIn("unit_kerja", $unit_kerja_user->toArray());
        } else {
            $unitkerjas = UnitKerja::all();
            $proyeks = Proyek::all();
        }

        $proyeks = $proyeks->where("tahun_perolehan", "=", (int) date("Y"))->get()->filter(function ($proyek) {
            return $proyek->is_disetujui || checkGreenLine($proyek);
        });

        $selected_year = (int) date("Y");
        $tahun_proyeks = $proyeks->groupBy("tahun_perolehan")->keys();

        return view("3_Proyek_green_non_green_lane", compact([
            "proyeks",
            "selected_year",
            "tahun_proyeks",
            "filterStage",
            "filterJenis",
            "filterTipe",
            "filterUnit",
            "jenisProyek",
            "tipeProyek",
            "customers",
            "sumberdanas",
            "subtitle",
            "unitkerjas"
        ]));
    }

    public function indexNonGreenLane(Request $request)
    {
        $filter = $request->query("filter");
        $filterStage = $request->query("filter-stage");
        $filterJenis = $request->query("filter-jenis");
        $filterTipe = $request->query("filter-tipe");
        $filterUnit = $request->query("filter-unit");
        $subtitle = "Proyek Non Green Lane";

        $jenisProyek = JenisProyek::all();
        $customers = Customer::all();
        $sumberdanas = SumberDana::all();
        $tipeProyek = TipeProyek::all();

        $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
            $unitkerjas = UnitKerja::all()->whereIn("divcode", $unit_kerja_user->toArray());
            $proyeks = Proyek::with(['UnitKerja', 'proyekBerjalan'])->whereIn("unit_kerja", $unit_kerja_user->toArray());
        } else {
            $unitkerjas = UnitKerja::all();
            $proyeks = Proyek::all();
        }

        $proyeks = $proyeks->where("tahun_perolehan", "=", (int) date("Y"))->get()->filter(function ($proyek) {
            return !$proyek->is_disetujui || !checkGreenLine($proyek);
        });

        $selected_year = (int) date("Y");
        $tahun_proyeks = $proyeks->groupBy("tahun_perolehan")->keys();

        return view("3_Proyek_green_non_green_lane", compact([
            "proyeks",
            "selected_year",
            "tahun_proyeks",
            "filterStage",
            "filterJenis",
            "filterTipe",
            "filterUnit",
            "jenisProyek",
            "tipeProyek",
            "customers",
            "sumberdanas",
            "subtitle",
            "unitkerjas"
        ]));
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

    private function getNomorMatriksApproval($id_divisi, $klasifikasi_pasdin, $departemen, $kategori, $urutan = null)
    {
        $matriks_approval = MatriksApprovalRekomendasi::where("is_active", true)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori);
        // if ($kategori == "Persetujuan") {
        //     return $matriks_approval->get();
        // } else {
        //     if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi") {
        //         return $matriks_approval->where("unit_kerja", $id_divisi)->first();
        //     }
        //     return $matriks_approval->first();
        // }
        if (empty($urutan)) {
            if ($kategori == "Persetujuan") {
                // return $matriks_approval->get();
                return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->get();
            } else {
                if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi" || $kategori == "Penyusun") {
                    return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->get();
                }
                return $matriks_approval->get();
            }
        } else {
            if ($kategori == "Persetujuan") {
                // return $matriks_approval->where('urutan', '=', $urutan)->get();
                return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->where('urutan', '=', $urutan)->get();
            } else {
                if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi" || $kategori == "Penyusun") {
                    return $matriks_approval->where("unit_kerja", $id_divisi)->where("departemen", $departemen)->where('urutan', '=', $urutan)->get();
                }
                return $matriks_approval->where('urutan', '=', $urutan)->get();
            }
        }
    }

    public function generateFileNotaRekomendasiFinal(Request $request, $kode_proyek)
    {
        $proyek = Proyek::find($kode_proyek);
        $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();

        if (!empty($proyek)) {
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $hasil_assessment = collect(json_decode($notaRekomendasi->hasil_assessment));
            try {
                // $generateForm = createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                $generateForm = createWordNotaRekomendasiSetuju($notaRekomendasi, $hasil_assessment, $request);
                $notaRekomendasi->refresh();
                sleep(5);
                // $file_persetujuan_old = $proyek->file_persetujuan;
                // $file_persetujuan_old = $notaRekomendasi->file_persetujuan;
                $pdfMerger = new PdfMerge();
                $pdfMerger->add(public_path('file-persetujuan' . '/' . $notaRekomendasi->file_persetujuan));
                $pdfMerger->add(public_path('file-rekomendasi' . '/' . $notaRekomendasi->file_rekomendasi));
                // $pdfMerger->add(public_path('file-profile-risiko' . '/' . $proyek->file_penilaian_risiko));
                $pdfMerger->add(public_path('file-profile-risiko' . '/' . $notaRekomendasi->file_penilaian_risiko));

                if (!empty($proyek->DokumenPendukungPasarDini)) {
                    foreach ($proyek->DokumenPendukungPasarDini as $dokumen) {
                        $pdfMerger->add(public_path('dokumen-pendukung-pasdin' . '/' . $dokumen->id_document));
                    }
                }

                if (!empty($proyek->proyekBerjalan->customer->AHU)) {
                    foreach ($proyek->proyekBerjalan->customer->AHU as $dokumen) {
                        $pdfMerger->add(public_path('customer-file' . '/' . $dokumen->file_document));
                    }
                }

                $now = \Carbon\Carbon::now();
                $file_name = $now->format("dmYHis") . "_nota-persetujuan_" . $proyek->kode_proyek;
                $pdfMerger->merge(public_path("file-persetujuan" . "/" . $file_name . ".pdf"));

                // File::delete(public_path('file-persetujuan'.'/'.$file_persetujuan_old));
                // $proyek->file_persetujuan = $file_name . ".pdf";
                $notaRekomendasi->file_persetujuan = $file_name . ".pdf";

                // if ($proyek->save()) {
                //     return response()->json([
                //         'success' => true,
                //         'message' => "File berhasil dibuat"
                //     ]);
                // }
                if ($notaRekomendasi->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => "File berhasil dibuat"
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => "File gagal dibuat, Hubungi Admin"
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function uploadFileNotaRekomendasiFinal(Request $request, Proyek $proyek)
    {
        if (empty($proyek)) {
            Alert::error('Error', 'Proyek tidak ditemukan. Hubungi admin!');
            return redirect()->back();
        }

        $uploadedFile = $request->file('dokumen-nota-rekomendasi-1');

        $dokumen = new DokumenNotaRekomendasi1();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(" ", "-", $file_name);
        $nama_document = $file_name;
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $proyek->kode_proyek;
        $uploadedFile->move(public_path('dokumen-nota-rekomendasi'), $id_document);

        if ($dokumen->save()) {
            Alert::success('Success', "Dokumen Nota Rekomendasi Final Berhasil diupload");
            return redirect()->back();
        }
        Alert::error('Error', "Dokumen Nota Rekomendasi Final Gagal diupload");
        return redirect()->back();
    }

    public function downloadFileNotaRekomendasiFinal($id_document)
    {
        $dokumenFinal = DokumenNotaRekomendasi1::where('id_document', $id_document)->first();
        if (empty($dokumenFinal)) {
            Alert::error('Error', 'Dokumen tidak ditemukan. Hubungi admin!');
            return redirect()->back();
        }

        return response()->download(public_path('dokumen-nota-rekomendasi/' . $dokumenFinal->id_document), $dokumenFinal->nama_dokumen);
    }

    public function viewProyekQrCode(Request $request, $kode_proyek, $nip)
    {
        try {
            $ProyekNotaQrSelected = NotaRekomendasi::where('kode_proyek', $kode_proyek)->first();
            $proyekSelected = $ProyekNotaQrSelected->Proyek;
            $assessmentInternal = 0;
            $assessmentEksternal = 0;

            $kategori = $request->get("kategori");

            switch ($kategori) {
                case 'pengajuan':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_pengajuan));
                    break;
                case 'penyusun':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_verifikasi));
                    break;
                case 'rekomendasi':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_rekomendasi_final));
                    break;
                case 'persetujuan':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->approved_persetujuan));
                    break;

                default:
                    $collectPenandatangan = null;
                    break;
            }

            if ($kategori != "pengajuan") {
                $hasil_assessment = collect(json_decode($ProyekNotaQrSelected->hasil_assessment));
                $assessmentInternal = $hasil_assessment->sum(function ($ra) {
                    if ($ra->kategori == "Internal") {
                        return $ra->score;
                    }
                });
                $assessmentEksternal = $hasil_assessment->sum(function ($ra) {
                    if ($ra->kategori == "Eksternal") {
                        return $ra->score;
                    }
                });
            }

            $userSelected = User::where('nip', $nip)->first();

            $penandatanganSelected = $collectPenandatangan->where('user_id', $userSelected->id)->first();

            $penandatanganSelected->user_id = $userSelected->name;

            $penandatanganSelected->jabatan = $userSelected->Pegawai?->Jabatan?->nama_jabatan ?? null;

            $penandatanganSelected->tanggal = \Carbon\Carbon::parse(date('d M Y H:i:s', strtotime($penandatanganSelected->tanggal)))->translatedFormat('d F Y, H:i:s');

            return view('22_View_TTD_Barcode_Nota_1', ["penandatanganSelected" => $penandatanganSelected, "dataNotaRekomendasi" => $ProyekNotaQrSelected, "proyek" => $proyekSelected, "kategori" => $kategori, "assessmentInternal" => $assessmentInternal, "assessmentEksternal" => $assessmentEksternal]);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'Attempt to read property "id" on null') {
                throw new \Exception('Pegawai tidak ditemukan. Mohon Hubungi Admin!', 0, $e);
            } else {
                throw $e;
            }
        }
    }
}
