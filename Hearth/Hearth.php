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
     * Location stack
     *
     * @var array
     * @access private
     */
    private $_locations = array(
        ''
    );

    /**
     * Constructor
     *
     * @access public
     * @return mixed Value.
     */
    public function __construct()
    {
        
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
        // Call and excute a target
        return $this;
    }

    /**
     * Add a Target location to the loader
     * 
     * @param string|array $locations
     *
     * @access public
     * @return \Hearth\Core
     */
    public function addTargetLocation($locations)
    {
        foreach ((array) $locations as $location) {
            // Validate that the location is a string
            if (!is_string($location)) {
                throw new \UnexpectedValueException(
                    'A location must be a string.'
                );
            }
            // Check if this location is already in the stack
            if (in_array($location, $this->_locations)) {
                continue;
            }
            // Check that the path is valid
            if (!file_exists($location)) {
                throw new \Hearth\InvalidTargetLocation(
                    'The specified location does not exist.'
                );
            }
            $this->_locations[] = $location;
        }
        return $this;
    }

    public function getTargetLocations()
    {
        return $this->_locations;
    }
}
