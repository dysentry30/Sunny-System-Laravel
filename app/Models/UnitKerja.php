<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;
    public function proyeks() {
        return $this->hasMany(Proyek::class, "unit_kerja", "divcode");
    }
}
