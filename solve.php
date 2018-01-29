<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/config.php';

use src\Controllers\TspController as TspController;

// Create and launch the TSP controller
$tspController = new TspController($config);
$tspController->start();

// Get and print best route
$route = $tspController->getMinRoute();
$route->printRoute();
