<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KriteriaDampakKuantitatif extends Model
{
    use HasUuids;
    public $table = 'kriteria_dampak_kuantitatif';
}
