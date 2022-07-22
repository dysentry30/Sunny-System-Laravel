<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewPembatalanKontrak extends Model
{
    use HasFactory;

    public function User() {
        return $this->hasOne(User::class, "id", "created_by");
    }
}
