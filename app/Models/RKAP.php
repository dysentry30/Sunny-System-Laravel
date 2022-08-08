<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class RKAP extends Model
{
    use HasFactory;
     use Sortable;

    // public $sortable = [
    //     'nomor_unit', 'unit_kerja', 'divcode', 'dop', 'company', 'divisi', 'is_active'
    // ];

    public function Proyeks() {
        return $this->hasMany(Proyek::class, "kode_proyek");
    }
}
