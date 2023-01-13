<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractChangeProposal extends Model
{
    use HasFactory;
    protected $primaryKey = "id_technical_query";
    protected $table = "contract_change_proposal";
}
