<?php

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\Staff;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentRecord::all()->each(function($sr)
        {
            Staff::inRandomOrder()
            ->take(3)
            ->get()
            ->each(function($s) use ($sr)
            {
                $sr->addSupervisor( $s, $sr->supervisors()->count()+1 );
            });
        });
    }
}
