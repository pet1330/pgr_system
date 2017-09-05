<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Milestone;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentRecord extends Model
{
    protected $dates = [ 'enrolment_date' ];
    
    use LogsActivity;
    use SoftDeletes;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'student_id',
        'school_id',
        'enrolment_date',
        'student_status_id',
        'programme_id',
        'enrolment_status_id',
        'funding_type_id',
        'mode_of_study_id',
        'tierFour'
    ];

    protected $fillable = [
        'student_id',
        'school_id',
        'enrolment_date', 
        'student_status_id',
        'programme_id',
        'enrolment_status_id',
        'funding_type_id',
        'mode_of_study_id',
        'tierFour',
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

    public function modeOfStudy()
    {
        return $this->belongsTo(ModeOfStudy::class)->withTrashed();
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
        return $this->supervisors()
                    ->updateExistingPivot(
                        $supervisor->id,
                        ['changed_on' => Carbon::now()]
                    );
    }

    public function addSupervisor(Staff $supervisor, $type)
    {
        return $this->supervisors()->syncWithoutDetaching(
            [
                $supervisor->id =>  [ "supervisor_type" => $type ]
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
        $unit = "add" . ucfirst($this->programme->duration_unit);
        return $this->enrolment_date
                    ->copy()
                    ->addMonths(
                        $this->programme->duration * 
                        $this->modeOfStudy->timing_factor)
                    ->addDays(
                        $this->student->interuptionPeriodSoFar());
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
