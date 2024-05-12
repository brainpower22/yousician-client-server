<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class EventController extends Controller
{
    public function new(ServerRequest $request, Response $response)
    {
        $objectJson = (object)[];
        return $response->withJson($objectJson);
    }
}