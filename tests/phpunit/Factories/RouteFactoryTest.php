<?php

use PHPUnit\Framework\TestCase;
use src\Factories\RouteFactory as RouteFactory;
use src\Factories\CityFactory as CityFactory;

class RouteFactoryTest extends TestCase
{
    /**
     * Returns a valid set of data to call factory
     *
     * @return array
     */
    private function getCreateSet()
    {
        return [
            CityFactory::createFromFile("Barcelona 0 0"),
            CityFactory::createFromFile("Madrid 10 5"),
            CityFactory::createFromFile("Bilbao -5 -10")
        ];
    }

    /**
     * Test create
     *
     * @return void
     */
    public function test_create()
    {
        // success case
        $cities = $this->getCreateSet();
        $result = RouteFactory::create($cities);
        $this->assertEquals("src\Entities\Route", get_class($result));
        $this->assertEquals($cities, $result->getCities());

    }
}

?>
