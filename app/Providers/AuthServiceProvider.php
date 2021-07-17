<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->dashboardPolicies();
    }
    public function dashboardPolicies()
    {
        Gate::define('user-permission', 'App\Policies\UserPermissionPolicy@userpermissions');
        Gate::define('manager-only', 'App\Policies\ManagerPolicy@manager');
        Gate::define('admin-only', 'App\Policies\AdminPolicy@admin');
        Gate::define('user-only', 'App\Policies\UserPolicy@user');
        Gate::define('departmentAdmin', 'App\Policies\DepartmentAdminPolicy@departmentAdmin');
    }
}
