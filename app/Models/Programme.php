<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'duration', 'duration_unit'];

    protected $table = 'programmes';

    protected $dates = ['deleted_at'];

    public function students()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
