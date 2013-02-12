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

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Hearth' . DIRECTORY_SEPARATOR . 'Autoload' . DIRECTORY_SEPARATOR . 'Path.php';
$corePath = new \Hearth\Autoload\Path(dirname(__FILE__));
$autoloader->addLoadPath($corePath);

spl_autoload_register(array($autoloader, 'load'));

// Autoload Composer libraries
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';

$outputProcessor = new \Hearth\Console\Output();

$request = \Hearth\Request::constructFromArgs($argv);

$core = new \Hearth\Core($request);

$core->setOutputProcessor($outputProcessor)
     ->setAutoloader($autoloader);

try {
    $core->main()->close();
} catch(\Hearth\Exception\BuildException $e) {
    $core->failBuild($e)->close();
} catch(\Exception $e) {
    $core->displayException($e)->close();
}
