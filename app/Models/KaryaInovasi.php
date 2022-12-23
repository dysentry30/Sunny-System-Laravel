<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaInovasi extends Model
{
    use HasFactory;
    protected $primaryKey = "id_inovasi";  
    protected $table = 'karya_inovasi';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }


}