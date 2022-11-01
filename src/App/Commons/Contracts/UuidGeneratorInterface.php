<?php

namespace Agendanet\App\Commons\Contracts;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
