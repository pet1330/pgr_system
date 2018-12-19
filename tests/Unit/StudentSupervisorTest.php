<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentSupervisorTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Student can add a supervisor.
     *
     * @return void
     */
    public function testAddSupervisor()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        $student = factory(Student::class)->create();
        $supers = factory(Staff::class, 3)->create();
        $studentRecord = factory(StudentRecord::class)->make();
        $student->records()->save($studentRecord);

        $supers->each(function ($s) use ($studentRecord) {
            $count = $studentRecord->supervisors()->count() + 1;
            $studentRecord->addSupervisor($s, $count);

            $this->assertDatabaseHas('supervisors', [
                'staff_id' => $s->id,
                'student_record_id' => $studentRecord->id,
                'changed_on' => null,
                'supervisor_type' => $count,
            ]);
        });

        $this->assertEquals($studentRecord->supervisors()->count(), 3);
    }

    /**
     * Test Student can remove a supervisor.
     *
     * @return void
     */
    public function testRemoveSupervisor()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        $student = factory(Student::class)->create();
        $supers = factory(Staff::class, 3)->create();
        $studentRecord = factory(StudentRecord::class)->make();
        $student->records()->save($studentRecord);

        $supers->each(function ($s) use ($studentRecord) {
            $count = $studentRecord->supervisors()->count() + 1;
            $studentRecord->addSupervisor($s, $count);

            $this->assertDatabaseHas('supervisors', [
                'staff_id' => $s->id,
                'student_record_id' => $studentRecord->id,
                'changed_on' => null,
                'supervisor_type' => $count,
            ]);
        });

        $this->assertEquals($studentRecord->supervisors()->count(), 3);

        $studentRecord->removeSupervisor($supers->first());

        $this->assertEquals($studentRecord->supervisors()->count(), 2);
    }

    /**
     * Test Student has a Director of Study (main supervisor).
     *
     * @return void
     */
    public function testDirectorOfStudy()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        $student = factory(Student::class)->create();
        $staff = factory(Staff::class)->create();
        $studentRecord = factory(StudentRecord::class)->make();
        $student->records()->save($studentRecord);
        $studentRecord->addSupervisor($staff, 1);
        $this->assertEquals($studentRecord->DirectorOfStudy->id, $staff->id);
        $this->assertNull($studentRecord->secondSupervisor);
        $this->assertNull($studentRecord->thirdSupervisor);
    }

    /**
     * Test Student has a second supervisor.
     *
     * @return void
     */
    public function testSecondSupervisor()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        $student = factory(Student::class)->create();
        $staff = factory(Staff::class)->create();
        $studentRecord = factory(StudentRecord::class)->make();
        $student->records()->save($studentRecord);
        $studentRecord->addSupervisor($staff, 2);
        $this->assertNull($studentRecord->DirectorOfStudy);
        $this->assertEquals($studentRecord->secondSupervisor->id, $staff->id);
        $this->assertNull($studentRecord->thirdSupervisor);
    }

    /**
     * Test Student has a third supervisor.
     *
     * @return void
     */
    public function testThirdSupervisor()
    {
        $this->artisan('db:seed', ['--class' => 'EnrolmentStatusSeeder']);
        $this->artisan('db:seed', ['--class' => 'StudentStatusSeeder']);
        $this->artisan('db:seed', ['--class' => 'ProgrammeSeeder']);
        $this->artisan('db:seed', ['--class' => 'CollegeSeeder']);
        $this->artisan('db:seed', ['--class' => 'SchoolSeeder']);
        $this->artisan('db:seed', ['--class' => 'FundingTypeSeeder']);

        $student = factory(Student::class)->create();
        $staff = factory(Staff::class)->create();
        $studentRecord = factory(StudentRecord::class)->make();
        $student->records()->save($studentRecord);
        $studentRecord->addSupervisor($staff, 3);
        $this->assertNull($studentRecord->DirectorOfStudy);
        $this->assertNull($studentRecord->secondSupervisor);
        $this->assertEquals($studentRecord->thirdSupervisor->id, $staff->id);
    }
}
