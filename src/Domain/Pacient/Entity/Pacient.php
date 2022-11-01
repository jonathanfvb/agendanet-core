<?php

namespace Agendanet\Domain\Pacient\Entity;

class Pacient
{
    public string $name;
    
    public string $phone;
    
    public function __construct(
        string $name,
        string $phone
    ) {
        $this->name = $name;
        $this->phone = $phone;
    }
}
