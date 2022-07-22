<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Sbu extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'sbu' ,'kode_sbu','klasifikasi','sub_klasifikasi','referensi1','referensi2','referensi3','lingkup_kerja'
    ];
}
