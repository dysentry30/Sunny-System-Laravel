<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RekomendasiController extends Controller
{
    public function index(Request $request){
        // $all_super_user_counter = User::all()->filter(function($u) {
        //     return str_contains($u->name, "PIC") || $u->check_administrator;
        // })->count() - 2;
        $all_super_user_counter = 2;
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
                    ]
                ]
            );
            if($check_user_approval_counter) {
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
            $is_proyek_mega = (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega")) ? true : false;
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            
            $proyek->is_recommended = true;
            $proyek->recommended_with_note = $data["note-rekomendasi"];
            if($proyek->save()) {
                createWordPersetujuan($proyek, $hasil_assessment, $is_proyek_mega);
                Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> ditolak", "success");
                return redirect()->back();
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal ditolak", "error");
            return redirect()->back();
        }
        // End Prosess Approval

        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
        $unit_kerjas = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        // if($is_super_user) {
        //     $proyeks_pengajuan = Proyek::where("stage", "=", 1)->get()->filter(function($p) {
        //         return $p->is_request_rekomendasi || !empty($p->approved_rekomendasi) && !$p->review_assessment;
        //     });
        //     $proyeks_rekomendasi = Proyek::where("stage", "=", 1)->get()->filter(function($p) use($all_super_user_counter) {
        //         $approved_rekomendasi = collect(json_decode($p->approved_rekomendasi));
        //         return !empty($approved_rekomendasi) && $approved_rekomendasi->every("status", "=", "approved") && $approved_rekomendasi->count() == $all_super_user_counter && $p->review_assessment;
        //     });
        //     // $proyeks_persetujuan = Proyek::all()->filter(function($p) {
        //     //     return $p->is_request_rekomendasi || !is_null($p->approved_rekomendasi);
        //     // });
        //     $proyeks_persetujuan = [];
        // } else {
        //     $proyeks_pengajuan = Proyek::where("stage", "=", 1)->whereIn('unit_kerja', $unit_kerjas->toArray())->get()->filter(function($p) {
        //         return $p->is_request_rekomendasi || !is_null($p->approved_rekomendasi);
        //     });
        //     $proyeks_rekomendasi = Proyek::where("stage", "=", 1)->whereIn('unit_kerja', $unit_kerjas->toArray())->get()->filter(function($p) use($all_super_user_counter) {
        //         $approved_rekomendasi = collect(json_decode($p->approved_rekomendasi));
        //         return !empty($approved_rekomendasi) && $approved_rekomendasi->every("status", "=", "approved") && $approved_rekomendasi->count();
        //     });
        //     $proyeks_persetujuan = Proyek::where("approved_rekomendasi", "=", null)->get();
        // }
        $proyeks_pengajuan = Proyek::where("stage", "=", 1)->get()->filter(function($p) {
            return ($p->is_request_rekomendasi || !empty($p->approved_rekomendasi)) && !$p->review_assessment;
        });
        $proyeks_rekomendasi = Proyek::where("stage", "=", 1)->get()->filter(function($p) use($all_super_user_counter) {
            $approved_rekomendasi = collect(json_decode($p->approved_rekomendasi));
            return !empty($approved_rekomendasi) && $approved_rekomendasi->every("status", "=", "approved") && $approved_rekomendasi->count() == $all_super_user_counter && $p->review_assessment && empty($p->is_recommended);
        });
        $proyeks_persetujuan = Proyek::all()->filter(function($p) {
            return $p->is_recommended;
        });
        // $proyeks_persetujuan = [];
        if(!empty($rekomendasi_open)) {
            return view('13_Rekomendasi', compact(['proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter", "rekomendasi_open", "proyeks_rekomendasi"]));
        }
        return view('13_Rekomendasi', compact(['proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter", "proyeks_rekomendasi"]));
    }
}
