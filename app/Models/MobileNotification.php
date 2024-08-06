<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileNotification extends Model
{
    use HasFactory;
    public $incrementing = false;

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }
}
