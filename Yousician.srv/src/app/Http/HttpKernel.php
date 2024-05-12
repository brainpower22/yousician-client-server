<?php

namespace App\Http;

use App\Http\Middleware\CookiesMiddleware;
use App\Http\Middleware\SessionMiddleware;
use Boot\Foundation\HttpKernel as Kernel;

class HttpKernel extends Kernel
{
    /**
     * Injectable Request Input Form Request Validators
     * @var array
     */
    public array $requests = [
	//
    ];

    /**
     * Global Middleware
     *
     * @var array
     */
    public array $middleware = [
//        SessionMiddleware::class
        CookiesMiddleware::class
    ];

    /**
     * Route Group Middleware
     */
    public array $middlewareGroups = [
        'api' => [],
        'web' => [
            Middleware\RouteContextMiddleware::class,
            'csrf'
        ]
    ];
}
