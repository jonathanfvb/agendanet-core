<?php

namespace Agendanet\Domain\Doctor\Repository;

use Agendanet\Domain\Doctor\Entity\DoctorSchedule;
use DateTime;

interface DoctorScheduleRepositoryInterface
{
    public function findSchedule(
        string $doctorId, 
        DateTime $dateTime
    ): ?DoctorSchedule;
    
    public function update(DoctorSchedule $doctorSchedule): void;
}
