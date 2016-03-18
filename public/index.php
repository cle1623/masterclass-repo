<?php

session_start();

$path = realpath(__DIR__.'/..');
require_once $path.'/vendor/autoload.php';
$builder = new Aura\Di\ContainerBuilder();
$di = $builder->newConfiguredInstance(['Masterclass\Configuration\DiConfig', 'Masterclass\Configuration\Routerconfig']);
$framework = $di->newInstance('Masterclass\MasterController');
echo $framework->execute();