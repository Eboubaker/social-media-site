<?php

namespace App\Exceptions;

use App\Http\StatusCodes;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpUnsupportedMediaTypeException extends HttpException
{
    public function __construct()
    {
        parent::__construct(StatusCodes::HTTP_UNSUPPORTED_MEDIA_TYPE, "Media type no supported");
    }
}
