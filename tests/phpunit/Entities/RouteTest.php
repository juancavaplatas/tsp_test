<?php

use PHPUnit\Framework\TestCase;
use src\Entities\Route as Route;
use src\Factories\CityFactory as CityFactory;

class RouteTest extends TestCase
{
    private function getRouteSet()
    {
        $route = new Route();

        $route->addCity(CityFactory::createFromFile("Barcelona 0 0"));
        $route->addCity(CityFactory::createFromFile("Madrid 10 0"));
        $route->addCity(CityFactory::createFromFile("Bilbao -10 0"));

        return $route;
    }

    /**
     * Test getCities
     *
     * @return void
     */
    public function test_getCities()
    {
        // Create route entity
        $route = $this->getRouteSet();
        // success case
        $result = $route->getCities();
        $this->assertInternalType("array", $result);
        $this->assertEquals(3, count($result));
        // check route cities content
        $this->assertInstanceOf("src\Entities\City", $result[0]);
        $this->assertEquals("Barcelona", $result[0]->getName());
        $this->assertInstanceOf("src\Entities\City", $result[1]);
        $this->assertEquals("Madrid", $result[1]->getName());
        $this->assertInstanceOf("src\Entities\City", $result[2]);
        $this->assertEquals("Bilbao", $result[2]->getName());
    }

    /**
     * Test getRouteDistance
     *
     * @return void
     */
    public function test_getRouteDistance()
    {
        // Create 1 city route test
        $route = new Route();
        $route->addCity(CityFactory::createFromFile("Sevilla 10 10"));
        // success case
        $result = $route->getRouteDistance();
        $this->assertInternalType("float", $result);
        $this->assertEquals(0.0, $result);


        // Create route entity
        $route = $this->getRouteSet();
        // success case
        $result = $route->getRouteDistance();
        $this->assertInternalType("float", $result);
        /*
        route [0,0] ->  [10,0] ->   [-10,0]
                        10.0    +   20.0    = 30.0
        */
        $this->assertEquals(30.0, $result);
    }
}

?>
