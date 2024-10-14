<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisaHargaSatuanDetail extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $fillable = ['kode_ahs', 'resource_code'];

    public function MasterAnalisaHargaSatuan()
    {
        return $this->hasOne(MasterAnalisaHargaSatuan::class, "kode_ahs", "kode_ahs");
    }

    public function MasterSumberDaya()
    {
        return $this->hasOne(MasterSumberDaya::class, "code", "resource_code");
    }

    public function MasterHargaSatuan()
    {
        return $this->hasOne(MasterHargaSatuan::class, "resource_code", "resource_code");
    }
}
