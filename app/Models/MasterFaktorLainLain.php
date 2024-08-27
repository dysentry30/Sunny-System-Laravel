<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFaktorLainLain extends Model
{
    use HasUuids;
    protected $table = "master_faktor_lain_lain";

    public function MasterSumberDaya()
    {
        return $this->belongsTo(MasterSumberDaya::class, "kode_sumber_daya", "kode_sumber_daya");
    }
}
