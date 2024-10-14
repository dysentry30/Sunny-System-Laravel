<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\AnalisaHargaSatuanDetail;
use App\Models\MasterAnalisaHargaSatuan;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class AhsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row['KODE SUMBER DAYA'])) {
            return new MasterAnalisaHargaSatuan([
                'kode_ahs' => $row['KODE AHS'],
                'uraian' => $row['URAIAN PEKERJAAN'],
            ]);
        } else {
            return new AnalisaHargaSatuanDetail([
                'kode_ahs' => $row['KODE AHS'],
                'resource_code' => $row['KODE SUMBER DAYA']
            ]);
        }
    }
}
