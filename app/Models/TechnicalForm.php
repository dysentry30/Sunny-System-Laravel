<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalForm extends Model
{
    use HasFactory;
    protected $primaryKey = "id_technical_form";
    protected $table = "contract_technical_form";
}
