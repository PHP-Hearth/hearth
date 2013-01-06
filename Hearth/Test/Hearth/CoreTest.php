<?php
/**
 * CoreTest.php
 * 
 * @category Hearth
 * @package Test
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Test\Hearth;

use Hearth\Core;

use PHPUnit_Framework_TestCase as Test;

/**
 * CoreTest
 *
 * @category Hearth
 * @package Test
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class CoreTest extends Test
{
    /**
     * testGetArgs
     */
    public function testGetArgs()
    {
        $testCore = new Core();

        $testCore->setArguments(
            array(1 => 'test', 2 => 'abcd')
        );

        $this->assertEquals('test', $testCore->getArguments(1));
        $this->assertEquals('abcd', $testCore->getArguments(2));
    }

    /**
     * testGetArgsFailure
     *
     * @expectedException InvalidArgumentException
     */
    public function testGetArgsFailure()
    {
        $testCore = new Core();

        $testCore->setArguments(
            array(1 => 'test', 2 => 'abcd')
        );

        $this->assertEquals('test', $testCore->getArguments(8));
    }
}
