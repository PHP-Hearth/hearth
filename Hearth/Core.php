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
}
