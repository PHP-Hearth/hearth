<?php
/**
 * Chmod.php
 *
 * Description of Chmod.php
 * 
 * @category Hearth
 * @package Tasks
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Task;

use Hearth\Task as TaskInterface;

class Write implements TaskInterface
{
	protected $_string = '';

	public function main()
	{
		echo $this->_string;
	}

	public function setText($string)
	{
		$this->_string = $string;
	}
}
