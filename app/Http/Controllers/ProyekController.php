<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Sbu;
use App\Models\Proyek;
use App\Models\Company;
use App\Models\Customer;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use App\Models\HistoryForecast;
use App\Models\ProyekBerjalans;
use App\Models\ClaimManagements;
use Illuminate\support\Facades\DB;
use App\Models\ContractManagements;
use App\Models\TeamProyek;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Google\Service\FactCheckTools\Resource\Claims;

class ProyekController extends Controller
{
    public function view(Request $request)
    {
        $cari = $request->query("cari");
        $column = $request->get("column");
        $filter = $request->query("filter");
        // dd($column);
        $sumberdanas = SumberDana::all();
        $unitkerjas = UnitKerja::get();
        
        // Begin::FILTER
        if (!empty($column)) {
            // $proyeks = Proyek::sortable()->where($column, '=', $filter)->get();
            $proyeks = Proyek::sortable()->where($column, 'like', '%'.$filter.'%')->get();
        }else{
            if(!empty($cari)){
                $proyeks = Proyek::sortable()->where('nama_proyek', 'like', '%'.$cari.'%')->orWhere('kode_proyek', 'like', '%'.$cari.'%')->orWhere('tahun_perolehan', 'like', '%'.$cari.'%')->get();
            }else{
                $proyeks = Proyek::sortable()->get();
                // dd($proyeks);
            }
        }
                
        // $proyeks = Proyek::sortable()->get();

        return view('3_Proyek', compact(["proyeks", "cari", "column", "filter", "sumberdanas", "unitkerjas"]));
    }


    // public function new()
    // {
    //     return view('Proyek/newProyek');   
    // }


    public function save(Request $request, Proyek $newProyek)
    {
        $dataProyek = $request->all();
        $proyekAll = Proyek::all();
        $unitKerja = UnitKerja::where('divcode', "=", $dataProyek["unit-kerja"])->get()->first();

        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nama-proyek" => "required",
            "unit-kerja" => "required",
            "jenis-proyek" => "required",
            "tipe-proyek" => "required",
            "nilai-rkap" => "required",
            "sumber-dana" => "required",
            "tahun-perolehan" => "required",
            "bulan-pelaksanaan" => "required",
        ];
        $validation = Validator::make($dataProyek, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Proyek Gagal Dibuat, Periksa Kembali !");
            $request->old("nama-proyek");
            $request->old("unit-kerja");
            $request->old("jenis-proyek");
            $request->old("tipe-proyek");
            $request->old("nilai-rkap");
            $request->old("sumber-dana");
            $request->old("tahun-perolehan");
            $request->old("bulan-pelaksanaan");
            Session::flash('failed', 'Proyek gagal dibuat, Periksa kembali button "NEW" !');
        }
        $validation->validate();
        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        $newProyek->jenis_proyek = $dataProyek["jenis-proyek"];
        $newProyek->tipe_proyek = $dataProyek["tipe-proyek"];
        $newProyek->nilai_rkap = $dataProyek["nilai-rkap"];
        $newProyek->sumber_dana = $dataProyek["sumber-dana"];
        $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        $newProyek->bulan_pelaksanaan = $dataProyek["bulan-pelaksanaan"];
        $newProyek->stage = "1";

        $newProyek->dop = $unitKerja->dop;
        $newProyek->company = $unitKerja->company;

        //begin::Generate Kode Proyek
        if ($proyekAll->last() == null) {
            $no_urut = 1;
        } else {
            // $no_urut = count($proyekAll)+1;
            $no_urut = (int) preg_replace("/[^0-9]/i", "", $proyekAll->last()->kode_proyek) + 1;
        }

        // dd($no_urut);

        $unit_kerja = $dataProyek["unit-kerja"];
        $jenis_proyek = $dataProyek["jenis-proyek"];
        $tipe_proyek = $dataProyek["tipe-proyek"];
        $tahun = $dataProyek["tahun-perolehan"];

        // Kondisi kalau tahun lebih besar dari 2021 maka O Selain itu A
        $kode_tahun = $tahun == 2021 ? "A" : "O";

