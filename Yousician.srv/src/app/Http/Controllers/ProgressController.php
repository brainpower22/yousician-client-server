<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class ProgressController extends Controller
{
    public function getLevel(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "levels" => (object)[],
            "master_level" => 2
        ];
        return $response->withJson($objectJson);
    }
    public function postLevel(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "levels" => (object)[],
            "master_level" => $request->getParsedBody()['master_level']
        ];
        return $response->withJson($objectJson);
    }
}