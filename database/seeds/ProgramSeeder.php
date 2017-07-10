<?php

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
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
            Program::create([
                'status' => $status,
                'status_type' => 'program'
            ]);
        }
    }
}
