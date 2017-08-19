<?php

use Illuminate\Database\Seeder;
use App\Models\Milestone;
use App\Models\StudentRecord;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentRecord::get()->map(function ($sr)
        {
            $sr->timeline()->saveMany( factory( Milestone::class, 10 )->make() );
        });
    }
}
