<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserQueryScopeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Staff Query Scope
     *
     * @return void
     */
    public function testQueryScope()
    {
      factory(App\Models\Student::class,10)->create();
      factory(App\Models\Staff::class,7)->create();
      factory(App\Models\Admin::class,5)->create();
      factory(App\Models\Wizard::class,2)->create();

      $this->assertEquals(App\Models\Student::count(), 10);
      $this->assertEquals(App\Models\Staff::count(), 7);
      $this->assertEquals(App\Models\Admin::count(), 5);
      $this->assertEquals(App\Models\Wizard::count(), 2);
    }
}