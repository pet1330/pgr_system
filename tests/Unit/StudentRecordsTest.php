<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentRecordsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Student can save a Record.
     *
     * @return void
     */
    public function testSavingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory(Student::class, 10)
          ->create()
          ->each(function ($stu) {
              $stu->records()->save(factory(StudentRecord::class)->make());
          });
        $this->assertEquals(StudentRecord::count(), 10);
    }

    /**
     * Test Student has A Record.
     *
     * @return void
     */
    public function testGettingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory(Student::class, 10)
          ->create()
          ->each(function ($stu) {
              $stu->records()->save(factory(StudentRecord::class)->make());
          });

        $students = Student::all();

        foreach ($students as $stu) {
            $this->assertTrue($stu->records()->count() === 1);
        }
    }

    public function testCreatingStudentRecordAndInfo()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory(Student::class, 10)
            ->create()
            ->each(function ($stu) {
                $stu->records()
                  ->save(factory(StudentRecord::class)->make());
            });

        $students = Student::all();

        foreach ($students as $stu) {
            $this->assertTrue($stu->records()->count() === 1);
        }
    }

    public function testSoftDeleteingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory(Student::class, 3)->create()->each(function ($stu) {
                $stu->records()->save(factory(StudentRecord::class)->make());
            });

        $sr = StudentRecord::first();
        $sr->delete(); # soft_delete
        $this->assertSoftDeleted('student_records', ['id' => $sr->id]);
    }

    public function testHardDeleteingStudentRecord()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        factory(Student::class, 3)->create()->each(function ($stu) {
                $stu->records()->save(factory(StudentRecord::class)->make());
            });

        $sr = StudentRecord::first();
        $this->assertEquals(StudentRecord::count(), 3);
        $sr->forceDelete(); # soft_delete
        $this->assertEquals(StudentRecord::count(), 2);
        $this->assertEquals(StudentRecord::withTrashed()->count(), 2);
    }

    public function testSoftDeleteingStudentRecordCascades()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        $stu = factory(Student::class)->create();
        $r = $stu->records()->save(factory(StudentRecord::class)->make());
        $mt = factory(MilestoneType::class)->create();
        $m = $r->timeline()->save(factory(Milestone::class)->make());
        $this->assertEquals($r->timeline()->count(), 1);
        $r->delete();
        $this->assertSoftDeleted('student_records', ['id' => $r->id]);
        $this->assertSoftDeleted('milestones', ['id' => $m->id]);
    }

    public function testRestoringStudentRecordCascades()
    {
        $this->seedDatabaseWithStudentRecordInformation();

        $stu = factory(Student::class)->create();
        factory(MilestoneType::class)->create();

        $r = $stu->records()->save(factory(StudentRecord::class)->make());
        $r->addSupervisor(factory(Staff::class)->create(), 1);
        $r->updateNote('rawr');
        $r->timeline()->saveMany(factory(Milestone::class, 10)->make());

        $this->assertEquals($r->refresh()->timeline()->count(), 10);
        $this->assertEquals($r->refresh()->supervisors()->count(), 1);
        $this->assertTrue($r->refresh()->note()->exists());

        $r->delete();
        $this->assertEquals($r->refresh()->timeline()->count(), 0);
        $this->assertEquals($r->refresh()->supervisors()->count(), 0);
        $this->assertFalse($r->refresh()->note()->exists());

        $r->restore();
        $this->assertEquals($r->refresh()->timeline()->count(), 10);
        $this->assertEquals($r->refresh()->supervisors()->count(), 1);
        $this->assertTrue($r->refresh()->note()->exists());
    }
}
