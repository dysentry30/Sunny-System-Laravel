<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\MatriksApprovalRekomendasi;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RekomendasiController extends Controller
{
    public $isnomorTargetActive = false;
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

            //Flow setelah setuju rekomendasi pengajuan
            if ($check_user_approval_counter) {
                $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;
                $hasil_assessment = collect(performAssessment($proyek->proyekBerjalan->Customer, $proyek));
                // dd($hasil_assessment);
                // createWord($proyek, $hasil_assessment, $is_proyek_mega);

                $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, "Penyusun")->Pegawai->handphone : $this->nomorDefault;
                // dd($nomorTarget);
                $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
                $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                    "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                    "sender" => "6281188827008",
                    // "sender" => "62811881227",
                    "number" => $nomorTarget,
                    // "number" => "085881028391",
                    "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan permohonan Pengajuan Nota Rekomendasi I, *" . $proyek->ProyekBerjalan->name_customer . "* untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                    // "url" => $url
                ]);

                $send_msg_to_wa->onError(function ($error) {
                    // dd($error);
                    Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                    return redirect()->back();
                });

                QrCode::size(50)->generate($request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_", public_path('/qr-code' . '/' . $proyek->kode_proyek . '.svg'));
                createWordPengajuan($proyek, $hasil_assessment, $is_proyek_mega);
                createWordRekomendasi($proyek, $hasil_assessment, $is_proyek_mega);
                $proyek->review_assessment = true;
                $proyek->is_request_rekomendasi = false;
                $proyek->hasil_assessment = $hasil_assessment;
                $proyek->approved_rekomendasi = $data->toJson();
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
            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $data, "Pengajuan");
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
            // $data = $request->all();


            if (strlen(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi"))) < 58) {
                $note_penyusun = null;
                $proyek->recommended_with_note = null;
            } else {
                $note_penyusun = substr(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi")), 59);
                $proyek->recommended_with_note = "Direkomendasikan dengan catatan";
            }

            $data = collect(json_decode($proyek->approved_penyusun));
            $data = $data->push(
                [
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "catatan" => $note_penyusun,
                    "tanggal" => \Carbon\Carbon::now()
                ]
            );
            $proyek->approved_penyusun = $data->toJson();
            // dd($data);

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $data, "Penyusun");

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
                if (!str_contains($proyek->klasifikasi_pasdin, "Mega") || !str_contains($proyek->klasifikasi_pasdin, "Besar")) {
                    $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
                    $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_user_view_persetujuan" . $proyek->kode_proyek;
                    $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                        "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                        "sender" => "6281188827008",
                        // "sender" => "62811881227",
                        "number" => $nomorTarget,
                        // "number" => "085881028391",
                        "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                        // "url" => $url
                    ]);
                } else {
                    $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, "Verifikasi")->Pegawai->handphone : $this->nomorDefault;
                    $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
                    $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                        "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                        "sender" => "6281188827008",
                        // "sender" => "62811881227",
                        "number" => $nomorTarget,
                        // "number" => "085881028391",
                        "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk proses verifikasi penyusunan Nota Rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                        // "url" => $url
                    ]);
                }

                $send_msg_to_wa->onError(function ($error) {
                    // dd($error);
                    Alert::error(
                        'Error',
                        "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !"
                    );
                    return redirect()->back();
                });

                // if (empty($request->get("note-rekomendasi"))) {
                //     $proyek->recommended_with_note = "-";
                // } else {
                //     $proyek->recommended_with_note = $request->get("note-rekomendasi");
                // }

                $proyek->is_draft_recommend_note = false;

                if (
                    !str_contains($proyek->klasifikasi_pasdin, "Mega") || !str_contains($proyek->klasifikasi_pasdin, "Besar")
                ) {
                    $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
                    $approved_verifikasi->push([
                        "user_id" => Auth::user()->id,
                        "status" => "approved",
                        "tanggal" => \Carbon\Carbon::now(),
                    ]);
                    $proyek->approved_verifikasi = $approved_verifikasi->toJson();
                    $proyek->is_verifikasi_approved = true;
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
            if (strlen(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi"))) < 58) {
                $note_penyusun = null;
                $proyek->recommended_with_note = null;
            } else {
                $note_penyusun = substr(preg_replace('/\s+/', ' ', $request->get("note-rekomendasi")), 59);
                $proyek->recommended_with_note = "Direkomendasikan dengan catatan";
            }
            if ($proyek->save()) {
                Alert::html("Success", "Verifikasi dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disimpan sebagai draft", "success");
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
        } else if (!empty($request["verifikasi-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));

            $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $proyek->approved_verifikasi = $approved_verifikasi->toJson();
            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $approved_verifikasi, "Penyusun");
            $nomorTarget = !empty($this->isnomorTargetActive) ? self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, "Rekomendasi")->Pegawai->handphone : $this->nomorDefault;
            if ($is_checked) {
                $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_user_view_persetujuan" . $proyek->kode_proyek;
                $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                    "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                    "sender" => "6281188827008",
                    // "sender" => "62811881227",
                    "number" => $nomorTarget,
                    // "number" => "085881028391",
                    "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan hasil asesmen *" . $proyek->proyekBerjalan->customer->name . "* untuk permohonan pemberian rekomendasi tahap I pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                    // "url" => $url
                ]);

                $send_msg_to_wa->onError(function ($error) {
                    // dd($error);
                    Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                    return redirect()->back();
                });
                $proyek->is_verifikasi_approved = true;
            }


            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
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
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
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
                    "alasan" => $request["alasan-ditolak"],
                ]);
                $proyek->approved_rekomendasi_final = $approved_rekomendasi_final->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $approved_rekomendasi_final, "Rekomendasi");
                if ($is_checked) {
                    $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, "Persetujuan");
                    // $matriks_approval = MatriksApprovalRekomendasi::where("unit_kerja", "=", $proyek->UnitKerja->Divisi->id_divisi)->where("klasifikasi_proyek", "=", $proyek->klasifikasi_pasdin)->where("kategori", "=", "Persetujuan")->get();
                    foreach ($matriks_approval as $key => $user) {
                        $user = $user->Pegawai->User;
                        // URL::forceScheme("https");
                        $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_user_view_persetujuan" . $proyek->kode_proyek;
                        // $url = URL::temporarySignedRoute("rekomendasi", now()->addHours(3), ["open" => "kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek, "user" => $user->nip]);
                        // $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_user_view_persetujuan" . $proyek->kode_proyek . "&token=$token";
                        $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            "sender" => "6281188827008",
                            // "sender" => "62811881227",
                            "number" => $this->isnomorTargetActive ? $user->Pegawai->handphone : $this->nomorDefault,
                            // "number" => "085881028391",
                            "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            // "url" => $url
                        ]);

                        $send_msg_to_wa->onError(function ($error) {
                            // dd($error);
                            Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                            return redirect()->back();
                        });
                    }
                    // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                    $proyek->is_recommended_with_note = true;
                    $proyek->is_recommended = true;
                }
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi dengan catatan", "success");
            } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Tidak Direkomendasikan") {
                $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_verifikasi->push([
                    "user_id" => Auth::user()->id,
                    "status" => "rejected",
                    "tanggal" => \Carbon\Carbon::now(),
                    "alasan" => $request["alasan-ditolak"],
                ]);
                $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();

                $proyek->is_recommended = false;
                $proyek->is_disetujui = false;
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak oleh tim Rekomendasi", "success");
            } else if (isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan") {
                $approved_verifikasi = collect(json_decode($proyek->approved_rekomendasi_final));
                $approved_verifikasi->push([
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                    "tanggal" => \Carbon\Carbon::now(),
                    "alasan" => $request["alasan-ditolak"],
                ]);
                $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();

                $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $approved_verifikasi, "Rekomendasi");
                // dd($is_checked);
                if ($is_checked) {
                    // $matriks_approval = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, "Persetujuan");
                    $matriks_approval = MatriksApprovalRekomendasi::where("unit_kerja", "=", $proyek->UnitKerja->Divisi->id_divisi)->where("klasifikasi_proyek", "=", $proyek->klasifikasi_pasdin)->where("kategori", "=", "Persetujuan")->get();
                    foreach ($matriks_approval as $key => $user) {
                        $user = $user->Pegawai->User;
                        URL::forceScheme("https");
                        $url = URL::temporarySignedRoute("rekomendasi", now()->addHours(3), ["open" => "kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek, "user" => $user->User->nip]);
                        // $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek;
                        // $url = $request->schemeAndHttpHost() . "?redirectTo=/rekomendasi?open=kt_user_view_persetujuan" . $proyek->kode_proyek . "&token=$token";
                        $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
                            "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
                            "sender" => "6281188827008",
                            // "sender" => "62811881227",
                            "number" => $this->isnomorTargetActive ? $user->Pegawai->handphone : $this->nomorDefault,
                            // "number" => "085881028391",
                            // "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan Permohonan tanda tangan Persetujuan Nota Rekomendasi Tahap I untuk Proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            "message" => "Yth Bapak/Ibu .....\nDengan ini menyampaikan permohonan persetujuan Nota Rekomendasi Tahap I untuk *" . $proyek->proyekBerjalan->customer->name . "* pada proyek *$proyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
                            // "url" => $url
                        ]);

                        $send_msg_to_wa->onError(function ($error) {
                            // dd($error);
                            Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
                            return redirect()->back();
                        });
                    }
                    // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                    $proyek->is_recommended = true;
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
                Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
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
                "alasan" => $request["alasan-ditolak"],
            ]);
            $proyek->approved_rekomendasi_final = $approved_verifikasi->toJson();

            $proyek->is_recommended = false;
            $proyek->is_disetujui = false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if (!empty($request["persetujuan-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $approved_verifikasi = collect(json_decode($proyek->approved_persetujuan));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => \Carbon\Carbon::now(),
            ]);
            $proyek->approved_persetujuan = $approved_verifikasi->toJson();

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $approved_verifikasi, "Persetujuan");
            // dd($is_checked);
            if ($is_checked) {
                $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
                $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
                $hasil_assessment = collect(json_decode($proyek->hasil_assessment));

                URL::forceScheme("https");
                $url = URL::temporarySignedRoute("rekomendasi", now()->addHours(3), ["open" => "kt_modal_view_proyek_persetujuan_" . $proyek->kode_proyek]);
                QrCode::size(50)->generate($url, public_path('/qr-code' . '/' . $proyek->kode_proyek . '.svg'));
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                $proyek->is_disetujui = true;
                $proyek->persetujuan_note = $request["catatan-persetujuan"];
            }
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if ($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect("/");
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect("/");
        } else if (!empty($request["persetujuan-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $approved_verifikasi = collect(json_decode($proyek->approved_persetujuan));
            $approved_verifikasi->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => \Carbon\Carbon::now(),
                "alasan" => $request["alasan-ditolak"],
            ]);
            $proyek->approved_persetujuan = $approved_verifikasi->toJson();

            $is_checked = self::checkMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->klasifikasi_pasdin, $approved_verifikasi, "Persetujuan");
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
            if ($all_super_user_counter < 1) {
                $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                    return ($p->is_request_rekomendasi || $p->review_assessment || !empty($p->hasil_assessment) || !empty($p->approved_rekomendasi));
                });

                $proyeks_rekomendasi = [];

                $proyeks_persetujuan = [];
            } else {
                /*
                if ($matriks_user->contains("kategori", "Pengajuan")) {
                    $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return ($p->is_request_rekomendasi && !$p->review_assessment && is_null($p->hasil_assessment)) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->review_assessment == true && (is_null($p->is_draft_recommend_note) || $p->is_draft_recommend_note) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Pengajuan')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
                } else {
                    $proyeks_pengajuan = [];
                }

                if ($matriks_user->contains("kategori", "Penyusun")) {
                    $proyeks_penyusun = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->review_assessment == true && (is_null($p->is_draft_recommend_note) || $p->is_draft_recommend_note) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return (!is_null($p->is_draft_recommend_note) && !$p->is_draft_recommend_note) && is_null($p->is_verifikasi_approved) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Penyusun')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
                } else {
                    $proyeks_penyusun = [];
                }

                if ($matriks_user->contains("kategori", "Verifikasi")) {
                    $proyeks_verifikasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return (!is_null($p->is_draft_recommend_note) && !$p->is_draft_recommend_note) && is_null($p->is_verifikasi_approved) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->is_verifikasi_approved && is_null($p->is_recommended) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Verifikasi')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
                } else {
                    $proyeks_verifikasi = [];
                }

                if ($matriks_user->contains("kategori", "Rekomendasi")) {
                    $proyeks_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->is_verifikasi_approved && is_null($p->is_recommended) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->is_recommended == true && is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Rekomendasi')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
                } else {
                    $proyeks_rekomendasi = [];
                }

                if ($matriks_user->contains("kategori", "Persetujuan")) {
                    $proyeks_persetujuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->is_recommended == true && is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $proyeks_rekomendasi_final = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                        return $p->is_recommended == true && is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                    });
                    $matriks_category = MatriksApprovalRekomendasi::where('kategori', 'Persetujuan')->get()->groupBy(['klasifikasi_proyek', 'kategori']);
                } else {
                    $proyeks_persetujuan = [];
                }
                */

                $proyeks_pengajuan = [];
                $proyeks_penyusun = [];
                $proyeks_verifikasi = [];
                $proyeks_rekomendasi = [];
                $proyeks_persetujuan = [];

                $proyeks_rekomendasi_final = Proyek::whereIn('unit_kerja', $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                    return $p->is_disetujui && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                });
                $proyeks_proses_rekomendasi = Proyek::whereIn('unit_kerja', $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                    return is_null($p->is_disetujui) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                });
                $matriks_category = MatriksApprovalRekomendasi::all()->groupBy(['klasifikasi_proyek', 'kategori']);
                // dd($matriks_category);
                $all_proyeks = Proyek::whereIn('unit_kerja', $unit_kerjas)->where("stage", "=", 1)->get()->filter(function ($p) use ($matriks_user) {
                    return $p->is_disetujui && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                });
            }
        }
        if (!empty($rekomendasi_open)) {
            return view('13_Rekomendasi', compact(["nip", 'proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter", "rekomendasi_open", "proyeks_rekomendasi", "proyeks_penyusun", "proyeks_verifikasi", "is_user_exist_in_matriks_approval", "matriks_user", "matriks_category", "proyeks_rekomendasi_final", "proyeks_proses_rekomendasi"]));
        }
        return view('13_Rekomendasi', compact(["nip", 'proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter", "proyeks_rekomendasi", "proyeks_penyusun", "proyeks_verifikasi", "is_user_exist_in_matriks_approval", "matriks_user", "matriks_category", "proyeks_rekomendasi_final", "proyeks_proses_rekomendasi"]));
    }

    private function checkMatriksApproval($unit_kerja, $klasifikasi_proyek, $approved_data, $kategori): bool
    {
        $matriks_approval = MatriksApprovalRekomendasi::where("start_tahun", "=", (int) date("Y"))->get();
        if ($kategori == "Penyusun") {
            return $matriks_approval->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("kategori", "=", $kategori)->count() == $approved_data->count();
        }
        return $matriks_approval->where("unit_kerja", "=", $unit_kerja)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("kategori", "=", $kategori)->count() == $approved_data->count();
    }

    private function getNomorMatriksApproval($id_divisi, $klasifikasi_pasdin, $kategori)
    {
        $matriks_approval = MatriksApprovalRekomendasi::where("is_active", true)->where("klasifikasi_proyek", "=", $klasifikasi_pasdin)->where("kategori", "=", $kategori);
        if ($kategori == "Persetujuan") {
            return $matriks_approval->get();
        } else {
            if ($kategori == "Pangajuan" || $kategori == "Verifikasi" || $kategori == "Rekomendasi") {
                return $matriks_approval->where("unit_kerja", $id_divisi)->first();
            }
            return $matriks_approval->first();
        }
    }
}
