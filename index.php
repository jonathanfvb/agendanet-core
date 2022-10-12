<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Agendanet\App\Controllers\ApiController;

require __DIR__.'/vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/api', function (Request $request, Response $response, $args) {
    $controller = new ApiController();
    return $controller->getAction($request, $response);
});

$app->post('/api', function (Request $request, Response $response, $args) {
    $data = ['message' => 'Hello', 'method' => 'POST'];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
