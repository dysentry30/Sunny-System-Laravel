<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasalKontraktual extends Model
{
    use HasFactory;
    protected $primaryKey = "id_pasal_kontraktual";
    protected $table = "pasal_kontraktual";
}
