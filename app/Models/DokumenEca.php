<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenEca extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_dokumen_eca';
    protected $table = 'dokumen_ecas'; 
}
