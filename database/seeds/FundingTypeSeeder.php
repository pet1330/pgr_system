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
        $examples = ['rif', 'project', 'self_funding'];

        foreach ($examples as $example)
        {
            FundingType::create([
                'name' => $example
            ]);
        }
    }
}
