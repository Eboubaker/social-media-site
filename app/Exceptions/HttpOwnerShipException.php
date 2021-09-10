<?php

namespace App\Exceptions;

use App\Http\StatusCodes;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpOwnerShipException extends HttpException
{
    public function __construct()
    {
        parent::__construct(StatusCodes::HTTP_FORBIDDEN, "OwnerShip Error");
    }
}
