<?php

namespace App\Http\Controllers;

use App\Models\Csi;
use App\Models\CsiMasterTingkatKepuasan;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        $CSIFinish = Csi::select(['id_csi', 'id_customer', 'no_spk', 'status', 'score_csi', 'is_setuju'])->with(['ProyekPIS'])->where('status', 'Done')->where('is_setuju', 't')->whereYear('tanggal_submit', $getYear)->get();

        if (!empty($getMonth)) {
            $CSIFinish = $CSIFinish->filter(function ($csi) use ($getMonth) {
                return Carbon::parse($csi->tanggal_submit)->format('m') == $getMonth;
            });
        }

        $kategoriCSI = CsiMasterTingkatKepuasan::all();
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
                    $totalPerDivisi = $item->count();
                }
            });
            $averagePerDivisi = $totalPerDivisi != 0 ? round($sumPerDivisi / $totalPerDivisi, 2) : 0;
            $persentasePerDivisi = $averagePerDivisi != 0 || $masterTingkatKepuasan->count() != 0 ? round($averagePerDivisi / $masterTingkatKepuasan->count() * 100, 2) : 0;

            $keteranganPerDivisi = $masterTingkatKepuasan->filter(function ($item) use ($persentasePerDivisi) {
                return $item->dari <= $persentasePerDivisi && $item->sampai >= $persentasePerDivisi;
            })->first()->kategori ?? '-';

            return ['key' => $value, 'sumPerDivisi' => round($sumPerDivisi, 2), 'totalPerDivisi' => $totalPerDivisi, 'persentasePerDivisi' => $persentasePerDivisi, 'keteranganPerDivisi' => $keteranganPerDivisi];
        });

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

        $nilaiRadarKanan = collect([]);
        for ($i = 0; $i < 7; $i++) {
            $nilaiRadarKanan->push(round(rand(30 * 10, 100 * 10) / 10, 2));
        }

        $nilaiRadarKiri = collect([]);
        for ($i = 0; $i < 5; $i++) {
            $nilaiRadarKiri->push(round(rand(30 * 10, 100 * 10) / 10, 2));
        }
        return view('Csi.dashboard.detail', ['unitKerja' => $unit_kerja, 'nilaiRadarKiri' => $nilaiRadarKiri, 'nilaiRadarKanan' => $nilaiRadarKanan, 'getYear' => $getYear, 'getMonth' => $getMonth]);
    }
}
