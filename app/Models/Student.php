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
}
