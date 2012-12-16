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
    public function printLn($string);
}
