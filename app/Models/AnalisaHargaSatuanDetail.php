<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisaHargaSatuanDetail extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $fillable = ['kode_ahs', 'kode_sumber_daya'];

    public function MasterAnalisaHargaSatuan()
    {
        return $this->hasOne(MasterAnalisaHargaSatuan::class, "kode_ahs", "kode_ahs");
    }

    public function MasterSumberDaya()
    {
        return $this->hasOne(MasterSumberDaya::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterHargaSatuan()
    {
        return $this->hasOne(MasterHargaSatuan::class, "kode_sumber_daya", "kode_sumber_daya");
    }
}
