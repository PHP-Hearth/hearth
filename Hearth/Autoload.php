<?php
/**
 * Autoload.php
 *
 * Autoloader
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

use Hearth\Autoload\Path;

/**
 * Autoload
 *
 * Autoloader for hearth's internal files
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Autoload
{
    /**
     * @var array
     */
    private $loadPathStack = array();

    /**
     * load
     *
     * Load a class file
     *
     * @access public
     * @param string $class The class to search for
     * @return void
     */
    public function load($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        $lastNsPos = strrpos($className, '\\');
        if ($lastNsPos) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';


        foreach ($this->getLoadPathStack() as $loadPath) {
            $checkFile = $loadPath->getPath() . DIRECTORY_SEPARATOR . $fileName;
            $checkFile = str_replace(
                str_replace('\\', '/', $loadPath->getBaseExclude()),
                '',
                $checkFile
            );

            if(file_exists($checkFile)) {
                require $checkFile;
            }
        }
    }

    /**
     * Get Load Path Stack
     *
     * Gets the stack of paths to auto load from
     *
     * @return array
     */
    public function getLoadPathStack()
    {
        return $this->loadPathStack;
    }

    /**
     * Add load path
     *
     * Adds a path to the stack for autoloading
     *
     * @param string $path The path to add to the autoloader
     * @return \Hearth\Autoload
     * @throws \InvalidArgumentException
     */
    public function addLoadPath(Path $path)
    {
        array_unshift($this->loadPathStack, $path);

        return $this;
    }
}
