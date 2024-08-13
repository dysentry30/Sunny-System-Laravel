<?php

namespace App\Http\Controllers;

use App\Class\sendNotification;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotificationApproval(Request $request, $token)
    {
        $sendMessage = new sendNotification();
        // $sendMessage->sendNotificationFirebase($token, "TESTING", "Tesss", []);
        return response()->json("TES");
    }
}
