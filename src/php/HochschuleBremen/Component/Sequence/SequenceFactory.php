<?php
/**
 * `SequenceFactory.php`
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

use FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * Constructs instances of biological sequences.
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
class SequenceFactory
{

    /**
     * This class implements the *Singleton* creational design pattern.
     */
    use SingletonTrait;

    /**
     * Constructs and returns the sequence for the specified type of sequence.
     *
     * @param SequenceTypeEnum $type        The type of the sequence to create.
     * @param string           $sequenceStr The sequence string of the sequence
     *                                      to create.
     *
     * @return SequenceAbstract The sequence.
     * @throws InvalidArgumentException If the specified sequence type is not
     *                                  supported.
     */
    public function create(SequenceTypeEnum $type, $sequenceStr)
    {
        $className = $type->getName() . '\Sequence';

        if (false === \class_exists($className)) {
            throw new \InvalidArgumentException(
                "The sequence of type {$type} is not supported."
            );
        }

        /* @var $result SequenceAbstract */
        $result = new $className($sequenceStr);

        return $result;
    }

}
