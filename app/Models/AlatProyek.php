<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatProyek extends Model
{
    use HasFactory;

    public function MasterAlatProyek()
    {
        return $this->hasOne(MasterAlatProyek::class, 'nomor_rangka', 'nomor_rangka');
    }

    public function Proyek()
    {
        return $this->belongsTo(Proyek::class, 'kode_proyek', 'kode_proyek');
    }
}