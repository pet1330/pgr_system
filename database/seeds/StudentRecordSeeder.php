<?php

use App\Models\Student;
use App\Models\StudentRecord;
use Illuminate\Database\Seeder;

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
        foreach ($students as $student) {
            $record = $student->records()->save(
                factory(StudentRecord::class)->make(), 'student_id');
        }
    }
}
