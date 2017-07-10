<?php

namespace App\Scopes;

class StatusScope extends GlobalQueryScope {

    function __construct($status_type)
    {
        parent::__construct($status_type, 'status_type');
    }
}
