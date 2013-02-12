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

        ob_start();
        $targetClass->main();
        $targetOutput = ob_get_clean();
        $classNameSegments = explode('\\', $fullClassName);
        $targetName = end($classNameSegments);

        $this->sectionedOutput($targetOutput, $targetName);
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
    public function sectionedOutput($output, $sectionTitle)
    {
        if (empty($output)) {
            return;
        }

        $outputLines = preg_split("/\n/", $output);

        foreach ($outputLines as $line) {
            $builtOutputString = '[' . $sectionTitle . '] ';
            $builtOutputString .= $line;
            echo $builtOutputString . "\n";
        }

        return;
    }
}
