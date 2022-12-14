<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenNda extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_dokumen_nda';
    protected $table = 'dokumen_ndas'; 
}
