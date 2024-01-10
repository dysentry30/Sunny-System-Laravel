<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimTender extends Model
{
    use HasFactory;

    public function Pegawai()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'nip_pegawai');
    }
}
