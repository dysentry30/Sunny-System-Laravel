<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimContractDiajukan extends Model
{
    use HasFactory;
    protected $primaryKey = "id_diajukans";
    protected $table = "claim_diajukans";
}
