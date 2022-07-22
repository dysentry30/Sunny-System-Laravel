<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimContractNegoisasi extends Model
{
    use HasFactory;
    protected $primaryKey = "id_negosiasi";
    protected $table = "claim_negosiasis";
}
