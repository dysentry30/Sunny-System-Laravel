<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenDraft extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id_dokumen_draft';
    protected $table = 'dokumen_drafts';
}
