<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalTerkontrakProyek extends Model
{
    use HasUuids;

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function PegawaiRequest()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'request_by');
    }

    public function PegawaiApproved()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'approved_by');
    }
}
