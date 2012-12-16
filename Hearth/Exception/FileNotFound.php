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

}
