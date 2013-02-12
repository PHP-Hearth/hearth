<?php
/**
 * Output.php
 *
 * @category Hearth
 * @package Test
 * @subpackage Mock
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Test\Mock;

/**
 * Output
 *
 * @category Hearth
 * @package Test
 * @subpackage Mock
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Output implements \Hearth\Console\Output\OutputInterface
{
    public function bgColor($color)
    {
        return $this;
    }

    public function fgColor($color)
    {
        return $this;
    }

    public function intense()
    {
        return $this;
    }

    public function printLn($string)
    {
        return $this;
    }

    public function reset()
    {
        return $this;
    }
}
