<?php

namespace App\Models;

use Carbon\Carbon;
use Plank\Mediable\Mediable;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use Mediable;
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $minSlugLength = 11;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'name',
        'duration',
        'submitted_date',
        'milestone_type_id',
        'student_record_id',
        'non_interuptive_date',
    ];

    protected $table ='milestones';

    protected $dates = [
        'due_date',
        'submitted_date',
        'non_interuptive_date'
    ];

    protected $with = [ 'milestone_type' ];

    protected $fillable = [
        'name',
        'due_date',
        'duration',
        'created_by',
        'submitted_date',
        'milestone_type_id',
        'student_record_id',
        'non_interuptive_date',
    ];

    public static function fromTemplate(StudentRecord $record, MilestoneTemplate $template)
    {
        // return $record->timeline->save([
            // 'due' => $template->due,
            // 'milestone_type_id' => $template->milestone_type->id,
            // ]);
    }

    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->milestone_type->name;
    }

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_record_id');
    }

    public function milestone_type()
    {
        return $this->belongsTo(MilestoneType::class);
    }

    public function scopePreviouslySubmitted($query)
    {
        return $query->submitted()->where('submitted_date', '<=', Carbon::parse('-5 weeks'));
    }

    public function isPreviouslySubmitted()
    {
        return $this->isSubmitted() && $this->submitted_date <= Carbon::parse('-5 weeks');
    }

    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_date');
    }

    public function isSubmitted()
    {
        return !! $this->submitted_date;
    }

    public function scopeNotSubmitted($query)
    {
        return $query->whereNull('submitted_date');
    }

    public function isNotSubmitted()
    {
        return ! $this->isSubmitted();
    }

    public function scopeRecentlySubmitted($query)
    {
        return $query->submitted()->where('submitted_date', '>', Carbon::parse('-5 weeks'));
    }

    public function isRecentlySubmitted()
    {
        return $this->isSubmitted() && $this->submitted_date > Carbon::parse('-5 weeks');
    }

    public function scopeUpcoming($query)
    {
        return $query->notSubmitted()->where('due_date', '>', Carbon::now())
                     ->where('due_date', '<', Carbon::parse('+5 weeks'));
    }

    public function isUpcoming()
    {
        return $this->isNotSubmitted() && 
        $this->due_date > Carbon::now() &&
        $this->due_date < Carbon::parse('+5 weeks');
    }

    public function scopeOverdue($query)
    {
        return $query->notSubmitted()->where('due_date', '<=', Carbon::now());
    }

    public function isOverdue()
    {
        return $this->isNotSubmitted() && $this->due_date <= Carbon::now();
    }

    public function getStartDateAttribute()
    {
        return $this->due_date->subMonths($this->duration);
    }

    public function usefulDate()
    {
        return $this->submitted_date ?? $this->due_date;
    }

    public function scopeFuture($query)
    {
        return $query->notSubmitted()->where('due_date', '>', Carbon::parse('+5 weeks'));
    }

    public function isFuture()
    {
        return $this->isNotSubmitted() && $this->due_date > Carbon::parse('+5 weeks');
    }

    public function getStatusAttribute()
    {
        return snake_case($this->attributes['status_for_humans']);
    }

    public function getStatusForHumansAttribute()
    {
        if ( $this->isRecentlysubmitted() ) return "Recently Submitted";
        if ( $this->isOverdue() ) return "Overdue";
        if ( $this->isPreviouslySubmitted() ) return "Submitted";
        if ( $this->isUpcoming() ) return "Upcoming";
        if ( $this->isFuture() ) return "Future";
    }  

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }  

}
