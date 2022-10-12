<?php

namespace Agendanet\App\Http\Exceptions;

class BadRequestException extends BaseException
{
    const CODE = 404;
    const MESSAGE = 'Not Found';
    
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? self::MESSAGE, self::CODE);
    }
}
