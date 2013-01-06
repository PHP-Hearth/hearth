<?php
/**
 * bootstrap.php
 *
 * Testing framework bootstrap
 * 
 * @category Hearth
 * @package Tests
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */

require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR 
    . '..' . DIRECTORY_SEPARATOR . 'Hearth' . DIRECTORY_SEPARATOR
    . 'Autoload.php';

$autoloader = new \Hearth\Autoload();

$autoloader->setBasePath(
    dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
);

spl_autoload_register(array($autoloader, 'load'));

// Autoload Composer libraries
require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR 
    . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR
    . 'autoload.php';
