<?php
/**
 * `ProteinSequence.php`
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
 * This class models a Protein sequence.
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
class ProteinSequence extends SequenceAbstract
{

    /**
     * Validates the specified sequence string.
     *
     * @param string $sequenceStr The sequence string.
     */
    protected function validateSequenceString($sequenceStr)
    {
        return (boolean) \preg_match(
            '/^[arndcqeghilkmfpstwyv]+$/i', $sequenceStr
        );
    }

    public function getAllowedCompounds()
    {
        return [
            'a', 'r', 'n', 'd', 'c', 'q', 'e', 'g', 'h', 'i',
            'l', 'k', 'm', 'f', 'p', 's', 't', 'w', 'y', 'v'
        ];
    }
}
