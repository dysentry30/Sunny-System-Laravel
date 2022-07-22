<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimContractDrafts extends Model
{
    use HasFactory;
    protected $primaryKey = "id_draft";
    protected $table = "claim_drafts";
}
