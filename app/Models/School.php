<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;












class School extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected static $logOnlyDirty = true;
    
    protected static $logAttributes = [ 'name', 'college_id', 'notifications_address_id' ];
    
    protected $with = ['college'];
    
    protected $fillable = [ 'name', 'college_id', 'notifications_address_id' ];
    
    protected $table = 'schools';

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function student()
    {
        return $this->hasManyThrough(
            Student::class, StudentRecord::class, 'school_id', 'id');
    }

    public function studentRecord()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
