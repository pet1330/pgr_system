<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentDashboardTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_student_can_visit_their_dashboard_without_a_record()
    {
        $stu = factory(Student::class)->create();
        $stu->assignDefaultPermissions(true);
        $this->actingAs($stu)
            ->get(route('student.show', $stu->university_id))
            ->assertStatus(200)
            ->assertSeeText('does not currently have an active student record')
            ->assertSeeText('Dashboard')
            ->assertDontSeeText('Access Control')
            ->assertDontSeeText('Milestones')
            ->assertDontSeeText('Settings')
            ->assertDontSeeText('Users');
    }

    public function test_a_student_is_redirected_if_only_only_one_active_record()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());
        $stu->assignDefaultPermissions(true);

        $this->actingAs($stu)
            ->get(route('student.show', $stu->university_id))
            ->assertRedirect(route('student.record.show', [$stu->university_id, $stu->records()->first()->slug()]));
    }

    public function test_a_student_can_visit_their_dashboard_with_a_blank_record()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());
        $stu->assignDefaultPermissions(true);

        $this->actingAs($stu)
            ->get(route('student.record.show', [$stu->university_id, $stu->records()->first()->slug()]))
            ->assertStatus(200)
            ->assertSeeText('Dashboard')
            ->assertSeeText('You have no upcoming or or overdue milestones! Congrats!')
            ->assertSeeText('You have not been assigned a supervisor')
            ->assertSeeText('You have no absences')
            ->assertSeeText('User information')
            ->assertDontSeeText('Access Control')
            ->assertDontSeeText('Settings')
            ->assertDontSeeText('Users');
    }

    public function test_a_student_is_not_redirected_if_they_have_two_or_more_active_record()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());
        $stu->records()->save(factory(StudentRecord::class)->make());
        $stu->assignDefaultPermissions(true);

        $this->actingAs($stu)
            ->get(route('student.show', $stu->university_id))
            ->assertStatus(200)
            ->assertSeeText('Select Record')
            ->assertDontSeeText('Create New Student Record');
    }

    public function test_overdue_milestone_is_on_dashboard()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());

        $mt = factory(MilestoneType::class)->create();

        $m = factory(Milestone::class)->make([
            'due_date' => Carbon::today()->subDays(20),
            'non_interuptive_date' => Carbon::today()->subDays(20),
            'submitted_date' => null,
        ]);
        $stu->records()->first()->timeline()->save($m);
        $stu->assignDefaultPermissions(true);
        $stu->records()->first()->refresh();

        $this->actingAs($stu)
            ->get(route('student.record.show', [$stu->university_id, $stu->records()->first()->slug()]))
            ->assertStatus(200)
            ->assertSeeText('Overdue Milestones')
            ->assertDontSeeText('You have no upcoming or or overdue milestones! Congrats!');
    }

    public function test_upcoming_milestone_is_on_dashboard()
    {
        $this->seedDatabaseWithStudentRecordInformation();
        $stu = factory(Student::class)->create();
        $stu->records()->save(factory(StudentRecord::class)->make());

        $mt = factory(MilestoneType::class)->create();

        $m = factory(Milestone::class)->make([
            'due_date' => Carbon::today()->addDays(3),
            'non_interuptive_date' => Carbon::today()->addDays(3),
            'submitted_date' => null,
        ]);
        $stu->records()->first()->timeline()->save($m);
        $stu->assignDefaultPermissions(true);
        $stu->records()->first()->refresh();

        $this->actingAs($stu)
            ->get(route('student.record.show', [$stu->university_id, $stu->records()->first()->slug()]))
            ->assertStatus(200)
            ->assertSeeText('Upcoming Milestones')
            ->assertDontSeeText('You have no upcoming or or overdue milestones! Congrats!');
    }
}
