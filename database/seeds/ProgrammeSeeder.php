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
        $example_programmes =
            [
                ['name' => 'PhD', 'duration' => 42, 'duration_unit' => 'Months' ],
                ['name' => 'MSc', 'duration' => 12, 'duration_unit' => 'Months' ],
                ['name' => 'MPhil', 'duration' => 18,'duration_unit' => 'Months' ]
            ];
        foreach ($example_programmes as $programme)
        {
            Programme::create([
                'name' => $programme['name'],
                'duration' => $programme['duration'],
                'duration_unit' => $programme['duration_unit'],
            ]);
        }
    }
}
