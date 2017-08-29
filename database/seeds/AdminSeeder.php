<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \factory(App\Models\Admin::class,20)->create();
        App\Models\Admin::first()->assign('manage_access_control');
    }
}
