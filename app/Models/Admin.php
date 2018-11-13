<?php

namespace App\Models;

use App\Scopes\UserScope;

class Admin extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope('Admin'));
    }

    public function assignDefaultPermissions($reset = false)
    {
        $this->assignBasicAdminPermissions($reset);
    }

    public function downgrade_to_staff($reset = true)
    {
        $this->update(['user_type' => 'Staff']);
        $staff = Staff::find($this->id);
        $staff->assignDefaultPermissions(true);
    }
}
