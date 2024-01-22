<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyek;
use App\Models\JenisProyek;
use App\Models\TipeProyek;
use App\Models\Customer;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\MatriksApprovalRekomendasi;
use App\Models\KriteriaPenggunaJasaDetail;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Karriere\PdfMerge\PdfMerge;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RekomendasiController extends Controller
{
    public $isnomorTargetActive = false;
    // public $isnomorTargetActive = true;
    // public $nomorDefault = "6285376444701";
    public $nomorDefault = "085881028391";

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
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        $all_super_user_counter = $all_super_user_counter->groupBy("Pegawai.nama_pegawai")->count();
        // dd($all_super_user_counter);
        // $all_super_user_counter = 1;
        $rekomendasi_open = $request->query("open") ?? "";
        // Begin Prosess Approval
        if (!empty($request->setuju)) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $is_paralel = false;
            // $proyek->is_request_rekomendasi = false;
            $data = collect(json_decode($proyek->approved_rekomendasi));
            $data = $data->mergeRecursive([
                [
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                ]
            ]);
            $check_user_approval_counter = is_array(collect($data->first())->values()->first()) ? collect($data->first())->values()->count() == $all_super_user_counter : $data->count() == $all_super_user_counter;
            $is_user_id_exist = $data->filter(function ($d) {
                if (is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            // dd($data, $check_user_approval_counter);
            $proyek->approved_rekomendasi = $data->toJson();


            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $data, "Pengajuan");
            // dd($is_checked);
            //Flow setelah setuju rekomendasi pengajuan
            // dd(MatriksApprovalRekomendasi::where("unit_kerja", "=", $proyek->UnitKerja->Divisi->id_divisi)->where("klasifikasi_proyek", "=", $proyek->klasifikasi_pasdin)->where("kategori", "=", "Pengajuan")->get());
            if ($is_checked) {
            // if ($check_user_approval_counter) {
                $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;
                $hasil_assessment = collect(performAssessment($proyek->proyekBerjalan->Customer, $proyek));
                // dd($hasil_assessment);
                // createWord($proyek, $hasil_assessment, $is_proyek_mega);

                // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun")->where('urutan', '=', 1) : $this->nomorDefault;
                $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun")->where('urutan', '=', 1);
                // dd($nomorTarget);
                foreach ($nomorTarget as $target) {
                    // dd($target->Pegawai->handphone);
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_user_view_kriteria_" . $proyek->kode_proyek;
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
                    $message = nl2br("Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
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
                createWordPengajuan($proyek, $hasil_assessment, $is_proyek_mega, null);
                createWordRekomendasi($proyek, $hasil_assessment, $is_proyek_mega);
                $proyek->review_assessment = true;
                $proyek->is_request_rekomendasi = false;
                $proyek->hasil_assessment = $hasil_assessment;
                $proyek->approved_rekomendasi = $data->toJson();
            } else {
                if (!$is_paralel) {
                    $matriks_approval = self::getUserMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan");
                    $matriks_sekarang = self::getUrutanUserMatriksApprovalSekarang(Auth::user()->nip, $proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan");
                    // $matriks_sekarang = MatriksApprovalRekomendasi::where('nama_pegawai', Auth::user()->nip)->first()->urutan;
                    $check_urutan_user = $matriks_approval->contains(function ($user) use ($matriks_sekarang) {
                        return $user->urutan == $matriks_sekarang + 1;
                    });

                    if ($check_urutan_user) {
                        $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Pengajuan", (int)$matriks_sekarang + 1);
                        foreach ($get_nomor as $user) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$proyek->kode_proyek";
                            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            //     "sender" => env("NO_WHATSAPP_BLAST"),
                            //     // "sender" => "6281188827008",
                            //     "number" => !empty($this->isnomorTargetActive) ? $user->Pegawai->handphone : $this->nomorDefault,
                            //     // "number" => "085881028391",
                            //     "message" => "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            //     // "url" => $url
                            // ]);
                            $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, " . $proyek->ProyekBerjalan->name_customer . " untuk Proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                            $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Penandatanganan Pengajuan Nota Rekomendasi I", $message, $this->isnomorTargetActive);
                            if (!$sendEmailUser) {
                                return redirect()->back();
                            }
                            // $send_msg_to_wa->onError(function ($error) {
                            //     // dd($error);
                            //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                            //     return redirect()->back();
                            // });
                        }
                    }
                }

            }
            if ($proyek->save()) {
                Alert::html("Success", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disetujui", "success");
                return redirect()->back();
            }
            // if(!$is_user_id_exist) {
            // }
            Alert::html("Failed", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui", "error");
            return redirect()->back();
        } else if (!empty($request->tolak)) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            // $proyek->is_request_rekomendasi = true;
            $data = collect(json_decode($proyek->approved_rekomendasi));
            // dd($data);
            $is_user_id_exist = $data->filter(function ($d) {
                if (is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            $data = $data->mergeRecursive(
                [
                    [
                        "user_id" => Auth::user()->id,
                        "status" => "rejected",
                        "alasan" => $request->get("alasan-ditolak"),
                        "tanggal" => \Carbon\Carbon::now(),
                    ]
                ]
            );
            // dd($data);
            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $data, "Pengajuan");
            if ($is_checked) {
                $proyek->is_recommended = false;
                $proyek->is_request_rekomendasi = false;
                $proyek->is_disetujui = false;
            }
            $proyek->approved_rekomendasi = $data->toJson();
            if ($proyek->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        } else if (!empty($request["input-rekomendasi-with-note"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $is_paralel = false;
            // $data = $request->all();
            // dd($request->get("note-rekomendasi"));


            // if (strlen(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi"))) < 58) {
            //     $note_penyusun = null;
            //     $proyek->recommended_with_note = null;
            // } else {
            //     // $note_penyusun = substr(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi")), 59);
            //     $note_penyusun = substr($request->get("note-rekomendasi"),62);
            //     $proyek->recommended_with_note = "Direkomendasikan dengan catatan";
            // }
            $data = collect(json_decode($proyek->approved_penyusun));

            if ($data->where('user_id', Auth::user()->id)->isEmpty()) {
                $data = $data->push(
                    [
                        "user_id" => Auth::user()->id,
                        "status" => "approved",
                        "catatan" => $request->get("note-rekomendasi") ?? '-',
                        "tanggal" => \Carbon\Carbon::now()
                    ]
                );
                $proyek->approved_penyusun = $data->toJson();
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

                $proyek->approved_penyusun = $data->values()->toJson();
            }
            // $proyek->approved_penyusun = $note_penyusun;
            $proyek->catatan_nota_rekomendasi = $request->get("note-rekomendasi");

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $data, "Penyusun");

            if ($is_checked) {
                $proyek->is_penyusun_approved = true;
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                $hasil_assessment = collect(json_decode($proyek->hasil_assessment));

                // if(isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan dengan catatan") {
                //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                //     $proyek->is_recommended_with_note = true;
                //     $proyek->is_recommended = true;
                //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi dengan catatan", "success");
                // } else if(isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Tidak Direkomendasikan") {
                //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                //     $proyek->is_recommended = false;
                //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi", "success");
                // } else if(isset($data["kategori-rekomendasi"])) {
                //     $proyek->is_recommended = true;
                //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                //     Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi", "success");
                // }
                if (is_null($proyek->is_revisi)) {
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
                        // $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Verifikasi")->Pegawai->handphone : $this->nomorDefault;
                        // $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
                        // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                        //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                        //     "sender" => env("NO_WHATSAPP_BLAST"),
                            // "sender" => "6281188827008",
                        //     // "sender" => "62811881227",
                        //     "number" => $nomorTarget,
                        //     // "number" => "085881028391",
                        //     "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk proses verifikasi penyusunan Nota Rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                        //     // "url" => $url
                        // ]);
                        $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Rekomendasi");
                        foreach ($nomorTarget as $target) {
                            $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
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
    
                        $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
                        $approved_verifikasi->push([
                            "user_id" => Auth::user()->id,
                            "status" => "approved",
                            "tanggal" => \Carbon\Carbon::now(),
                        ]);
                        $proyek->approved_verifikasi = $approved_verifikasi->toJson();
                        $proyek->is_verifikasi_approved = true;
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
                    }

                    $proyek->is_revisi = null;
                }


                // if (empty($request->get("note-rekomendasi"))) {
                //     $proyek->recommended_with_note = "-";
                // } else {
                //     $proyek->recommended_with_note = $request->get("note-rekomendasi");
                // }

                $proyek->is_draft_recommend_note = false;
                // createWordProfileRisiko($proyek->kode_proyek);
                $mergeLampiran = mergeFileLampiranRisiko($proyek->kode_proyek);
                $profileResiko = createWordProfileRisikoNew($proyek->kode_proyek);
                // dd($profileResiko);
                if (!empty($profileResiko)) {
                    // dd($mergeLampiran);
                    if (!empty($mergeLampiran)) {
                        $pdfMerger = new PdfMerge();
                        $pdfMerger->add(public_path('file-profile-risiko' . '/' . $profileResiko));
                        $pdfMerger->add(public_path('file-kriteria-pengguna-jasa' . '/' . $mergeLampiran));

                        $now = \Carbon\Carbon::now();
                        $file_name = $now->format("dmYHis") . "_profile-risiko-final_" . $proyek->kode_proyek;
                        sleep(10);
                        // File::delete(public_path('/file-profile-risiko//' . $profileResiko));
                        $pdfMerger->merge(public_path("file-profile-risiko" . "/" . $file_name . ".pdf"));
                        // dd($pdfMerger);
                        $proyek->file_penilaian_risiko = $file_name . ".pdf";
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
                    }
                }
            }

            // dd($proyek);
            if ($proyek->save()) {
                Alert::html("Success", "Penyusunan dengan nama proyek <b>$proyek->nama_proyek</b> berhasil", "success");
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
            Alert::html("Failed", "Penyusunan dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        } else if (!empty($request["save-draft-note-rekomendasi"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $proyek->is_draft_recommend_note = true;
            // if (strlen(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi"))) < 58) {
            //     $note_penyusun = null;
            //     $proyek->recommended_with_note = null;
            // } else {
            //     // $note_penyusun = substr(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi")), 59);
            //     $note_penyusun = substr($request->get("note-rekomendasi"),62);
            //     $proyek->recommended_with_note = "Direkomendasikan dengan catatan";
            // }
            $data = collect(json_decode($proyek->approved_penyusun));
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
            $proyek->approved_penyusun = $data->values()->toJson();
            // dd($proyek->approved_penyusun);
            $proyek->catatan_nota_rekomendasi = $request->get("note-rekomendasi");
            if ($proyek->save()) {
                Alert::html("Success", "Penyusun dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disimpan sebagai draft", "success");
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
        } else if (!empty($request["verifikasi-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $is_paralel = false;
            $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $proyek->approved_verifikasi = $approved_verifikasi->toJson();
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
                $proyek->is_verifikasi_approved = true;
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
            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } elseif (!empty($request["verifikasi-revisi"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            if (empty($request["revisi-note"])) {
                Alert::error('Mohon isi catatan revisi');
                return redirect()->back();
            }

            $revisi_note = collect(json_decode($proyek->revisi_note));
            $revisi_note->push([
                "user_id" => Auth::user()->id,
                "status" => "revisi",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["revisi-note"]
            ]);

            $proyek->revisi_note = $revisi_note;
            $proyek->is_revisi = true;

            $get_nomor = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, "Penyusun", 1);

            foreach ($get_nomor as $user) {
                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_$proyek->kode_proyek";
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

            $proyek->is_penyusun_approved = null;
            $proyek->approved_penyusun = null;
            $proyek->approved_penyusun = null;
            $proyek->is_draft_recommend_note = null;



            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> berhasil dikembalikan ke Penyusun", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Proyek dengan nama proyek <b>$proyek->nama_proyek</b> gagal dikembalikan ke Penyusun", "error");
            return redirect()->back();


        } else if (!empty($request["verifikasi-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $proyek->approved_verifikasi = $approved_verifikasi->toJson();
            $proyek->is_verifikasi_approved = false;
            $proyek->is_disetujui = false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["rekomendasi-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_paralel = true;

            if (!isset($data["kategori-rekomendasi"]) && is_null($data["kategori-rekomendasi"])) {
                Alert::html("Failed", "<b>Kategori Rekomendasi</b> harap diisi!", "error");
                return redirect()->back();
            }

            if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan dengan catatan") {
                $approved_rekomendasi_final = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_rekomendasi_final->push([
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["alasan-ditolak"],
                ]);
                $proyek->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_rekomendasi_final, "Rekomendasi");
                // dd($is_checked);
                if ($is_checked) {
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
                    $proyek->is_recommended_with_note = true;
                    $proyek->is_recommended = true;
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
                $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_verifikasi->push([
                    "user_id" => Auth::user()->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["alasan-ditolak"],
                ]);
                $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();

                $proyek->is_recommended = false;
                $proyek->is_disetujui = false;

                $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);

                if ($proyek->save()) {
                    Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak oleh tim Rekomendasi", "success");
                    return redirect()->back();
                }

            } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan") {
                $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_verifikasi->push([
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "catatan" => $request["alasan-ditolak"],
                ]);
                $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Rekomendasi");
                // dd($is_checked);
                if ($is_checked) {
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
                    $proyek->is_recommended = true;
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


            // $send_msg_to_wa->onError(function ($error) {
            //     // dd($error);
            //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            //     return redirect()->back();
            // });

            // $proyek->is_recommended = true;

            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
                // Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
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
            $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();

            $proyek->is_recommended = false;
            $proyek->is_disetujui = false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["persetujuan-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $approved_persetujuan = collect(json_decode($proyek->approved_persetujuan));
            $approved_persetujuan->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["catatan-persetujuan"]
            ]);
            $proyek->approved_persetujuan = $approved_persetujuan->toJson();

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_persetujuan, "Persetujuan");
            if ($is_checked) {
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                $hasil_assessment = collect(json_decode($proyek->hasil_assessment));

                // URL::forceScheme("https");
                // $url = URL::temporarySignedRoute("rekomendasi", now()->addHours(3), ["open" => "kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek]);
                // QrCode::size(50)->generate($url, public_path('/qr-code' . '/' . $proyek->kode_proyek . '.svg'));
                // createWordProfileRisiko($proyek->kode_proyek);
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                // dd("Tes");
                $proyek->is_disetujui = true;
                $proyek->persetujuan_note = $request["catatan-persetujuan"];
            }
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["persetujuan-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            $approved_verifikasi = collect(json_decode($proyek->approved_persetujuan));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
                "catatan" => $request["alasan-ditolak"],
            ]);
            $proyek->approved_persetujuan = $approved_verifikasi->toJson();

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $proyek->departemen_proyek, $approved_verifikasi, "Persetujuan");
            // dd($is_checked);
            $proyek->persetujuan_note = $request["catatan-persetujuan"];
            $proyek->is_disetujui = false;
            // if($is_checked) {
            //     $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            //     $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            //     $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            //     createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
            // }
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
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

        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
        $unit_kerjas = $is_super_user && str_contains(Auth::user()->name, "Admin") ? UnitKerja::addSelect(["divcode"])->get()->toArray() : (str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja))->toArray();
        $matriks_user = Auth::user()->Pegawai->MatriksApproval ?? null;
        $matriks_category = [];

        if ($is_super_user) {
            $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) {
                return ($p->is_request_rekomendasi || !empty($p->approved_rekomendasi)) && !$p->review_assessment;
            });
            $proyeks_penyusun = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) {
                return $p->review_assessment == true && (is_null($p->is_draft_recommend_note) || $p->is_draft_recommend_note);
            });
            $proyeks_verifikasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) {
                return (!is_null($p->is_draft_recommend_note) && !$p->is_draft_recommend_note) && is_null($p->is_verifikasi_approved);
            });
            $proyeks_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($all_super_user_counter) {
                // $approved_rekomendasi = collect(json_decode($p->approved_rekomendasi));
                return $p->review_assessment && empty($p->is_recommended);
            });
            $proyeks_persetujuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->get()->filter(function ($p) {
                return $p->is_recommended;
            });

            $proyeks_proses_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->where('is_request_rekomendasi', '!=', null)->where('is_disetujui', '=', null)->get();
            $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                return $p->is_recommended == true && $p->is_disetujui;
            });
            $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori']);
        } else {
            // if ($all_super_user_counter < 1) {
            //     $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //         return ($p->is_request_rekomendasi || $p->review_assessment || !empty($p->hasil_assessment) || !empty($p->approved_rekomendasi));
            //     });

            //     $proyeks_rekomendasi = [];

            //     $proyeks_persetujuan = [];
            // } else {
            //     /*
            //     if ($matriks_user->contains("kategori", "Pengajuan")) {
            //         $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return ($p->is_request_rekomendasi && !$p->review_assessment && is_null($p->hasil_assessment)) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->review_assessment == true && (is_null($p->is_draft_recommend_note) || $p->is_draft_recommend_note) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Pengajuan')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
            //     } else {
            //         $proyeks_pengajuan = [];
            //     }

            //     if ($matriks_user->contains("kategori", "Penyusun")) {
            //         $proyeks_penyusun = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->review_assessment == true && (is_null($p->is_draft_recommend_note) || $p->is_draft_recommend_note) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return (!is_null($p->is_draft_recommend_note) && !$p->is_draft_recommend_note) && is_null($p->is_verifikasi_approved) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Penyusun')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
            //     } else {
            //         $proyeks_penyusun = [];
            //     }

            //     if ($matriks_user->contains("kategori", "Verifikasi")) {
            //         $proyeks_verifikasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return (!is_null($p->is_draft_recommend_note) && !$p->is_draft_recommend_note) && is_null($p->is_verifikasi_approved) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->is_verifikasi_approved && is_null($p->is_recommended) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Verifikasi')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
            //     } else {
            //         $proyeks_verifikasi = [];
            //     }

            //     if ($matriks_user->contains("kategori", "Rekomendasi")) {
            //         $proyeks_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->is_verifikasi_approved && is_null($p->is_recommended) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->is_recommended == true && is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Rekomendasi')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
            //     } else {
            //         $proyeks_rekomendasi = [];
            //     }

            //     if ($matriks_user->contains("kategori", "Persetujuan")) {
            //         $proyeks_persetujuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->is_recommended == true && is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
            //             return $p->is_recommended == true && is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            //         });
            //         $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Persetujuan')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
            //     } else {
            //         $proyeks_persetujuan = [];
            //     }
            //     */

            //     // $proyeks_pengajuan = [];
            //     // $proyeks_penyusun = [];
            //     // $proyeks_verifikasi = [];
            //     // $proyeks_rekomendasi = [];
            //     // $proyeks_persetujuan = [];

            // }
            $proyeks_rekomendasi_final = Proyek::whereIn('unit_kerja', $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                return !is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            });
            $proyeks_proses_rekomendasi = Proyek::whereIn('unit_kerja', $unit_kerjas)->where('is_request_rekomendasi', '!=', null)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                return is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            });
            $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori', 'departemen']);
            // dd($matriks_category);
            $all_proyeks = Proyek::whereIn('unit_kerja', $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                return $p->is_disetujui && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
            });
        }
        if (!empty($rekomendasi_open)) {
            return view('13_Rekomendasi', compact(["proyek_from_url", "nip", "all_super_user_counter", "rekomendasi_open", "is_user_exist_in_matriks_approval", "matriks_user", "matriks_category", "proyeks_rekomendasi_final", "proyeks_proses_rekomendasi"]));
        }
        return view('13_Rekomendasi', compact(["proyek_from_url", "nip", "all_super_user_counter", "is_user_exist_in_matriks_approval", "matriks_user", "matriks_category", "proyeks_rekomendasi_final", "proyeks_proses_rekomendasi"]));
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
            return $matriks_approval->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("unit_kerja", "=", $unit_kerja)->where('departemen', $departemen)->where("kategori", "=", $kategori)->count() == $approved_data->count();
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

        if (!empty($proyek)) {
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            try {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega, $request);
                $file_persetujuan_old = $proyek->file_persetujuan;
                $pdfMerger = new PdfMerge();
                $pdfMerger->add(public_path('file-persetujuan' . '/' . $file_persetujuan_old));
                $pdfMerger->add(public_path('file-profile-risiko' . '/' . $proyek->file_penilaian_risiko));

                $now = \Carbon\Carbon::now();
                $file_name = $now->format("dmYHis") . "_nota-persetujuan_" . $proyek->kode_proyek;
                $pdfMerger->merge(public_path("file-persetujuan" . "/" . $file_name . ".pdf"));

                // File::delete(public_path('file-persetujuan'.'/'.$file_persetujuan_old));
                $proyek->file_persetujuan = $file_name . ".pdf";

                if ($proyek->save()) {
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
}
