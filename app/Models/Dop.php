<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dop extends Model
{
    use HasFactory;

    public function UnitKerjas() {
        return $this->hasMany(UnitKerja::class, "dop", "dop");
    }
}
