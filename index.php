<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__.'/vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/api', function (Request $request, Response $response, $args) {
    $data = ['message' => 'Hello', 'method' => 'GET', 'version' => 4];
    $response->getBody()->write(json_encode($data));
    
    $out = fopen('php://stdout', 'w');
    fputs($out, "GET Method\n");
    fclose($out);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api', function (Request $request, Response $response, $args) {
    $data = ['message' => 'Hello', 'method' => 'POST'];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
