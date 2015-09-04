<?php
use Cake\Routing\Router;

Router::plugin('User', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
