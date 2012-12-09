<?php
/**
 * Resolver.php
 *
 * Description of Resolver.php
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

/**
 * Resolver
 *
 * Description of Resolver
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Resolver
{
    
    protected $_initialYmlPath;

    protected $_targetName;

    protected $_targetsPath;

    protected $_targetsNamespace;

    protected $_lastChildTargetsPath;

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
        return Yaml::parse($file);
    }

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

    public function lookup(array $targetArgs)
    {
        $targetName =  array_pop($targetArgs);
        $childQueue = $targetArgs;

        $lastChildYmlPath = $this->_resolveConfigPath($childQueue, $this->getInitialYmlPath());
        $lastChildYaml = $this->_loadConfigFile($lastChildYmlPath);

        $namespace = $lastChildYaml['namespace'];

        $this->setTargetName($targetName);
        $this->setTargetsPath(
            dirname($lastChildYmlPath) . '/' . $lastChildYaml['targets']
        );
        $this->setTargetsNamespace($namespace);
        $this->setLastChildTargetsPath('/' . $lastChildYaml['targets']);
    }

    public function index()
    {
        $index = $this->_indexConfig($this->getInitialYmlPath());

        $this->_displayIndex($index);
    }

    protected function _displayIndex(array $index, $namespace = '')
    {
        if (isset($index['targets'])) {
            $files = glob($namespace . $index['targets'] . '/*.php');
            foreach ($files as $file) {
                echo $namespace . basename($file, '.php') . "\n";
            }
        }

        if(isset($index['children']) && is_array($index['children']))
        foreach ($index['children'] as $child => $value) {
            $this->_displayIndex($value, $namespace . $child . '/');
        }

        return $this;
    }

    protected function _indexConfig($config)
    {
        $config = $this->_loadConfigFile($config);
        $targets['targets'] = $config['targets'];

        if(is_array($config['children']))
        foreach ($config['children'] as $childName => $childConfigPath) {
            $targets['children'][$childName] = $this->_indexConfig($childConfigPath);
        }

        return $targets;
    }

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

    public function getInitialYmlPath()
    {
        return $this->_initialYmlPath;
    }

    public function setTargetName($name)
    {
        $this->_targetName = $name;
    }

    public function getTargetName()
    {
        return $this->_targetName;
    }

    public function setTargetsPath($path)
    {
        $this->_targetsPath = $path;
    }

    public function getTargetsPath()
    {
        return $this->_targetsPath;
    }

    public function getTargetsNamespace()
    {
        return $this->_targetsNamespace;
    }

    public function setTargetsNamespace($namespace)
    {
        $this->_targetsNamespace = $namespace;
    }

    public function getTargetFile()
    {
        return $this->getTargetsPath() . '/' . $this->getTargetName() . '.php';
    }
    public function setLastChildTargetsPath($path)
    {
        $this->_lastChildTargetsPath = $path;
    }
    public function getLastChildTargetsPath()
    {
        return $this->_lastChildTargetsPath;
    }

    public function getTargetClassName()
    {
        $className = '\\' . $this->getTargetsNamespace();
        $className .= preg_replace('#/#', '\\', trim($this->getLastChildTargetsPath(), '.'));
        $className .= '\\' . $this->getTargetName();

        return $className;
    }
}
