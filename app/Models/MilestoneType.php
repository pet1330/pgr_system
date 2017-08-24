<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    use Spatie\Activitylog\Traits\LogsActivity;

class MilestoneType extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [ 'name', 'duration' ];
    
    protected $table ='milestone_types';

    protected $fillable = [ 'name', 'duration' ];

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function milestone_templates()
    {
        return $this->hasMany(MilestoneTemplate::class);
    }
}
