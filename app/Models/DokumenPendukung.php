<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendukung extends Model
{
    use HasFactory;

    protected $primaryKey = "id_dokumen_pendukung";
    
    public function User() {
        return $this->hasOne(User::class, "id", "created_by");
    }
}
