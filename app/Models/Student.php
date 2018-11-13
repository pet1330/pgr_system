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

    public function record()
    {
        return $this->records->last();
    }

    public function getSchoolAttribute()
    {
        return $this->record()->school;
    }

    public function getCollegeAttribute()
    {
        return $this->record()->school->college;
    }

    public function getTierFourAttribute()
    {
        return $this->record()->tierFour;
    }

    public function getStudentStatusAttribute()
    {
        return $this->record()->StudentStatus;
    }

    public function getProgrammeTitleAttribute()
    {
        return $this->record()->ProgrammeTitle;
    }

    public function getProgrammeTypeAttribute()
    {
        return $this->record()->ProgrammeType;
    }

    public function getEnrolmentStatusAttribute()
    {
        return $this->record()->EnrolmentStatus;
    }

    public function getDirectorOfStudyAttribute()
    {
        return $this->record()->directorOfStudy;
    }

    public function getSecondSupervisorAttribute()
    {
        return $this->record()->secondSupervisor;
    }

    public function getThirdSupervisorAttribute()
    {
        return $this->record()->thirdSupervisor;
    }

    public function removeSupervisor(Staff $supervisor)
    {
        return $this->record()->removeSupervisor($supervisor);
    }

    public function addSupervisor(Staff $supervisor, $type)
    {
        return $this->record()->addSupervisor($supervisor, $type);
    }

    public function supervisors()
    {
        return $this->record()->supervisors();
    }

    public function interuptionPeriodSoFar(Carbon $at_point = null, $include_current = true)
    {
        return $this->absences->filter(function (Absence $ab)  use ($at_point, $include_current) {
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

    public function getStartDateAttribute()
    {
        return $this->record()->enrolment_date;
    }

    public function enrolmentStatus()
    {
        return $this->record()->enrolmentStatus();
    }

    public function fundingType()
    {
        return $this->record()->fundingType();
    }

    public function programme()
    {
        return $this->record()->programme();
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
