<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        "nilai_forecast"
    ];
    protected $primaryKey = "id_forecast";
    protected $table = "forecasts";
    public function Dop()
    {
        // return $this->hasMany(Dop::class);
        return $this->hasOne(Dop::class, "dop", "unit_kerja");
    }
    public function Proyek()
    {
        return $this->belongsTo(Proyek::class, "kode_proyek");
    }
}
