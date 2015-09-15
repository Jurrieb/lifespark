<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);

    $routes->fallbacks('InflectedRoute');
});

Plugin::routes();
