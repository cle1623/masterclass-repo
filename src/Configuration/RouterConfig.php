<?php

namespace Masterclass\Configuration;

use Aura\Di\ContainerConfig;
use Aura\Di\Container;
use Masterclass\Router\Route\GetRoute;
use Masterclass\Router\Route\PostRoute;

class RouterConfig extends ContainerConfig
{
    public function define(Container $di)
    {
        $path = realpath(__DIR__.'/..');
        $config = require($path.'/../config/config.php');
        $routes = $config['routes'];
        $routeObj = [];

        foreach ($routes as $path => $route) {
            if ($route['type'] == 'POST') {
                $routeObj[] = new PostRoute($path, $route['class']);
            } else {
                $routeObj[] = new GetRoute($path, $route['class']);
            }
        }

        $di->params['Masterclass\Router\Router'] = [
            'serverVars' => $_SERVER,
            'routes' => $routeObj
        ];
    }
}