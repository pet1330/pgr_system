<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as ScopeInterface;

class AdminUserScope extends BaseUserScope implements ScopeInterface 
{

    protected $scope_filter = 'admin';
    protected $scope_column = 'user_type';
}
