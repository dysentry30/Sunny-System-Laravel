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
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function welcome()
    {
        return view('0_Welcome');
    }

    public function delete ($id) 
    { 
        $id = User::find($id);
        $id->delete();
        Alert::success('Delete', $id->name.", Berhasil Dihapus");
        return redirect("/user")->with('status', 'User Deleted');   
    }


    public function authen(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials) && Auth::check()) {
            $request->session()->regenerate();

            // if request from API
            if (str_contains($request->url(), "api")) {
                $user = auth()->user();
                $token_user = $user->createToken($user->name)->plainTextToken;
                auth()->user()->forceFill([
                    "remember_token" => $token_user,
                ])->save();
                return response()->json([
                    "token" => $token_user,
                    "user" => $user,
                ]);
            }

            return redirect()->intended("/dashboard");
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

        Auth::logout();

        Request()->session()->invalidate();

        Request()->session()->regenerateToken();


        if (str_contains($request->url(), "api")) {

            return response()->json([
                "status" => "success",
                "msg" => "Logged out",
            ]);
        }

        return redirect('/');
    }

    public function save(Request $request, User $user)
    {

        $data = $request->all();
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
        ];
        $rules = [
            "name-user" => "required",
            "email" => "required",
            "phone-number" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "User Gagal Dibuat, Periksa Kembali !");
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            // return redirect()->back();
        }
        
        $validation->validate();
        $is_administrator = $request->has("administrator") ?? false;
        $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        $is_user_sales = $request->has("user-sales") ?? false;
        $is_team_proyek = $request->has("team-proyek") ?? false;
        if($is_administrator == false && $is_admin_kontrak == false && $is_user_sales == false && $is_team_proyek == false){
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            Alert::error("Error", "Pilih Hak Akses Terlebih Dahulu");
            return redirect()->back();   
        }
        // dd($is_administrator, $is_admin_kontrak, $is_user_sales, $is_team_proyek);
        $password = Str::random(20);
        $user->name = $data["name-user"];
        $user->email = $data["email"];
        $user->no_hp = $data["phone-number"];
        $user->unit_kerja = $data["unit-kerja"];
        $user->alamat = $data["alamat"];
        $user->check_administrator = $is_administrator;
        $user->check_admin_kontrak = $is_admin_kontrak;
        $user->check_user_sales = $is_user_sales;
        $user->check_team_proyek = $is_team_proyek;
        $user->password = Hash::make($password);

        if ($user->save()) {
            Mail::to($user->email)->send(new UserPasswordEmail($user, $password));
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
        return view("/User/viewUser", ["user" => $user, "unit_kerjas" => UnitKerja::all()]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
        ];
        $rules = [
            "name-user" => "required",
            "email" => "required",
            "phone-number" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "User Gagal Dibuat, Periksa Kembali !");
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            // return redirect()->back();
        }
        
        $validation->validate();
        $is_administrator = $request->has("administrator") ?? false;
        $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        $is_user_sales = $request->has("user-sales") ?? false;
        $is_team_proyek = $request->has("team-proyek") ?? false;
        if($is_administrator == false && $is_admin_kontrak == false && $is_user_sales == false && $is_team_proyek == false){
            $request->old("name-user");
            $request->old("email");
            $request->old("phone-number");
            Alert::error("Error", "Pilih Hak Akses Terlebih Dahulu");
            return redirect()->back();   
        }

        $user = User::find($data["user-id"]);
        $user->name = $data["name-user"];
        $user->email = $data["email"];
        $user->no_hp = $data["phone-number"];
        $user->unit_kerja = $data["unit-kerja"];
        $user->alamat = $data["alamat"];
        $user->check_administrator = $is_administrator;
        $user->check_admin_kontrak = $is_admin_kontrak;
        $user->check_user_sales = $is_user_sales;
        $user->check_team_proyek = $is_team_proyek;

        if ($user->save()) {
            Alert::success("Success", "User berhasil diperbarui.")->autoClose(3000);
            return redirect("/user");
        }
    }

    public function userResetPassword(Request $request)
    {
        $data = $request->all();
        // $user = User::find($data["user-id"]);
        $user = auth()->user();
        // $to_user = User::where("check_administrator", "=", "1")->get()->first();
        $is_uuid = Str::isUuid($data["id-user"]);
        if ($is_uuid) {
            $current_notif = NotificationsModel::find($data["id-user"]);
            // $socket_id_from_user = $data["socket-id"];
            $to_user = User::find($current_notif->from_id_user);
            $all_notif_related_to_user = NotificationsModel::where("from_id_user", "=", $current_notif->from_id_user)->get();
            $all_notif_related_to_user->each(function($notif) use($request, $to_user, $current_notif) {
                $user = User::find($notif->to_user);
                if ($request->is_rejected) {
                    $notif->is_rejected = true;
                    $msg = "Request ganti password ditolak oleh <b>" . $current_notif->ToUser->name . "</b>";
                    NotificationPasswordReset::dispatch($user, $msg, $notif->id_notification, $to_user, true, false);
                } else {
                    $msg = "Request ganti password disetujui oleh <b>" . $current_notif->ToUser->name . "</b>";
                    $notif->is_approved = true;
                    NotificationPasswordReset::dispatch($user, $msg, $notif->id_notification, $to_user, false, false);
                }
                $notif->message = $msg;
                $notif->save();
            });

            if ($request->is_rejected) {
                $current_notif->is_rejected = true;
            } else {
                $current_notif->is_approved = true;
            }
            $current_notif->save();
        } else {
            $to_user = User::find($data["id-user"]);
        }

        $uuid = new Uuid();
        $id_notif = $uuid->uuid3();
        if ($user->check_administrator) {

            if ($request->is_rejected) {
                NotificationPasswordReset::dispatch($user, "Request ganti password ditolak oleh <b>" . $user->name . "</b>", $id_notif, $to_user, true, true);
            } else {
                NotificationPasswordReset::dispatch($user, "Request ganti password sudah disetujui oleh <b>" . $user->name . "</b>", $id_notif, $to_user, false, true);
            }
        } else {
            $to_user = User::where("check_administrator", "=", "1")->get();
            $to_user->each(function($admin_user) use($uuid, $user) {
                $id_notif = $uuid->uuid3();
                NotificationPasswordReset::dispatch($user, "Request ganti password untuk <b>$user->name</b>", $id_notif, $admin_user, false);
            });
        }
        Alert::success("Success", "Request ganti password berhasil, silahkan tunggu hingga admin menyetujui");
        return redirect()->back();
    }

    public function userNewPassword(Request $request)
    {
        if ($request->getMethod() == "GET") {
            Alert::error("Error", "Tidak bisa mengakses halaman ini");
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

    public function requestLockAnswer(Request $request) {
        $data = $request->all();
        if(Str::length($data["next_user"]) < 2) {
            $to_user = $data["next_user"];
        } else {
            $next_user = explode(",", $data["next_user"]);
            $to_user = array_splice($next_user, 0, 1)[0];
        }
        // array splice return array jadi harus dikasih index 0 biar dapet value di index pertama #303

        $to_user = User::find((int) $to_user);
        $from_user = User::find($data["from_user"]);

        if(isset($data["is_approved"])) {
            $is_approved = true;
        } else {
            $is_rejected = true;
        }
        if(isset($data["is_rejected"]) && $data["is_rejected"]) {
            $to_user = User::find($data["from_user"]);
            $from_user = User::find($data["next_user"]);
            $unit_kerja = $from_user->UnitKerja;
            LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast tidak disetujui oleh unit <b>" . $unit_kerja->unit_kerja . "</b>", [], false, $is_rejected);
            return;
        }
        if($to_user->check_administrator == 1) {
            $unit_kerja = $from_user->UnitKerja;
            LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast sudah disetujui oleh unit <b>" . $unit_kerja->unit_kerja . "</b>", [], $is_approved ?? false, $is_rejected ?? false);
            return;
        }
        LockForeacastEvent::dispatch($from_user, $to_user, "Request Lock Forecast", $next_user, false, false);
        // $from_user = 
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
