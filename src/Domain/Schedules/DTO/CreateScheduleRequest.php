<?php

namespace Agendanet\Domain\Schedules\DTO;

class CreateScheduleRequest
{
    public string $userPhone;
    
    public string $userName;
    
    public string $doctorId;
    
    public string $scheduleDatetime;
    
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
