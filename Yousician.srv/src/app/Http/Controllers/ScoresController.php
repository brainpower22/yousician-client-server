<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class ScoresController extends Controller
{
    public function highMe(ServerRequest $request, Response $response)
    {
        $objectJson = [];
        return $response->withJson($objectJson);
    }
}