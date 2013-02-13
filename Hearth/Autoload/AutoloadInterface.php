<?php
/**
 * AutoloadInterface.php
 *
 * @category Hearth
 * @package Core
 * @subpackage Autoload
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Autoload;

/**
 * Interface
 *
 * @category Hearth
 * @package Core
 * @subpackage Autoload
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
interface AutoloadInterface
{
    /**
     * load
     *
     * Load a class file
     *
     * @access public
     * @param string $class The class to search for
     * @return void
     */
    public function load($className);

    /**
     * Get Load Path Stack
     *
     * Gets the stack of paths to auto load from
     *
     * @return array
     */
    public function getLoadPathStack();

    /**
     * Add load path
     *
     * Adds a path to the stack for autoloading
     *
     * @param \Hearth\Autoload\Path $path The path to add to the autoloader
     * @return \Hearth\Autoload
     */
    public function addLoadPath(Path $path);
}
