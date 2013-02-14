<?php
/**
 * Autoload.php
 *
 * Autoloader
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

use Hearth\Autoload\AutoloadInterface;
use Hearth\Autoload\Path;

/**
 * Autoload
 *
 * Autoloader for hearth's internal files
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Autoload implements AutoloadInterface
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
     * @param \Hearth\Autoload\Path $path The path to add to the autoloader
     * @return \Hearth\Autoload
     * @throws \InvalidArgumentException
     */
    public function addLoadPath(Path $path)
    {
        array_unshift($this->loadPathStack, $path);

        return $this;
    }

    /**
     * Register Default Autoloader
     *
     * Registers the default configuration and one path for the hearth
     * autoloader based on that single basepath.
     *
     * WARNING - This method is a bootstrap helper!
     * it has a dependency on \Hearth\Autoload\Path
     *
     * @param string $path The basepath to load from
     * @return \Hearth\Autoload The autoloader object
     */
    public static function registerDefaultAutoloader($path = null)
    {
        if ($path === null) {
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
        }
        
        $autoloader = new \Hearth\Autoload();

        $corePath = new \Hearth\Autoload\Path($path);
        $autoloader->addLoadPath($corePath);

        spl_autoload_register(array($autoloader, 'load'));

        return $autoloader;
    }

    /**
     * Load and Register Composer
     *
     * This function requires the composer autoload file which registers it
     * immediately into the spl_autoload_register
     *
     * WARNING - This method is a bootsrap helper!
     * It will include files into your application using require()
     *
     * @param string $path The Basepath to look for the vendors dir inside of
     * @return mixed The composer autoload object
     */
    public static function loadAndRegisterComposer($path = null)
    {
        if ($path === null) {
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
        }

        return require $path . DIRECTORY_SEPARATOR . 'vendor'
            . DIRECTORY_SEPARATOR . 'autoload.php';
    }
}
