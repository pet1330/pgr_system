<?php

use Illuminate\Database\Seeder;
use App\Models\StudentStatus;

class StudentStatusSeeder extends Seeder
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
            StudentStatus::create([
                'status' => $status,
                'status_type' => 'student'
            ]);
        }
    }
}
    