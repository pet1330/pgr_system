<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    
    use SoftDeletes;

    protected $table ='milestones';

    protected $with = ['milestone_type'];

    protected $fillable = [
        'name',
        'duration',
        'due',
        'submission_date',
        'student_record_id',
        'milestone_type_id'
    ];

    public static function fromTemplate(StudentRecord $record, MilestoneTemplate $template)
    {
        return $record->timeline->save([
            'due' => $template->due,
            'milestone_type_id' => $template->milestone_type->id,
            ]);
    }

    public function getNameAttribute()
    {
        return $this->name ?? $this->milestone_type->name;
    }

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_record_id');
    }

    public function milestone_type()
    {
        return $this->belongsTo(MilestoneType::class);
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePendingApproval($query)
    {
        return $query->where('approval_required', 1)
              ->whereNotNull('submission_date')
              ->whereNull('approval_granted')
              ->orWhere('approval_granted', 0);
    }

    public function pending_approval()
    {
        return $this->approval_required &&
               $this->submission_date && 
               ! $this->approval_granted;
    }

    public function isSubmitted()
    {
        return !! $this->submission_date;
    }

    public function startDate()
    {
        return $this->endDate->subMonths($this->duration);
    }

    public function endDate()
    {
        return $this->student->start->addMonths($this->due);
    }
} 
