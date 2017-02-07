<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as ScopeInterface;

class StaffUserScope extends BaseUserScope implements ScopeInterface 
{

    protected $scope_filter = 'staff';
    protected $scope_column = 'user_type';
}
