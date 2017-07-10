<?php

use Illuminate\Database\Seeder;
use App\Models\FundingType;

class FundingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_statuses = ['rif', 'project', 'self_funding'];

        foreach ($example_statuses as $status)
        {
            FundingType::create([
                'status' => $status,
                'status_type' => 'funding_type'
            ]);
        }
    }
}
