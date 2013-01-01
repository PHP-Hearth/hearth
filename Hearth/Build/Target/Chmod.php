<?php
/**
 * Chmod.php
 *
 * @category Hearth
 * @package Targets
 * @author Douglas Linsmeyer <douglinsmeyer@gmail.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Build\Target;

use Hearth\Target;
use Hearth\Exception\FileNotFound as FileNotFoundException;

/**
 * Chmod
 *
 * A general purpose task for performing
 * unix chmod operations.
 *
 * @category Hearth
 * @package Targets
 * @author Douglas Linsmeyer <douglinsmeyer@gmail.com>
 */
class Chmod Extends Target
{
    /**
     * File
     *
     * @var string
     */
    $_file = null;

    /**
     * Permissions
     *
     * @var integer
     */
    $_permissions = null;

    /**
     *
     * @var boolean
     */
    $_recursive = false;

    /**
     * Primary target procedure
     *
     * @access public
     * @return void
     */
    public function main()
    {

    }

    public function setPermissions($permissions)
    {

    }

    public function setFile($file)
    {
        if (!file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        $this->_file = $file;

        return $this;
    }

    public function setRecursive($isRecursive)
    {
        $this->_recursive = ($isRecursive) ? true : false;

        return $this;
    }

    public function getRecursive()
    {
        return $this->_recursive;
    }

    public function getFile()
    {
        return $this->_file;
    }
}
