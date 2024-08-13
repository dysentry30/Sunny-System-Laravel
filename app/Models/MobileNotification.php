<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileNotification extends Model
{
    use HasUuids;
    public $incrementing = false;

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }
}
