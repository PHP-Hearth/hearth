<?php
/**
 * Copy.php
 *
 * @category Hearth
 * @package Library
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
 *          Attribution-NonCommercial-ShareAlike 3.0 Unported
 *          Some Rights Reserved
 */

namespace Hearth\Library;

use Hearth\Task;

/**
 * Copy
 *
 * @category Hearth
 * @package Library
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Copy extends Task
{
    /**
     * @var string The path to copy from
     */
    private $copyFrom;
    
    /**
     * @var string The path to copy to
     */
    private $copyTo;
    
    /**
     * @var array an associate array of key/value pairs to search and replace
     *            within the file
     */
    private $replace = array();

    /**
     * Constructor
     *
     * Constructs a new copy action and executes it.
     *
     * @param string $copyFrom The path to copy from
     * @param string $copyTo The path to copy to
     * @param array $replace an associate array of key/value pairs to search and
     *                       replace within the file
     */
    public function __construct($copyFrom, $copyTo, $replace = array())
    {
        $this->setCopyFrom($copyFrom)
             ->setCopyTo($copyTo)
             ->setReplace($replace);
    }

    /**
     * Execute the task
     *
     * @return \Hearth\Copy
     */
    public function main()
    {
        echo '[copy] Copying file ' . $this->getCopyFrom()
            . ' to ' . $this->getCopyTo() . PHP_EOL;
        
        $fileContents = file_get_contents($this->getCopyFrom());

        foreach ($this->getReplace() as $replacementKey => $replacementValue) {
            $fileContents = str_replace(
                $replacementKey,
                $replacementValue,
                $fileContents
            );
        }

        file_put_contents($this->getCopyTo(), $fileContents);

        return $this;
    }

    /**
     * Get Copy From
     *
     * @return string
     */
    public function getCopyFrom()
    {
        return $this->copyFrom;
    }

    /**
     * Set Copy From
     *
     * @param string $copyFrom
     * @return \Hearth\Copy
     * @throws \InvalidArgumentException
     */
    public function setCopyFrom($copyFrom)
    {
        if (!is_string($copyFrom)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($copyFrom) . '. Expected a string.'
            );
        }

        $this->copyFrom = $copyFrom;

        return $this;
    }

    /**
     * Get Copy to
     *
     * @return string
     */
    public function getCopyTo()
    {
        return $this->copyTo;
    }

    /**
     * Set Copy To
     *
     * @param string $copyTo
     * @return \Hearth\Copy
     * @throws \InvalidArgumentException
     */
    public function setCopyTo($copyTo)
    {
        if (!is_string($copyTo)) {
            throw new \InvalidArgumentException(
                'Unexpected ' . gettype($copyTo) . '. Expected a string.'
            );
        }

        $this->copyTo = $copyTo;

        return $this;
    }

    /**
     * Get Replace
     *
     * @return array
     */
    public function getReplace()
    {
        return $this->replace;
    }

    /**
     * Set Replace
     *
     * @param array $replace
     * @return \Hearth\Copy
     */
    public function setReplace(array $replace)
    {
        $this->replace = $replace;

        return $this;
    }
}
