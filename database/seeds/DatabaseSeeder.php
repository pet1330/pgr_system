<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // User Seeders
        $this->call(StudentSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(AdminSeeder::class);

        // Student Record Seeders
        $this->call(EnrolmentStatusSeeder::class);
        $this->call(StudentStatusSeeder::class);
        $this->call(ProgrammeSeeder::class);
        $this->call(CollegeSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(FundingTypeSeeder::class);
        $this->call(StudentRecordSeeder::class);

        // Supervisor Seeder
        $this->call(SupervisorSeeder::class);

        // Absence Seeders
        $this->call(AbsenceTypeSeeder::class);
        $this->call(AbsenceSeeder::class);

        // Milestone Seeders
        $this->call(MilestoneTypeSeeder::class);
        $this->call(TimelineTemplateSeeder::class);
        $this->call(MilestoneTemplateSeeder::class);
        $this->call(MilestoneSeeder::class);
    }
}
