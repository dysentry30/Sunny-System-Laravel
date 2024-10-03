<?php

namespace App\Imports;

use App\Models\BoqDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class BoqImport implements ToModel, WithHeadingRow
{

    protected $kodeProyek;
    protected $count;

    // Constructor untuk menerima kode proyek saat instance di-create
    public function __construct($kodeProyek)
    {
        $this->kodeProyek = $kodeProyek;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->count++;
        return new BoqDetail([
            'kode_proyek' => $this->kodeProyek,
            'kode_boq' => $row['NO'],
            'uraian_pekerjaan' => $row['URAIAN PEKERJAAN'],
            'satuan' => $row['SATUAN'],
            'volume' => $row['VOLUME'],
            'level' => 0,
            'index' => $this->count,
        ]);
    }

    public function headingRow(): int
    {
        return 4;
    }
}
