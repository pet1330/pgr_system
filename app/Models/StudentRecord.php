<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRecord extends Model
{

    protected $casts = [
        'tierFour' => 'boolean',
    ];
    
    protected $fillable = [
        'studentid',
        'school',
        'enrolment_date', 
        'student_status',
        'programe_title',
        'programe_type',
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

    public function getCollegeAttribute()
    {
        return $this->school->college;
    }
}
