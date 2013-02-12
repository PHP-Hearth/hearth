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

namespace Hearth\Test\Hearth\Target;

use Hearth\Target\Resolver;
use Hearth\Test\Mock\Output;

use PHPUnit_Framework_TestCase as Test;

/**
 * ResolverTest
 *
 * @category Hearth
 * @package Test
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class ResolverTest extends Test
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
        $mockOutput = new Output();
        $testYaml   = dirname(__FILE__) . '/../../Mock/config/.hearth.yml';

        $this->resolver = new Resolver();
        $this->resolver->setOutputProcessor($mockOutput)
                       ->setResolveBasePath(getcwd())
                       ->setInitialYmlPath($testYaml);
    }

    /**
     * testResolverLookup
     *
     * Tests the resolver's lookup function
     */
    public function testResolverLookup()
    {
        $this->resolver->lookup(array('TestChild', 'MockTarget'));

        $this->assertEquals(
            '/Targets/MockTarget.php',
            $this->resolver->getTargetFile()
        );
        $this->assertEquals(
            '\TestNamespace\Targets\MockTarget',
            $this->resolver->getTargetClassName()
        );

        return;
    }
}
