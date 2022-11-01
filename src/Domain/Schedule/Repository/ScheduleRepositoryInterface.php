<?php

namespace Agendanet\Domain\Schedule\Repository;

use Agendanet\Domain\Schedule\Entity\Schedule;

interface ScheduleRepositoryInterface
{
    public function create(Schedule $schedule): void;
}
