<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractRFADocument extends Model
{
    use HasFactory;
    protected $table = 'contract_rfa';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, 'kode_proyek');
    }
}
