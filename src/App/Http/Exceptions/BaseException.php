<?php

namespace Agendanet\App\Http\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $message;
    
    protected $code;
    
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
