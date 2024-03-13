<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPenentuanKSO extends Model
{
    use HasFactory;
    protected $table = 'dokumen_penentuan_kso';

    public function Proyek()
    {
        return $this->belongsTo(Proyek::class, 'kode_proyek', 'kode_proyek');
    }
}