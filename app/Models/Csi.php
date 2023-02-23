<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Csi extends Model
{
    use HasFactory;
    protected $primaryKey = "id_csi";  
    protected $table = 'proyek_csi';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "no_spk");
    }

    public function UnitKerja()
    {
        return $this->hasOne(UnitKerja::class, "divcode", "divisi");
    }

}