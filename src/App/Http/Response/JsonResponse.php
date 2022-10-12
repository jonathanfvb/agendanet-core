<?php

namespace Agendanet\App\Http\Response;

use Psr\Http\Message\ResponseInterface as Response;

class JsonResponse
{
    public static function send(Response $response)
    {
        return $response->withHeader('Content-Type', 'application/json');
    }
}
