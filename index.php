<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Agendanet\App\Controllers\PostController;
use DI\Container;
use Agendanet\Domain\UseCase\CreateSchedule;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$container->set('PostController', \DI\autowire(PostController::class));
$container->set('CreateSchedule', \DI\autowire(CreateSchedule::class));

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->post('/schedules', function (Request $request, Response $response, $args) {
    /** @var PostController $controller */
    $controller = $this->get('PostController');
    return $controller->handler($request, $response);
});
    
$app->run();
