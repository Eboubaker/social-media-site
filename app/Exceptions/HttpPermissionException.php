<?php

namespace App\Exceptions;

use App\Http\StatusCodes;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpPermissionException extends HttpException
{
    public function __construct()
    {
        parent::__construct(StatusCodes::HTTP_FORBIDDEN, "You don't have the permission to do this action!");
    }
}
