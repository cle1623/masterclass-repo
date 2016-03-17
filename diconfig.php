<?php

$builder = new Aura\Di\ContainerBuilder();
$di = $builder->newInstance();

$db = $config['database'];

$dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $db['user'],
    'passwd' => $db['pass'],
    'options' => null
];

$di->params['Masterclass\MasterController'] = [
    'config' => $config,
    'container' => $di
];

$di->params['Masterclass\Model\Comment'] = [
    'pdo' => $di->lazyNew('PDO')
];

$di->params['Masterclass\Model\Story'] = [
    'pdo' => $di->lazyNew('PDO')
];

$di->params['Masterclass\Model\User'] = [
    'pdo' => $di->lazyNew('PDO')
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