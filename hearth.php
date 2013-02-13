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
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$autoloader = \Hearth\Autoload::registerDefaultAutoloader(dirname(__FILE__));
\Hearth\Autoload::loadAndRegisterComposer(dirname(__FILE__));

$request = \Hearth\Request::constructFromArgs($argv);
$outputProcessor = new \Hearth\Console\Output();

$core = new \Hearth\Core($outputProcessor, $autoloader);
$core->handleRequest($request);
