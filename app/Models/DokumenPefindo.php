<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPefindo extends Model
{
    use HasFactory;
    protected $table = "dokumen_pefindos";
    public $primaryKey = "id_dokumen_pefindo";
}
