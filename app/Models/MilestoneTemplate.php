<?php

namespace App\Models;

use Bouncer;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilestoneTemplate extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = ['due', 'milestone_type_id'];

    protected $table = 'milestone_templates';

    protected $with = ['type'];

    protected $fillable = ['due', 'milestone_type_id', 'timeline_template_id'];

    public function type()
    {
        return $this->belongsTo(MilestoneType::class, 'milestone_type_id')->withTrashed();
    }

    public function timeline_template()
    {
        return $this->belongsTo(TimelineTemplate::class);
    }

    public function create_milestone(StudentRecord $record)
    {
        $nid = $record->enrolment_date->copy()->addMonths($this->due);

        $m = $record->timeline()->save(
            Milestone::create([
                'non_interuptive_date' => $nid,
                'student_record_id' => $record->id,
                'created_by' => auth()->id(),
                'milestone_type_id' => $this->type->id,
                'due_date' => $nid->copy()->addDays(
                    $record->student->interuptionPeriodSoFar()),
            ])
        );
        $record->student->allow('view', $m);
        $record->student->allow('upload', $m);
        Bouncer::refreshFor($record->student);
        $record->supervisors->each(function (Staff $staff) use ($m) {
            $staff->allow('view', $m);
            Bouncer::refreshFor($staff);
        });
    }
}
