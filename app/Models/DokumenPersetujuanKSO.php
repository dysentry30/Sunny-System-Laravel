<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPersetujuanKSO extends Model
{
    use HasUuids;
    public $table = 'dokumen_persetujuan_kso';

    public function Proyek()
    {
        return $this->belongsTo(Proyek::class, 'kode_proyek', 'kode_proyek');
    }
}
