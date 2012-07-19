<?php
/**
 * `SequenceAbstract.php`
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see http://gnu.org/licenses/lgpl.txt.
 *
 * PHP version 5.4
 *
 * @category  Biology
 * @package   Sequence
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   GIT: $Id$
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     File available since Release 0.1.0
 */

namespace HochschuleBremen\Component\Sequence;

/**
 * The base class for DNA, RNA and Protein sequences.
 *
 * @category  Biology
 * @package   Sequence
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version   Release: @package_version@
 * @link      http://github.com/FlorianWolters/SequenceAlignment
 * @since     Class available since Release 0.1.0
 */
abstract class SequenceAbstract implements SequenceInterface
{

    /**
     * The sequence string of this sequence.
     *
     * @var string
     */
    protected $sequenceStr;

    /**
     * The length of this sequence.
     *
     * @var integer
     */
    private $length;

    /**
     * Constructs a new sequence from the specified string.
     *
     * @param string $sequenceStr The sequence string.
     *
     * @throws InvalidArgumentException If the specified string contains invalid
     *                                  characters.
     */
    public function __construct($sequenceStr)
    {
        $this->setSequenceStr($sequenceStr);

        if (false === $this->validateSequenceStr()) {
            throw new \InvalidArgumentException(
                'The sequence string contains invalid characters.'
            );
        }
    }

    /**
     * Validates the sequence string of this sequence.
     *
     * @return boolean `true` if the sequence string is valid; `false`
     *                 otherwise.
     */
    abstract protected function validateSequenceStr();

    /**
     * Sets the sequence string of this sequence.
     *
     * @param string $sequenceStr The sequence string.
     */
    protected function setSequenceStr($sequenceStr)
    {
        $this->sequenceStr = \strtoupper($sequenceStr);
        $this->updateLength();
    }

    /**
     * Updates the length of this sequence.
     *
     * @return void
     */
    private function updateLength()
    {
        $this->length = \strlen($this->sequenceStr);
    }

    /**
     * Returns the sequence string of this sequence.
     *
     * @return string The sequence string.
     */
    public function __toString()
    {
        return $this->sequenceStr;
    }

    /**
     * Returns the length of the sequence.
     *
     * {@inhritdoc}
     *
     * @return integer The length.
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Returns the sequence string of the sequence.
     *
     * {@inhritdoc}
     *
     * @return string The sequence string.
     */
    public function getSequenceStr()
    {
        return $this->sequenceStr;
    }

}
