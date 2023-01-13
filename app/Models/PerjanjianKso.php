<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerjanjianKso extends Model
{
    use HasFactory;
    
    protected $primaryKey = "id_perjanjian_kso";

    public function User() {
        return $this->hasOne(User::class, "id", "created_by");
    }
}
