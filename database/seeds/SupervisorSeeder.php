<?php

use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentRecord;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff = Staff::all();

        StudentRecord::all()->each(function(StudentRecord $sr) use ($staff)
        {
            $staff->random(3)->each(function(Staff $s) use ($sr)
            {
                $sr->addSupervisor( $s, $sr->supervisors()->count()+1 );
            });
        });
    }
}
