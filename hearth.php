<?php
/**
 * hearth.php
 *
 * Core of application
 * 
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */

define('DS', '/');

require dirname(__FILE__) . DS . 'Hearth' . DS . 'Core.php';

$core = new \Hearth\Core();

$core->main();
