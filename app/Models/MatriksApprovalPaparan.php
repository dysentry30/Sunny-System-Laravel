<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksApprovalPaparan extends Model
{
    use HasFactory;
    protected $table = 'matriks_approval_paparan';

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nama_pegawai', 'nip');
    }

    public function Divisi()
    {
        return $this->hasOne(Divisi::class, 'id_divisi', 'divisi_id');
    }

    public function Departemen()
    {
        return $this->hasOne(Departemen::class, 'kode_departemen', 'departemen_code');
    }
}
