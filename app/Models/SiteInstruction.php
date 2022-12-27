<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteInstruction extends Model
{
    use HasFactory;
    protected $primaryKey = "id_instruction";
    protected $table = "contract_site_instruction";
}
