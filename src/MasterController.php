<?php

namespace Masterclass;

use Aura\Di\Container;
use Masterclass\Router\Router;

/**
 * MasterController for Masterclass
 * @package Masterclass
 */
class MasterController
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Router
     */
    protected $router;

    public function __construct(Container $container, array $config, Router $router)
    {
        $this->container = $container;
        $this->config = $config;
        $this->router = $router;
    }

    public function execute()
    {
        $match = $this->_determineControllers();
        $calling = $match->getRouteClass();
        list($class, $method) = explode(':', $calling);
        $controllerObject = $this->container->newInstance($class);
        return $controllerObject->$method();
    }

    private function _determineControllers()
    {
        $router = $this->router;
        $match = $router->findMatch();
        if (!$match) {
            throw new \Exception('No route match found');
        }
        return $match;
    }

}