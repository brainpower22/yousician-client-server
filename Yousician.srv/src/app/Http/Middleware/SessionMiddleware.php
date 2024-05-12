<?php

namespace App\Http\Middleware;

use App\Controllers\UserController;
use App\Models\User;
use App\Support\Auth;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;

class SessionMiddleware
{

//    /**
//     * @var array|string[]
//     */
//    private array $whiteList;
//    private Response $response;
//
//    public function __construct(Response $response)
//    {
//        //Define the urls that you want to exclude from Authentication, aka public urls
//        $this->whiteList = array('\/validate_client_version', '\/events\/new');
//        $this->response = $response;
//    }
//
//    /**
//     * Check against the DB if the token is valid
//     *
//     * @param string $token
//     * @return bool
//     */
//    public function authenticate($session)
//    {
//        return UserController::validateToken($session);
//    }
//
//    /**
//     * This function will compare the provided url against the whitelist and
//     * return wether the $url is public or not
//     *
//     * @param string $url
//     * @return bool
//     */
//    public function isPublicUrl($url)
//    {
//        $patterns_flattened = implode('|', $this->whiteList);
//        $matches = null;
//        preg_match('/' . $patterns_flattened . '/', $url, $matches);
//        return (count($matches) > 0);
//    }


    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Handler $handler): \Psr\Http\Message\ResponseInterface
    {
        if (Auth::check()) {
            return $handler->handle($request);
        } else {
            abort(403);
        }
    }
}