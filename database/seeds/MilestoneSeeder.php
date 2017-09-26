<?php

use App\Models\Admin;
use App\Models\Milestone;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use Illuminate\Database\Seeder;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        StudentRecord::all()->map(function ($sr) use ($faker)
        {
            for ($i=0; $i < 10 ; $i++) {
                $sub = $faker->optional()->dateTimeBetween($sr->enrolment_date, $sr->calculateEndDate());
                $due = $faker->dateTimeBetween($sr->enrolment_date, $sr->calculateEndDate());
                $type = MilestoneType::inRandomOrder()->first();
                $m = $sr->timeline()->save(Milestone::make(
                    [
                        'submitted_date'        =>   $sub,
                        'duration'              =>   $faker->numberBetween(1,12),
                        'duration_unit'         =>   'Months',
                        'name'                  =>   $sub ? $type->name : null,
                        'due_date'              =>   $due,
                        'non_interuptive_date'  =>   $due,
                        'milestone_type_id'     =>   $type->id,
                        'created_by'            =>   Admin::first()->id,
                    ])
                );
                $sr->student->allow('view', $m);
                $sr->student->allow('upload', $m);
                $sr->supervisors->map->allow('view', $m);
            }
        });
        Bouncer::refresh();
    }
}
