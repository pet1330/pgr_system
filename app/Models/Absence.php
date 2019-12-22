<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Absence extends Model
{
    use SoftDeletes;
    use LogsActivity;
    use HasHashSlug;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'user_id',
        'absence_type_id',
        'from',
        'to',
        'duration',
    ];

    protected $with = ['type'];

    protected $fillable = [
        'user_id',
        'absence_type_id',
        'from',
        'to',
        'duration',
    ];

    protected $dates = [
        'from',
        'to',
    ];

    public function type()
    {
        return $this->belongsTo(AbsenceType::class, 'absence_type_id')->withTrashed();
    }

    public function student()
    {
        return $this->belongsTo(student::class, 'user_id');
    }

    public function isFuture($date = null)
    {
        return ($date ?? Carbon::now()) < $this->from;
    }

    public function isPast($date = null)
    {
        return ($date ?? Carbon::now()) > $this->to;
    }

    public function isCurrent($date = null)
    {
        $date = $date ?? Carbon::now();

        return $date >= $this->from && $date <= $this->to;
    }

    public function scopePast($query)
    {
        return $query->where('to', '<', Carbon::now())
        ->orderBy('from', 'desc')->get();
    }

    public function scopeCurrent($query)
    {
        return $query
        ->where('from', '<=', Carbon::now())
        ->where('to', '>=', Carbon::now())
        ->orderBy('from', 'desc')->get();
    }

    public function scopeFuture($query)
    {
        return $query->where('from', '>', Carbon::now())
        ->orderBy('from', 'asc')->get();
    }
}
