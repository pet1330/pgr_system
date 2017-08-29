<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
    use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRolesAndAbilities;
    use Notifiable;
    use LogsActivity;

    protected $table = "users";

    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'university_email',
        'university_id',
        'user_type'
    ];

    public function getNameAttribute()
    {
        return sprintf("%s %s", $this->first_name, $this->last_name);
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

    public function avatar($size=80)
    {
        return "https://s.gravatar.com/avatar/" . 
                md5( strtolower( trim( $this->university_email ) ) ) . "?d=mm&s=" . $size;
    }

    public function interuptionPeriodSoFar($include_current=true, $at_point=null)
    {
        return $this->absences->filter(function ( Absence $ab) {
            return !! $ab->absence_type->interuption;
        })->filter(function (Absence $ab) use ($include_current, $at_point) {
            return $ab->isPast($at_point) || $ab->isCurrent($at_point) && $include_current;
        })->sum('duration');
    }

    public function isAdmin()
    {
        return $this->user_type === "Admin";
    }

    public function isStaff()
    {
        return $this->user_type === "Staff";
    }

    public function isStudent()
    {
        return $this->user_type === "Student";
    }

    public function dashboard_url($user=null)
    {
        if( $user instanceof static ) $user = $user->id;

        switch ($this->user_type) {
            case 'Admin': return route('admin.admin.show', $user ?? $this->university_id);
            case 'Staff': return route('admin.staff.show', $user ?? $this->university_id);
            case 'Student': return route('admin.student.show', $user ?? $this->university_id);
        }
    }

    public function getRouteKeyName()
    {
        return "university_id";
    }
}
