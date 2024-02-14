<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaRekomendasi extends Model
{
    use HasFactory;
    protected $table = 'nota_rekomendasi';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function KriteriaPenggunaJasaDetail()
    {
        return $this->hasMany(KriteriaPenggunaJasaDetail::class, 'kode_proyek', 'kode_proyek');
    }
}
