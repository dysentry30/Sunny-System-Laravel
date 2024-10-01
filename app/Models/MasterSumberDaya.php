<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MasterSumberDaya extends Model
{
    use HasUuids;
    protected $table = "master_sumber_daya";

    public function MasterHargaSatuan()
    {
        return $this->hasOne(MasterHargaSatuan::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterProduktivitas()
    {
        return $this->hasOne(MasterProduktivitas::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterWaste()
    {
        return $this->hasOne(MasterWaste::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterFaktorLainLain()
    {
        return $this->hasOne(MasterFaktorLainLain::class, "kode_sumber_daya", "kode_sumber_daya");
    }
}
