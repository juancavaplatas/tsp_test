<?php

use PHPUnit\Framework\TestCase;
use src\Utils\MathOperation as MathOperation;

class MathoperationTest extends TestCase
{
    /**
     * Test distance2d
     *
     * @return void
     */
    public function test_distance2d()
    {
        // success case
        $pnt1 = [0,0];
        $pnt2 = [0,1];
        $expected = 1;
        $result = MathOperation::distance2d($pnt1, $pnt2);
        $this->assertEquals($expected, $result);

        // success case - only takes 2 first dimensions
        $pnt1 = [0,0,0];
        $pnt2 = [0,0,1];
        $expected = 0;
        $result = MathOperation::distance2d($pnt1, $pnt2);
        $this->assertEquals($expected, $result);
    }

    public function test_factorial()
    {
        // success
        $num = 5;
        $expected = 120;
        $result = MathOperation::factorial($num);
        $this->assertEquals($expected, $result);

        // success, factorial for 0
        $num = 0;
        $expected = 1;
        $result = MathOperation::factorial($num);
        $this->assertEquals($expected, $result);
    }
}

?>
