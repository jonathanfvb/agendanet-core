<?php

namespace Agendanet\App\Commons\Http\Exceptions;

use Exception;

class BusinessException extends Exception
{   
    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
    }
    
    public function toArray()
    {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}
