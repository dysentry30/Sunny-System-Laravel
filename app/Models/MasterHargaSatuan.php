<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHargaSatuan extends Model
{
    use HasFactory;
    protected $table = "master_harga_satuan";

    public function MasterSumberDaya()
    {
        return $this->belongsTo(MasterSumberDaya::class, 'kode_sumber_daya', 'kode_sumber_daya');
    }
}
