<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasals extends Model
{
    use HasFactory;
    protected $primaryKey = "id_pasal";
    protected $fillable = ["pasal"];
}
