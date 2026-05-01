<?php

namespace App\Services;

use Framework\Database;

class UserService
{
    public function __construct(private Database $db)
    {

    }
}