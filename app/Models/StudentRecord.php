<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentRecord extends Model
{
    // protected $with = ['school', 'modeOfStudy', 'studentStatus', 'programmeType', 'enrolmentStatus'];

    protected $casts = [
        'tierFour' => 'boolean',
    ];

    protected $dates = [
    'enrolment_date'
    ];
    
    protected $fillable = [
        'student_id',
        'school_id',
        'enrolment_date', 
        'student_status_id',
        'programme_title',
        'programme_type_id',
        'enrolment_status_id',
        'funding_type_id',
        'mode_of_study_id',
        'tierFour'
    ];

    /**
     * Get the student that this record belongs to.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function college()
    {
        return $this->school->college;
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function modeOfStudy()
    {
        return $this->belongsTo(ModeOfStudy::class);
    }

    public function studentStatus()
    {
        return $this->belongsTo(StudentStatus::class);
    }

    public function programmeType()
    {
        return $this->belongsTo(Programme::class);
    }

    public function enrolmentStatus()
    {
        return $this->belongsTo(EnrolmentStatus::class);
    }

    public function getDirectorOfStudyAttribute()
    {
        return $this->supervisor(1);
    }

    public function getSecondSupervisorAttribute()
    {
        return $this->supervisor(2);
    }

    public function getThirdSupervisorAttribute()
    {
        return $this->supervisor(3);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Staff::class, 'supervisors')
                    ->wherePivot('changed_on', null)
                    ->withPivot('supervisor_type')
                    ->withTimestamps();
    }

    public function supervisor($supervisorType)
    {
        return $this->supervisors()
            ->wherePivot('supervisor_type', $supervisorType)->first();
    }

    public function removeSupervisor(Staff $supervisor)
    {
        return $this->supervisors()
                    ->updateExistingPivot(
                        $supervisor->id,
                        ['changed_on' => Carbon::now()]
                    );
    }

    public function addSupervisor(Staff $supervisor, $type)
    {
        return $this->supervisors()->sync(
            [
                $supervisor->id => 
                [ 
                    "supervisor_type" => $type
                ]
            ], false
        );
    }
}
