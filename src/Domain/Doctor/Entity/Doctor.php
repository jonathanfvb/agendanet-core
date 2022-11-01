<?php

namespace Agendanet\Domain\Doctor\Entity;

class Doctor
{
    public string $id;
    
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
