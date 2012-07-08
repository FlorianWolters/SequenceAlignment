<?php
/**
 * `SmithWatermanEntity.php`
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
 * PHP version 5.3
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Entity
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * An object of type {@link SmithWatermanEntity} represents and stores the data
 * to run the {@link SmithWaterman} algorithm.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Entity
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      Class available since Release 0.1.0
 */
class SmithWatermanEntity
{

    /**
     * The first sequence.
     *
     * @var string
     */
    private $firstSequence;

    /**
     * The second sequence.
     *
     * @var string
     */
    private $secondSequence;

    /**
     * Adds the constraints for this class.
     *
     * @param ClassMetadata $metadata The constraints on this class.
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        self::addGetterConstraintsToElement($metadata, 'firstSequence');
        self::addGetterConstraintsToElement($metadata, 'secondSequence');
    }

    /**
     * @param ClassMetadata $metadata The constraints on this class.
     * @param string $name
     *
     * @return void
     */
    private static function addGetterConstraintsToElement(
        ClassMetadata $metadata, $name
    ) {
        $metadata->addGetterConstraint($name, new NotBlank);
        $metadata->addGetterConstraint($name, new Type('string'));
    }

    /**
     * Constructs a new {@link SmithWatermanEntity} with the specified first
     * sequence and the specified second sequence.
     *
     * @param string $firstSequence  The first sequence.
     * @param string $secondSequence The second sequence.
     * @todo  This constructor can be removed before release.
     */
    public function __construct($firstSequence = null, $secondSequence = null)
    {
        $this->setFirstSequence($firstSequence);
        $this->setSecondSequence($secondSequence);
    }

    /**
     * Returns the first sequence of this {@link SmithWatermanEntity}.
     *
     * @return The first sequence.
     */
    public function getFirstSequence()
    {
        return $this->firstSequence;
    }

    /**
     * Sets the first sequence of this {@link SmithWatermanEntity}.
     *
     * @param string $firstSequence The new first sequence.
     *
     * @return void
     */
    public function setFirstSequence($firstSequence)
    {
        $this->firstSequence = $firstSequence;
    }

    /**
     * Returns the second sequence of this {@link SmithWatermanEntity}.
     *
     * @return The second sequence.
     */
    public function getSecondSequence()
    {
        return $this->secondSequence;
    }

    /**
     * Sets the second sequence of this {@link SmithWatermanEntity}.
     *
     * @param string $secondSequence The new second sequence.
     *
     * @return void
     */
    public function setSecondSequence($secondSequence)
    {
        $this->secondSequence = $secondSequence;
    }

}