<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'university_email',
        'university_id',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function getNameAttribute()
    {
        if( is_null($this->middle_name) )
            return sprintf("%s %s", $this->first_name, $this->last_name);
        else
            return sprintf("%s %s %s", $this->first_name, $this->middle_name, $this->last_name);
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        if (static::class === "App\Models\User")
        {
            if(!isset($attributes->user_type))
                throw new Exception("User Type Not Defined", 1);
            $userType = __NAMESPACE__ . '\\' . $attributes->user_type;
            $factory = (new $userType)->newFromBuilder($attributes, $connection);
            $factory->setRawAttributes((array) $attributes, true);
            return $factory->load($factory->with);
        }
        return parent::newFromBuilder($attributes, $connection);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class, 'user_id');
    }

    public function isAbsent()
    {
        return !! $this->absences()->current()->count();
    }

    public function isNotAbsent()
    {
        return ! $this->isAbsent();
    }

    public function avatar()
    {
        return asset('imgs/usericon.jpg');
    }

    public function interuptionPeriodSoFar($include_current=true)
    {
        return $this->absences->filter(function ($ab) {
            return !! $ab->absence_type->interuption;
        })->filter(function ($ab) use ($include_current) {
            return $ab->isPast() || $ab->isCurrent() && $include_current;
        })->sum(function ($ab) {
            return $ab->duration;
        });
    }
}
