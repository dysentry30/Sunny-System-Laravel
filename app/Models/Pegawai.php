<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = "pegawai";
    protected $primaryKey = "nip";
    protected $keyType = "string";

    public function Jabatan() {
        return $this->hasOne(Jabatan::class, "kode_jabatan", "kode_jabatan");
    }
}
