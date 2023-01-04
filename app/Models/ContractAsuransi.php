<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractAsuransi extends Model
{
    use HasFactory;
    protected $primaryKey = "id_asuransi";  
    protected $table = 'contract_asuransi';

}