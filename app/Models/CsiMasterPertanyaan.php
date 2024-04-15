<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsiMasterPertanyaan extends Model
{
    use HasFactory;

    protected $table = "csi_master_pertanyaan";
    public $incrementing = false;

    public function CsiMasterKategoriPertanyaan()
    {
        return $this->hasOne(CsiMasterKategoriPertanyaan::class, 'code', 'kategori');
    }

    public function CsiMasterGroupParentPertanyaan()
    {
        return $this->hasOne(CsiMasterGroupParentPertanyaan::class, 'code', 'kategori');
    }
}
