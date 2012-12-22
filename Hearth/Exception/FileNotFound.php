<?php
/**
 * FileNotFound.php
 *
 * File Not Found Exception
 *
 * @category Hearth
 * @package Exception
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Exception;

use Hearth\Exception as HearthException;

/**
 * FileNotFound
 *
 * File not found exception, used when the hearth internal system cannot find
 * a file it expected to find. This usually occurs when a child is defined
 * without a configuration file
 *
 * @category Hearth
 * @package Exception
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class FileNotFound extends HearthException
{
	/**
	 * Error string to use if a filename was given.
	 */
	const DEFAULT_ERROR_STRING = 'Unable to locate file: ';

	/**
	 * Error string to use if no filename was given.
	 */
	const DEFAULT_NULL_ERROR_STRING = 'Unable to locate file.';

	/**
	 * Initialization
	 *
	 * @param string $file Filename
	 */
	public function __construct($file = null)
	{
		if (!is_null($file)) {
			$message = self::DEFAULT_ERROR_STRING . $file;
		} else {
			$message = self::DEFAULT_NULL_ERROR_STRING;
		}

		return parent::__construct($message);
	}
}
