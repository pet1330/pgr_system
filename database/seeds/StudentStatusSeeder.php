<?php

use App\Models\StudentStatus;
use Illuminate\Database\Seeder;

class StudentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_statuses = ['UK', 'EU', 'International'];

        foreach ($example_statuses as $status) {
            StudentStatus::create([
                'status' => $status,
            ]);
        }
    }
}
