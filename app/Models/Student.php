<?php

namespace App\Models;

use App\Scopes\StudentUserScope;

class Student extends User
{

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StudentUserScope);
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
