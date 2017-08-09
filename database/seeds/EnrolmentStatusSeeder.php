<?php

use Illuminate\Database\Seeder;
use App\Models\EnrolmentStatus;

class EnrolmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_statuses = ['Not Enrolled', 'Enrolled', 'Submitted', 'Graduated', 'Failed'];

        foreach ($example_statuses as $status)
        {
            EnrolmentStatus::create([
                'status' => $status
            ]);
        }
    }
}
