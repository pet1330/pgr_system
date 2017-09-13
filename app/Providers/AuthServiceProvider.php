<?php

namespace App\Providers;


use App\Models\Student;
use App\Models\StudentRecord;
use App\Policies\StudentPolicy;
use App\Policies\StudentRecordPolicy;
use App\Models\AbsenceType;
use App\Policies\AbsenceTypePolicy;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        //
    }
}
