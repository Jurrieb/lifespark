<?php
use Cake\Routing\Router;

Router::plugin('Running', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
