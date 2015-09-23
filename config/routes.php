<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::defaultRouteClass('Route');

Plugin::routes();

Router::scope('/', function ($routes) {

    $routes->extensions(['json']);
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'overview']);
    $routes->connect('/profile/*', ['controller' => 'Users', 'action' => 'profile']);
    $routes->fallbacks('InflectedRoute');

});
