<?php


namespace App\Console\Commands;


class RouteListCommand extends Command
{
    protected $name = 'route:list';
    protected $help = 'Show Route List';
    protected $description = 'Show Route List';

    public function handler()
    {
        $routeCollector = app()->getRouteCollector();
        $routeParser = $routeCollector->getRouteParser();
        $routes = $routeParser;
        $routes = $routes;
    }
}
