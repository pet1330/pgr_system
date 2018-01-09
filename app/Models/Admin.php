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

    public function assignElevatedPermissions($reset=false)
    {
        $this->assignDefaultPermissions($reset);

        $this->allow('view', Admin::class);
        $this->allow('manage', Admin::class);
        $this->allow('manage', School::class);
        $this->allow('manage', College::class);
        $this->allow('manage', Programme::class);
        $this->allow('manage', AbsenceType::class);
        $this->allow('manage', FundingType::class);
        $this->allow('manage', StudentStatus::class);
        $this->allow('manage', MilestoneType::class);
        $this->allow('manage', EnrolmentStatus::class);
        $this->allow('manage', TimelineTemplate::class);
        Bouncer::refresh();
    }

    public function assignDefaultPermissions($reset=false)
    {
        if($reset) $this->abilities()->sync([]);

        $this->allow('view', $this);
        $this->allow('view', Note::class);
        $this->allow('view', Staff::class);
        $this->allow('manage', Note::class);
        $this->allow('manage', Staff::class);
        $this->allow('view', Student::class);
        $this->allow('manage', Absence::class);
        $this->allow('view', Milestone::class);
        $this->allow('manage', Student::class);
        $this->allow('manage', Approval::class);
        $this->allow('upload', Milestone::class);
        $this->allow('manage', Milestone::class);
        $this->allow('view', TimelineTemplate::class);
        Bouncer::refresh();
    }
}
