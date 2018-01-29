<?php

namespace src\Entities;

use src\Utils\MathOperation as MathOperation;
use src\Entities\City as City;

/**
 * Route entity
 */
class Route
{
    /**
     * Cities route array
     *
     * @var array $cities
     */
    private $_cities = [];

    /**
     * Calculate distance between cities
     *
     * @param City $city1
     * @param City $city2
     *
     * @return float
     */
    private function getCitiesDistance(City $city1, City $city2) : float
    {
        return Mathoperation::distance2d($city1->getPoint(), $city2->getPoint());
    }

    /**
     * Inject city to the cities array
     *
     * @param City $city City entity
     *
     * @return void
     */
    public function addCity(City $city)
    {
        $this->_cities[] = $city;
    }

    /**
     * Get cities array
     *
     * @return array
     */
    public function getCities() : array
    {
        return $this->_cities;
    }

    /**
     * Calculates all route distance
     *
     * @return float Route distance sumatory
     */
    public function getRouteDistance() : float
    {
        $distance = 0.0;
        for ($i = 1; $i < count($this->_cities); $i++) {
            $distance += $this->getCitiesDistance($this->_cities[$i], $this->_cities[$i-1]);
        }

        return $distance;
    }

    /**
     * Print route by console
     */
    public function printRoute()
    {
        foreach ($this->_cities as $city) {
            echo $city->getName() . "\n";
        }
    }
}

?>
