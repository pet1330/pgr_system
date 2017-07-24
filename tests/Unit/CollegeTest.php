<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\College;
use App\Models\School;
class CollegeTest extends TestCase
{
    
    use DatabaseTransactions;

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
        College::create([ 'name' => $this->testCollege]);
        $this->assertEquals(College::whereName($this->testCollege)->count(), 1);
    }

    /**
     * Test College has Schools
     *
     * @return void
     */
    public function testCollegeHasSchools()
    {
        College::create([ 'name' => $this->testCollege]);
        $college = College::whereName($this->testCollege)->first();

        foreach ($this->testSchools as $schoolName)
        {  
            $s = new School;
            $s->name = $schoolName;
            $college->schools()->save( $s );
            $this->assertEquals( $college->schools()->whereName($schoolName)->count(), 1);
        }
        $this->assertEquals( $college->schools->count(), 7);
    }
}
