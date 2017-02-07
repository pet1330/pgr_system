<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StudentSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(WizardSeeder::class);
    }
}
