<?php

namespace App\Scopes;

class UserScope extends GlobalQueryScope
{
    public function __construct($user_type)
    {
        parent::__construct($user_type, 'user_type');
    }
}
