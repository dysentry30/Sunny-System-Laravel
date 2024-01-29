<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKlasifikasiSBU extends Model
{
    use HasFactory;
    protected $table = 'master_klasifikasi_sbu';

    public function MasterSubKlasifikasiSBU()
    {
        return $this->belongsTo(MasterSubKlasifikasiSBU::class, 'klasifikasi_id', 'id_klasifikasi');
    }
}
