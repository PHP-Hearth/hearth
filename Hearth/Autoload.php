<?php
/**
 * Autoload.php
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

/**
 * Autoload
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class Autoload
{
    /**
     * @var string The directory separtor to use
     */
    protected $_ds;

    /**
     * @var string The base application path to search from
     */
    protected $_basePath;

    /**
     * load
     *
     * Load a class file
     *
     * @access public
     * @param string $class The class to search for
     * @return void
     */
    public function load($class)
    {
        $file = str_replace('\\', $this->getDs(), $class).'.php';

        if (file_exists($this->getBasePath() . $this->getDs() . $file)) {
            require_once $this->getBasePath() . $this->getDs() . $file;
        }
    }

    /**
     * setDs
     *
     * Set the directory separator to use
     *
     * @access public
     * @param string $ds The directory separator to use
     * @return \Hearth\Autoload
     */
    public function setDs($ds)
    {
        $this->_ds = $ds;

        return $this;
    }

    /**
     * getDs
     *
     * Get the directory separator to use
     *
     * @access public
     * @return string
     */
    public function getDs()
    {
        return $this->_ds;
    }

    /**
     * setBasePath
     *
     * Set the base of the autoloader seach
     *
     * @param string $path The base of the autoloader search
     * @return \Hearth\Autoload
     */
    public function setBasePath($path)
    {
        $this->_basePath = $path;

        return $this;
    }

    /**
     * getBasePath
     *
     * Get the base path of the autoloader search
     *
     * @access public
     * @return string
     */
    public function getBasePath()
    {
        return $this->_basePath;
    }
}
