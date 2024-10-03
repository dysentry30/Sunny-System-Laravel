<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqDetail extends Model
{
    use HasUuids;
    public $table = 'boq_detail';

    protected $fillable = ['kode_proyek', 'uraian_pekerjaan', 'satuan', 'volume', 'level', 'index', 'kode_boq'];
}
