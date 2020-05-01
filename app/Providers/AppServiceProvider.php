<?php

namespace App\Providers;

use App\User;
use App\Services\UserService;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\DoctorServices;
use Illuminate\Support\ServiceProvider;
use App\Session;
use App\Doctor;
use App\Patient;
use App\Pharmacist;
use App\Staff;
use App\Prescription;
use App\Util\AzureBlobClient;
use App\Services\PrescriptionService;
use App\Services\PatientService;
use App\Services\PharmacistService;

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
            return new AdminService(new Doctor() , new UserService(new User()),new Patient() , new Pharmacist() , new Staff() , new Prescription());
        });
        $this->app->singleton(AuthService::class,function(){
            return new AuthService(new User());
        });
        $this->app->singleton(DoctorServices::class,function(){
            return new DoctorServices(new Prescription() , new User() , new Patient() ,new PrescriptionService(new Prescription(), new AzureBlobClient()));
        });
        $this->app->singleton(PatientService::class,function(){
            return new PatientService(new Prescription());
        });
        $this->app->singleton(PharmacistService::class,function(){
            return new PharmacistService(new Patient,new PrescriptionService(new Prescription(),new AzureBlobClient()));
        });
    }
}
