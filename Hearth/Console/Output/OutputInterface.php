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
    public function printLn($string);
}
