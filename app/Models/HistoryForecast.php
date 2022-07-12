<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryForecast extends Model
{
    use HasFactory;

    protected $primaryKey = "id_history_forecast";
    protected $table = "history_forecast";

    public function Proyek() {
        return $this->belongsTo(Proyek::class, "kode_proyek");
    }
}
