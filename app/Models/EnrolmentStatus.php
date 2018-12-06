<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrolmentStatus extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = ['status'];

    protected $fillable = ['status'];

    protected $table = 'enrolment_statuses';

    protected $dates = ['deleted_at'];

    public function students()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
