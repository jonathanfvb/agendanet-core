<?php

namespace Agendanet\App\Commons\Generator;

use Agendanet\App\Commons\Contracts\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGeneratorInterface
{

    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
