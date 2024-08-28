<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaRekomendasi2 extends Model
{
    use HasFactory;
    protected $table = 'nota_rekomendasi_2';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, 'kode_proyek', 'kode_proyek');
    }
    public function KriteriaProjectSelectionDetail()
    {
        return $this->hasMany(KriteriaProjectSelectionDetail::class, 'kode_proyek', 'kode_proyek');
    }
    public function ProyekBerjalan()
    {
        return $this->hasOne(ProyekBerjalans::class, 'kode_proyek', 'kode_proyek');
    }
}
