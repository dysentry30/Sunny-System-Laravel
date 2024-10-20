<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerlakuanRisiko extends Model
{
    use HasUuids;
    public $table = 'perlakuan_risiko';
}
