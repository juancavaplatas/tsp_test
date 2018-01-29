<?php

namespace src\Repositories;

use src\Repositories\Repository as Repository;
use src\Factories\CityFactory as CityFactory;

class CityRepository extends Repository
{
    /**
     * File datasource path
     */
    protected $path = "cities.txt";

    /**
     * Get all cities
     *
     * @return array Cities array
     */
    public function findAll() : array
    {
        // Get route cities from the file cities.txt
        $file = $this->getCompletePath();
        $data = file_get_contents($file);

        // Get arrays from trimed string
        $arrays = explode("\n", trim($data));

        // Init route
        $cities = [];
        foreach ($arrays as $cityString) {
            $cities[] = CityFactory::createFromFile($cityString);
        }

        return $cities;
    }
}

?>
