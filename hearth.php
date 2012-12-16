#!/usr/bin/env php
<?php
/**
 * hearth.php
 *
 * Core of application
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Hearth' 
    . DIRECTORY_SEPARATOR. 'Autoload.php';

$autoloader = new \Hearth\Autoload();

$autoloader->setBasePath(dirname(__FILE__));

spl_autoload_register(array($autoloader, 'load'));

// Autoload Composer libraries
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' 
    . DIRECTORY_SEPARATOR . 'autoload.php';

$outputProcessor = new \Hearth\Console\Output();

// Strip off the program name
$program = array_shift($argv);

$core = new \Hearth\Core();

$core->setOutputProcessor($outputProcessor)
     ->setArgs($argv);

try {
    $core->main()->close();
} catch(\Hearth\Exception\BuildException $e) {
    $core->failBuild($e)->close();
} catch(\Exception $e) {
    $core->displayException($e)->close();
}
