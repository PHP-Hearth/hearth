<?php
/**
 * Touch.php
 *
 * @category Hearth
 * @package Library
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Library;

use Hearth\Task;

/**
 * Touch
 *
 * Updates file timestamps
 *
 * @category Hearth
 * @package Library
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Touch extends Task
{
    /**
     * @var string The file path to touch
     */
    private $filePath;

    /**
     * Constructor
     *
     * Constructs a new Touch object
     *
     * @param string $filePath The file path to touch
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * main
     */
    public function main()
    {
        echo '[touch] Updating file: ' . $this->getFilePath() . PHP_EOL;
        
        touch($this->getFilePath());
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set file path
     *
     * @param string $filePath
     * @return \Hearth\Library\Touch
     */
    public function setFilePath($filePath)
    {
        if (!is_string($filePath)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($filePath) . '. Expected a string'
            );
        }
        
        $this->filePath = $filePath;

        return $this;
    }
}
