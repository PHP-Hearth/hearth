<?php
/**
 * Output.php
 *
 * Console output library
 *
 * @category Hearth
 * @package Console
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Console;

/**
 * Output
 *
 * Outputter class. Handles commands for the console output, rather than
 * printing the output directly, use this class.
 * Class currently is adapting the Qi_Console_Terminal class in order to meet
 * the OutputInterface used in the application. This could be swapped out to use
 * any other library in the future, still using this or another class.
 *
 * @category Hearth
 * @package Console
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Output extends \Qi_Console_Terminal
    implements \Hearth\Console\Output\OutputInterface
{
    /**
     * printLn
     *
     * Outputs a single line to the console
     *
     * @access public
     * @param string $string The string to output
     * @param array $settings
     * @return \Hearth\Console\Output
     */
    public function printLn($string)
    {
        $this->el();
        $this->printterm($string . "\r\n");

        return $this;
    }

    /**
     * fgColor
     *
     * Sets the foreground color of the output if available
     *
     * @access public
     * @param int $color
     * @return \Hearth\Console\Output
     */
    public function fgColor($color)
    {
        $this->set_fgcolor($color);

        return $this;
    }

    /**
     * bgColor
     *
     * Sets the background color of the output if available
     *
     * @access public
     * @param int $color
     * @return \Hearth\Console\Output
     */
    public function bgColor($color)
    {
        $this->set_bgcolor($color);

        return $this;
    }

    /**
     * reset
     *
     * Resets the output formatting to defaults
     *
     * @access public
     * @return \Hearth\Console\Output
     */
    public function reset()
    {
        $this->sgr0();
        $this->op();
        $this->el();

        return $this;
    }

    /**
     * intense
     *
     * Sets the output formatting intensity
     *
     * @access public
     * @return \Hearth\Console\Output
     */
    public function intense()
    {
        $this->bold_type();

        return $this;
    }
}
