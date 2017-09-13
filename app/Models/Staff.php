<?php

namespace App\Models;

use App\Scopes\UserScope;
use App\Models\Training;

class Staff extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('Staff'));
    }

    public function supervising()
    {
        return $this->belongsToMany(StudentRecord::class, 'supervisors')
            ->wherePivot('changed_on', null)
            ->with('student')
            ->withPivot('supervisor_type')
            ->withTimestamps();
    }

    public function supervisor_types($rank)
    {
        switch ($rank) {
            case 1: return 'Director of Study';
            case 2: return 'Second Supervisor';
            case 3: return 'Third Supervisor';
            default: abort(404); 
        }
    }

    public function training()
    {
        return $this->belongsToMany(App\Models\Training::class);
    }
}
