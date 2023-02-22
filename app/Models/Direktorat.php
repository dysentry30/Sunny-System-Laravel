<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    use HasFactory;
    protected $table = "direktorat";
    protected $primaryKey = "id_direktorat";

    public function DOP() {
        return $this->hasOne(Dop::class, "id", "dop");
    }
}
