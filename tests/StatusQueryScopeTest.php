<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $this->assertEquals(App\Models\EnrolmentStatus::count(), 5);
    }

    /**
     * Test Funding Type Status Query Scope
     *
     * @return void
     */
    public function testFundingTypeStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'FundingTypeSeeder']);
        $this->assertEquals(App\Models\FundingType::count(), 3);
    }

    /**
     * Test ModeOfStudy Status Query Scope
     *
     * @return void
     */
    public function testModeOfStudyStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'ModeOfStudySeeder']);
        $this->assertEquals(App\Models\ModeOfStudy::count(), 3);
    }

    /**
     * Test Programme Status Query Scope
     *
     * @return void
     */
    public function testProgrammeStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'ProgrammeSeeder']);
        $this->assertEquals(App\Models\Programme::count(), 3);
    }

    /**
     * Test Student Status Query Scope
     *
     * @return void
     */
    public function testStudentStatusQueryScope()
    {
        $this->artisan('db:seed', [ '--class' => 'StudentStatusSeeder']);
        $this->assertEquals(App\Models\StudentStatus::count(), 3);

    }
}
