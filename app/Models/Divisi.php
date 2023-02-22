<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $table = "divisi";
    protected $primaryKey = "id_divisi";

    public function UnitKerja() {
        return $this->hasOne(UnitKerja::class, "divcode", "unit_kerja");
    }
}
