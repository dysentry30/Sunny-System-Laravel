<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    // use HasFactory;
    use HasUuids;
    // protected $primaryKey = "id_piutang";
    protected $table  = "piutang_new";

    // public function Proyek() {
    //     return $this->hasOne(Proyek::class, "profit_center", "profit_center");
    // }

    public function Proyek() {
        return $this->hasOne(Proyek::class, "kode_proyek", "kode_proyek");
    }
    
    // public function Customer() {
    //     return $this->hasOne(Customer::class, "kode_nasabah", "debitor");
    // }
    
    public function Customer() {
        return $this->hasOne(Customer::class, "id_customer", "customer_id");
    }

    public function UserCreated()
    {
        return $this->hasOne(User::class, "nip", "created_by");
    }

    public function UserUpdated()
    {
        return $this->hasOne(User::class, "nip", "updated_by");
    }
}