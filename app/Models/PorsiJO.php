<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorsiJO extends Model
{
    use HasFactory;
    protected $table = 'porsi_jo_proyeks';

    public function Company()
    {
        return $this->hasOne(Customer::class, 'id_customer', 'id_company_jo');
    }

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function PartnerSelection()
    {
        return $this->hasMany(PartnerSelectionDetail::class, 'partner_id', 'id');
    }

    public function DokumenKelengkapanPartnerKSO()
    {
        return $this->hasMany(DokumenKelengkapanPartnerKSO::class, 'id_partner', 'id');
    }

}
