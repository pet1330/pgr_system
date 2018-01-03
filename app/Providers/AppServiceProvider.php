<?php

namespace App\Providers;

use View;
use Bouncer;
use Blade;
use Validator;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Milestone;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // Fix for MySQL versions < 5.7.7

        Bouncer::cache();

        Validator::extend('student', function ($attribute, $value) {
            return Student::where('university_id', $value)->exists();
        });

        Validator::extend('staff', function ($attribute, $value) {
            return Staff::where('university_id', $value)->exists();
        });

        Validator::extend('admin', function ($attribute, $value) {
            return Admin::where('university_id', $value)->exists();
        });

        View::share('app_version', \Cache::remember('app_version', 10, function () { return strtok(shell_exec('git describe --always --tags'), '-'); }) );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
