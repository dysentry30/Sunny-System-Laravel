<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekBerjalans extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_proyek';
    protected $table = "proyek_berjalans";
}
