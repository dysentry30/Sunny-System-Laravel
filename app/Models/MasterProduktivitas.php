<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProduktivitas extends Model
{
    use HasUuids;

    public function MasterSumberDaya()
    {
        return $this->belongsTo(MasterSumberDaya::class, "kode_sumber_daya", "kode_sumber_daya");
    }
}
