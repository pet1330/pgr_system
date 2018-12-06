<?php

namespace App\Models;

use Bouncer;
use Carbon\Carbon;
use App\Scopes\UserScope;

class Student extends User
{
    protected $with = ['records'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('Student'));
    }

    public function records()
    {
        return $this->hasMany(StudentRecord::class);
    }

    public function interuptionPeriodSoFar(Carbon $at_point = null, $include_current = true)
    {
        return $this->absences->filter(function (Absence $ab) use ($at_point, $include_current) {
            return ((bool) $ab->type->interuption) &&
                ($ab->isPast($at_point) || $ab->isCurrent($at_point) && $include_current);
        })->sum('duration');
    }

    public function totalInteruptionPeriod()
    {
        return $this->absences->filter(function (Absence $ab) {
            return (bool) $ab->type->interuption;
        })->sum('duration');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class, 'user_id');
    }

    public function isAbsent()
    {
        return $this->absences()->current()->isNotEmpty();
    }

    public function isNotAbsent()
    {
        return ! $this->isAbsent();
    }

    public function assignDefaultPermissions($reset = false)
    {
        // Remove all abilities
        if ($reset) {
            $this->abilities()->sync([]);
        }
        // Assign a sensable default
        $this->allow('view', $this);

        $this->records->each(function (StudentRecord $sr) {
            $sr->timeline->each(function (Milestone $m) {
                $this->allow('view', $m);
                $this->allow('upload', $m);
            });
        });
        Bouncer::refreshFor($this);
    }
}
