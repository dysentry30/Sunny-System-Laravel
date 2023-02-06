<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = "jabatans";
    protected $primaryKey = "id_jabatans";

    public function UnitKerja() {
        return $this->hasOne(UnitKerja::class, "divcode", "unit_kerja");
    }
}
