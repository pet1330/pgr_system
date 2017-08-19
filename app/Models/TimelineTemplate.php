<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineTemplate extends Model
{
    use SoftDeletes;

    protected $table ='timeline_templates';

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
