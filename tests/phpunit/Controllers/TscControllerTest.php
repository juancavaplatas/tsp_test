<?php

use PHPUnit\Framework\TestCase;
use src\Controllers\TspController as TspController;
use src\Factories\CityFactory as CityFactory;
use src\Factories\RouteFactory as RouteFactory;

class TspControllerTest extends TestCase
{
    private function createTspController($maxTime = 15)
    {
        // Route cities
        $cities = [
            CityFactory::createFromFile("Barcelona 0 0"),
            CityFactory::createFromFile("Madrid 10 0"),
            CityFactory::createFromFile("Bilbao -10 0")
        ];

        // First route
        $initRoute = RouteFactory::create($cities);

        // Create and launch the TSP controller
        return new TspController($initRoute, $maxTime);

    }

    /**
     * Test getMinRoute
     *
     * @return void
     */
    public function test_getMinRoute()
    {
        // success case
        $tspController = $this->createTspController();
        $result = $tspController->getMinRoute();
        // check route result
        $this->assertInstanceOf("src\Entities\Route", $result);
        $this->assertEquals(30.0, $result->getRouteDistance());
        // check route cities
        $cities = $result->getCities();
        $this->assertInternalType("array", $cities);
        $this->assertEquals(3, count($cities));
        // check cities content and order
        $this->assertInstanceOf("src\Entities\City", $cities[0]);
        $this->assertEquals("Barcelona", $cities[0]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[1]);
        $this->assertEquals("Madrid", $cities[1]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[2]);
        $this->assertEquals("Bilbao", $cities[2]->getName());
    }

    /**
     * Test getMinRoute
     *
     * @return void
     */
    public function test_start()
    {
        // success case
        $tspController = $this->createTspController();
        // Launch start method
        $tspController->start();
        // check minimum route
        $result = $tspController->getMinRoute();
        $this->assertInstanceOf("src\Entities\Route", $result);
        $this->assertEquals(20.0, $result->getRouteDistance());
        // check route cities
        $cities = $result->getCities();
        $this->assertInternalType("array", $cities);
        $this->assertEquals(3, count($cities));
        // check cities content and order
        $this->assertInstanceOf("src\Entities\City", $cities[0]);
        $this->assertEquals("Madrid", $cities[0]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[1]);
        $this->assertEquals("Barcelona", $cities[1]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[2]);
        $this->assertEquals("Bilbao", $cities[2]->getName());

        // success case - reduce execution time to 0
        $maxTime = 0;
        $tspController = $this->createTspController($maxTime);
        // Launch start method
        $tspController->start();
        // check minimum route
        $result = $tspController->getMinRoute();
        $this->assertInstanceOf("src\Entities\Route", $result);
        $this->assertEquals(30.0, $result->getRouteDistance());
        // check route cities
        $cities = $result->getCities();
        $this->assertInternalType("array", $cities);
        $this->assertEquals(3, count($cities));
        // check cities content and order
        $this->assertInstanceOf("src\Entities\City", $cities[0]);
        $this->assertEquals("Barcelona", $cities[0]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[1]);
        $this->assertEquals("Madrid", $cities[1]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[2]);
        $this->assertEquals("Bilbao", $cities[2]->getName());


    }
}

?>
