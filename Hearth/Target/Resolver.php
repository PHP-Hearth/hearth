<?php
/**
 * Resolver.php
 *
 * Hearth Resolver
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Target;

use Symfony\Component\Yaml\Yaml;
use Hearth\Console\Output\OutputInterface;

/**
 * Resolver
 *
 * Hearth resolver class. Used
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Resolver
{
    /**
     * @var string The initial yaml file to start from
     */
    protected $_initialYmlPath;

    /**
     * @var string The resolved target name
     */
    protected $_targetName;

    /**
     * @var string the path of the resolved child's targets
     */
    protected $_targetsPath;

    /**
     * @var string The base namespace of the resolved child's targets
     */
    protected $_targetsNamespace;

    /**
     * @var string The absolute path of the resolved target
     */
    protected $_lastChildTargetsPath;

    /**
     * _loadConfigFile
     *
     * Parse a YML file into an array
     *
     * @access protected
     * @param string $file Full path and filename to the YML file
     * @return array
     */
    protected function _loadConfigFile($file) {
        if (!file_exists($file)) {
            throw new \Hearth\Exception\FileNotFound(
                "Unable to find configuration file: {$file}"
            );
        }
        return Yaml::parse($file);
    }

    /**
     * _resolveConfigPath
     *
     * Resolves a path from a queue of children config files for hearth to load
     * This is used to parse the final configuration file from a given command
     * line input such ad Hearth/Demo/Build. loading the final configuration
     * file for 'Build' in that case.
     *
     * @access protected
     * @param array $queue The argument queue to load from
     * @param string $initial The path of the initial config to load from
     * @return string
     */
    protected function _resolveConfigPath($queue, $initial)
    {
        $path = $initial;

        for ($yml = $this->_loadConfigFile($initial);
            count($queue) > 0;
            $yml = $this->_loadConfigFile($path)) {

            $child = array_shift($queue);

            $path = $yml['children'][$child];

        }

        return $path;
    }

    /**
     * lookup
     *
     * Resolves the various properties of the target arguments
     *
     * @access public
     * @param array $targetArgs The target arguments to lookup on
     * @return \Hearth\Target\Resolver
     */
    public function lookup(array $targetArgs)
    {
        $targetName = array_pop($targetArgs);
        $childQueue = $targetArgs;

        $lastChildYmlPath = $this->_resolveConfigPath($childQueue, $this->getInitialYmlPath());
        $lastChildYaml = $this->_loadConfigFile($lastChildYmlPath);

        $namespace = $lastChildYaml['namespace'];

        $this->setTargetName($targetName);
        $this->setTargetsPath(
            realpath(dirname($lastChildYmlPath)) . DIRECTORY_SEPARATOR 
            . $lastChildYaml['targets']
        );
        $this->setTargetsNamespace($namespace);
        $this->setLastChildTargetsPath(
            DIRECTORY_SEPARATOR . $lastChildYaml['targets']
        );

        return $this;
    }

    /**
     * index
     *
     * Lists out all available targets to use from the initial yaml file
     * recursively down all children
     *
     * @access public
     * @return \Hearth\Target\Resolver
     */
    public function index()
    {
        $this->getOutputProcessor()->printLn("Available Targets");
        $this->getOutputProcessor()->printLn("-----------------");

        $index = $this->_indexConfig($this->getInitialYmlPath());

        $this->_displayIndex($index);

        return $this;
    }

    /**
     * _displayIndex
     *
     * Display an index array of targets to the console output.
     * This is where any formatting of the output list can be done
     *
     * @access protected
     * @param array $index The index of options to display
     * @param string $namespace The base namespace, used for recursing
     * @return \Hearth\Target\Resolver
     */
    protected function _displayIndex(array $index, $namespace = '')
    {
        if (isset($index['targets'])) {
            $path = $index['targets'] . DIRECTORY_SEPARATOR . '*.php';

            $files = glob($path);
            foreach ($files as $file) {
                $this->getOutputProcessor()->printLn(
                    '    - ' . $namespace . basename($file, '.php')
                );
            }
        }

        if (isset($index['children']) && is_array($index['children'])) {
            foreach ($index['children'] as $child => $value) {
                $this->_displayIndex($value, $namespace . $child . '/');
            }
        }

        return $this;
    }

    /**
     * _indexConfig
     *
     * Loads an index array of the targets and their children available
     *
     * @access protected
     * @param string $config the configuration file to initally load from
     * @return array
     */
    protected function _indexConfig($config)
    {
        // Get the absolute path of the config file so we can set the path to 
        // the targets correctly
        $path = realpath(dirname($config));

        $config = $this->_loadConfigFile($config);

        if ($config['targets'] != '') {
            $targets['targets'] = $path . DIRECTORY_SEPARATOR . $config['targets'];
        } else {
            $targets['targets'] = '';
        }

        if (!is_array($config['children'])) {
            return $targets;
        }

        foreach ($config['children'] as $childName => $childConfigPath) {
            $targets['children'][$childName] = $this->_indexConfig($childConfigPath);
        }

        return $targets;
    }

    /**
     * setInitialYmlPath
     *
     * Sets the initial yaml configuration file to load from
     *
     * @access public
     * @param string $path The yaml file to load
     * @return \Hearth\Target\Resolver
     * @throws \InvalidArgumentException
     */
    public function setInitialYmlPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($path) . '. Expected a string'
            );
        }

        $this->_initialYmlPath = $path;

        return $this;
    }

    /**
     * getInitialYmlPath
     *
     * Get inital yaml path to load configurations from
     *
     * @access public
     * @return string
     */
    public function getInitialYmlPath()
    {
        return $this->_initialYmlPath;
    }

    /**
     * setTargetName
     *
     * Sets the resolved target name
     *
     * @access public
     * @param string $name
     * @return \Hearth\Target\Resolver
     * @throws \InvalidArgumentException
     */
    public function setTargetName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($name) . '. Expected a string'
            );
        }

        $this->_targetName = $name;

        return $this;
    }

    /**
     * getTargetName
     *
     * Get the resolved target name
     *
     * @access public
     * @return type
     */
    public function getTargetName()
    {
        return $this->_targetName;
    }

    /**
     * setTargetsPath
     *
     * Set the resolved target class path
     *
     * @access public
     * @param string $path
     * @return \Hearth\Target\Resolver
     * @throws \InvalidArgumentException
     */
    public function setTargetsPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($path) . '. Expected a string'
            );
        }
        
        $this->_targetsPath = $path;

        return $this;
    }

    /**
     * getTargetsPath
     *
     * Get the resolved target class path
     *
     * @access public
     * @return string
     */
    public function getTargetsPath()
    {
        return rtrim($this->_targetsPath, DIRECTORY_SEPARATOR);
    }

    /**
     * getTargetsNamespace
     *
     * Gets the namespace of the resolved target
     *
     * @access public
     * @return string
     */
    public function getTargetsNamespace()
    {
        return $this->_targetsNamespace;
    }

    /**
     * setTargetsNamespace
     *
     * Set the namespace of the resolved target
     *
     * @access public
     * @param string $namespace
     * @return \Hearth\Target\Resolver
     * @throws \InvalidArgumentException
     */
    public function setTargetsNamespace($namespace)
    {
        if (!is_string($namespace)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($namespace) . '. Expected a string'
            );
        }

        $this->_targetsNamespace = $namespace;

        return $this;
    }

    /**
     * getTargetFile
     *
     * Get the absolute file path of the target
     *
     * @access public
     * @return string
     */
    public function getTargetFile()
    {
        return $this->getTargetsPath() . DIRECTORY_SEPARATOR 
            . $this->getTargetName() . '.php';
    }

    /**
     * setLastChildTargetsPath
     *
     * The path of the final child's targets, relative to the location of the
     * final config file
     *
     * @access public
     * @param string $path
     * @return \Hearth\Target\Resolver
     * @throws \InvalidArgumentException
     */
    public function setLastChildTargetsPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($path) . '. Expected a string'
            );
        }

        $this->_lastChildTargetsPath = $path;

        return $this;
    }

    /**
     * getLastChildTargetsPath
     *
     * Gets the path of the final child's targets relative to the location of
     * the final config file
     *
     * @access public
     * @return type
     */
    public function getLastChildTargetsPath()
    {
        return $this->_lastChildTargetsPath;
    }

    /**
     * getTargetClassName
     *
     * Gets the fully qualified class name of the resolved target
     *
     * @access public
     * @return string
     */
    public function getTargetClassName()
    {
        $className = '\\' . $this->getTargetsNamespace();
        $className .= preg_replace('#/#', '\\', trim($this->getLastChildTargetsPath(), '.'));
        $className .= '\\' . $this->getTargetName();

        return $className;
    }

    /**
     * setOutputProcessor
     *
     * Set an output processor to use throughout the class
     *
     * @access public
     * @param \Output $outputProcessor
     * @return \Hearth\Core
     */
    public function setOutputProcessor(OutputInterface $outputProcessor)
    {
        $this->_outputProcessor = $outputProcessor;

        return $this;
    }

    /**
     * getOutputProcessor
     *
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
}
