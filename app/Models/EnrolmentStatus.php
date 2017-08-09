<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrolmentStatus extends Model
{

    use SoftDeletes;
    
    protected $fillable = ['status'];
    
    protected $table = 'enrolment_statuses';

    protected $dates = ['deleted_at'];

    public function students()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
