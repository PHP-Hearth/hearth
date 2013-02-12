<?php
/**
 * DeleteTask.php
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Library;

use Hearth\Task;

/**
 * DeleteTask
 *
 * @category Hearth
 * @package Library
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Delete extends Task
{
    /**
     * @var string The file path to be deleted
     */
    private $filePath;
    
    /**
     * Construct a new Delete task
     * 
     * @param string $filePath The file path to be deleted
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
        unlink($this->getFilePath());
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
     * @param string $filePath The file to delete
     * @return \Hearth\Library
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

}
