<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMou extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_dokumen_mou';
    protected $table = 'dokumen_mous'; 
}
