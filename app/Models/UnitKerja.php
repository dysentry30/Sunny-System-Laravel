<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;
    public function proyeks() {
        return $this->hasMany(Proyek::class, "unit_kerja", "divcode");
    }

    public function Users() {
        return $this->hasMany(User::class, "unit_kerja", "divcode");;
    }
    public function User_1() {
        return $this->hasOne(User::class, "id", "user_1");;
    }
    public function User_2() {
        return $this->hasOne(User::class, "id", "user_2");;
    }
    public function User_3() {
        return $this->hasOne(User::class, "id", "user_3");;
    }
}
