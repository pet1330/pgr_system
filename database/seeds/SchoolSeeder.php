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
                [
                    'name' => 'School of Architecture & Design',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of English & Journalism',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'Lincoln School of Film & Media',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Fine & Performing Arts',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of History & Heritage',
                    'contact' => 'school@lincoln.ac.uk'
                ],
            ],

            'College of Science' => 
            [
                [
                    'name' => 'School of Chemistry',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Computer Science',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Engineering',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Geography',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Life Sciences',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Mathematics and Physics',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Pharmacy',
                    'contact' => 'school@lincoln.ac.uk'
                ],
            ],

            'College of Social Science' => 
            [
                [
                    'name' => 'School of Education',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Health and Social Care ' ,
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'Lincoln Law School',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Psychology',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Social & Political Sciences',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'School of Sport and Exercise Science',
                    'contact' => 'school@lincoln.ac.uk'
                ],
                [
                    'name' => 'International Business School',
                    'contact' => 'school@lincoln.ac.uk'
                ],
            ]
        ];

        foreach($example_schools as $college => $schools)
        {
            $college = College::whereName($college)->pluck('id')->first();
            foreach ($schools as $school)
            {
                School::create([
                    'name' => $school['name'],
                    'college_id' => $college,
                    'notifications_address' => $school['contact'],
                    ]);
            }
        }
    }
}
