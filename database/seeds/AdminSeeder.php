<?php

use App\Models\Admin;
use App\Models\School;
use App\Models\Staff;
use App\Models\Absence;
use App\Models\College;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\Programme;
use App\Models\AbsenceType;
use App\Models\FundingType;
use App\Models\ModeOfStudy;
use App\Models\StudentStatus;
use Illuminate\Database\Seeder;
use App\Models\EnrolmentStatus;
use App\Models\TimelineTemplate;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \factory(App\Models\Admin::class,20)->create();
        
        Admin::first()->allow('create', Absence::class);
        Admin::first()->allow('view', Absence::class);
        Admin::first()->allow('update', Absence::class);
        Admin::first()->allow('delete', Absence::class);
        Admin::first()->allow('create', Milestone::class);
        Admin::first()->allow('view', Milestone::class);
        Admin::first()->allow('update', Milestone::class);
        Admin::first()->allow('delete', Milestone::class);
        Admin::first()->allow('upload', Milestone::class);
        Admin::first()->allow('create', Programme::class);
        Admin::first()->allow('view', Programme::class);
        Admin::first()->allow('update', Programme::class);
        Admin::first()->allow('delete', Programme::class);
        Admin::first()->allow('create', Staff::class);
        Admin::first()->allow('update', Staff::class);
        Admin::first()->allow('view', Staff::class);
        Admin::first()->allow('create', AbsenceType::class);
        Admin::first()->allow('view', AbsenceType::class);
        Admin::first()->allow('update', AbsenceType::class);
        Admin::first()->allow('delete', AbsenceType::class);
        Admin::first()->allow('create', Admin::class);
        Admin::first()->allow('view', Admin::class);
        Admin::first()->allow('create', College::class);
        Admin::first()->allow('view', College::class);
        Admin::first()->allow('update', College::class);
        Admin::first()->allow('delete', College::class);
        Admin::first()->allow('create', EnrolmentStatus::class);
        Admin::first()->allow('view', EnrolmentStatus::class);
        Admin::first()->allow('update', EnrolmentStatus::class);
        Admin::first()->allow('delete', EnrolmentStatus::class);
        Admin::first()->allow('create', FundingType::class);
        Admin::first()->allow('view', FundingType::class);
        Admin::first()->allow('update', FundingType::class);
        Admin::first()->allow('delete', FundingType::class);
        Admin::first()->allow('create', ModeOfStudy::class);
        Admin::first()->allow('view', ModeOfStudy::class);
        Admin::first()->allow('update', ModeOfStudy::class);
        Admin::first()->allow('delete', ModeOfStudy::class);
        Admin::first()->allow('create', School::class);
        Admin::first()->allow('view', School::class);
        Admin::first()->allow('update', School::class);
        Admin::first()->allow('delete', School::class);
        Admin::first()->allow('create', Student::class);
        Admin::first()->allow('view', Student::class);
        Admin::first()->allow('update', Student::class);
        Admin::first()->allow('delete', Student::class);
        Admin::first()->allow('create', StudentStatus::class);
        Admin::first()->allow('view', StudentStatus::class);
        Admin::first()->allow('update', StudentStatus::class);
        Admin::first()->allow('delete', StudentStatus::class);
        Admin::first()->allow('view', Approval::class);
        Admin::first()->allow('create', Approval::class);
        Admin::first()->allow('view', TimelineTemplate::class);
        Admin::first()->allow('create', TimelineTemplate::class);
        Admin::first()->allow('update', TimelineTemplate::class);
    }
}
