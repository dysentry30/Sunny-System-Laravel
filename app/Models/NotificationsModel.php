<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsModel extends Model
{
    use HasFactory;

    protected $primaryKey = "id_notification";
    protected $table = "notifications";

    protected $casts = [
        "id_notification" => "string"
    ];

    public function FromUser() {
        return $this->hasOne(User::class, "id", "from_id_user");
    }

    public function ToUser() {
        return $this->hasOne(User::class, "id", "to_user");
    }
}
