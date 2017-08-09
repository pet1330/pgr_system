<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeOfStudy extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'timing_factor'];

    protected $table = 'mode_of_studys';

    protected $dates = ['deleted_at'];

    public function studentRecord()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
