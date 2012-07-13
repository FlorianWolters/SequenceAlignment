<?php
/**
 * `Alignment.php`
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

namespace HochschuleBremen\Application\SequenceAlignment\Entity;

use HochschuleBremen\Component\Alignment\GapPenalty\GapPenaltyInterface;
use HochschuleBremen\Component\Sequence\SequenceInterface;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * An object of class Alignment represents and stores the data for a pairwise
 * sequence alignment.
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
class Alignment
{

    /**
     * The first sequence of the pair to align.
     *
     * @var SequenceInterface
     */
    private $query;

    /**
     * The second sequence of the pair to align.
     *
     * @var SequenceInterface
     */
    private $target;

	/**
	 * The gap penalties used during alignment.
     *
     * @var GapPenaltyInterface
	 */
    private $gapPenalty;

	/**
     * The name of the substitution matrix to use during alignment.
     *
     * @var string
	 */
    private $substitutionMatrixName;

    /**
     * Adds the constraints for this class.
     *
     * @param ClassMetadata $metadata The constraints on this class.
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        self::addGetterConstraintsForSequence($metadata, 'query');
        self::addGetterConstraintsForSequence($metadata, 'target');
        $metadata->addGetterConstraint('gapPenalty', new NotNull);
        $metadata->addGetterConstraint(
            'gapPenalty',
            new Type(
                'HochschuleBremen\Component\Alignment\GapPenalty\GapPenaltyInterface'
            )
        );
    }

    private static function addGetterConstraintsForSequence(
        ClassMetadata $metadata, $name
    ) {
        $metadata->addGetterConstraint($name, new NotNull);
        $metadata->addGetterConstraint($name, new MaxLength(2048));
        $metadata->addGetterConstraint(
            $name,
            new Type('HochschuleBremen\Component\Sequence\SequenceInterface')
        );
    }

    /**
     * Returns the query sequence.
     *
     * @return SequenceInterface The first sequence of the pair to align.
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Sets the query sequence.
     *
     * @param SequenceInterface $query The first sequence of the pair to align.
     *
     * @return void
     */
    public function setQuery(SequenceInterface $query)
    {
        $this->query = $query;
    }

    /**
     * Returns the target sequence.
     *
     * @return SequenceInterface The second sequence of the pair to align.
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the target sequence.
     *
     * @param SequenceInterface $target The second sequence of the pair to align.
     *
     * @return void
     */
    public function setTarget(SequenceInterface $target)
    {
        $this->target = $target;
    }

    /**
     * Returns the gap penalties.
     *
     * @return GapPenaltyInterface The gap penalties used during alignment.
     */
    public function getGapPenalty()
    {
        return $this->gapPenalty;
    }

    /**
     * Sets the gap penalties.
     *
     * @param GapPenaltyInterface $gapPenalty The gap penalties used during
     *                                        alignment.
     */
    public function setGapPenalty(GapPenaltyInterface $gapPenalty)
    {
        $this->gapPenalty = $gapPenalty;
    }

    /**
	 * Returns the name of the substitution matrix.
     *
     * @return string The name of the substitution matrix to use during
     *                alignment.
	 */
    public function getSubstitutionMatrixName()
    {
        return $this->substitutionMatrixName;
    }

    /**
	 * Sets the name of the substitution matrix.
     *
     * @param string $substitutionMatrixSelection The name of the substitution
     *                                            matrix to use during
     *                                            alignment.
     *
     * @return void
	 */
    public function setSubstitutionMatrixName($substitutionMatrixSelection)
    {
        $this->substitutionMatrixName = $substitutionMatrixSelection;
    }

}
