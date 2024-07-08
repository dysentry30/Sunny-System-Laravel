<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksApprovalTerkontrakProyek extends Model
{
    use HasUuids;

    public function Pegawai()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'nip');
    }

    public function UnitKerja()
    {
        return $this->hasOne(UnitKerja::class, 'divcode', 'unit_kerja');
    }
}
