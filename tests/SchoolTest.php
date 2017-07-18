<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SchoolTest extends TestCase
{
    
    use DatabaseTransactions;

        protected $testCollege = 'College of Testing';
        protected $testSchools = 'School of Testing';
    /**
     * Test creating a School
     *
     * @return void
     */
    public function testCreatingSchool()
    {
        $college = App\Models\College::create([ 'name' => $this->testCollege]);
        $school = App\Models\School::create(
        [ 
            'name' => $this->testSchools,
            'college_id' => $college->id,
        ]);

        $this->assertEquals(App\Models\School::whereName($this->testSchools)->count(), 1);
    }

    /**
     * Test School belongs to College
     *
     * @return void
     */
    public function testSchoolBelongsToCollege()
    {
        $college = App\Models\College::create([ 'name' => $this->testCollege]);
        $school = App\Models\School::create(
        [ 
            'name' => $this->testSchools,
            'college_id' => $college->id,
        ]);

        $this->assertEquals($college->name, $school->college->name);
    }
}
