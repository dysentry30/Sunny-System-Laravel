<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcaraKesepakatan extends Model
{
    use HasUuids;

    public $table = 'berita_acara_kesepakatan';
}
