<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Student;
use App\Models\StudentRecord;

class StudentRecordsTest extends TestCase
{

    use DatabaseTransactions;

    public function seedDatabaseWithStudentRecordInformation()
    {
        $this->artisan('db:seed', [ '--class' => 'EnrolmentStatusSeeder']);
        $this->artisan('db:seed', [ '--class' => 'StudentStatusSeeder']);
        $this->artisan('db:seed', [ '--class' => 'ProgrammeSeeder']);
        $this->artisan('db:seed', [ '--class' => 'CollegeSeeder']);
        $this->artisan('db:seed', [ '--class' => 'SchoolSeeder']);
        $this->artisan('db:seed', [ '--class' => 'FundingTypeSeeder']);
    }

    /**
     * Test Student can save a Record
     *
     * @return void
     */
    public function testSavingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory( Student::class, 10 )
          ->create()
          ->each( function ( $stu ) {
                $stu
                    ->records()
                    ->save( factory( StudentRecord::class )->make() );
            } );
        $this->assertEquals(StudentRecord::count(), 10);
    }

    /**
     * Test Student has A Record
     *
     * @return void
     */
    public function testGettingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory( Student::class,10 )
          ->create()
          ->each( function ( $stu )
          {
                $stu
                    ->records()
                    ->save( factory( StudentRecord::class )->make() );
            } );

        $students = Student::all();

        foreach ($students as $stu)
        {
            $this->assertTrue( $stu->records()->count() === 1 );
        }
    }

    public function testCreatingStudentRecordAndInfo()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory( Student::class,10 )
            ->create()
            ->each( function ( $stu )
            {
                $stu
                    ->records()
                    ->save( factory( StudentRecord::class )->make() );
            } );

        $students = Student::all();

        foreach ($students as $stu)
        {
            $this->assertTrue( $stu->records()->count() === 1 );
        }
    }
}
