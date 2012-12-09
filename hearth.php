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

define('DS', '/');

require dirname(__FILE__) . DS . 'Hearth' . DS . 'Core.php';

$core = new \Hearth\Core();

$core->main();
