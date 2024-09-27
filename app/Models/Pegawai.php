<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = "pegawai";
    protected $primaryKey = "nip";
    protected $keyType = "string";

    public function Jabatan() {
        return $this->hasOne(Jabatan::class, "kode_jabatan_sap", "kode_jabatan_sap");
    }

    public function User() {
        return $this->hasOne(User::class, "nip", "nip");
    }

    public function MatriksApproval()
    {
        return $this->hasMany(MatriksApprovalRekomendasi::class, "nama_pegawai", "nip");
    }

    public function MatriksTerkontrakProyek()
    {
        return $this->hasMany(MatriksApprovalTerkontrakProyek::class, "nip", "nip");
    }

    public function MatriksPartner()
    {
        return $this->hasMany(MatriksApprovalPartnerSelection::class, "nama_pegawai", "nip");
    }

    public function MatriksVerifikasiPartner()
    {
        return $this->hasMany(MatriksApprovalVerifikasiPartner::class, "nama_pegawai", "nip");
    }

    public function MatriksApprovalPersetujuanPartner()
    {
        return $this->hasMany(MatriksApprovalPersetujuanPartner::class, "nama_pegawai", "nip");
    }

    public function MatriksApprovalVerifikasiProyekNota2()
    {
        return $this->hasMany(MatriksApprovalVerifikasiProyekNota2::class, "nama_pegawai", "nip");
    }

    public function MatriksApproval2()
    {
        return $this->hasMany(MatriksApprovalNotaRekomendasi2::class, "nama_pegawai", "nip");
    }

    public function MatriksApprovalChangeManagement()
    {
        return $this->hasMany(MatriksApprovalChangeManagement::class, "nip", "nip");
    }

}
