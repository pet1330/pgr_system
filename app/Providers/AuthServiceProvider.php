<?php

namespace App\Providers;

use App\Models\Milestone;
use App\Models\MilestoneType;
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
        Gate::define('createMilestone', function ($user, $m = null) {
            if ($user->can('manage', Milestone::class)) {
                return true;
            }

            if (is_null($m)) {
                return $user->isStudent() && MilestoneType::StudentMakable()->count();
            }

            if (is_int($m)) {
                $mt = MilestoneType::where('id', $m)->first();
                if ($mt) {
                    return $user->isStudent() && $mt->student_makable;
                }
            }

            return false;
        });
    }
}
