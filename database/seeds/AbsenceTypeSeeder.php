<?php

use App\Models\AbsenceType;
use Illuminate\Database\Seeder;

class AbsenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $examples = [
            'holiday' => 0,
            'sickness' => 0,
            'conference' => 0,
            'fieldwork' => 0,
            'long term sick' => 1,
            'unknown (interuptive)' => 1,
            'unknown (non interuptive)' => 0, ];

        foreach ($examples as $name => $interupts) {
            AbsenceType::create([
                'name' => $name,
                'interuption' => $interupts,
            ]);
        }
    }
}
