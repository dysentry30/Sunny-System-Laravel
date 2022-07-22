<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekBerjalans extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_proyek';
    protected $table = "proyek_berjalans";

    public function proyek()
    {
        return $this->hasOne(Proyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function UnitKerja()
    {
        return $this->hasOne(UnitKerja::class, "divcode", "unit_kerja");
    }
}
