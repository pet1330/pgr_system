<?php

use Illuminate\Database\Seeder;
use App\Models\College;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $example_schools = 
        [
            'College of Arts' => 
            [
                'School of Architecture & Design',
                'School of English & Journalism',
                'Lincoln School of Film & Media',
                'School of Fine & Performing Arts',
                'School of History & Heritage',
            ],

            'College of Science' => 
            [
                'School of Chemistry',
                'School of Computer Science',
                'School of Engineering',
                'School of Geography',
                'School of Life Sciences',
                'School of Mathematics and Physics',
                'School of Pharmacy',
            ],

            'College of Social Science' => 
            [
                'School of Education',
                'School of Health and Social Care ',
                'Lincoln Law School',
                'School of Psychology',
                'School of Social & Political Sciences',
                'School of Sport and Exercise Science',
                'International Business School',
            ]
        ];

        foreach($example_schools as $college => $schools)
        {
            $college_id = College::whereName($college)->pluck('id')->first();
            foreach ($schools as $school)
            {
                School::create([
                    'name' => $school,
                    'college_id' => $college_id,
                    ]);
            }
        }
    }
}
