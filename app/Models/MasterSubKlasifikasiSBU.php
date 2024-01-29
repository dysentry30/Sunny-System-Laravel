<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubKlasifikasiSBU extends Model
{
    use HasFactory;
    protected $table = 'master_subklasifikasi_sbu';

    public function MasterKlasifikasiSBU()
    {
        return $this->hasOne(MasterKlasifikasiSBU::class, 'id_klasifikasi', 'klasifikasi_id');
    }
}
