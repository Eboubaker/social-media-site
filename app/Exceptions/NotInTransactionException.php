<?php

namespace App\Exceptions;

use Exception;

class NotInTransactionException extends Exception
{
    public function __construct()
    {
        parent::__construct("not in transaction");
    }
}
