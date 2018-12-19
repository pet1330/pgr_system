<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use Notifiable;
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = ['name', 'college_id', 'notifications_address'];

    protected $with = ['college'];

    protected $fillable = ['id', 'name', 'college_id', 'notifications_address'];

    protected $table = 'schools';

    public function college()
    {
        return $this->belongsTo(College::class)->withTrashed();
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class, StudentRecord::class, 'school_id', 'id');
    }

    public function studentRecords()
    {
        return $this->hasMany(StudentRecord::class);
    }

    public function routeNotificationForMail()
    {
        return $this->notifications_address;
    }
}
