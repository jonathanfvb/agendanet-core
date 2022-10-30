<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Agendanet\App\Controllers\PostController;
use GuzzleHttp\Psr7\Request as PsrRequest;
use Illuminate\Http\Request;

$router->get('/', function (Request $request) {
    return 'ok';
});

$router->post('/schedules', function (Request $request) {
    $psrRequest = new PsrRequest('POST','/schedules');
    $psrRequest->getBody()->write(json_encode($request->toArray()));
    
    $postController = app(PostController::class);
    $response = $postController->handler($psrRequest);
    return $response;
});
