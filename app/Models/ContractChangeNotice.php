<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractChangeNotice extends Model
{
    use HasFactory;
    protected $primaryKey = "id_field_change";
    protected $table = "contract_change_notice";
}
