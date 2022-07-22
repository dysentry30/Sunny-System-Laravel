<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ClaimManagements extends Model
{
    use HasFactory;
    use Sortable;
    protected $primaryKey = "id_claim";

    protected $casts = [
        "id_claim" => "string",
    ];

    public $sortable = [
        'nilai_claim', 'kode_proyek'
    ];

    public function contract() {
        return $this->hasOne(ContractManagements::class, "id_contract", "id_contract");
    }

    public function project() {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }

    public function claimDetails() {
        return $this->hasMany(ClaimDetails::class, "id_claim");
    }

    public function claimContractDrafts()
    {
        return $this->hasMany(ClaimContractDrafts::class, "id_claim");
    }

    public function claimContractDiajukan()
    {
        return $this->hasMany(ClaimContractDiajukan::class, "id_claim");
    }

    public function claimContractNegoisasi()
    {
        return $this->hasMany(ClaimContractNegoisasi::class, "id_claim");
    }
    
    public function claimContractDisetujui()
    {
        return $this->hasMany(ClaimContractDisetujui::class, "id_claim");
    }

}
