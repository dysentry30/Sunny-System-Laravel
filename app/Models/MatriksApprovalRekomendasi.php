<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksApprovalRekomendasi extends Model
{
    use HasFactory;
    protected $table = "matriks_approval_rekomendasi";
    protected $primaryKey = "id_matriks_approval_rekomendasi";

    // public function Jabatan() {
    //     return $this->hasOne(Jabatan::class, "kode_jabatan", "jabatan");
    // }
    public function Divisi() {
        return $this->hasOne(Divisi::class, "id_divisi", "unit_kerja");
    }

    public function Pegawai() {
        return $this->hasOne(Pegawai::class, "nip", "nama_pegawai");
    }
}
