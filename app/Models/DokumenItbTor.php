<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenItbTor extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_dokumen_itb_tor';
    protected $table = 'dokumen_itb_tors';
}
