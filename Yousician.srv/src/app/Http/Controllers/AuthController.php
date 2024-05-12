<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Auth;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class AuthController extends Controller
{
    public function login(ServerRequest $request, Response $response)
    {
        $authorizationData = substr($request->getHeader('authorization')[0], 6);
        $authorizationData = base64_decode($authorizationData);
        list($email, $password) = explode(':', $authorizationData);
        Auth::attempt($email, $password);

        return $response->withJson((object)[]);
    }

    public function logged(ServerRequest $request, Response $response)
    {
        return $response->withJson(['authenticated' => Auth::check()]);
    }
    public function logout(ServerRequest $request, Response $response)
    {
        Auth::logout();
        return $response->withJson((object)[]);
    }
}