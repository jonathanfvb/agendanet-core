<?php

namespace Agendanet\Domain\Schedule\Factory;

use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Pacient\Entity\Pacient;
use Agendanet\Domain\Schedule\Entity\Schedule;
use DateTime;

interface ScheduleFactoryInterface
{
    public function make(
        Pacient $pacient,
        Doctor $doctor,
        DateTime $dateTime
    ): Schedule;
}
