<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\EnrolmentStatus;
use App\Models\FundingType;
use App\Models\ModeOfStudy;
use App\Models\Programme;
use App\Models\StudentStatus;


class StatusQueryScopeSeeder extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test Enrolment Status Query Scope
     *
     * @return void
     */
    public function testEnrolmentStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'EnrolmentStatusSeeder']);
        $this->assertEquals(EnrolmentStatus::count(), 5);
    }

    /**
     * Test Funding Type Status Query Scope
     *
     * @return void
     */
    public function testFundingTypeStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'FundingTypeSeeder']);
        $this->assertEquals(FundingType::count(), 3);
    }

    /**
     * Test ModeOfStudy Status Query Scope
     *
     * @return void
     */
    public function testModeOfStudyStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'ModeOfStudySeeder']);
        $this->assertEquals(ModeOfStudy::count(), 3);
    }

    /**
     * Test Programme Status Query Scope
     *
     * @return void
     */
    public function testProgrammeStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'ProgrammeSeeder']);
        $this->assertEquals(Programme::count(), 3);
    }

    /**
     * Test Student Status Query Scope
     *
     * @return void
     */
    public function testStudentStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'StudentStatusSeeder']);
        $this->assertEquals(StudentStatus::count(), 3);

    }
}
