<?php

namespace App\Http\Controllers;

use App\Models\Csi;
use App\Models\CsiMasterTingkatKepuasan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class CSIDashboardController extends Controller
{
    /**
     * Tampilan Utama Dashboard
     */
    public function index(Request $request)
    {
        //-----------------------------------------//
        // Filter Dashboard
        //-----------------------------------------//

        $getYear = $request->get('get-year') ?? date('Y');
        $getMonth = $request->get('get-month') ?? '';

        $CSIFinish = Csi::select(['id_csi', 'id_customer', 'no_spk', 'status', 'score_csi', 'is_setuju'])
        ->with(['ProyekPIS'])
        ->where('status', 'Done')
        ->where('is_setuju', 't')
        ->whereYear('tanggal_submit', $getYear)
            ->get();

        if (!empty($getMonth)) {
            $CSIFinish = $CSIFinish->filter(function ($csi) use ($getMonth) {
                return Carbon::parse($csi->tanggal_submit)->format('m') <= $getMonth;
            });
        }

        $kategoriCSI = CsiMasterTingkatKepuasan::all();
        $masterTingkatKepuasan = CsiMasterTingkatKepuasan::all();

        $CSIGroupByProyek = $CSIFinish?->filter(function ($csi) {
            return empty($csi->ProyekPIS->entitas_proyek) && !empty($csi->ProyekPIS->bast2_date) && $csi->ProyekPIS->bast2_date >= Carbon::now();
        })->groupBy('no_spk');

        $CSIGetLastProgress = $CSIGroupByProyek?->map(function ($value, $key) {
            $value = $value?->sortBy("id_csi")->last();
            return $value;
        })->values();

        //------------------------------------------//
        // Total Average Charts
        //------------------------------------------//

        $totalAverageScoreCsi = 0;
        $totalAveragePersentaseCsi = 0;

        if (!empty($CSIGetLastProgress)) {
            $totalNilaiCsi = $CSIGetLastProgress->sum(function ($item) {
                return (int)$item->score_csi;
            });
            $totalCountCSI = $CSIGetLastProgress->count();

            $totalAverageScoreCsi = $totalNilaiCsi != 0 || $totalCountCSI != 0 ? round($totalNilaiCsi / $totalCountCSI, 2) : 0;

            $totalAveragePersentaseCsi = $totalAverageScoreCsi != 0 || $masterTingkatKepuasan->count() != 0 ? round($totalAverageScoreCsi / $masterTingkatKepuasan->count() * 100, 2) : 0;
        }

        $tingkatKepuasanTotal = $masterTingkatKepuasan->filter(function ($item) use ($totalAveragePersentaseCsi) {
            return $item->dari <= $totalAveragePersentaseCsi && $item->sampai >= $totalAveragePersentaseCsi;
        })->first()->kategori ?? '-';

        $dataAverageTotalCsi = [$totalAverageScoreCsi, $totalAveragePersentaseCsi];




        //------------------------------------------//
        // Total Average Charts Per Divisi
        //------------------------------------------//

        $CSIMapWithDivisi = $CSIGetLastProgress->sortBy("profit_center")->map(function ($item) {
            $item->unit_kerja = $item->ProyekPIS->UnitKerja->unit_kerja;
            return $item;
        });

        $CSIGroupByUnitKerja = $CSIMapWithDivisi->groupBy('unit_kerja');

        $groupUnitKerja = collect(['Divisi Infrastruktur 1', 'Divisi Infrastruktur 2', 'Divisi EPCC', 'Divisi Gedung']);

        $dataAveragePerDivisiCsi = $CSIGroupByUnitKerja->map(function ($item, $key) use ($masterTingkatKepuasan) {
            $totalPerDivisi = $item->count();
            $sumPerDivisi = $item->sum(function ($i) {
                return (float) $i->score_csi;
            });

            $scorePerDivisi = round($item->avg(function ($value) {
                return (float) $value->score_csi;
            }), 2);

            $averagePerDivisi = $totalPerDivisi != 0 ? round($sumPerDivisi / $totalPerDivisi, 2) : 0;
            $persentasePerDivisi = $averagePerDivisi != 0 || $masterTingkatKepuasan->count() != 0 ? round($averagePerDivisi / $masterTingkatKepuasan->count() * 100, 2) : 0;
            $keteranganPerDivisi = $masterTingkatKepuasan->filter(function ($item) use ($persentasePerDivisi) {
                return $item->dari <= $persentasePerDivisi && $item->sampai >= $persentasePerDivisi;
            })->first()->kategori ?? '-';

            return ['key' => $key, 'sumPerDivisi' => round($sumPerDivisi, 3), 'totalPerDivisi' => $totalPerDivisi, 'persentasePerDivisi' => $persentasePerDivisi, 'keteranganPerDivisi' => $keteranganPerDivisi, 'scorePerDivisi' => $scorePerDivisi];
        })->sortKeys()->values();


        // $dataAveragePerDivisiCsi = $groupUnitKerja->map(function ($value) use ($CSIGroupByUnitKerja, $masterTingkatKepuasan) {
        //     $sumPerDivisi = 0;
        //     $totalPerDivisi = 0;
        //     $CSIGroupByUnitKerja->each(function ($item, $key) use ($value, &$sumPerDivisi, &$totalPerDivisi) {
        //         if ($value == $key) {
        //             $totalPerDivisi += 1;
        //             $sumPerDivisi += $item->sum(function ($i) {
        //                 return (float)$i->score_csi;
        //             });
        //         }
        //     });
        //     $averagePerDivisi = $totalPerDivisi != 0 ? round($sumPerDivisi / $totalPerDivisi, 2) : 0;
        //     $persentasePerDivisi = $averagePerDivisi != 0 || $masterTingkatKepuasan->count() != 0 ? round($averagePerDivisi / $masterTingkatKepuasan->count() * 100, 2) : 0;

        //     $keteranganPerDivisi = $masterTingkatKepuasan->filter(function ($item) use ($persentasePerDivisi) {
        //         return $item->dari <= $persentasePerDivisi && $item->sampai >= $persentasePerDivisi;
        //     })->first()->kategori ?? '-';

        //     return ['key' => $value, 'sumPerDivisi' => round($sumPerDivisi, 2), 'totalPerDivisi' => $totalPerDivisi, 'persentasePerDivisi' => $persentasePerDivisi, 'keteranganPerDivisi' => $keteranganPerDivisi];
        // });

        return view("Csi.dashboard.index", ["kategoriCSI" => $kategoriCSI, 'dataAverageTotalCsi' => $dataAverageTotalCsi, 'tingkatKepuasanTotal' => $tingkatKepuasanTotal, 'dataAveragePerDivisiCsi' => $dataAveragePerDivisiCsi, 'getYear' => $getYear, 'getMonth' => $getMonth]);
    }

    /**
     * Tampilan Detail Dashboard Per Divisi
     */
    public function detail(Request $request, $unit_kerja)
    {
        //----------------------------//
        // Filter Dashboard
        //----------------------------//
        $getYear = $request->get('get-year') ?? date('Y');
        $getMonth = $request->get('get-month') ?? '';

        $CSIFinish = Csi::select(['id_csi', 'id_customer', 'no_spk', 'status', 'jawaban', 'score_csi', 'is_setuju'])
            ->with(['ProyekPIS'])
            ->where('status', 'Done')
            ->where('is_setuju', 't')
            ->whereYear('tanggal_submit', $getYear)->get();

        if (!empty($getMonth)) {
            $CSIFinish = $CSIFinish->filter(function ($csi) use ($getMonth) {
                return Carbon::parse($csi->tanggal_submit)->format('m') <= $getMonth;
            });
        }

        $CSIGroupByProyek = $CSIFinish?->filter(function ($csi) {
            return empty($csi->ProyekPIS->entitas_proyek) && !empty($csi->ProyekPIS->bast2_date) && $csi->ProyekPIS->bast2_date >= Carbon::now();
        })->groupBy('no_spk');

        $CSIGetLastProgress = $CSIGroupByProyek?->map(function ($value, $key) {
            $value = $value?->sortBy("id_csi")->last();
                return $value;
            })->values();

        $nilaiRadarKanan = collect([]);
        $nilaiRadarKiri = collect([]);

        if (!empty($CSIGetLastProgress)) {
            $CSIMapWithDivisi = $CSIGetLastProgress->sortBy("profit_center")->map(function ($item) {
                $item->unit_kerja = $item->ProyekPIS->UnitKerja->unit_kerja;
                return $item;
            });

            $CSIGroupByUnitKerja = $CSIMapWithDivisi->groupBy('unit_kerja')->sortKeys();

            $CSIFilterUnitKerja = $CSIGroupByUnitKerja->filter(function ($value, $key) use ($unit_kerja) {
                return $key == $unit_kerja;
            })->values()->flatten();

            $jawabanCollect = $CSIFilterUnitKerja->where("jawaban", "!=", null)->sortBy("no_spk")->map(function ($value) {
                return json_decode($value->jawaban);
            })->filter(function ($item) {
                return !empty($item);
            });


            $mapPerCSI = $jawabanCollect->map(function ($item) {

                $newClass = new stdClass();

                $newClass->total_kepentingan = (int) $item->answer_4_1_2 + (int) $item->answer_4_2_2 + (int) $item->answer_4_3_2 + (int) $item->answer_4_4_1_b + (int) $item->answer_4_4_2_b + (int) $item->answer_4_4_3_b + (int) $item->answer_4_4_4_b + (int) $item->answer_5_1_2 + (int) $item->answer_5_2_2 + (int) $item->answer_5_3_2 + (int) $item->answer_5_4_2 + (int) $item->answer_5_5_2;
                $newClass->total_kepuasan = (int) $item->answer_4_1_1 + (int) $item->answer_4_2_1 + (int) $item->answer_4_3_1 + (int) $item->answer_4_4_1_a + (int) $item->answer_4_4_2_a + (int) $item->answer_4_4_3_a + (int) $item->answer_4_4_4_a + (int) $item->answer_5_1_1 + (int) $item->answer_5_2_1 + (int) $item->answer_5_3_1 + (int) $item->answer_5_4_1 + (int) $item->answer_5_5_1;

                $newClass->wis_1 = ((int) $item->answer_4_1_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_4_1_1;
                $newClass->wis_2 = ((int) $item->answer_4_2_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_4_2_1;
                $newClass->wis_3 = ((int) $item->answer_4_3_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_4_3_1;
                $newClass->wis_4 = ((int) $item->answer_4_4_1_b / (int) $newClass->total_kepentingan) * (int) $item->answer_4_4_1_a;
                $newClass->wis_5 = ((int) $item->answer_4_4_2_b / (int) $newClass->total_kepentingan) * (int) $item->answer_4_4_2_a;
                $newClass->wis_6 = ((int) $item->answer_4_4_3_b / (int) $newClass->total_kepentingan) * (int) $item->answer_4_4_3_a;
                $newClass->wis_7 = ((int) $item->answer_4_4_4_b / (int) $newClass->total_kepentingan) * (int) $item->answer_4_4_4_a;
                $newClass->wis_8 = ((int) $item->answer_5_1_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_5_1_1;
                $newClass->wis_9 = ((int) $item->answer_5_2_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_5_2_1;
                $newClass->wis_10 = ((int) $item->answer_5_3_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_5_3_1;
                $newClass->wis_11 = ((int) $item->answer_5_4_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_5_4_1;
                $newClass->wis_12 = ((int) $item->answer_5_5_2 / (int) $newClass->total_kepentingan) * (int) $item->answer_5_5_1;

                $total_wis = $newClass->wis_1 + $newClass->wis_2 + $newClass->wis_3 + $newClass->wis_4 + $newClass->wis_5 + $newClass->wis_6 + $newClass->wis_7 + $newClass->wis_8 + $newClass->wis_9 + $newClass->wis_10 + $newClass->wis_11 + $newClass->wis_12;

                $newClass->total_wis = round($total_wis, 2);

                return $newClass;
            })->values();

            $persentaseTotalWis1 = round($mapPerCSI->avg("wis_1") / 0.42, 4) * 100;
            $persentaseTotalWis2 = round($mapPerCSI->avg("wis_2") / 0.42, 4) * 100;
            $persentaseTotalWis3 = round($mapPerCSI->avg("wis_3") / 0.42, 4) * 100;
            $persentaseTotalWis4 = round($mapPerCSI->avg("wis_4") / 0.42, 4) * 100;
            $persentaseTotalWis5 = round($mapPerCSI->avg("wis_5") / 0.42, 4) * 100;
            $persentaseTotalWis6 = round($mapPerCSI->avg("wis_6") / 0.42, 4) * 100;
            $persentaseTotalWis7 = round($mapPerCSI->avg("wis_7") / 0.42, 4) * 100;

            $persentaseTotalWis8 = round($mapPerCSI->avg("wis_8") / 0.42, 4) * 100;
            $persentaseTotalWis9 = round($mapPerCSI->avg("wis_9") / 0.42, 4) * 100;
            $persentaseTotalWis10 = round($mapPerCSI->avg("wis_10") / 0.42, 4) * 100;
            $persentaseTotalWis11 = round($mapPerCSI->avg("wis_11") / 0.42, 4) * 100;
            $persentaseTotalWis12 = round($mapPerCSI->avg("wis_12") / 0.42, 4) * 100;


            for ($i = 1; $i <= 12; $i++) {
                if ($i <= 7) {
                    $nameVariable = 'persentaseTotalWis' . $i;
                    $nilaiRadarKanan->push($$nameVariable);
                } else {
                    $nameVariable = 'persentaseTotalWis' . $i;
                    $nilaiRadarKiri->push($$nameVariable);
                }
            }
        }

        return view('Csi.dashboard.detail', ['unitKerja' => $unit_kerja, 'nilaiRadarKiri' => $nilaiRadarKiri, 'nilaiRadarKanan' => $nilaiRadarKanan, 'getYear' => $getYear, 'getMonth' => $getMonth]);
    }
}
