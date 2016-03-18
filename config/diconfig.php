<?php

$builder = new Aura\Di\ContainerBuilder();
$di = $builder->newInstance();

$db = $config['database'];

$dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

$di->params['Masterclass\DatabaseLayer\Mysql'] = [
    'dsn' => $dsn,
    'user' => $db['user'],
    'pass' => $db['pass']
];

$di->params['Masterclass\MasterController'] = [
    'config' => $config,
    'container' => $di
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