<?php

namespace App\Models;

use Plank\Mediable\Mediable;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilestoneType extends Model
{
    use Mediable;
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected $casts = [
        'student_makable' => 'boolean',
    ];

    protected static $logAttributes = ['name', 'duration', 'student_makable'];

    protected $table = 'milestone_types';

    protected $fillable = ['name', 'duration', 'student_makable'];

    public function scopeStudentMakable($query)
    {
        return $query->where('student_makable', true);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function milestone_templates()
    {
        return $this->hasMany(MilestoneTemplate::class);
    }
}
