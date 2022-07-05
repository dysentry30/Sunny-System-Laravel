<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamProyek extends Model
{
    use HasFactory;

    public function Proyek()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }

    public function User()
    {
        return $this->hasOne(User::class, "id", "id_user");
    }
}
