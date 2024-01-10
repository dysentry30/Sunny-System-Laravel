<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksApprovalNotaRekomendasi2 extends Model
{
    use HasFactory;
    protected $table = 'matriks_approval_nota_rekomendasi_2';

    public function Pegawai()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'nama_pegawai');
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
