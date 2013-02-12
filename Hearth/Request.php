<?php
/**
 * Request.php
 *
 * @category hearth
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */

namespace Hearth;

/**
 * Request
 *
 * This class models the requesat made to the hearth builder and any data given
 * to it.
 *
 * @category hearth
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class Request
{
    /**
     * @var string The target being requested
     */
    private $target;

    /**
     * @var string The configuration file to use for hearth
     */
    private $config;

    /**
     * Constructor
     * 
     * Construct a new Request
     */
    public function __construct($target, $config)
    {
        $this->setTarget($target);
        $this->setConfig($config);
    }

    /**
     * Construct From Arguments
     *
     * Construct a new Request from an argument array, typically from the CLI
     *
     * @param array $args The arguments to construct with
     * @return \Hearth\Request
     */
    public static function constructFromArgs(array $args)
    {
        // Shift off script name
        array_shift($args);

        $target = array_shift($args);
        $config = array_shift($args);

        $request = new self($target, $config);

        return $request;
    }
    
    /**
     * Get Target
     *
     * Gets the target that is to be used for the build request
     * 
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set Target
     *
     * @param string $target The target to use for this build request
     * @return \Hearth\Request
     */
    public function setTarget($target)
    {
        if (!is_string($target) && !$target === null) {
            throw new \InvalidArgumentException(
                'Unexpected type: ' . gettype($target) . '. Expected a string.'
            );
        }

        $this->target = $target;
        
        return $this;
    }

    /**
     * Get Config
     *
     * Gets the config file to be used for the build request
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set Config
     *
     * @param string $config The config file to load for hearth
     * @return \Hearth\Request
     */
    public function setConfig($config)
    {
        if (!is_string($config) && !$config === null) {
            throw new \InvalidArgumentException(
                'Unexpected type: ' . gettype($config) . '. Expected a string.'
            );
        }
        
        $this->config = $config;

        return $this;
    }
}
