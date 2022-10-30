<?php

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Agendanet\App\Controllers\PostController;
use DI\Container;
use Agendanet\Domain\Schedules\UseCase\CreateScheduleUC;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$container->set(ResponseInterface::class, \DI\create(Response::class));
$container->set('PostController', \DI\autowire(PostController::class));
$container->set('CreateScheduleUC', \DI\autowire(CreateScheduleUC::class));

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function(Request $request, ResponseInterface $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write('{"message": "ok"}');
    return $response;
});

$app->post('/schedules', function (Request $request, $args) {
    /** @var PostController $controller */
    $controller = $this->get('PostController');
    return $controller->handler($request);
});
    
$app->run();
