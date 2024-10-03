<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\MatriksApprovalChangeManagement;
use App\Models\UserMenuManagement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();
        Gate::define('super-admin', function (User $user) {
            return $user->check_administrator == true;
        });

        Gate::define('crm', function (User $user) {
            return $user->check_user_sales == true;
        });

        Gate::define('ccm', function (User $user) {
            return $user->check_admin_kontrak == true;
        });

        Gate::define('csi', function (User $user) {
            return $user->check_user_csi == true;
        });

        Gate::define('mobile', function (User $user) {
            return $user->check_user_mobile == true;
        });

        Gate::define('ska-skt', function (User $user) {
            return $user->check_user_ska_skt == true;
        });

        Gate::define('admin', function (User $user) {
            return $user->role_admin == true;
        });
        

        Gate::define('user', function (User $user) {
            return $user->role_user == true;
        });

        Gate::define('approver', function (User $user) {
            return $user->approver == true;
        });

        Gate::define('risk', function (User $user) {
            return $user->role_risk == true;
        });

        Gate::define('admin-crm', function (User $user) {
            return  $user->check_user_sales == true && $user->role_admin == true;
        });

        Gate::define('user-crm', function (User $user) {
            return $user->check_user_sales == true && $user->role_user == true;
        });

        Gate::define('approver-crm', function (User $user) {
            return $user->check_user_sales == true && $user->role_approver == true;
        });

        // Gate::define('risk-crm',
        //     function (User $user) {
        //         return $user->check_user_sales == true && $user->role_risk == true;
        //     }
        // );

        Gate::define('risk-crm',
            function (User $user) {
                $divisiRMD = Divisi::where("nama_kantor", "RISK MANAGEMENT DIVISION")->first();
                return !empty($user->Pegawai?->kode_kantor_sap) && $user->Pegawai->kode_kantor_sap == $divisiRMD->kode_sap;
            }
        );

        Gate::define('admin-ccm',
            function (User $user) {
                return  $user->check_admin_kontrak == true && $user->role_admin == true;
            }
        );

        Gate::define('user-ccm',
            function (User $user) {
                return $user->check_admin_kontrak == true && $user->role_user == true;
            }
        );

        Gate::define('approver-ccm', function (User $user) {
            return $user->check_admin_kontrak == true && $user->role_approver == true;
        });

        Gate::define('risk-ccm',
            function (User $user) {
                return $user->check_admin_kontrak == true && $user->role_risk == true;
            }
        );

        Gate::define(
            'admin-csi',
            function (User $user) {
                return  $user->check_user_csi == true && $user->role_admin == true;
            }
        );

        Gate::define(
            'user-csi',
            function (User $user) {
                return  $user->check_user_csi == true && $user->role_user == true;
            }
        );

        Gate::define(
            'unlock-ccm',
            function (User $user) {
                return $user->role_admin && $user->is_unlock;
            }
        );

        Gate::define('user-scm', function (User $user) {
            return $user->check_user_sales && $user->role_scm;
        });

        Gate::define("lock-change", function (User $user, $profit_center) {
            if ($user->check_administrator) {
                return true;
            }

            if (!empty($user->proyeks_selected)) {
                $proyekCollect = collect(json_decode($user->proyeks_selected));
                return $user->check_admin_kontrak && $proyekCollect->contains($profit_center);
            }

            return false;
        });

        Gate::define('approve-change', function (User $user, $profit_center) {
            if ($user->check_administrator) {
                return true;
            }

            return MatriksApprovalChangeManagement::where("nip", $user->nip)->where("profit_center", $profit_center)->exists();
        });

        Gate::define('access-menu-read', function (User $user, $menu) {
            return UserMenuManagement::where("nip", $user->nip)
            ->where("menu", $menu)
                ->where("read", true)
                ->exists();
        });

        Gate::define('access-menu-create', function (User $user, $menu) {
            return UserMenuManagement::where("nip", $user->nip)
            ->where("menu", $menu)
                ->where("create", true)
            ->exists();
        });

        Gate::define('access-menu-update', function (User $user, $menu) {
            return UserMenuManagement::where("nip", $user->nip)
            ->where("menu", $menu)
                ->where("update", true)
            ->exists();
        });

        Gate::define('access-menu-delete', function (User $user, $menu) {
            return UserMenuManagement::where("nip", $user->nip)
            ->where("menu", $menu)
                ->where("delete", true)
            ->exists();
        });
        //
    }
}
