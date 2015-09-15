<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {

    $routes->extensions(['json']);
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'overview']);

    $routes->fallbacks('InflectedRoute');
});

Plugin::routes();
