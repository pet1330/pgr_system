<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Process;
use App\Models\Step;
use App\Models\Student;

class ProcessTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test a process has many steps
     *
     * @return void
     */
    public function testProcessHasStep()
    {
        $student = factory(Student::class)->create();
        $Process = factory(Process::class)->create();
        $step = factory(Step::class)->create();

    }

    // /**
    //  * Test a process has many steps
    //  *
    //  * @return void
    //  */
    // public function testProcessHasProcess()
    // {
    //     $p1 = factory(Process::class)->create();
    //     $p2 = factory(Process::class)->create();
    //     $p1->processable()->save($p2);
    //     dd($p1->processable()->first());
    // }
}
