<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class NotificationController extends Controller
{
    public function notifications(ServerRequest $request, Response $response)
    {
        $objectJson = (object)[
            'notifications' => []
        ];
        return $response->withJson($objectJson);
    }
}