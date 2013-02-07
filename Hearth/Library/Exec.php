<?php
/**
 * Exec.php
 *
 * @category hearth
 * @package Library
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */

namespace Hearth\Library;

use Hearth\Task;

/**
 * Exec
 *
 * Executes a command in the system
 *
 * @category hearth
 * @package Library
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class Exec extends Task
{
    /**
     * @var string The command to execute
     */
    private $command;

    /**
     * @var bool Whether or not to fail the build on error of execution
     */
    private $failOnError;

    /**
     * Construct a new execution object
     *
     * @param string $command The command to execute
     * @param bool $failOnError Whether or not to fail the build on error of
     *                          execution
     */
    public function __construct($command, $failOnError = true)
    {
        $this->failOnError = $failOnError;
        $this->command     = $command;
    }

    /**
     * Main execution method
     */
    public function main()
    {
        $returnVal = null;
        $output = null;
        exec($this->getCommand(), $output, $returnVal);

        if ($this->shouldFailOnError() && $returnVal !== 0) {
            throw new \Hearth\Exception\BuildException(
                'Exec task failed, exit with status code: '
                . $returnVal . PHP_EOL
                . 'Output was: ' . PHP_EOL
                . implode(PHP_EOL, $output)
                . PHP_EOL
            );
        }

    }

    /**
     * Get Command
     *
     * Get the command that is supposed to be run in the exec call
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set Command
     *
     * Set the command that is supposed to be run in the exec call
     *
     * @param type $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * Should fail on error
     *
     * @return bool
     */
    public function shouldFailOnError()
    {
        return $this->failOnError;
    }

    /**
     * Set fail on error
     *
     * @param bool $failOnError Whether or not the task should fail the build
     *                          on error of the exec call
     */
    public function setFailOnError($failOnError)
    {
        $this->failOnError = $failOnError;
    }
}
