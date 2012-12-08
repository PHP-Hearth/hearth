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
     * @return void
     */
    public function run($target)
    {
        // Call and excute a target
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
                throw new \InvalidArgumentException(
                    'A location must be a string.'
                );
            }
            // Check if this location is already in the stack
            if (!in_array($location, $this->_locations) {
                $this->_locations[] = $location;
            }
        }

        return $this;
    }
}
