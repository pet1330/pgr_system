<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserQueryScopeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Student Query Scope.
     *
     * @return void
     */
    public function testStudentUserQueryScope()
    {
        factory(Student::class, 10)->create();
        $this->assertEquals(Student::count(), 10);
    }

    /**
     * Test Staff Query Scope.
     *
     * @return void
     */
    public function testStaffUserQueryScope()
    {
        factory(Staff::class, 7)->create();
        $this->assertEquals(Staff::count(), 7);
    }

    /**
     * Test Admin Query Scope.
     *
     * @return void
     */
    public function testAdminUserQueryScope()
    {
        factory(Admin::class, 5)->create();
        $this->assertEquals(Admin::count(), 5);
    }

    /**
     * Test a admin user type is returned when base class is instanciated.
     * @return void
     */
    public function testUserClassResolvesAdminCorrectly()
    {
        factory(Admin::class, 1)->create();

        return $this->assertTrue(User::first() instanceof Admin);
    }

    /**
     * Test a staff user type is returned when base class is instanciated.
     * @return void
     */
    public function testUserClassResolvesStaffCorrectly()
    {
        factory(Staff::class, 1)->create();

        return $this->assertTrue(User::first() instanceof Staff);
    }

    /**
     * Test a student user type is returned when base class is instanciated.
     * @return void
     */
    public function testUserClassResolvesStudentCorrectly()
    {
        factory(Student::class, 1)->create();

        return $this->assertTrue(User::first() instanceof Student);
    }
}
