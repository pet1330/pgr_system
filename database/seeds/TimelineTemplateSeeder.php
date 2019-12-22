<?php

use App\Models\TimelineTemplate;
use Illuminate\Database\Seeder;

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
