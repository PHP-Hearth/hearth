<?php
/**
 * Core.php
 *
 * Hearth Core class
 *
 * @category Hearth
 * @package Core
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */

namespace Hearth;

use Hearth\Ansi\Format;
use Hearth\Target\Resolver;

/**
 * Core
 *
 * @category Hearth
 * @package Core
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
class Core
{
    /**
     * @var boolean Wheather or not the build is marked as failed
     */
    protected $_failed = false;

    /**
     * @var array The arguments given for the build script
     */
    protected $_args = array();

    /**
     * Index of targets available to Hearth
     *
     * @var array
     * @access protected
     */
    protected $_targetIndex = array();

    /**
     * Output Processor cache
     *
     * @var mixed
     * @access protected
     */
    protected $_outputProcessor = null;

    /**
     * Retrieve an output processor object
     * 
     * @access public
     * @return \Hearth\Console\Output
     */
    public function getOutputProcessor()
    {
        if (is_null($this->_outputProcessor)) {
            throw new \Hearth\Exception\NoOutputFormatterFound(
                "No output processor has been configured."
            );
        }

        return $this->_outputProcessor;
    }

    public function output()
    {
        return $this->getOutputProcessor();
    }

    /**
     * Set an output processor
     * 
     * @param \Output $outputProcessor
     *
     * @access public
     * @return \Hearth\Core
     */
    public function setOutputProcessor(Console\Output $outputProcessor)
    {
        $this->_outputProcessor = $outputProcessor;

        return $this;
    }

    /**
     * Primary procedure
     * 
     * @access public
     * @return void
     */
    public function main()
    {
        $args = $this->getArgs();
        $argumentCount = count($args);
        $initialYml = '.hearth.yml';

        $resolver = new Resolver();
        $resolver->setInitialYmlPath($initialYml);

        switch ($argumentCount) {
            case 1:
                // Show Index of all targets
                $resolver->index();
                exit;
                break;

            case 2:
                // Call target
                $targetArgs = explode('/', $args[1]);
                break;

            case 3:
                // Call target and specify config name
                $targetArgs = explode('/', $args[2]);
                $initialYml = $args[1];
                break;
        }
        
        $resolver->lookup($targetArgs);

        require $resolver->getTargetFile();

        $targetName = $resolver->getTargetClassName();
        $target = new $targetName();

        $target->main();

        return $this;
    }

    /**
     * setArgs
     *
     * Sets the arguments given from the application call
     *
     * @access public
     * @param array $args
     * @return \Hearth\Core
     * @throws \InvalidArgumentException
     */
    public function setArgs($args)
    {
        if (!is_array($args)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($args) . '. Expected an array'
            );
        }

        $this->_args = $args;

        return $this;
    }

    /**
     * getArgs
     *
     * Gets the arguments given from the application call
     *
     * @access public
     * @return array
     */
    public function getArgs($index = null)
    {
        if (!is_null($index) && !array_key_exists($index, $this->_args)) {
            throw new \InvalidArgumentException(
                "Invalid argument specified, argument does not exist."
            );
        }

        return (is_null($index)) ? $this->_args : $this->_args[$index];
    }

    /**
     * getFailed
     *
     * Get the failed status of the application
     *
     * @access public
     * @return boolean
     */
    public function getFailed()
    {
        return $this->_failed;
    }

    /**
     * setFailed
     *
     * Set the failed status of the application
     *
     * @access public
     * @param boolean $status
     * @return \Hearth\Core
     * @throws \InvalidArgumentException
     */
    public function setFailed($status)
    {
        if (!is_bool($status)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($status) . '. Expected an array'
            );
        }

        $this->_failed = $status;

        return $this;
    }

    /**
     * failBuild
     *
     * Fails the current build
     *
     * @access public
     * @param \Hearth\Exception\BuildException $e
     * @return \Hearth\Core
     */
    public function failBuild(\Hearth\Exception\BuildException $e)
    {
        $this->getOutputProcessor()
             ->printLine(
                 'Build Failed!',
                 array(
                     'foreground' => 'white',
                     'background' => 'red',
                     'attribute'  => 'bold',
                 )
             )
             ->printLine(
                 $e->getMessage()
                 . ' in ' . $e->getFile() . '#' . $e->getLine(),
                 array(
                     'foreground' => 'red',
                 )
             );

        $this->setFailed(true);

        return $this;
    }

    /**
     * close
     *
     * Ends the application and EXITS the php script
     *
     * @access public
     * @return void
     */
    public function close()
    {
        if ($this->getFailed()) {
            exit(1);
        }

        exit(0);
    }
}
