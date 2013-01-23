<?php
/**
 * Target.php
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

use Hearth\Console\Output\OutputInterface;

/**
 * Target
 *
 * Target class abstraction for all hearth targets to extend
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
abstract class Target
{
    /**
     * @var int The target nesting level
     */
    private $level = 0;

    /**
     * Constructor
     *
     * Constructs a new target
     *
     * @param int $level
     * @return void
     */
    public function __construct($level = 0)
    {
        $this->setLevel($level);
    }

    /**
     * main
     *
     * @access public
     * @return void
     */
    abstract public function main();

    /**
     * callTarget
     *
     * Calls a subtarget to be run inside of a Target
     *
     * @access protected
     * @param string $name The target class to run
     * @return void
     */
    protected function callTarget($name)
    {
        $namespace = implode(
            '\\',
            array_slice(
                explode('\\', get_called_class()),
                0,
                -1
            )
        );

        $fullClassName = '\\' . $namespace . '\\' . $name;
        $targetClass = new $fullClassName();

        if (!$targetClass instanceof Target) {
            throw new \InvalidArgumentException(
                'Unexpected '
                . get_class($targetClass)
                . '. Expected an instance of Target'
            );
        }

        $level = $this->getLevel();
        ++$level;
        $targetClass->setLevel($level);

        ob_start();
        $targetClass->main();
        $targetOutput = ob_get_clean();
        $targetName = "JustATest";

        $this->sectionedOutput($targetOutput, $targetName, $this->getLevel()+2);
    }

    /**
     * sectionedOutput
     *
     * Displays a string line by line divided into sections marked by their
     * section title and optionally indented.
     *
     * @access public
     * @param string $output
     * @param string $sectionTitle
     * @param int $lineIndent
     * @return void
     */
    public function sectionedOutput($output, $sectionTitle, $lineIndent = 1)
    {
        if (empty($output)) {
            return;
        }

        if (!is_int($lineIndent)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($lineIndent) . '. Expected an int'
            );
        }

        $outputLines = preg_split("/\n/", $output);

        foreach ($outputLines as $line) {
            $builtOutputString = '';

            for ($x = 0; $x < $lineIndent; $x++) {
                $builtOutputString .= '  ';
            }

            $builtOutputString .= '[' . $sectionTitle . '] ';
            $builtOutputString .= $line;
            $this->getOutputProcessor()->printLn($builtOutputString);
        }

        return;
    }

    /**
     * Set Level
     *
     * Sets the nesting level of the target call
     *
     * @param int $level The level to set
     * @return \Hearth\Target
     * @throws \InvalidArgumentException
     */
    public function setLevel($level)
    {
        if (!is_int($level)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($level) . '. Expected an int'
            );
        }
        $this->level = $level;

        return $this;
    }

    /**
     * Get Level
     *
     * Gets the nesting level of the target
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Set an output processor
     *
     * @param \Output $outputProcessor
     *
     * @access public
     * @return \Hearth\Core
     */
    public function setOutputProcessor(OutputInterface $outputProcessor)
    {
        $this->outputProcessor = $outputProcessor;

        return $this;
    }

    /**
     * Retrieve an output processor object
     *
     * @access public
     * @return \Hearth\Console\Output
     */
    public function getOutputProcessor()
    {
        if (!isset($this->outputProcessor)) {
            throw new \UnexpectedValueException(
                'No output processor has been configured.'
            );
        }

        return $this->outputProcessor;
    }
}
