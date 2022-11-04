<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryOwner extends Model
{
    use HasFactory;

    protected $primaryKey = "code_owner";
    protected $keyType = "string";
    protected $table = "industry_owners";
}
