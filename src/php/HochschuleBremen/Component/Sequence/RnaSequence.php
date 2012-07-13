<?php
/**
 * `RnaSequence.php`
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
 * PHP version 5.
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
 * This class models a RNA sequence.
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
class RnaSequence extends SequenceAbstract
{

    /**
     * Validates the specified sequence string.
     *
     * @param string $sequenceStr The sequence string.
     */
    protected function validateSequenceString($sequenceStr)
    {
        return (boolean) \preg_match('/^[cgau]+$/i', $sequenceStr);
    }

    /**
     * Constructs a new DnaSequence object equivalent to this RnaSequence.
     *
     * @return DnaSequence The DnaSequence.
     */
    public function toRnaSequence()
    {
        $sequenceStr = \str_replace('u', 't', $this->__toString);
        return new RnaSequence($sequenceStr);
    }

}
