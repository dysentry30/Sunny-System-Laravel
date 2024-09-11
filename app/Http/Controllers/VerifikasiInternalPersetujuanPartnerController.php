<?php

namespace App\Http\Controllers;

use App\Models\MatriksApprovalPersetujuanPartner;
use App\Models\Pegawai;
use App\Models\Proyek;
use App\Models\UnitKerja;
use App\Models\User;
use App\Models\VerifikasiInternalPersetujuanPartner;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Karriere\PdfMerge\PdfMerge;

class VerifikasiInternalPersetujuanPartnerController extends Controller
{

    public $matriks_user;
    public bool $isnomorTargetActive;

    public function __construct()
    {
        $this->isnomorTargetActive = env('IS_SEND_EMAIL');
    }

    /**
     * ? Tampilan Menu Approval Verifikasi Partner
     *
     */
    public function index()
    {
        // $this->matriks_user = !Auth::user()->check_administrator ? Auth::user()->Pegawai->MatriksApprovalPersetujuanPartner->where('is_active', true) : MatriksApprovalPersetujuanPartner::all()->where('is_active', true);
        $this->matriks_user = !Auth::user()->check_administrator && !Gate::allows("admin-crm") ? Auth::user()->Pegawai->MatriksApprovalPersetujuanPartner->where('is_active', true) : MatriksApprovalPersetujuanPartner::all()->where('is_active', true);

        $is_super_user = Gate::allows("super-admin");
        $unit_kerjas = $is_super_user && str_contains(Auth::user()->name, "Admin") || str_contains(Auth::user()->name, "ANDIAS") ?
            UnitKerja::select('divcode')->get()->map(function ($unit_kerja) {
                return $unit_kerja["divcode"];
            }) : (str_contains(Auth::user()->unit_kerja, ",") ?
                collect(explode(",", Auth::user()->unit_kerja)) :
                collect(Auth::user()->unit_kerja))->toArray();

        $all_super_user_counter = MatriksApprovalPersetujuanPartner::all()->filter(function ($user) {
            return $user->nip == Auth::user()->nip;
        });

        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            return $user->nip == Auth::user()->nip;
        });

        $matriks_category = [];

        $matriks_user = $this->matriks_user;
        $collectDivisiMatriksUser = $matriks_user?->groupBy('divisi_id')->keys()->values()->toArray() ?? [];
        $collectDepartemenMatriksUser = $matriks_user?->groupBy('departemen_code')->keys()->values()->toArray() ?? [];

        $collectDivisiMatriksUser = $matriks_user?->groupBy('divisi_id')?->keys()?->toArray();
        $collectDepartemenMatriksUser = $matriks_user?->groupBy('departemen_code')?->keys()?->toArray();

        $matriks_category = MatriksApprovalPersetujuanPartner::all()->groupBy(['kategori', 'departemen_code', 'divisi_id']);

        $partnerApprovalAll = VerifikasiInternalPersetujuanPartner::with('Proyek')?->whereIn('unit_kerja', $unit_kerjas)->whereIn('divisi_id', $collectDivisiMatriksUser)?->whereIn('departemen_id', $collectDepartemenMatriksUser)?->orderByDesc('updated_at')->get();

        $dataProyekProsesVerifikasi = $partnerApprovalAll->whereNull('is_persetujuan_approved')->filter(function ($proyek) {
            return !$proyek->is_cancel;
        });

        $dataProyekFinishVerifikasi = $partnerApprovalAll->filter(function ($proyek) {
            return !is_null($proyek->is_persetujuan_approved) || $proyek->Proyek->is_cancel;
        });

        return view('27_VerifikasiInternalPersetujuanPartner', [
            'dataProyekProsesVerifikasi' => $dataProyekProsesVerifikasi,
            'dataProyekFinishVerifikasi' => $dataProyekFinishVerifikasi,
            'matriks_user' => $matriks_user,
            'matriks_category' => $matriks_category
        ]);
    }

    /**
     * ? Proses Request Pengajuan Approval Verifikasi Partner
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Proyek $proyek
     */
    public function ProsesRequestApproval(Request $request, Proyek $proyek)
    {
        try {

            $checkUserInMatriks = $this->checkValidateUserMatriks(Auth::user(), $proyek, "Request Pengajuan");

            if (!$checkUserInMatriks) {
                return response()->json([
                    "Success" => false,
                    "Message" => "Anda tidak dapat melakukan aksi ini. Silahkan Hubungi Admin!"
                ]);
                // Alert::error("Unautorized User", "Anda tidak dapat melakukan aksi ini. Silahkan Hubungi Admin!");
                // return redirect()->back();
            }

            $verifikasiKSO = collect(json_decode($proyek->alasan_kso));

            if ($verifikasiKSO->isEmpty()) {
                return response()->json([
                    "Success" => false,
                    "Message" => "Mohon isi Verifikasi Internal KSO terlebih dahulu!"
                ]);
            }

            $pdf = Pdf::loadView('GenerateFile.generatePermohonanKSO', ["proyek" => $proyek]);

            if (!File::isDirectory(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/'))) {
                File::makeDirectory(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/'));
            }

            $namaFile = date("dmYHis_") . $proyek->kode_proyek . "_Dokumen_Verifikasi_Internal_Persetujuan_KSO.pdf";

            $pdf->save(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/' . $namaFile));

            $requestApproval = collect([
                "nip" => Auth::user()->nip,
                "status" => "Requested",
                "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s"),
            ]);

            $isExistVerifikasi = VerifikasiInternalPersetujuanPartner::where("kode_proyek", $proyek->kode_proyek)->first();

            if (empty($isExistVerifikasi)) {
                $newApproval = new VerifikasiInternalPersetujuanPartner();
                $newApproval->kode_proyek = $proyek->kode_proyek;
                $newApproval->unit_kerja = $proyek->unit_kerja;
                $newApproval->divisi_id = $proyek->UnitKerja->Divisi->id_divisi;
                $newApproval->departemen_id = $proyek->departemen_proyek;
                $newApproval->request_pengajuan = $requestApproval->toJson();
                $newApproval->stage = "Pengajuan";
                $newApproval->is_request_pengajuan = true;
                $newApproval->nama_dokumen = $namaFile;

                $nomorTarget = self::getNomorMatriksApproval($proyek->UnitKerja->Divisi->id_divisi, $proyek->departemen_proyek, "Pengajuan");

                if ($newApproval->save()) {
                    self::mergeFileFinalDokumen($namaFile, $newApproval);
                    foreach ($nomorTarget as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini mengajukan varifikasi internal persetujuan partner untuk proyek " . $proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                }
            } else {
                $isExistVerifikasi->is_request_pengajuan = true;
                $isExistVerifikasi->stage = "Pengajuan";
                $isExistVerifikasi->request_pengajuan = $requestApproval->toJson();
                $isExistVerifikasi->is_revisi = null;
                $isExistVerifikasi->nama_dokumen = $namaFile;

                $nomorTarget = self::getNomorMatriksApproval($isExistVerifikasi->divisi_id, $proyek->departemen_proyek, "Pengajuan");

                if ($isExistVerifikasi->save()) {
                    foreach ($nomorTarget as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_view_proyek_rekomendasi_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini mengajukan varifikasi internal persetujuan partner untuk proyek " . $proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Pengajuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                }
            }
            // Alert::success("Pengajuan Berhasil", "Proses Pengajuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO) Berhasil Diajukan");
            // return redirect()->back();
            return response()->json([
                'Success' => true,
                'Message' => "Proses Pengajuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO) Berhasil Diajukan"
            ]);
        } catch (\Throwable $th) {
            // return response()->json([
            //     'Success' => false,
            //     'Message' => $th->getMessage()
            // ]);
            throw $th;
        }
    }

    /**
     * ? Proses Approval Pengajuan Verifikasi Partner
     */
    public function ProsesPengajuanApproval(Request $request, VerifikasiInternalPersetujuanPartner $proyek)
    {
        $data = $request->all();

        try {

            if (empty($proyek)) {
                Alert::error("Error", "Proyek Tidak Ditemukan. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            $checkValidateUser = $this->checkValidateUserMatriks(auth()->user(), $proyek->Proyek, "Pengajuan");

            if (!$checkValidateUser) {
                Alert::error("Error", "Anda tidak dapat melakukan approval. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            if (isset($data["is_approved"])) {
                $approvedPengajuan = collect(json_decode($proyek->pengajuan_approved));
                $approvedPengajuan = $approvedPengajuan->push([
                    "nip" => auth()->user()->nip,
                    "status" => "approved",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s")
                ]);

                $proyek->pengajuan_approved = $approvedPengajuan->toJson();

                $is_done = $this->checkMatriksApproval($proyek->divisi_id, $proyek->departemen_id, $approvedPengajuan, "Pengajuan");
                if ($is_done) {

                    $proyek->stage = "Pengusul";
                    $proyek->is_pengajuan_approved = true;

                    $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Pengusul");

                    foreach ($getNomorMatriks as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_pengajuan_verifikasi_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan pemberitahuan verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan persetujuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                }

                $proyek->save();
                Alert::success("Success", "Proyek Berhasil Disetujui");
                return redirect()->back();
            } else {
                $revisiNote = collect(json_decode($proyek->revisi_note));
                $revisiNote = $revisiNote->push([
                    "nip" => auth()->user()->nip,
                    "status" => "Revisi",
                    "stage" => "Pengajuan",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s"),
                    "catatan" => $data["catatan-revisi"]
                ]);

                $proyek->is_revisi = true;
                $proyek->revisi_note = $revisiNote->toJson();
                $proyek->is_request_pengajuan = null;
                $proyek->request_pengajuan = null;

                $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Pengajuan");
                foreach ($getNomorMatriks as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_pengajuan_verifikasi_" . $proyek->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan revisi verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Revisi Pengajuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }

                $proyek->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * ? Proses Approval Pengusul Verifikasi Partner
     */
    public function ProsesPengusulApproval(Request $request, VerifikasiInternalPersetujuanPartner $proyek)
    {
        $data = $request->all();

        try {

            if (empty($proyek)) {
                Alert::error("Error", "Proyek Tidak Ditemukan. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            $checkValidateUser = $this->checkValidateUserMatriks(auth()->user(), $proyek->Proyek, "Pengusul");

            if (!$checkValidateUser) {
                Alert::error("Error", "Anda tidak dapat melakukan approval. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            if (isset($data["is_approved"])) {
                $approvedPengusul = collect(json_decode($proyek->pengusul_approved));
                $approvedPengusul = $approvedPengusul->push([
                    "nip" => auth()->user()->nip,
                    "status" => "approved",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s")
                ]);

                $proyek->pengusul_approved = $approvedPengusul->toJson();

                $is_done = $this->checkMatriksApproval($proyek->divisi_id, $proyek->departemen_id, $approvedPengusul, "Pengusul");
                if ($is_done) {

                    $proyek->stage = "Rekomendasi";
                    $proyek->is_pengusul_approved = true;

                    $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Rekomendasi");

                    foreach ($getNomorMatriks as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_pengajuan_verifikasi_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan pemberian rekomendasi verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan persetujuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Permohonan Pemberian Rekomendasi Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                }

                $proyek->save();
                Alert::success("Success", "Proyek Berhasil Disetujui");
                return redirect()->back();
            } else {
                $revisiNote = collect(json_decode($proyek->revisi_note));
                $revisiNote = $revisiNote->push([
                    "nip" => auth()->user()->nip,
                    "status" => "Revisi",
                    "stage" => "Pengusul",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s"),
                    "catatan" => $data["catatan-revisi"]
                ]);

                $proyek->is_revisi = true;
                $proyek->revisi_note = $revisiNote->toJson();
                $proyek->is_request_pengajuan = null;
                $proyek->request_pengajuan = null;

                $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Pengajuan");
                foreach ($getNomorMatriks as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_pengajuan_verifikasi_" . $proyek->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan revisi verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Revisi Pengajuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }

                $proyek->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * ? Proses Pemberian Rekomendasi Verifikasi Partner
     */
    public function ProsesRekomendasiApproval(Request $request, VerifikasiInternalPersetujuanPartner $proyek)
    {
        $data = $request->all();

        try {

            if (empty($proyek)) {
                Alert::error("Error", "Proyek Tidak Ditemukan. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            $checkValidateUser = $this->checkValidateUserMatriks(auth()->user(), $proyek->Proyek, "Rekomendasi");

            if (!$checkValidateUser) {
                Alert::error("Error", "Anda tidak dapat melakukan approval. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            if (isset($data["is_approved"])) {
                $approvedRekomendasi = collect(json_decode($proyek->rekomendasi_approved));
                $approvedRekomendasi = $approvedRekomendasi->push([
                    "nip" => auth()->user()->nip,
                    "status" => "approved",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s")
                ]);

                $proyek->rekomendasi_approved = $approvedRekomendasi->toJson();

                $is_done = $this->checkMatriksApproval($proyek->divisi_id, $proyek->departemen_id, $approvedRekomendasi, "Rekomendasi");

                if ($is_done) {

                    $proyek->stage = "Persetujuan";
                    $proyek->is_rekomendasi_approved = true;

                    $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Persetujuan");

                    foreach ($getNomorMatriks as $target) {
                        $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_persetujuan_verifikasi_" . $proyek->kode_proyek;
                        $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                        $sendEmailUser = sendNotifEmail($target->Pegawai, "Permohonan Persetujuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                        if (!$sendEmailUser) {
                            return redirect()->back();
                        }
                    }
                }

                $proyek->save();
                Alert::success("Success", "Proyek Berhasil Disetujui");
                return redirect()->back();
            } else {
                $revisiNote = collect(json_decode($proyek->revisi_note));
                $revisiNote = $revisiNote->push([
                    "nip" => auth()->user()->nip,
                    "status" => "Revisi",
                    "stage" => "Rekomendasi",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s"),
                    "catatan" => $data["catatan-revisi"]
                ]);

                $proyek->is_revisi = true;
                $proyek->revisi_note = $revisiNote->toJson();
                $proyek->is_request_persetujuan = null;
                $proyek->request_persetujuan = null;

                $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Pengajuan");
                foreach ($getNomorMatriks as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_persetujuan_verifikasi_" . $proyek->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan revisi verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Revisi Persetujuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }

                $proyek->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * ? Proses Pemberian Persetujuan Verifikasi Partner
     */
    public function ProsesPersetujuanApproval(Request $request, VerifikasiInternalPersetujuanPartner $proyek)
    {
        $data = $request->all();

        try {

            if (empty($proyek)) {
                Alert::error("Error", "Proyek Tidak Ditemukan. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            $checkValidateUser = $this->checkValidateUserMatriks(auth()->user(), $proyek->Proyek, "Persetujuan");

            if (!$checkValidateUser) {
                Alert::error("Error", "Anda tidak dapat melakukan approval. Hubungi Admin!");
                return redirect()->back()->with(["modal" => $data["modal-name"]]);
            }

            if (isset($data["is_approved"])) {
                $approvedPersetujuan = collect(json_decode($proyek->persetujuan_approved));
                $approvedPersetujuan = $approvedPersetujuan->push([
                    "nip" => auth()->user()->nip,
                    "status" => "approved",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s")
                ]);

                $proyek->persetujuan_approved = $approvedPersetujuan->toJson();

                $is_done = $this->checkMatriksApproval($proyek->divisi_id, $proyek->departemen_id, $approvedPersetujuan, "Persetujuan");

                if ($is_done) {

                    $proyek->stage = "Selesai";
                    $proyek->is_persetujuan_approved = true;

                    // $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Request Pengajuan");
                    $getNomorMatriks = collect(json_decode($proyek->request_pengajuan));

                    $user = Pegawai::where("nip", $getNomorMatriks["nip"])->first();
                    $url = $request->schemeAndHttpHost() . "?nip=" . $user->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_persetujuan_verifikasi_" . $proyek->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $user->nama_pegawai . "\nDengan ini menyampaikan permohonan pemberian rekomendasi verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($user, "Permohonan Pemberian Rekomendasi Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                    $proyek->save();
                    $namaFile = self::generateFinalDokumen($request, $proyek->Proyek);
                    self::mergeFileFinalDokumen($namaFile, $proyek);
                }

                $proyek->save();

                Alert::success("Success", "Proyek Berhasil Disetujui");
                return redirect()->back();
            } else {
                $revisiNote = collect(json_decode($proyek->revisi_note));
                $revisiNote = $revisiNote->push([
                    "nip" => auth()->user()->nip,
                    "status" => "Revisi",
                    "stage" => "Pengajuan",
                    "tanggal" => Carbon::now()->translatedFormat("d F Y H:i:s"),
                    "catatan" => $data["catatan-revisi"]
                ]);

                $proyek->is_revisi = true;
                $proyek->revisi_note = $revisiNote;
                $proyek->is_request_persetujuan = null;
                $proyek->request_persetujuan = null;

                $getNomorMatriks = $this->getNomorMatriksApproval($proyek->divisi_id, $proyek->departemen_id, "Rekomendasi");
                foreach ($getNomorMatriks as $target) {
                    $url = $request->schemeAndHttpHost() . "?nip=" . $target->Pegawai->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner?open=kt_modal_persetujuan_verifikasi_" . $proyek->kode_proyek;
                    $message = "Yth Bapak/Ibu " . $target->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan revisi verifikasi internal partner untuk proyek " . $proyek->Proyek->nama_proyek . " untuk permohonan pengajuan assessment partner.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                    $sendEmailUser = sendNotifEmail($target->Pegawai, "Pemberitahuan Revisi Persetujuan Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)", nl2br($message), $this->isnomorTargetActive);
                    if (!$sendEmailUser) {
                        return redirect()->back();
                    }
                }

                $proyek->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * ? Tampilan QR Code
     */
    public function viewProyekQRSelected(Request $request, $kode_proyek, $nip)
    {
        try {
            $ProyekNotaQrSelected = VerifikasiInternalPersetujuanPartner::where('kode_proyek', $kode_proyek)->first();
            $proyekSelected = $ProyekNotaQrSelected->Proyek;

            $kategori = $request->get("kategori");

            switch ($kategori) {
                case 'pengajuan':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->pengusul_approved));
                    break;
                case 'rekomendasi':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->rekomendasi_approved));
                    break;
                case 'persetujuan':
                    $collectPenandatangan = collect(json_decode($ProyekNotaQrSelected->persetujuan_approved));
                    break;

                default:
                    $collectPenandatangan = null;
                    break;
            }


            $userSelected = User::where('nip', $nip)->first();

            $penandatanganSelected = $collectPenandatangan->where('nip', $userSelected->nip)->first();
            if (!empty($penandatanganSelected)) {
                $penandatanganSelected->nip = $userSelected->name ?? null;

                $penandatanganSelected->jabatan = $userSelected->Pegawai?->Jabatan?->nama_jabatan ?? null;

                $penandatanganSelected->tanggal = Carbon::create($penandatanganSelected->tanggal)->translatedFormat('d F Y, H:i:s');
            }

            return view('29_View_TTD_Verifikasi', ["penandatanganSelected" => $penandatanganSelected, "dataNotaRekomendasi" => $ProyekNotaQrSelected, "proyek" => $proyekSelected]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    /**
     * Untuk cek apakah yang melakukan approval sesuai dengan matriks atau bukan
     * 
     * @param \App\Models\User $user User yang melakukan approval
     * @param \App\Models\Proyek $proyek Proyek yang diajukan
     * @param string $kategori Kategori user di matriks sebagai apa
     * @return bool Hasilnya harus true 
     */
    private function checkValidateUserMatriks(User $user, Proyek $proyek, $kategori)
    {
        try {
            $matriksSelected = MatriksApprovalPersetujuanPartner::where('nama_pegawai', $user->nip)
                ?->where("divisi_id", $proyek->UnitKerja?->Divisi?->id_divisi)
                ?->where("departemen_code", $proyek->departemen_proyek)
                ?->where("kategori", $kategori)
                ?->first();

            if (empty($matriksSelected)) {
                return false;
            }

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Untuk cek apakah matriks di kategori tersebut sudah semua melakukan approval atau belum
     * 
     * @param int $divisi_id Id Divisi | Proyek => Unit Kerja => Divisi => id_divisi
     * @param string $departemen_code Departemen Code | Proyek => departemen_proyek
     * @param Collection $approved_data Collect Data yg melakukan Approval
     * @param string $kategori Kategori Approval
     * @return bool
     */
    private function checkMatriksApproval($divisi_id, $departemen_code, $approved_data, $kategori): bool
    {
        try {
            return MatriksApprovalPersetujuanPartner::where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("kategori", "=", $kategori)->count() == $approved_data->count();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Untuk Mendapatkan List Matriks Approval
     * 
     * @param int $divisi_id Id Divisi | Proyek => Unit Kerja => Divisi => id_divisi
     * @param string $departemen_code Departemen Code | Proyek => departemen_proyek
     * @param Collection $approved_data Collect Data yg melakukan Approval
     * @param string $kategori Kategori Approval
     * @param int $urutan Urutan matriks
     * @return \App\Models\MatriksApprovalPersetujuanPartner
     */
    private function getNomorMatriksApproval($divisi_id, $departemen_code, $kategori, $urutan = null)
    {
        try {
            $matriksSelected = MatriksApprovalPersetujuanPartner::where("divisi_id", "=", $divisi_id)->where('departemen_code', $departemen_code)->where("kategori", "=", $kategori)->get();

            if ($matriksSelected->isEmpty()) {
                if ($kategori == "Pengajuan") {
                    return response()->json([
                        "Success" => false,
                        "Message" => "Matriks $kategori tidak ditemukan. Mohon Hubungi Admin!"
                    ]);
                } else {
                    Alert::error("Error", "Matriks $kategori tidak ditemukan. Mohon Hubungi Admin!");
                    return redirect()->back();
                }
            }

            if (!empty($urutan)) {
                return $matriksSelected->where("urutan", $urutan);
            }

            return $matriksSelected;
        } catch (\Throwable $th) {
            if ($kategori == "Pengajuan") {
                return response()->json([
                    "Success" => false,
                    "Message" => $th->getMessage()
                ]);
            } else {
                throw $th;
            }
        }
    }

    /**
     * GENERATE FILE FINAL YG SUDAH DI TANDA TANGAN
     */
    private function generateFinalDokumen($request, $proyek)
    {
        try {
            $verifikasiPartner = $proyek->VerifikasiInternalPersetujuanPartner;

            $pathQRPengajuan = collect([]);
            $pathQRRekomendasi = collect([]);
            $pathQRPersetujuan = collect([]);

            $approvedPengajuan = collect(json_decode($verifikasiPartner->pengusul_approved));
            $approvedRekomendasi = collect(json_decode($verifikasiPartner->rekomendasi_approved));
            $approvedPersetujuan = collect(json_decode($verifikasiPartner->persetujuan_approved));
            $approvedPengajuan->each(function ($item) use ($request, $proyek, $pathQRPengajuan) {
                $qrNamePengajuan = date('dmYHis_') . $item->nip . '_signed_Pengajuan-Verif-Internal_Partner.png';
                $qrPathPengajuan = public_path("template-ttd/verif-internal-persetujuan-partner/" . $qrNamePengajuan);
                $urlPengajuan = $request->schemeAndHttpHost() . "?nip=" . $item->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner/" . $proyek->kode_proyek . "/" . $item->nip . "/view-qr?kategori=pengajuan";
                generateQrCode($qrNamePengajuan, $qrPathPengajuan, $urlPengajuan);
                $pathQRPengajuan->push(collect([
                    "user" => Pegawai::where("nip", $item->nip)->first()->nama_pegawai ?? "NN",
                    "fileName" => $qrNamePengajuan,
                    "jabatan" => Pegawai::where("nip", $item->nip)->first()?->Jabatan->nama_jabatan ?? "NN",
                ]));
            });

            $approvedRekomendasi->each(function ($item) use ($request, $proyek, $pathQRRekomendasi) {
                $qrNameRekomendasi = date('dmYHis_') . $item->nip . '_signed_Rekomendasi-verif-internal_Partner.png';
                $qrPathRekomendasi = public_path("template-ttd/verif-internal-persetujuan-partner/" . $qrNameRekomendasi);
                $urlRekomendasi = $request->schemeAndHttpHost() . "?nip=" . $item->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner/" . $proyek->kode_proyek . "/" . $item->nip . "/view-qr?kategori=rekomendasi";
                generateQrCode($qrNameRekomendasi, $qrPathRekomendasi, $urlRekomendasi);
                $pathQRRekomendasi->push(collect([
                    "user" => Pegawai::where("nip", $item->nip)->first()->nama_pegawai ?? "NN",
                    "fileName" => $qrNameRekomendasi,
                    "jabatan" => Pegawai::where("nip", $item->nip)->first()?->Jabatan->nama_jabatan ?? "NN",
                ]));
            });

            $approvedPersetujuan->each(function ($item) use ($request, $proyek, $pathQRPersetujuan) {
                $qrNamePersetujuan = date('dmYHis_') . $item->nip . '_signed_Persetujuan-verif-internal_Partner.png';
                $qrPathPersetujuan = public_path("template-ttd/verif-internal-persetujuan-partner/" . $qrNamePersetujuan);
                $urlPersetujuan = $request->schemeAndHttpHost() . "?nip=" . $item->nip . "&redirectTo=/verifikasi-internal-persetujuan-partner/" . $proyek->kode_proyek . "/" . $item->nip . "/view-qr?kategori=persetujuan";
                generateQrCode($qrNamePersetujuan, $qrPathPersetujuan, $urlPersetujuan);
                $pathQRPersetujuan->push(collect([
                    "user" => Pegawai::where("nip", $item->nip)->first()->nama_pegawai ?? "NN",
                    "fileName" => $qrNamePersetujuan,
                    "jabatan" => Pegawai::where("nip", $item->nip)->first()?->Jabatan->nama_jabatan ?? "NN",
                ]));
            });

            $pdf = Pdf::loadView('GenerateFile.generatePermohonanKSO', ["proyek" => $proyek, "pathQRPengajuan" => $pathQRPengajuan, "pathQRRekomendasi" => $pathQRRekomendasi, "pathQRPersetujuan" => $pathQRPersetujuan]);

            if (!File::isDirectory(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/'))) {
                File::makeDirectory(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/'));
            }

            $namaFile = date("dmYHis_") . $proyek->kode_proyek . "_Dokumen_Verifikasi_Internal_Penentuan_KSO_Final.pdf";
            $pdf->save(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/' . $namaFile));

            $verifikasiPartner->nama_dokumen = $namaFile;
            $verifikasiPartner->save();
            return $namaFile;
        } catch (\Throwable $th) {
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }

    private function mergeFileFinalDokumen($namaFile, $proyekVerifikasi)
    {
        $proyek = $proyekVerifikasi->Proyek;

        $newName = date('dMYHis_') . "Dokumen_Persetujuan_Partner_KSO_" . $proyek->nama_proyek . ".pdf";
        $pdfMerge = new PdfMerge();

        $pdfMerge->add(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/' . $namaFile));

        $proyekAssessment = $proyek->PorsiJO->where("is_greenlane", false);

        if (!empty($proyekAssessment)) {
            foreach ($proyekAssessment as $partner) {
                if (!empty($partner->file_assessment_merge)) {
                    $pdfMerge->add(public_path('file-nota-rekomendasi-2/file-kriteria-partner/' . $partner->file_assessment_merge));
                }

                if (!empty($partner->file_kelengkapan_merge)) {
                    $pdfMerge->add(public_path('file-kelengkapan-partner/' . $partner->file_kelengkapan_merge));
                }
            }
        }

        $pdfMerge->merge(public_path('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner/' . $newName));

        $proyekVerifikasi->nama_dokumen = $newName;
        $proyekVerifikasi->save();
    }
}
