<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    protected $table = "departement";

    public function Proyek()
    {
        return $this->belongsTo(Proyek::class, "departemen_proyek", "kode_departemen");
    }
    
    public function UnitKerja()
    {
        return $this->belongsTo(UnitKerja::class, "kode_divisi", "kode_sap");
    }

    public function MatriksApproval()
    {
        return $this->belongsTo(MatriksApprovalRekomendasi::class, "departemen", "kode_departemen");
    }
}
