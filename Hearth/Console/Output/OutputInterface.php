<?php
/**
 * OutputInterface.php
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */

namespace Hearth\Console\Output;

/**
 * OutputInterface
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @category Hearth
 * @package
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
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
