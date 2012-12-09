<?php
/**
 * Chmod.php
 *
 * Description of Chmod.php
 * 
 * @category Hearth
 * @package Tasks
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Tasks;

use Hearth\Task;

/**
 * Chmod
 *
 * Description of Chmod
 *
 * @category Hearth
 * @package Tasks
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Chmod implements Task
{
    /**
     * @var string The file to run the chmod command on
     */
    protected $_file;

    /**
     * @var int The permissions to set to the file
     */
    protected $_permissions;

    /**
     * main
     * 
     * Description of main
     * 
     * @access public
     * @return void
     */
    public function main()
    {

        return;
    }

    /**
     * setFile
     *
     * Set the file to run the chmod command on
     *
     * @access public
     * @param string $file
     * @return \Hearth\Tasks\Chmod
     * @throws \InvalidArgumentException
     */
    public function setFile($file)
    {
        if (!is_string($file)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($file) . '. Expected a string'
            );
        }

        $this->_file = $file;

        return $this;
    }

    /**
     * getFile
     *
     * Get the file to run the chmod command on
     *
     * @access public
     * @return string
     * @throws \Exception
     */
    public function getFile()
    {
        if (!isset($this->_file)) {
            throw new \Exception(
                'No File was set to chmod'
            );
        }

        return $this->_file;
    }

    /**
     * setPermissions
     *
     * Sets the permissions to be set to the file
     *
     * @access public
     * @param int $permissions
     * @return \Hearth\Tasks\Chmod
     */
    public function setPermissions($permissions)
    {
        if (!is_int($permissions)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($permissions) . '. Expected an int'
            );
        }

        $this->_permissions = $permissions;

        return $this;
    }

    /**
     * getPermissions
     *
     * Gets the permissions to be set to the file
     *
     * @access public
     * @return int
     * @throws Exception
     */
    public function getPermissions()
    {
        if (!isset($this->_permissions)) {
            throw new Exception(
                'No Permsissions were set to chmod'
            );
        }

        return $this->_permissions;
    }

}
