<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractUploadFinal extends Model
{
    use HasFactory;
    protected $table = "contract_final_document";
    
    public function contract() {
        return $this->belongsTo(ContractManagements::class, 'id_contract');
    }
}
