<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $with = ['college'];
    protected $fillable = [ 'name', 'college_id' ];
    protected $table = 'schools';

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function student()
    {
        return $this->hasManyThrough(
            Student::class, StudentRecord::class, 'school_id', 'id');
    }

    public function studentRecord()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
