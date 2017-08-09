<?php

use Illuminate\Database\Seeder;
use App\Models\ModeOfStudy;

class ModeOfStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $examples = [
            'Full Time' => 1.,
            'Lazy Full Time' => 1.5,
            'Part Time' => 2.,
            'Every Thursdays Afternoon' => 10.];

        foreach ($examples as $mos => $tf)
        {
            ModeOfStudy::create([
                'name' => $mos,
                'timing_factor' => $tf,
            ]);
        }
    }
}
