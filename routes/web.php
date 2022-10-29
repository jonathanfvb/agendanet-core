<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Request As PsrRequest;
use Agendanet\App\Controllers\PostController;

$router->get('/', function (Request $request) {
    return 'ok';
});

$router->post('/schedules', function (Request $request) {
    $psrRequest = new PsrRequest('POST', '/schedules');
    $psrRequest->getBody()->write(json_encode($request->toArray()));
    
    $postController = app(PostController::class);
    $response = $postController->handler($psrRequest);
    return $response;
});
