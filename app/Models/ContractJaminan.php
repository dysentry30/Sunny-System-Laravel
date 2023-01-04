<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractJaminan extends Model
{
    use HasFactory;
    protected $primaryKey = "id_jaminan";  
    protected $table = 'contract_jaminan';

}