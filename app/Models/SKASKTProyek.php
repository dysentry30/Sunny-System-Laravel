<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKASKTProyek extends Model
{
    protected $table = 'ska_skt_proyeks';
    protected $guarded = [];

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
