<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MenuManagement extends Model
{
    use HasUuids;

    protected $fillable = ["kode_aplikasi", "kode_menu"];
}
