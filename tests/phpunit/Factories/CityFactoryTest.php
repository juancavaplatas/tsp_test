<?php

use PHPUnit\Framework\TestCase;
use src\Factories\CityFactory as CityFactory;

class CityFactoryTest extends TestCase
{
    /**
     * Test createFromFile
     *
     * @return void
     */
    public function test_createFromFile()
    {
        // success case
        $cityString = "Barcelona 0 0";
        $result = CityFactory::createFromFile($cityString);
        $this->assertInstanceOf("src\Entities\City", $result);
        $this->assertEquals("Barcelona", $result->getName());
        $this->assertEquals(0, $result->getCoordX());
        $this->assertEquals(0, $result->getCoordY());
    }
}

?>
