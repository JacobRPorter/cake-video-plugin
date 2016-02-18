<?php
use Cake\Routing\Router;

Router::plugin('Video', function ($routes) {
	$routes->connect('/', ['controller' => 'Video', 'action' => 'index']);
    $routes->fallbacks('InflectedRoute');
});
