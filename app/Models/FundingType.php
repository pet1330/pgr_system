<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusScope;

class FundingType extends Model
{
    protected $table = 'statuses';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new StatusScope('funding_type'));
    }
}
