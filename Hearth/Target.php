<?php
/**
 * Target.php
 *
 * Description of Target.php
 * 
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
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
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
abstract class Target
{
    /**
     * @var array The registry of task calls
     */
    private $_taskRegistry = array();

    /**
     * main
     *
     * @access public
     * @return void
     */
    public function main();

    /**
     * task
     *
     * Adds a task to the registry to be built on a target
     *
     * @access public
     * @param string $task
     * @return \Hearth\Target
     */
    public function task($task)
    {
        $this->addTaskToRegistry($task);

        return $this;
    }

    /**
     * getTaskRegistry
     *
     * Gets the task registry for the target
     *
     * @access public
     * @return array
     */
    public function getTaskRegistry()
    {
        return $this->_taskRegistry;
    }

    /**
     * addTaskToRegistry
     *
     * Adds a given task to the task registry
     *
     * @access public
     * @param string $task
     * @return \Hearth\Target
     * @throws \InvalidArgumentException
     */
    public function addTaskToRegistry($task)
    {
        if (!is_string($task)) {
            throw new \InvalidArgumentException(
                'Could not add task to registry. '
                . 'Unexpected ' . gettype($task) . '. Expected a string'
            );
        }

        array_push(
            $this->_taskRegistry,
            $task
        );
        
        return $this;
    }
}
