<?php

namespace App\Providers;

use App\User;
use App\Services\UserService;
use App\Services\AdminService;
use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;
use App\Session;
use App\Doctor;
use App\Patient;
use App\Pharmacist;
use App\Staff;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserService::class,function(){
            return new UserService(new User());
        });
        $this->app->singleton(AdminService::class,function(){
            return new AdminService(new Doctor() , new UserService(new User()),new Patient() , new Pharmacist() , new Staff());
        });
        $this->app->singleton(AuthService::class,function(){
            return new AuthService(new User());
        });
    }
}
