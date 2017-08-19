<?php

use Illuminate\Database\Seeder;
use App\Models\TimelineTemplate;

class TimelineTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TimelineTemplate::class, 3)->create();
    }
}
