<?php
/**
 * Format.php
 *
 * Description of Format.php
 *
 * @category Hearth
 * @package Ansi
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 0.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Ansi;

/**
 * Format
 *
 * Description of Format
 *
 * @category Hearth
 * @package Ansi
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Format
{
    /**
     * @var string The escape sequence to start fomatting
     */
    protected $_escape = '\033[';

    /**
     * @var string The separator for the formatting parameters
     */
    protected $_separator = ';';

    /**
     * @var the end of the escape formatting sequence
     */
    protected $_postfix = 'm';

    /**
     * @var array A map of attribute names to output values
     */
    public $attributes = array(
        'clear'      => 0,
        'bold'       => 1,
        'underscore' => 4,
        'blink'      => 5,
        'reverse'    => 7,
        'concealed'  => 8,
    );

    /**
     * @var array A map of foreground colors to their output values
     */
    public $foregrounds = array(
        'black'   => 30,
        'red'     => 31,
        'green'   => 32,
        'yellow'  => 33,
        'blue'    => 34,
        'magenta' => 35,
        'cyan'    => 36,
        'white'   => 37,
    );

    /**
     * @var array A map of background colors to their output values
     */
    public $backgrounds = array(
        'black'   => 40,
        'red'     => 41,
        'green'   => 42,
        'yellow'  => 43,
        'blue'    => 44,
        'magenta' => 45,
        'cyan'    => 46,
        'white'   => 47,
    );

    /**
     * @var array The registry of formatting options to use
     */
    protected $_registry = array();

    /**
     * clear
     *
     * Clears out all formatting
     *
     * @access public
     * @return string
     */
    public function clear()
    {
        return $this->getEscape()
            . $this->attributes['clear']
            . $this->getPostfix();
    }

    /**
     * setAttribute
     *
     * Sets an attribute to the current format
     *
     * @access public
     * @param string $type The format type name
     * @return \Hearth\Ansi\Format
     * @throws \InvalidArgumentException
     */
    public function setAttribute($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($type) . '. Expected a string'
            );
        }

        if (!isset($this->attributes[$type])) {
            throw new \InvalidArgumentException(
                'Unexpected attribute: ' . $type . '. Not a valid attribute'
            );
        }

        array_push($this->_registry, $this->attributes[$type]);

        return $this;
    }

    /**
     * getSequence
     *
     * Gets the final sequence to output into a console
     *
     * @access public
     * @return string
     */
    public function getSequence()
    {
        $returnStr = $this->getEscape() 
            . implode($this->getSeparator(), $this->getRegistry())
            . $this->getPostfix();

        return $returnStr;
    }

    /**
     * setForeground
     *
     * Sets a forground color to the format
     *
     * @access public
     * @param string $type
     * @return \Hearth\Ansi\Format
     * @throws \InvalidArgumentException
     */
    public function setForeground($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($type) . '. Expected a string'
            );
        }

        if (!isset($this->foregrounds[$type])) {
            throw new \InvalidArgumentException(
                'Unexpected Foreground: ' . $type . '. Not a valid foreground color'
            );
        }

        array_push($this->_registry, $this->foregrounds[$type]);

        return $this;
    }

    /**
     * setBackground
     *
     * Sets a background color to the format
     *
     * @param string $type
     * @return \Hearth\Ansi\Format
     * @throws \InvalidArgumentException
     */
    public function setBackground($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($type) . '. Expected a string'
            );
        }

        if (!isset($this->backgrounds[$type])) {
            throw new \InvalidArgumentException(
                'Unexpected Background: ' . $type . '. Not a valid background color'
            );
        }

        array_push($this->_registry, $this->backgrounds[$type]);

        return $this;
    }

    /**
     * setEscape
     *
     * Sets the escape prefix for the sequence
     *
     * @param string $char
     * @return \Hearth\Ansi\Format
     * @throws \InvalidArgumentException
     */
    public function setEscape($char)
    {
        if (!is_string($char)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($char) . '. Expected a string'
            );
        }

        $this->_escape = $char;

        return $this;
    }

    /**
     * getEscape
     *
     * Gets the escape prefix for the sequence
     *
     * @access public
     * @return string
     */
    public function getEscape()
    {
        return $this->_escape;
    }

    /**
     * setPostfix
     *
     * Sets the postfix for the sequence
     *
     * @param string $char
     * @return \Hearth\Ansi\Format
     * @throws \InvalidArgumentException
     */
    public function setPostfix($char)
    {
        if (!is_string($char)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($char) . '. Expected a string'
            );
        }

        $this->_postfix = $char;

        return $this;
    }

    /**
     * getPostfix
     *
     * Gets the postfix for the sequence
     *
     * @access public
     * @return string
     */
    public function getPostfix()
    {
        return $this->_postfix;
    }

    /**
     * getSeparator
     *
     * Gets the separator for each sequence parameter
     *
     * @access public
     * @return string
     */
    public function getSeparator()
    {
        return $this->_separator;
    }

    /**
     * setSeparator
     *
     * Sets the separator for each sequence parameter
     *
     * @param string $char
     * @return \Hearth\Ansi\Format
     * @throws \InvalidArgumentException
     */
    public function setSeparator($char)
    {
        if (!is_string($char)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($char) . '. Expected a string'
            );
        }

        $this->_separator = $char;

        return $this;
    }

    /**
     * getRegistry
     *
     * Gets the registry of formatting codes to apply in the sequence
     *
     * @access public
     * @return array
     */
    public function getRegistry()
    {
        return $this->_registry;
    }

    /**
     * __toString
     *
     * Converts The formatting class to it's sequence string
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->getSequence();
    }
}
