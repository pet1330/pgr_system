<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class User extends Authenticatable
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
}
