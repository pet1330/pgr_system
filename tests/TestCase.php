<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function seedDatabaseWithStudentRecordInformation()
    {
        $this->artisan('db:seed', ['--class' => 'EnrolmentStatusSeeder']);
        $this->artisan('db:seed', ['--class' => 'StudentStatusSeeder']);
        $this->artisan('db:seed', ['--class' => 'ProgrammeSeeder']);
        $this->artisan('db:seed', ['--class' => 'CollegeSeeder']);
        $this->artisan('db:seed', ['--class' => 'SchoolSeeder']);
        $this->artisan('db:seed', ['--class' => 'FundingTypeSeeder']);
    }
}
