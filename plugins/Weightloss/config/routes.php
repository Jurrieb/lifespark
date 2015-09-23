<?php
use Cake\Routing\Router;

Router::plugin('Weightloss', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
