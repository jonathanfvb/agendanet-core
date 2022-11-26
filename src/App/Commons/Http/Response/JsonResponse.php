<?php

namespace Agendanet\App\Commons\Http\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;

class JsonResponse
{
    public static function send(Response $response): ResponseInterface
    {
        return $response->withHeader('Content-Type', 'application/json');
    }
}
