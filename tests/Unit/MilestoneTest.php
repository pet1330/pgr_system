<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MilestoneTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test assigning a student record a timeline.
     */
    public function testBlankMilestoneCanBeAssignedToStudent()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());
        $mt = factory(MilestoneType::class)->create();

        $m = factory(Milestone::class)->make();
        $stu->record()->timeline()->save($m);
        $this->assertEquals($stu->record()->timeline()->count(), 1);
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
