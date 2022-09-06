<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryForecast extends Model
{
    use HasFactory;

    protected $primaryKey = "id_history_forecast";
    protected $table = "history_forecast";
    protected $fillable = ["kode_proyek", "nilai_forecast", "month_forecast", "month_rkap", "rkap_forecast", "realisasi_forecast", "month_realisasi", "periode_prognosa"];

    public function Proyek() {
        return $this->belongsTo(Proyek::class, "kode_proyek");
    }
}
