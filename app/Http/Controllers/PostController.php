<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Agendanet\App\Controllers\PostController As PostBehavior;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $postBehavior = app(PostBehavior::class);
        $postBehavior->handler(new \GuzzleHttp\Psr7\Request('POST', '/schedules'), new Response());
        die('teste');
        #return $postBehavior->handler($request, new Response());
    }
}