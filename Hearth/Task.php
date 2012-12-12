<?php
/**
 * Task.php
 *
 * Task interface
 *
 * @category Hearth
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

/**
 * Task
 *
 * Description of Target
 *
 * @category Hearth
 * @package Abstracts
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
interface Task
{
    /**
     * Main
     *
     * This is method that is called by a Target
     *
     * @access public
     * @return void
     */
    public function main();
}
