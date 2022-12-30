<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractChangeOrder extends Model
{
    use HasFactory;
    protected $primaryKey = "id_change_order";
    protected $table = "contract_change_order";
}
