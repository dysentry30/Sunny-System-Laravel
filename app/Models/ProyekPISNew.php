<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekPISNew extends Model
{
    use HasFactory;
    protected $table = 'proyek_pis_new';

    public function ContractManagements()
    {
        return $this->hasOne(ContractManagements::class, 'profit_center', 'profit_center');
    }

    public function ProyekProgress()
    {
        return $this->hasMany(ProyekProgress::class, 'kode_spk', 'spk_intern_no');
    }

    public function Customer()
    {
        return $this->hasOne(Customer::class, 'kode_nasabah', 'pemberi_kerja_code');
    }

    public function Csi()
    {
        return $this->hasMany(Csi::class, "no_spk", "spk_intern_no");
    }

    public function UnitKerja()
    {
        return $this->hasOne(UnitKerja::class, "divcode", "kd_divisi");
    }

    public function ContractApproval()
    {
        return $this->hasMany(ContractApproval::class, "profit_center", "profit_center");
    }

    public function PerubahanKontrak()
    {
        return $this->hasMany(PerubahanKontrak::class, "profit_center", "profit_center");
    }
}
