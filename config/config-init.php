<?php

return array(

    'database' => array(
        'user' => 'root',
        'pass' => 'secret',
        'host' => 'localhost',
        'name' => 'masterclass',
    ),

    'routes' => array(
        '/' => [
            'class' => 'Masterclass\Controller\Index:index',
            'type' => 'GET'
        ],
        '/comment/create' => [
            'class' => 'Masterclass\Controller\Comment:create',
            'type' => 'POST'
        ],
        '/story' => [
            'class' => 'Masterclass\Controller\Story:index',
            'type' => 'GET'
        ],
        '/story/create' => [
            'class' => 'Masterclass\Controller\Story:create',
            'type' => 'GET'
        ],
        '/story/create/save' => [
            'class' => 'Masterclass\Controller\Story:create',
            'type' => 'POST'
        ],
        '/user/account/create' => [
            'class' => 'Masterclass\Controller\User:create',
            'type' => 'POST'
        ],
        '/user/account' => [
            'class' => 'Masterclass\Controller\User:account',
            'type' => 'GET'
        ],
        '/user/account/save' => [
            'class' => 'Masterclass\Controller\User:account',
            'type' => 'POST'
        ],
        '/user/create' => [
            'class' => 'Masterclass\Controller\User:create',
            'type' => 'GET'
        ],
        '/user/login/check' => [
            'class' => 'Masterclass\Controller\User:login',
            'type' => 'POST'
        ],
        '/user/login' => [
            'class' => 'Masterclass\Controller\User:login',
            'type' => 'GET'
        ],
        '/user/logout' => [
            'class' => 'Masterclass\Controller\User:logout',
            'type' => 'GET'
        ],
    ),
);