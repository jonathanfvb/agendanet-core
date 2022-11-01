<?php

namespace Agendanet\Domain\Schedule\Factory;

use Agendanet\App\Commons\Contracts\UuidGeneratorInterface;
use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Pacient\Entity\Pacient;
use Agendanet\Domain\Schedule\Entity\Schedule;
use Agendanet\Domain\Schedule\Enum\ScheduleStatus;
use DateTime;

class ScheduleFactory implements ScheduleFactoryInterface
{
    private UuidGeneratorInterface $uuidGenerator;
    
    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }
    
    public function make(
        Pacient $pacient,
        Doctor $doctor,
        DateTime $dateTime
    ): Schedule {
        return new Schedule(
            $this->uuidGenerator->generate(), 
            $pacient, 
            $doctor, 
            $dateTime, 
            new ScheduleStatus(ScheduleStatus::PENDING), 
            new DateTime()
        );
    }
}
