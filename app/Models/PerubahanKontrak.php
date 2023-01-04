<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerubahanKontrak extends Model
{
    use HasFactory;
    protected $table = "perubahan_kontrak";
    protected $primaryKey = "id_perubahan_kontrak";

    public function JenisDokumen() {
        return $this->hasMany(JenisDokumen::class, "id_perubahan_kontrak");
    }

    public function DokumenPendukungs() {
        return $this->hasMany(DokumenPendukung::class, "id_perubahan_kontrak");
    }

    public function ContractManagement() {
        return $this->belongsTo(ContractManagements::class, "id_contract");
    }

    public function Asuransi(){
        return $this->hasMany(ContractAsuransi::class, "id_perubahan_kontrak");
    }
    
    public function Jaminan(){
        return $this->hasMany(ContractJaminan::class, "id_perubahan_kontrak");
    }

    // public function Proyek() {
    //     return $this->belongsTo(Proyek::class, "project_id", "kode_proyek");
    // }
}
