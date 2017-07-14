<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusScope;

class ModeOfStudy extends Model
{
    protected $table = 'statuses';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new StatusScope('mode_of_study'));
    }

    public function StudentRecord()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
