<?php
use Cake\Routing\Router;

Router::plugin('Smoking', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
