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
            ['name' => 'PGR Application decision form', 'duration' => null],
            ['name' => 'PGR Arrival Checklist', 'duration' => null],
            ['name' => 'PGR Study Plan', 'duration' => 2],
            ['name' => 'PGR Confirmation of Studies', 'duration' => 7],
            ['name' => 'Training and Development needs initial report (TDNAI)', 'duration' => 1],
            ['name' => 'PGR Monthly Progress form', 'duration' => 0],
            ['name' => 'PGR Annual Monitoring form', 'duration' => 5],
            ['name' => 'Training and Development needs annual report (TDNAA)', 'duration' => 1],
            ['name' => 'PGR Request for Transfer', 'duration' => 14],
            ['name' => 'PGR Change of Supervisory Team', 'duration' => null],
            ['name' => 'PGR Thesis Submission Form', 'duration' => 3],
            ['name' => 'PGR Examiners and Viva Chair Form', 'duration' => 2],
            ['name' => 'PGR Examiners Initial report on the Thesis', 'duration' => null],
            ['name' => 'PGR Examiners and Chair report on the Thesis and Viva', 'duration' => null],
            ['name' => 'PGR Examiners Approval of the Thesis Amendments', 'duration' => 60],
            ['name' => 'PGR Confirmation of Award', 'duration' => 2],
            ['name' => 'PGR Research Electronic Thesis Submission Form', 'duration' => 5],
        ];
        foreach ($examples as $example)
        {
            MilestoneType::create([
                'name' => $example['name'],
                'duration' => $example['duration'],
            ]);
        }
    }
}
