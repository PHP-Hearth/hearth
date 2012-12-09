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
    protected $_ds;

    protected $_basePath;

    public function load($class)
    {
        $file = str_replace('\\', $this->getDs(), $class).'.php';

        if (file_exists($file)) {
            require_once $this->getBasePath() . $this->getDs() . $file;
        }
    }

    public function setDs($ds)
    {
        $this->_ds = $ds;

        return $this;
    }

    public function getDs()
    {
        return $this->_ds;
    }

    public function setBasePath($path)
    {
        $this->_basePath = $path;

        return $this;
    }

    public function getBasePath()
    {
        return $this->_basePath;
    }
}
