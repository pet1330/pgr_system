<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilestoneTemplate extends Model
{
    use SoftDeletes;

    protected $table ='milestone_templates';

    protected $with = ['milestone_type'];

    protected $fillable = [ 'due', 'milestone_type_id', 'timeline_template_id' ];


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
