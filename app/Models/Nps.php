<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nps extends Model
{
    use HasFactory;
    protected $primaryKey = "id_nps";  
    protected $table = 'proyek_nps';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }


}