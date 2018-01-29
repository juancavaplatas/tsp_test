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
    private $cities = [];

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
        $this->cities[] = $city;
    }

    /**
     * Get cities array
     *
     * @return array
     */
    public function getCities() : array
    {
        return $this->cities;
    }

    /**
     * Calculates all route distance
     *
     * @return float Route distance sumatory
     */
    public function getRouteDistance() : float
    {
        $distance = 0.0;
        for ($i = 1; $i < count($this->cities); $i++) {
            $distance += $this->getCitiesDistance($this->cities[$i], $this->cities[$i-1]);
        }

        return $distance;
    }

    /**
     * Print route by console
     *
     * @return void
     */
    public function printRoute()
    {
        foreach ($this->cities as $city) {
            echo $city->getName() . "\n";
        }
    }
}

?>
