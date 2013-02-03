<?php
/**
 * Chmod.php
 *
 * @category Hearth
 * @package Library
 * @author Douglas Linsmeyer <douglinsmeyer@gmail.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Library;

use Hearth\Exception\FileNotFound as FileNotFoundException;
use Hearth\Exception\BuildException as BuildException;
use Hearth\Task;

/**
 * Chmod
 *
 * A general purpose task for performing
 * unix chmod operations.
 *
 * @category Hearth
 * @package Library
 * @author Douglas Linsmeyer <douglinsmeyer@gmail.com>
 */
class Chmod implements Task
{
    /**
     * Define message to display if
     * target is executed with incomplete
     * parameters.
     */
    const ERROR_INVALID_PARAMETERS = 'Unable to execute Chmod operation, parameters are missing.';

    /**
     * Define message to display if
     * the PHP "chmod" function itself
     * fails.
     */
    const ERROR_CHMOD_OPERATION = 'Chmod operation has failed on: ';

    /**
     * File
     *
     * @var string
     */
    private $file = null;

    /**
     * File Permissions
     *
     * @var integer
     */
    private $filePermissions = null;

    /**
     * Folder permissions
     *
     * @var integer
     */
    private $folderPermissions = null;

    /**
     * Recursive operation indicator
     *
     * @var boolean
     */
    private $recursive = false;

    /**
     * Count of files affected
     *
     * @var integer
     */
    private $fileCount = 0;

    /**
     * Count of folders afected
     *
     * @var integer
     */
    private $folderCount = 0;

    /**
     * Initialization
     *
     * Provides wrapper utility for optional
     * parameters given.
     *
     * @param string $file
     * @param string|integer $permissions
     * @param boolean $recursion
     * @return void
     */
    public function __construct(
        $file = null,
        $permissions = null,
        $recursion = null
    ) {
        if (!is_null($file)) {
            $this->setFile($file);
        }

        if (!is_null($permissions)) {
            $this->setFilePermissions($permissions);
        }

        if (!is_null($recursion)) {
            $this->setRecursive($recursion);
        }
    }

    /**
     * Primary target procedure
     *
     * @access public
     * @throws \Hearth\Exception\BuildException
     * @return void
     */
    public function main()
    {
        if (!$this->validate()) {
            throw new BuildException(self::ERROR_INVALID_PARAMETERS);
        }
        if ($this->getRecursive()) {
            $this->executeRecursive(
                $this->getFile(),
                $this->getFilePermissions(),
                $this->getFolderPermissions()
            );
        }
        else {
            $this->executeSingle(
                $this->getFile(),
                $this->getFilePermissions()
            );
        }

        return (object) array(
            'folders' => $this->folderCount,
            'files'   => $this->fileCount,
        );
    }

    /**
     * Perform actual chmod operation
     *
     * @access protected
     * @param string $file Filename, path/to/some/file.php
     * @throws \Hearth\Exception\BuildException
     * @return boolean
     */
    protected function execute($file, $permissions)
    {
        if (!chmod($file, $permissions)) {
            throw new BuildException(self::ERROR_CHMOD_OPERATION . $file);
        }

        return;
    }

    public function executeSingle($file, $permissions)
    {
        if (is_dir($file)) {
            $this->folderCount++;
        }
        else {
            $this->fileCount++;
        }

        return $this->execute($file, $permissions);
    }

    /**
     * Perform a recursive chmod operation
     *
     * Operation will include the origin path specified.
     *
     * @param  string $file
     * @return void
     */
    public function executeRecursive(
        $file,
        $filePermissions,
        $folderPermissions
    ) {
        $results = array();

        if (is_dir($file)) {
            // Remove "." and ".."
            $subItems = array_slice(scandir($file), 2);

            foreach ($subItems as $item) {
                $this->executeRecursive(
                    $file.DIRECTORY_SEPARATOR.$item,
                    $filePermissions,
                    $folderPermissions
                );
            }

            $results[] = $this->execute($file, $folderPermissions);
            $this->folderCount++;
        }
        else {
            $results[] = $this->execute($file, $filePermissions);
            $this->fileCount++;
        }
    }

    /**
     * Validate that all parameters are set
     *
     * @access public
     * @return boolean
     */
    public function validate()
    {
        if (is_null($this->file)) {
            return false;
        }
        if (is_null($this->filePermissions)) {
            return false;
        }
        if (is_null($this->recursive)) {
            return false;
        }

        return true;
    }

    /**
     * Set both file and folder permissions
     *
     * Functions essentially as a wrapper for
     * setFIlePermissions() and setFolderPermissions()
     * methods
     *
     * @param integer|string $permission
     * @return \Hearth\Build\Target\Chmod
     */
    public function setPermissions($permission)
    {
        $this->setFilePermissions($permission);
        $this->setFolderPermissions($permission);
        return $this;
    }

    /**
     * Set the desired permissions
     *
     * The $permissions parameter will accept either a numeric code
     * eg: 755 or a string code "go-rwx"
     *
     * @access public
     * @param string|integer $permissions
     * @return \Hearth\Target\Chmod
     */
    public function setFilePermissions($permissions)
    {
        $this->filePermissions = $permissions;
        return $this;
    }

    /**
     * Retrieve the permissions to be assigned
     *
     * @access public
     * @return string|integer
     */
    public function getFilePermissions()
    {
        if (is_null($this->filePermissions) && !is_null($this->folderPermissions)) {
            $this->filePermissions = $this->getFolderPermissions();
        }
        return $this->filePermissions;
    }

    /**
     * Set the desired folder permissions
     *
     * The $permissions parameter will accept either a numeric code
     * eg: 755 or a string code "go-rwx"
     *
     * @access public
     * @param string|integer $permissions
     * @return \Hearth\Target\Chmod
     */
    public function setFolderPermissions($permissions)
    {
        $this->folderPermissions = $permissions;
        return $this;
    }

    /**
     * Retrieve the folder permissions to be assigned
     *
     * @access public
     * @return string|integer
     */
    public function getFolderPermissions()
    {
        if (
            is_null($this->folderPermissions)
            && !is_null($this->filePermissions)
        ) {
            $this->folderPermissions = $this->getFilePermissions();
        }
        return $this->folderPermissions;
    }

    /**
     * Set the filename upon which to perform chmod operation
     *
     * @access public
     * @param string $file /path/to/file.php
     * @return \Hearth\Target\Chmod
     */
    public function setFile($file)
    {
        if (!file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        $this->file = $file;
        return $this;
    }

    /**
     * Retrieve the file name upon which chmod operations are to be
     * performed.
     *
     * @access public
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the recursion indicator
     *
     * @access public
     * @param boolean $isRecursive
     * @return \Hearth\Target\Chmod
     */
    public function setRecursive($isRecursive)
    {
        $this->recursive = ($isRecursive) ? true : false;
        return $this;
    }

    /**
     * Retrieve the recursion indicator
     *
     * Default false
     *
     * @access public
     * @return boolean
     */
    public function getRecursive()
    {
        return $this->recursive;
    }
}
