<?php

namespace App\Models;

use Bouncer;
use App\Scopes\UserScope;

class Admin extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('Admin'));
    }

    public function assignDefaultPermissions($reset=false)
    {
        $this->allow('create', Absence::class);
        $this->allow('view', Absence::class);
        $this->allow('update', Absence::class);
        $this->allow('delete', Absence::class);
        $this->allow('create', Milestone::class);
        $this->allow('view', Milestone::class);
        $this->allow('update', Milestone::class);
        $this->allow('delete', Milestone::class);
        $this->allow('upload', Milestone::class);
        $this->allow('create', Programme::class);
        $this->allow('view', Programme::class);
        $this->allow('update', Programme::class);
        $this->allow('delete', Programme::class);
        $this->allow('create', Staff::class);
        $this->allow('update', Staff::class);
        $this->allow('view', Staff::class);
        $this->allow('create', AbsenceType::class);
        $this->allow('view', AbsenceType::class);
        $this->allow('update', AbsenceType::class);
        $this->allow('delete', AbsenceType::class);
        $this->allow('create', Admin::class);
        $this->allow('view', Admin::class);
        $this->allow('create', College::class);
        $this->allow('view', College::class);
        $this->allow('update', College::class);
        $this->allow('delete', College::class);
        $this->allow('create', EnrolmentStatus::class);
        $this->allow('view', EnrolmentStatus::class);
        $this->allow('update', EnrolmentStatus::class);
        $this->allow('delete', EnrolmentStatus::class);
        $this->allow('create', FundingType::class);
        $this->allow('view', FundingType::class);
        $this->allow('update', FundingType::class);
        $this->allow('delete', FundingType::class);
        $this->allow('create', School::class);
        $this->allow('view', School::class);
        $this->allow('update', School::class);
        $this->allow('delete', School::class);
        $this->allow('create', Student::class);
        $this->allow('view', Student::class);
        $this->allow('update', Student::class);
        $this->allow('delete', Student::class);
        $this->allow('create', StudentStatus::class);
        $this->allow('view', StudentStatus::class);
        $this->allow('update', StudentStatus::class);
        $this->allow('delete', StudentStatus::class);
        $this->allow('view', Approval::class);
        $this->allow('create', Approval::class);
        $this->allow('view', TimelineTemplate::class);
        $this->allow('create', TimelineTemplate::class);
        $this->allow('update', TimelineTemplate::class);
        $this->allow('delete', TimelineTemplate::class);
        $this->allow('create', MilestoneType::class);
        $this->allow('view', MilestoneType::class);
        $this->allow('delete', MilestoneType::class);
        $this->allow('update', MilestoneType::class);
        $this->allow('upload', MilestoneType::class);
        Bouncer::refresh();
    }
}
