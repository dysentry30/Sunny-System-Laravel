<?php

namespace App\Http\Controllers;

use stdClass;
use Exception;
use App\Models\Dop;
use App\Models\User;
use Faker\Core\Uuid;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\MasterMenu;
use Illuminate\Support\Str;
use App\Models\ProyekPISNew;
use Illuminate\Http\Request;
use App\Models\MenuManagement;
use App\Mail\UserPasswordEmail;
use App\Models\RoleManagements;
use App\Models\MasterApplication;
use Illuminate\Http\UploadedFile;
use App\Events\LockForeacastEvent;
use App\Models\NotificationsModel;
use App\Models\UserMenuManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Events\NotificationPasswordReset;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function welcomeAdmin(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if (!empty($data["redirectTo"]) && !empty($data["nip"])) {
            try {
                // $credentials = (array) json_decode(decrypt($data["token"]));
                $user = User::where("nip", $data["nip"])->first();
                if (Auth::loginUsingId($user->id)) {
                    return redirect($data["redirectTo"]);
                }
                Alert::error("Error", "User Tidak Ditemukan!");
                return redirect("/");
            } catch (Exception $e) {
                Alert::error("Error", "User Tidak Ditemukan!");
                return redirect("/");
            }
        } elseif (Auth::check()) {
            return redirect('/dashboard');
        } else {
            return view('0_Welcome');
            // return redirect(env('WZONE_URL'));
        }
        // return redirect('/dashboard');
    }

    public function welcome(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if (!empty($data["redirectTo"]) && !empty($data["nip"])) {
            try {
                // $credentials = (array) json_decode(decrypt($data["token"]));
                $user = User::where("nip", $data["nip"])->first();
                if (Auth::loginUsingId($user->id)) {
                    return redirect($data["redirectTo"]);
                }
                Alert::error("Error", "User Tidak Ditemukan!");
                return redirect("/");
            } catch (Exception $e) {
                Alert::error("Error", "User Tidak Ditemukan!");
                return redirect("/");
            }
        } elseif (Auth::check()) {
            return redirect('/dashboard');
        } elseif ($request->getRequestUri() == "/csi-login" || $request->getRequestUri() == "/login-admin") {
            return view('0_Welcome');
        } else {
            return redirect(env('WZONE_URL'));
        }
        return redirect('/dashboard');
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
        if (str_contains($request->url(), "api") && !$request->isMobile) {
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
        } else if ((bool) $request->isMobile) {
            return self::loginForMobile($request);
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

                if (!Gate::allows('user-csi')) {
                    $redirect = $request->schemeAndHttpHost() . $request->get("redirect-to");
                    if (!empty($redirect)) {
                        return redirect()->intended($redirect);
                    }

                    $path = Auth::user()->UserMenuManagement?->map(function ($userMenu) {
                        return $userMenu->MasterMenu;
                    })?->sortBy("urutan")?->first()->path;

                    if (!empty($redirect)) {
                        return redirect()->intended($redirect);
                    }

                    return redirect()->intended($path);
                } else {
                    return redirect()->intended("/csi/customer-survey");
                }


                // if (!Gate::allows('user-csi')) {
                //     if (Auth::user()->is_active) {
                //         if (!Gate::allows("user-scm")) {
                //             $redirect = $request->schemeAndHttpHost() . $request->get("redirect-to");
                //             if (!empty($redirect)) {
                //                 return redirect()->intended($redirect);
                //             }
                //             return redirect()->intended("/dashboard");
                //         } else {
                //             return redirect()->intended("/proyek");
                //         }
                //     } else {
                //         Auth::logout();
                //         Alert::error("USER NON ACTIVE", "Hubungi Admin (PIC)");
                //         return redirect()->intended("/");
                //     }
                // } else {
                //     // Alert::success('Selamat Datang', "Silahkan Mengisi Survey Berikut");
                //     return redirect()->intended("/csi/customer-survey");
                // }
            }
        }
        Alert::error("Login Gagal", "Pastikan Email dan Password Benar");
        // dd("gagal login");
        return back();
    }

    public function authenNew(Request $request)
    {
        $data = $request->all();
        $nip = $data['email'] ?? null;

        if (empty($nip)) {
            Alert::error('Error', 'Mohon masukkan NIP');
            return redirect()->back();
        }

        if (str_contains($nip, '@')) {
            $credentials = $request->validate([
                'email' => ["required"],
                'password' => ["required"]
            ]);
            if (Auth::guard('web')->attempt($credentials) && Auth::check()) {
                $request->session()->regenerate();
                if (!str_contains(Auth::user()->email, "@wika-customer")) {
                    if (Auth::user()->is_active) {
                        $redirect = $request->schemeAndHttpHost() . $request->get("redirect-to");
                        if (!empty($redirect)) {
                            return redirect()->intended($redirect);
                        }
                        return redirect()->intended("/dashboard");
                    } else {
                        Auth::logout();
                        Alert::error("USER NON ACTIVE", "Hubungi Admin (PIC)");
                        return redirect()->intended("/");
                    }
                } else {
                    // Alert::success('Selamat Datang', "Silahkan Mengisi Survey Berikut");
                    return redirect()->intended("/csi/customer-survey");
                }
            }
            Alert::error('LOGIN FAILED', 'Anda tidak bisa login');
            return redirect()->back();
        } else {
            $user = Auth::getProvider()->retrieveByCredentials([
                'nama_pegawai' => $nip
            ]);
            // $user = RoleManagements::find($nip);
            Auth::login($user);
            if (Auth::check()) {
                // $user = Auth::user()->User;
                if (Auth::user()->is_active) {
                    // Auth::guard('web')->attempt(['email' => $user->email, 'password' => 'password']);
                    Auth::guard('role')->setUser(Auth::user());
                    return redirect()->intended("/dashboard");
                } else {
                    Auth::logout();
                    Alert::error("USER NON ACTIVE", "Hubungi Admin (PIC)");
                    return redirect()->intended("/");
                }
            }
        }
    }

    function loginForMobile(Request $request)
    {
        $data = $request->all();
        $user = User::select(["*"])->where("email", "=", $data["UserName"])->get()->first();
        if (!empty($user) && Hash::check($data["UserPassword"], $user->password)) {
            return response()->json($user);
        }
        return response()->json("Gagal");
    }

    public function logoutOld(Request $request)
    {
        // auth()->user()->forceFill([
        //     "remember_token" => null,
        // ])->save();

        
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

    public function saveRole(Request $request, User $user)
    {
        $data = $request->all();
        $messages = [
            "required" => "This field is required",
            "accepted" => "This field is required",
        ];
        $rules = [
            "nip" => "required",
            "aplikasi.*" => "required"
        ];

        $validation = Validator::make($data, $rules, $messages);

        // $is_administrator = $request->has("administrator") ?? false;
        // $is_admin_kontrak = $request->has("admin-kontrak") ?? false;
        // $is_user_sales = $request->has("user-sales") ?? false;
        // $is_user_csi = $request->has("user-csi") ?? false;
        // $is_team_proyek = $request->has("team-proyek") ?? false;
        // $is_user_mobile = $request->has("mobile") ?? false;
        // $is_user_ska_skt = $request->has("ska-skt") ?? false;

        // if ($is_administrator == false && $is_admin_kontrak == false && $is_user_sales == false && $is_user_csi == false && $is_team_proyek == false && $is_user_mobile == false && $is_user_ska_skt == false) {
        //     $rules["administrator"] = "accepted";
        //     $rules["admin-kontrak"] = "accepted";
        //     $rules["user-sales"] = "accepted";
        //     $rules["user-csi"] = "accepted";
        //     $rules["team-proyek"] = "accepted";
        //     $rules["mobile"] = "accepted";
        //     $rules["ska-skt"] = "accepted";

        //     $validation = Validator::make($data, $rules, $messages);
        //     if ($validation->fails()) {
        //         Alert::error("Error", "Pilih Hak Akses Terlebih Dahulu");
        //         $validation->validate();
        //     }
        // }

        $is_administrator = false;
        $is_admin_kontrak = false;
        $is_user_sales = false;
        $is_user_csi = false;
        $is_user_mobile = false;
        $is_user_4eyes = false;

        // Loop aplikasi yang dipilih
        foreach ($data['aplikasi'] as $aplikasi) {
            switch ($aplikasi) {
                case 'SUPER':
                    $is_administrator = true;
                    break;
                case 'CRM':
                    $is_user_sales = true;
                    break;
                case 'CCM':
                    $is_admin_kontrak = true;
                    break;
                case 'CSI':
                    $is_user_csi = true;
                    break;
                case 'MOB':
                    $is_user_mobile = true;
                    break;
                case 'NR':
                    $is_user_4eyes = true;
                    break;
            }
        }

        $pegawai_selected = Pegawai::where('nip', $data['nip'])->first();

        $user->nip = $pegawai_selected->nip;
        // dd($data["nip"]);
        $user->name = $pegawai_selected->nama_pegawai;
        $user->email = $pegawai_selected->email;
        $user->no_hp = $pegawai_selected->handphone;
        $user->unit_kerja = $data["unit-kerja"];
        $user->check_administrator = $is_administrator;
        $user->check_admin_kontrak = $is_admin_kontrak;
        $user->check_user_sales = $is_user_sales;
        $user->check_user_csi = $is_user_csi;
        $user->check_user_mobile = $is_user_mobile;
        $user->is_user_4eyes = $is_user_4eyes;
        // $user->check_team_proyek = $is_team_proyek;
        // $user->check_user_ska_skt = $is_user_ska_skt;
        $user->password = Hash::make("password");

        if ($user->save()) {
            // Mail::to($user->email)->send(new UserPasswordEmail($user, $password));
            Alert::success("Success", 'User berhasil ditambahkan. Informasi Akun akan dikirimkan melalu email.');
            return redirect("/user");
        }
    }

    public function viewOld($user)
    {
        $user = User::find($user);

        if (empty($user)) {
            Alert::error("Error", "User tidak ditemukan");
            return redirect("user");
        }

        $collectMenu = MasterMenu::all()->groupBy("kode_parrent")->sortBy(function ($item, $key) {
            return $key;
        })->map(function ($item) {
            return $item->sortBy("urutan");
        })->flatten();

        $collectAplikasi = MasterApplication::all();

        $userManagementSelected = UserMenuManagement::where("nip", $user->nip)->get();

        $menuSelected = collect([]);

        $menuManagement = MenuManagement::all();

        if ($user->check_administrator) {
            $menuSelected = $collectMenu;
        }

        if ($user->check_user_sales) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "CRM");
            // if ($userManagementSelected->isNotEmpty() && $menuFilter->isNotEmpty()) {
            //     $userManagementSelected->each(function ($ums) use ($menuFilter, $menuSelected) {
            //         $checkMenuFromTemplate = $menuFilter->where("kode_aplikasi", $ums->aplikasi)?->where("kode_menu", $ums->menu);
            //         if (!empty($checkMenuFromTemplate)) {
            //             $menuSelected->push($checkMenuFromTemplate);
            //         }
            //     });
            // } else {
            //     $menuSelected->push($menuFilter);
            // }
            $menuSelected->push($menuFilter);
        }

        if ($user->check_admin_kontrak) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "CCM");
            // if ($userManagementSelected->isNotEmpty() && $menuFilter->isNotEmpty()) {
            //     $userManagementSelected->each(function ($ums) use ($menuFilter, $menuSelected) {
            //         $checkMenuFromTemplate = $menuFilter->where("kode_aplikasi", $ums->aplikasi)?->where("kode_menu", $ums->menu);
            //         if (!empty($checkMenuFromTemplate)) {
            //             $menuSelected->push($checkMenuFromTemplate);
            //         }
            //     });
            // } else {
            //     $menuSelected->push($menuFilter);
            // }
            $menuSelected->push($menuFilter);
        }

        if ($user->check_user_csi) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "CSI");
            // if ($userManagementSelected->isNotEmpty() && $menuFilter->isNotEmpty()) {
            //     $userManagementSelected->each(function ($ums) use ($menuFilter, $menuSelected) {
            //         $checkMenuFromTemplate = $menuFilter->where("kode_aplikasi", $ums->aplikasi)?->where("kode_menu", $ums->menu);
            //         if (!empty($checkMenuFromTemplate)) {
            //             $menuSelected->push($checkMenuFromTemplate);
            //         }
            //     });
            // } else {
            //     $menuSelected->push($menuFilter);
            // }
            $menuSelected->push($menuFilter);
        }

        if ($user->check_user_mobile) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "MOB");
            // if ($userManagementSelected->isNotEmpty() && $menuFilter->isNotEmpty()) {
            //     $userManagementSelected->each(function ($ums) use ($menuFilter, $menuSelected) {
            //         $checkMenuFromTemplate = $menuFilter->where("kode_aplikasi", $ums->aplikasi)?->where("kode_menu", $ums->menu);
            //         if (!empty($checkMenuFromTemplate)) {
            //             $menuSelected->push($checkMenuFromTemplate);
            //         }
            //     });
            // } else {
            //     $menuSelected->push($menuFilter);
            // }
            $menuSelected->push($menuFilter);
        }

        if ($user->is_user_4eyes) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "NR");
            // if ($userManagementSelected->isNotEmpty() && $menuFilter->isNotEmpty()) {
            //     $userManagementSelected->each(function ($ums) use ($menuFilter, $menuSelected) {
            //         $checkMenuFromTemplate = $menuFilter->where("kode_aplikasi", $ums->aplikasi)?->where("kode_menu", $ums->menu);
            //         if (!empty($checkMenuFromTemplate)) {
            //             $menuSelected->push($checkMenuFromTemplate);
            //         }
            //     });
            // } else {
            //     $menuSelected->push($menuFilter);
            // }
            $menuSelected->push($menuFilter);
        }

        $menuSelected?->flatten()?->each(function ($item) use ($user, $userManagementSelected) {
            $existingMenu = $userManagementSelected->where('aplikasi', $item->kode_aplikasi)->where('menu', $item->kode_menu)->first();

            // Jika menu tidak ada, tambahkan dengan default akses
            if (is_null($existingMenu)) {
                $newClass = new stdClass();
                $newClass->nip = $user->nip;
                $newClass->aplikasi = $item->kode_aplikasi;
                $newClass->menu = $item->kode_menu;
                $newClass->create = true;
                $newClass->read = true;
                $newClass->update = true;
                $newClass->delete = false;
                $newClass->lock = false;
                $newClass->approve = false;

                $userManagementSelected->push($newClass);
            } else {
                // Jika menu sudah ada, sesuaikan apakah akan dihapus atau tidak
                // Misalnya jika `delete` adalah true, kita set akses menu sesuai kebutuhan
                if ($existingMenu->delete) {
                    // Hapus akses menu
                    $userManagementSelected = $userManagementSelected->filter(function ($ums) use ($item) {
                        return !($ums->aplikasi === $item->kode_aplikasi && $ums->menu === $item->kode_menu);
                    })->values();
                } else {
                    // Update akses jika tidak dihapus
                    $existingMenu->create = true;  // Sesuaikan logika sesuai kebutuhan
                    $existingMenu->read = true;
                    $existingMenu->update = true;
                    $existingMenu->delete = false;  // Contoh jika delete tetap false
                    // Update the object in the collection
                    $userManagementSelected = $userManagementSelected->map(function ($ums) use ($existingMenu) {
                        return ($ums->aplikasi === $existingMenu->aplikasi && $ums->menu === $existingMenu->menu) ? $existingMenu : $ums;
                    });
                }
            }
        });

        $userManagementSelected = $userManagementSelected->unique("menu")->values();
        // dd($userManagementSelected);

        // $userManagementSelectedNew = $userManagementSelected-


        return view("/User/viewUser", ["user" => $user, "unit_kerjas" => UnitKerja::all(), "dops" => Dop::with("UnitKerjas")->get()->sortBy("dop"), 'collectMenu' => $collectMenu, 'userManagementSelected' => $userManagementSelected, 'menuSelected' => $menuSelected?->flatten(), 'collectAplikasi' => $collectAplikasi]);
    }

    public function view($user)
    {
        $user = User::find($user);

        if (empty($user)) {
            Alert::error("Error", "User tidak ditemukan");
            return redirect("user");
        }

        $collectMenu = MasterMenu::all()->groupBy("kode_parrent")->sortBy(function ($item, $key) {
            return $key;
        })->map(function ($item) {
            return $item->sortBy("urutan");
        })->flatten();

        $collectAplikasi = MasterApplication::all();

        $userManagementSelected = UserMenuManagement::where("nip", $user->nip)->get();

        $menuSelected = collect([]);

        $menuManagement = MenuManagement::all();

        if ($user->check_administrator) {
            $menuSelected = $collectMenu;
        }

        if ($user->check_user_sales) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "CRM");
            $menuSelected->push($menuFilter);
        }

        if ($user->check_admin_kontrak) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "CCM");
            $menuSelected->push($menuFilter);
        }

        if ($user->check_user_csi) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "CSI");
            $menuSelected->push($menuFilter);
        }

        if ($user->check_user_mobile) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "MOB");
            $menuSelected->push($menuFilter);
        }

        if ($user->is_user_4eyes) {
            $menuFilter = $menuManagement->where("kode_aplikasi", "NR");
            $menuSelected->push($menuFilter);
        }

        return view("/User/viewUser", ["user" => $user, "unit_kerjas" => UnitKerja::all(), "dops" => Dop::with("UnitKerjas")->get()->sortBy("dop"), 'collectMenu' => $collectMenu, 'userManagementSelected' => $userManagementSelected, 'menuSelected' => $menuSelected?->flatten(), 'collectAplikasi' => $collectAplikasi]);
    }

    public function updateOld(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->all();

            $messages = [
                "required" => "This field is required",
            ];
            $rules = [
                "nip" => "required",
                "name-user" => "required",
                "email" => "required",
                "phone-number" => "required",
                "aplikasi" => "required|array"
            ];

            $validation = Validator::make($data, $rules, $messages);
            if ($validation->fails()) {
                dd($validation->errors());
                Alert::error('Error', "User gagal diperbaharui, Periksa Kembali !");
            }

            $validation->fails();

            $is_administrator = false;
            $is_admin_kontrak = false;
            $is_user_sales = false;
            $is_user_csi = false;
            $is_user_mobile = false;
            $is_user_4eyes = false;

            // Loop aplikasi yang dipilih
            foreach ($data['aplikasi'] as $aplikasi) {
                switch ($aplikasi) {
                    case 'SUPER':
                        $is_administrator = true;
                        break;
                    case 'CRM':
                        $is_user_sales = true;
                        break;
                    case 'CCM':
                        $is_admin_kontrak = true;
                        break;
                    case 'CSI':
                        $is_user_csi = true;
                        break;
                    case 'MOB':
                        $is_user_mobile = true;
                        break;
                    case 'NR':
                        $is_user_4eyes = true;
                        break;
                }

                $selectedMenus = [];

                // Loop menu yang dipilih
                foreach ($data['menus'] as $kodeMenu => $menuData) {
                    // Update atau buat baru berdasarkan kombinasi nip, aplikasi, dan menu
                    $menu = UserMenuManagement::updateOrCreate(
                        [
                            'nip' => $data["nip"],
                            'aplikasi' => $aplikasi,
                            'menu' => $kodeMenu
                        ],
                        [
                            'create' => isset($menuData['create']) ? 1 : 0,
                            'read' => isset($menuData['read']) ? 1 : 0,
                            'update' => isset($menuData['update']) ? 1 : 0,
                            'delete' => isset($menuData['delete']) ? 1 : 0,
                            'lock' => isset($menuData['lock']) ? 1 : 0,
                            'approve' => isset($menuData['approve']) ? 1 : 0,
                        ]
                    );

                    // Simpan ID menu yang dipilih
                    $selectedMenus[] = $menu->menu;
                }

                // Hapus menu yang tidak dipilih untuk aplikasi saat ini
                UserMenuManagement::where('nip', $data["nip"])
                ->where('aplikasi', $aplikasi)
                    ->whereNotIn('menu', $selectedMenus) // Hapus menu yang tidak dipilih
                    ->delete();
            }


            $user = User::find($data["user-id"]);
            $user->nip = $data["nip"];
            $user->name = $data["name-user"];
            $user->email = $data["email"];
            $user->no_hp = $data["phone-number"];

            $user->is_active = $request->has("is-active");

            $user->unit_kerja = count($data["unit-kerja"]) > 1 ? join(",", $data["unit-kerja"]) : $data["unit-kerja"][0];

            $user->check_administrator = $is_administrator;
            $user->check_admin_kontrak = $is_admin_kontrak;
            $user->check_user_sales = $is_user_sales;
            $user->check_user_csi = $is_user_csi;
            $user->check_user_mobile = $is_user_mobile;
            $user->is_user_4eyes = $is_user_4eyes;


            if (isset($data['proyeks'])) {
                $user->proyeks_selected = $data['list-proyek'];
            } else {
                $user->proyeks_selected = null;
            }
            // $user->alamat = $data["alamat"];
            DB::commit();

            if ($user->save()) {
                Alert::success("Success", "User berhasil diperbarui.")->autoClose(3000);
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            // $request->old("nip");
            // $request->old("name-user");
            // $request->old("email");
            // $request->old("phone-number");
            // Alert::error("Error", $th->getMessage());
            // return redirect()->back();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $messages = [
                "required" => "This field is required",
            ];
            $rules = [
                "nip" => "required",
                "name-user" => "required",
                "email" => "required",
                "phone-number" => "required",
                "aplikasi" => "required|array",
                "menus" => "required|array"
            ];

            $validation = Validator::make($data, $rules, $messages);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation->errors())->withInput();
            }

            // Inisialisasi user di sini
            $user = User::find($data["user-id"]);

            // Ambil aplikasi yang sudah ada di database untuk user ini
            $existingApps = UserMenuManagement::where('nip', $data['nip'])->pluck('aplikasi')->unique()->toArray();
            // dd($existingApps);

            // Aplikasi baru yang dipilih user
            $newApps = $data['aplikasi'];

            // Mengatur properti user seperti role atau hak akses lainnya
            $roleMap = [
                'SUPER' => 'check_administrator',
                'CRM' => 'check_user_sales',
                'CCM' => 'check_admin_kontrak',
                'CSI' => 'check_user_csi',
                'MOB' => 'check_user_mobile',
                'NR' => 'is_user_4eyes',
            ];

            foreach ($newApps as $aplikasi) {
                if (isset($roleMap[$aplikasi])) {
                    // Mengatur properti user sesuai role yang dipilih
                    $user->{$roleMap[$aplikasi]} = true;
                }
            }

            // Tentukan aplikasi yang di-unchecklist (yang tidak dipilih lagi)
            $removedApps = array_diff($existingApps, $newApps);

            // Hapus aplikasi yang di-unchecklist dan menu terkait
            foreach ($removedApps as $aplikasi) {
                $modelUserManagement = UserMenuManagement::where('nip', $data['nip'])
                ->where('aplikasi', $aplikasi)
                    ->delete();
            }


            // Template Menu Management
            $menuManagement = MenuManagement::all()->groupBy("kode_aplikasi");

            $selectedMenus = [];

            // Mapping menu untuk aplikasi baru
            foreach (array_diff($newApps, $existingApps) as $aplikasi) {
                if (isset($menuManagement[$aplikasi])) {
                    foreach ($menuManagement[$aplikasi] as $menu) {
                        UserMenuManagement::create([
                            'nip' => $data['nip'],
                            'aplikasi' => $aplikasi,
                            'menu' => $menu->kode_menu,
                            'create' => 1,
                            'read' => 1,
                            'update' => 1,
                            'delete' => 1,  // Sesuaikan jika `delete` diperlukan
                        ]);
                        $selectedMenus[] = $menu->kode_menu;
                    }
                }
            }

            // DB::commit();

            foreach ($newApps as $aplikasi) {

                // $selectedMenus = [];

                foreach ($data['menus'] as $kodeMenu => $menuData) {
                    // $menu = UserMenuManagement::updateOrCreate(
                    //     [
                    //         'nip' => $data["nip"],
                    //         'aplikasi' => $aplikasi,
                    //         'menu' => $kodeMenu
                    //     ],
                    //     [
                    //         'create' => isset($menuData['create']) ? 1 : 0,
                    //         'read' => isset($menuData['read']) ? 1 : 0,
                    //         'update' => isset($menuData['update']) ? 1 : 0,
                    //         'delete' => isset($menuData['delete']) ? 1 : 0,
                    //         'lock' => isset($menuData['lock']) ? 1 : 0,
                    //         'approve' => isset($menuData['approve']) ? 1 : 0,
                    //     ]
                    // );
                    $existMenuUser = UserMenuManagement::where("nip", $data['nip'])->where('aplikasi', $aplikasi)->where('menu', $kodeMenu);
                    if ($existMenuUser->exists()) {
                        $menuUpdate = $existMenuUser->update([
                            'create' => isset($menuData['create']) ? 1 : 0,
                            'read' => isset($menuData['read']) ? 1 : 0,
                            'update' => isset($menuData['update']) ? 1 : 0,
                            'delete' => isset($menuData['delete']) ? 1 : 0,
                            'lock' => isset($menuData['lock']) ? 1 : 0,
                            'approve' => isset($menuData['approve']) ? 1 : 0,
                        ]);
                    } else {
                        $menuCreate = $existMenuUser->create([
                            'nip' => $data['nip'],
                            'aplikasi' => $aplikasi,
                            'menu' => $kodeMenu,
                            'create' => isset($menuData['create']) ? 1 : 0,
                            'read' => isset($menuData['read']) ? 1 : 0,
                            'update' => isset($menuData['update']) ? 1 : 0,
                            'delete' => isset($menuData['delete']) ? 1 : 0,
                            'lock' => isset($menuData['lock']) ? 1 : 0,
                            'approve' => isset($menuData['approve']) ? 1 : 0,
                        ]);
                    }


                    $selectedMenus[] = $kodeMenu;
                }
            }

            // Hapus menu yang tidak dipilih untuk aplikasi saat ini
            $menuDelete = UserMenuManagement::where('nip', $data["nip"])
            // ->where('aplikasi', $aplikasi)
            ->whereNotIn('menu', $selectedMenus)
                ->delete();

            // dd("TESS");

            $user->nip = $data["nip"];
            $user->name = $data["name-user"];
            $user->email = $data["email"];
            $user->no_hp = $data["phone-number"];
            $user->is_active = $request->has("is-active");
            $user->unit_kerja = count($data["unit-kerja"]) > 1 ? join(",", $data["unit-kerja"]) : $data["unit-kerja"][0];

            if (isset($data['proyeks'])) {
                $user->proyeks_selected = $data['list-proyek'];
            } else {
                $user->proyeks_selected = null;
            }

            if ($user->save()) {
                DB::commit();
                Alert::success("Success", "User berhasil diperbarui.")->autoClose(3000);
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error("Error", $th->getMessage());
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

    /**
     * TESTING LOGIN VIA SSO WZONE
     */
    public function authenticate(Request $request)
    {
        $data = $request->all();
        $token = $data['token'];
        $nip = null;

        //Check Validate Token WZone
        try {
            $validateLoginWZone = Http::withoutVerifying()->withOptions(["verify" => false])->get(env('WZONE_URL') . '/app/sso/valid', [
                'app_secret' => env('WZONE_APP_SECRET'),
                'token' => $token
            ]);
            // dd($validateLoginWZone->body());
            if ($validateLoginWZone->successful()) {
                //Get Data User From WZone
                $response = $validateLoginWZone->json();
                // $user = $validateLoginWZone->collect($key = 'data')->first();

                if ($response["responseStatus"] != 0) {
                    // dd($response["responseData"]);
                    setLogging("login", "User Login WZONE => ",  $response["responseData"]);
                    $nip = $response["responseData"]["nip"];
                } else {
                    dd($response);
                }
                // $nip = $user['NIP'];
            } else {
                return redirect()->back();
            }

            if (!empty($nip)) {
                //Check Pegawai yg login dari WZone ada di CRM atau tidak
                $checkUserInCRM = User::where('nip', $nip)->first();
                // dd($checkUserInCRM);

                if (!empty($checkUserInCRM) && $checkUserInCRM->is_active) {
                    $dataPegawai = Pegawai::where('nip', $nip)->first();
                    // if (!empty($dataPegawai)) {
                    //     $dataPegawai->nama_pegawai = $response["responseData"]["full_name"];
                    //     $dataPegawai->email = $response["responseData"]["email"];
                    //     $dataPegawai->handphone = $response["responseData"]["handphone"] ?? 0;
                    //     // $dataPegawai->kode_jabatan = $response["responseData"]["kd_jabatan"];
                    //     $dataPegawai->kode_fungsi_bidang_sap = $response["responseData"]["kd_fungsi_bidang"];
                    //     $dataPegawai->nama_fungsi_bidang = $response["responseData"]["nm_fungsi_bidang"];
                    //     $dataPegawai->kode_jabatan_sap = $response["responseData"]["kd_jabatan"];
                    //     // $dataPegawai->kode_kantor_sap = $response["responseData"]["kd_kantor"];
                    //     $dataPegawai->nama_kantor = $response["responseData"]["nm_kantor"];
                    // }

                    $checkUserInCRM->name = $response["responseData"]["full_name"];
                    $checkUserInCRM->email = $response["responseData"]["email"];
                    $checkUserInCRM->no_hp = $response["responseData"]["handphone"];

                    // dd($dataPegawai);
                    if ($dataPegawai->save() && $checkUserInCRM->save()) {
                        // Auth::login(['nip' => $nip]);
                        Auth::login($checkUserInCRM);
                        if (Auth::check()) {
                            $request->session()->regenerate();
                            $path = Auth::user()->UserMenuManagement?->map(function ($userMenu) {
                                return $userMenu->MasterMenu;
                            })?->sortBy("urutan")?->first()->path;
                            // if (!Gate::allows("user-scm")) {
                            //     return redirect()->intended("/dashboard");
                            // } else {
                            //     return redirect()->intended("/proyek");
                            // }
                            return redirect()->intended($path);
                        } else {
                            dd([
                                "Success" => false,
                                "Status" => "Login Failed",
                                "Message" => "Terjadi kesalahan. Mohon hubungi Admin!"
                            ]);
                        }
                    } else {
                        dd([
                            "Success" => false,
                            "Status" => "Login Failed",
                            "Message" => "Terjadi kesalahan. Mohon hubungi Admin!"
                        ]);
                    }
                } else {
                    dd([
                        "Success" => false,
                        "Status" => "Login Failed",
                        "Message" => "User belum terdaftar di Aplikasi CRM."
                    ]);
                }
            } else {
                dd([
                    "Success" => false,
                    "Status" => "Login Failed",
                    "Message" => "Key [NIP] undifined or null"
                ]);
                // return redirect(env('WZONE_URL')); 
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function authenticateMobile(Request $request)
    {
        $data = $request->all();
        $token = $data['token'];
        $nip = null;

        //Check Validate Token WZone
        try {
            $validateLoginWZone = Http::withoutVerifying()->withOptions(["verify" => false])->get(env('WZONE_URL') . '/app/sso/valid', [
                'app_secret' => env('WZONE_APP_SECRET'),
                'token' => $token
            ]);
            // dd($validateLoginWZone->body());
            if ($validateLoginWZone->successful()) {
                //Get Data User From WZone
                $response = $validateLoginWZone->json();
                // $user = $validateLoginWZone->collect($key = 'data')->first();

                if ($response["responseStatus"] != 0) {
                    // dd($response["responseData"]);
                    $response["responseData"]["fcm_token"] = $request->get("fcm-token");
                    setLogging("login", "User Login WZONE Mobile => ",  $response["responseData"]);
                    $nip = $response["responseData"]["nip"];
                } else {
                    setLogging("login", "User Login WZONE Mobile FAIL => ",  $response["responseData"]);
                }
                // $nip = $user['NIP'];
            } else {
                return redirect()->back();
            }

            if (!empty($nip)) {
                //Check Pegawai yg login dari WZone ada di CRM atau tidak
                $checkUserInCRM = User::where('nip', $nip)->first();

                if (!empty($checkUserInCRM) && $checkUserInCRM->is_active && ($checkUserInCRM->check_administrator || $checkUserInCRM->check_user_mobile)) {
                    Auth::login($checkUserInCRM);
                    $user = Auth::user();
                    $token = $user->createToken($nip)->plainTextToken;

                    $token_fcm = $request->get("fcm-token");

                    $checkUserInCRM->fcm_token = $token_fcm;

                    $checkUserInCRM->save();

                    return response()->json([
                        'success' => true,
                        'user' => $user,
                        'token' => $token,
                        'message' => "Success",
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'user' => null,
                        'token' => null,
                        'message' => "Forbidden",
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'user' => null,
                    'token' => null,
                    'message' => "WZONE ERROR",
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'user' => null,
                'token' => null,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        // auth()->user()->forceFill([
        //     "remember_token" => null,
        // ])->save();


        Request()->session()->invalidate();

        Request()->session()->regenerateToken();


        if (str_contains($request->url(), "api")) {

            return response()->json([
                "status" => "success",
                "msg" => "Logged out",
            ]);
        }

        Auth::logout();
        return redirect(env("WZONE_URL"));

        // if (auth()->user()->check_admin_kontrak) {
        //     Auth::logout();
        //     return redirect('/ccm');
        // } else {
        //     Auth::logout();
        //     return redirect('/');
        // }
    }

}
