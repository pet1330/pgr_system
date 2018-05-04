<?php

namespace App\Models;

use Bouncer;
use Carbon\Carbon;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentRecord extends Model
{
    protected $with = ['supervisors'];

    protected $dates = ['enrolment_date'];

    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'tierFour',
        'school_id',
        'student_id',
        'programme_id',
        'enrolment_date',
        'funding_type_id',
        'student_status_id',
        'enrolment_status_id',
    ];

    protected $fillable = [
        'tierFour',
        'school_id',
        'student_id',
        'programme_id',
        'enrolment_date',
        'funding_type_id',
        'student_status_id',
        'enrolment_status_id',
    ];

    /**
     * Get the student that this record belongs to.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function college()
    {
        return $this->school->college;
    }

    public function school()
    {
        return $this->belongsTo(School::class)->withTrashed();
    }

    public function studentStatus()
    {
        return $this->belongsTo(StudentStatus::class)->withTrashed();
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class)->withTrashed();
    }

    public function enrolmentStatus()
    {
        return $this->belongsTo(EnrolmentStatus::class)->withTrashed();
    }

    public function getDirectorOfStudyAttribute()
    {
        return $this->supervisor(1);
    }

    public function getSecondSupervisorAttribute()
    {
        return $this->supervisor(2);
    }

    public function getThirdSupervisorAttribute()
    {
        return $this->supervisor(3);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Staff::class, 'supervisors')
                    ->wherePivot('changed_on', null)
                    ->withPivot('supervisor_type')
                    ->withTimestamps();
    }

    public function supervisor($supervisorType)
    {
        return $this->supervisors()
            ->wherePivot('supervisor_type', $supervisorType)->first();
    }

    public function removeSupervisor(Staff $supervisor)
    {
        $supervisor->disallow('view', $this->student);

        $this->timeline->each(function (Milestone $m) use ($supervisor) {
            $supervisor->disallow('view', $m);
        });
        Bouncer::refreshFor($supervisor);

        return $this->supervisors()
                    ->updateExistingPivot($supervisor->id,
                        ['changed_on' => Carbon::now()]);
    }

    public function addSupervisor(Staff $supervisor, $type)
    {
        $supervisor->allow('view', $this->student);

        $this->timeline->each(function (Milestone $m) use ($supervisor) {
            $supervisor->allow('view', $m);
        });
        Bouncer::refreshFor($supervisor);

        return $this->supervisors()->syncWithoutDetaching(
            [
                $supervisor->id =>  ['supervisor_type' => $type],
            ]
        );
    }

    public function fundingType()
    {
        return $this->belongsTo(FundingType::class)->withTrashed();
    }

    public function timeline()
    {
        return $this->hasMany(Milestone::class);
    }

    public function getStartAttribute()
    {
        return $this->enrolment_date;
    }

    public function getEndAttribute()
    {
        return $this->calculateEndDate();
    }

    public function calculateEndDate()
    {
        return $this->enrolment_date->copy()
                    ->addMonths($this->programme->duration)
                    ->addDays($this->student->totalInteruptionPeriod());
    }

    public function recalculateMilestonesDueDate()
    {
        return $this->timeline()->notSubmitted()->get()->each->recalculateDueDate();
    }

    public function ordinal($number)
    {
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number.'th';
        } else {
            return $number.['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][$number % 10];
        }
    }

    public function note()
    {
        return $this->morphOne(Note::class, 'noteable')->withDefault();
    }

    public function updateNote($content = '')
    {
        $this->note->exists ?
            $this->note->update(['content' => $content]) :
            $this->note()->save(Note::make(['content' => $content]));
    }

    public function visualTimelineEnd()
    {
        $e = $this->timeline()->orderBy('due_date', 'desc')->pluck('due_date')->first();
        if ($e) {
            return max($e, $this->end);
        }

        return $this->end;
    }

    public function visualTimelineStart()
    {
        $s = $this->timeline()->orderBy('due_date')->pluck('due_date')->first();
        if ($s) {
            return min($s, $this->start);
        }

        return $this->start;
    }
}
