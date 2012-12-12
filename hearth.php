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

define('HEARTH_DS', '/');

require dirname(__FILE__) . HEARTH_DS . 'Hearth' . HEARTH_DS . 'Autoload.php';

$autoloader = new \Hearth\Autoload();

$autoloader->setDs(HEARTH_DS)
           ->setBasePath(dirname(__FILE__));

spl_autoload_register(array($autoloader, 'load'));

// Autoload Composer libraries
require dirname(__FILE__) . HEARTH_DS . 'vendor' . HEARTH_DS . 'autoload.php';

$outputProcessor = new \Hearth\Console\Output();

// Strip off the program name
$program = array_shift($argv);

$core = new \Hearth\Core();

$core->setOutputProcessor($outputProcessor)
     ->setArgs($argv)
     ->setDs(HEARTH_DS);

try {
    $core->main()->close();
} catch(\Hearth\Exception\BuildException $e) {
    $core->failBuild($e)->close();
} catch(\Exception $e) {
    $core->displayException($e)->close();
}
