<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKelengkapanPartnerKSO extends Model
{
    use HasFactory;
    protected $table = "dokumen_kelengkapan_partner_kso";
    protected $casts = [
        'id' => 'string'
    ];
}
