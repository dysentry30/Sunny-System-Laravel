<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelTenderProyek extends Model
{
    use HasFactory;

    public function Pegawai()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'nip');
    }

    public function Proyek()
    {
        return $this->belongsTo(Proyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function SKASKTProyek()
    {
        return $this->hasMany(SKASKTProyek::class, 'nip', 'nip');
    }
}
