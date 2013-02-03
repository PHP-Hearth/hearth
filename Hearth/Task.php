<?php
/**
 * Task.php
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

/**
 * Task
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
abstract class Task
{
    /**
     * Execute the main task routine
     *
     * @return void
     */
    public function main();

    /**
     * run a task and execute it immediately
     *
     * @return type
     */
    public static function run()
    {
        $args      = func_get_args();
        $className = get_class();

        $taskReflection = new \ReflectionClass($className);
        $taskObj = $taskReflection->newInstance($args);

        return $taskObj->main();
    }
}
