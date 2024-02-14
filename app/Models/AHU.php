<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AHU extends Model
{
    use HasFactory;
    protected $table = 'customer_ahu';
    public $timestamps = true;
}
