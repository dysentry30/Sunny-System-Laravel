<?php

namespace App\Http\Controllers;

use App\Events\NotificationPasswordReset;
use App\Mail\UserPasswordEmail;
use App\Models\NotificationsModel;
use App\Models\UnitKerja;
use App\Models\User;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    public function welcome()
    {
        return view('0_Welcome');
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

        // dd("gagal login");
        return back()->with('LoginError', "Login Gagal Pastikan Email dan Password Benar");
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
        $is_administrator = $request->has("administrator") ?? false;
        $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        $is_user_sales = $request->has("user-sales") ?? false;
        $is_team_proyek = $request->has("team-proyek") ?? false;

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
            Alert::error("Error", 'User berhasil ditambahkan.<br> Informasi Akun akan dikirimkan melalu email.');
            // return redirect("/user")->with("success", );
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
        $is_administrator = $request->has("administrator") ?? false;
        $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        $is_user_sales = $request->has("user-sales") ?? false;
        $is_team_proyek = $request->has("team-proyek") ?? false;

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
            Alert::success("Success", "User berhasil diperbarui.");
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
            $to_user = User::find($current_notif->from_id_user);
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
                NotificationPasswordReset::dispatch($user, "Request ganti password ditolak oleh Admin", $id_notif, $to_user);
            } else {
                NotificationPasswordReset::dispatch($user, "Request ganti password sudah disetujui oleh Admin", $id_notif, $to_user, false);
            }
        } else {
            $to_user = User::where("check_administrator", "=", "1")->get()->first();
            NotificationPasswordReset::dispatch($user, "Request ganti password untuk <b>$user->name</b>", $id_notif, $to_user, false);
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
        Alert::error("Error", "Tidak terauthorisasi dalam melakukan reset password");
        return redirect()->back();
    }

    public function userNewPasswordSave(Request $request)
    {
        $data = $request->all();
        $notif = NotificationsModel::where("token_reset_password", "=", $data["reset-password-token"])->get()->first();
        $user = User::find($notif->to_user);
        if (!empty($notif) && !empty($user)) {
            $user->password = HASH::make($data["reset-password-new"]);
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
