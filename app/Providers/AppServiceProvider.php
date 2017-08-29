<?php

namespace App\Providers;

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

        \Validator::extend('student', function ($attribute, $value) {
            return \App\Models\Student::where('university_id', $value)->exists();
        });

        \Validator::extend('staff', function ($attribute, $value) {
            return \App\Models\Staff::where('university_id', $value)->exists();
        });

        \Validator::extend('admin', function ($attribute, $value) {
            return \App\Models\Admin::where('university_id', $value)->exists();
        });

        \Blade::directive('canany', function ($arguments) {
            list($permissions, $guard) = explode(',', $arguments . ',');

            $permissions = explode('|', str_replace('\'', '', $permissions));

            $expression = "<?php if(auth({$guard})->check() && ( false";
            foreach ($permissions as $permission) {
                $expression .= " || auth({$guard})->user()->can('{$permission}')";
            }

            return $expression . ")): ?>";
        });

        \Blade::directive('endcanany', function () { return '<?php endif; ?>'; });

        \View::share('app_version', \Cache::remember('app_version', 10, function () { return strtok(shell_exec('git describe --always --tags'), '-'); }) );
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
