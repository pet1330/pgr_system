<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineTemplate extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = ['name'];

    protected $table = 'timeline_templates';

    protected $with = ['milestone_templates'];

    protected $fillable = ['name'];

    public function milestone_templates()
    {
        return $this->hasMany(MilestoneTemplate::class);
    }

    public function copyToStudent(StudentRecord $record)
    {
        $this->milestone_templates->map->create_milestone($record);
    }
}
