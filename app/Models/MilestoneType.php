<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilestoneType extends Model
{
    use SoftDeletes;
    
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
