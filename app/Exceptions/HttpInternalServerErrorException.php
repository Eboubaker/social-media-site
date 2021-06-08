<?php

namespace App\Exceptions;

use App\Http\StatusCodes;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpInternalServerErrorException extends HttpException
{
    public function __construct()
    {
        parent::__construct(StatusCodes::HTTP_INTERNAL_SERVER_ERROR, "Internal server error, the request may have not been fulfilled");
    }
}
