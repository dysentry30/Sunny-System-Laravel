<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractChangeNotice extends Model
{
    use HasFactory;
    protected $primaryKey = "id_change_notice";
    protected $table = "contract_change_notice";
}
