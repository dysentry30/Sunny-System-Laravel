<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
            return $user->check_administrator == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('crm', function (User $user) {
            return $user->check_user_sales == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('ccm', function (User $user) {
            return $user->check_admin_kontrak == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('csi', function (User $user) {
            return $user->check_user_csi == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('mobile', function (User $user) {
            return $user->check_user_mobile == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('ska-skt', function (User $user) {
            return $user->check_user_ska_skt == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('admin', function (User $user) {
            return $user->role_admin == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('user', function (User $user) {
            return $user->role_user == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('approver', function (User $user) {
            return $user->approver == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('risk', function (User $user) {
            return $user->risk == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('admin-crm', function (User $user) {
            return  $user->check_user_sales == true && $user->role_admin == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('user-crm', function (User $user) {
            return $user->check_user_sales == true && $user->role_user == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define('approver-crm', function (User $user) {
            return $user->check_user_sales == true && $user->role_approver == true && $user->email != "user-poc@sunny.com";
        });

        // Gate::define('risk-crm',
        //     function (User $user) {
        //         return $user->check_user_sales == true && $user->role_risk == true && $user->email != "user-poc@sunny.com";
        //     }
        // );

        Gate::define(
            'risk-crm',
            function (User $user) {
                return !empty($user->Pegawai?->kode_kantor_sap) && $user->Pegawai->kode_kantor_sap == 'A112';
            }
        );

        Gate::define(
            'admin-ccm',
            function (User $user) {
                return  $user->check_admin_kontrak == true && $user->role_admin == true && $user->email != "user-poc@sunny.com";
            }
        );

        Gate::define(
            'user-ccm',
            function (User $user) {
                return $user->check_admin_kontrak == true && $user->role_user == true && $user->email != "user-poc@sunny.com";
            }
        );

        Gate::define('approver-ccm', function (User $user) {
            return $user->check_admin_kontrak == true && $user->role_approver == true && $user->email != "user-poc@sunny.com";
        });

        Gate::define(
            'risk-ccm',
            function (User $user) {
                return $user->check_admin_kontrak == true && $user->role_risk == true && $user->email != "user-poc@sunny.com";
            }
        );

        Gate::define(
            'admin-csi',
            function (User $user) {
                return  $user->check_user_csi == true && $user->role_admin == true && $user->email != "user-poc@sunny.com";
            }
        );

        Gate::define(
            'user-csi',
            function (User $user) {
                return  $user->check_user_csi == true && $user->role_user == true && $user->email != "user-poc@sunny.com";
            }
        );

        Gate::define('unlock-ccm',
            function (User $user) {
                return $user->role_admin && $user->is_unlock;
            }
        );

        Gate::define('poc', function (User $user) {
            return $user->email == "user-poc@sunny.com";
        });
        //
    }
}
