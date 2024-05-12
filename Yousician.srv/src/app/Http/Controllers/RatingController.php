<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class RatingController extends Controller
{
    public function ratings(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'ratings' => (object)[]
        ];
        return $response->withJson($objectJson);
    }
}