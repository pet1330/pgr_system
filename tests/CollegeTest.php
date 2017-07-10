<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollegeTest extends TestCase
{

        protected $testCollege = 'College of Testing';
        protected $testSchools = 
        [
            'School of Testing 1',
            'School of Testing 2',
            'School of Testing 3',
            'School of Testing 4',
            'School of Testing 5',
            'School of Testing 6',
            'School of Testing 7',
        ];
    /**
     * Test creating a College
     *
     * @return void
     */
    public function testCreatingCollege()
    {
        App\Models\College::create([ 'name' => $this->testCollege]);
        $this->assertEquals(App\Models\College::whereName($this->testCollege)->count(), 1);
    }

    /**
     * Test College has Schools
     *
     * @return void
     */
    public function testCollegeHasSchools()
    {
        App\Models\College::create([ 'name' => $this->testCollege]);
        $college = App\Models\College::whereName($this->testCollege)->first();

        foreach ($this->testSchools as $schoolName)
        {  
            $s = new App\Models\School;
            $s->name = $schoolName;
            $college->schools()->save( $s );
            $this->assertEquals( $college->schools()->whereName($schoolName)->count(), 1);
        }
        $this->assertEquals( $college->schools->count(), 7);
    }
}
