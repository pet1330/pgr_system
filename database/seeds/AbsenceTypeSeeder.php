<?php

use Illuminate\Database\Seeder;
use App\Models\AbsenceType;

class AbsenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_statuses = ['holiday', 'sickness', 'conference', 'fieldwork'];

        foreach ($example_statuses as $status)
        {
            AbsenceType::create([
                'status' => $status,
                'status_type' => 'absence'
            ]);
        }
    }
}
