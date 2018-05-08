<?php

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \factory(Staff::class, 100)->create();
        Staff::all()->each(function (Staff $s) {
            $s->allow('view', $s);
        });
        Bouncer::refresh();
    }
}
