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
        $all_super_user_counter = User::all()->filter(function($u) {
            return str_contains($u->name, "PIC") || $u->check_administrator;
        })->count() - 2;
        // Begin Prosess Approval
        if(!empty($request->setuju)) {
            $proyek = Proyek::find($request->get("kode-proyek"));
            // $proyek->is_request_rekomendasi = false;
            $data = collect(json_decode($proyek->approved_rekomendasi));
            $is_user_id_exist = $data->filter(function($d) {
                if(is_array($d)) {
                    return in_array(Auth::user()->id, $d);
                }
                return $d->user_id == Auth::user()->id;
            })->count() > 0;
            $check_user_approval_counter = is_array(collect($data->first())->values()->first()) ? collect($data->first())->values()->count() == $all_super_user_counter : $data->count() == $all_super_user_counter;
            $data = $data->mergeRecursive([
                [
                    "user_id" => Auth::user()->id,
                    "status" => "approved",
                ]
            ]);
            if(!$is_user_id_exist) {
                if($check_user_approval_counter) {
                    $proyek->is_request_rekomendasi = false;
                }
                $proyek->approved_rekomendasi = $data->toJson();
                if($proyek->save()) {
                    Alert::html("Success", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> berhasil disetujui", "success");
                    return redirect()->back();
                }
            }
            Alert::html("Failed", "Rekomendasi dengan nama proyek <b>$proyek->nama_proyek</b> gagal disetujui", "error");
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
        }
        // End Prosess Approval

        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
        $unit_kerjas = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
        
        if($is_super_user) {
            $proyeks_pengajuan = Proyek::where("is_request_rekomendasi", "=", true)->where("stage", "=", 1)->get();
            $proyeks_persetujuan = Proyek::all()->filter(function($p) {
                return $p->is_request_rekomendasi || !is_null($p->approved_rekomendasi);
            });
        } else {
            $proyeks_pengajuan = Proyek::where("stage", "=", 1)->whereIn('unit_kerja', $unit_kerjas->toArray())->get()->filter(function($p) {
                return $p->is_request_rekomendasi || !is_null($p->approved_rekomendasi);
            });
            $proyeks_persetujuan = Proyek::where("approved_rekomendasi", "=", null)->get();
        }

        return view('13_Rekomendasi', compact(['proyeks_pengajuan', "proyeks_persetujuan", "all_super_user_counter"]));
    }
}
