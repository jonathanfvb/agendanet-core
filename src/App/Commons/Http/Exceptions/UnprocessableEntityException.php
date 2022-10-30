<?php

namespace Agendanet\App\Commons\Http\Exceptions;

class UnprocessableEntityException extends BusinessException
{
    const CODE = 422;
    const MESSAGE = 'Unprocessable Entity';
    
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? self::MESSAGE, self::CODE);
    }
}
