<?php
/**
 * Parent repository class
 */

namespace src\Repositories;

class Repository
{
    /**
     * File datasource base path
     */
    protected $basePath = "";

    /**
     * File datasource path
     */
    protected $path = "";

    /**
     * Init table relations
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->setBasePath($config["repositoryBasePath"]);
    }

    /**
     * Get base path attribute
     *
     * @return string basePath attribute
     */
    public function getBasePath() : string
    {
        return $this->basePath;
    }

    /**
     * Get complete path
     *
     * @return string String formed by basePath and path
     */
    public function getCompletePath() : string
    {
        return $this->getBasePath() . $this->getPath();
    }

    /**
     * Get path attribute
     *
     * @return string path attribute
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * Set base path attribute
     */
    public function setBasePath(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Set path attribute
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }
}


?>
