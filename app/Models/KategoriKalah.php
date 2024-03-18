<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class KategoriKalah extends Model
{
    use HasUuids;
    protected $table = 'kategori_kalah';

    public function KategoriKalah()
    {
        return $this->belongsTo(Proyek::class, 'kategori_kalah', 'kategori');
    }
}
