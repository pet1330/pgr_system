<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserQueryScopeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Student Query Scope
     *
     * @return void
     */
    public function testStudentUserQueryScope()
    {
        factory(App\Models\Student::class,10)->create();
        $this->assertEquals(App\Models\Student::count(), 10);
    }

    /**
     * Test Staff Query Scope
     *
     * @return void
     */
    public function testStaffUserQueryScope()
    {
        factory(App\Models\Staff::class,7)->create();
        $this->assertEquals(App\Models\Staff::count(), 7);
    }

    /**
     * Test Admin Query Scope
     *
     * @return void
     */
    public function testAdminUserQueryScope()
    {
        factory(App\Models\Admin::class,5)->create();
        $this->assertEquals(App\Models\Admin::count(), 5);
    }

    /**
     * Test Wizard Query Scope
     *
     * @return void
     */
    public function testWizardUserQueryScope()
    {
        factory(App\Models\Wizard::class,2)->create();
        $this->assertEquals(App\Models\Wizard::count(), 2);
    }
}
