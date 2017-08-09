<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Absence;
use App\Models\Staff;
use App\Models\Admin;
use App\Models\AbsenceType;
use Auth;

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
        
        $student = factory(Student::class)->create();

        $ab = factory(Absence::class)->make([
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
        
        $staff = factory(Staff::class)->create();

        $ab = factory(Absence::class)->make([
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
        
        $admin = factory(Admin::class)->create();

        $ab = factory(Absence::class)->make([
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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
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
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
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
     * Test absence scope for future period
     *
     * @return void
     */
    public function testScopeForFutureAbsences()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
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
     * Test absence scope for current period
     *
     * @return void
     */
    public function testScopeForCurrentAbsences()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
        ]);

        $this->assertEquals(Absence::past()->count(), 0);
        $this->assertEquals(Absence::current()->count(), 1);
        $this->assertEquals(Absence::future()->count(), 0);

    }

    /**
     * Test an absence can be marked as approved
     *
     * @return void
     */
    public function testMarkingAbsenceAsApproved()
    {
        $this->artisan('db:seed', [ '--class' => 'AbsenceTypeSeeder' ]);
        $staff = factory(Staff::class)->create();
        $student = factory(Student::class)->create();

        $ab = factory(Absence::class)->create([
            'user_id' => $student->id,
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
            'approval_required' => true,
            'approval_granted' => null,
            'approved_by' => null,
            'approved_on' => null,
        ]);

        $this->assertEquals(Absence::IsApproved()->count(), 0);

        Auth::loginUsingId($staff->id);

        $ab->approve();

        $this->assertEquals(Absence::IsApproved()->count(), 1);

    }

    /**
     * Test an interuptive absence calculation with current interuption
     *
     * @return void
     */
    public function testInteruptionDurationCalculationWithCurrent()
    {
        $it = factory(AbsenceType::class)->create( [ 'interuption' => true ] );
        $nit = factory(AbsenceType::class)->create( [ 'interuption' => false ] );
        $stu = factory(Student::class)->create();


        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
            'duration' => 4,
        ]);

        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(10),
            'to'   =>  Carbon::now()->subDays(8),
            'duration' => 2,
        ]);

        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(50),
            'to'   =>  Carbon::now()->subDays(40),
            'duration' => 10,
        ]);

        // future dates should be ignored
        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->addDays(40),
            'to'   =>  Carbon::now()->addDays(50),
            'duration' => 10,
        ]);
        // none interuptive dates should be ignored (current)
        factory(Absence::class)->create([
            'absence_type_id' => $nit->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(5),
            'to'   =>  Carbon::now()->addDays(5),
            'duration' => 10,
        ]);
        // none interuptive dates should be ignored (past)
        factory(Absence::class)->create([
            'absence_type_id' => $nit->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(35),
            'to'   =>  Carbon::now()->subDays(30),
            'duration' => 5,
        ]);

        $this->assertEquals($stu->interuptionPeriodSoFar(), 16);
        $this->assertEquals($stu->interuptionPeriodSoFar(true), 16);
    }

    /**
     * Test an interuptive absence calculation without current interuption
     *
     * @return void
     */
    public function testInteruptionDurationCalculationWithOutCurrent()
    {
        $it = factory(AbsenceType::class)->create( [ 'interuption' => true ] );
        $nit = factory(AbsenceType::class)->create( [ 'interuption' => false ] );

        $stu = factory(Student::class)->create();

        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(10),
            'to'   =>  Carbon::now()->subDays(8),
            'duration' => 2,
        ]);

        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(50),
            'to'   =>  Carbon::now()->subDays(40),
            'duration' => 10,
        ]);

        // future dates should be ignored
        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->addDays(40),
            'to'   =>  Carbon::now()->addDays(50),
            'duration' => 10,
        ]);
        // none interuptive dates should be ignored
        factory(Absence::class)->create([
            'absence_type_id' => $nit->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(5),
            'to'   =>  Carbon::now()->addDays(5),
            'duration' => 10,
        ]);
        // none interuptive dates should be ignored (past)
        factory(Absence::class)->create([
            'absence_type_id' => $nit->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(35),
            'to'   =>  Carbon::now()->subDays(30),
            'duration' => 5,
        ]);
        // current interuption should be ignored
        factory(Absence::class)->create([
            'absence_type_id' => $it->id,
            'user_id' => $stu->id,
            'from' =>  Carbon::now()->subDays(2),
            'to'   =>  Carbon::now()->addDays(2),
            'duration' => 4,
        ]);

        $this->assertEquals($stu->interuptionPeriodSoFar(false), 12);
    }
}
