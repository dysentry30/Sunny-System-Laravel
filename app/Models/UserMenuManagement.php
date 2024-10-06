<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenuManagement extends Model
{
    use HasUuids;

    protected $fillable = ["nip", "aplikasi", "menu", "create", "read", "update", "delete", "lock", "approve"];

    public function MasterMenu()
    {
        return $this->hasOne(MasterMenu::class, 'kode_menu', 'menu');
    }

    public function MasterApplication()
    {
        return $this->hasOne(MasterApplication::class, 'kode_aplikasi', 'aplikasi');
    }
}
