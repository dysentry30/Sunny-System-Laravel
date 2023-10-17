<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    use HasFactory;
    protected $table = 'customer_laporan_keuangan';
    public $timestamps = true;
}
