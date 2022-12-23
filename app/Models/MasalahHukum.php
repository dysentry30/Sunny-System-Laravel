<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasalahHukum extends Model
{
    use HasFactory;
    protected $primaryKey = "id_hukum";  
    protected $table = 'masalah_hukum';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }


}