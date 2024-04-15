<?php

namespace App\Http\Controllers;

use App\Models\Csi;
use App\Models\CsiMasterTingkatKepuasan;
use Illuminate\Http\Request;

class CSIDashboardController extends Controller
{
    /**
     * Tampilan Utama Dashboard
     */
    public function index(Request $request)
    {
        $kategoriCSI = CsiMasterTingkatKepuasan::all();
        $CSIFinish = Csi::select(['id_csi', 'id_customer', 'no_spk', 'status', 'score_csi', 'is_setuju'])->with(['ProyekPIS'])->where('status', 'Done')->where('is_setuju', 't')->get();
        $masterTingkatKepuasan = CsiMasterTingkatKepuasan::all();

        $CSIGroupByProyek = $CSIFinish->groupBy('no_spk');

        $CSIGetLastProgress = $CSIGroupByProyek?->map(function ($value, $key) {
            $value = $value->last();
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

            $totalAverageScoreCsi = round($totalNilaiCsi / $totalCountCSI, 2);

            $totalAveragePersentaseCsi = round($totalAverageScoreCsi / $masterTingkatKepuasan->count() * 100, 2);
        }

        $tingkatKepuasanTotal = $masterTingkatKepuasan->filter(function ($item) use ($totalAveragePersentaseCsi) {
            return $item->dari <= $totalAveragePersentaseCsi && $item->sampai >= $totalAveragePersentaseCsi;
        })->first()->kategori ?? '-';

        $dataAverageTotalCsi = [$totalAverageScoreCsi, $totalAveragePersentaseCsi];




        //------------------------------------------//
        // Total Average Charts Per Divisi
        //------------------------------------------//

        $CSIMapWithDivisi = $CSIGetLastProgress->map(function ($item) {
            $item->unit_kerja = $item->ProyekPIS->UnitKerja->unit_kerja;
            return $item;
        });

        $CSIGroupByUnitKerja = $CSIMapWithDivisi->groupBy('unit_kerja');

        $groupUnitKerja = collect(['Divisi Infrastruktur 1', 'Divisi Infrastruktur 2', 'Divisi EPCC', 'Divisi BGLN']);

        $dataAveragePerDivisiCsi = $groupUnitKerja->map(function ($value) use ($CSIGroupByUnitKerja, $masterTingkatKepuasan) {
            $sumPerDivisi = 0;
            $totalPerDivisi = 0;
            $CSIGroupByUnitKerja->each(function ($item, $key) use ($value, &$sumPerDivisi, &$totalPerDivisi) {
                if ($value == $key) {
                    $sumPerDivisi = $item->sum(function ($i) {
                        return (float)$i->score_csi;
                    });
                    $totalPerDivisi += $item->count();
                }
            });
            $averagePerDivisi = $totalPerDivisi != 0 ? round($sumPerDivisi / $totalPerDivisi, 2) : 0;
            $persentasePerDivisi = $averagePerDivisi != 0 || $masterTingkatKepuasan->count() != 0 ? round($averagePerDivisi / $masterTingkatKepuasan->count() * 100, 2) : 0;

            $keteranganPerDivisi = $masterTingkatKepuasan->filter(function ($item) use ($persentasePerDivisi) {
                return $item->dari <= $persentasePerDivisi && $item->sampai >= $persentasePerDivisi;
            })->first()->kategori ?? '-';

            return ['key' => $value, 'sumPerDivisi' => round($sumPerDivisi, 2), 'totalPerDivisi' => $totalPerDivisi, 'persentasePerDivisi' => $persentasePerDivisi, 'keteranganPerDivisi' => $keteranganPerDivisi];
        });

        return view("Csi.dashboard.index", ["kategoriCSI" => $kategoriCSI, 'dataAverageTotalCsi' => $dataAverageTotalCsi, 'tingkatKepuasanTotal' => $tingkatKepuasanTotal, 'dataAveragePerDivisiCsi' => $dataAveragePerDivisiCsi]);
    }
}
