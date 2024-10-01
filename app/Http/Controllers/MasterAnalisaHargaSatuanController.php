<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MasterSumberDaya;
use App\Models\AnalisaHargaSatuanDetail;
use App\Models\MasterAnalisaHargaSatuan;
use RealRashid\SweetAlert\Facades\Alert;

class MasterAnalisaHargaSatuanController extends Controller
{
    public function index()
    {
        $masterHargaSatuanAll = MasterAnalisaHargaSatuan::all();
        return view("MasterData.MasterAnalisaHargaSatuan", ['masterHargaSatuanAll' => $masterHargaSatuanAll]);
    }

    public function view(Request $request, MasterAnalisaHargaSatuan $masterAHS)
    {
        $masterSumberDaya = MasterSumberDaya::all();
        $masterSumberDayaDetail = AnalisaHargaSatuanDetail::where("kode_ahs", $masterAHS->kode_ahs)->get();
        return view('MasterData.MasterAnalisaHargaDetail', ['masterSumberDaya' => $masterSumberDaya, 'masterAHS' => $masterAHS, 'masterSumberDayaDetail' => $masterSumberDayaDetail]);
    }

    public function insert(Request $request)
    {
        $data = $request->all();

        $newMaster = new MasterAnalisaHargaSatuan();
        $newMaster->kode_ahs = $data["kode-ahs"];
        $newMaster->uraian = $data["uraian"];

        if ($newMaster->save()) {
            Alert::success("Success", "Data berhasil ditambahkan");
            return redirect()->back();
        }

        Alert::error("Error", "Data gagal ditambahkan");
        return redirect()->back();
    }

    public function insertDetail(Request $request, MasterAnalisaHargaSatuan $masterAHS)
    {
        $data = $request->all();
        $collectChecklist = $request->get("checklist-sumber-daya");
        $collectDataInsert = [];

        try {
            if (!empty($collectChecklist)) {
                foreach ($collectChecklist as $sumber_daya) {
                    $dataReal = [
                        "id" => Str::uuid()->toString(),
                        "kode_sumber_daya" => $sumber_daya,
                        "kode_ahs" => $masterAHS->kode_ahs,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    ];

                    array_push($collectDataInsert, $dataReal);
                }

                // dd($collectDataInsert);
                AnalisaHargaSatuanDetail::insert($collectDataInsert);
            }
            $masterAHS->kode_ahs = $data["kode-ahs"];
            $masterAHS->uraian = $data["uraian"];
            $masterAHS->save();

            Alert::success("Success", "Data berhasil diubah");
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            Alert::error("Error", "Terjadi Kesalahan. Hubungi Admin");
            return redirect()->back();
        }
    }
}
