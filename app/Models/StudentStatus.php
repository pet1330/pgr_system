<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentStatus extends Model
{
 use SoftDeletes;

    protected $fillable = ['status'];

    protected $table = 'student_statuses';

    protected $dates = ['deleted_at'];
}
