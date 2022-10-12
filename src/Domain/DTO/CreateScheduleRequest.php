<?php

namespace Agendanet\Domain\DTO;

class CreateScheduleRequest
{
    public $userPhone;
    
    public $userName;
    
    public $doctorId;
    
    public $scheduleDatetime;
    
    public function __construct(
        string $userPhone,
        string $userName,
        string $doctorId,
        string $scheduleDatetime
    ) {
        $this->userPhone = $userPhone;
        $this->userName = $userName;
        $this->doctorId = $doctorId;
        $this->scheduleDatetime = $scheduleDatetime;
    }
}
