<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRecord extends Model
{

    protected $fillable = [
        'student',
        'college',
        'school',
        'enrolment_date', 
        'student_status',
        'programme',
        'enrolment_status',
        'funding_type',
        'mode_of_study',
    ];

    /**
     * Get the student that this record belongs to.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    
}
