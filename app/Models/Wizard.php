<?php

namespace App\Models;

use App\Scopes\WizardUserScope;

class Wizard extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new WizardUserScope);
    }
}
