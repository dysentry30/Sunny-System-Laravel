<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractApproval extends Model
{
    use HasFactory;
    protected $table = "contract_approval";

    public function ContractManagements(){
      return  $this->belongsTo(ContractManagements::class, "id_contract");
    }
}
