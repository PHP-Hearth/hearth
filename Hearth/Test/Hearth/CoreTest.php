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

use Hearth\Core;

/**
 * CoreTest
 *
 * @category Hearth
 * @package Test
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class CoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * testGetArgs
     */
    public function testGetArgs()
    {
        $testCore = new Core();

        $testCore->setArgs(
            array(1 => 'test', 2 => 'abcd')
        );

        $this->assertEquals('test', $testCore->getArgs(1));
        $this->assertEquals('abcd', $testCore->getArgs(2));
    }

    /**
     * testGetArgsFailure
     *
     * @expectedException InvalidArgumentException
     */
    public function testGetArgsFailure()
    {
        $testCore = new Core();

        $testCore->setArgs(
            array(1 => 'test', 2 => 'abcd')
        );

        $this->assertEquals('test', $testCore->getArgs(8));
    }
}
