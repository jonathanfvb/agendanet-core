<?php

namespace Agendanet\Domain\Schedule\Enum;

class ScheduleStatus
{
    CONST PENDING = 'PE';
    CONST CONFIRMED = 'CO';
    CONST CANCELED = 'CA';
    
    public string $value;
    
    public function __construct(string $status)
    {
        $this->value = $status;
    }
}
