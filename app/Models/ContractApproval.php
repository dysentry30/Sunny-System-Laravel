<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContractApproval extends Model
{
  use HasUuids;
  protected $table = "contract_approval_new";
  protected $guarded = [];
  public $timestamps = true;
  // protected $primaryKey = "id_perubahan_kontrak";
  // public $timestamps = false;
  // protected $hidden = ['created_at', 'updated_at'];

  public function ContractManagements()
  {
    try {
      if (Str::isUuid($this->id_contract)) {
        return  $this->belongsTo(ContractManagements::class, "id_contract");
      } else {
        return  $this->belongsTo(ContractManagements::class, "profit_center", "profit_center");
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  public function Proyeks()
  {
    try {
      if (!empty($this->kode_proyek)) {
        return  $this->belongsTo(Proyek::class, "kode_proyek");
      } else {
        return  $this->belongsTo(Proyek::class, "profit_center", "profit_center");
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  // public function PerubahanKontrak()
  // {
  //   return  $this->belongsTo(PerubahanKontrak::class, "perubahan_id", 'id_perubahan_kontrak');
  // }
  public function ProyekPISNew()
  {
    return  $this->hasOne(ProyekPISNew::class, "profit_center", "profit_center");
  }
}
