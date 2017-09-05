<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $nid = $record->enrolment_date->copy()->addMonths($this->due);

        return $record->timeline()->save(
            Milestone::create([
        'non_interuptive_date' => $nid,
        'student_record_id' => $record->id,
        'created_by' => Auth::id(),
        'milestone_type_id' => $this->milestone_type->id,
        'due_date' => $nid->copy()->addDays($record->student
                                        ->interuptionPeriodSoFar())
            ])
        );
    }
}
