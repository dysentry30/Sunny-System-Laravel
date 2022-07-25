<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingIssue extends Model
{
    use HasFactory;
    protected $primaryKey = "id_pending_issue";
    protected $table = "pending_issues";
}
