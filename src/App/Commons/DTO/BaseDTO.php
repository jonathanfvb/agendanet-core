<?php

namespace Agendanet\App\Commons\DTO;

use Agendanet\App\Commons\Contracts\Arrayable;

class BaseDTO implements Arrayable
{
    public function toArray(): array
    {
        $data = [];
        foreach ($this as $key => $value) {
            $key = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $key)), '_');
            $data[$key] = $value;
        }
        return $data;
    }
}
