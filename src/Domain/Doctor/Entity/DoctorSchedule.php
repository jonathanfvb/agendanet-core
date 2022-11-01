<?php

namespace Agendanet\Domain\Doctor\Entity;

use DateTime;

class DoctorSchedule
{
    public Doctor $doctor;
    
    public DateTime $dateTime;
    
    public bool $available;
    
    public function __construct(
        Doctor $doctor,
        DateTime $dateTime,
        bool $available
    ) {
        $this->doctor = $doctor;
        $this->dateTime = $dateTime;
        $this->available = $available;
    }
}
