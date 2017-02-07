<?php

use Illuminate\Database\Seeder;

class WizardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \factory(App\Models\Wizard::class,5)->create();
    }
}
