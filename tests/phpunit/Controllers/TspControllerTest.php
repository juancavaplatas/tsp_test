<?php

use PHPUnit\Framework\TestCase;
use src\Controllers\TspController as TspController;
use src\Factories\CityFactory as CityFactory;
use src\Factories\RouteFactory as RouteFactory;

class TspControllerTest extends TestCase
{
    public $tspController;

    /**
     * Testing setUp
     *
     * @return void
     */
    protected function setUp()
    {
        include __DIR__ . "/../../../config/test.php";
        $this->tspController = new TspController($config);
    }

    /**
     * Test getMinRoute
     *
     * @return void
     */
    public function test_getMinRoute()
    {
        // success case
        $result = $this->tspController->getMinRoute();
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
     * Test start
     *
     * @return void
     */
    public function test_start()
    {
        // Launch start method
        $this->tspController->start();
        // check minimum route
        $result = $this->tspController->getMinRoute();
        $this->assertInstanceOf("src\Entities\Route", $result);
        $this->assertEquals(20.0, $result->getRouteDistance());
        // check route cities
        $cities = $result->getCities();
        $this->assertInternalType("array", $cities);
        $this->assertEquals(3, count($cities));
        // check cities content
        // order should be Madrid - Barcelona - Bilbao
        $this->assertInstanceOf("src\Entities\City", $cities[0]);
        $this->assertEquals("Madrid", $cities[0]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[1]);
        $this->assertEquals("Barcelona", $cities[1]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[2]);
        $this->assertEquals("Bilbao", $cities[2]->getName());

        // success case with execution time to 0
        $config = [
            "maxExecutionTime" => 0,
            "repositoryBasePath" => "tests/phpunit/"
        ];
        $this->tspController = new TspController($config);
        $this->tspController->start(); // Launch start method
        // check minimum route
        $result = $this->tspController->getMinRoute();
        $this->assertInstanceOf("src\Entities\Route", $result);
        $this->assertEquals(30.0, $result->getRouteDistance());
        // check route cities
        $cities = $result->getCities();
        $this->assertInternalType("array", $cities);
        $this->assertEquals(3, count($cities));
        // check cities content
        // order should be the original data Barcelona - Madrid - Bilbao
        $this->assertInstanceOf("src\Entities\City", $cities[0]);
        $this->assertEquals("Barcelona", $cities[0]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[1]);
        $this->assertEquals("Madrid", $cities[1]->getName());
        $this->assertInstanceOf("src\Entities\City", $cities[2]);
        $this->assertEquals("Bilbao", $cities[2]->getName());
    }
}

?>
