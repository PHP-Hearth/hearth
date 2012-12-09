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

use Symfony\Component\Yaml\Yaml;

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
     * @var array The arguments given for the build script
     */
    protected $_args = array();
    
    /**
     * Current working directory
     *
     * This is the direction from which Hearth was called in the CLI
     *
     * @var string
     * @access protected
     */
    protected $_cwd = null;

    /**
     * Default Hearth config file name
     *
     * @var string
     * @access protected
     */
    protected $_defaultConfigName = 'Hearth/.hearth.yml';

    /**
     * Name of the initialized config file
     *
     * This is set in main()
     *
     * @var string
     * @access protected
     */
    protected $_configName;

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
    public function output()
    {
        if (is_null($this->_outputProcessor)) {
            throw new \Hearth\Exception\NoOutputFormatterFound(
                "No output processor has been configured."
            );
        }

        return $this->_outputProcessor;
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
     * Build an index of available Targets
     *
     * This method creates a mapped index of all
     * available Targets starting.
     * 
     * @access protected
     * @return void
     */
    protected function _buildTargetIndex($config, $path = '')
    {
        if ($path === '') {
            $path = dirname(realpath($this->_cwd.'/'.$config)) . '/';
        }
        
        $configData = $this->_loadConfigFile($path . basename($config));

        $element = (object) array(
            'namespace'  => (property_exists($configData, 'namespace')) ? $configData->namespace : null,
            'targetPath' => (property_exists($configData, 'targets')) ? $configData->targets : null,
            'taskPath'   => (property_exists($configData, 'tasks')) ? $configData->tasks : null,
            'path'       => $path,
            'targets'    => array(),
            'children'   => array(),
        );
        
        // Load all the Targets Available
        if (file_exists($path.$element->targetPath)) {
            //get all image files with a .jpg extension.
            $targets = glob($path.$element->targetPath . "/*.php");

            foreach ($targets as $target) {
                $element->targets[] = substr(basename($target), 0, -4);
            }
        }

        // Load all the Tasks Available
        if (file_exists($path.$element->taskPath)) {
            //get all image files with a .jpg extension.
            $tasks = glob($path.$element->taskPath . "/*.php");

            foreach ($tasks as $task) {
                $element->tasks[] = substr(basename($task), 0, -4);
            }
        }

        // Load any child Hearth configs
        if (property_exists($configData, 'children')) {
            foreach ((array) $configData->children as $child) {
                $element->children = $this->_buildTargetIndex($child, $element->path);
            }
        }

        return $tree;
    }

    /**
     * Parse a YML file
     * 
     * @param string $file Full path and filename to the YML file
     *
     * @access protected
     * @return array
     */
    protected function _loadConfigFile($file) {
        if (!file_exists($file)) {
            throw new \Hearth\Exception\FileNotFound(
                "Unable to find configuration file: {$file}"
            );
        }
        return (object) Yaml::parse($file);
    }

    /**
     * Primary procedure
     * 
     * @access public
     * @return void
     */
    public function main()
    {
        $this->_cwd = getcwd();

        $argumentCount = count($this->getArgs());

        switch ($argumentCount) {
            case 2:
                $targetName = $this->getArgs(1);
                break;

            case 3:
                $this->setConfigName($this->getArgs(1));
                $targetName = $this->getArgs(2);
                break;
        }

        // Parse the base config file
        $this->_targetIndex = $this->_buildTargetIndex($this->getConfigName());

        // Define requested Target
        $this->output()->printLine($targetName);

        $target = $this->_loadTarget($targetName);

        $this->output()->setBackground('blue')
                       ->setForeground('white')
                       ->dump($this->_targetIndex);

        return;
    }

    public function _loadTarget($target)
    {
        $parts = explode('/', $target);

        $targetName = array_pop($parts);

        // Traverse down the targetIndex
        
        $configSet = null;

        foreach ($parts as $part) {
            $configSet = $configSet['children'];
        }
    }

    /**
     * Set the configuration file name
     *
     * This sets the name of the configuration file that Hearth
     * will use to build it's Target index from.
     * 
     * @param mixed $name Description.
     *
     * @access public
     * @return mixed Value.
     */
    public function setConfigName($name)
    {
        if (!is_string($name)) {
            throw new \UnexpectedValueException(
                sprintf("Expected a string, got a %s", gettype($name))
            );
        }
        $this->_configName = $name;
    }

    public function getConfigName()
    {
        if (empty($this->_configName)) {
            $this->setConfigName($this->_defaultConfigName);
        }

        return $this->_configName;
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
}
