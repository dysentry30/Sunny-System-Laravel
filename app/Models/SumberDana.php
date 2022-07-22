<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SumberDana extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'nama_sumber', 'kategori', 'unique_code', 'sumber_dana_id', 'kode_proyek_id'
    ];
}
