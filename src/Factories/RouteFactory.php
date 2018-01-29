<?php

namespace src\Factories;

use src\Entities\Route as Route;

/**
 * Routes factory
 */
class RouteFactory
{
    /**
     * Creates a new route from an array of cities
     *
     * @param array $cities
     *
     * @return Route Route entity
     */
    public static function create(array $cities)
    {
        // Create and fill entity
        $route = new Route();

        foreach ($cities as $city) {
            $route->addCity($city);
        }

        // Return entity
        return $route;
    }
}

?>
