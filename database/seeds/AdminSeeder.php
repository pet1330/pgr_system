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
        Admin::first()->assignDefaultPermissions();
    }
}
