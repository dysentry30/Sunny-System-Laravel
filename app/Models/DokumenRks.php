<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenRks extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_dokumen_rks';
    protected $table = 'dokumen_rks';
}
