<?php

namespace App\Http\Controllers;

use App\Models\OtomasiApproval;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OtomasiApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData/OtomasiApproval', ["data" => OtomasiApproval::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $otomasiApproval = new OtomasiApproval();
        $otomasiApproval->feature = $data["feature"];
        $otomasiApproval->is_active = true;

        if ($otomasiApproval->save()) {
            Alert::success("Success", "Otomasi Approval Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Otomasi Approval Gagal Ditambahkan");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OtomasiApproval  $otomasiApproval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $otomasiApproval = OtomasiApproval::find($id);

        // dd($data, $otomasiApproval);

        if (empty($otomasiApproval)) {
            Alert::success("Error", "Otomasi Approval Tidak Ditemukan");
            return redirect()->back();
        }

        $otomasiApproval->feature = $data["feature"];

        $otomasiApproval->is_active = isset($data["is_active"]) ? true : false;

        if ($otomasiApproval->save()) {
            Alert::success("Success", "Otomasi Approval Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::success("Error", "Otomasi Approval Gagal Ditambahkan");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OtomasiApproval  $otomasiApproval
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtomasiApproval $otomasiApproval, string $id)
    {
        $isOtomasiApproval = $otomasiApproval->find($id);
        if ($isOtomasiApproval) {
            $isOtomasiApproval->delete();
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }
        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    }
}
