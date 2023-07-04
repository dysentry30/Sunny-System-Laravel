<?php

namespace App\Http\Controllers;

use App\Events\LockForeacastEvent;
use App\Models\User;
use Faker\Core\Uuid;
use App\Models\UnitKerja;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserPasswordEmail;
use App\Models\NotificationsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Events\NotificationPasswordReset;
use App\Models\Dop;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function welcome(Request $request)
    {
        $data = $request->all();
        if(!empty($data["redirectTo"]) && !empty($data["token"])) {
            try{
                $credentials = (array) json_decode(decrypt($data["token"]));
                $user = User::where("email", $credentials["email"])->first();
                if(Auth::loginUsingId($user->id)) {
                    return redirect($data["redirectTo"]);
                }
                Alert::error("Error", "User Tidak Ditemukan!");
                return redirect("/");
            }catch(Exception $e) {
                Alert::error("Error", "User Tidak Ditemukan!");
                return redirect("/");
            }
        }
        return view('0_Welcome');
    }

    public function delete($id)
    {
        $id = User::find($id);
        $id->delete();
        Alert::success('Delete', $id->name . ", Berhasil Dihapus");
        return redirect("/user")->with('status', 'User Deleted');
    }


    public function authen(Request $request)
    {
        if (str_contains($request->url(), "api")) {
            // $request->email = $request->UserName;
            // $request->password = $request->UserPassword;
            $credentials = $request->validate([
                'UserName' => ["required", "email"],
                'UserPassword' => ["required"]
            ]);
            $token = STR::random(50);
            $data = [
                'email' => $request->UserName,
                'password' => $request->UserPassword
            ];
            if (Auth::attempt($data)) {
                $user = auth()->user();
                $token_user = $user->createToken($user->name)->plainTextToken;
                // dd($token_user);
                auth()->user()->forceFill([
                    "remember_token" => $token_user,
                ])->save();
                return response()->json([
                    "token" => $token_user,
                    "user" => $user,
                ])->cookie("BPMCSRF", $token, 60);
            }
        } else {
            
            $credentials = $request->validate([
                'email' => ["required"],
                'password' => ["required"]
            ]);
            if($request->ajax()) {
                // if(Auth::check()) Auth::logout();
                $user = User::where("email", "=", $request->email)->first();
                if(!empty($user) && Hash::check($request->password, $user->password)) {
                    return response()->json(["is_success" => true]);
                }
                // return abort(401, "Unauthorized");
                return response()->json(["is_success" => false]);
            }
            if (Auth::attempt($credentials) && Auth::check()) {
                // dd(Auth::user());
                $request->session()->regenerate();
                if (!str_contains(Auth::user()->email, "@wika-customer")) {
                    if (Auth::user()->is_active) {
                        $redirect = $request->schemeAndHttpHost() . $request->get("redirect-to");
                        if(!empty($redirect)) {
                            return redirect()->intended( $redirect );
                        }
                        return redirect()->intended("/dashboard");
                    }else{
                        Auth::logout();
                        Alert::error("USER NON ACTIVE", "Hubungi Admin (PIC)");
                        return redirect()->intended("/");
                    }
                } else {
                    // Alert::success('Selamat Datang', "Silahkan Mengisi Survey Berikut");
                    return redirect()->intended("/csi/customer-survey");
                }
            }
        }
        Alert::error("Login Gagal", "Pastikan Email dan Password Benar");
        // dd("gagal login");
        return back();
    }
    
    public function logout(Request $request)
    {
        auth()->user()->forceFill([
            "remember_token" => null,
        ])->save();

        
        Request()->session()->invalidate();
        
        Request()->session()->regenerateToken();
        

        if (str_contains($request->url(), "api")) {

            return response()->json([
                "status" => "success",
                "msg" => "Logged out",
            ]);
        }

        if (auth()->user()->check_admin_kontrak) {
            Auth::logout();
            return redirect('/ccm');
        } else {
            Auth::logout();
            return redirect('/');
        }
    }

    public function save(Request $request, User $user)
    {

        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "This field is required",
            "accepted" => "This field is required",
        ];
        $rules = [
            "nip" => "required",
            "name-user" => "required",
            "email" => "required",
            "phone-number" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);

        $is_administrator = $request->has("administrator") ?? false;
        $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        $is_user_sales = $request->has("user-sales") ?? false;
        $is_team_proyek = $request->has("team-proyek") ?? false;
        
        
        if ($is_administrator == false && $is_admin_kontrak == false && $is_user_sales == false && $is_team_proyek == false) {
            $rules["administrator"] = "accepted";
            $rules["admin-kontrak"] = "accepted";
            $rules["user-sales"] = "accepted";
            $rules["team-proyek"] = "accepted";
            
            Alert::error("Error", "Pilih Hak Akses Terlebih Dahulu");
            $request->old("nip");
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            // dd("tes");
            
            if ($validation->fails()) {
                $request->old("nip");
                $request->old("name-user");
                $request->old("email");
                $request->old("phone-number");
                // return redirect()->back();
                
                Alert::error('Error', "User Gagal Dibuat, Periksa Kembali !");
                $validation->validate();
                
                // return redirect()->back();
            }
            
            $validation = Validator::make($data, $rules, $messages);
            $validation->validate();
        }
        
        
        // dd($is_administrator, $is_admin_kontrak, $is_user_sales, $is_team_proyek);
        // $password = Str::random(20);
        $user->nip = $data["nip"];
        // dd($data["nip"]);
        $user->name = $data["name-user"];
        $user->email = $data["email"];
        $user->no_hp = $data["phone-number"];
        $user->unit_kerja = $data["unit-kerja"];
        // $user->alamat = $data["alamat"];
        $user->check_administrator = $is_administrator;
        $user->check_admin_kontrak = $is_admin_kontrak;
        $user->check_user_sales = $is_user_sales;
        $user->check_team_proyek = $is_team_proyek;
        // $user->password = Hash::make($password);
        $user->password = Hash::make("password");

        if ($user->save()) {
            // Mail::to($user->email)->send(new UserPasswordEmail($user, $password));
            Alert::success("Success", 'User berhasil ditambahkan. Informasi Akun akan dikirimkan melalu email.');
            return redirect("/user");
        }
    }

    public function view($user)
    {
        $user = User::find($user);
        if (empty($user)) {
            Alert::error("Error", "User tidak ditemukan");
            return redirect("user");
        }
        return view("/User/viewUser", ["user" => $user, "unit_kerjas" => UnitKerja::all(), "dops" => Dop::with("UnitKerjas")->get()->sortBy("dop")]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nip" => "required",
            "name-user" => "required",
            "email" => "required",
            "phone-number" => "required",
            "upload-ttd" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);

        $is_administrator = $request->has("administrator") ?? false;
        $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        $is_user_sales = $request->has("user-sales") ?? false;
        $is_team_proyek = $request->has("team-proyek") ?? false;


        if ($validation->fails()) {
            $request->old("nip");
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            // return redirect()->back();

            Alert::error('Error', "User Gagal Dibuat, Periksa Kembali !");

            $validation->validate();
            // return redirect()->back();
        }

        if ($is_administrator == false && $is_admin_kontrak == false && $is_user_sales == false && $is_team_proyek == false) {
            $rules["administrator"] = "accepted";
            $rules["admin-kontrak"] = "accepted";
            $rules["user-sales"] = "accepted";
            $rules["team-proyek"] = "accepted";

            Alert::error("Error", "Pilih Hak Akses Terlebih Dahulu");
            $request->old("nip");
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            // dd("tes");

            $validation = Validator::make($data, $rules, $messages);
            $validation->validate();
        }

        // // loading the source image
        // // $src = imagecreatetruecolor(150, 150);
        // // $color = imagecolorat($src, 0, 0);
        // // $hex = dechex($color);
        
        // // dd($hex);
        // $white = imagecolorallocatealpha($src, 255, 255, 255, 127);
        // $_transColor = imagecolortransparent($src, $white);
        // imagefill($src, 0, 0, $_transColor);
        // // saving the image to public folder
        // $file_name = "tanda-tangan-" . $data["nip"] . "." . "png";
        // imagesavealpha($src, true);
        
        // $file_name = "tanda-tangan-" . $data["nip"] . "." . $data["upload-ttd"]->clientExtension();
        // $src = imagecreatefromjpeg($data["upload-ttd"]);
        // $new = imagescale($src,100);

        // imagejpeg($new, public_path("/file-ttd/$file_name"), 100);
        // $data["upload-ttd"]->storeAs("/", $file_name, ["disk" => "public/ttd"]);

        $user = User::find($data["user-id"]);
        $user->nip = $data["nip"];
        $user->name = $data["name-user"];
        $user->email = $data["email"];
        $user->no_hp = $data["phone-number"];
        // $user->file_ttd = $file_name;
        $user->is_active = $request->has("is-active");
        // if (!Auth::user()->check_administrator) {
        if (str_contains($user->email, "@wika-customer")) {
            $user->unit_kerja = null;
        } else {
            $user->unit_kerja = count($data["unit-kerja"]) > 1 ? join(",", $data["unit-kerja"]) : $data["unit-kerja"][0];
        }
        
        // }
        $user->check_administrator = $is_administrator;
        $user->check_admin_kontrak = $is_admin_kontrak;
        $user->check_user_sales = $is_user_sales;
        $user->check_team_proyek = $is_team_proyek;
        // $user->alamat = $data["alamat"];
        
        if ($user->save()) {
            Alert::success("Success", "User berhasil diperbarui.")->autoClose(3000);
            return redirect()->back();
        }
    }

    public function userResetPassword(Request $request)
    {
        $data = $request->all();
        if($data["new-password"] == $data["confirm-password"]) {
            $user = User::find($data["id-user"]);
            $user->password = Hash::make($data["new-password"]);
            if($user->save()) {
                Alert::success("Success", "Ganti Password berhasil");
                return redirect()->back();
            }
            Alert::error("Error", "Ganti Password gagal!");
            return redirect()->back();
        }
        Alert::error("Error", "New Password dan Confirm Password tidak sama!");
        return redirect()->back();
        

        // BEGIN :: RESET PASSWORD USING APPROVAL
        // // $to_user = User::where("check_administrator", "=", "1")->get()->first();
        // $is_uuid = Str::isUuid($data["id-user"]);
        // if ($is_uuid) {
        //     $current_notif = NotificationsModel::find($data["id-user"]);
        //     // $socket_id_from_user = $data["socket-id"];
        //     $to_user = User::find($current_notif->from_id_user);
        //     $all_notif_related_to_user = NotificationsModel::where("from_id_user", "=", $current_notif->from_id_user)->get();
        //     $all_notif_related_to_user->each(function ($notif) use ($request, $to_user, $current_notif) {
        //         $user = User::find($notif->to_user);
        //         if ($request->is_rejected) {
        //             $notif->is_rejected = true;
        //             $msg = "Request ganti password ditolak oleh <b>" . $current_notif->ToUser->name . "</b>";
        //             NotificationPasswordReset::dispatch($user, $msg, $notif->id_notification, $to_user, true, false);
        //         } else {
        //             $msg = "Request ganti password disetujui oleh <b>" . $current_notif->ToUser->name . "</b>";
        //             $notif->is_approved = true;
        //             NotificationPasswordReset::dispatch($user, $msg, $notif->id_notification, $to_user, false, false);
        //         }
        //         $notif->message = $msg;
        //         $notif->save();
        //     });

        //     if ($request->is_rejected) {
        //         $current_notif->is_rejected = true;
        //     } else {
        //         $current_notif->is_approved = true;
        //     }
        //     $current_notif->save();
        // } else {
        //     $to_user = User::find($data["id-user"]);
        // }

        // $uuid = new Uuid();
        // $id_notif = $uuid->uuid3();
        // if ($user->check_administrator) {

        //     if ($request->is_rejected) {
        //         NotificationPasswordReset::dispatch($user, "Request ganti password ditolak oleh <b>" . $user->name . "</b>", $id_notif, $to_user, true, true);
        //     } else {
        //         NotificationPasswordReset::dispatch($user, "Request ganti password sudah disetujui oleh <b>" . $user->name . "</b>", $id_notif, $to_user, false, true);
        //     }
        // } else {
        //     $to_user = User::where("check_administrator", "=", "1")->get();
        //     $to_user->each(function ($admin_user) use ($uuid, $user) {
        //         $id_notif = $uuid->uuid3();
        //         NotificationPasswordReset::dispatch($user, "Request ganti password untuk <b>$user->name</b>", $id_notif, $admin_user, false);
        //     });
        // }
        // END :: RESET PASSWORD USING APPROVAL
        
    }

    public function userNewPassword(Request $request)
    {
        if ($request->getMethod() == "GET") {
            Alert::error("Error", "Tidak bisa mengakses halaman ini. Pastikan Reset Password sudah di Approved oleh Admin");
            return redirect()->back();
        }
        $data = $request->all();
        $notification = NotificationsModel::find($data["id-notification"]);
        if (!empty($notification->token_reset_password) && $notification->is_approved) {
            return view("User/createUserPassword", ["reset_password_token" => $notification->token_reset_password]);
        }
        Alert::error("Error", "Tidak terauthorisasi untuk melakukan reset password");
        return redirect()->back();
    }

    public function userNewPasswordSave(Request $request)
    {
        $data = $request->all();
        $notif = NotificationsModel::where("token_reset_password", "=", $data["reset-password-token"])->get()->first();
        $user = User::find($notif->to_user);
        if (!empty($notif) && !empty($user)) {
            $user->password = Hash::make($data["reset-password-new"]);
            $notif->token_reset_password = null;
            $notif->is_approved = false;
            if ($user->save() && $notif->save()) {
                Alert::success("Success", "Password anda berhasil diperbarui");
                return redirect("/user/view/" . $user->id);
            }
            Alert::success("Error", "Maaf, telah terjadi kesalahan pada sistem");
            return redirect("/user/view/" . $user->id);
        }
    }

    public function requestLockAnswer(Request $request)
    {
        $data = $request->all();
        if (Str::length($data["next_user"]) < 2) {
            $to_user = $data["next_user"];
        } else {
            $next_user = explode(",", $data["next_user"]);
            $to_user = array_splice($next_user, 0, 1)[0];
        }
        // array splice return array jadi harus dikasih index 0 biar dapet value di index pertama #303

        $to_user = User::find((int) $to_user);
        $from_user = User::find($data["from_user"]);

        if (isset($data["is_approved"])) {
            $is_approved = true;
        } else {
            $is_rejected = true;
        }
        if (isset($data["is_rejected"]) && $data["is_rejected"]) {
            $to_user = User::find($data["from_user"]);
            $from_user = User::find($data["next_user"]);
            $unit_kerja = $from_user->UnitKerja;
            LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast tidak disetujui oleh unit <b>" . $unit_kerja->unit_kerja . "</b>", [], false, $is_rejected);
            return;
        }
        if ($to_user->check_administrator == 1 && $is_approved) {
            $unit_kerja = $from_user->UnitKerja;
            LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast sudah disetujui oleh unit <b>" . $unit_kerja->unit_kerja . "</b>", [], $is_approved ?? false, $is_rejected ?? false);
            return;
        }
        LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast", $next_user, false, false);
        // $from_user = 
    }

    public function requestUnlockAnswer(Request $request)
    {
        $data = $request->all();
        if (Str::length($data["next_user"]) < 2) {
            $to_user = $data["next_user"];
        } else {
            $next_user = explode(",", $data["next_user"]);
            $to_user = array_splice($next_user, 0, 1)[0];
        }
        // array splice return array jadi harus dikasih index 0 biar dapet value di index pertama

        $to_user = User::find((int) $to_user);
        $from_user = User::find($data["from_user"]);

        if (isset($data["is_approved"])) {
            $is_approved = true;
        } else {
            $is_rejected = true;
        }
        if (isset($data["is_rejected"]) && $data["is_rejected"]) {
            $to_user = User::find($data["from_user"]);
            $from_user = User::find($data["next_user"]);
            $unit_kerja = $from_user->UnitKerja;
            LockForeacastEvent::dispatch($from_user, $to_user, "Request Unlock Forecast tidak disetujui oleh unit <b>" . $unit_kerja->unit_kerja . "</b>", [], false, $is_rejected);
            return;
        }
        if ($to_user->check_administrator == 1 && $is_approved) {
            $unit_kerja = $from_user->UnitKerja;
            LockForeacastEvent::dispatch($from_user, $to_user, "Request Unlock Forecast sudah disetujui oleh unit <b>" . $unit_kerja->unit_kerja . "</b>", [], $is_approved ?? false, $is_rejected ?? false);
            return;
        }
        LockForeacastEvent::dispatch($from_user, $to_user, "Request Unlock Forecast", $next_user, false, false);
        // $from_user = 
    }

    public function checkCurrentPassword(Request $request) {
        $user = User::find($request->id_user);
        if(Hash::check(trim($request->password), $user->password)) {
            return response()->json([
                "status" => "success",
                "msg" => "Password sesuai"
            ]);
        }
        return response()->json([
            "status" => "error",
            "msg" => "Password tidak sesuai"
        ]);
    }

    public function TestingWebsocket(Request $request) {
        dump($request->all());
    }

    // public function createUser()
    // {
    //     $user = new User;
    //     $user->name = 'admin';
    //     $user->email = 'admin@sunny.com';
    //     $user->password = Hash::make('admin@sunny.com');

    //     if ( ! ($user->save()))
    //     {
    //         dd('user is not being saved to database properly - this is the problem');          
    //     }

    //     if ( ! (Hash::check('123456', Hash::make('123456'))))
    //     {
    //         dd('hashing of password is not working correctly - this is the problem');          
    //     }

    //     if ( ! (Auth::attempt(array('email' => 'joe@gmail.com', 'password' => '123456'))))
    //     {
    //         dd('storage of user password is not working correctly - this is the problem');          
    //     }

    //     else
    //     {
    //         dd('everything is working when the correct data is supplied - so the problem is related to your forms and the data being passed to the function');
    //     }
    // }


}
