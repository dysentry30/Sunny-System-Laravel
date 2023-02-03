<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaAssessment extends Model
{
    use HasFactory;
    protected $table = "kriteria_assessment";
    protected $primaryKey = "id_kriteria_assessment";
}
