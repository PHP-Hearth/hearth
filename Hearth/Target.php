<?php
/**
 * Target.php
 *
 * Description of Target.php
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
 * Target
 *
 * Description of Target
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
abstract class Target
{

    public function main();

    /**
     * task
     *
     * Calls a task
     *
     * @access public
     * @param string $task
     * @return \Hearth\Target
     */
    public function task($task)
    {

        return $this;
    }
}
