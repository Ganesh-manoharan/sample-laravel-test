<?php

namespace App\Providers;

use App\Client;
use App\ClientKeyContacts;
use App\DepartmentMembers;
use App\Departments;
use App\FundGroups;
use App\FundsKeyContact;
use App\Observers\ClientKeyContactsObserver;
use App\Observers\ClientObserver;
use App\Observers\DepartmentMemberObserver;
use App\Observers\DepartmentsObserver;
use App\Observers\FundGroupsObserver;
use App\Observers\FundKeyContactsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Departments::observe(DepartmentsObserver::class);
        DepartmentMembers::observe(DepartmentMemberObserver::class);
        FundGroups::observe(FundGroupsObserver::class);
        FundsKeyContact::observe(FundKeyContactsObserver::class);
        Client::observe(ClientObserver::class);
        ClientKeyContacts::observe(ClientKeyContactsObserver::class);
    }
}
