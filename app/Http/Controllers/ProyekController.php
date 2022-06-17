<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Sbu;
use App\Models\Proyek;
use App\Models\Company;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
{
    public function view() 
    {
        return view ('3_Proyek', ['proyeks' => Proyek::all(), 'sumberdanas' => SumberDana::all(), 'unitkerjas' => UnitKerja::all()]);
    }


    public function new()
    {
        return view('Proyek/newProyek');   
    }


    public function save(Request $request, Proyek $newProyek)
    {
        $dataProyek = $request->all(); 
        $proyekAll = Proyek::all();
        $unitKerja = UnitKerja::where('divcode', "=", $dataProyek["unit-kerja"])->get()->first();

        $messages = [
            "required" => "This field is required",
            // "numeric" => "This field must be numeric only",
            // "string" => "This field must be alphabet only",
            // "date" => "This field must be date format only",
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
            $validation->validate();
            $request->old("nama-proyek");
            $request->old("unit-kerja");
            $request->old("jenis-proyek");
            $request->old("tipe-proyek");
            $request->old("nilai-rkap");
            $request->old("sumber-dana");
            $request->old("tahun-perolehan");
            $request->old("bulan-pelaksanaan");
            return redirect()->with("failed", "Proyek gagal dibuat, Periksa kembali !");
            // dd($validation->errors());
        }
        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        $newProyek->jenis_proyek= $dataProyek["jenis-proyek"];
        $newProyek->tipe_proyek= $dataProyek["tipe-proyek"];
        $newProyek->nilai_rkap = $dataProyek["nilai-rkap"];
        $newProyek->sumber_dana= $dataProyek["sumber-dana"];
        $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        $newProyek->bulan_pelaksanaan= $dataProyek["bulan-pelaksanaan"];
        $newProyek->stage= "1";
        
        $newProyek->dop= $unitKerja->dop;
        $newProyek->company= $unitKerja->company;

        //begin::Generate Kode Proyek
            if ($proyekAll->last() == null){
                $no_urut = 1;
            } else {
                $no_urut = count($proyekAll)+1;
            }
            
            $unit_kerja = $dataProyek["unit-kerja"];
            $jenis_proyek = $dataProyek["jenis-proyek"];
            $tipe_proyek = $dataProyek["tipe-proyek"];
            $tahun = $dataProyek["tahun-perolehan"];
            
                // Kondisi kalau tahun lebih besar dari 2021 maka O Selain itu A
                $kode_tahun = $tahun == 2021 ? "A" : "O";
                
                // Untuk membuat 3 digit nomor urut terakhir
                $no_urut = str_pad(strval($no_urut),3,0, STR_PAD_LEFT);
                
                // Menggabungkan semua kode beserta nomor urut
                $kode_proyek = $unit_kerja . $jenis_proyek . $tipe_proyek . $kode_tahun . $no_urut;

                $newProyek->kode_proyek = $kode_proyek;
        //end::Generate Kode Proyek
        
        if ($newProyek->save()) {
            return redirect("/project")->with("success", ($dataProyek["nama-proyek"].", Berhasil dibuat"));
        }
    }
    
    
    public function  edit($kode_proyek)
    {
        $proyek = Proyek::find($kode_proyek);
        // dd($proyek); //tes log hasil 
        return view('Proyek/viewProyek', 
        ["proyek" => $proyek, "proyeks" => Proyek::all()], [
        'companies' => Company::all(),
        'sumberdanas' => SumberDana::all(),
        'dops' => Dop::all(),
        'sbus' => Sbu::all(),
        'unitkerjas' => UnitKerja::all()]
        );
    }

    public function update(Request $request, Proyek $newProyek)
    {
        $dataProyek = $request->all(); 
        // dd($request); //console log hasil $dataProyek
        $newProyek=Proyek::find($dataProyek["id"]);
        // $allProyek = Proyek::all();
        
        // form PASAR DINI
        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        // $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        // $newProyek->kode_proyek = $dataProyek["kode-proyek"];
        // $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        // $newProyek->sumber_dana = $dataProyek["sumber-dana"];
        // $newProyek->jenis_proyek= $dataProyek["jenis-proyek"];   
        // $newProyek->tipe_proyek= $dataProyek["tipe-proyek"];
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
        
        
        if ($newProyek->save()) {
            return redirect()->back()->with("success", "Success,");
        }
    }
    
    public function delete($kode_proyek)
    {
        $kode_proyek = Proyek::find($kode_proyek)->delete();
        // dd($proyek); //tes log hasil 
        return redirect("/project")->with("success", "Proyek Berhasil Dihapus");;
    }

}