<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentPartnerSelection extends Model
{
    use HasFactory;

    public function PartnerJO()
    {
        return $this->hasOne(PorsiJO::class, 'id', 'partner_id');
    }
}
