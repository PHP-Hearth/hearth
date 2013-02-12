<?php
/**
 * Request.php
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
 * Request
 *
 * A Dummy Request
 *
 * @category hearth
 * @package Test
 * @subpackage Mock
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class Request extends \Hearth\Request
{
    /**
     * @inheritdoc
     */
    public function __construct($target, $config)
    {
        return;
    }

    /**
     * @inheritdoc
     */
    public static function constructFromArgs(array $args)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return null;
    }

    public function setConfig($config)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setTarget($target)
    {
        return null;
    }

}
