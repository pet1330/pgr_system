<?php

use Illuminate\Database\Seeder;
use App\Models\MilestoneType;

class MilestoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $examples = [
            [   
                'name' => 'PGR Application decision form',
                'duration' => null,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Arrival Checklist',
                'duration' => null,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Study Plan',
                'duration' => 2,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Confirmation of Studies',
                'duration' => 7,
                'student_makable' => false
            ],
            [   
                'name' => 'Training and Development needs initial report (TDNAI)',
                'duration' => 1,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Monthly Progress form',
                'duration' => 0,
                'student_makable' => true
            ],
            [   
                'name' => 'PGR Annual Monitoring form',
                'duration' => 5,
                'student_makable' => false
            ],
            [   
                'name' => 'Training and Development needs annual report (TDNAA)',
                'duration' => 1,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Request for Transfer',
                'duration' => 14,
                'student_makable' => true
            ],
            [   
                'name' => 'PGR Change of Supervisory Team',
                'duration' => null,
                'student_makable' => true
            ],
            [   
                'name' => 'PGR Thesis Submission Form',
                'duration' => 3,
                'student_makable' => true
            ],
            [   
                'name' => 'PGR Examiners and Viva Chair Form',
                'duration' => 2,
                'student_makable' => true
            ],
            [   
                'name' => 'PGR Examiners Initial report on the Thesis',
                'duration' => null,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Examiners and Chair report on the Thesis and Viva',
                'duration' => null,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Examiners Approval of the Thesis Amendments',
                'duration' => 60,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Confirmation of Award',
                'duration' => 2,
                'student_makable' => false
            ],
            [   
                'name' => 'PGR Research Electronic Thesis Submission Form',
                'duration' => 5,
                'student_makable' => true
            ],
        ];
        foreach ($examples as $example)
        {
            MilestoneType::create([
                'name' => $example['name'],
                'duration' => $example['duration'],
                'student_makable' => $example['student_makable'],
            ]);
        }
    }
}
