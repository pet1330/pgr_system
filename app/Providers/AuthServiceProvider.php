<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Milestone;
use App\Models\AbsenceType;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use App\Policies\StudentPolicy;
use App\Policies\AbsenceTypePolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\StudentRecordPolicy;
use Illuminate\Database\Eloquent\Model;
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

        Gate::define('createMilestone', function ($user, $m=null)
        {

            if( $user->can('create', Milestone::class) ) return true;

            if( is_null($m) ) return $user->isStudent() && MilestoneType::StudentMakable()->count();

            if ( is_integer($m) )
            {
                $mt = MilestoneType::where('id', $m)->first();
                if($mt) return $user->isStudent() && $mt->student_makable;
            }
            return false;
        });

    }
}
