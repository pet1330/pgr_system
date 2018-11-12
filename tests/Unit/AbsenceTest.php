<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Absence;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\AbsenceType;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbsenceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if a student has an absence.
     */
    public function test_student_has_absence()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);

        $student = factory(Student::class)->create();

        $ab = factory(Absence::class)->make([
            'from' =>  Carbon::today()->subDays(2),
            'to'   =>  Carbon::today()->addDays(2),
        ]);
        $student->absences()->save($ab);
        $this->assertEquals($student->absences()->count(), 1);
    }

    /**
     * Test if an absence period is happening now.
     */
    public function test_absence_is_happening_now()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        $student = factory(Student::class)->create();

        $pastAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(4),
            'to'   =>  Carbon::today()->subDays(2),
        ]);

        $futureAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->addDays(2),
            'to'   =>  Carbon::today()->addDays(4),
        ]);

        $currentAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(2),
            'to'   =>  Carbon::today()->addDays(2),
        ]);

        $this->assertFalse($pastAbence->isCurrent());
        $this->assertFalse($futureAbence->isCurrent());
        $this->assertTrue($currentAbence->isCurrent());
    }

    /**
     * Test if an absence period has already happened and finished.
     */
    public function test_absence_has_happened_and_finished()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        $student = factory(Student::class)->create();

        $pastAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(4),
            'to'   =>  Carbon::today()->subDays(2),
        ]);

        $futureAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->addDays(2),
            'to'   =>  Carbon::today()->addDays(4),
        ]);

        $currentAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(2),
            'to'   =>  Carbon::today()->addDays(2),
        ]);

        $this->assertTrue($pastAbence->isPast());
        $this->assertFalse($futureAbence->isPast());
        $this->assertFalse($currentAbence->isPast());
    }

    /**
     * Test if an absence period has yet to start.
     */
    public function test_absence_has_not_started_yet()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        $student = factory(Student::class)->create();

        $pastAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(4),
            'to'   =>  Carbon::today()->subDays(2),
        ]);

        $futureAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->addDays(2),
            'to'   =>  Carbon::today()->addDays(4),
        ]);

        $currentAbence = factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(2),
            'to'   =>  Carbon::today()->addDays(2),
        ]);

        $this->assertFalse($pastAbence->isFuture());
        $this->assertTrue($futureAbence->isFuture());
        $this->assertFalse($currentAbence->isFuture());
    }

    /**
     * Test absence scope for past period.
     */
    public function test_scope_for_past_absences()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(4),
            'to'   =>  Carbon::today()->subDays(2),
        ]);

        $this->assertEquals(Absence::past()->count(), 1);
        $this->assertEquals(Absence::current()->count(), 0);
        $this->assertEquals(Absence::future()->count(), 0);
    }

    /**
     * Test absence scope for future period.
     */
    public function test_scope_for_future_absences()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::today()->addDays(2),
            'to'   =>  Carbon::today()->addDays(4),
        ]);

        $this->assertEquals(Absence::past()->count(), 0);
        $this->assertEquals(Absence::current()->count(), 0);
        $this->assertEquals(Absence::future()->count(), 1);
    }

    /**
     * Test absence scope for current period.
     */
    public function test_scope_for_current_absences()
    {
        $this->artisan('db:seed', ['--class' => 'AbsenceTypeSeeder']);
        factory(Student::class)->create();

        factory(Absence::class)->create([
            'from' =>  Carbon::today()->subDays(2),
            'to'   =>  Carbon::today()->addDays(2),
        ]);

        $this->assertEquals(Absence::past()->count(), 0);
        $this->assertEquals(Absence::current()->count(), 1);
        $this->assertEquals(Absence::future()->count(), 0);
    }

    public function test_total_interuption_period_includes_previous_interuptions()
    {
        $stu = factory(Student::class)->create();
        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $this->assertEquals($stu->totalInteruptionPeriod(), 0);
        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->subDays(3);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->totalInteruptionPeriod(), 4);

        $from = Carbon::today()->subDays(22);
        $to = Carbon::today()->subDays(20);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->totalInteruptionPeriod(), 6);
    }

    public function test_total_interuption_period_includes_future_interuptions()
    {
        $stu = factory(Student::class)->create();
        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $this->assertEquals($stu->totalInteruptionPeriod(), 0);
        $from = Carbon::today()->addDays(3);
        $to = Carbon::today()->addDays(7);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->totalInteruptionPeriod(), 4);

        $from = Carbon::today()->addDays(9);
        $to = Carbon::today()->addDays(12);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->totalInteruptionPeriod(), 7);
    }

    public function test_total_interuption_period_includes_current_interuptions()
    {
        $stu = factory(Student::class)->create();
        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $this->assertEquals($stu->totalInteruptionPeriod(), 0);
        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->addDays(3);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to), ])
        );

        $stu->refresh();
        $this->assertEquals($stu->totalInteruptionPeriod(), 10);
    }


    public function test_interuption_period_so_far_includes_previous_interuptions()
    {
        $stu = factory(Student::class)->create();
        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $this->assertEquals($stu->interuptionPeriodSoFar(), 0);
        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->subDays(3);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->interuptionPeriodSoFar(), 4);

        $from = Carbon::today()->subDays(22);
        $to = Carbon::today()->subDays(20);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->interuptionPeriodSoFar(), 6);
    }

    public function test_interuption_period_so_far_excludes_future_interuptions()
    {
        $stu = factory(Student::class)->create();
        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $this->assertEquals($stu->totalInteruptionPeriod(), 0);
        $this->assertEquals($stu->interuptionPeriodSoFar(), 0);
        $from = Carbon::today()->addDays(3);
        $to = Carbon::today()->addDays(7);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->interuptionPeriodSoFar(), 0);
        $this->assertEquals($stu->interuptionPeriodSoFar($stu->absences->first()->from), 4);

        $from = Carbon::today()->addDays(9);
        $to = Carbon::today()->addDays(12);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->interuptionPeriodSoFar(), 0);
        $this->assertEquals($stu->interuptionPeriodSoFar($stu->absences[1]->from), 7);
    }

    public function test_interuption_period_so_far_includes_current_interuptions()
    {
        $stu = factory(Student::class)->create();
        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $this->assertEquals($stu->interuptionPeriodSoFar(), 0);
        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->addDays(3);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $stu->refresh();
        $this->assertEquals($stu->interuptionPeriodSoFar(), 10);
        $this->assertEquals($stu->interuptionPeriodSoFar(Carbon::today(), false), 0);
    }


    public function test_recalculating_milestone_due_date()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());

        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $mt = factory(MilestoneType::class)->create();

        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->subDays(3);
        $due_date = Carbon::today()->addDays(3);

        $m = factory(Milestone::class)->make([
            'due_date' => $due_date,
            'non_interuptive_date' => $due_date,
        ]);

        $stu->record()->timeline()->save($m);
        $this->assertEquals($stu->record()->timeline()->count(), 1);

        $this->assertEquals($m->due_date, $due_date);
        $this->assertEquals($m->non_interuptive_date, $due_date);

        $stu->absences()->save(
            Absence::make([
                'from' => $from,
                'to' => $to,
                'absence_type_id' => $abs_type->id,
                'duration' => $from->diffInDays($to),
            ])
        );

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date->addDays($from->diffInDays($to)));
    }
}
