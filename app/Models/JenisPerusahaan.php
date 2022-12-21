<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPerusahaan extends Model
{
    use HasFactory;
    protected $primaryKey = "kode_jenis";
    protected $keyType = "string";
    protected $table = "jenis_perusahaan";
}
