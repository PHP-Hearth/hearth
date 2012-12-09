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
    abstract public function main();

    /**
     * task
     *
     * Adds a task to the registry to be built on a target
     *
     * @access public
     * @param object $task
     * @return \Hearth\Target
     */
    public function addTask($task)
    {
        if (!is_object($task)) {
            throw new \UnexpectedValueException(
                'Expected an object, got a ' . gettype($task)
            );
        }
        $this->addTaskToRegistry($task);
        return $task;
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
        array_push(
            $this->_taskRegistry,
            $task
        );
        
        return $this;
    }

    /**
     * Execute tasks
     * 
     * @access public
     * @return void
     */
    public function execute()
    {
        $tasks = $this->getTaskRegistry();
        foreach ($tasks as $task) {
            $task->main();
        }

        return;
    }
}
