<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class Controller
{
    public function empty(ServerRequest $request, Response $response)
    {
        $objectJson = (object)[];
        return $response->withJson($objectJson);
    }

}
