<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Absence extends Model
{
    protected $with = ['absence_type'];

    protected $casts = [
        'approval_required' => 'boolean',
        'approval_granted' => 'boolean',

    ];

    protected $fillable = [
        'user_id',
        'absence_type_id',
        'from',
        'to',
        'duration',
        'approval_required',
        'approval_granted',
        'approved_by',
        'approved_on',
    ];

    protected $dates = [
        'from',
        'to',
        'approved_on',

    ];

    public function absence_type()
    {
        return $this->belongsTo(AbsenceType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getTypeAttribute()
    {
        return $this->type();
    }

    public function type()
    {
        return $this->absence_type->status;
    }

    public function scopeNeedsApproving($query)
    {
        return $query->where('approval_required',true)->whereNull('approval_granted');
    }

    public function isFuture()
    {
        return Carbon::now()->lt($this->from);
    }
    
    public function isPast()
    {
        return Carbon::now()->gt($this->to);
    }

    public function isCurrent()
    {
        return Carbon::now()->gte($this->from) && Carbon::now()->lte($this->to);
    }

    public function scopePast($query)
    {
        return $query->where('to', '<', Carbon::now())
        ->orderBy('from', 'desc')->get();
    }

    public function scopeCurrent($query) {
        return $query
        ->where('from', '<=', Carbon::now())
        ->where('to', '>=', Carbon::now())
        ->orderBy('from', 'desc')->get();
    }

    public function scopeFuture($query) {
        return $query->where('from', '>', Carbon::now())
        ->orderBy('from', 'asc')->get();
    }

    public function scopeIsApproved($query)
    {
        return $query->where('approval_granted',true)
                     ->orWhere('approval_required', false);
    }

    public function approve($allowed=true)
    {
        $this->user()->associate( Auth::user() );
        $this->approval_granted = $allowed;
        $this->approved_on = Carbon::now();
        $this->save();
    }

    public function calculateDuration()
    {
        return $this->from
                ->diffInDaysFiltered(function(Carbon $date) {
                    return !$date->isWeekend();
                }, $this->to);
    }
}
