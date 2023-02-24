<?php

namespace App\Http\Controllers;

use App\Models\MatriksApprovalRekomendasi;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RekomendasiController extends Controller
{
    public function index(Request $request){
        $all_super_user_counter = MatriksApprovalRekomendasi::all()->filter(function($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        // dd($all_super_user_counter);
        $all_super_user_counter = $all_super_user_counter->groupBy("Pegawai.nama_pegawai")->count();
        // $all_super_user_counter = 1;
        $rekomendasi_open = $request->query("open") ?? "";
        // Begin Prosess Approval
        if(!empty($request->setuju)) {
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
            $is_user_id_exist = $data->filter(function($d) {
                if(is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            // dd($data, $check_user_approval_counter);
            if($check_user_approval_counter) {
                $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;
                $hasil_assessment = collect(performAssessment($proyek->proyekBerjalan->Customer, $proyek));
                createWordPengajuan($proyek, $hasil_assessment, $is_proyek_mega);
                createWordRekomendasi($proyek, $hasil_assessment, $is_proyek_mega);
                // createWord($proyek, $hasil_assessment, $is_proyek_mega);
                $proyek->review_assessment = true;
                $proyek->is_request_rekomendasi = false;
            }
            $proyek->approved_rekomendasi = $data->toJson();
            if($proyek->save()) {
                Alert::html("Success", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disetujui", "success");
                return redirect()->back();
            }
            // if(!$is_user_id_exist) {
            // }
            Alert::html("Failed", "Pengajuan Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui", "error");
            return redirect()->back();
        } else if(!empty($request->tolak)) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            // $proyek->is_request_rekomendasi = true;
            $data = collect(json_decode($proyek->approved_rekomendasi));
            // dd($data);
            $is_user_id_exist = $data->filter(function($d) {
                if(is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            $check_user_approval_counter = is_array(collect($data->first())->values()->first()) ? collect($data->first())->values()->count() == $all_super_user_counter : $data->count() == $all_super_user_counter;
            $data = $data->mergeRecursive(
                [
                    [
                        "user_id" => Auth::user()->id,
                        "status" => "rejected",
                        "tanggal" => \Carbon\Carbon::now(),
                    ]
                ]
            );
            if($check_user_approval_counter) {
                $proyek->is_recommended = false;
                $proyek->is_request_rekomendasi = false;
            }
            $proyek->approved_rekomendasi = $data->toJson();
            if($proyek->save()) {
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        } else if(!empty($request["input-rekomendasi-with-note"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            $data = $request->all();
            // dd($data);
            // $proyek->is_request_rekomendasi = true;
            $is_proyek_mega = str_contains($proyek->klasifikasi_pasdin, "Mega") ? true : false;
            $is_proyek_besar = str_contains($proyek->klasifikasi_pasdin, "Besar") ? true : false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            
            if(isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Direkomendasikan dengan catatan") {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                $proyek->is_recommended_with_note = true;
                $proyek->is_recommended = true;
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi dengan catatan", "success");
            } else if(isset($data["kategori-rekomendasi"]) && $data["kategori-rekomendasi"] == "Rekomendasi Ditolak") {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                $proyek->is_recommended = false;
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi", "success");
            } else if(isset($data["kategori-rekomendasi"])) {
                $proyek->is_recommended = true;
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> disetujui oleh tim Rekomendasi", "success");
            }

            $proyek->recommended_with_note = $data["note-rekomendasi"] ?? null;
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_besar, $is_proyek_mega);
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        } else if(!empty($request["penyusun-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            
            $proyek->is_penyusun_approved = true;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if(!empty($request["penyusun-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            
            $proyek->is_penyusun_approved = false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Penyusun melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if(!empty($request["rekomendasi-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            
            $proyek->is_recommended = true;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if(!empty($request["rekomendasi-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            
            $proyek->is_recommended = false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Rekomendasi melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();

        } else if(!empty($request["persetujuan-setujui"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            
            $proyek->is_disetujui = true;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        } else if(!empty($request["persetujuan-tolak"])) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            
            $proyek->is_disetujui = false;
            // $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                // createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> telah ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak oleh tim Persetujuan melalui <b>Tahap Nota Rekomendasi 1</b>", "error");
            return redirect()->back();
        }
        // End Prosess Approval

        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
        $unit_kerjas = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        $matriks_user = Auth::user()->Pegawai->MatriksApproval;
        // dd($matriks_user);
        if($is_super_user) {
            $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function($p) {
                return ($p->is_request_rekomendasi || !empty($p->approved_rekomendasi)) && !$p->review_assessment;
            });
            $proyeks_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function($p) use($all_super_user_counter) {
                // $approved_rekomendasi = collect(json_decode($p->approved_rekomendasi));
                return $p->review_assessment && empty($p->is_recommended);
            });
            $proyeks_persetujuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->get()->filter(function($p) {
                return $p->is_recommended;
            });
        } else {
            if($matriks_user->contains("kategori", "Pengajuan")) {
                $proyeks_pengajuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function($p) use($matriks_user) {
                    return ($p->is_request_rekomendasi || $p->review_assessment || !empty($p->hasil_assessment) || !empty($p->approved_rekomendasi)) && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                });
            } else {
                $proyeks_pengajuan = [];
            }
            
            if($matriks_user->contains("kategori", "Verifikasi")) {
                $proyeks_rekomendasi = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function($p) use($matriks_user) {
                    return $p->review_assessment && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                });
            
            } else {
                $proyeks_rekomendasi = [];
                
            }

            if($matriks_user->contains("kategori", "Persetujuan") || $matriks_user->contains("kategori", "Rekomendasi") || $matriks_user->contains("kategori", "Penyusun")) {
                $proyeks_persetujuan = Proyek::whereIn("unit_kerja", $unit_kerjas)->where("stage", "=", 1)->get()->filter(function($p) use($matriks_user) {
                    return $p->review_assessment && $matriks_user->where("klasifikasi_proyek", $p->klasifikasi_pasdin)->count() > 0;
                });
            } else {
                $proyeks_persetujuan = [];

            }
        }
        if(!empty($rekomendasi_open)) {
            return view('13_Rekomendasi', compact(['proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter", "rekomendasi_open", "proyeks_rekomendasi", "is_user_exist_in_matriks_approval", "matriks_user"]));
        }
        return view('13_Rekomendasi', compact(['proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter", "proyeks_rekomendasi", "is_user_exist_in_matriks_approval", "matriks_user"]));
    }
}
