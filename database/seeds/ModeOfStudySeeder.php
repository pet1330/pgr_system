<?php

use Illuminate\Database\Seeder;
use App\Models\ModeOfStudy;

class ModeOfStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_statuses = ['Full Time', 'Part Time', 'Remote'];

        foreach ($example_statuses as $status)
        {
            ModeOfStudy::create([
                'status' => $status,
                'status_type' => 'mode_of_study'
            ]);
        }
    }
}
