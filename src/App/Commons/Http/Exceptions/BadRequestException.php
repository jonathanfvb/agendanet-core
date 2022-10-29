<?php

namespace Agendanet\App\Commons\Http\Exceptions;

class BadRequestException extends BusinessException
{
    const CODE = 400;
    const MESSAGE = 'Bad Request';
    
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? self::MESSAGE, self::CODE);
    }
}
