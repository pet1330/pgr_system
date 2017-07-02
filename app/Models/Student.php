<?php

namespace App\Models;

use App\Scopes\UserScope;

class Student extends User
{

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('student'));
    }

    /**
     * Fetch the Student's record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function records()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
