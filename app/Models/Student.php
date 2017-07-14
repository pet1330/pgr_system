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
        return $this->records()->first();
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
}
