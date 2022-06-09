<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimManagements extends Model
{
    use HasFactory;
    protected $primaryKey = "id_claim";

    protected $casts = [
        "id_claim" => "string",
    ];

    public function contract() {
        return $this->hasOne(ContractManagements::class, "id_contract");
    }

    public function project() {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }

    public function claimDetails() {
        return $this->hasMany(ClaimDetails::class, "id_claim");
    }

}
