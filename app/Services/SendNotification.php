<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Proyek;
use Kreait\Firebase\Factory;
use App\Models\MobileNotification;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendNotification
{
    public $messaging;
    public function __construct()
    {
        $firebase_credential = (new Factory())->withServiceAccount(base_path(env("FIREBASE_CREDENTIALS")));
        $this->messaging = $firebase_credential->createMessaging();
    }

    public function sendNotificationFirebase($nip, $category, $sub_category, $kode_proyek, $category_approval = "", $status = "", $data = [])
    {
        $user = User::where("nip", $nip)->first();
        $proyek = Proyek::find($kode_proyek);

        $messageing = $this->setMessageNotification($proyek, $category, $sub_category, $category_approval, $status);

        $insertNotifDatabase = $this->insertNotificationToDatabase($user, $proyek, $category, $sub_category, $messageing[1]);

        if ($insertNotifDatabase) {
            // $message = CloudMessage::withTarget('token', $user->fcm_token)->withNotification([
            $message = CloudMessage::withTarget('topic', "global")->withNotification([
                "title" => $messageing[0],
                "body" => $messageing[1]
            ])->withData($data);

            if ($this->messaging->send($message)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function insertNotificationToDatabase(User $user, Proyek $proyek, $category, $sub_category, $message)
    {
        try {
            DB::beginTransaction();

            $newNotification = new MobileNotification();
            $newNotification->kode_proyek = $proyek->kode_proyek;
            $newNotification->category = $category;
            $newNotification->sub_category = $sub_category;
            $newNotification->message = $message;
            $newNotification->item_date = Carbon::now()->translatedFormat("d F Y");
            $newNotification->nip = $user->nip;
            $newNotification->is_read = false;

            $newNotification->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return false;
        }
    }





    private function setMessageNotification(Proyek $proyek, $category, $sub_category, $category_approval, $status)
    {
        $title = "";
        $body = "";

        if ($category == "Approval") {
            if ($sub_category == "Terkontrak") {
                switch ($category_approval) {
                    case 'Pengajuan':
                        $title = "Menunggu Persetujuan Approval Terkontrak";
                        $body = "Segera lakukan approval untuk proyek " . $proyek->nama_proyek;
                        break;
                    case 'Persetujuan':
                        switch ($status) {
                            case 'approve':
                                $title = "Proyek " . $proyek->nama_proyek . " Telah Disetujui";
                                $body = "Proyek anda berhasil disetujui.";
                                break;
                            case 'revisi':
                                $title = "Permohonan Revisi Proyek " . $proyek->name;
                                $body = "Proyek anda mohon segera direvisi.";
                        }
                        break;

                    default:
                        $title = "";
                        $body = "";
                        break;
                }
            }
        } elseif ($category == "Scheduler") {
        }

        return [$title, $body];
    }
}
