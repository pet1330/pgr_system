<?php

use App\Models\MilestoneTemplate;
use Illuminate\Database\Seeder;

class MilestoneTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MilestoneTemplate::class, 10)->create();
    }
}
