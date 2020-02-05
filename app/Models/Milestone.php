<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Spatie\Activitylog\Traits\LogsActivity;

class Milestone extends Model
{
    use Mediable;
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected $table = 'milestones';

    protected $with = ['type', 'approvals'];

    protected $dates = [
        'due_date',
        'submitted_date',
        'non_interuptive_date',
        'deleted_at',
    ];

    protected static $logAttributes = [
        'name',
        'duration',
        'created_by',
        'submitted_date',
        'milestone_type_id',
        'student_record_id',
        'non_interuptive_date',
    ];

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

    public static function boot()
    {
        parent::boot();

        static::deleting(function (self $milestone) {
            if ($milestone->isForceDeleting()) {
                $milestone->approvals->each->forceDelete();
                $milestone->media()->withTrashed()->get()->each->forceDelete();
            } else {
                $milestone->media()->get()->each->delete();
                $milestone->approvals->each->delete();
            }
        });

        static::restoring(function (self $milestone) {
            $deleted_time = $milestone->deleted_at->copy()->subSecond();
            $milestone->media()->withTrashed()
                ->where('deleted_at', '>=', $deleted_time)
                ->get()->each->restore();
            $milestone->approvals()->withTrashed()->get()->each->restore();
        });
    }

    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->type->name;
    }

    public function getDurationAttribute()
    {
        return $this->attributes['duration'] ?: $this->type->duration;
    }

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_record_id');
    }

    public function type()
    {
        return $this->belongsTo(MilestoneType::class, 'milestone_type_id')->withTrashed();
    }

    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_date');
    }

    public function isSubmitted()
    {
        return (bool) $this->submitted_date;
    }

    public function scopeNotSubmitted($query)
    {
        return $query->whereNull('submitted_date');
    }

    public function isNotSubmitted()
    {
        return ! $this->isSubmitted();
    }

    public function scopePreviouslySubmitted($query)
    {
        return $query->submitted()->where('submitted_date', '<=',
            Carbon::parse('-5 weeks'))->doesntHave('approvals');
    }

    public function isPreviouslySubmitted()
    {
        return $this->isSubmitted() &&
            $this->submitted_date <= Carbon::parse('-5 weeks') &&
            $this->approvals->isEmpty();
    }

    public function scopeRecentlySubmitted($query)
    {
        return $query->submitted()->where('submitted_date', '>',
            Carbon::parse('-5 weeks'))->doesntHave('approvals');
    }

    public function isRecentlySubmitted()
    {
        return $this->isSubmitted() &&
            $this->submitted_date > Carbon::parse('-5 weeks') &&
            $this->approvals->isEmpty();
    }

    public function scopeUnderReview($query)
    {
        return $query->submitted()->where('submitted_date', '<=',
            Carbon::today())->doesntHave('approvals');
    }

    public function isUnderReview()
    {
        return $this->isSubmitted() &&
            $this->approvals->isEmpty();
    }

    public function scopeUpcoming($query)
    {
        return $query->notSubmitted()->where('due_date', '>=', Carbon::today())
                     ->where('due_date', '<', Carbon::parse('+5 weeks'))
                     ->doesntHave('approvals');
    }

    public function isUpcoming()
    {
        return $this->isNotSubmitted() &&
        $this->due_date >= Carbon::today() &&
        $this->due_date < Carbon::parse('+5 weeks') &&
        $this->approvals->isEmpty();
    }

    public function scopeOverdue($query)
    {
        return $query->notSubmitted()
            ->where('due_date', '<', Carbon::today())
            ->doesntHave('approvals');
    }

    public function isOverdue()
    {
        return $this->isNotSubmitted() &&
            $this->due_date < Carbon::today() &&
            $this->approvals->isEmpty();
    }

    public function scopeFuture($query)
    {
        return $query->notSubmitted()->where('due_date', '>',
            Carbon::parse('+5 weeks'))
            ->doesntHave('approvals');
    }

    public function isFuture()
    {
        return $this->isNotSubmitted() &&
            $this->due_date > Carbon::parse('+5 weeks') &&
            $this->approvals->isEmpty();
    }

    public function scopeAwaitingAmendments($query, $selector = null)
    {
        return $query->filterApprovals(false, $selector);
    }

    public function isAwaitingAmendments()
    {
        return $this->approvals->isNotEmpty() && ! $this->approvals->last()->approved;
    }

    public function scopeApproved($query, $selector = null)
    {
        return $query->filterApprovals(true, $selector);
    }

    public function isApproved()
    {
        return $this->approvals->isNotEmpty() && $this->approvals->last()->approved;
    }

    public function scopeFilterApprovals($query, $accepted = true, $selector = null)
    {
        return $query->select($selector ?? 'milestones.*')
            ->join('approvals', 'milestones.id', '=', 'approvals.approvable_id')
            ->join(DB::raw('(SELECT approvable_id, MAX(created_at) created_at
                FROM approvals GROUP BY approvable_id) aa'), function ($join) {
                $join->on('approvals.approvable_id', '=', 'aa.approvable_id')
                     ->on('approvals.created_at', '=', 'aa.created_at');
            })->where('approvals.approved', (bool) $accepted);
    }

    public function getStartDateAttribute()
    {
        if ($this->duration) {
            return $this->due_date->copy()->subDays($this->duration);
        }

        return $this->due_date;
    }

    public function startsToday()
    {
        return $this->start_date->isToday();
    }

    public function usefulDate()
    {
        return $this->submitted_date ?? $this->due_date;
    }

    public function getStatusAttribute()
    {
        return snake_case($this->attributes['status_for_humans']);
    }

    public function getStatusForHumansAttribute()
    {
        if ($this->isRecentlysubmitted()) {
            return 'Recently Submitted';
        }
        if ($this->isOverdue()) {
            return 'Overdue';
        }
        if ($this->isPreviouslySubmitted()) {
            return 'Submitted';
        }
        if ($this->isUpcoming()) {
            return 'Upcoming';
        }
        if ($this->isFuture()) {
            return 'Future';
        }
        if ($this->isAwaitingAmendments()) {
            return 'Awaiting Amendments';
        }
        if ($this->isApproved()) {
            return 'Approved';
        }
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function approve($approved = true, $feedback = null)
    {
        return $this->approvals()->save(
            Approval::make([
                'approved' => $approved,
                'reason' => $feedback,
                'approved_by_id' => auth()->id(),
            ])
        );
    }

    public function recalculateDueDate()
    {
        $this->update(['due_date' => $this->non_interuptive_date->copy()
            ->addDays($this->student->student->interuptionPeriodSoFar($this->due_date)), ]);
    }
}
