<?php

namespace Agendanet\Domain\Schedule\Entity;

use Agendanet\Domain\Pacient\Entity\Pacient;
use Agendanet\Domain\Doctor\Entity\Doctor;
use DateTime;
use Agendanet\Domain\Schedule\Enum\ScheduleStatus;

class Schedule
{
    public string $id;
    
    public Pacient $pacient;
    
    public Doctor $doctor;
    
    public DateTime $dateTime;
    
    public ScheduleStatus $status;
    
    public DateTime $createdAt;
    
    public ?DateTime $updatedAt = null;
    
    public function __construct(
        string $id,
        Pacient $pacient,
        Doctor $doctor,
        DateTime $dateTime,
        ScheduleStatus $status,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->pacient = $pacient;
        $this->doctor = $doctor;
        $this->dateTime = $dateTime;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }
}
