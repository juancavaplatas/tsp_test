<?php

namespace src\Controllers;

use src\Entities\Route as Route;
use src\Factories\RouteFactory as RouteFactory;
use src\Repositories\RouteRepository as RouteRepository;
use src\Utils\MathOperation as MathOperation;

/**
 * Class who implements the TSP Algorithm logic
 */
class TspController
{
    /**
     * Finish execution time in timestamp
     *
     * @var float $finishTime
     */
    private $finishTime = 0;

    /**
     * Minimum distance route
     *
     * @var Route $minRoute
     */
    private $minRoute;

    /**
     * Counter of maximum number of compute permutations
     *
     * @var int $pendingPerms
     */
    private $pendingPerms = 0;

    /**
     * Route repository
     *
     * @var RouteRepository $routeRepository
     */
    public $routeRepository;

    /**
     * Init algorithm params
     *
     * @param array $config
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $maxTime = $config["maxExecutionTime"];
        $datetime = new \DateTime();
        $this->finishTime = $datetime->getTimestamp() + $maxTime;
        $this->routeRepository = new RouteRepository($config);
        $firstRoute = $this->routeRepository->findFirst();
        $firstRoute = $this->routeRepository->findFirst();
        $this->setMinRoute($firstRoute);
    }

    /**
     * Check finish algorithm conditions
     *
     * @return boolean
     */
    private function finishPermConditions()
    {
        $datetime = new \DateTime();
        $actualTime = $datetime->getTimestamp();

        if ($this->pendingPerms == 0 || $actualTime >= $this->finishTime) {
            return true;
        }

        return false;

    }

    /**
     * Generate new route permutation and check if is the minimum route
     *
     * @param array $items
     * @param array $items
     *
     * @return void
     */
    private function computePermutation($items, $perms = array())
    {
        // We found a new permutation
        if (empty($items)) {

            // Create route and try to update by minimum distance
            $route = RouteFactory::create($perms);
            $this->updateMinRoute($route);

            // Prepare next router permutation
            $return = array($perms);
            $this->pendingPerms--;

        } else {
            $return = array();
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);

                // Next iteration depending perms conditions
                if (!$this->finishPermConditions()) {
                    $return = array_merge($return, $this->computePermutation($newitems, $newperms));
                }
            }
        }
        return $return;
    }

    /**
     * Update min route if the new one has a minimum distance
     *
     * @param Route $route New candidate route
     *
     * @return void
     */
    private function updateMinRoute(Route $route)
    {
        if ($this->minRoute->getRouteDistance() > $route->getRouteDistance()) {
            $this->setMinRoute($route);
        }
    }

    /**
     * Get route with minimum distance
     *
     * @return Route Minimum distance route
     */
    public function getMinRoute() : Route
    {
        return $this->minRoute;
    }

    /**
     * Set minRoute value
     *
     * @param Route $route
     *
     * @return void
     */
    public function setMinRoute(Route $route)
    {
        $this->minRoute = $route;
    }

    /**
     * Start computing route permutations
     *
     * @return void
     */
    public function start()
    {
        // Init cities array
        $cities = $this->getMinRoute()->getCities();

        // Using brute force, we will need to compute the first n! / 2 options
        $this->pendingPerms = MathOperation::factorial(count($cities)) / 2;

        // Start computing route permutations
        $this->computePermutation($cities);
    }
}

?>
