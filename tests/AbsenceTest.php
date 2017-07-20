<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        
        $student = factory(App\Models\Student::class)->create();

        $ab = factory(App\Models\Absence::class)->make([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);
        $student->absences()->save($ab);
        $this->assertEquals($student->absences()->count(), 1);
    }

    /**
     * Test if a staff has an absence.
     *
     * @return void
     */
    public function testStaffHasAbsence()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        
        $staff = factory(App\Models\Staff::class)->create();

        $ab = factory(App\Models\Absence::class)->make([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);
        $staff->absences()->save($ab);
        $this->assertEquals($staff->absences()->count(), 1);
    }

    /**
     * Test if a admin has an absence.
     *
     * @return void
     */
    public function testAdminHasAbsence()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        
        $admin = factory(App\Models\Admin::class)->create();

        $ab = factory(App\Models\Absence::class)->make([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
            ]);
        $admin->absences()->save($ab);
        $this->assertEquals($admin->absences()->count(), 1);
    }

    /**
     * Test if an absence period is happening now.
     *
     * @return void
     */
    public function testAbsenceIsHappeningNow()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        $student = factory(App\Models\Student::class)->create();
        
        $pastAbence = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $futureAbence = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $currentAbence = factory(App\Models\Absence::class)->create([
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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        $student = factory(App\Models\Student::class)->create();
        
        $pastAbence = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $futureAbence = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $currentAbence = factory(App\Models\Absence::class)->create([
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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        $student = factory(App\Models\Student::class)->create();
        
        $pastAbence = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $futureAbence = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $currentAbence = factory(App\Models\Absence::class)->create([
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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        factory(App\Models\Student::class)->create();

        factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->subDays(4),
            'to'   =>  Carbon::now()->subDays(2),
        ]);

        $this->assertEquals(App\Models\Absence::past()->count(), 1);
        $this->assertEquals(App\Models\Absence::current()->count(), 0);
        $this->assertEquals(App\Models\Absence::future()->count(), 0);
    }

    /**
     * Test absence scope for future period
     *
     * @return void
     */
    public function testScopeForFutureAbsences()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        factory(App\Models\Student::class)->create();

        factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->addDays(2),
            'to'   =>  Carbon::now()->addDays(4),
        ]);

        $this->assertEquals(App\Models\Absence::past()->count(), 0);
        $this->assertEquals(App\Models\Absence::current()->count(), 0);
        $this->assertEquals(App\Models\Absence::future()->count(), 1);
    }

    /**
     * Test absence scope for current period
     *
     * @return void
     */
    public function testScopeForCurrentAbsences()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        factory(App\Models\Student::class)->create();

        factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);

        $this->assertEquals(App\Models\Absence::past()->count(), 0);
        $this->assertEquals(App\Models\Absence::current()->count(), 1);
        $this->assertEquals(App\Models\Absence::future()->count(), 0);

    }

    /**
     * Test an absence can be marked as approved
     *
     * @return void
     */
    public function testMarkingAbsenceAsApproved()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        $staff = factory(App\Models\Student::class)->create();
        factory(App\Models\Staff::class)->create();

        $ab = factory(App\Models\Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
            'approval_required' => true,
            'approval_granted' => null,
            'approved_by' => null,
            'approved_on' => null,
        ]);

        $this->assertEquals(App\Models\Absence::IsApproved()->count(), 0);

        Auth::loginUsingId($staff->id);

        $ab->approve();

        $this->assertEquals(App\Models\Absence::IsApproved()->count(), 1);

    }
}
