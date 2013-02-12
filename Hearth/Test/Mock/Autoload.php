<?php
/**
 * Autoload.php
 *
 * @category hearth
 * @package Test
 * @subpackage Mock
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Test\Mock;

/**
 * Autoload
 *
 * @category Hearth
 * @package Test
 * @subpackage Mock
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Autoload extends \Hearth\Autoload
{
    /**
     * @inheritDoc
     */
    public function load($className)
    {
        return;
    }

    /**
     * @inheritDoc
     */
    public function getLoadPathStack()
    {
        return array();
    }

    /**
     * @inheritDoc
     */
    public function addLoadPath(\Hearth\Autoload\Path $path)
    {
        return $this;
    }
}
