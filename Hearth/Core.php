<?php
/**
 * Core.php
 *
 * Hearth Core class
 *
 * @category Hearth
 * @package Core
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth;

use Hearth\Ansi\Format;
use Hearth\Target\Resolver;
use Hearth\Console\Output\OutputInterface;
use Hearth\Exception\FileNotFound as FileNotFoundException;

/**
 * Core
 *
 * @category Hearth
 * @package Core
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
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
     * Set an output processor
     *
     * @param \Output $outputProcessor
     *
     * @access public
     * @return \Hearth\Core
     */
    public function setOutputProcessor(OutputInterface $outputProcessor)
    {
        $this->_outputProcessor = $outputProcessor;

        return $this;
    }

    /**
     * Retrieve an output processor object
     *
     * @access public
     * @return \Hearth\Console\Output
     */
    public function getOutputProcessor()
    {
        if (!isset($this->_outputProcessor)) {
            throw new \UnexpectedValueException(
                'No output processor has been configured.'
            );
        }

        return $this->_outputProcessor;
    }

    /**
     * Primary procedure
     *
     * @access public
     * @return void
     */
    public function main()
    {
        $args          = $this->getArgs();
        $argumentCount = count($args);
        $initialYml    = '.hearth.yml';
        $time          = microtime();
        $out           = $this->getOutputProcessor();

        $out->fgColor($out::COLOR_GREEN);
        $out->intense();
        $out->printLn(
            'Hearth Build: ' . getcwd() . DIRECTORY_SEPARATOR . $initialYml
        );
        $out->reset();

        $resolver = new Resolver();
        $resolver->setOutputProcessor($out)
                 ->setInitialYmlPath($initialYml);

        // If no arguments, show the listing (index)
        if ($argumentCount === 0) {
            $resolver->index();
            return $this;
        }

        $targetArgs = explode('/', $args[0]);
        $resolver->lookup($targetArgs);

        $targetFile = $resolver->getTargetFile();

        if (!file_exists($targetFile)) {
            throw new FileNotFoundException("Target '" . $args[0] . "' not found.\nLooking in '" . $targetFile . "'");
        }

        require $targetFile;

        $targetName = $resolver->getTargetClassName();
        $target = new $targetName();

        $target->main();

        $out->printLn('')
            ->set_bgcolor($out::COLOR_GREEN)
            ->set_fgcolor($out::COLOR_BLACK)
            ->printLn('Build Successful!')
            ->reset();

        $timeDiff = microtime() - $time;
        $out->printLn(
            'Build execution time: ' . $timeDiff . 's'
        );
        $out->printLn('');

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
        $this->displayException($e, 'Build Failed!');

        $this->setFailed(true);

        return $this;
    }

    /**
     * Display an exception
     *
     * @access public
     * @param \Exception $exception Exception
     * @param string $warningMessage Special Warning message
     * @return \Hearth\Core
     */
    public function displayException(
        \Exception $exception,
        $warningMessage = 'Exception!'
    ) {
        $out = $this->getOutputProcessor();
        $out->bgColor($out::COLOR_RED)
            ->fgColor($out::COLOR_WHITE)
            ->printLn($warningMessage)
            ->reset()
            ->fgColor($out::COLOR_RED)
            ->printLn(
                $exception->getMessage()
                . ' in ' . $exception->getFile()
                . ':' . $exception->getLine()
            )
            ->reset();

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
