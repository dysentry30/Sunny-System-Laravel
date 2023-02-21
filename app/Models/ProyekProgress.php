<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekProgress extends Model
{
    use HasFactory;
    protected $primaryKey = "id_proyek_progress";
    protected $table = "proyek_progress";

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'kode_proyek', 'kode_proyek');
    }
}

