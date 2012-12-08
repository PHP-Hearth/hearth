<?php
/**
 * hearth.php
 *
 * Core of application
 * 
 * @category Hearth
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */

define('HEARTH_DS', '/');

require dirname(__FILE__) . HEARTH_DS . 'Hearth' . HEARTH_DS . 'Core.php';

$core = new \Hearth\Core();

$core->main();
