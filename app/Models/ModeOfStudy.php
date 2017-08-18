<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeOfStudy extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'timing_factor'];

    protected $table = 'modes_of_study';

    protected $dates = ['deleted_at'];

    public function students()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
