<?php

namespace Masterclass\Configuration;

use Aura\Di\ContainerConfig;
use Aura\Di\Container;

class DiConfig extends ContainerConfig
{
    public function define(Container $di)
    {
        $path = realpath(__DIR__.'/..');
        $config = require($path.'/../config/config.php');
        $db = $config['database'];
        $dsn = 'mysql:host='.$db['host'].';dbname='.$db['name'];
        $di->params['Masterclass\DatabaseLayer\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $db['user'],
            'pass' => $db['pass']
        ];

        $di->params['Masterclass\MasterController'] = [
            'config' => $config,
            'container' => $di,
            'router' => $di->lazyNew('Masterclass\Router\Router')
        ];

        $di->params['Masterclass\Model\Comment'] = [
            'db' => $di->lazyNew('Masterclass\DatabaseLayer\Mysql')
        ];

        $di->params['Masterclass\Model\Story'] = [
            'db' => $di->lazyNew('Masterclass\DatabaseLayer\Mysql')
        ];

        $di->params['Masterclass\Model\User'] = [
            'db' => $di->lazyNew('Masterclass\DatabaseLayer\Mysql')
        ];

        $di->params['Masterclass\Controller\Comment'] = [
            'comment' => $di->lazyNew('Masterclass\Model\Comment')
        ];

        $di->params['Masterclass\Controller\Index'] = [
            'story' => $di->lazyNew('Masterclass\Model\Story')
        ];

        $di->params['Masterclass\Controller\Story'] = [
            'story' => $di->lazyNew('Masterclass\Model\Story'),
            'comment' => $di->lazyNew('Masterclass\Model\Comment')
        ];

        $di->params['Masterclass\Controller\User'] = [
            'user' => $di->lazyNew('Masterclass\Model\User')
        ];
    }
}