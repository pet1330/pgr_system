<?php

namespace App\Scopes;

class UserScope extends GlobalQueryScope {

    function __construct($user_type)
    {
        parent::__construct($user_type, 'user_type');
    }
}
