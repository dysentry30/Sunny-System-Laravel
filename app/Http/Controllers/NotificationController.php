<?php

namespace App\Http\Controllers;

use App\Class\sendNotification;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotificationApproval(Request $request)
    {
        $sendMessage = new sendNotification();
        $sendMessage->sendNotificationFirebase('ET163790', "Approval", "Terkontrak", 'AE012402EP', "Persetujuan", "revisi");
        return response()->json("TES");
    }
}
