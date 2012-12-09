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
     * Build an index of available Targets
     *
     * This method creates a mapped index of all
     * available Targets starting.
     * 
     * @access protected
     * @return void
     */
    protected function _buildTargetIndex($config, $path = '', $tree = array())
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

        // Load all the f

        // Load any child Hearth configs
        if (property_exists($configData, 'children')) {
            foreach ((array) $configData->children as $child) {
                $element->children[] = $this->_buildTargetIndex($child, $element->path, $tree);
            }
        }

        $tree[] = $element;

        return $element;
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

        global $argv;

        $argumentCount = count($argv);

        switch ($argumentCount) {
            case 2:
                
                break;

            case 3:
                $this->setConfigName($argv[1]);
                break;
        }

        // Parse the base config file
        $this->_targetIndex = $this->_buildTargetIndex($this->getConfigName());

        print_r($this->_targetIndex);

        return;
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
     * Execute a Hearth Target
     *
     * @param string $target Target name
     *
     * @access public
     * @return \Hearth\Core
     */
    public function run($target)
    {
        $this->_buildTargetIndex(getcwd());
        $target = $this->_loadTarget($target);
        return $this;
    }
    
    /**
     * Load a Target Class
     *
     * Requires a class file based on the value of $target.
     * The value of $target should be the fully qualified
     * namespace of the Target class you wish to load.
     *
     * Ex.
     * $target = /path/to/some/bundle/Targets/MyTarget
     *
     * This will attempt to load the file:
     * /path/to/some/bundle/Targets/MyTarget.php
     *
     * Then it will create a new instance of:
     * \
     * 
     * @param string $target /path/to/Target/SomeTarget
     *
     * @access protected
     * @return mixed Value.
     */
    protected function _loadTarget($target)
    {
        
    }
}
