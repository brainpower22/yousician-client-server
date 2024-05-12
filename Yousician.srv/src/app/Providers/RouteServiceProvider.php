<?php

namespace App\Providers;

use App\Support\RouteGroup;
use Boot\Foundation\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->apiRouteGroup()->register();
        $this->thirdPartyRouteGroup()->register();
        $this->webRouteGroup()->register();
    }

    public function apiRouteGroup() : RouteGroup
    {
        $get = routes_path('api.php');
        $add = $this->resolve('middleware');
        $api = $this->resolve(RouteGroup::class);

        return $api->routes($get)->prefix('')->middleware([
            ...$add['api'],
            ...$add['global']
        ]);
    }

    public function thirdPartyRouteGroup() : RouteGroup
    {
        $get = routes_path('thirdParty.php');
        $add = $this->resolve('middleware');
        $api = $this->resolve(RouteGroup::class);

        return $api->routes($get)->prefix('')->middleware([
            ...$add['api'],
            ...$add['global']
        ]);
    }

    public function webRouteGroup() : RouteGroup
    {
        $get = routes_path('web.php');
        $add = $this->resolve('middleware');
        $web = $this->resolve(RouteGroup::class);

        return $web->routes($get)->prefix('/web')->middleware([
            ...$add['web'],
            ...$add['global']
        ]);
    }
}
