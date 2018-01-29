<?php

namespace src\Repositories;

use src\Entities\Route as Route;
use src\Factories\RouteFactory as RouteFactory;
use src\Repositories\Repository as Repository;
use src\Repositories\CityRepository as CityRepository;

class RouteRepository extends Repository
{
    /**
     * City related repository
     *
     * @var CityRepository
     */
    public $cityRepository;

    /**
     * Init table relations
     *
     * @return void
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->cityRepository = new CityRepository($config);
    }

    /**
     * Find route
     */
    public function findFirst() : Route
    {
        // "JOIN" city repository
        $cities = $this->cityRepository->findAll();

        // Create route and return
        return RouteFactory::create($cities);
    }
}

?>
