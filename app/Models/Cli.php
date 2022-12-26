<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cli extends Model
{
    use HasFactory;
    protected $primaryKey = "id_cli";  
    protected $table = 'proyek_cli';

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }


}