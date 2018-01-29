<?php

namespace src\Factories;

use src\Entities\City as City;

/**
 * Cities factory
 */
class CityFactory
{
    /**
     * Create a city from cities.txt formatted data
     *
     * @param string $cityString City data in string format
     *
     * @return City City entity
     */
    public static function createFromFile(string $cityString)
    {
        // Explode string
        $data = explode(" ", $cityString);

        // Extract data from array
        $coord_y = array_pop($data);
        $coord_x = array_pop($data);
        $name = implode(" ", $data);

        // Create and fill entity
        $city = new City();
        $city->setName($name);
        $city->setCoordX($coord_x);
        $city->setCoordY($coord_y);

        // Return entity
        return $city;
    }
}

?>
