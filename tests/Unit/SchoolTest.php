<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\School;
use App\Models\College;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SchoolTest extends TestCase
{
    use DatabaseTransactions;

    protected $testCollege = 'College of Testing';
    protected $testSchools = 'School of Testing';

    /**
     * Test creating a School.
     *
     * @return void
     */
    public function testCreatingSchool()
    {
        $college = College::create(['name' => $this->testCollege]);
        $school = School::create(
        [
            'name' => $this->testSchools,
            'college_id' => $college->id,
        ]);

        $this->assertEquals(School::whereName($this->testSchools)->count(), 1);
    }

    /**
     * Test School belongs to College.
     *
     * @return void
     */
    public function testSchoolBelongsToCollege()
    {
        $college = College::create(['name' => $this->testCollege]);
        $school = School::create(
        [
            'name' => $this->testSchools,
            'college_id' => $college->id,
        ]);

        $this->assertEquals($college->name, $school->college->name);
    }
}
