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

    public function Proyek() {
        return $this->belongsTo(Proyek::class, "kode_proyek");
    }

    public function ProyekPISNew()
    {
        return $this->belongsTo(ProyekPISNew::class, "profit_center", "profit_center");
    }

    public function SiteInstruction()
    {
        return $this->hasMany(SiteInstruction::class, "perubahan_id", "id_perubahan_kontrak");
    }
    public function TechnicalForm()
    {
        return $this->hasMany(TechnicalForm::class, "perubahan_id", "id_perubahan_kontrak");
    }
    public function TechnicalQuery()
    {
        return $this->hasMany(TechnicalQuery::class, "perubahan_id", "id_perubahan_kontrak");
    }
    public function FieldChange()
    {
        return $this->hasMany(FieldChange::class, "perubahan_id", "id_perubahan_kontrak");
    }
    public function ChangeNotice()
    {
        return $this->hasMany(ContractChangeNotice::class, "perubahan_id", "id_perubahan_kontrak");
    }
    public function ChangeOrder()
    {
        return $this->hasMany(ContractChangeOrder::class, "perubahan_id", "id_perubahan_kontrak");
    }
    public function ChangeProposal()
    {
        return $this->hasMany(ContractChangeProposal::class, "perubahan_id", "id_perubahan_kontrak");
    }
}
