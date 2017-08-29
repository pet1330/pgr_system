<?php

use Illuminate\Database\Seeder;
// use App\Models\Permission;
// use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Bouncer::allow('manage_access_control')->to('ban-users');
         
        Bouncer::allow('manage_access_control')->to([
            'assign_permissions_to_user',
            'remove_permissions_from_user',
            'assign_role_to_user',
            'remove_role_from_user',
            'assign_permissions_to_role',
            'remove_permissions_from_role']);
    }
}
