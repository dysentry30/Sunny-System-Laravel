<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratPembayaran extends Model
{
    use HasFactory;
    protected $primaryKey = "kode";
    protected $keyType = "string";
    protected $table = "syarat_pembayaran";
}
