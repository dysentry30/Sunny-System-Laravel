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
            return str_contains($user->email, '@wika-customer');
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
            return $user->check_user_sales == true && $user->approver == true;
        });

        //
    }
}
