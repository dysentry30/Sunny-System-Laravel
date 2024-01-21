<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractApproval extends Model
{
    use HasFactory;
    protected $table = "contract_approval";
    protected $primaryKey = "id_perubahan_kontrak";
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function ContractManagements()
    {
      return  $this->belongsTo(ContractManagements::class, "id_contract");
    }
    public function Proyeks()
    {
      return  $this->belongsTo(Proyek::class, "kode_proyek");
    }
    public function PerubahanKontrak()
    {
      return  $this->belongsTo(PerubahanKontrak::class, "perubahan_id", 'id_perubahan_kontrak');
    }
    public function ProyekPISNew()
    {
      return  $this->hasOne(ProyekPISNew::class, "profit_center", "profit_center");
    }
}
