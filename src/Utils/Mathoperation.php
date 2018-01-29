<?php

namespace src\Utils;

/**
 * Class who implements mathematic operations
 */
class MathOperation
{
    /**
     * Calculates the distante between 2 points
     *
     * @param array $pnt1 First point
     * @param array $pnt2 Second point
     *
     * @return float
     */
    public static function distance2d(array $pnt1, array $pnt2)
    {
        return sqrt(pow($pnt1[0] - $pnt2[0], 2) + pow($pnt1[1] - $pnt2[1], 2));
    }

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

?>
