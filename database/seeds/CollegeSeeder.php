<?php

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_colleges = [
            'College of Arts',
            'College of Science',
            'College of Social Science', ];

        foreach ($example_colleges as $college) {
            College::create(['name' => $college]);
        }
    }
}
