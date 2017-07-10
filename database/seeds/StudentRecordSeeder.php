<?php

use Illuminate\Database\Seeder;
use App\Models\StudentRecord;
use App\Models\Student;

class StudentRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
        foreach ($students as $student)
        {
            $student->records()->save(factory(StudentRecord::class)->make() , 'student_id' );
        }
    }
}
