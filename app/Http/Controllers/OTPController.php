<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class OTPController extends Controller
{
    protected $max_attempt_resend_code = 3;

    public function index(Request $request, User $user) {
        $data = $request->all();
        $max_attempt_resend_code = $this->max_attempt_resend_code;
        return view("otpPage/otp", compact(["user", "data", "max_attempt_resend_code"]));
        // return errorPage(403, "Link Expired", "Oops! This link has expired", "Please resend new link to continue this action!", true, "/resend-otp", "Resend OTP", $user);
    }

    public function validateOTP($otp, User $user) {
        if(!empty($user->otp)) {
            $data_otp = json_decode($user->otp);
            if($data_otp->otp == $otp) {
                $user->otp = null;
                if($user->save()) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    public function send_otp(Request $request) {
        $data = $request->all();
        $user = User::where("nip", "=", $data["user"])->get()->first();
        $otp = random_int(100000, 999999);
        $user->otp = json_encode(["otp" => $otp, "send_otp_counter" => 1]);
        $user->save();
        $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            "api_key" => "c15978155a6b4656c4c0276c5adbb5917eb033d5",
            "sender" => "62811881227",
            // "number" => "085157875773",
            "number" => "085156341949",
            "message" => "Yth Bapak/Ibu *$user->name*\n\n*$otp*\n\nadalah kode OTP anda. Silahkan masukan kode tersebut untuk melanjutkan approval.\n.\n\nTerimakasih 🙏🏻",
            // "url" => $url
        ]);

        $send_msg_to_wa->onError(function ($error) {
            // dd($error);
            Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            return redirect()->back();
        });
        return redirect()->back()->with(["user" => $user->nip]);
    }

    public function resend_otp(Request $request) {
        $data = $request->all();
        $user = User::where("nip", "=", $data["user"])->get()->first();
        $otp = random_int(100000, 999999);
        $data_otp = json_decode($user->otp);
        $send_otp_counter = ++$data_otp->send_otp_counter;
        $user->otp = json_encode(["otp" => $otp, "send_otp_counter" => $send_otp_counter]);
        $user->save();
        $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            "api_key" => "c15978155a6b4656c4c0276c5adbb5917eb033d5",
            "sender" => "62811881227",
            // "number" => "085157875773",
            "number" => "085156341949",
            "message" => "Yth Bapak/Ibu *$user->name*\n\n*$otp*\n\nadalah kode OTP anda. Silahkan masukan kode tersebut untuk melanjutkan approval.\n.\n\nTerimakasih 🙏🏻",
            // "url" => $url
        ]);

        $send_msg_to_wa->onError(function ($error) {
            // dd($error);
            Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            return redirect()->back();
        });
        return redirect()->back()->with(["user" => $user->nip]);
    }
}
