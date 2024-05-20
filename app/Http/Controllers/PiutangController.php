<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PiutangController extends Controller
{
    /**
     * Displaying Piutang Home Page
     * @param Request $request
     * 
     * @return [type]
     */
    public function index(Request $request){
        $piutangs = Piutang::all();
        return view("/Piutang/piutang_new", compact(["piutangs"]));
    }

    public function save(Request $request, Piutang $piutang)
    {
        try {
            $data = $request->all();

            $rules = [
                'nama_pelanggan' => "required",
                'kode_proyek' => "required",
                'status' => "required",
            ];

            $validation = validateInput($data, $rules);

            if (!empty($validation)) {
                Alert::html("Error", "Pastikan field <b>$validation</b> terisi!", "error");
                return redirect()->back();
            }

            $piutang->customer_id = $data['nama_pelanggan'];
            $piutang->kode_proyek = $data['kode_proyek'];
            $piutang->kategori = $data['status'];
            $piutang->created_by = Auth::user()->nip;
            $piutang->updated_by = Auth::user()->nip;
            $piutang->save();

            Alert::success("Success", "Data Piutang Berhasil Dibuat!");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, Piutang $piutang)
    {
        try {
            $data = $request->all();

            $rules = [
                // 'nama_pelanggan' => "required",
                // 'kode_proyek' => "required",
                'status' => "required",
            ];

            $validation = validateInput($data, $rules);

            if (!empty($validation)) {
                Alert::html("Error", "Pastikan field <b>$validation</b> terisi!", "error");
                return redirect()->back();
            }

            if (empty($piutang)) {
                Alert::html("Error", "Data Piutang Tidak Ditemukan <br> Hubungi Admin!", "error");
                return redirect()->back();
            }

            $piutang->kategori = $data['status'];
            $piutang->updated_by = Auth::user()->nip;
            $piutang->save();

            Alert::success("Success", "Data Piutang Berhasil Diubah!");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request, Piutang $piutang)
    {
        try {
            $piutang->delete();
            Alert::success("Success", "Data Piutang Berhasil Dihapus!");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }

    }
}
