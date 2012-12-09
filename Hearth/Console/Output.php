<?php
/**
 * Output.php
 *
 * Console output library
 *
 * @category Hearth
 * @package Console
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Console;

use \Hearth\Ansi\Format;

/**
 * Output
 *
 * Console output library
 *
 * @category Hearth
 * @package Console
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
class Output
{
    /**
     * @var \Hearth\Ansi\Format The format output sequence to use 
     */
    protected $_format;

    /**
     * printLine
     *
     * Outputs a single line to the console
     *
     * @access public
     * @param string $string The string to output
     * @param array $settings
     * @return \Hearth\Console\Output
     */
    public function printLine($string, Array $settings = null)
	{
		$format = $this->getFormat($settings);
        
		echo $format->getSequence() . $string . "\n" . $format->clear();
        
		return $this;
	}

    /**
     * dump
     *
     * Dumps a variable to the output
     *
     * @access public
     * @param mixed $variable the variable to dump
     * @param array $settings
     * @return \Hearth\Console\Output
     */
	public function dump($variable, Array $settings = null)
	{
		$format = $this->getFormat($settings);

		echo $format->getSequence();
		print_r($variable);
        echo "\n";
		echo $format->clear();

		return $this;
	}

    /**
     * getFormat
     *
     * Gets the format object to use
     *
     * @access public
     * @param array $settings
     * @return \Hearth\Ansi\Format
     */
    public function getFormat($settings = null)
    {
        if (!$this->_format && !isset($settings)) {
            $tmpFormat = new Format();
            $tmpFormat->setAttribute('clear');
            
            return $tmpFormat;
        }

        if (!isset($settings)) {
            return $this->_format;
        }

        if ($settings instanceof Format) {
            return $settings;
        }

        $tmpFormat = new Format();
        foreach ($settings as $setting => $value) {
            $methodName = 'set' . ucfirst($setting);

            $tmpFormat->$methodName($value);
        }

        return $tmpFormat;
    }

    /**
     * setFormat
     *
     * Sets the default format to use
     *
     * @access public
     * @param \Hearth\Ansi\Format $format
     * @return \Hearth\Console\Output
     */
    public function setFormat(Format $format = null)
    {
        $this->_format = $format;

        return $this;
    }

    /**
     * resetFormat
     *
     * Resets the default format to use on outputs
     *
     * @access public
     * @return \Hearth\Console\Output
     */
    public function resetFormat()
    {
        unset($this->_format);

        return $this;
    }
}
