<?php

namespace src\Controllers;

use src\Entities\Route as Route;
use src\Factories\RouteFactory as RouteFactory;
use src\Utils\MathOperation as MathOperation;

/**
 * Class who implements the TSP Algorithm logic
 */
class TspController
{
    /**
     * Counter of maximum number of compute permutation
     *
     * @var int $_pendingPerms
     */
    private $_pendingPerms = 0;

    /**
     * Cities array
     */
    private $_cities = [];

    /**
     * Minimum distance route
     *
     * @var Route $_minRoute
     */
    private $_minRoute;

    /**
     * Finish execution time in timestamp
     *
     * @var float $_finishTime
     */
    private $_finishTime = 0;

    /**
     * Init algorithm params
     *
     * @param Route $route
     * @param int $maxTime Time execution time in miliseconds
     *
     * @return void
     */
    public function __construct(Route $route, float $maxTime)
    {
        $this->_minRoute = $route;
        $datetime = new \DateTime();
        $this->_finishTime = $datetime->getTimestamp();
        $this->_finishTime = $datetime->getTimestamp() + $maxTime;
    }

    /**
     * Check finish algorithm conditions
     *
     * @return boolean
     */
    private function _finishPermConditions()
    {
        $datetime = new \DateTime();
        $actualTime = $datetime->getTimestamp();


        if (!$this->_pendingPerms || $actualTime > $this->_finishTime) {
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
    private function _computePermutation($items, $perms = array())
    {
        // We found a new permutation
        if (empty($items) && !$this->_finishPermConditions()) {

            // Create route and try to update by minimum distance
            $route = RouteFactory::create($perms);
            $this->_updateMinRoute($route);

            // Prepare next router permutation
            $return = array($perms);
            $this->_pendingPerms--;

        }  else {
            $return = array();
            for ($i = count($items) - 1; $i >= 0; --$i) {
                 $newitems = $items;
                 $newperms = $perms;
                 list($foo) = array_splice($newitems, $i, 1);
                 array_unshift($newperms, $foo);
                 $return = array_merge($return, $this->_computePermutation($newitems, $newperms));
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
    private function _updateMinRoute(Route $route)
    {
        if ($this->_minRoute->getRouteDistance() > $route->getRouteDistance()) {
            $this->_minRoute = $route;
        }
    }

    /**
     * Get route with minimum distance
     *
     * @return Route Minimum distance route
     */
    public function getMinRoute() : Route
    {
        return $this->_minRoute;
    }

    /**
     * Start computing route permutations
     *
     * @return void
     */
    public function start()
    {
        // Init cities array
        $cities = $this->_minRoute->getCities();

        // Using brute force, we will need to compute the first n! / 2 options
        $this->_pendingPerms = MathOperation::factorial(count($cities)) / 2;

        // Start computing route permutations
        $this->_computePermutation($cities);
    }
}

?>
