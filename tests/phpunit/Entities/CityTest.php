<?php

use PHPUnit\Framework\TestCase;
use src\Entities\City as City;

class CityTest extends TestCase
{
    private function getCitySet()
    {
        $city = new City();
        $city->setName("Barcelona");
        $city->setCoordX(0);
        $city->setCoordY(0);
        return $city;
    }

    /**
     * Test getPoint
     *
     * @return void
     */
    public function test_getPoint()
    {
        // Create City entity
        $city = $this->getCitySet();
        // success case
        $result = $city->getPoint();
        $this->assertInternalType("array", $result);
        $this->assertEquals(2, count($result));
        $expected = [0,0];
        $this->assertEquals($expected, $result);
    }
}

?>
