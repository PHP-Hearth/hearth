<?php
/**
 * Path.php
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Autoload;

/**
 * Path
 *
 * @category Hearth
 * @package
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Path
{
    /**
     * @var string The directory path to include
     */
    private $path;
    
    /**
     * @var string An excluded base namespace to exclude from the path
     */
    private $baseExclude;

    /**
     * Constructor
     *
     * Constructs a new Path element
     *
     * @param string $path
     * @param string $baseExclude
     */
    public function __construct($path, $baseExclude = null)
    {
        $this->setPath($path)
             ->setBaseExclude($baseExclude);
    }
    
    /**
     * Get Path
     * 
     * Gets the directory path to include
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set Path
     *
     * Sets the directory path to include
     *
     * @param string $path
     * @return \Hearth\Autoload\Path
     * @throws \InvalidArgumentException
     */
    public function setPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($path) . '. Expected a string'
            );
        }
        $this->path = $path;

        return $this;
    }

    /**
     * Get Base Exclude
     *
     * Gets the base namespace to exclude from the path when autoloading
     * the class
     *
     * @return string
     */
    public function getBaseExclude()
    {
        return $this->baseExclude;
    }

    /**
     * Set Base Exclude
     *
     * Sets the base namespace to exclude from the path when autoloading
     * the class
     *
     * @param string $baseExclude
     * @return \Hearth\Autoload\Path
     * @throws \InvalidArgumentException
     */
    public function setBaseExclude($baseExclude)
    {
        if ($baseExclude === null) {
            return;
        }
        if (!is_string($baseExclude)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($baseExclude) . '. Expected a string'
            );
        }

        if ($baseExclude[0] !== '\\') {
            $baseExclude = '\\' . $baseExclude;
        }

        $this->baseExclude = $baseExclude;

        return $this;
    }

}
