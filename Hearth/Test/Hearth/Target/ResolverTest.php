<?php
/**
 * ResolverTest.php
 *
 * @category Hearth
 * @package Test
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

use Hearth\Target\Resolver;

/**
 * ResolverTest
 *
 * @category Hearth
 * @package Test
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class ResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Hearth\Target\Resolver 
     */
    private $resolver;

    /**
     * setUp
     */
    public function setUp()
    {
        $mockOutput = new Hearth\Test\Mock\Output();
        $testYaml   = dirname(__FILE__) . '../../Mock/config/test/.hearth.yml';

        $this->resolver = new Resolver();
        $this->resolver->setOutputProcessor($mockOutput)
                       ->setInitialYmlPath($testYaml);
    }

    public function testResol()
    {
        $this->resolver->lookup(array('TestChild', 'MockTarget'));
    }
}
