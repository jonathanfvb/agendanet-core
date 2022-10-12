<?php

namespace Agendanet\App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiController
{
    public function getAction(Request $request, Response $response)
    {
        $data = [
            'message' => 'Hello',
            'method' => 'GET',
            'version' => 5,
            'database' => [
                'name' => $_ENV['DB_NAME'] ?? null
            ]
        ];
        $response->getBody()->write(json_encode($data));
        
        $out = fopen('php://stdout', 'w');
        fputs($out, "GET Method\n");
        fclose($out);
        
        return $response->withHeader('Content-Type', 'application/json');
    }
}
