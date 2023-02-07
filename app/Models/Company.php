<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Company extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'nama_company'
    ];

    public function UnitKerja() {
        return $this->hasOne(UnitKerja::class, "unit_kerja", "nama_company");
    }
}
