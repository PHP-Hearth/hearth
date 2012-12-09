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

function hearthAutoloader($class)
{
	$file = str_replace('\\', '/', $class).'.php';

	if (file_exists($file)) {
		require_once $file;
	}	
}

spl_autoload_register('hearthAutoloader');

require dirname(__FILE__) . HEARTH_DS . 'Hearth' . HEARTH_DS . 'Core.php';

$core = new \Hearth\Core();

$core->main();
