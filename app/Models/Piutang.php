<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;
    protected $primaryKey = "id_piutang";
    protected $table  = "piutang";

    public function Proyek() {
        return $this->hasOne(Proyek::class, "profit_center", "profit_center");
    }
    
    public function Customer() {
        return $this->hasOne(Customer::class, "kode_nasabah", "debitor");
    }
}