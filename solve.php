<?php

require __DIR__ . '/vendor/autoload.php';

use src\Entities\Route as Route;
use src\Factories\CityFactory as CityFactory;
use src\Factories\RouteFactory as RouteFactory;
use src\Controllers\TspController as TspController;

// Get data from the file cities.txt
$data = file_get_contents("cities.txt");

// Get arrays from trimed string
$arrays = explode("\n", trim($data));

// Init route
$cities = [];
foreach ($arrays as $cityString) {
    $cities[] = CityFactory::createFromFile($cityString);
}
$initRoute = RouteFactory::create($cities);

// Create and launch the TSP controller
$maxTime = 15 * 60; // 15 minutes to seconds
$maxTime = 2 * 60;
$tspController = new TspController($initRoute, $maxTime);

$route = $tspController->getMinRoute();
$tspController->start();

// Get best route
$route = $tspController->getMinRoute();
$route->printRoute();
