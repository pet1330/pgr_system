<?php

namespace App\Models;

use App\Scopes\UserScope;

class Staff extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('Staff'));
    }

    public function supervising()
    {
        return $this->belongsToMany(StudentRecord::class, 'supervisors')->with('student');
    }
}
