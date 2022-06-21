<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_customer';
    // protected $guarded   = ['id_customer'];

    public function customerAttachments()
    {
        return $this->hasMany(CustomerAttachments::class, "id_customer");
    }

    public function proyekBerjalans()
    {
        return $this->hasMany(ProyekBerjalans::class, "id_customer");
    }
    
    public function proyek()
    {
        return $this->hasMany(Proyek::class);
    }

}