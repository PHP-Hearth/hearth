<?php
/**
 * bootstrap.php
 *
 * A Shared bootstrap file providing the files needed to start up hearth
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

// Autoload Interface
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Hearth'
    . DIRECTORY_SEPARATOR . 'Autoload' . DIRECTORY_SEPARATOR
    . 'AutoloadInterface.php';

// Autoloader Class
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Hearth'
    . DIRECTORY_SEPARATOR . 'Autoload.php';

// Path Class
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Hearth'
    . DIRECTORY_SEPARATOR . 'Autoload' . DIRECTORY_SEPARATOR . 'Path.php';