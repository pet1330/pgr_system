<?php

namespace App\Models;

use App\Scopes\StaffUserScope;

class Staff extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StaffUserScope);
    }
}
