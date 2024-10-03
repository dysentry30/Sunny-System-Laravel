<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Proyek;
use App\Models\BoqDetail;
use App\Imports\BoqImport;
use Illuminate\Http\Request;
use App\Models\MasterSumberDaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AnalisaHargaSatuanDetail;
use App\Models\MasterAnalisaHargaSatuan;
use RealRashid\SweetAlert\Facades\Alert;

class EstimasiController extends Controller
{
    public function index(Request $request)
    {
        $proyeks = Proyek::where("dop", "!=", "EA")->where("tahun_perolehan", date("Y"))->where("tipe_proyek", "P")->where("stage",  3)->where("is_cancel", false)->where("is_tidak_lulus_pq", false)->get();
        return view("30_RAB_POC", ["proyeks" => $proyeks]);
    }

    public function view(Request $request, Proyek $proyek)
    {
        try {
            $masterAHS = MasterAnalisaHargaSatuan::all();
            $dataDetailBOQ = BoqDetail::where("kode_proyek", $proyek->kode_proyek)->orderBy("index")->get();

            if ($proyek->jenis_proyek == "J") {
                if ($proyek->PorsiJO->isNotEmpty()) {
                    $porsiJO = $proyek->PorsiJO->map(function ($item) {
                        return ["nama_partner" => $item->company_jo, "porsi_jo" => $item->porsi_jo];
                    });
                } else {
                    $porsiJO = collect([]);
                }
            } else {
                $porsiJO = collect([]);
            }

            $dataUmumField = [
                "KODE PROYEK" => $proyek->kode_proyek,
                "NAMA PROYEK" => $proyek->nama_proyek,
                "LOKASI PEKERJAAN" => $proyek->Provinsi->province_name ?? "",
                "TAHUN TENDER" => $proyek->tahun_perolehan ?? "",
                "TANGGAL AANWIJZING" => "",
                "TANGGAL SITE VISIT" => "",
                "TANGGAL PENGESAHAN RAB" => "",
                "TANGGAL PEMASUKAN TENDER" => !empty($proyek->jadwal_tender) ? Carbon::create($proyek->jadwal_tender)->translatedFormat("d F Y") : "",
                "OWNER" => $proyek->proyekBerjalan->customer->name ?? "",
                "KONSULTAN PERENCANA" => "",
                "KONSULTAN PENGAWAS" => "",
                "PAGU (Incl. PPN)" => "Rp." . number_format($proyek->hps_pagu, "0", ".", ","),
                "OWNER ESTIMATE/ HPS (Incl. PPN)" => "",
                "JAMINAN PENAWARAN" => "",
                "JAMINAN PELAKSANAAN" => "",
                "UANG MUKA" => $proyek->uang_muka . '%' ?? 0 . '%',
                "JANGKA WAKTU PELAKSANAAN" => $proyek->waktu_pelaksanaan . " Hari" ?? 0,
                "JANGKA WAKTU PEMELIHARAAN" => "",
                "CARA PEMBAYARAN" => $proyek->sistem_bayar ?? "",
                "BENTUK KONTRAK (D&B / DBO)" => "",
                "SIFAT KONTRAK (LS / UNIT PRICE)" => $proyek->jenis_terkontrak ?? "",
                "ESKALASI/ PENYESUAIAN HARGA" => "",
                "FAT / MOS" => "",
                "HARGA TIMPANG" => "",
                "DENDA" => "",
                "MITRA JO/ KSO" => $porsiJO->toArray(),
                "PORSI KSO WIKA" => $proyek->porsi_jo . '%',
                "LABA AHS EKSTERNAL (%)" => "",
                "OVERHEAD AHS EKSTERNAL (%)" => "",
                "METODE" => "",
                "NAMA BIDDER" => "",
                "STATUS LAHAN" => "",
                "STATUS PERIZINAN (AMDAL, PRINSIP,DLL)" => "",
                "KLARIFIKASI / NEGOSIASI" => "",
                "KOMPENSASI OVERHEAD" => "",
                "SCOPE PEMELIHARAAN" => "",
                "SCOPE CAR" => "",
                "HIRARKI DOKUMEN KONTRAK" => "",
                "KLAIM / ANTI KLAIM" => "",
                "OVERHEAD DAN MARGIN EKSTERN" => "",
                "ESTIMATOR" => "",
                "KTT" => "",
                "MANAGER QS" => "",
                "GM QS" => "",
                "SVP PEMASARAN" => "",
                "GM OPERASI" => "",
                "SVP OPERASI" => "",

            ];
            return view("31_RAB_POC_DETAIL_NEW", ["proyek" => $proyek, "masterAHS" => $masterAHS, 'dataUmumField' => $dataUmumField, 'dataDetailBOQ' => $dataDetailBOQ]);
        } catch (\Throwable $th) {
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }

    public function viewDetailAHS(Request $request, Proyek $proyek, $kode_ahs)
    {
        try {
            $analisaHargaSatuanDetail = AnalisaHargaSatuanDetail::where("kode_ahs", $kode_ahs)->get();
            $analisaHargaSatuanDetail = $analisaHargaSatuanDetail->map(function ($item) use ($analisaHargaSatuanDetail) {
                if (str_contains(mb_substr($item->kode_sumber_daya, 0, 1), "A")) {
                    if ($item->kode_sumber_daya == "AN300000") {
                        $item->koef = $analisaHargaSatuanDetail->filter(function ($a) {
                            return str_contains(mb_substr($a->kode_sumber_daya, 0, 1), "D");
                        })->sum(function ($i) {
                            return !empty($i->MasterSumberDaya->MasterProduktivitas?->nilai_produktivitas) ? round(1 / $i->MasterSumberDaya->MasterProduktivitas?->nilai_produktivitas, 2) : 0;
                        }) * $item->MasterSumberDaya->MasterWaste->nilai_waste;
                    } else {
                        $item->koef = $item->MasterSumberDaya->MasterWaste->nilai_waste;
                    }
                } elseif (str_contains(mb_substr($item->kode_sumber_daya, 0, 1), "C")) {
                    $item->koef = 1;
                } elseif (str_contains(mb_substr($item->kode_sumber_daya, 0, 1), "D")) {
                    if ($item->kode_sumber_daya != "D1200000") {
                        if (!empty($item->MasterSumberDaya->MasterProduktivitas?->nilai_produktivitas)) {
                            $item->koef = round(1 / $item->MasterSumberDaya->MasterProduktivitas?->nilai_produktivitas, 4);
                        } else {
                            $item->koef = 0;
                        }
                    } else {
                        $item->koef = $analisaHargaSatuanDetail->filter(function ($a) {
                            return str_contains(mb_substr($a->kode_sumber_daya, 0, 1), "D");
                        })->sum(function ($i) {
                            return !empty($i->MasterSumberDaya->MasterProduktivitas?->nilai_produktivitas) ? round(1 / $i->MasterSumberDaya->MasterProduktivitas?->nilai_produktivitas, 2) : 0;
                        });
                    }
                } elseif (str_contains(mb_substr($item->kode_sumber_daya, 0, 1), "E")) {
                    $item->koef = 1;
                }

                return $item;
            });

            // dd($analisaHargaSatuanDetail);


            $materials = $analisaHargaSatuanDetail->filter(function ($ahs) {
                return str_contains(mb_substr($ahs->kode_sumber_daya, 0, 1), "A");
            });
            $upahs = $analisaHargaSatuanDetail->filter(function ($ahs) {
                return str_contains(mb_substr($ahs->kode_sumber_daya, 0, 1), "C");
            });
            $alats = $analisaHargaSatuanDetail->filter(function ($ahs) {
                return str_contains(mb_substr($ahs->kode_sumber_daya, 0, 1), "D");
            });
            $subKons = $analisaHargaSatuanDetail->filter(function ($ahs) {
                return str_contains(mb_substr($ahs->kode_sumber_daya, 0, 1), "E");
            });


            $total = $analisaHargaSatuanDetail->map(function ($item) {
                return ["harga" => (int)$item->MasterHargaSatuan?->harga ?? 0];
            })->sum(function ($item) {
                return $item["harga"];
            });

            $ahs = MasterAnalisaHargaSatuan::where("kode_ahs", $kode_ahs)->first();

            return view("32_RAB_POC_DETAIL_AHS", [
                "ahs" => $ahs,
                "materials" => $materials,
                "upahs" => $upahs,
                "alats" => $alats,
                "subKons" => $subKons,
                "total" => $total,
            ]);
        } catch (\Throwable $th) {
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }

    public function getDetailAHS($kode_ahs)
    {
        try {
            $ahsParent = MasterAnalisaHargaSatuan::where("kode_ahs", $kode_ahs)->first();
            $analisaHargaDetail = AnalisaHargaSatuanDetail::where("kode_ahs", $kode_ahs)->get();
            $totalVolume = $analisaHargaDetail->sum(function ($item) {
                return (float)$item->MasterSumberDaya->MasterHargaSatuan->volume ?? 0;
            });
            $totalHarsat = $analisaHargaDetail->sum(function ($item) {
                return (float)$item->MasterSumberDaya->MasterHargaSatuan->harga ?? 0;
            });

            $data = [
                "kode_ahs" => $kode_ahs,
                "uraian" => $ahsParent->uraian,
                "satuan" => "",
                "volume" => $totalVolume,
                "harsat" => $totalHarsat,
                "total" =>  $totalVolume * $totalHarsat,
                "harsat_eksternal" => $totalVolume != 0 && $totalHarsat != 0 ? (int)(($totalVolume * $totalHarsat) * 1.3) / $totalVolume : 0,
                "total_eksternal" => $totalVolume != 0 && $totalHarsat != 0 ? (int)($totalVolume * $totalHarsat) * 1.3 : 0,
            ];

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                "kode_ahs" => null,
                "uraian" => null,
                "satuan" => null,
                "volume" => null,
                "harsat" => null,
                "total" =>  null,
                "harsat_eksternal" => null,
                "total_eksternal" => null,
            ], 500);
        }
    }

    public function uploadBOQ(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx',
                'kode_proyek' => 'required|string',  // Tambahkan validasi untuk kode proyek
            ]);

            // Ambil kode proyek dari request
            $kodeProyek = $request->kode_proyek;

            // Lakukan import dan masukkan kode proyek ke dalam BoqImport
            Excel::import(new BoqImport($kodeProyek), $request->file('file'));

            Alert::success("Success", "Data Berhasil Di Upload");
            return redirect('/estimasi-proyek/detail/' . $request->kode_proyek . '#kt_view_boq_ekstern');
        } catch (\Throwable $th) {
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }

    public function editBOQ(Request $request, Proyek $proyek)
    {

        try {
            DB::beginTransaction();
            $collectIndex = $request->get("index");
            $collectKodeTahap = $request->get("kode_tahap");

            foreach ($collectIndex as $key => $id) {
                $selectBOQ = BoqDetail::find($id);
                $selectBOQ->kode_tahap = $collectKodeTahap[$key];
                $selectBOQ->save();
            }

            DB::commit();

            Alert::success("Success", "Data berhasil di edit");
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }
}
