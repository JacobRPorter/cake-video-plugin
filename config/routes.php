<?php
use Cake\Routing\Router;

Router::plugin('Help', function ($routes) {
	$routes->connect('/', ['controller' => 'Help', 'action' => 'index']);
    $routes->fallbacks('InflectedRoute');
});
