<?php
/**
 * OutputInterface.php
 *
 * Console output interface
 *
 * @category Hearth
 * @package Console
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Console\Output;

/**
 * OutputInterface
 *
 * Output interface to define the expected functionality of the output object
 *
 * @category Hearth
 * @package Console
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
interface OutputInterface
{
    const COLOR_BLACK = 0;
    const COLOR_RED = 1;
    const COLOR_GREEN = 2;
    const COLOR_YELLOW = 3;
    const COLOR_BLUE = 4;
    const COLOR_MAGENTA = 5;
    const COLOR_CYAN = 6;
    const COLOR_WHITE = 7;

    public function printLn($string);

    public function fgColor($color);

    public function bgColor($color);

    public function intense();

    public function reset();
}
