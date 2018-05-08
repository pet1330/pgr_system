<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Absence;
use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbsenceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if a student has an absence.
     *
     * @return void
     */
    public function testStudentHasAbsence()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);

        $student = factory(Student::class)->create();

        $ab = factory(Absence::class)->make([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);
        $student->absences()->save($ab);
        $this->assertEquals($student->absences()->count(), 1);
    }

    /**
     * Test if an absence period is happening now.
     *
     * @return void
     */
    public function testAbsenceIsHappeningNow()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        $student = factory(Student::class)->create();

        $pastAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $futureAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $currentAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);

        $this->assertFalse($pastAbence->isCurrent());
        $this->assertFalse($futureAbence->isCurrent());
        $this->assertTrue($currentAbence->isCurrent());
    }

    /**
     * Test if an absence period has already happened and finished.
     *
     * @return void
     */
    public function testAbsenceHasHappenedAndFinished()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        $student = factory(Student::class)->create();

        $pastAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $futureAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $currentAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);

        $this->assertTrue($pastAbence->isPast());
        $this->assertFalse($futureAbence->isPast());
        $this->assertFalse($currentAbence->isPast());
    }

    /**
     * Test if an absence period has yet to start.
     *
     * @return void
     */
    public function testAbsenceHasNotStartedYet()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        $student = factory(Student::class)->create();

        $pastAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $futureAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $currentAbence = factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);

        $this->assertFalse($pastAbence->isFuture());
        $this->assertTrue($futureAbence->isFuture());
        $this->assertFalse($currentAbence->isFuture());
    }

    /**
     * Test absence scope for past period.
     *
     * @return void
     */
    public function testScopeForPastAbsences()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $this->assertEquals(Absence::past()->count(), 1);
        $this->assertEquals(Absence::current()->count(), 0);
        $this->assertEquals(Absence::future()->count(), 0);
    }

    /**
     * Test absence scope for future period.
     *
     * @return void
     */
    public function testScopeForFutureAbsences()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $this->assertEquals(Absence::past()->count(), 0);
        $this->assertEquals(Absence::current()->count(), 0);
        $this->assertEquals(Absence::future()->count(), 1);
    }

    /**
     * Test absence scope for current period.
     *
     * @return void
     */
    public function testScopeForCurrentAbsences()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);

        $this->assertEquals(Absence::past()->count(), 0);
        $this->assertEquals(Absence::current()->count(), 1);
        $this->assertEquals(Absence::future()->count(), 0);
    }
}
