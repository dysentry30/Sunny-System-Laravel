<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewContracts extends Model
{
    use HasFactory;

    protected $primaryKey = "id_review";
    protected $fillable = ["*"];

    public function User() {
        return $this->hasOne(User::class, "id", "pic_cross");
    }

    public function DraftContract() {
        return $this->hasOne(DraftContracts::class, "id_draft", "id_draft_contract");
    }
}
