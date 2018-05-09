<?php

namespace App\Models;

use Bouncer;
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

    public function assignDefaultPermissions($reset = false)
    {
        // Remove all abilities
        if ($reset) {
            $this->abilities()->sync([]);
        }

        // Assign a sensable default
        $this->allow('view', $this);
        $this->supervising->each(function (StudentRecord $record) {
            $this->allow('view', $record->student);
            $record->timeline->each(function (Milestone $m) {
                $this->allow('view', $m);
            });
        });
        Bouncer::refreshFor($supervisor);
    }
}
