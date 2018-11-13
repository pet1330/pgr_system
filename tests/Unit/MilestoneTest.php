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

class MilestoneTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test assigning a student record a timeline.
     */

    public function test_blank_milestone_can_be_assigned_to_student()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());
        $mt = factory(MilestoneType::class)->create();
        $m = factory(Milestone::class)->make([
            'due_date' => Carbon::now(),
            'non_interuptive_date' => Carbon::now(),
        ]);
        $stu->record()->timeline()->save($m);
        $this->assertEquals($stu->record()->timeline()->count(), 1);
    }

    private function recalculate_test_setup($due_date, $from, $to)
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());

        $abs_type = AbsenceType::create(['name' => 'test', 'interuption' => true]);
        $mt = factory(MilestoneType::class)->create();

        $m = factory(Milestone::class)->make([
            'due_date' => $due_date,
            'non_interuptive_date' => $due_date,
        ]);

        $stu->record()->timeline()->save($m);
        $this->assertEquals($stu->record()->timeline()->count(), 1);

        $this->assertEquals($m->due_date, $due_date);
        $this->assertEquals($m->non_interuptive_date, $due_date);

        $m->recalculateDueDate();
        $m->refresh();

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
        return $m;
    }

    public function test_past_milestone_is_moved_by_past_absence_before_it()
    {
        $due_date = Carbon::today()->subDays(3);
        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->subDays(4);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date->addDays($from->diffInDays($to)));
    }

    public function test_past_milestone_is_not_moved_by_past_absence_after_it()
    {
        $due_date = Carbon::today()->subDays(7);
        $from = Carbon::today()->subDays(5);
        $to = Carbon::today()->subDays(3);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date);

    }

    public function test_past_milestone_is_not_moved_by_current_absence() // think about when abense is over both current time and milestone due date
    {
        $due_date = Carbon::today()->subDays(7);
        $from = Carbon::today()->subDays(3);
        $to = Carbon::today()->addDays(3);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date);
    }

    public function test_past_milestone_is_not_moved_by_future_absence()
    {
        $due_date = Carbon::today()->subDays(3);
        $from = Carbon::today()->addDays(4);
        $to = Carbon::today()->addDays(7);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date);
    }

// Can we have current Due Date (current milestones)

    public function test_future_milestone_is_moved_by_past_absence()
    {
        $due_date = Carbon::today()->addDays(3);
        $from = Carbon::today()->subDays(7);
        $to = Carbon::today()->subDays(4);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date->addDays($from->diffInDays($to)));
    }

    public function test_future_milestone_is_moved_by_current_absence()
    {
        $due_date = Carbon::today()->addDays(5);
        $from = Carbon::today()->subDays(2);
        $to = Carbon::today()->addDays(2);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date->addDays($from->diffInDays($to)));
    }

    public function test_future_milestone_is_moved_by_future_absence_before_it()
    {
        $due_date = Carbon::today()->addDays(7);
        $from = Carbon::today()->addDays(2);
        $to = Carbon::today()->addDays(4);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date->addDays($from->diffInDays($to)));
    }

    public function test_future_milestone_is_not_moved_by_future_absence_after_it()
    {
        $due_date = Carbon::today()->addDays(3);
        $from = Carbon::today()->addDays(5);
        $to = Carbon::today()->addDays(7);

        $m = $this->recalculate_test_setup($due_date, $from, $to);

        $m->recalculateDueDate();
        $m->refresh();
        $this->assertEquals($m->non_interuptive_date, $due_date);
        $this->assertEquals($m->due_date, $due_date);
    }




    // /**
    //  * Test assigning a student record a timeline.
    //  *
    //  */
    // public function testMilestonePendingApproval()
    // {
    //     $mt = factory( MilestoneType::class )->create();

    //     // Milestone that does not require approval
    //     $m = Milestone::make([
    //         'name'                 => 'milestone 1',
    //         'milestone_type_id'    => $mt->id,
    //         'submission_date'      => null,
    //         'approval_required'    => 0,
    //         'approval_granted'     => null,
    //         ]);

    //     // Milestone does not require approval
    //     $this->assertFalse($m->pending_approval());

    //     // Milestone not yet submitted
    //     $m->approval_required = 1;
    //     $this->assertFalse($m->pending_approval());

    //     // Milestone not yet aproved
    //     $m->submission_date = Carbon::now();
    //     $this->assertTrue($m->pending_approval());

    //     // Milestone that has already been approved
    //     $m->approval_granted = 1;
    //     $this->assertFalse($m->pending_approval());

    //     // Milestone that has been rejected
    //     $m->approval_granted = false;
    //     $this->assertTrue($m->pending_approval());
    // }
}
