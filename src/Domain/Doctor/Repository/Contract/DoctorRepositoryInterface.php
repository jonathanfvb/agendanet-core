<?php

namespace Agendanet\Domain\Doctor\Repository\Contract;

use Agendanet\Domain\Doctor\Entity\Doctor;

interface DoctorRepositoryInterface
{
    public function findByDoctorId(string $doctorId): ?Doctor;
}
