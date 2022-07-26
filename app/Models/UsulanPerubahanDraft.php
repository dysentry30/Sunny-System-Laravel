<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanPerubahanDraft extends Model
{
    use HasFactory;
    protected $primaryKey = "id_usulan_perubahan_draft";
    protected $table = "usulan_perubahan_drafts";
}
