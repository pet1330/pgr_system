<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
         app()['cache']->forget('spatie.permission.cache');
         

        // Permissions
        Permission::create(['name' => 'assign_permissions_to_user']);
        Permission::create(['name' => 'remove_permissions_from_user']);

        Permission::create(['name' => 'assign_role_to_user']);
        Permission::create(['name' => 'remove_role_from_user']);

        Permission::create(['name' => 'assign_permissions_to_role']);
        Permission::create(['name' => 'remove_permissions_from_role']);


        // Roles
        Role::create(['name' => 'student_default']);
        // ----------------------------------------------
        // ====================================================

        $role = Role::create(['name' => 'manage_access_control']);
        // ----------------------------------------------
        $role->givePermissionTo('assign_permissions_to_user');
        $role->givePermissionTo('remove_permissions_from_user');
        $role->givePermissionTo('assign_role_to_user');
        $role->givePermissionTo('remove_role_from_user');
        $role->givePermissionTo('assign_permissions_to_role');
        $role->givePermissionTo('remove_permissions_from_role');

        // ====================================================
    }
}
