<?php
/**
 * Class who implements mathematic operations
 */
class MathOperation
{
    /**
     * Function n! of a number
     *
     * @param float $num
     *
     * @return float
     */
    public static function factorial($num)
    {
        $res = 1;
        for ($i = $num; $i >= 1; $i--) {
            $res = $res * $i;
        }
        return $res;
    }
}

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

/**
 * City entity
 */
class City
{
    public $coord_x;
    public $coord_y;
    public $name;

    public function getCoordX() : float
    {
        return $this->coord_x;
    }
    public function getCoordY() : float
    {
        return $this->coord_y;
    }
    public function getName() : string
    {
        return $this->name;
    }

    public function setCoordX(float $coord_x)
    {
        $this->coord_x = $coord_x;
    }
    public function setCoordY(float $coord_y)
    {
        $this->coord_y = $coord_y;
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }
}

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
     * Calc distance between cities
     *
     * @param City $city1
     * @param City $city2
     *
     * @return float
     */
    private function getCitiesDistance(City $city1, City $city2) : float
    {
        return sqrt(
            pow($city1->getCoordX() - $city2->getCoordX(), 2) +
            pow($city1->getCoordY() - $city2->getCoordY(), 2)
        );
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

/**
 * Algorithm
 */
class TspAlgorithm
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
     * Init algorithm params
     *
     * @param Route $route
     * @param int $maxTime Time execution time
     *
     * @return void
     */
    public function __construct(Route $route, int $maxTime)
    {
        $this->_minRoute = $route;
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
        if (empty($items) && $this->_pendingPerms) {

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
        /* if ( !isset($this->_minRoute) ) {
            $this->_minRoute = $route;
        }*/

        if ($this->_minRoute->getRouteDistance() > $route->getRouteDistance()) {
            $this->_minRoute = $route;
        }
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

// Create and launch TspAlgorithm
$maxTime = 15 * 60;
$tspAlgorithm = new TspAlgorithm($initRoute, $maxTime);
$tspAlgorithm->start();

// Best route
$route = $tspAlgorithm->getMinRoute();
$route->printRoute();
