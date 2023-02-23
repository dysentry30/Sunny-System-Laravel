<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    // protected $table = "divisi";
    protected $table = "divisi_new";
    protected $primaryKey = "id_divisi";

    public function Direktorat() {
        return $this->hasOne(Direktorat::class, "kode_direktorat", "kode_direktorat");
    }

    // public function UnitKerja() {
    //     return $this->hasOne(UnitKerja::class, "divcode", "unit_kerja");
    // }
}
