<?php
/**
 * MockTarget.php
 * 
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */

namespace TestNamespace\Targets;

/**
 * MockTarget
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @category Hearth
 * @package 
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode 
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */
class MockTarget extends \Hearth\Target
{
    public function main()
    {
        echo "It's a thing\n";
        $this->callTarget("MockSubTarget");
        echo "no it isn't\n";
        return;
    }
}
