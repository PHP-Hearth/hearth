<?php
/**
 * MockSubTarget.php
 *
 * @category Hearth
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace TestNamespace\Targets;

/**
 * MockSubTarget
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @category Hearth
 */
class MockSubTarget extends \Hearth\Target
{
    public function main()
    {
        echo 'Rejoyce! And be glad!';
        return;
    }
}
