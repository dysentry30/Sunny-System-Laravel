<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenConsentNPWP extends Model
{
    use HasFactory;
    protected $table = 'dokumen_consent_npwp';
    public $primaryKey = 'id_dokumen_consent_npwp';
}
