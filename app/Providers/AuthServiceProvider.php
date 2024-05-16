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
            return $user->risk == true;
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
                return !empty($user->Pegawai?->kode_kantor_sap) && $user->Pegawai->kode_kantor_sap == 'A112';
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
        //
    }
}
