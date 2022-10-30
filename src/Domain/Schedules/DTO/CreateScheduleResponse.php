<?php

namespace Agendanet\Domain\Schedules\DTO;

use Agendanet\App\Commons\DTO\BaseDTO;

class CreateScheduleResponse extends BaseDTO
{
    public string $userPhone;
    
    public string $userName;
    
    public string $doctorId;
    
    public string $scheduleDatetime;
    
    public string $createdAt;
    
    public function __construct(
        string $userPhone,
        string $userName,
        string $doctorId,
        string $scheduleDatetime,
        string $createdAt
    ) {
        $this->userPhone = $userPhone;
        $this->userName = $userName;
        $this->doctorId = $doctorId;
        $this->scheduleDatetime = $scheduleDatetime;
        $this->createdAt = $createdAt;
    }
}
