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
     * @var float $coordX
     */
    private $coordX;

    /**
     * City y gps coord
     *
     * @var float $coordY
     */
    private $coordY;

    /**
     * City name
     *
     * @var string $name
     */
    private $name;

    /**
     * Get coordX attribute
     *
     * @return float coordX
     */
    public function getCoordX() : float
    {
        return $this->coordX;
    }

    /**
     * Get coord_y attribute
     *
     * @return float coord_y
     */
    public function getCoordY() : float
    {
        return $this->coordY;
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
     * Set coordX attribute
     *
     * @param float $coordX City X gps coordenate
     *
     * @return void
     */
    public function setCoordX(float $coordX)
    {
        $this->coordX = $coordX;
    }

    /**
     * Set coordY attribute
     *
     * @param float $coordY City Y gps coordenate
     *
     * @return void
     */
    public function setCoordY(float $coordY)
    {
        $this->coordY = $coordY;
    }

    /**
     * Set name attribute
     *
     * @param string $name City name
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}

?>
