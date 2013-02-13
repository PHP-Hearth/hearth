<?php
/**
 * bootstrap.php
 *
 * Testing framework bootstrap
 * 
 * @category Hearth
 * @package Tests
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */
require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
    . '..' . DIRECTORY_SEPARATOR . 'Hearth' . DIRECTORY_SEPARATOR
    . 'Autoload' . DIRECTORY_SEPARATOR . 'AutoloadInterface.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR 
    . '..' . DIRECTORY_SEPARATOR . 'Hearth' . DIRECTORY_SEPARATOR
    . 'Autoload.php';

$autoloader = new \Hearth\Autoload();

require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
    . '..' . DIRECTORY_SEPARATOR . 'Hearth' . DIRECTORY_SEPARATOR . 'Autoload' 
    . DIRECTORY_SEPARATOR . 'Path.php';

$corePath = new \Hearth\Autoload\Path(
    dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
);

$autoloader->addLoadPath($corePath);

spl_autoload_register(array($autoloader, 'load'));

// Autoload Composer libraries
require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR 
    . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR
    . 'autoload.php';
