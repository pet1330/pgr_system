<?php

namespace App\Models;

use App\Scopes\UserScope;

class Staff extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('staff'));
    }
}
