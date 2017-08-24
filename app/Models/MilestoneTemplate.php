<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    use Spatie\Activitylog\Traits\LogsActivity;

class MilestoneTemplate extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [ 'due', 'milestone_type_id' ];

    protected $table ='milestone_templates';

    protected $with = ['milestone_type'];

    protected $fillable = ['due', 'milestone_type_id'];


    public function milestone_type()
    {
        return $this->belongsTo(MilestoneType::class);
    }

    public function timeline_template()
    {
        return $this->belongsTo(TimelineTemplate::class);
    }

    public function create_milestone(StudentRecord $record)
    {
        return $record->timeline->save([
                'due' => $this->due,
                'milestone_type_id' => $this->milestone_type->id,
            ]);
    }
}
