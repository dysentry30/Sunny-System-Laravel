<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrySector extends Model
{
    use HasFactory;
    protected $table = "industry_sectors";
    protected $primaryKey = "id_industry_sectors";
    protected $keyType = "string";
}