        // Untuk membuat 3 digit nomor urut terakhir
        $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);

        // Menggabungkan semua kode beserta nomor urut
        $kode_proyek = $unit_kerja . $jenis_proyek . $tipe_proyek . $kode_tahun . $no_urut;

        $newProyek->kode_proyek = $kode_proyek;
        //end::Generate Kode Proyek

        Alert::success('Success', $dataProyek["nama-proyek"] . ", Berhasil Ditambahkan");

        if ($newProyek->save()) {
            return redirect("/proyek/view/$kode_proyek")->with("success", ($dataProyek["nama-proyek"] . ", Berhasil dibuat"));
        }
        // return redirect("/proyek")->with("failed", ($dataProyek["nama-proyek"].", Gagal Dibuat"));
    }


    public function  edit($kode_proyek)
    {
        $proyek = Proyek::find($kode_proyek);
        $historyForecast = HistoryForecast::where("periode_prognosa", "=", date("m"))->where("kode_proyek", "=", $kode_proyek)->get();
        $teamProyek = TeamProyek::where("kode_proyek", "=", $kode_proyek)->get();

        // dd($kode_proyek);
        // dd($proyek); //tes log hasil 
        return view(
            'Proyek/viewProyek',
            ["proyek" => $proyek, "proyeks" => Proyek::all()],
            [
                'companies' => Company::all(),
                'sumberdanas' => SumberDana::all(),
                'dops' => Dop::all(),
                'sbus' => Sbu::all(),
                'unitkerjas' => UnitKerja::all(),
                'customers' => Customer::all(),
                'users' => User::all(),
                'teams' => $teamProyek,
                'proyekberjalans' => ProyekBerjalans::where("kode_proyek", "=", $kode_proyek)->get()->first(),
                "historyForecast" => $historyForecast
            ]
        );
    }

    public function update(Request $request, Proyek $newProyek, ProyekBerjalans $customerHistory)
    {
        $dataProyek = $request->all();
        // dd($dataProyek); //console log hasil $dataProyek
        $newProyek = Proyek::find($dataProyek["kode-proyek"]);
        // $allProyek = Proyek::all();

        // form PASAR DINI
        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        // $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        // $newProyek->kode_proyek = $dataProyek["kode-proyek"];
        // $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        $newProyek->sumber_dana = $dataProyek["sumber-dana"];
        // $newProyek->jenis_proyek= $dataProyek["jenis-proyek"];   
        // $newProyek->tipe_proyek= $dataProyek["tipe-proyek"];

        $newProyek->pic = $dataProyek["pic"];
        $newProyek->bulan_pelaksanaan = $dataProyek["bulan-pelaksanaan"];
        $newProyek->nilai_rkap = $dataProyek["nilai-rkap"];
        $newProyek->nilai_valas_review = $dataProyek["nilai-valas-review"];
        $newProyek->mata_uang_review = $dataProyek["mata-uang-review"];
        $newProyek->kurs_review = $dataProyek["kurs-review"];
        $newProyek->bulan_review = $dataProyek["bulan-pelaksanaan-review"];
        $newProyek->nilaiok_review = $dataProyek["nilaiok-review"];
        $newProyek->nilai_valas_awal = $dataProyek["nilai-valas-awal"];
        $newProyek->mata_uang_awal = $dataProyek["mata-uang-awal"];
        $newProyek->kurs_awal = $dataProyek["kurs-awal"];
        $newProyek->bulan_awal = $dataProyek["bulan-pelaksanaan-awal"];
        $newProyek->nilaiok_awal = $dataProyek["nilaiok-awal"];
        $newProyek->laporan_kualitatif_pasdin = $dataProyek["laporan-kualitatif-pasdin"];

        // form PASAR POTENSIAL
        $newProyek->negara = $dataProyek["negara"];
        $newProyek->sbu = $dataProyek["sbu"];
        $newProyek->provinsi = $dataProyek["provinsi"];
        $newProyek->klasifikasi = $dataProyek["klasifikasi"];
        $newProyek->status_pasar = $dataProyek["status-pasar"];
        $newProyek->sub_klasifikasi = $dataProyek["sub-klasifikasi"];
        // $newProyek->dop = $dataProyek["dop"];
        // $newProyek->company = $dataProyek["company"];
        $newProyek->laporan_kualitatif_paspot = $dataProyek["laporan-kualitatif-paspot"];

        // form PASAR PRAKUALIFIKASI
        $newProyek->jadwal_pq = $dataProyek["jadwal-pq"];
        $newProyek->jadwal_proyek = $dataProyek["jadwal-proyek"];
        $newProyek->hps_pagu = $dataProyek["hps-pagu"];
        $newProyek->porsi_jo = $dataProyek["porsi-jo"];
        $newProyek->ketua_tender = $dataProyek["ketua-tender"];
        // foreach($allProyek as $proyek) {
        //     if($proyek->ketua_tender == $dataProyek["ketua-tender"] && !($proyek->stage > 8)) {
        //         return redirect()->back()->with("failed", "Ketua Tender sudah terdaftar di proyek lain");
        //     }
        // }
        $newProyek->ketua_tender = $dataProyek["ketua-tender"];
        $newProyek->laporan_prakualifikasi = $dataProyek["laporan-prakualifikasi"];

        // form TENDER DIIKUTI
        $newProyek->jadwal_tender = $dataProyek["jadwal-tender"];
        $newProyek->lokasi_tender = $dataProyek["lokasi-tender"];
        $newProyek->penawaran_tender = $dataProyek["penawaran-tender"];
        $newProyek->hps_tender = $dataProyek["hps-tender"];
        $newProyek->laporan_tender = $dataProyek["laporan-tender"];

        // form PEROLEHAN
        $newProyek->biaya_praproyek = $dataProyek["biaya-praproyek"];
        $newProyek->penawaran_perolehan = $dataProyek["penawaran-perolehan"];
        $newProyek->hps_perolehan = $dataProyek["hps-perolehan"];
        $newProyek->oe_wika = $dataProyek["oe-wika"];
        $newProyek->peringkat_wika = $dataProyek["peringkat-wika"];
        $newProyek->laporan_perolehan = $dataProyek["laporan-perolehan"];

        // form MENANG
        $newProyek->aspek_pesaing = $dataProyek["aspek-pesaing"];
        $newProyek->aspek_non_pesaing = $dataProyek["aspek-non-pesaing"];
        $newProyek->saran_perbaikan = $dataProyek["saran-perbaikan"];

        // form TERKONTRAK
        $newProyek->nospk_external = $dataProyek["nospk-external"];
        $newProyek->jenis_proyek_terkontrak = $dataProyek["jenis-proyek-terkontrak"];
        $newProyek->tglspk_internal = $dataProyek["tglspk-internal"];
        $newProyek->porsijo_terkontrak = $dataProyek["porsijo-terkontrak"];
        $newProyek->tahun_ri_perolehan = $dataProyek["tahun-ri-perolehan"];
        $newProyek->nilaiok_terkontrak = $dataProyek["nilaiok-terkontrak"];
        $newProyek->bulan_ri_perolehan = $dataProyek["bulan-ri-perolehan"];
        $newProyek->matauang_terkontrak = $dataProyek["matauang-terkontrak"];
        $newProyek->nomor_terkontrak = $dataProyek["nomor-terkontrak"];
        $newProyek->kursreview_terkontrak = $dataProyek["kurs-review-terkontrak"];
        $newProyek->tanggal_terkontrak = $dataProyek["tanggal-terkontrak"];
        $newProyek->nilai_kontrak_keseluruhan = $dataProyek["nilai-kontrak-keseluruhan"];
        $newProyek->tanggal_mulai_terkontrak = $dataProyek["tanggal-mulai-kontrak"];
        $newProyek->nilai_wika_terkontrak = $dataProyek["nilai-wika-terkontrak"];
        $newProyek->tanggal_akhir_terkontrak = $dataProyek["tanggal-akhir-kontrak"];
        $newProyek->klasifikasi_terkontrak = $dataProyek["klasifikasi-terkontrak"];
        $newProyek->tanggal_selesai_terkontrak = $dataProyek["tanggal-selesai-kontrak"];
        $newProyek->jenis_terkontrak = $dataProyek["jenis-terkontrak"];

        $idCustomer = $dataProyek["customer"];

        // Form update Customer dan auto Proyek Berjalan
        // $newProyek->customer= $dataProyek["customer"];

        Alert::success('Success', "Edit Berhasil")->autoClose(3000);

        if ($idCustomer != null) {

            // $customer = Customer::where('name', "=", $dataProyek["customer"])->get()->first();
            // $customer = Customer::find($idCustomer);


            $customerHistory = ProyekBerjalans::where('kode_proyek', "=", $newProyek->kode_proyek)->get()->first();
            // dd($customerHistory);

            if ($customerHistory == null) {

                $customerHistory = new ProyekBerjalans();
                $customerHistory->id_customer = $idCustomer;
                $customerHistory->nama_proyek = $newProyek->nama_proyek;
                $customerHistory->kode_proyek = $newProyek->kode_proyek;
                $customerHistory->pic_proyek = $newProyek->ketua_tender;
                $customerHistory->unit_kerja = $newProyek->unit_kerja;
                $customerHistory->jenis_proyek = $newProyek->jenis_proyek;
                $customerHistory->nilaiok_proyek = $newProyek->nilai_rkap;
                $customerHistory->stage = $newProyek->stage;
            } else {
                $customerHistory->id_customer = $idCustomer;
            }

            $newProyek->save();
            $customerHistory->save();
            return redirect()->back()->with("success", "Success,");
        } else {
            $newProyek->save();
            return redirect()->back()->with("success", "Success,");
        }
    }

    public function delete($kode_proyek)
    {
        $deleteProyek = Proyek::find($kode_proyek);

        $proyekBerjalan = ProyekBerjalans::where('kode_proyek', "=", $deleteProyek->kode_proyek)->get()->first();
        $contractManagement = ContractManagements::where('project_id', "=", $deleteProyek->kode_proyek)->get()->first();
        $claimManagement = ClaimManagements::where('kode_proyek', "=", $deleteProyek->kode_proyek)->get();
        $claimManagement->each(function ($claim) {
            $claim->delete();
        });

        Alert::success('Delete', $deleteProyek->nama_proyek . ", Berhasil Dihapus");

        if ($proyekBerjalan == null && $contractManagement == null) {
            $deleteProyek->delete();
        } elseif ($proyekBerjalan == null) {
            $deleteProyek->delete();
            $contractManagement->delete();
        } elseif ($contractManagement ==  null) {
            $deleteProyek->delete();
            $proyekBerjalan->delete();
        } else {
            $deleteProyek->delete();
            $proyekBerjalan->delete();
            $contractManagement->delete();
        }

        // dd($proyekBerjalan); 
        // dd($deleteProyek->kode_proyek);


        return redirect("/proyek")->with("success", "Proyek Berhasil Dihapus");
    }

    public function assignTeam(Request $request, TeamProyek $newTeam, Proyek $proyek)
    {
        $assignTeam = $request->all();
        // $proyek=Proyek::find($proyek["kode-proyek"]);
        // dd($proyek);
        $newTeam->id_user = $assignTeam["nama-team"];
        $newTeam->kode_proyek = $assignTeam["assign-kode-proyek"];

        $newTeam->save();
        return redirect()->back();
    }


    public function stage(Request $request)
    {
        $kodeProyek = $request->kode_proyek;
        $proyekStage = Proyek::find($kodeProyek);
        if (!$request->is_ajax) {
            $data = $request->all();
            // Check kalo variable di bawah ini ada
            if (!empty($data["stage-menang"]) && $data["stage-menang"] == "Menang") {
                // dd($request->all());
                $request->stage = 6;
            } elseif (!empty($data["stage-kalah"]) && $data["stage-kalah"] == "Kalah") {
                $request->stage = 7;
            } elseif (!empty($data["stage-terkontrak"]) && $data["stage-terkontrak"] == "Terkontrak") {
                $request->stage = 8;
            } elseif (!empty($data["stage-terendah"]) && $data["stage-terendah"] == "Terendah") {
                $request->stage = 9;
            }
        }
        $proyekStage->stage = $request->stage;

        $teamProyek = TeamProyek::where('kode_proyek', "=", $proyekStage->kode_proyek)->get();
        if ($teamProyek != null) {
            $teamProyek->each(function ($stage) use ($proyekStage) {
                if ($proyekStage->stage > 8) {
                    $stage->proyek_selesai = true;
                    $stage->save();
                }
            });
        }

        $proyekBerjalans = ProyekBerjalans::where('kode_proyek', "=", $proyekStage->kode_proyek)->get()->first();
        if ($proyekBerjalans == null) {
            $proyekStage->save();
            if ($request->is_ajax) {
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }
            Alert::success("Success", "Stage berhasil diperbarui");
            return back();
        } else {
            $proyekBerjalans->stage = $request->stage;
            $proyekBerjalans->save();
            $proyekStage->save();
            if ($request->is_ajax) {
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }
            Alert::success("Success", "Stage berhasil diperbarui");
            return back();
        }
        Alert::error("Error", "Stage gagal diperbarui");
        return back();
    }
}
