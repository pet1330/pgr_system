<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRecord extends Model
{
    protected $with = ['school', 'modeOfStudy', 'studentStatus', 'programmeType', 'enrolmentStatus'];

    protected $casts = [
        'tierFour' => 'boolean',
    ];
    
    protected $fillable = [
        'student_id',
        'school_id',
        'enrolment_date', 
        'student_status',
        'programme_title',
        'programme_type',
        'enrolment_status',
        'funding_type',
        'mode_of_study',
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

}
