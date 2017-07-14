<?php

use Illuminate\Database\Seeder;
use App\Models\Programme;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_statuses = ['PhD', 'MSc', 'MPhil'];

        foreach ($example_statuses as $status)
        {
            Programme::create([
                'status' => $status,
                'status_type' => 'programme'
            ]);
        }
    }
}
