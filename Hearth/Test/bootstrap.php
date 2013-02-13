<?php
/**
 * bootstrap.php
 *
 * Testing framework bootstrap
 * Loads autoloaders and exactly nothing else
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
    . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load our autoloader
\Hearth\Autoload::registerDefaultAutoloader(
    dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
);
// Load Composer autoloader
\Hearth\Autoload::loadAndRegisterComposer(
    dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
);
