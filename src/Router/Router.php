<?php

namespace Masterclass\Router;

use Masterclass\Router\Route\RouteInterface;

class Router
{
    /**
     * @var array
     */
    protected $serverVars;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * Router constructor
     * @param array $serverVars
     * @param array $routes
     */
    public function __construct(array $serverVars, array $routes = [])
    {
        $this->serverVars = $serverVars;
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    /**
     * @param RouteInterface $route
     */
    public function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @return bool|RouteInterface
     */
    public function findMatch()
    {
        $path = parse_url($this->serverVars['REQUEST_URI'], PHP_URL_PATH);

        /**
         * @var RouteInterface $route
         */
        foreach ($this->routes as $route) {
            if ($route->matchRoute($path, $this->serverVars['REQUEST_METHOD'])) {
                return $route;
            }
        }
        return false;
    }

}