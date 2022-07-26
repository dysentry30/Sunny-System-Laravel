<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanKerjaManajemenKontrak extends Model
{
    use HasFactory;
    protected $primaryKey = "id_rencana_kerja_manajemen";
    protected $table = "rencana_kerja_manajemens";
}
