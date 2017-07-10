<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRecordsTest extends TestCase
{
    use DatabaseTransactions;


    public function seedDatabaseWithStudentRecordInformation()
    {
        $this->artisan('db:seed', [ '--class' => 'EnrolmentStatusSeeder']);
        $this->artisan('db:seed', [ '--class' => 'ModeOfStudySeeder']);
        $this->artisan('db:seed', [ '--class' => 'StudentStatusSeeder']);
        $this->artisan('db:seed', [ '--class' => 'ProgramSeeder']);
        $this->artisan('db:seed', [ '--class' => 'CollegeSeeder']);
        $this->artisan('db:seed', [ '--class' => 'SchoolSeeder']);
        $this->artisan('db:seed', [ '--class' => 'FundingTypeSeeder']);
    }

    /**
     * Test User can save a Record
     *
     * @return void
     */
    public function testSavingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory( App\Models\Student::class, 10 )
          ->create()
          ->each( function ( $stu ) {
                $stu
                    ->records()
                    ->save( factory( App\Models\StudentRecord::class )->make() );
            } );
        $this->assertEquals(App\Models\StudentRecord::count(), 10);
    }

    /**
     * Test User has A Record
     *
     * @return void
     */
    public function testGettingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory( App\Models\Student::class,10 )
          ->create()
          ->each( function ( $stu )
          {
                $stu
                    ->records()
                    ->save( factory( App\Models\StudentRecord::class )->make() );
            } );

        $students = App\Models\Student::all();

        foreach ($students as $stu)
        {
            $this->assertTrue( $stu->records()->count() === 1 );
        }
    }

    public function testCreatingStudentRecordAndInfo()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory( App\Models\Student::class,10 )
            ->create()
            ->each( function ( $stu )
            {
                $stu
                    ->records()
                    ->save( factory( App\Models\StudentRecord::class )->make() );
            } );

        $students = App\Models\Student::all();

        foreach ($students as $stu)
        {
            $this->assertTrue( $stu->records()->count() === 1 );
        }
    }
}
