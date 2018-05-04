<?php

use App\Models\EnrolmentStatus;
use Illuminate\Database\Seeder;

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

        foreach ($example_statuses as $status) {
            EnrolmentStatus::create([
                'status' => $status,
            ]);
        }
    }
}
