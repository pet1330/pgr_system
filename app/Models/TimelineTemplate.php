<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TimelineTemplate extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [ 'name' ];

    protected $table ='timeline_templates';

    protected $with = [ 'milestone_templates' ];

    protected $fillable = [ 'name' ];

    public function milestone_templates()
    {
        return $this->hasMany(MilestoneTemplate::class);
    }

    public function copyToStudent(StudentRecord $record, $all=false)
    {
        // $this->milestone_templates()
        //      ->get()
        //      ->map()
    }

}
