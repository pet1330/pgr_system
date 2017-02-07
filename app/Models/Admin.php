<?php

namespace App\Models;

use App\Scopes\AdminUserScope;

class Admin extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminUserScope);
    }
}
