<?php

use Agendanet\App\Commons\Contracts\UuidGeneratorInterface;
use Agendanet\App\Commons\Generator\RamseyUuidGenerator;
use Agendanet\App\Controllers\PostController;
use Agendanet\Domain\Doctor\Repository\DoctorRepositoryInterface;
use Agendanet\Domain\Doctor\Repository\DoctorRepositoryPDO;
use Agendanet\Domain\Doctor\Repository\DoctorScheduleRepositoryInterface;
use Agendanet\Domain\Doctor\Repository\DoctorScheduleRepositoryPDO;
use Agendanet\Domain\Schedule\Factory\ScheduleFactory;
use Agendanet\Domain\Schedule\Factory\ScheduleFactoryInterface;
use Agendanet\Domain\Schedule\Repository\ScheduleRepositoryInterface;
use Agendanet\Domain\Schedule\Repository\ScheduleRepositoryPDO;
use Agendanet\Domain\Schedule\UseCase\CreateScheduleUC;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$container->set(ResponseInterface::class, \DI\create(Response::class));
$container->set(DoctorRepositoryInterface::class, \DI\create(DoctorRepositoryPDO::class));
$container->set(DoctorScheduleRepositoryInterface::class, \DI\create(DoctorScheduleRepositoryPDO::class));
$container->set(ScheduleRepositoryInterface::class, \DI\create(ScheduleRepositoryPDO::class));
$container->set(ScheduleFactoryInterface::class, \DI\autowire(ScheduleFactory::class));
$container->set(UuidGeneratorInterface::class, \DI\create(RamseyUuidGenerator::class));
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
    $res = $controller->createSchedule($request);
    return $res;
});

$app->run();
