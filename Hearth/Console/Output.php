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

use \Hearth\Ansi\Format as Formatter;

/**
 * Output
 *
 * Console output library
 *
 * @category Hearth
 * @package Console
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
class Output extends Formatter
{
	public function printLine($string, Array $settings = null)
	{
		$this->_parseSettings($settings);
		echo $this->getSequence() . $string . $this->clear();
		return $this;
	}

	public function dump($variable, Array $settings = null)
	{
		$this->_parseSettings($settings);
		echo $this->getSequence();
		print_r($variable);
		echo $this->clear();
		return $this;
	}

	protected function _parseSettings(Array $settings = null)
	{
		if (is_array($settings)) {
			foreach($settings as $setting => $value) {
				$this->_applySetting($setting, $value);
			}
		}
	}

	protected function _applySetting($setting, $value)
	{
		$methodName = 'set'.ucfirst($setting);

		if (method_exists($this, $methodName)) {
			$this->$methodName($value);
		}
	}
}
