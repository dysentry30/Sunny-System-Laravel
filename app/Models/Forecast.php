<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Forecast extends Model
{
    use HasFactory,Sortable;

    public $sortable = [
        'nilai_forecast', 'rkap_forecast', 'realisasi_forecast'
    ];

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
        // return $this->hasOne(Proyek::class, "kode_proyek");
    }
}
