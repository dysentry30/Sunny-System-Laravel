<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAnalisaHargaSatuan extends Model
{
    use HasUuids;
    protected $table = "master_analisa_harga_satuan";
}
