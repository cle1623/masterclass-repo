<?php

namespace Masterclass\Router\Route;

abstract class AbstractRoute implements RouteInterface
{
    protected $routePath;

    protected $routeClass;

    public function __construct($routePath, $routeClass)
    {
        $this->routePath = $routePath;
        $this->routeClass = $routeClass;
    }

    public function getRoutePath()
    {
        return $this->routePath;
    }

    public function getRouteClass()
    {
        return $this->routeClass;
    }

    abstract public function matchRoute($requestPath, $requestType);
}