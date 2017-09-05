<?php

namespace App\Models;

use App\Scopes\UserScope;

class Student extends User
{
    protected $with = ['records'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('Student'));
    }

    /**
     * Fetch the Student's record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

    public function getModeOfStudyAttribute()
    {
        return $this->record()->ModeOfStudy;
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

    public function interuptionPeriodSoFar($include_current=true, $at_point=null)
    {
        return $this->absences->filter(function ( Absence $ab) {
            return !! $ab->absence_type->interuption;
        })->filter(function (Absence $ab) use ($include_current, $at_point) {
            return $ab->isPast($at_point) || $ab->isCurrent($at_point) && $include_current;
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

    public function modeOfStudy()
    {
        return $this->record()->modeOfStudy();
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
}
