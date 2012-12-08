<?php
/**
 * Chmod.php
 *
 * Description of Chmod.php
 * 
 * @category Hearth
 * @package Targets
 * @package Expression package is undefined on line 8, column 15 in Templates/Scripting/PHPClass.php.
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */

namespace Hearth\Tasks;

/**
 * Chmod
 *
 * Description of Chmod
 *
 * @category Hearth
 * @package Targets
 * @package Expression package is undefined on line 18, column 15 in Templates/Scripting/PHPClass.php.
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 * @version $Id$
 */
class Chmod
{
    /**
     * @var string The file to run the chmod command on
     */
    protected $_file;

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

}
