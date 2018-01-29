<?php

namespace src\Entities;

/**
 * City entity
 */
class City
{
    /**
     * City x gps coord
     *
     * @var float $coord_x
     */
    public $coord_x;

    /**
     * City y gps coord
     *
     * @var float $coord_y
     */
    public $coord_y;

    /**
     * City name
     *
     * @var float $coord_y
     */
    public $name;

    /**
     * Get coord_x attribute
     *
     * @return float coord_x
     */
    public function getCoordX() : float
    {
        return $this->coord_x;
    }

    /**
     * Get coord_y attribute
     *
     * @return float coord_y
     */
    public function getCoordY() : float
    {
        return $this->coord_y;
    }

    /**
     * Get name attribute
     *
     * @return string name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get GPS point as 2D coordinate
     *
     * @return array
     */
    public function getPoint() : array
    {
        return [$this->getCoordX(), $this->getCoordY()];
    }

    /**
     * Set coord_x attribute
     *
     * @param float $coord_x
     *
     * @return void
     */
    public function setCoordX(float $coord_x)
    {
        $this->coord_x = $coord_x;
    }

    /**
     * Set coord_y attribute
     *
     * @param float $coord_y
     *
     * @return void
     */
    public function setCoordY(float $coord_y)
    {
        $this->coord_y = $coord_y;
    }

    /**
     * Set name attribute
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}

?>
