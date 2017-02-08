<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRecordsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test User can save a Record
     *
     * @return void
     */
    public function testSavingStudentRecord()
    {
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
    public function testGettingStudentRecord(){

        factory( App\Models\Student::class,10 )
          ->create()
          ->each( function ( $stu ) {
                $stu
                    ->records()
                    ->save( factory( App\Models\StudentRecord::class )->make() );
            } );

        $students = App\Models\Student::all();

        foreach ($students as $stu) {
            $this->assertTrue( $stu->records()->count() === 1 );
        }
    }
}
