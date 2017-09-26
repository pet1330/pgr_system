<?php

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \factory(Student::class,500)->create();

        Student::all()->each(function(Student $s) {
            $s->allow('view', $s);
        });
        Bouncer::refresh();
    }
}
