<?php

namespace Agendanet\Domain\Doctor\Entity;

class Doctor
{
    public string $doctorId;
    
    public function __construct(string $doctorId)
    {
        $this->doctorId = $doctorId;
    }
}
